<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../includes/db_conn.php';
require_once dirname(__FILE__) . '/../includes/T2_lux_accounts_yahoo.php'; 
require_once dirname(__FILE__) . '/../includes/T2_reg_accounts_yahoo.php';

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
$worksheetTab = $genIdsList[0]['t2'];



// SET OTHER GOOGLE SHEET API INFORMATION



$fileId = "";
$clientId = "";
$clientEmail = "";
$pathToP12File = "";



// GOOGLE SHEETS API OAUTH FUNCTION



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
        $columns['c4'] = $row['c4'];                  
        $columnsList[] = $columns;

    }

$key = array_search('y2', array_column($columnsList, 'tier'));
$one = $columnsList[$key]['c1'];
$two = $columnsList[$key]['c2'];
$three = $columnsList[$key]['c3'];
$four = $columnsList[$key]['c4'];



// EMPTY DESTINATION FOLDERS OF OLD REPORTS



$files = glob(dirname(__FILE__) . '/../Reports/YahooT2Pacing/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}



// LOAD YAHOO GEMINI OAUTH2 INFORMATION



require "YahooOAuth2.class.php"; 

#Your Yahoo API consumer key & secret with access to Gemini data 
define("CONSUMER_KEY","");
define("CONSUMER_SECRET","");
$redirect_uri="http://".$_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];//Or your other redirect URL - must match the callback domain 



echo "<br/>ERASING OLD FIGURES FROM RANGE ON GOOGLE SHEET";



$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
for($y=2;$y<100;$y++) {
  $batchRequest->addEntry($cellFeed->createInsertionCell($y, $one, ""));
  $batchRequest->addEntry($cellFeed->createInsertionCell($y, $two, ""));
  $batchRequest->addEntry($cellFeed->createInsertionCell($y, $three, ""));
  $batchRequest->addEntry($cellFeed->createInsertionCell($y, $four, ""));
}
$batchResponse = $cellFeed->insertBatch($batchRequest);



echo "<br/>INSERTING TIME STAMP ON LAST ROW OF GOOGLE SHEET FOR CURRENTLY EXECUTING SCRIPT";



$sheetArray = $cellFeed->toArray();
end($sheetArray);
$dateRow = key($sheetArray);

if(isset($sheetArray[$dateRow][1])) {
  $dateRow = (int)$dateRow + 2;
}

$lowRange = date('Y-m-') . "01";
$highRange = date('Y-m-d');
$now = date("F j, Y, g:i a");


$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
$batchRequest->addEntry($cellFeed->createInsertionCell($dateRow, $one, "Date Range: $lowRange - $highRange (figures pulled on $now)"));
$batchResponse = $cellFeed->insertBatch($batchRequest);



echo "<br/>FETCHING ACCOUNT LIST FROM DATABASE";



$accounts = json_decode($regJSON);
$luxAccounts = json_decode($luxJSON);






$sheetArray = array_values($sheetArray);


echo "<br/>CHECKING THAT THERE ARE NO ACCOUNTS IN DATABASE THAT CANNOT BE FOUND IN GOOGLE SHEET DESTINATION";


$columnArray = [];
for($testingSheetRow=0; $testingSheetRow < count($sheetArray); $testingSheetRow++) {
    if($sheetArray[$testingSheetRow][1]){
        $columnArray[] = $sheetArray[$testingSheetRow][1];
    }
}

$columnLuxAccountsArray = [];
for($testingSheetRow=0; $testingSheetRow < count($luxAccounts); $testingSheetRow++) {
    $columnLuxAccountsArray[] = $luxAccounts[$testingSheetRow]->name;
}

$columnAccountsArray = [];
for($testingSheetRow=0; $testingSheetRow < count($accounts); $testingSheetRow++) {
    $columnAccountsArray[] = $accounts[$testingSheetRow]->name;
}

$columnArray = array_values(array_filter($columnArray));
$columnAccountsArray = array_values(array_filter($columnAccountsArray));
$columnLuxAccountsArray = array_values(array_filter($columnLuxAccountsArray));

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

// THROW ERROR

    if ($foundMarker == 0) {
        echo "<br/><h1>$accountTestName Not Found in Google Sheet</h1>";
        echo "<script type=\"text/javascript\">window.location.href = \"\";</script>";
        exit;
    }
}

for($accountTestRow=0; $accountTestRow < count($columnLuxAccountsArray); $accountTestRow++) {

    $foundMarker = 0;
    $accountTestName = $columnLuxAccountsArray[$accountTestRow];

    for($columnTestRow=0; $columnTestRow < count($columnArray); $columnTestRow++) {

        $columnTestName = $columnArray[$columnTestRow];

        if (stripos($columnTestName, trim($accountTestName)) !== false) {
            $foundMarker = 1;
        }
    }

// THROW ERROR

    if ($foundMarker == 0) {
        echo "<br/><h1>$accountTestName Not Found in Google Sheet</h1>";
        echo "<script type=\"text/javascript\">window.location.href = \"\";</script>";
        exit;
    }
}



// PREPPING INFO FOR GOOGLE SHEETS INSERTION



$sheetArray = $cellFeed->toArray();
$arrayKeys = (array_keys($sheetArray));
$myCount = count($accounts);



// BEGIN INITIAL REPORT REQUEST OUTSIDE OF LOOP



$gemini_api_endpoint="https://api.admanager.yahoo.com/v1/rest";
$oauth2client=new YahooOAuth2();

if (isset($_GET['code'])){
    $code=$_GET['code'];  
} 
else {
    $code=0;
}


// SET DATE RANGE FROM THE FIRST OF MONTH TO TODAY


$lowRange = date('Y-m-') . "01";
$highRange = date('Y-m-d');


// SET ACCOUNT SPECIFIC INFO


$accountNumber = (string)$accounts[0]->code;
$name = (string)$accounts[0]->name;
        

// JSON REQUEST TO SEND OVER HTTP CURL


$json = '{ "cube": "performance_stats",
"fields": [
   { "field": "Ad ID" },
   { "field": "Campaign ID" },
   { "field": "Ad Group ID" },
   { "field": "Month" },
   { "alias": "My dummy column", "value": "" },
   { "field": "Clicks" },
   { "field": "Average CPC" },
   { "field": "CTR" },
   { "field": "Spend" },
   { "field": "Impressions" },
   { "field": "Ad Landing URL", "alias": "url" }
 ],
"filters": [
   { "field": "Advertiser ID", "operator": "=", "value": "' . $accountNumber . '" },
   { "field": "Day", "operator": "between", "from": "' . $lowRange . '", "to": "' . $highRange . '" }
 ]
}';


// GO THROUGH YAHOO GEMINNI OAUTH2 PROCESS


if($code){
    #oAuth 3-legged authorization is successful, fetch access token  
    $tokens=$oauth2client->get_access_token(CONSUMER_KEY,CONSUMER_SECRET,$redirect_uri,$code);

    #Access token is available. Do API calls.   
    $headers= array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json');
    #Fetch Advertiser Name and Advertiser ID
    // $url=$gemini_api_endpoint."/campaign/347026014";
    $url=$gemini_api_endpoint."/reports/custom";
    $resp=$oauth2client->fetch($url,$postdata=$json,$auth="",$headers);
    $jsonResponse = json_decode( $resp );
    // $advertiserName = $jsonResponse->response[0]->advertiserName; 
    // $advertiserId = $jsonResponse->response[0]->id; 
    // echo "Welcome ".$advertiserName;
}
else {
    # no valid access token available, go to authorization server 
    header("HTTP/1.1 302 Found");
    header("Location: " . $oauth2client->getAuthorizationURL(CONSUMER_KEY,$redirect_uri));
    exit;
}


// PING YAHOO SERVER UNTIL REPORT IS PREPARED


$jobId = ($jsonResponse->response->jobId);

$jobStatus = "";

while ($jobStatus !== "completed") {

     // Get cURL resource
     $curl = curl_init();
     // Set some options - we are passing in a useragent too here
     curl_setopt_array($curl, array(
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/reports/custom/$jobId?advertiserId=$accountNumber",
         // CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/campaign/347026014",
         CURLOPT_USERAGENT => 'Codular Sample cURL Request',
         CURLOPT_HTTPHEADER => array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json'),
     ));
     // Send the request & save response to $resp
     $resp = curl_exec($curl);

     // Close request to clear up some resources
     curl_close($curl);

     // 'Authorization: Bearer '.$token,'Accept: application/json','Content-Type: application/json'
     $json2 = (json_decode($resp));
     $jobResponse = ($json2->response->jobResponse);

     $jobStatus = ($json2->response->status);

} 


echo "<br/>DOWNLOADING REPORT";


//Get the file
$content = file_get_contents("$jobResponse");

//Store in the filesystem.
$fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Pacing/$name.csv", "w");
fwrite($fp, $content);
fclose($fp);


// PHPEXCEL OPEN SPREADSHEET 


$objReader = new PHPExcel_Reader_CSV();
$objPHPExcel = $objReader->load("../Reports/YahooT2Pacing/$name.csv");
$objWorksheet = $objPHPExcel->getActiveSheet();
$performanceArray = $objWorksheet->toArray();


// MASSAGE KEYWORDS


$adjustedArray = array();

$x = 0;

for ($i = 1; $i < count($performanceArray); ++$i) {

    $campaignId = $performanceArray[$i][1];
    $landingUrl = $performanceArray[$i][10];
    $performanceClicks = $performanceArray[$i][5];
    $performanceImp = $performanceArray[$i][9];
    $performanceCtr = number_format((float)$performanceArray[$i][7] * 100, 2, '.', ',')  . '%';
    $performanceCpc = $performanceArray[$i][6];
    $performanceSpend = $performanceArray[$i][8];


    $landingUrl = array(str_replace("%2B", " ", substr(strrchr($landingUrl, "="), 1)));
    $landingUrl = str_replace("abilene ", "", $landingUrl);
    $landingUrl = str_replace("alexandria ", "", $landingUrl);
    $landingUrl = str_replace("amarillo ", "", $landingUrl);
    $landingUrl = str_replace("baton rouge ", "", $landingUrl);
    $landingUrl = str_replace("corpus ", "", $landingUrl);
    $landingUrl = str_replace("mcallen ", "", $landingUrl);
    $landingUrl = str_replace("mcallennissanrogue", "nissan rogue", $landingUrl);
    $landingUrl = str_replace("lafayette ", "", $landingUrl);
    $landingUrl = str_replace("lake charles ", "", $landingUrl);
    $landingUrl = str_replace("laredo ", "", $landingUrl);
    $landingUrl = str_replace("new orleans ", "", $landingUrl);
    $landingUrl = str_replace("lubbock ", "", $landingUrl);
    $landingUrl = str_replace("victoria ", "", $landingUrl);
    $landingUrl = str_replace("tyler ", "", $landingUrl);
    $landingUrl = str_replace("sherman ada ", "", $landingUrl);
    $landingUrl = str_replace("fourrunner", "four runner", $landingUrl);
    $landingUrl = str_replace("focusse", "focus se", $landingUrl);
    $landingUrl = str_replace("monroe ", "", $landingUrl);
    $landingUrl = str_replace("san angelo ", "", $landingUrl);
    $landingUrl = str_replace("wichita ", "", $landingUrl);
    $landingUrl = str_replace("fordfusion", "ford fusion", $landingUrl);
    $landingUrl = str_replace("hyundaielantra", "hyundai elantra", $landingUrl);
    $landingUrl = str_replace("hondacrv", "honda crv", $landingUrl);
    $landingUrl = str_replace("beaumont ", "beaumont", $landingUrl);
    $landingUrl = str_replace("grandcherokee", "grand cherokee", $landingUrl);
    $landingUrl = str_replace("batonrougefordfocus", "ford focus", $landingUrl);
    $landingUrl = str_replace("santafe", "santa fe", $landingUrl);
    $landingUrl = str_replace("genesiscoupe", "genesis coupe", $landingUrl);
    $landingUrl = str_replace("nissanrogue", "nissan rogue", $landingUrl);
    $landingUrl = str_replace("kiasportage", "kia sportage", $landingUrl);

    $adjustedArray[] = $landingUrl;


// SAVE FIGURES IN VARIABLE


    $adjustedArray[$x][1] = $performanceClicks;
    $adjustedArray[$x][2] = $performanceImp;
    $adjustedArray[$x][3] = $performanceCtr;
    $adjustedArray[$x][4] = $performanceCpc;
    $adjustedArray[$x][5] = $performanceSpend;
    $adjustedArray[$x][6] = $campaignId;

++$x;

}


// PHPEXCEL OPEN SECOND SPREADSHEET 


$objPHPExcel->disconnectWorksheets();
$objPHPExcel->createSheet();
$objWorksheet = $objPHPExcel->getActiveSheet();


// SEND TO ARRAY


$clicksArray = array();
$spendArray = array();
$howManyRows = count($adjustedArray);
$objWorksheet->fromArray($adjustedArray, NULL, 'A1');


// MASSAGE DATA


$objWorksheet->getStyle('E1:E' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
$objWorksheet->getStyle('F1:F' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
$objWorksheet->getStyle('B1:B' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');
$objWorksheet->getStyle('C1:C' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');

$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5


// ITERATE THROUGH SPREADSHEET ARRAY AND PULL CLICKS AND SPEND DATA


for ($row = 1; $row <= $highestRow; ++$row) {

    $clicks = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
    $spend = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();

    $clicksArray[] = $clicks;
    $spendArray[] = $spend;

}


// SAVE TOTAL SPEND AND CLICKS IN VAR

            
$regClicks = array_sum($clicksArray);
$regSpend = array_sum($spendArray);

$option = $accounts[0]->name;
$filter = $accounts[0]->filter;



// FIND GOOGLE SHEET ROW THAT MATCHES ACCOUNT NAME



$o = 0;
foreach($sheetArray as $item)
{
    foreach($item as $sub => $v)
    {
        if (($filter !== "") && (isset($item[1])) && ((stripos($item[1], trim($option)) !== false)) && (stripos($item[2], trim($filter)) !== false)) {

            $googleSheetRow = $arrayKeys[$o];

        }
        elseif (($filter == "") && (isset($item[1])) && (stripos($item[1], trim($option)) !== false)) {

            $googleSheetRow = $arrayKeys[$o];

        }
    }
  
$o++;

} 



// IF THERE ARE FORMULAS SELECTED BY USER, FIND LETTER VALUE

           

$letters = range('A', 'Z');
$formulaColClicks = $letters[$one-1];
$formulaColSpend = $letters[$two-1];



echo "<br/>INSERTING DATA INTO SPREADSHEET";



if ($filter !== "") {
  $rowBelow = $googleSheetRow + 1;
  $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
  $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$regClicks-$formulaColClicks$rowBelow"));
  $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "=$regSpend-$formulaColSpend$rowBelow"));
  $batchResponse = $cellFeed->insertBatch($batchRequest);
}
else {
  $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
  $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$regClicks"));
  $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$regSpend"));
  $batchResponse = $cellFeed->insertBatch($batchRequest);
}



// SET REFRESH TOKEN FOR YAHOO GEMINI OAUTH2



$refreshThis = $tokens['r'];


$gemini_api_endpoint="https://api.admanager.yahoo.com/v1/rest";
    $oauth2client=new YahooOAuth2();

    if (isset($_GET['code'])){
        $code=$_GET['code'];  
    } 
    else {
        $code=0;
    }



// JSON REQUEST TO SEND OVER HTTP CURL



$json = '{ "cube": "product_ads",
"fields": [
{
  "field": "Advertiser ID"
},
{
  "field": "Clicks"
},
{
  "field": "Spend"
}
],
"filters": [
   { "field": "Advertiser ID", "operator": "=", "value": "' . $accountNumber . '" },
   { "field": "Day", "operator": "between", "from": "' . $lowRange . '", "to": "' . $highRange . '" }
 ]
}';



// GO THROUGH YAHOO GEMINI OAUTH2 PROCESS



if($code){
    #oAuth 3-legged authorization is successful, fetch access token  
    $tokens=$oauth2client->get_new_access_token(CONSUMER_KEY,CONSUMER_SECRET,$redirect_uri,$refreshThis);

    #Access token is available. Do API calls.   
    $headers= array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json');
    #Fetch Advertiser Name and Advertiser ID
    // $url=$gemini_api_endpoint."/campaign/347026014";
    $url=$gemini_api_endpoint."/reports/custom";
    $resp=$oauth2client->fetch($url,$postdata=$json,$auth="",$headers);
    $jsonResponse = json_decode( $resp );
    // $advertiserName = $jsonResponse->response[0]->advertiserName; 
    // $advertiserId = $jsonResponse->response[0]->id; 
    // echo "Welcome ".$advertiserName;
}
else {
    # no valid access token available, go to authorization server 
    header("HTTP/1.1 302 Found");
    header("Location: " . $oauth2client->getAuthorizationURL(CONSUMER_KEY,$redirect_uri));
    exit;
}



// PING YAHOO SERVER UNTIL REPORT IS PREPARED



$jobId = ($jsonResponse->response->jobId);
$jobStatus = "";

while ($jobStatus !== "completed") {

    usleep(250000);
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/reports/custom/$jobId?advertiserId=$accountNumber",
    // CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/campaign/347026014",
    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
    CURLOPT_HTTPHEADER => array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json'),
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);

    // Close request to clear up some resources
    curl_close($curl);

    // 'Authorization: Bearer '.$token,'Accept: application/json','Content-Type: application/json'
    $json2 = (json_decode($resp));
    $jobResponse = ($json2->response->jobResponse);

    $jobStatus = ($json2->response->status);

} 



echo "<br/>DOWNLOADING REPORT";



//Get the file
$content = file_get_contents("$jobResponse");

//Store in the filesystem.
$fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Pacing/" . $accounts[0]->name ."Test.csv", "w");
fwrite($fp, $content);
fclose($fp);


// PHPEXCEL OPEN SPREADSHEET 


$objReader = new PHPExcel_Reader_CSV();
$objPHPExcel = $objReader->load("../Reports/YahooT2Pacing/" . $accounts[0]->name . "Test.csv");
$objWorksheet = $objPHPExcel->getActiveSheet();


// SEND TO ARRAY


$performanceArray = $objWorksheet->toArray();


// STORE DATA FROM REPORT INTO VARS


$testSpend = $performanceArray[1][2];
$testCode = $performanceArray[1][0];
$accountNumber = $accounts[0]->code;
$displayName = $accounts[0]->name;

$testSpend = number_format($testSpend, 2, '.', '');
$regSpend = number_format($regSpend, 2, '.', '');



// COMPARE FIGURES AND THROW ERROR FOR DISCREPENCY



if ($testSpend >= ($regSpend - 10) || $testSpend <= ($regSpend + 10)) {
    $errorMessage = "";
}
else {
    $errorMessage = "Yahoo Warning: discrepency found between $name $filter presumed entry: $regSpend and $name total: $testSpend";
}

if ($testCode == $accountNumber) {
    $accountMessage = "TRUE $displayName";
}
else {
    $accountMessage = "FALSE Account Reports don't match";
}



echo "<br/>INSERTING DATA INTO SPREADSHEET";              



if ($filter !== "") {

    $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$accountMessage"));
    $batchResponse = $cellFeed->insertBatch($batchRequest);

}
else {

    $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$accountMessage"));    
    $batchResponse = $cellFeed->insertBatch($batchRequest);

}



echo "<br/>BEGIN ITERATING THROUGH ACCOUNT LIST"; 



for ($thisRow = 1; $thisRow < $myCount; $thisRow++) {

// SET REFRESH TOKEN

    $refreshThis = $tokens['r'];


// GO THROUGH OAUTH YAHOO PROCESS


    $gemini_api_endpoint="https://api.admanager.yahoo.com/v1/rest";
    $oauth2client=new YahooOAuth2();

    if (isset($_GET['code'])){
        $code=$_GET['code'];  
    } 
    else {
        $code=0;
    }

//SET ACCOUNT SPECIFIC INFO

    $accountNumber = (string)$accounts[$thisRow]->code;
    $name = (string)$accounts[$thisRow]->name;



//DEFINE JSON TO BE SENT OVER CURL TO YAHOO GEMINI



    $json = '{ "cube": "performance_stats",
    "fields": [
       { "field": "Ad ID" },
       { "field": "Campaign ID" },
       { "field": "Ad Group ID" },
       { "field": "Month" },
       { "alias": "My dummy column", "value": "" },
       { "field": "Clicks" },
       { "field": "Average CPC" },
       { "field": "CTR" },
       { "field": "Spend" },
       { "field": "Impressions" },
       { "field": "Ad Landing URL", "alias": "url" }
     ],
    "filters": [
       { "field": "Advertiser ID", "operator": "=", "value": "' . $accountNumber . '" },
       { "field": "Day", "operator": "between", "from": "' . $lowRange . '", "to": "' . $highRange . '" }
     ]
    }';


//GO THROUGH YAHOO OAUTH PROCESS


    if($code){
        #oAuth 3-legged authorization is successful, fetch access token  
        $tokens=$oauth2client->get_new_access_token(CONSUMER_KEY,CONSUMER_SECRET,$redirect_uri,$refreshThis);

        #Access token is available. Do API calls.   
        $headers= array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json');
        #Fetch Advertiser Name and Advertiser ID
        // $url=$gemini_api_endpoint."/campaign/347026014";
        $url=$gemini_api_endpoint."/reports/custom";
        $resp=$oauth2client->fetch($url,$postdata=$json,$auth="",$headers);
        $jsonResponse = json_decode( $resp );
        // $advertiserName = $jsonResponse->response[0]->advertiserName; 
        // $advertiserId = $jsonResponse->response[0]->id; 
        // echo "Welcome ".$advertiserName;
    }        
    else {
        # no valid access token available, go to authorization server 
        header("HTTP/1.1 302 Found");
        header("Location: " . $oauth2client->getAuthorizationURL(CONSUMER_KEY,$redirect_uri));
        exit;
    } 


//PING GEMINI UNTIL REPORT IS PREPARED


    $jobId = ($jsonResponse->response->jobId);

    $jobStatus = "";

    while ($jobStatus !== "completed") {

        usleep(250000);
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/reports/custom/$jobId?advertiserId=$accountNumber",
            // CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/campaign/347026014",
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
            CURLOPT_HTTPHEADER => array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json'),
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

        // 'Authorization: Bearer '.$token,'Accept: application/json','Content-Type: application/json'
        $json2 = (json_decode($resp));
        $jobResponse = ($json2->response->jobResponse);

        $jobStatus = ($json2->response->status);

    } 



//DOWNLOAD THE REPORT



    //Get the file
    $content = file_get_contents("$jobResponse");

    //Store in the filesystem.
    $fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Pacing/$name.csv", "w");
    fwrite($fp, $content);
    fclose($fp);



// PHPEXCEL OPEN SPREADSHEET



    $objReader = new PHPExcel_Reader_CSV();
    $objPHPExcel = $objReader->load("../Reports/YahooT2Pacing/$name.csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();


// SEND TO ARRAY


    $performanceArray = $objWorksheet->toArray();
    $adjustedArray = array();


// MASSAGE KEYWORDS


    $x = 0;

    for ($i = 1; $i < count($performanceArray); ++$i) {

        $landingUrl = $performanceArray[$i][10];
        $performanceClicks = $performanceArray[$i][5];
        $performanceImp = $performanceArray[$i][9];
        $performanceCtr = number_format((float)$performanceArray[$i][7] * 100, 2, '.', ',')  . '%';
        $performanceCpc = $performanceArray[$i][6];
        $performanceSpend = $performanceArray[$i][8];
        $campaignId = $performanceArray[$i][1];

        $landingUrl = array(str_replace("%2B", " ", substr(strrchr($landingUrl, "="), 1)));

        $landingUrl = str_replace("abilene ", "", $landingUrl);
        $landingUrl = str_replace("%2", " ", $landingUrl);
        $landingUrl = str_replace("alexandria ", "", $landingUrl);
        $landingUrl = str_replace("amarillo ", "", $landingUrl);
        $landingUrl = str_replace("baton rouge ", "", $landingUrl);
        $landingUrl = str_replace("corpus ", "", $landingUrl);
        $landingUrl = str_replace("mcallen ", "", $landingUrl);
        $landingUrl = str_replace("mcallennissanrogue", "nissan rogue", $landingUrl);
        $landingUrl = str_replace("lafayette ", "", $landingUrl);
        $landingUrl = str_replace("lake charles ", "", $landingUrl);
        $landingUrl = str_replace("laredo ", "", $landingUrl);
        $landingUrl = str_replace("new orleans ", "", $landingUrl);
        $landingUrl = str_replace("lubbock ", "", $landingUrl);
        $landingUrl = str_replace("victoria ", "", $landingUrl);
        $landingUrl = str_replace("tyler ", "", $landingUrl);
        $landingUrl = str_replace("sherman ada ", "", $landingUrl);
        $landingUrl = str_replace("fourrunner", "four runner", $landingUrl);
        $landingUrl = str_replace("focusse", "focus se", $landingUrl);
        $landingUrl = str_replace("monroe ", "", $landingUrl);
        $landingUrl = str_replace("san angelo ", "", $landingUrl);
        $landingUrl = str_replace("wichita ", "", $landingUrl);
        $landingUrl = str_replace("fordfusion", "ford fusion", $landingUrl);
        $landingUrl = str_replace("hyundaielantra", "hyundai elantra", $landingUrl);
        $landingUrl = str_replace("hondacrv", "honda crv", $landingUrl);
        $landingUrl = str_replace("beaumont ", "", $landingUrl);
        $landingUrl = str_replace("grandcherokee", "grand cherokee", $landingUrl);
        $landingUrl = str_replace("batonrougefordfocus", "ford focus", $landingUrl);
        $landingUrl = str_replace("santafe", "santa fe", $landingUrl);
        $landingUrl = str_replace("genesiscoupe", "genesis coupe", $landingUrl);
        $landingUrl = str_replace("nissanrogue", "nissan rogue", $landingUrl);
        $landingUrl = str_replace("kiasportage", "kia sportage", $landingUrl);


// SAVE FIGURES IN VARIABLE


        $adjustedArray[] = $landingUrl;

        $adjustedArray[$x][1] = $performanceClicks;
        $adjustedArray[$x][2] = $performanceImp;
        $adjustedArray[$x][3] = $performanceCtr;
        $adjustedArray[$x][4] = $performanceCpc;
        $adjustedArray[$x][5] = $performanceSpend;
        $adjustedArray[$x][6] = $campaignId;

    ++$x;

    } 

          

// OPEN OTHER PHPEXCEL SPREADSHEET



    $objPHPExcel->disconnectWorksheets();
    $objPHPExcel->createSheet();
    $objWorksheet = $objPHPExcel->getActiveSheet();


// MASSAGE COLUMNS AND DATA


    $clicksArray = array();
    $spendArray = array();

    $howManyRows = count($adjustedArray);
    $objWorksheet->fromArray($adjustedArray, NULL, 'A1');

    $objWorksheet->getStyle('E1:E' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('F1:F' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('B1:B' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');
    $objWorksheet->getStyle('C1:C' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');

    $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
    $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5



//ITERATE THROUGH ACCOUNTS AND STORE DATA IN VARS



    for ($row = 1; $row <= $highestRow; ++$row) {

        $clicks = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
        $spend = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();

        $clicksArray[] = $clicks;
        $spendArray[] = $spend;

    }

    $regClicks = array_sum($clicksArray);
    $regSpend = array_sum($spendArray);

    $option = $accounts[$thisRow]->name;
    $filter = $accounts[$thisRow]->filter;



// FIND GOOGLE SHEET ROW THAT MATCHES ACCOUNT NAME



    $o = 0;
    foreach($sheetArray as $item)
    {
        foreach($item as $sub => $v)
        {
            if (($filter !== "") && (isset($item[1])) && ((stripos($item[1], trim($option)) !== false)) && (stripos($item[2], trim($filter)) !== false)) {

                $googleSheetRow = $arrayKeys[$o];
              
            }
            elseif (($filter == "") && (isset($item[1])) && (stripos($item[1], trim($option)) !== false)) {

            $googleSheetRow = $arrayKeys[$o];
           
            }

        }
      
      $o++;

    } 



echo "<br/>INSERTING DATA INTO SPREADSHEET";



    if ($filter !== "") {

        $rowBelow = $googleSheetRow + 1;
        $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$regClicks-$formulaColClicks$rowBelow"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "=$regSpend-$formulaColSpend$rowBelow"));
        $batchResponse = $cellFeed->insertBatch($batchRequest);

    }
    else {

        $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$regClicks"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$regSpend"));
        $batchResponse = $cellFeed->insertBatch($batchRequest);

    }



// SET REFRESH TOKEN



    $refreshThis = $tokens['r'];

    $gemini_api_endpoint="https://api.admanager.yahoo.com/v1/rest";
    $oauth2client=new YahooOAuth2();

    if (isset($_GET['code'])){
        $code=$_GET['code'];  
    } 
    else {
        $code=0;
    }



// DEFINE JSON TO BE SENT OVER CURL TO GEMINI           



    $json = '{ "cube": "product_ads",
    "fields": [
    {
    "field": "Advertiser ID"
    },
    {
    "field": "Clicks"
    },
    {
    "field": "Spend"
    }
    ],
    "filters": [
    { "field": "Advertiser ID", "operator": "=", "value": "' . $accountNumber . '" },
    { "field": "Day", "operator": "between", "from": "' . $lowRange . '", "to": "' . $highRange . '" }
    ]
    }';

   
// GO THROUGH GEMINI OAUTH2 PROCESS


    if($code){
        #oAuth 3-legged authorization is successful, fetch access token  
        $tokens=$oauth2client->get_new_access_token(CONSUMER_KEY,CONSUMER_SECRET,$redirect_uri,$refreshThis);

        #Access token is available. Do API calls.   
        $headers= array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json');
        #Fetch Advertiser Name and Advertiser ID
        // $url=$gemini_api_endpoint."/campaign/347026014";
        $url=$gemini_api_endpoint."/reports/custom";
        $resp=$oauth2client->fetch($url,$postdata=$json,$auth="",$headers);
        $jsonResponse = json_decode( $resp );
        // $advertiserName = $jsonResponse->response[0]->advertiserName; 
        // $advertiserId = $jsonResponse->response[0]->id; 
        // echo "Welcome ".$advertiserName;
    }
    else {
       # no valid access token available, go to authorization server 
       header("HTTP/1.1 302 Found");
       header("Location: " . $oauth2client->getAuthorizationURL(CONSUMER_KEY,$redirect_uri));
       exit;
    }


// PING YAHOO UNTIL REPORT IS COMPLETED


    $jobId = ($jsonResponse->response->jobId);
    $jobStatus = "";

    while ($jobStatus !== "completed") {

        usleep(250000);
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/reports/custom/$jobId?advertiserId=$accountNumber",
            // CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/campaign/347026014",
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
            CURLOPT_HTTPHEADER => array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json'),
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

        // 'Authorization: Bearer '.$token,'Accept: application/json','Content-Type: application/json'
        $json2 = (json_decode($resp));
        $jobResponse = ($json2->response->jobResponse);
        $jobStatus = ($json2->response->status);

    } 


// DOWNLOAD THE FILE


    //Get the file
    $content = file_get_contents("$jobResponse");

    //Store in the filesystem.
    $fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Pacing/" . $accounts[$thisRow]->name ."Test.csv", "w");
    fwrite($fp, $content);
    fclose($fp);


// OPEN REPORT IN PHPEXCEL
    

    $objReader = new PHPExcel_Reader_CSV();
    $objPHPExcel = $objReader->load("../Reports/YahooT2Pacing/" . $accounts[$thisRow]->name . "Test.csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();


// SEND TO ARRAY


    $performanceArray = $objWorksheet->toArray();


// STORE DATA IN VARS


    $testSpend = $performanceArray[1][2];
    $testCode = $performanceArray[1][0];
    $accountNumber = $accounts[$thisRow]->code;

    $testSpend = number_format($testSpend, 2, '.', '');
    $regSpend = number_format($regSpend, 2, '.', '');

    $displayName = $accounts[$thisRow]->name;



// COMPARE FIGURES AND THROW ERROR FOR DISCREPENCY



    if ($testSpend >= ($regSpend - 10) && $testSpend <= ($regSpend + 10)) {
        $errorMessage = "";
    }
    else {
        $errorMessage = "Yahoo Warning: discrepency found between $name $filter presumed entry: $regSpend and $name total: $testSpend";
    }

    if ($testCode == $accountNumber) {
        $accountMessage = "TRUE $displayName";
    }
    else {
        $accountMessage = "FALSE: Accounts don't match";
    }



echo "<br/>INSERTING DATA INTO SPREADSHEET";   



    if ($filter !== "") {

        $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$accountMessage"));
        $batchResponse = $cellFeed->insertBatch($batchRequest);

    }
    else {

        $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$accountMessage"));    
        $batchResponse = $cellFeed->insertBatch($batchRequest);

    }

}    



// ITERATE THROUGH LUX ACCOUNT LIST



for ($thisRow = 0; $thisRow < $myCount; $thisRow++) {
    
// TAKE A NAP

    sleep(1);

// SET REFRESH TOKEN

    $refreshThis = $tokens['r'];

// GO THROUGH GEMINI OAUTH    

    $gemini_api_endpoint="https://api.admanager.yahoo.com/v1/rest";
    $oauth2client=new YahooOAuth2();

    if (isset($_GET['code'])){
        $code=$_GET['code'];  
    } 
    else {
        $code=0;
    }

    $accountNumber = (string)$luxAccounts[$thisRow]->code;
    $name = (string)$luxAccounts[$thisRow]->name;
    $luxAccountNumber1 = (string)$luxAccounts[$thisRow]->lux_campaign_1;
    $luxAccountNumber2 = (string)$luxAccounts[$thisRow]->lux_campaign_2;


// STORE JSON DATA TO BE SENT OVER CURL        


    $json = '{ "cube": "performance_stats",
    "fields": [
       { "field": "Ad ID" },
       { "field": "Campaign ID" },
       { "field": "Ad Group ID" },
       { "field": "Month" },
       { "alias": "My dummy column", "value": "" },
       { "field": "Clicks" },
       { "field": "Average CPC" },
       { "field": "CTR" },
       { "field": "Spend" },
       { "field": "Impressions" },
       { "field": "Ad Landing URL", "alias": "url" }
     ],
    "filters": [
       { "field": "Advertiser ID", "operator": "=", "value": "' . $accountNumber . '" },
       { "field": "Day", "operator": "between", "from": "' . $lowRange . '", "to": "' . $highRange . '" }
     ]
    }';


// MORE OAUTH


    if($code){
        #oAuth 3-legged authorization is successful, fetch access token  
        $tokens=$oauth2client->get_new_access_token(CONSUMER_KEY,CONSUMER_SECRET,$redirect_uri,$refreshThis);

        #Access token is available. Do API calls.   
        $headers= array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json');
        #Fetch Advertiser Name and Advertiser ID
        // $url=$gemini_api_endpoint."/campaign/347026014";
        $url=$gemini_api_endpoint."/reports/custom";
        $resp=$oauth2client->fetch($url,$postdata=$json,$auth="",$headers);
        $jsonResponse = json_decode( $resp );
        // $advertiserName = $jsonResponse->response[0]->advertiserName; 
        // $advertiserId = $jsonResponse->response[0]->id; 
        // echo "Welcome ".$advertiserName;
    }
    else {
        # no valid access token available, go to authorization server 
        header("HTTP/1.1 302 Found");
        header("Location: " . $oauth2client->getAuthorizationURL(CONSUMER_KEY,$redirect_uri));
        exit;
    }

    $jobId = ($jsonResponse->response->jobId);


// PING YAHOO UNTIL REPORT IS PREPARED


    $jobStatus = "";

    while ($jobStatus !== "completed") {

    usleep(250000);
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/reports/custom/$jobId?advertiserId=$accountNumber",
        // CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/campaign/347026014",
        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
        CURLOPT_HTTPHEADER => array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json'),
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);

    // Close request to clear up some resources
    curl_close($curl);

    // 'Authorization: Bearer '.$token,'Accept: application/json','Content-Type: application/json'
    $json2 = (json_decode($resp));
    $jobResponse = ($json2->response->jobResponse);

    $jobStatus = ($json2->response->status);

    } 


// DOWNLOAD THE REPORT


   //Get the file
   $content = file_get_contents("$jobResponse");

   //Store in the filesystem.
   $fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Pacing/$name.csv", "w");
   fwrite($fp, $content);
   fclose($fp);



// OPEN UP PHPEXCEL SPREADSHEET



    $objReader = new PHPExcel_Reader_CSV();
    $objPHPExcel = $objReader->load("../Reports/YahooT2Pacing/$name.csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $performanceArray = $objWorksheet->toArray();
    $adjustedArray = array();


// MASSAGE DATA


    $x = 0;

    for ($i = 1; $i < count($performanceArray); ++$i) {

        $landingUrl = $performanceArray[$i][10];
        $performanceClicks = $performanceArray[$i][5];
        $performanceImp = $performanceArray[$i][9];
        $performanceCtr = number_format((float)$performanceArray[$i][7] * 100, 2, '.', ',')  . '%';
        $performanceCpc = $performanceArray[$i][6];
        $performanceSpend = $performanceArray[$i][8];
        $campaignId = $performanceArray[$i][1];

        $landingUrl = array(str_replace("%2B", " ", substr(strrchr($landingUrl, "="), 1)));

        $landingUrl = str_replace("abilene ", "", $landingUrl);
        $landingUrl = str_replace("%2", " ", $landingUrl);
        $landingUrl = str_replace("alexandria ", "", $landingUrl);
        $landingUrl = str_replace("amarillo ", "", $landingUrl);
        $landingUrl = str_replace("baton rouge ", "", $landingUrl);
        $landingUrl = str_replace("corpus ", "", $landingUrl);
        $landingUrl = str_replace("mcallen ", "", $landingUrl);
        $landingUrl = str_replace("mcallennissanrogue", "nissan rogue", $landingUrl);
        $landingUrl = str_replace("lafayette ", "", $landingUrl);
        $landingUrl = str_replace("lake charles ", "", $landingUrl);
        $landingUrl = str_replace("laredo ", "", $landingUrl);
        $landingUrl = str_replace("new orleans ", "", $landingUrl);
        $landingUrl = str_replace("lubbock ", "", $landingUrl);
        $landingUrl = str_replace("victoria ", "", $landingUrl);
        $landingUrl = str_replace("tyler ", "", $landingUrl);
        $landingUrl = str_replace("sherman ada ", "", $landingUrl);
        $landingUrl = str_replace("fourrunner", "four runner", $landingUrl);
        $landingUrl = str_replace("focusse", "focus se", $landingUrl);
        $landingUrl = str_replace("monroe ", "", $landingUrl);
        $landingUrl = str_replace("san angelo ", "", $landingUrl);
        $landingUrl = str_replace("wichita ", "", $landingUrl);
        $landingUrl = str_replace("fordfusion", "ford fusion", $landingUrl);
        $landingUrl = str_replace("hyundaielantra", "hyundai elantra", $landingUrl);
        $landingUrl = str_replace("hondacrv", "honda crv", $landingUrl);
        $landingUrl = str_replace("beaumont ", "", $landingUrl);
        $landingUrl = str_replace("grandcherokee", "grand cherokee", $landingUrl);
        $landingUrl = str_replace("batonrougefordfocus", "ford focus", $landingUrl);
        $landingUrl = str_replace("santafe", "santa fe", $landingUrl);
        $landingUrl = str_replace("genesiscoupe", "genesis coupe", $landingUrl);
        $landingUrl = str_replace("nissanrogue", "nissan rogue", $landingUrl);
        $landingUrl = str_replace("kiasportage", "kia sportage", $landingUrl);

        $adjustedArray[] = $landingUrl;

        $adjustedArray[$x][1] = $performanceClicks;
        $adjustedArray[$x][2] = $performanceImp;
        $adjustedArray[$x][3] = $performanceCtr;
        $adjustedArray[$x][4] = $performanceCpc;
        $adjustedArray[$x][5] = $performanceSpend;
        $adjustedArray[$x][6] = $campaignId;

        ++$x;

    } 

          

// OPEN UP SEPARATE PHPEXCEL OBJECT



    $objPHPExcel->disconnectWorksheets();
    $objPHPExcel->createSheet();
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $clicksArray = array();
    $spendArray = array();


// MASSAGE DATA


    $howManyRows = count($adjustedArray);
    $objWorksheet->fromArray($adjustedArray, NULL, 'A1');

    $objWorksheet->getStyle('E1:E' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('F1:F' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('B1:B' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');
    $objWorksheet->getStyle('C1:C' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');

    $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
    $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5


// ITERATE THROUGH AND PULL IMPORTANT DATA
              

    for ($row = 1; $row <= $highestRow; ++$row) {
        for ($col = 1; $col <= $highestColumnIndex; ++$col) {

            $contents = $objWorksheet->getCellByColumnAndRow(($col + 5), $row)->getValue();

            $option = $luxAccounts[$thisRow]->name;
            $filter = $luxAccounts[$thisRow]->filter;

        if ((($filter === "Luxury") || ($filter === "luxury")) && (stripos($contents, trim($luxAccountNumber1)) !== false) || (stripos($contents, trim($luxAccountNumber2)) !== false)) {

            $clicks = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            $spend = $objWorksheet->getCellByColumnAndRow(($col + 4), $row)->getValue();
            $clicksArray[] = $clicks;
            $spendArray[] = $spend;

            }
        }
    }


// STORE DATA IN VARS


    $luxClicks = array_sum($clicksArray);
    $luxSpend = array_sum($spendArray);
            


// FIND GOOGLE SHEET ROW THAT MATCHES ACCOUNT NAME



    $o = 0;
    foreach($sheetArray as $item)
    {
        foreach($item as $sub => $v)
        {
            if (($filter !== "") && (isset($item[1])) && ((stripos($item[1], trim($option)) !== false)) && (stripos($item[2], trim($filter)) !== false)) {

                $googleSheetRow = $arrayKeys[$o];

            }
            elseif (($filter == "") && (isset($item[1])) && (stripos($item[1], trim($option)) !== false)) {

                $googleSheetRow = $arrayKeys[$o];

            }

        }
      
        $o++;
    } 


    echo "<br/>INSERTING DATA INTO SPREADSHEET";


    $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$luxClicks"));
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$luxSpend"));
    $batchResponse = $cellFeed->insertBatch($batchRequest);



//START OTHER REPORT FOR COMPARISONS


// REFRESH


    $refreshThis = $tokens['r'];
    $gemini_api_endpoint="https://api.admanager.yahoo.com/v1/rest";
    $oauth2client=new YahooOAuth2();

    if (isset($_GET['code'])){
        $code=$_GET['code'];  
    } 
    else {
        $code=0;
    }


// DEFINE CURL JSON


    $json = '{ "cube": "product_ads",
    "fields": [
    {
      "field": "Advertiser ID"
    },
    {
      "field": "Clicks"
    },
    {
      "field": "Spend"
    }
    ],
    "filters": [
       { "field": "Advertiser ID", "operator": "=", "value": "' . $accountNumber . '" },
       { "field": "Day", "operator": "between", "from": "' . $lowRange . '", "to": "' . $highRange . '" }
     ]
    }';


// YAHOO OAUTH


    if($code){
        #oAuth 3-legged authorization is successful, fetch access token  
        $tokens=$oauth2client->get_new_access_token(CONSUMER_KEY,CONSUMER_SECRET,$redirect_uri,$refreshThis);

        #Access token is available. Do API calls.   
        $headers= array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json');
        #Fetch Advertiser Name and Advertiser ID
        // $url=$gemini_api_endpoint."/campaign/347026014";
        $url=$gemini_api_endpoint."/reports/custom";
        $resp=$oauth2client->fetch($url,$postdata=$json,$auth="",$headers);
        $jsonResponse = json_decode( $resp );
        // $advertiserName = $jsonResponse->response[0]->advertiserName; 
        // $advertiserId = $jsonResponse->response[0]->id; 
        // echo "Welcome ".$advertiserName;
    }    
    else {
       # no valid access token available, go to authorization server 
       header("HTTP/1.1 302 Found");
       header("Location: " . $oauth2client->getAuthorizationURL(CONSUMER_KEY,$redirect_uri));
       exit;
    }


// PING YAHOO


    $jobId = ($jsonResponse->response->jobId);
    $jobStatus = "";

    while ($jobStatus !== "completed") {

        usleep(250000);
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/reports/custom/$jobId?advertiserId=$accountNumber",
            // CURLOPT_URL => "https://api.admanager.yahoo.com/v1/rest/campaign/347026014",
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
            CURLOPT_HTTPHEADER => array('Authorization: Bearer '.$tokens['a'],'Accept: application/json','Content-Type: application/json'),
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

        // 'Authorization: Bearer '.$token,'Accept: application/json','Content-Type: application/json'
        $json2 = (json_decode($resp));
        $jobResponse = ($json2->response->jobResponse);
        $jobStatus = ($json2->response->status);

    } 


// DOWNLOAD


    //Get the file
    $content = file_get_contents("$jobResponse");

    //Store in the filesystem.
    $fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Pacing/" . $name ."Test.csv", "w");
    fwrite($fp, $content);
    fclose($fp);


// OPEN PHPEXCEL


    $objReader = new PHPExcel_Reader_CSV();
    $objPHPExcel = $objReader->load("../Reports/YahooT2Pacing/" . $name . "Test.csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();


// MOVE TO ARRAY AND STORE DATA IN VARS


    $performanceArray = $objWorksheet->toArray();

    $testSpend = $performanceArray[1][2];
    $testCode = $performanceArray[1][0];

    $testSpend = number_format($testSpend, 2, '.', '');
    $luxSpend = number_format($luxSpend, 2, '.', '');


    $displayName = $accounts[$thisRow]->name;



// COMPARE FIGURES AND THROW ERROR FOR DISCREPENCY


                
    $errorMessage = "Luxury campaign spend of total spend: $testSpend (+- $10)";
    
    if ($testCode == $accountNumber) {
        $accountMessage = "TRUE $name";
    }
    else {
        $accountMessage = "FALSE: Accounts don't match";
    }



echo "<br/>INSERTING DATA INTO SPREADSHEET";


        
    if ($filter !== "") {

        $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$accountMessage"));
        $batchResponse = $cellFeed->insertBatch($batchRequest);

    }
    else {

        $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$accountMessage"));    
        $batchResponse = $cellFeed->insertBatch($batchRequest);

    }
 
}

?>