<?php

require_once dirname(__FILE__) . '/../includes/db_conn.php';
require_once dirname(__FILE__) . '/../includes/T3_reg_accounts_google.php';  
require_once dirname(dirname(__FILE__)) . '/vendor/examples/AdWords/v201601/init.php';
require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';
require_once dirname(__FILE__) . '/../vendor/autoload.php';

date_default_timezone_set('America/Chicago');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');



// FETCH DYNAMIC GOOGLE SHEET DATA FROM DATABASE



$sql = "SELECT * FROM id";

$g2col = $conn->query($sql);

while($row = mysqli_fetch_array($g2col))
    {

        $genIds= array();
        $genIds['sheet'] = $row['sheet'];
        $genIds['t2'] = $row['t2'];
        $genIds['t3'] = $row['t3'];                
        $genIdsList[] = $genIds;

    }

$worksheetTitle = $genIdsList[0]['sheet'];
$worksheetTab = $genIdsList[0]['t3'];



// SET OTHER GOOGLE SHEET API INFORMATION



$fileId = "";
$clientId = "";
$clientEmail = "";
$pathToP12File = "";



// GOOGLE SHEETS API REPORTING FUNCTIONS



function getGoogleTokenFromKeyFile($clientId, $clientEmail, $pathToP12File) {
    $client = new Google_Client();
    $client->setClientId($clientId);

    $cred = new Google_Auth_AssertionCredentials(
        $clientEmail,
        array('https://spreadsheets.google.com/feeds'),
        file_get_contents($pathToP12File)
    );

    $client->setAssertionCredentials($cred);

    if ($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($cred);
    }

    $service_token = json_decode($client->getAccessToken());
    return $service_token->access_token;
}



// LOAD GOOGLE SHEET API CLASSES



use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\CellEntry;
use Google\Spreadsheet\CellFeed;



// FETCH GOOGLE SHEET API DATA FROM GOOGLE SERVERS



$serviceRequest = new DefaultServiceRequest(getGoogleTokenFromKeyFile($clientId, $clientEmail, $pathToP12File));
ServiceRequestFactory::setInstance($serviceRequest);
$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
$spreadsheet = $spreadsheetFeed->getByTitle($worksheetTitle);
$worksheetFeed = $spreadsheet->getWorksheets();
$worksheet = $worksheetFeed->getByTitle($worksheetTab);
$cellFeed = $worksheet->getCellFeed();
$sheetArray = $cellFeed->toArray();



// FETCH USER COLUMN SELECTION DATA FROM DATABASE



$sql = "SELECT * FROM columns";

$g2col = $conn->query($sql);

while($row = mysqli_fetch_array($g2col))
    {

        $columns= array();
        $columns['tier'] = $row['tier'];
        $columns['c1'] = $row['c1'];
        $columns['c2'] = $row['c2'];
        $columns['c3'] = $row['c3'];                 
        $columnsList[] = $columns;

    }

$key = array_search('g3', array_column($columnsList, 'tier'));
$one = $columnsList[$key]['c1'];
$two = $columnsList[$key]['c2'];
$three = $columnsList[$key]['c3'];



// EMPTY DESTINATION FOLDERS OF OLD REPORTS



$files = glob(dirname(__FILE__) . '/../Reports/GoogleT3Pacing/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}



echo "<br/>ERASING OLD FIGURES FROM RANGE ON GOOGLE SHEET";



$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
for($y=2;$y<100;$y++) {
  $batchRequest->addEntry($cellFeed->createInsertionCell($y, $one, ""));
  $batchRequest->addEntry($cellFeed->createInsertionCell($y, $two, ""));
  $batchRequest->addEntry($cellFeed->createInsertionCell($y, $three, ""));
}
$batchResponse = $cellFeed->insertBatch($batchRequest);



echo "<br/>INSERTING TIME STAMP ON LAST ROW OF GOOGLE SHEET FOR CURRENTLY EXECUTING SCRIPT";



end($sheetArray);
$dateRow = key($sheetArray);

if(isset($sheetArray[$dateRow][1])) {
  $dateRow = (int)$dateRow + 2;
}

$lowRange = date('Y-m-') . "01";
        
if (date('d') == 01) {
  $highRange = date('Ym') . sprintf('%02d', date('d'));
}
elseif (date('d') <= 10) {
  $zeroLead = sprintf('%02d', (date('d') - 01));
  $highRange = date('Y-m-') . $zeroLead;
}
else {
  $highRange = date('Y-m-') . (date('d') - 01);
}

$now = date("F j, Y, g:i a");

$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
$batchRequest->addEntry($cellFeed->createInsertionCell($dateRow, $one, "Date Range: $lowRange - $highRange (figures pulled on $now)"));
$batchResponse = $cellFeed->insertBatch($batchRequest);



echo "<br/>CHECKING THAT THERE ARE NO ACCOUNTS IN DATABASE THAT CANNOT BE FOUND IN GOOGLE SHEET DESTINATION";



$sheetArray = array_values($sheetArray);
$accounts = json_decode($regJSON);

$columnArray = [];
for($testingSheetRow=0; $testingSheetRow < count($sheetArray); $testingSheetRow++) {
    if($sheetArray[$testingSheetRow][1]){
        $columnArray[] = $sheetArray[$testingSheetRow][1];
    }
}

$columnAccountsArray = [];
for($testingSheetRow=0; $testingSheetRow < count($accounts); $testingSheetRow++) {
    $columnAccountsArray[] = $accounts[$testingSheetRow]->name;
}

$columnArray = array_values(array_filter($columnArray));
$columnAccountsArray = array_values(array_filter($columnAccountsArray));

$foundMarker = 0;
for($accountTestRow=0; $accountTestRow < count($columnAccountsArray); $accountTestRow++) {

    $foundMarker = 0;
    $accountTestName = $columnAccountsArray[$accountTestRow];

    for($columnTestRow=0; $columnTestRow < count($columnArray); $columnTestRow++) {

        $columnTestName = $columnArray[$columnTestRow];
        if (stripos($columnTestName, trim($accountTestName)) !== false) {
            $foundMarker = 1;
        }
    }
    if ($foundMarker == 0) {
        echo "<br/><h1>$accountTestName Not Found in Google Sheet</h1>";
        echo "<script type=\"text/javascript\">window.location.href = \"\";</script>";
        exit;
    }
}



// CAMPAIGN PERFORMANCE REPORT FUNCTION



    function runCampaignReport(AdWordsUser $user, $filePath, $accountNumber, $name) {
      // Load the service, so that the required classes are available.
      $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
      // Optional: Set clientCustomerId to get reports of your child accounts
      $user->SetClientCustomerId($accountNumber);
       

      // Create selector.
      $selector = new Selector();
      $selector->fields = array('CampaignName', 'Clicks', 'Cost', 'AdvertisingChannelType');


      // Create report definition.
      $reportDefinition = new ReportDefinition();
      $reportDefinition->selector = $selector;
      $reportDefinition->reportName = 'Campaign Performance Report #' . time();


// SET DATE RANGE FROM 1ST OF THIS MONTH TO YESTERDAY


      $lowRange = date('Ym') . "01";
    
    if (date('d') == 01) {
      $highRange = date('Ym') . sprintf('%02d', date('d'));
    }
    elseif (date('d') <= 10) {
      $zeroLead = sprintf('%02d', (date('d') - 01));
      $highRange = date('Ym') . $zeroLead;
    }
    else {
      $highRange = date('Ym') . (date('d') - 01);
    }

      $selector->dateRange = new DateRange($lowRange, $highRange);

      $reportDefinition->dateRangeType = 'CUSTOM_DATE';
      $reportDefinition->reportType = 'CAMPAIGN_PERFORMANCE_REPORT';
      $reportDefinition->downloadFormat = 'CSV';


      // Set additional options.
      $options = array('version' => ADWORDS_VERSION);

      // Download report.
      ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);
      printf("Report with name '%s' was downloaded to '%s'.\n",
          $reportDefinition->reportName, $filePath);
      echo "<br/>";
    }



// ACCOUNT PERFORMANCE REPORT FUNCTION



    function runAccountReport(AdWordsUser $user, $filePath, $accountNumber, $name) {
      // Load the service, so that the required classes are available.
      $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
      // Optional: Set clientCustomerId to get reports of your child accounts
      $user->SetClientCustomerId($accountNumber);
       

      // Create selector.
      $selector = new Selector();
      $selector->fields = array('Clicks', 'Cost', 'AccountDescriptiveName');


      // Create report definition.
      $reportDefinition = new ReportDefinition();
      $reportDefinition->selector = $selector;
      $reportDefinition->reportName = 'Account Performance Report #' . time();


// SET DATE RANGE FROM 1ST OF THIS MONTH TO YESTERDAY


      $lowRange = date('Ym') . "01";
    
    if (date('d') == 01) {
      $highRange = date('Ym') . sprintf('%02d', date('d'));
    }
    elseif (date('d') <= 10) {
      $zeroLead = sprintf('%02d', (date('d') - 01));
      $highRange = date('Ym') . $zeroLead;
    }
    else {
      $highRange = date('Ym') . (date('d') - 01);
    }

      $selector->dateRange = new DateRange($lowRange, $highRange);

      $reportDefinition->dateRangeType = 'CUSTOM_DATE';
      $reportDefinition->reportType = 'ACCOUNT_PERFORMANCE_REPORT';
      $reportDefinition->downloadFormat = 'CSV';


      // Set additional options.
      $options = array('version' => ADWORDS_VERSION);

      // Download report.
      ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);
      printf("Report with name '%s' was downloaded to '%s'.\n",
          $reportDefinition->reportName, $filePath);
      echo "<br/>";
    }



echo "<br/>ITERATING OVER REGULAR ACCOUNT LIST AND DOWNLOADING REPORTS";



$accounts = json_decode($regJSON);
$myCount = count($accounts);

for ($row = 0; $row < $myCount; $row++) {

    // SET SPECIFIC ACCOUNT DETAILS

    $accountNumber = (string)$accounts[$row]->code;
    $name = (string)$accounts[$row]->name;
    $sheetFilter = (string)$accounts[$row]->filter;

    try {
      // Get AdWordsUser from credentials in "../auth.ini"
      // relative to the AdWordsUser.php file's directory.
      $user = new AdWordsUser();

      // Log every SOAP XML request and response.
      $user->LogAll();

      // Download the report to a file in the same directory as the example.
      $filePath = dirname(__FILE__) . '/../Reports/GoogleT3Pacing/' . $name . $sheetFilter . '.csv';


      // Run the example.
      runCampaignReport($user, $filePath, $accountNumber, $name);
    } catch (Exception $e) {
      printf("An error has occurred: %s\n", $e->getMessage());
    }


// GO TO SLEEP FOR A MOMENT TO PREVENT OVERWHELMING WITH REQUESTS (CAMPAIGN REPORT)
    
     
    $lastPath = dirname(__FILE__) . "/../Reports/GoogleT3Pacing/" . $name . $sheetFilter . ".csv";
    while (!file_exists($lastPath)) {
      sleep(1);
      }

    try {
      // Get AdWordsUser from credentials in "../auth.ini"
      // relative to the AdWordsUser.php file's directory.
      $user = new AdWordsUser();

      // Log every SOAP XML request and response.
      $user->LogAll();

      // Download the report to a file in the same directory as the example.
      $filePath = dirname(__FILE__) . '/../Reports/GoogleT3Pacing/' . $name . $sheetFilter . 'Test.csv';


      // Run the example.
      runAccountReport($user, $filePath, $accountNumber, $name);
    } catch (Exception $e) {
      printf("An error has occurred: %s\n", $e->getMessage());
    }


// GO TO SLEEP FOR A MOMENT TO PREVENT OVERWHELMING WITH REQUESTS (ACCOUNT REPORT)


    $lastPath = dirname(__FILE__) . "/../Reports/GoogleT3Pacing/" . $name . $sheetFilter . "Test.csv";
    while (!file_exists($lastPath)) {
      sleep(1);
    }

}


// GREEN LIGHT FOR DATA EXTRACTION


$lastItem = "GREEN LIGHT";

?>