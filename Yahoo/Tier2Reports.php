<?php include_once '../includes/functions.php';

sec_session_start();

date_default_timezone_set('America/Chicago');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../includes/T2_reg_accounts_yahoo.php';
require_once '../includes/db_connect.php';
require_once '../vendor/phpmailer/PHPMailerAutoload.php';
require "YahooOAuth2.class.php";



// EMPTY DESTINATION FOLDERS OF OLD REPORTS



$files = glob(dirname(__FILE__) . '/../Reports/YahooT2Reports/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}

$files = glob(dirname(__FILE__) . '/../Reports/YahooT2ReportsExt/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); 
}


// DEFINE OAUTH YAHOO DATA


#Your Yahoo API consumer key & secret with access to Gemini data 
// define("CONSUMER_KEY","dj0yJmk9NTFtMWFnU2l4TGtuJmQ9WVdrOU5FVmhSRFZQTkdjbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD0zZQ--");
define("");
define("");
$redirect_uri="http://".$_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];//Or your other redirect URL - must match the callback domain 



// FETCH ACCOUNTS AND CONVERT INTO ARRAY



$accounts = json_decode($regJSON);
$myCount = count($accounts);



// YAHOO OAUTH TOKENS



$gemini_api_endpoint="https://api.admanager.yahoo.com/v1/rest";
$oauth2client=new YahooOAuth2();

if (isset($_GET['code'])){
    $code=$_GET['code'];  
} 
else {
    $code=0;
}



// SET DATE RANGE TO LAST MONTH



$lowRange = date('Y-m-01', strtotime('previous month'));
$highRange = date('Y-m-t', strtotime('previous month'));
        
$accountNumber = (string)$accounts[0]->code;
$name = (string)$accounts[0]->name;


// DEFINE JSON TO BE SENT BY CURL TO GEMINI


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


// YAHOO OAUTH2 PROCESS


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


// PING GEMINI UNTIL REPORT IS READY


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

//Get the file
$content = file_get_contents("$jobResponse");

//Store in the filesystem.
$fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Reports/$name.csv", "w");
fwrite($fp, $content);
fclose($fp);


// OPEN PHPEXCEL SHEET AND SEND TO ARRAY


$objReader = new PHPExcel_Reader_CSV();
$objPHPExcel = $objReader->load("../Reports/YahooT2Reports/$name.csv");
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

    $adjustedArray[$x][1] = $performanceClicks;
    $adjustedArray[$x][2] = $performanceImp;
    $adjustedArray[$x][3] = $performanceCtr;
    $adjustedArray[$x][4] = $performanceCpc;
    $adjustedArray[$x][5] = $performanceSpend;

    ++$x;

} 


// CREATE BLANK SHEET AND LOAD STORED DATA


$objPHPExcel->disconnectWorksheets();
$objPHPExcel->createSheet();
$objWorksheet = $objPHPExcel->getActiveSheet();


$howManyRows = count($adjustedArray);
$objWorksheet->fromArray($adjustedArray, NULL, 'A1');

$objWorksheet->getStyle('E1:E' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');

$objWorksheet->getStyle('F1:F' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


$objWorksheet->getStyle('B1:B' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');
$objWorksheet->getStyle('C1:C' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');



// SAVE FILE



echo date('H:i:s') , " Write to XLSX format" , EOL;
$callStartTime = microtime(true);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save("../Reports/YahooT2ReportsExt/$name.xlsx");

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to Austin.xslx" , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , getcwd() , EOL;



// BEGIN ITERATTION THROUGH ACCOUNT LIST



for ($row = 1; $row < $myCount; $row++) {


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

    $accountNumber = (string)$accounts[$row]->code;
    $name = (string)$accounts[$row]->name;


// DEFINE JSON TO BE SENT VIA CURL


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


// GEMINI OAUTH PROCESS


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


// PING YAHOO UNTIL REPORT IS PREPARED


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
    $fp = fopen(dirname(__FILE__) . "/../Reports/YahooT2Reports/$name.csv", "w");
    fwrite($fp, $content);
    fclose($fp);


// OPEN PHPEXCEL FILE AND MASSAGE DATA


    $objReader = new PHPExcel_Reader_CSV();
    $objPHPExcel = $objReader->load("../Reports/YahooT2Reports/$name.csv");
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $performanceArray = $objWorksheet->toArray();

    $adjustedArray = array();

    $x = 0;

    for ($i = 1; $i < count($performanceArray); ++$i) {

        $landingUrl = $performanceArray[$i][10];
        $performanceClicks = $performanceArray[$i][5];
        $performanceImp = $performanceArray[$i][9];
        $performanceCtr = number_format((float)$performanceArray[$i][7] * 100, 2, '.', ',')  . '%';
        $performanceCpc = $performanceArray[$i][6];
        $performanceSpend = $performanceArray[$i][8];

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


        ++$x;

    } 

          

// CREATE BLANK SHEET AND STORE ARRAY VARS



    $objPHPExcel->disconnectWorksheets();
    $objPHPExcel->createSheet();
    $objWorksheet = $objPHPExcel->getActiveSheet();


    $howManyRows = count($adjustedArray);
    $objWorksheet->fromArray($adjustedArray, NULL, 'A1');

    $objWorksheet->getStyle('E1:E' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('F1:F' . $howManyRows)->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
    $objWorksheet->getStyle('B1:B' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');
    $objWorksheet->getStyle('C1:C' . $howManyRows)->getNumberFormat()->setFormatCode('#,##0');


// SAVE FILE


    echo date('H:i:s') , " Write to XLSX format" , EOL;
    $callStartTime = microtime(true);

    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save("../Reports/YahooT2ReportsExt/$name.xlsx");

    $callEndTime = microtime(true);
    $callTime = $callEndTime - $callStartTime;

    echo date('H:i:s') , " File written to Austin.xslx" , EOL;
    echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
    // Echo memory usage
    echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;

    // Echo memory peak usage
    echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

    // Echo done
    echo date('H:i:s') , " Done writing files" , EOL;
    echo 'Files have been created in ' , getcwd() , EOL;
        
}  



// SCAN DIRECTORY OF REPORTS TO PREP FOR ZIP



$dir    = '../Reports/YahooT2ReportsExt/';
$files_to_zip = scandir($dir);
$archiveCount = count($files_to_zip);


// ZIP FILES IN DIRECTORY


$zip = new ZipArchive;
$res = $zip->open('../Reports/YahooT2Reports/YahooT2Reports.zip', ZipArchive::CREATE);

if ($res === TRUE) {
    for ($archiveRow = 0; $archiveRow < $archiveCount; $archiveRow++) {

        $newFile = $files_to_zip[$archiveRow];

        if (!is_dir($newFile)) {
            $zip->addFile("../Reports/YahooT2ReportsExt/$newFile", "$newFile");
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



// FETCH EMAIL FROM SESSION



$sessionEmail = find_email($mysqli);


// LOGIN CHECK


if (login_check($mysqli) == true) {
    echo "Check your Email.";
} else {
    echo "You are not logged in.";
}


// EMAIL ZIPPED ARCHIVE WITH REPORTS TO LOGGED IN USER


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
$mail->Subject = 'Yahoo Tier 2 Reports';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually

$mail->Body = "Hi $_SESSION[username],

     Please find the attached ZIP archive of the Tier 2 reports for last month.

     ";

$mail->addAttachment('../Reports/YahooT2Reports/YahooT2Reports.zip'); 

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



















































// $what = is_writable((dirname(__FILE__) . "/yahoo/$name.csv");

// echo $what;

exit;
