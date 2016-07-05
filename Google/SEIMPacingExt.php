<?php

date_default_timezone_set('America/Chicago');

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once dirname(__FILE__) . '/SEIMPacing.php'; 
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../includes/db_conn.php';
require_once dirname(__FILE__) . '/../includes/SEIM_reg_accounts_google.php'; 
require_once dirname(__FILE__) . '/../includes/SEIM_reg_campaigns_google.php';   



// CHECK FOR GREEN LIGHT



while (!isset($lastItem)) {
  sleep(1);
}



// GET ARRAY OF ANY ACCOUNTS THAT HAVE CAMPAIGN FILTERS



$campaignList = json_decode($regCampJSON);
$campaignCount = count($campaignList);
$regCampaignsArray = array();

for ($campaignRow = 0; $campaignRow < $campaignCount; $campaignRow++) {

$each = $campaignList[$campaignRow];
$campaignArray = array();

      for ($testRow = 1; $testRow <= 10; $testRow++) {

      $property =  'campaign' . $testRow;

            if ($each->$property !== '') {

                  if (!isset($regCampaignsArray[$each->name])) {

                    $regCampaignsArray[$each->name] = array();
                  
                  }

            $campaignArray[] = $each->$property;
            $regCampaignsArray[$each->name] = $campaignArray; 

            } 
      }
}

$accounts = json_decode($regJSON);
$myCount = count($accounts);
$sheetArray = $cellFeed->toArray();
$arrayKeys = (array_keys($sheetArray));
$campaignsArrayCount = count($regCampaignsArray);
$countMarker = 0;



// SET REMAINING DAYS IN THE MONTH FOR FUTURE CALC



$pacingDays = (date("t") - (date("d") - 1));



echo "</br>EXTRACTING DATA FROM DOWNLOADED REPORTS";



// ITERATE OVER ACCOUNTS AND PULL DATA



for ($thisRow = 0; $thisRow < $myCount; $thisRow++) {



// SET ACCOUNT SPECIFIC INFO



    $campaignMarker = false;
    $codeNumber = $accounts[$thisRow]->code;
    $eachName = $accounts[$thisRow]->name;



// DETERMINE IF ACCOUNT NEEDS CAMPAIGN INFO



    for ($thisCampaignArrayRow = 0; $thisCampaignArrayRow < $campaignsArrayCount; $thisCampaignArrayRow++) {

        if (isset($regCampaignsArray[$eachName])) { 

            $thisTestCount = count($regCampaignsArray[$eachName]);

            for ($thisGranularCampaignArrayRow = 0; $thisGranularCampaignArrayRow < $thisTestCount; $thisGranularCampaignArrayRow++) {

                $indCampaignCount = count($regCampaignsArray[$eachName]);        
                $countMarker = 1;

            }
           
        }
    }



// PHPEXCEL OPEN SPREADSHEET 



    $objReader = new PHPExcel_Reader_CSV();  
    $objPHPExcel = $objReader->load("../Reports/SEIMReports/" . $accounts[$thisRow]->name .".csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();



// SEND TO ARRAY



    $clicksArray = array();
    $spendArray = array();

    $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
    $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5



// ITERATE THROUGH SPREADSHEET ARRAY AND PULL CLICKS AND SPEND DATA / DETERMINE CAMPAIGN INFO



    for ($row = 0; $row <= $highestRow; ++$row) {

        for ($col = 3; $col <= $highestColumnIndex; ++$col) {

        $contents = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        $contents2 = $objWorksheet->getCellByColumnAndRow(($col - 3), $row)->getValue();

            if ($countMarker == 1) {

                for ($indCampaignRow = 0; $indCampaignRow < $indCampaignCount; $indCampaignRow++) {

                    if (trim($contents2) == trim($regCampaignsArray[$eachName][$indCampaignRow])) {

                    $campaignMarker = true;
                    $clicks = $objWorksheet->getCellByColumnAndRow(($col - 2), $row)->getValue();
                    $spend = $objWorksheet->getCellByColumnAndRow(($col - 1), $row)->getValue();

                    $clicksArray[] = $clicks;
                    $spendArray[] = $spend;

                    }

                }

            }
            elseif ((stripos($contents, 'Search') !== false) || (stripos($contents2, 'Gmail') !== false)) { 

                  $clicks = $objWorksheet->getCellByColumnAndRow(($col - 2), $row)->getValue();
                  $spend = $objWorksheet->getCellByColumnAndRow(($col - 1), $row)->getValue();

                  $clicksArray[] = $clicks;
                  $spendArray[] = $spend;

            }
        }
    } 
              
    $countMarker = 0;



// SAVE TOTAL SPEND AND CLICKS IN VAR



    $clicksToDate = array_sum($clicksArray);
    $spendToDate = array_sum($spendArray);
    $spendToDate = $spendToDate / 1000000;

    $option = $accounts[$thisRow]->name;
    $filter = $accounts[$thisRow]->filter;



// OPEN 2ND REPORT FOR CROSS REFERENCE



    $objReader = new PHPExcel_Reader_CSV();                               
    $objPHPExcel = $objReader->load("../Reports/SEIMReports/" . $eachName . "Test.csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();



// SAVE CROSS REFERENCE FIGURES IN VAR



    $testSpend = $objWorksheet->getCellByColumnAndRow(1, 3)->getValue();
    $testAccount = $objWorksheet->getCellByColumnAndRow(2, 3)->getValue();
    $testDates = $objWorksheet->getCellByColumnAndRow(0, 1)->getValue();
    $testDates = substr($testDates, -26);
    $testSpend = $testSpend / 1000000;
    $testSpend = number_format($testSpend, 2, '.', '');
    $spendToDate = number_format($spendToDate, 2, '.', '');



// COMPARE FIGURES AND THROW ERROR FOR DISCREPENCY


           
    $errorName = $accounts[$thisRow]->name;
    $errorFilter = $accounts[$thisRow]->filter;
    $errorMessage = '';
    if ($testSpend != $spendToDate) {
        $errorMessage = "Google Warning: discrepency found between $errorName presumed entry: $spendToDate and $testAccount account total: $testSpend";
        if ($campaignMarker) {
            $errorMessage = "Campaign spend of total spend: $testSpend";
        }
    }



// FIND GOOGLE SHEET ROW THAT MATCHES ACCOUNT NAME



    $o = 0;
    foreach($sheetArray as $item)
    {
        foreach($item as $sub => $v)
        {
            if (($filter == "") && (isset($item[1])) && (stripos($item[1], trim($option)) !== false)) 
            {

            $googleSheetRow = $arrayKeys[$o];

            }
        }

    $o++;
    }



    echo "<br/>INSERTING SPEND DATA INTO SPREADSHEET"; 



    $letters = range('A', 'Z');
    $formulaColNet = $letters[$one+6];
    $formulaColSpend = $letters[$two-1];
       
    $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$clicksToDate"));
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$spendToDate"));
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$testAccount"));
    $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $five, "=($formulaColNet$googleSheetRow-$formulaColSpend$googleSheetRow)/$pacingDays"));
    $batchResponse = $cellFeed->insertBatch($batchRequest);

}


echo "<br/>All Done!";


?>