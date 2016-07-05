<?php

// Include the Bing Ads namespaced class files available
// for download at http://go.microsoft.com/fwlink/?LinkId=322147
include 'bingads\ReportingClasses.php';
include 'bingads\ClientProxy.php';

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

// Specify the BingAds\Proxy object that will be used.
use BingAds\Proxy\ClientProxy;

// Disable WSDL caching.

ini_set("soap.wsdl_cache_enabled", "0");
ini_set("soap.wsdl_cache_ttl", "0");

// Specify your credentials.

$UserName = "<UserNameGoesHere>";
$Password = "<PasswordGoesHere>";
$DeveloperToken = "<DeveloperTokenGoesHere>";
$CustomerId = <CustomerIdGoesHere>;
$AccountId = <AccountIdGoesHere>;


// Reporting WSDL.

$wsdl = "https://api.bingads.microsoft.com/Api/Advertiser/Reporting/V9/ReportingService.svc?singleWsdl";


// Specify the file to download the report to. Because the file is
// compressed use the .zip file extension.

$DownloadPath = "c:\\reports\\keywordperf.zip";

// Confirm that the download folder exist; otherwise, exit.

$length = strrpos($DownloadPath, '\\');
$folder = substr($DownloadPath, 0, $length);

if (!is_dir($folder))
{
    printf("The output folder, %s, does not exist.\nEnsure that the " .
        "folder exists and try again.", $folder);
    return;
}

try
{
    //  This example uses the UserName and Password elements for authentication. 
    $proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, $UserName, $Password, $DeveloperToken, $AccountId, $CustomerId, null);
    
    // For Managing User Authentication with OAuth, replace the UserName and Password elements with the AuthenticationToken, which is your OAuth access token.
    //$proxy = ClientProxy::ConstructWithAccountAndCustomerId($wsdl, null, null, $DeveloperToken, $AccountId, $CustomerId, "AuthenticationTokenGoesHere");
	
    // You can submit one of the example reports, or build your own.
    $report = GetAccountPerformanceReportRequest($proxy, $AccountId);
    //$report = GetAudiencePerformanceReportRequest($proxy, $AccountId);
    //$report = GetKeywordPerformanceReportRequest($proxy, $AccountId);
    
    // SubmitGenerateReport helper method calls the corresponding Bing Ads service operation
    // to request the report identifier. The identifier is used to check report generation status
    // before downloading the report.
    
    $reportRequestId = SubmitGenerateReport(
    		$proxy, 
    		$report
    		);
    
    printf("Report Request ID: %s\n\n", $reportRequestId);
    
    $waitTime = 30 * 1; 
    $reportRequestStatus = null;
    
    // This sample polls every 30 seconds up to 5 minutes.
    // In production you may poll the status every 1 to 2 minutes for up to one hour.
    // If the call succeeds, stop polling. If the call or 
    // download fails, the call throws a fault.
    
    for ($i = 0; $i < 10; $i++)
    {
    	sleep($waitTime);
    
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

function GetKeywordPerformanceReportRequest($proxy, $AccountId) 
{
    $report = new KeywordPerformanceReportRequest();
    
    $report->Format = ReportFormat::Tsv;
    $report->ReportName = 'My Keyword Performance Report';
    $report->ReturnOnlyCompleteData = false;
    $report->Aggregation = ReportAggregation::Weekly;
    
    $report->Scope = new AccountThroughAdGroupReportScope();
    $report->Scope->AccountIds = array();
    $report->Scope->AccountIds[] = $AccountId;
    $report->Scope->AdGroups = null;
    $report->Scope->Campaigns = null;
    
    $report->Time = new ReportTime();
    $report->Time->PredefinedTime = ReportTimePeriod::Yesterday;
    
    //  You may either use a custom date range or predefined time.
    //  date_default_timezone_set('UTC');
    //  $LastYear = date("Y") - 1;
    //   $report->Time->CustomDateRangeStart = new Date();
    //  $report->Time->CustomDateRangeStart->Month = 1;
    //  $report->Time->CustomDateRangeStart->Day = 1;
    //  $report->Time->CustomDateRangeStart->Year = $LastYear;
    //  $report->Time->CustomDateRangeEnd = new Date();
    //  $report->Time->CustomDateRangeEnd->Month = 12;
    //  $report->Time->CustomDateRangeEnd->Day = 31;
    //  $report->Time->CustomDateRangeEnd->Year = $LastYear;
    
    //  If you specify a filter, results may differ from data you see in the Bing Ads web application
    //  $report->Filter = new KeywordPerformanceReportFilter();
    //  $report->Filter->DeviceType = array (
    //      DeviceTypeReportFilter::Computer,
    //      DeviceTypeReportFilter::SmartPhone
    //  );
    
    $report->Columns = array (
    		KeywordPerformanceReportColumn::TimePeriod,
    		KeywordPerformanceReportColumn::AccountId,
    		KeywordPerformanceReportColumn::CampaignId,
    		KeywordPerformanceReportColumn::Keyword,
    		KeywordPerformanceReportColumn::KeywordId,
    		KeywordPerformanceReportColumn::DeviceType,
    		KeywordPerformanceReportColumn::BidMatchType,
    		KeywordPerformanceReportColumn::Clicks,
    		KeywordPerformanceReportColumn::Impressions,
    		KeywordPerformanceReportColumn::Ctr,
    		KeywordPerformanceReportColumn::AverageCpc,
    		KeywordPerformanceReportColumn::Spend,
    		KeywordPerformanceReportColumn::QualityScore
    );
    
    // You may optionally sort by any KeywordPerformanceReportColumn, and optionally
    // specify the maximum number of rows to return in the sorted report.
    
    $report->Sort = array ();
    $keywordPerformanceReportSort = new KeywordPerformanceReportSort();
    $keywordPerformanceReportSort->SortColumn = KeywordPerformanceReportColumn::Clicks;
    $keywordPerformanceReportSort->SortOrder = SortOrder::Ascending;
    $report->Sort[] = $keywordPerformanceReportSort;
    
    $report->MaxRows = 10;
    
    $encodedReport = new SoapVar($report, SOAP_ENC_OBJECT, 'KeywordPerformanceReportRequest', $proxy->GetNamespace());

    return $encodedReport;
}

function GetAccountPerformanceReportRequest($proxy, $AccountId) 
{
    $report = new AccountPerformanceReportRequest();
    
    $report->Format = ReportFormat::Tsv;
    $report->ReportName = 'My Account Performance Report';
    $report->ReturnOnlyCompleteData = false;
    $report->Aggregation = ReportAggregation::Weekly;
    
    $report->Scope = new AccountReportScope();
    $report->Scope->AccountIds = array();
    $report->Scope->AccountIds[] = $AccountId;
        
    $report->Time = new ReportTime();
    $report->Time->PredefinedTime = ReportTimePeriod::Yesterday;
    
    //  You may either use a custom date range or predefined time.
    //  date_default_timezone_set('UTC');
    //  $LastYear = date("Y") - 1;
    //   $report->Time->CustomDateRangeStart = new Date();
    //  $report->Time->CustomDateRangeStart->Month = 1;
    //  $report->Time->CustomDateRangeStart->Day = 1;
    //  $report->Time->CustomDateRangeStart->Year = $LastYear;
    //  $report->Time->CustomDateRangeEnd = new Date();
    //  $report->Time->CustomDateRangeEnd->Month = 12;
    //  $report->Time->CustomDateRangeEnd->Day = 31;
    //  $report->Time->CustomDateRangeEnd->Year = $LastYear;
    
    //  If you specify a filter, results may differ from data you see in the Bing Ads web application
    //  $report->Filter = new AccountPerformanceReportFilter();
    //  $report->Filter->DeviceType = array (
    //      DeviceTypeReportFilter::Computer,
    //      DeviceTypeReportFilter::SmartPhone
    //  );

    $report->Columns = array (
    		AccountPerformanceReportColumn::TimePeriod,
    		AccountPerformanceReportColumn::AccountId,
    		AccountPerformanceReportColumn::AccountName,
    		AccountPerformanceReportColumn::Clicks,
    		AccountPerformanceReportColumn::Impressions,
    		AccountPerformanceReportColumn::Ctr,
    		AccountPerformanceReportColumn::AverageCpc,
    		AccountPerformanceReportColumn::Spend,
    );
    
    $encodedReport = new SoapVar($report, SOAP_ENC_OBJECT, 'AccountPerformanceReportRequest', $proxy->GetNamespace());
    
    return $encodedReport;
}

function GetAudiencePerformanceReportRequest($proxy, $AccountId) 
{
    $report = new AudiencePerformanceReportRequest();
    
    $report->Format = ReportFormat::Tsv;
    $report->ReportName = 'My Audience Performance Report';
    $report->ReturnOnlyCompleteData = false;
    $report->Aggregation = ReportAggregation::Daily;
    
    $report->Scope = new AccountThroughAdGroupReportScope();
    $report->Scope->AccountIds = array();
    $report->Scope->AccountIds[] = $AccountId;
    $report->Scope->AdGroups = null;
    $report->Scope->Campaigns = null;
    
    $report->Time = new ReportTime();
    $report->Time->PredefinedTime = ReportTimePeriod::Yesterday;
    
    //  You may either use a custom date range or predefined time.
    //  date_default_timezone_set('UTC');
    //  $LastYear = date("Y") - 1;
    //   $report->Time->CustomDateRangeStart = new Date();
    //  $report->Time->CustomDateRangeStart->Month = 1;
    //  $report->Time->CustomDateRangeStart->Day = 1;
    //  $report->Time->CustomDateRangeStart->Year = $LastYear;
    //  $report->Time->CustomDateRangeEnd = new Date();
    //  $report->Time->CustomDateRangeEnd->Month = 12;
    //  $report->Time->CustomDateRangeEnd->Day = 31;
    //  $report->Time->CustomDateRangeEnd->Year = $LastYear;
    
    $report->Columns = array (
    		AudiencePerformanceReportColumn::TimePeriod,
    		AudiencePerformanceReportColumn::AccountId,
    		AudiencePerformanceReportColumn::CampaignId,
    		AudiencePerformanceReportColumn::AudienceId,
    		AudiencePerformanceReportColumn::Clicks,
    		AudiencePerformanceReportColumn::Impressions,
    		AudiencePerformanceReportColumn::Ctr,
    		AudiencePerformanceReportColumn::AverageCpc,
    		AudiencePerformanceReportColumn::Spend,
    );
    
    $encodedReport = new SoapVar($report, SOAP_ENC_OBJECT, 'AudiencePerformanceReportRequest', $proxy->GetNamespace());
    
    return $encodedReport;
}
 
?>