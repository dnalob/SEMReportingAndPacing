<?php

date_default_timezone_set('America/Chicago');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once dirname(__FILE__) . '/Tier3Pacing.php'; 
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../includes/db_conn.php';
require_once dirname(__FILE__) . '/../includes/T3_reg_accounts_google.php'; 
require_once dirname(__FILE__) . '/../includes/T3_reg_campaigns_google.php';   



// CHECK FOR GREEN LIGHT



while (!isset($lastItem)) {
  sleep(1);
}



echo "<br/>FETCH CAMPAIGN LIST AND PULL INTO ARRAY";



$campaignList = json_decode($regCampJSON);
$campaignCount = count($campaignList);
$regCampaignsArray = array();

for ($campaignRow = 0; $campaignRow < $campaignCount; $campaignRow++) {

    $each = $campaignList[$campaignRow];
    $campaignnArray = array();

    for ($testRow = 1; $testRow <= 10; $testRow++) {

        $property =  'campaign' . $testRow;

        if ($each->$property !== '') {

            if (!isset($regCampaignsArray[$each->code])) {

                $regCampaignsArray[$each->code] = array();

            }

        $regCampaignsArray[$each->code][$each->filter] = array();
        $campaignnArray[] = $each->$property; 
        $regCampaignsArray[$each->code][$each->filter] = $campaignnArray; 

        } 
    }
}


// SEND TO ARRAY


$myCount = count($accounts);
$sheetArray = $cellFeed->toArray();
$arrayKeys = (array_keys($sheetArray));
$campaignsArrayCount = count($regCampaignsArray);
$countMarker = 0;


// ITERATE THROUGH SPREADSHEET ARRAY AND PULL CLICKS AND SPEND DATA / DETERMINE CAMPAIGN INFO


for ($thisRow = 0; $thisRow < $myCount; $thisRow++) {


    // SET ACCOUNT SPECIFIC INFO


    $markAsTwin = FALSE;
    $codeNumber = $accounts[$thisRow]->code;
    $eachFilter = $accounts[$thisRow]->filter;


    // DETERMINE IF ACCOUNT NEEDS CAMPAIGN INFO


    for ($thisCampaignArrayRow = 0; $thisCampaignArrayRow < $campaignsArrayCount; $thisCampaignArrayRow++) {

      if (isset($regCampaignsArray[$codeNumber])) { 

        $thisTestCount = count($regCampaignsArray[$codeNumber]);

           for ($thisGranularCampaignArrayRow = 0; $thisGranularCampaignArrayRow < $thisTestCount; $thisGranularCampaignArrayRow++) {

              if (isset($regCampaignsArray[$codeNumber][$eachFilter]) || isset($regCampaignsArray[$codeNumber][strtolower($eachFilter)])) {

                    $indCampaignCount = count($regCampaignsArray[$codeNumber][$eachFilter]);

                      $countMarker = 1;

                }
            }
        }
    }



// PHPEXCEL OPEN SPREADSHEET 



    $objReader = new PHPExcel_Reader_CSV();
    $objPHPExcel = $objReader->load("../Reports/GoogleT3Pacing/" . $accounts[$thisRow]->name . $accounts[$thisRow]->filter .".csv");
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

                $markAsTwin = TRUE;

                for ($indCampaignRow = 0; $indCampaignRow < $indCampaignCount; $indCampaignRow++) {
              
                    if (trim($contents2) == trim($regCampaignsArray[$codeNumber][$eachFilter][$indCampaignRow])) {

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


// SAVE ACCOUNT SPECIFIC DETAILS IN VAR FOR GOOGLE SHEETS INSERTION


    $option = $accounts[$thisRow]->name;
    $filter = $accounts[$thisRow]->filter;



// OPEN 2ND REPORT FOR CROSS REFERENCE



    $objReader = new PHPExcel_Reader_CSV();      
    $objPHPExcel = $objReader->load("../Reports/GoogleT3Pacing/" . $accounts[$thisRow]->name . $accounts[$thisRow]->filter ."Test.csv");
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


    $errorMessage = "";
    $errorName = $accounts[$thisRow]->name;
    $errorFilter = $accounts[$thisRow]->filter;

    if ($testSpend != $spendToDate) {
        $errorMessage = "Google Warning: discrepency found between $errorName $errorFilter presumed entry: $spendToDate and $testAccount account total: $testSpend";
    }



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



    // DETERMINE DUPLICATE ACCOUNTS FOR FORMULA INSERTION



    if ($markAsTwin) {
      $errorMessage = "Campaign spend of total spend: $testSpend";
    }

    if ($accounts[$thisRow]->formula == 1) {



        echo "<br/>INSERTING FORMULA WITH SPEND DATA INTO SPREADSHEET"; 



        $findMyTwins = array();
        $y = 0;

        foreach($sheetArray as $item)
        {
            foreach($item as $sub => $v)
            {

                if ((isset($item[1])) && (stripos($item[1], trim($option)) !== false)) {

                    if(!in_array($arrayKeys[$y], $findMyTwins, true)){
                        array_push($findMyTwins, $arrayKeys[$y]);
                    }

                }

            }

        $y++;

        }
                                
        $pos = array_search($googleSheetRow, $findMyTwins);
        unset($findMyTwins[$pos]);
        $findMyTwins = array_values($findMyTwins);
        $twinCount = count($findMyTwins);



// IF THERE ARE FORMULAS SELECTED BY USER, FIND LETTER VALUE



        $letters = range('A', 'Z');
        $formulaColSpend = $letters[$one-1];
                                      
        if ($twinCount == 1) {
            $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$spendToDate-$formulaColSpend$findMyTwins[0]"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$errorMessage"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$testAccount"));
            $batchResponse = $cellFeed->insertBatch($batchRequest);
        }
        elseif ($twinCount == 2) {
            $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$spendToDate-$formulaColSpend$findMyTwins[0]-$formulaColSpend$findMyTwins[1]"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$errorMessage"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$testAccount"));
            $batchResponse = $cellFeed->insertBatch($batchRequest);
        }
        elseif ($twinCount == 3) {
            $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$spendToDate-$formulaColSpend$findMyTwins[0]-$formulaColSpend$findMyTwins[1]-$formulaColSpend$findMyTwins[2]"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$errorMessage"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$testAccount"));
            $batchResponse = $cellFeed->insertBatch($batchRequest);
        }
        elseif ($twinCount == 4) {
            $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$spendToDate-$formulaColSpend$findMyTwins[0]-$formulaColSpend$findMyTwins[1]-$formulaColSpend$findMyTwins[2]-$formulaColSpend$findMyTwins[3]"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$errorMessage"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$testAccount"));
            $batchResponse = $cellFeed->insertBatch($batchRequest);
        }
        elseif ($twinCount == 5) {
            $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$spendToDate-$formulaColSpend$findMyTwins[0]-$formulaColSpend$findMyTwins[1]-$formulaColSpend$findMyTwins[2]-$formulaColSpend$findMyTwins[3]-$formulaColSpend$findMyTwins[4]"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$errorMessage"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$testAccount"));
            $batchResponse = $cellFeed->insertBatch($batchRequest);
        }
        else {
            $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$spendToDate"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$errorMessage"));
            $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$testAccount"));
            $batchResponse = $cellFeed->insertBatch($batchRequest);
        }
    }
    else {


        echo "<br/>INSERTING SPEND DATA INTO SPREADSHEET"; 


        $batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$spendToDate"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$errorMessage"));
        $batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$testAccount"));
        $batchResponse = $cellFeed->insertBatch($batchRequest);
    }  
}

?>