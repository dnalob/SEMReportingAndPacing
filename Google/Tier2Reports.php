<?php

include_once '../includes/functions.php';

sec_session_start();

require_once dirname(__FILE__) . '/../includes/db_conn.php';
require_once dirname(__FILE__) . '/../includes/T2_reg_accounts_google.php';
require_once dirname(dirname(__FILE__)) . '/vendor/examples/AdWords/v201601/init.php';
require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once '../includes/db_connect.php';
require '../vendor/phpmailer/PHPMailerAutoload.php';

date_default_timezone_set('America/Chicago');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');



// KEYWORD PERFORMANCE REPORT FUNCTION



function KeywordReport(AdWordsUser $user, $filePath, $accountNumber, $name ) {
    // Load the service, so that the required classes are available.
    $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
    // Optional: Set clientCustomerId to get reports of your child accounts
    $user->SetClientCustomerId($accountNumber);


    // Create selector.
    $selector = new Selector();
    $selector->fields = array('Criteria', 'Clicks', 'Impressions', 'Ctr', 'AverageCpc', 'Cost');


    //FILTER CLICKS GREATER THAN OR EQUAL TO 1
    $selector->predicates[] = new Predicate('Clicks', 'GREATER_THAN_EQUALS', 1);

    // Optional: use predicate to filter out paused criteria.
    //$selector->predicates[] = new Predicate('Status', 'NOT_IN', array('PAUSED'));


// SET DATE RANGE TO LAST MONTH


    $lowRange = date('Ym01', strtotime('previous month'));
    $highRange = date('Ymt', strtotime('previous month'));

    // Create report definition.
    $reportDefinition = new ReportDefinition();
    $reportDefinition->selector = $selector;
    $reportDefinition->reportName = 'Keyword Performance Report #' . time();
    $selector->dateRange = new DateRange($lowRange, $highRange);
    $reportDefinition->dateRangeType = 'CUSTOM_DATE';
    $reportDefinition->reportType = 'KEYWORDS_PERFORMANCE_REPORT';
    $reportDefinition->downloadFormat = 'CSV';

    // Exclude criteria that haven't recieved any impressions over the date range.
    //$reportDefinition->includeZeroImpressions = false;

    // Set additional options.
    $options = array('version' => ADWORDS_VERSION);

    // Optional: Set skipReportHeader, skipColumnHeader, skipReportSummary to
    //     suppress headers or summary rows.
    // $options['skipReportHeader'] = true;
    // $options['skipColumnHeader'] = true;
    // $options['skipReportSummary'] = true;
    // Optional: Set includeZeroImpressions to include zero impression rows in
    //     the report output.
    // $options['includeZeroImpressions'] = true;

    // Download report.
    ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);
    printf("Report with name '%s' was downloaded to '%s'.\n",
    $reportDefinition->reportName, $filePath);
    echo "<br/>";
}



// EMPTY DESTINATION FOLDERS OF OLD REPORTS



$files = glob(dirname(__FILE__) . '/../Reports/GoogleT2Reports/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}

$files = glob(dirname(__FILE__) . '/../Reports/GoogleT2ReportsExt/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}



echo "<br/>ITERATING OVER REGULAR ACCOUNT LIST AND DOWNLOADING REPORTS";



$accounts = json_decode($regJSON);
$myCount = count($accounts);


for ($row = 0; $row < $myCount; $row++) {

    // SET SPECIFIC ACCOUNT DETAILS

    $accountNumber = (string)$accounts[$row]->code;
    $name = (string)$accounts[$row]->name;

    try {
      // Get AdWordsUser from credentials in "../auth.ini"
      // relative to the AdWordsUser.php file's directory.
      $user = new AdWordsUser();

      // Log every SOAP XML request and response.
      $user->LogAll();

      // Download the report to a file in the same directory as the example.
      $filePath = dirname(__FILE__) . '/../Reports/GoogleT2Reports/' . $name . '.csv';


      // Run the example.
      KeywordReport($user, $filePath, $accountNumber, $name);
    } catch (Exception $e) {
      printf("An error has occurred: %s\n", $e->getMessage());
    }

}



// GREEN LIGHT FOR DATA EXTRACTION



$lastItem = "Green Light";

?>

