<?php include_once '../includes/functions.php';

session_start();

// // The BingAds OAuth access token will be in session data. This is the token used
// // to access BingAds data on behalf of the customer.
$accessToken = $_SESSION['access_token'];
$refreshToken = $_SESSION['refresh_token'];

session_destroy();
sec_session_start();

printf("Implement code to retrieve data with access token: %s", $accessToken);
printf("Implement code to retrieve data with access token: %s", $refreshToken);

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../includes/T2_reg_accounts_bing.php';
require_once '../includes/db_connect.php';
require_once '../vendor/phpmailer/PHPMailerAutoload.php';

// Include the Bing Ads namespaced class files available
// for download at http://go.microsoft.com/fwlink/?LinkId=322147
include '../vendor/bing/PHP/Bing Ads API in PHP/v9/bingads/ReportingClasses.php';
include '../vendor/bing/PHP/Bing Ads API in PHP/v9/bingads/ClientProxy.php';

// Specify the BingAds\Reporting objects that will be used.
use BingAds\Reporting\SubmitGenerateReportRequest;
use BingAds\Reporting\KeywordPerformanceReportRequest;
use BingAds\Reporting\ReportFormat;
use BingAds\Reporting\ReportAggregation;
use BingAds\Reporting\AccountThroughAdGroupReportScope;
use BingAds\Reporting\CampaignReportScope;
use BingAds\Reporting\ReportTime;
use BingAds\Reporting\ReportTimePeriod;
use BingAds\Reporting\Date;
use BingAds\Reporting\KeywordPerformanceReportFilter;
use BingAds\Reporting\DeviceTypeReportFilter;
use BingAds\Reporting\KeywordPerformanceReportColumn;
use BingAds\Reporting\PollGenerateReportRequest;
use BingAds\Reporting\ReportRequestStatusType;
use BingAds\Reporting\KeywordPerformanceReportSort;
use BingAds\Reporting\SortOrder;
use BingAds\Reporting\AccountPerformanceReportRequest;
use BingAds\Reporting\AccountReportScope;
use BingAds\Reporting\AccountPerformanceReportColumn;
use BingAds\Reporting\CampaignPerformanceReportColumn;
use BingAds\Reporting\CampaignPerformanceReportRequest;
use BingAds\Reporting\AccountPerformanceReportFilter;

// Specify the BingAds\Proxy object that will be used.
use BingAds\Proxy\ClientProxy;

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('America/Chicago');



// GOOGLE ADWORDS API REPORTING FUNCTIONS



// Request the report. Use the ID that the request returns to
// check for the completion of the report.

function SubmitGenerateReport($proxy, $report)
{
    // Set the request information.
    
    $request = new SubmitGenerateReportRequest();
    $request->ReportRequest = $report;

    return $proxy->GetService()->SubmitGenerateReport($request)->ReportRequestId;
}

// Check the status of the report request. The guidance of how often to poll
// for status is from every five to 15 minutes depending on the amount
// of data being requested. For smaller reports, you can poll every couple
// of minutes. You should stop polling and try again later if the request
// is taking longer than an hour.

function PollGenerateReport($proxy, $reportRequestId)
{
    // Set the request information.
    
    $request = new PollGenerateReportRequest();
    $request->ReportRequestId = $reportRequestId;

    return $proxy->GetService()->PollGenerateReport($request)->ReportRequestStatus;
}

// Using the URL that the PollGenerateReport operation returned,
// send an HTTP request to get the report and write it to the specified
// ZIP file.

function DownloadFile($reportDownloadUrl, $downloadPath)
{
    if (!$reader = fopen($reportDownloadUrl, 'rb'))
    {
        throw new Exception("Failed to open URL " . $reportDownloadUrl . ".");
    }

    if (!$writer = fopen($downloadPath, 'wb'))
    {
        fclose($reader);
        throw new Exception("Failed to create ZIP file " . $downloadPath . ".");
    }

    $bufferSize = 100 * 1024;

    while (!feof($reader))
    {
        if (false === ($buffer = fread($reader, $bufferSize)))
        {
             fclose($reader);
             fclose($writer);
             throw new Exception("Read operation from URL failed.");
        }

        if (fwrite($writer, $buffer) === false)
        {
             fclose($reader);
             fclose($writer);
             $exception = new Exception("Write operation to ZIP file failed.");
        }
    }

    fclose($reader);
    fflush($writer);
    fclose($writer);
}



// ACCOUNT PERFORMANCE REPORT FUNCTION



function GetKeywordPerformanceReportRequest($proxy, $AccountId) 
{
    $report = new KeywordPerformanceReportRequest();
    
    $report->Format = ReportFormat::Csv;
    $report->ReportName = 'My Keyword Performance Report';
    $report->ReturnOnlyCompleteData = false;
    $report->Aggregation = ReportAggregation::Daily;
    
    $report->Scope = new AccountReportScope();
    $report->Scope->AccountIds = array();
    $report->Scope->AccountIds[] = $AccountId;
        
    $report->Time = new ReportTime();
    // $report->Time->PredefinedTime = ReportTimePeriod::Custom date range;
    
    //  You may either use a custom date range or predefined time.

     // $report->Time->CustomDateRangeStart = new Date();
     // $report->Time->CustomDateRangeStart->Month = date('n');
     // $report->Time->CustomDateRangeStart->Day = 1;
     // $report->Time->CustomDateRangeStart->Year = date('Y');
     // $report->Time->CustomDateRangeEnd = new Date();
     // $report->Time->CustomDateRangeEnd->Month = date('n');
     // $report->Time->CustomDateRangeEnd->Day = date('j');
     // $report->Time->CustomDateRangeEnd->Year = date('Y');
    


// SET DATE RANGE TO PREVIOUS MONTH



    $lowMonth = date('n', strtotime('previous month'));
    $highMonth = date('t', strtotime('previous month'));
    $thisYear = date('Y', strtotime('previous month'));

     $report->Time->CustomDateRangeStart = new Date();
     $report->Time->CustomDateRangeStart->Month = $lowMonth;
     $report->Time->CustomDateRangeStart->Day = 1;
     $report->Time->CustomDateRangeStart->Year = $thisYear;
     $report->Time->CustomDateRangeEnd = new Date();
     $report->Time->CustomDateRangeEnd->Month = $lowMonth;
     $report->Time->CustomDateRangeEnd->Day = $highMonth;
     $report->Time->CustomDateRangeEnd->Year = $thisYear;

    //  If you specify a filter, results may differ from data you see in the Bing Ads web application
    //  $report->Filter = new AccountPerformanceReportFilter();
    //  $report->Filter->DeviceType = array (
    //      DeviceTypeReportFilter::Computer,
    //      DeviceTypeReportFilter::SmartPhone
    //  );

    $report->Columns = array (
            // AccountPerformanceReportColumn::TimePeriod,
            // AccountPerformanceReportColumn::AccountId,
            KeywordPerformanceReportColumn::Keyword,
            KeywordPerformanceReportColumn::Clicks,
            KeywordPerformanceReportColumn::Impressions,
            KeywordPerformanceReportColumn::Ctr,
            KeywordPerformanceReportColumn::AverageCpc,
            KeywordPerformanceReportColumn::Spend,
    );
    
    $encodedReport = new SoapVar($report, SOAP_ENC_OBJECT, 'KeywordPerformanceReportRequest', $proxy->GetNamespace());
    
    return $encodedReport;
}



// EMPTY DESTINATION FOLDERS OF OLD REPORTS



$files = glob(dirname(__FILE__) . '/../Reports/BingT2Reports/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}
$files = glob(dirname(__FILE__) . '/../Reports/BingT2Reports2/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}
$files = glob(dirname(__FILE__) . '/../Reports/BingT2ReportsExt/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}



echo "<br/>FETCHING ACCOUNT LIST FROM DATABASE";



$accounts = json_decode($regJSON);
$myCount = count($accounts);



echo "<br/>ITERATING OVER REGULAR ACCOUNT LIST AND DOWNLOADING REPORTS";



for ($row = 0; $row < $myCount; $row++) {

    // SET SPECIFIC ACCOUNT DETAILS

    $AccountId = (string)$accounts[$row]->code;
    $bingName = (string)$accounts[$row]->name;
     
    // Disable WSDL caching.

    ini_set("soap.wsdl_cache_enabled", "0");
    ini_set("soap.wsdl_cache_ttl", "0");

    // Specify your credentials.

    // $UserName = $accessToken;
    // $Password = $refreshToken;
    $DeveloperToken = "";
    $CustomerId = "";

    // Reporting WSDL.

    $wsdl = "https://api.bingads.microsoft.com/Api/Advertiser/Reporting/V9/ReportingService.svc?singleWsdl";

    // Specify the file to download the report to. Because the file is
    // compressed use the .zip file extension.

    $DownloadPath = "../Reports/BingT2Reports/" . $bingName . ".zip";



    // REQUEST KEYWORD REPORT



    try
    {
        // For Managing User Authentication with OAuth, replace the UserName and Password elements with the AuthenticationToken, which is your OAuth access token.
        $proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, null, null, $DeveloperToken, $AccountId, $CustomerId, $accessToken);
        
        // You can submit one of the example reports, or build your own.
        $report = GetKeywordPerformanceReportRequest($proxy, $AccountId);
        // $report = GetAudiencePerformanceReportRequest($proxy, $AccountId);
        //$report = GetKeywordPerformanceReportRequest($proxy, $AccountId);
        
        // SubmitGenerateReport helper method calls the corresponding Bing Ads service operation
        // to request the report identifier. The identifier is used to check report generation status
        // before downloading the report.
        
        $reportRequestId = SubmitGenerateReport(
                $proxy, 
                $report
                );
        
        printf("Report Request ID: %s\n\n", $reportRequestId);
        
         
        $reportRequestStatus = null;
        
        // This sample polls every 30 seconds up to 5 minutes.
        // In production you may poll the status every 1 to 2 minutes for up to one hour.
        // If the call succeeds, stop polling. If the call or 
        // download fails, the call throws a fault.
        
        for ($i = 0; $i < 1000; $i++)
        {
            sleep(1);
        
            // PollGenerateReport helper method calls the corresponding Bing Ads service operation
            // to get the report request status.
            
            $reportRequestStatus = PollGenerateReport(
                    $proxy, 
                    $reportRequestId
                    );
        
            if ($reportRequestStatus->Status == ReportRequestStatusType::Success ||
                $reportRequestStatus->Status == ReportRequestStatusType::Error)
            {
                break;
            }
        }

        if ($reportRequestStatus != null)
        {
            if ($reportRequestStatus->Status == ReportRequestStatusType::Success)
            {
                $reportDownloadUrl = $reportRequestStatus->ReportDownloadUrl;
                printf("Downloading from %s.\n\n", $reportDownloadUrl);
                DownloadFile($reportDownloadUrl, $DownloadPath);
                printf("The report was written to %s.\n", $DownloadPath);



// ZIP AND RENAME CONTENTS TO MATCH ACCOUNT



                $zip = new ZipArchive;
                $res = $zip->open("../Reports/BingT2Reports/" . $bingName . ".zip");
                if ($res === TRUE) {

                  $filename = $zip->getNameIndex(0);
                  $zip->renameName($filename, $bingName . ".csv");
                  $zip->extractTo('../Reports/BingT2Reports2/', $bingName . ".csv");
                  $zip->close();

                } else {
                  echo 'doh!';
                }

                $dir    = '../Reports/BingT2Reports2/';
                $files = scandir($dir);
                $thisCount = count($files);
                $thisFile = $thisCount - 1;

                

            }
            else if ($reportRequestStatus->Status == ReportRequestStatusType::Error)
            {
                printf("The request failed. Try requesting the report " .
                        "later.\nIf the request continues to fail, contact support.\n");
            }
            else  // Pending
            {
                printf("The request is taking longer than expected.\n " .
                        "Save the report ID (%s) and try again later.\n",
                        $reportRequestId);
            }
        }
        
    }
    catch (SoapFault $e)
    {
        // Output the last request/response.

        print "\nLast SOAP request/response:\n";
        print $proxy->GetWsdl() . "\n";
        print $proxy->GetService()->__getLastRequest()."\n";
        print $proxy->GetService()->__getLastResponse()."\n";
         
        // Reporting service operations can throw AdApiFaultDetail.
        if (isset($e->detail->AdApiFaultDetail))
        {
            // Log this fault.

            print "The operation failed with the following faults:\n";

            $errors = is_array($e->detail->AdApiFaultDetail->Errors->AdApiError)
            ? $e->detail->AdApiFaultDetail->Errors->AdApiError
            : array('AdApiError' => $e->detail->AdApiFaultDetail->Errors->AdApiError);

            // If the AdApiError array is not null, the following are examples of error codes that may be found.
            foreach ($errors as $error)
            {
                print "AdApiError\n";
                printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

                switch ($error->Code)
                {
                    case 0:    // InternalError
                        break;
                    case 105:  // InvalidCredentials
                        break;
                    default:
                        print "Please see MSDN documentation for more details about the error code output above.\n";
                        break;
                }
            }
        }

        // Reporting service operations can throw ApiFaultDetail.
        elseif (isset($e->detail->ApiFaultDetail))
        {
            // Log this fault.

            print "The operation failed with the following faults:\n";

            // If the BatchError array is not null, the following are examples of error codes that may be found.
            if (!empty($e->detail->ApiFaultDetail->BatchErrors))
            {
                $errors = is_array($e->detail->ApiFaultDetail->BatchErrors->BatchError)
                ? $e->detail->ApiFaultDetail->BatchErrors->BatchError
                : array('BatchError' => $e->detail->ApiFaultDetail->BatchErrors->BatchError);

                foreach ($errors as $error)
                {
                    printf("BatchError at Index: %d\n", $error->Index);
                    printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

                    switch ($error->Code)
                    {
                        case 0:     // InternalError
                            break;
                        default:
                            print "Please see MSDN documentation for more details about the error code output above.\n";
                            break;
                    }
                }
            }

            // If the OperationError array is not null, the following are examples of error codes that may be found.
            if (!empty($e->detail->ApiFaultDetail->OperationErrors))
            {
                $errors = is_array($e->detail->ApiFaultDetail->OperationErrors->OperationError)
                ? $e->detail->ApiFaultDetail->OperationErrors->OperationError
                : array('OperationError' => $e->detail->ApiFaultDetail->OperationErrors->OperationError);

                foreach ($errors as $error)
                {
                    print "OperationError\n";
                    printf("Code: %d\nError Code: %s\nMessage: %s\n", $error->Code, $error->ErrorCode, $error->Message);

                    switch ($error->Code)
                    {
                        case 0:     // InternalError
                            break;
                        case 106:   // UserIsNotAuthorized
                            break;
                        case 2100:  // ReportingServiceInvalidReportId
                            break;
                        default:
                            print "Please see MSDN documentation for more details about the error code output above.\n";
                            break;
                    }
                }
            }
        }
    }
    catch (Exception $e)
    {
        if ($e->getPrevious())
        {
            ; // Ignore fault exceptions that we already caught.
        }
        else
        {
            print $e->getCode()." ".$e->getMessage()."\n\n";
            print $e->getTraceAsString()."\n\n";
        }
    }
}



echo "</br>ALL REPORTS DOWNLOADED";



////////////////////////////////////////////////////////////////////////////////



echo "</br>MASSAGING DATA FROM DOWNLOADED REPORTS";



// ITERATE OVER ACCOUNTS AND MASSAGE DATA



for ($thisRow = 0; $thisRow < $myCount; $thisRow++) {
	
    $accountName = $accounts[$thisRow]->name;



// PHPEXCEL OPEN SPREADSHEET 



    $objReader = new PHPExcel_Reader_CSV();
    $objPHPExcel = $objReader->load("../Reports/BingT2Reports2/" . $accountName . ".csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();



// SEND TO ARRAY



    $sheetArray = $objWorksheet->toArray();



// REMOVE 0 CLICKS FROM REPORT



    for ($i = 0; $i < count($sheetArray); ++$i) {

    $contents = $sheetArray[$i][1];

        if ($contents == 0) {
            
            array_splice($sheetArray,$i,1, ARRAY(NULL));
        }    

    }



// CLEAN KEYS



    $sheetArray = (array_filter($sheetArray));



// CREATE NEW PHPEXCEL OBJECT



    $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
    $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

    $objPHPExcel->disconnectWorksheets();
    $objPHPExcel->createSheet();
    $objWorksheet = $objPHPExcel->getActiveSheet();



// FORMAT AND SAVE REPORT



    $howManyRows = count($sheetArray);

    $objWorksheet->fromArray($sheetArray, NULL, 'A1');
    $objWorksheet->getStyle('E1:E' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('F1:F' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('B1:B' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');
    $objWorksheet->getStyle('C1:C' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');
    $objWorksheet->getStyle('D1:D' . $howManyRows)->getNumberFormat()->setFormatCode('0.00"%"');

	echo date('H:i:s') , " Write to XLSX format" , EOL;
	$callStartTime = microtime(true);

	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save("../Reports/BingT2ReportsExt/$accountName.xlsx");

	$callEndTime = microtime(true);
	$callTime = $callEndTime - $callStartTime;

	echo date('H:i:s') , " File written to $accountName.xslx" , EOL;
	echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
	// Echo memory usage
	echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

	// Echo memory peak usage
	echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

	// Echo done
	echo date('H:i:s') , " Done writing files" , EOL;
	echo 'Files have been created in ' , getcwd() , EOL;
}



echo "</br>ZIPPING REPORTS";



$dir    = '../Reports/BingT2ReportsExt/';
$files_to_zip = scandir($dir);
$archiveCount = count($files_to_zip);
$zip = new ZipArchive;
$res = $zip->open('../Reports/BingT2Reports/BingT2Reports.zip', ZipArchive::CREATE);

if ($res === TRUE) {
    for ($archiveRow = 0; $archiveRow < $archiveCount; $archiveRow++) {

        $newFile = $files_to_zip[$archiveRow];

        if (!is_dir($newFile)) {
            $zip->addFile("../Reports/BingT2ReportsExt/$newFile", "$newFile");
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



echo "</br>EMAILING REPORTS";



$sessionEmail = find_email($mysqli);

if (login_check($mysqli) == true) {
    echo "Check your Email.";
} else {
    echo "You are not logged in.";
}

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
$mail->addReplyTo('', '');
//Set who the message is to be sent to
$mail->addAddress("$sessionEmail", "$_SESSION[username]");
//Set the subject line
$mail->Subject = 'Bing Tier 2 Reports';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually

$mail->Body = "Hi $_SESSION[username],

     Please find the attached ZIP archive of the Tier 2 reports for last month.

     ";

$mail->addAttachment('../Reports/BingT2Reports/BingT2Reports.zip'); 

//$mail->AltBody = 'This is a plain-text messagtrahhhdbethsrthe body';
//Attach an image file
//                 $mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors

if (!$mail->send()) {

    echo "Mailer Error: " . $mail->ErrorInfo;

} else {

    echo "Message sent!";

    echo "<script type=\"text/javascript\">window.location.href = '';</script>";

}

?>