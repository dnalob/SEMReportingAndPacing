<?php 

require_once dirname(__FILE__) . '/Tier2Reports.php';
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../includes/db_conn.php';
require_once dirname(__FILE__) . '/../includes/T2_reg_accounts_google.php'; 



// CHECK FOR GREEN LIGHT



while (!isset($lastItem)) {
  sleep(1);
}


echo "</br>MASSAGING DATA FROM DOWNLOADED REPORTS FOR REGULAR ACCOUNTS";



// ITERATE OVER ACCOUNTS AND PULL DATA



$accounts = json_decode($regJSON);
$myCount = count($accounts);

for ($accountsRow = 0; $accountsRow < $myCount; $accountsRow++) {


// SET ACCOUNT SPECIFIC INFO


    $accountName = (string)$accounts[$accountsRow]->name;		
    

// PHPEXCEL OPEN SPREADSHEET


	$objReader = new PHPExcel_Reader_CSV();
	$objPHPExcel = $objReader->load("../Reports/GoogleT2Reports/$accountName.csv");
	$objWorksheet = $objPHPExcel->getActiveSheet();

	$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5


// ITERATE THROUGH SPREADSHEET ARRAY AND MASSAGE DATA


	for ($row = 3; $row <= $highestRow; ++$row) {
		for ($col = 6; $col <= $highestColumnIndex; ++$col) {
			$eachcol = $objWorksheet->getCellByColumnAndRow(($col - 2), $row)->getValue();
			$objWorksheet->getCellByColumnAndRow($col, $row)->setValue("=$eachcol/1000000");
		}
	}

	$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

	for ($row = 3; $row <= $highestRow; ++$row) {
		for ($col = 7; $col <= $highestColumnIndex; ++$col) {
			$eachcol = $objWorksheet->getCellByColumnAndRow(($col - 2), $row)->getValue();
			$objWorksheet->getCellByColumnAndRow($col, $row)->setValue("=$eachcol/1000000");
		}
	}

	$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

	for ($row = 3; $row <= $highestRow; ++$row) {
		for ($col = 8; $col <= $highestColumnIndex; ++$col) {
			$eachcol = $objWorksheet->getCellByColumnAndRow(($col - 2), $row)->getCalculatedValue();
			$objWorksheet->getCellByColumnAndRow($col, $row)->setValue($eachcol);
			$objWorksheet->getStyleByColumnAndRow($col, $row)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
			$objWorksheet->getStyleByColumnAndRow( 1 , $row )->getNumberFormat()->setFormatCode('#,##0');
		}
	}

	$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

	for ($row = 3; $row <= $highestRow; ++$row) {
		for ($col = 9; $col <= $highestColumnIndex; ++$col) {
			$eachcol = $objWorksheet->getCellByColumnAndRow(($col - 2), $row)->getCalculatedValue();
			$objWorksheet->getCellByColumnAndRow($col, $row)->setValue($eachcol);
			$objWorksheet->getStyleByColumnAndRow($col, $row)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
			$objWorksheet->getStyleByColumnAndRow( 2 , $row )->getNumberFormat()->setFormatCode('#,##0');
		}
	}

	$objWorksheet->removeColumnByIndex(4, 4);
	$objWorksheet->removeRow($highestRow);
	$highestRow = $objWorksheet->getHighestRow();
	$objWorksheet->removeRow(1,2);
	$objWorksheet->getColumnDimension("A","B","C","D","E")->setAutoSize(true);


// SAVE DATA IN NEW SPREADSHEET


	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save("../Reports/GoogleT2ReportsExt/$accountName.xlsx");
	echo date('H:i:s') , " File written to accountName.xslx";

}



// SCAN DIRECTORY AND GET READY TO ZIP THEM IN A FILE



$dir    = '../Reports/GoogleT2ReportsExt/';
$files_to_zip = scandir($dir);
$archiveCount = count($files_to_zip);


// ZIP FILES


$zip = new ZipArchive;
$res = $zip->open('../Reports/GoogleT2Reports/GoogleT2Reports.zip', ZipArchive::CREATE);

if ($res === TRUE) {
	for ($archiveRow = 0; $archiveRow < $archiveCount; $archiveRow++) {

		$newFile = $files_to_zip[$archiveRow];
		echo $newFile;

		if (!is_dir($newFile)) {
		$zip->addFile("../Reports/GoogleT2ReportsExt/$newFile", "$newFile");
		}

	}
    $zip->close();
} else {
    switch($res){
        case ZipArchive::ER_EXISTS: 
            $ErrMsg = "File already exists.";
            break;

        case ZipArchive::ER_INCONS: 
            $ErrMsg = "Zip archive inconsistent.";
            break;
            
        case ZipArchive::ER_MEMORY: 
            $ErrMsg = "Malloc failure.";
            break;
            
        case ZipArchive::ER_NOENT: 
            $ErrMsg = "No such file.";
            break;
            
        case ZipArchive::ER_NOZIP: 
            $ErrMsg = "Not a zip archive.";
            break;
            
        case ZipArchive::ER_OPEN: 
            $ErrMsg = "Can't open file.";
            break;
            
        case ZipArchive::ER_READ: 
            $ErrMsg = "Read error.";
            break;
            
        case ZipArchive::ER_SEEK: 
            $ErrMsg = "Seek error.";
            break;
        
        default: 
            $ErrMsg = "Unknow (Code $rOpen)";
            break; 
    }
    
    die( 'ZipArchive Error: ' . $ErrMsg);
}



// FETCH EMAIL FROM SESSION DATA



$sessionEmail = find_email($mysqli);

if (login_check($mysqli) == true) {
    echo "Check your Email.";
} else {
    echo "You are not logged in.";
}

 

// SEND EMAIL WITH ZIPPED KEYWORD REPORTS TO LOGGED IN USER




//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->SMTPDebug = 2;
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "";
//Password to use for SMTP authentication
$mail->Password = "";
//Set who the message is to be sent from
$mail->setFrom('', '');
//Set an alternative reply-to address
$mail->addReplyTo('');
//Set who the message is to be sent to
$mail->addAddress("$sessionEmail", "$_SESSION[username]");
//Set the subject line
$mail->Subject = 'Google Tier 2 Reports';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually

$mail->Body = "Hi $_SESSION[username],

     Please find the attached ZIP archive of the Tier 2 reports for last month.

     ";

$mail->addAttachment('../Reports/GoogleT2Reports/GoogleT2Reports.zip'); 

if (!$mail->send()) {

    echo "Mailer Error: " . $mail->ErrorInfo;

} else {

    echo "Message sent!";
	echo "<script type=\"text/javascript\">window.location.href = '';</script>";
}

?>