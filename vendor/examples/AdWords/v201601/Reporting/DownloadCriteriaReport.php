<?php
/**
 * This example downloads a criteria report to a file.
 *
 * Copyright 2016, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201601
 * @category   WebServices
 * @copyright  2015, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 */

// Include the initialization file
// require_once dirname(dirname(__FILE__)) . '/init.php';
// require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';

// /**
// * Runs the example.
// * @param AdWordsUser $user the user to run the example with
// * @param string $filePath the path of the file to download the report to
// */
// function KeywordPerformanceReport(AdWordsUser $user, $filePath) {
//   // Load the service, so that the required classes are available.
//   $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
//   // Optional: Set clientCustomerId to get reports of your child accounts
//   $user->SetClientCustomerId('663-616-0014');
   
   

//   // Create selector.
//   $selector = new Selector();
//   $selector->fields = array('Criteria', 'Clicks', 'Impressions', 'Ctr', 'AverageCpc', 'Cost');

//   // Optional: use predicate to filter out paused criteria.
//   //$selector->predicates[] = new Predicate('Status', 'NOT_IN', array('PAUSED'));

//   // Create report definition.
//   $reportDefinition = new ReportDefinition();
//   $reportDefinition->selector = $selector;
//   $reportDefinition->reportName = 'Keyword Performance Report #' . time();
//   $selector->dateRange = new DateRange('20160101', '20160131');
//   $reportDefinition->dateRangeType = 'CUSTOM_DATE';
//   $reportDefinition->reportType = 'KEYWORDS_PERFORMANCE_REPORT';
//   $reportDefinition->downloadFormat = 'CSV';

//   // Exclude criteria that haven't recieved any impressions over the date range.
//   //$reportDefinition->includeZeroImpressions = false;

//   // Set additional options.
//   $options = array('version' => ADWORDS_VERSION);

//   // Optional: Set skipReportHeader, skipColumnHeader, skipReportSummary to
//   //     suppress headers or summary rows.
//   // $options['skipReportHeader'] = true;
//   // $options['skipColumnHeader'] = true;
//   // $options['skipReportSummary'] = true;
//   // Optional: Set includeZeroImpressions to include zero impression rows in
//   //     the report output.
//   // $options['includeZeroImpressions'] = true;

//   // Download report.
//   ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);
//   printf("Report with name '%s' was downloaded to '%s'.\n",
//       $reportDefinition->reportName, $filePath);
// }

// // Don't run the example if the file is being included.
// //if (__FILE__ != realpath($_SERVER['PHP_SELF'])) {
// //  return;
// //  }

// try {
//   // Get AdWordsUser from credentials in "../auth.ini"
//   // relative to the AdWordsUser.php file's directory.
//   $user = new AdWordsUser();

//   // Log every SOAP XML request and response.
//   $user->LogAll();

//   // Download the report to a file in the same directory as the example.
//   $filePath = dirname(__FILE__) . '/report.csv';

//   // Run the example.
//   DownloadCriteriaReportExample($user, $filePath);
// } catch (Exception $e) {
//   printf("An error has occurred: %s\n", $e->getMessage());
// }



// Include the initialization file
require_once dirname(dirname(__FILE__)) . '/init.php';
require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';
date_default_timezone_set('America/Chicago');
/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param string $filePath the path of the file to download the report to
 */
 


header('Location: /api3/index2.php');






$accounts = array
  (
    array("Austin", '970-652-5185'),
    array("Carolina", '153-840-9044'),
    array("Charlotte", '269-856-6997'),
    array("Hampton", '180-316-4520'),
    array("Orlando", '207-459-5693'),
    array("Richmond", '533-129-9793'),
    array("SELA", '900-991-8713'),
    array("Jacksonville", '498-679-8122'),
    array("Augusta", '408-060-3957'),
    array("Charleston", '879-478-1951'),
    array("Abilene", '925-039-4232'),
    array("Amarillo", '973-073-4432'),
    array("Beaumont", '860-567-9936'),
    array("CorpusChristi", '428-647-3757'),
    array("Laredo", '486-759-6314'),
    array("Lubbock", '225-532-1857'),
    array("Harlingen", '353-405-5522'),
    array("Midland", '145-355-6024'),
    array("SanAngelo", '963-679-1381'),
    array("Sherman", '471-431-8122'),
    array("Tyler", '798-897-0669'),
    array("Wichita", '495-471-2353'),
    array("Victoria", '912-680-7253')
);





$myCount = count($accounts);
 





function KeywordReport(AdWordsUser $user, $filePath, $accountNumber, $name ) {
  // Load the service, so that the required classes are available.
  $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
  // Optional: Set clientCustomerId to get reports of your child accounts
  $user->SetClientCustomerId($accountNumber);
   

  // Create selector.
  $selector = new Selector();
  $selector->fields = array('Criteria', 'Clicks', 'Impressions', 'Ctr', 'AverageCpc', 'Cost');
  
  
  //FILTER CLICKS GREATER THAN OR EQUAL TO 1
  $selector->predicates[] =
      new Predicate('Clicks', 'GREATER_THAN_EQUALS', 1);

  // Optional: use predicate to filter out paused criteria.
  //$selector->predicates[] = new Predicate('Status', 'NOT_IN', array('PAUSED'));

  // Create report definition.
  $reportDefinition = new ReportDefinition();
  $reportDefinition->selector = $selector;
  $reportDefinition->reportName = 'Keyword Performance Report #' . time();
  $selector->dateRange = new DateRange('20160301', '20160331');
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







for ($row = 0; $row < $myCount; $row++) {


        $name = (string)$accounts[$row][0];
        $accountNumber = (string)$accounts[$row][1];
        


        try {
          // Get AdWordsUser from credentials in "../auth.ini"
          // relative to the AdWordsUser.php file's directory.
          $user = new AdWordsUser();

          // Log every SOAP XML request and response.
          $user->LogAll();

          // Download the report to a file in the same directory as the example.
          $filePath = dirname(__FILE__) . '/../../../../Reports1/' . $name . '.csv';


          // Run the example.
          KeywordReport($user, $filePath, $accountNumber, $name);
        } catch (Exception $e) {
          printf("An error has occurred: %s\n", $e->getMessage());
        }

         
        // $lastPath = dirname(__FILE__) . "/../../../../Reports1/" . $name . ".csv";
        // while (!file_exists($lastPath)) {
        //   sleep(1);
        //   }

}
















exit;




?>

