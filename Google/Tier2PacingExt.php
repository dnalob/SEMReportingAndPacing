<?php

date_default_timezone_set('America/Chicago');

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once dirname(__FILE__) . '/Tier2Pacing.php'; 
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../includes/db_conn.php';
require_once dirname(__FILE__) . '/../includes/T2_lux_accounts_google.php'; 
require_once dirname(__FILE__) . '/../includes/T2_reg_accounts_google.php'; 



// CHECK FOR GREEN LIGHT



while (!isset($lastItem)) {
	sleep(1);
}



// PREP GOOGLE SHEETS FOR ACCOUNT SEARCH AND DATA EXTRACTION



$accounts = json_decode($regJSON);
$luxAccounts = json_decode($luxJSON);
$myCount = count($accounts);
$sheetArray = $cellFeed->toArray();
$arrayKeys = (array_keys($sheetArray));



echo "</br>EXTRACTING DATA FROM DOWNLOADED REPORTS FOR REGULAR ACCOUNTS";



// ITERATE OVER ACCOUNTS AND PULL DATA



for ($thisRow = 0; $thisRow < $myCount; $thisRow++) {

	
// PHPEXCEL OPEN SPREADSHEET


	$objReader = new PHPExcel_Reader_CSV();
	$objPHPExcel = $objReader->load("../Reports/GoogleT2Pacing/" . $accounts[$thisRow]->name . ".csv");
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

			if ((stripos($contents, 'Search') !== false) || (stripos($contents2, 'Gmail') !== false)) {

				$clicks = $objWorksheet->getCellByColumnAndRow(($col - 2), $row)->getValue();
				$spend = $objWorksheet->getCellByColumnAndRow(($col - 1), $row)->getValue();

				$clicksArray[] = $clicks;
				$spendArray[] = $spend;

			}
		}
	}


// SAVE TOTAL SPEND AND CLICKS IN VAR


	$clicksToDate = array_sum($clicksArray);
	$spendToDate = array_sum($spendArray);
	$spendToDate = $spendToDate / 1000000;


// SET ACCOUNT SPECIFIC INFO


	$option = $accounts[$thisRow]->name;
	$filter = $accounts[$thisRow]->filter;


// OPEN 2ND REPORT FOR CROSS REFERENCE


	$objReader = new PHPExcel_Reader_CSV();			
	$objPHPExcel = $objReader->load("../Reports/GoogleT2Pacing/" . $option . "Test.csv");
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
		elseif (($filter == "") && (isset($item[1])) && (stripos($item[1], trim($option)) !== false)) 
		{

			$googleSheetRow = $arrayKeys[$o];

		}

	}
	
	$o++;
} 



echo "<br/>INSERTING SPEND DATA INTO SPREADSHEET";



	$letters = range('A', 'Z');
	$formulaColClicks = $letters[$one-1];
	$formulaColSpend = $letters[$two-1];

	if ($filter !== "") {
		$rowBelow = $googleSheetRow + 1;
		$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "=$clicksToDate-$formulaColClicks$rowBelow"));
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "=$spendToDate-$formulaColSpend$rowBelow"));
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$testAccount"));
		$batchResponse = $cellFeed->insertBatch($batchRequest);
	}
	else {
		$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$clicksToDate"));
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$spendToDate"));
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
		$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$testAccount"));
		$batchResponse = $cellFeed->insertBatch($batchRequest);
	}

}



echo "</br>EXTRACTING DATA FROM DOWNLOADED REPORTS FOR LUXURY ACCOUNTS";



$myCount = count($luxAccounts);

for ($thisRow = 0; $thisRow < $myCount; $thisRow++) {


// SET ACCOUNT SPECIFIC INFO


	$option = $luxAccounts[$thisRow]->name;
	$filter = $luxAccounts[$thisRow]->filter;


// PHPEXCEL OPEN SPREADSHEET

	
	$objReader = new PHPExcel_Reader_CSV();
	$objPHPExcel = $objReader->load("../Reports/GoogleT2Pacing/lux" . $luxAccounts[$thisRow]->name . ".csv");
	$objWorksheet = $objPHPExcel->getActiveSheet();


// SEND TO ARRAY


	$clicksArray = array();
	$spendArray = array();

	$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5


// ITERATE THROUGH SPREADSHEET ARRAY AND PULL CLICKS AND SPEND DATA / DETERMINE CAMPAIGN INFO


	for ($row = 1; $row <= $highestRow; ++$row) {
		for ($col = 0; $col <= $highestColumnIndex; ++$col) {

			$contents = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				
			if ((stripos($contents, 'Account')) !== false) {
		 		$specialRow = ($row + 1);
			}


			if ( (($filter === "Luxury") || ($filter === "luxury")) && (stripos($contents, 'genesis coupe') === false) && (stripos($contents, 'genesis') !== false) || (stripos($contents, 'equus') !== false) || (stripos($contents, 'Luxury') !== false)) {

				$clicks = $objWorksheet->getCellByColumnAndRow(($col + 1), $row)->getValue();
				$spend = $objWorksheet->getCellByColumnAndRow(($col + 2), $row)->getValue();
				$clicksArray[] = $clicks;
				$spendArray[] = $spend;
				$errorMessage = "Luxury";
			}


			if ( (($filter === "Honda") || ($filter === "honda")) && (stripos($contents, 'honda') !== false)) {

				$clicks = $objWorksheet->getCellByColumnAndRow(($col + 1), $row)->getValue();
				$spend = $objWorksheet->getCellByColumnAndRow(($col + 2), $row)->getValue();
				$clicksArray[] = $clicks;
				$spendArray[] = $spend;
				$errorMessage = "Honda";
			} 
		}
	}


// SAVE TOTAL SPEND AND CLICKS IN VAR


	$luxClicks = array_sum($clicksArray);
	$luxSpend = array_sum($spendArray);
	$luxSpend = $luxSpend / 1000000;
	$testAccount = $objWorksheet->getCell("E$specialRow")->getValue();


// FIND GOOGLE SHEET ROW THAT MATCHES ACCOUNT NAME


	$o = 0;
	foreach($sheetArray as $item)
	{
		foreach($item as $sub => $v)
		{
			if (($filter !== "") && (isset($item[1])) && ((stripos($item[1], trim($option)) !== false)) && (stripos($item[2], trim($filter)) !== false))
			{

				$googleSheetRow = $arrayKeys[$o];

			}
			elseif (($filter == "") && (isset($item[1])) && (stripos($item[1], trim($option)) !== false)) {

				$googleSheetRow = $arrayKeys[$o];

			}

		}
		
		$o++;
	}



	echo "<br/>INSERTING SPEND DATA INTO SPREADSHEET"; 


					
	$batchRequest = new Google\Spreadsheet\Batch\BatchRequest();
	$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $one, "$luxClicks"));
	$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $two, "$luxSpend"));
	$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $three, "$errorMessage"));
	$batchRequest->addEntry($cellFeed->createInsertionCell($googleSheetRow, $four, "$testAccount"));
	$batchResponse = $cellFeed->insertBatch($batchRequest);

}


echo "<br/>All Done!";


?>