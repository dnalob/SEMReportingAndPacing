<?php

// Include the Bing Ads namespaced class file available
// for download at http://go.microsoft.com/fwlink/?LinkId=322147
include 'bingads\CustomerManagementClasses.php';
include 'bingads\CampaignManagementClasses.php';
include 'bingads\ClientProxy.php';

// Specify the BingAds\CampaignManagement objects that will be used.
use BingAds\CampaignManagement\GetCampaignsByAccountIdRequest;
use BingAds\CampaignManagement\Campaign;

// Specify the BingAds\CustomerManagement objects that will be used.
use BingAds\CustomerManagement\GetUserRequest;
use BingAds\CustomerManagement\GetCustomerPilotFeaturesRequest;
use BingAds\CustomerManagement\SearchAccountsRequest;
use BingAds\CustomerManagement\Paging;
use BingAds\CustomerManagement\OrderBy;
use BingAds\CustomerManagement\OrderByField;
use BingAds\CustomerManagement\SortOrder;
use BingAds\CustomerManagement\Predicate;
use BingAds\CustomerManagement\PredicateOperator;
use BingAds\CustomerManagement\Account;
use BingAds\CustomerManagement\User;

// Specify the BingAds\Proxy object that will be used.
use BingAds\Proxy\ClientProxy;

// Disable WSDL caching.

ini_set("soap.wsdl_cache_enabled", "0");
ini_set("soap.wsdl_cache_ttl", "0");

// Specify your credentials.

$UserName = "<UserNameGoesHere>";
$Password = "<PasswordGoesHere>";
$DeveloperToken = "<DeveloperTokenGoesHere>";

$GLOBALS['proxy'] = null;

$GLOBALS['customerWsdl'] = "https://clientcenter.api.bingads.microsoft.com/Api/CustomerManagement/v9/CustomerManagementService.svc?singleWsdl";
$GLOBALS['customerProxy'] = null; 

$GLOBALS['campaignWsdl'] = "https://api.bingads.microsoft.com/Api/Advertiser/CampaignManagement/v9/CampaignManagementService.svc?singleWsdl";
$GLOBALS['campaignProxy'] = null; 

try
{
    //  This example uses the UserName and Password elements for authentication. 
    $GLOBALS['customerProxy'] = ClientProxy::ConstructWithCredentials(
                                                 $GLOBALS['customerWsdl'], 
                                                 $GLOBALS['UserName'], 
                                                 $GLOBALS['Password'], 
                                                 $GLOBALS['DeveloperToken'], 
                                                 null);
    
    // For Managing User Authentication with OAuth, replace the UserName and Password elements with the AuthenticationToken, which is your OAuth access token.
    /*
    $GLOBALS['customerProxy'] = ClientProxy::ConstructWithCredentials(
                                                 $GLOBALS['customerWsdl'], 
                                                 null, 
                                                 null, 
                                                 $GLOBALS['DeveloperToken'], 
                                                 "AuthenticationTokenGoesHere");
    */

    // Get the User object for the current authenticated user, by calling GetUser
    // with a null UserId.

    $user = GetUser(null);
    OutputUser($user);

    // Search for the Bing Ads accounts that the user can access.

    $accounts = SearchAccountsByUserId($user->Id);

    foreach ($accounts->Account as $account)
    {
        OutputAccount($account);

        // Optionally you can find out which pilot features the customer is able to use. 
        // Each account could belong to a different customer, so use the customer ID in each account.
        $featurePilotFlags = GetCustomerPilotFeatures($account->ParentCustomerId);
        if (!empty($featurePilotFlags))
        {
            print "Customer Pilot Flags:\n";
            foreach ($featurePilotFlags->int as $flag)
            {
                printf("%d; ", $flag);
            }
        }

        //  This example uses the UserName and Password elements for authentication. 
        $GLOBALS['campaignProxy'] = ClientProxy::ConstructWithAccountAndCustomerId(
                                                 $GLOBALS['campaignWsdl'], 
                                                 $GLOBALS['UserName'], 
                                                 $GLOBALS['Password'], 
                                                 $GLOBALS['DeveloperToken'], 
                                                 $account->Id, 
                                                 $account->ParentCustomerId, 
                                                 null);
        
        // For Managing User Authentication with OAuth, replace the UserName and Password elements with the AuthenticationToken, which is your OAuth access token.
        /*
        $GLOBALS['campaignProxy'] = ClientProxy::ConstructWithAccountAndCustomerId(
                                                 $GLOBALS['campaignWsdl'], 
                                                 null, 
                                                 null,
                                                 $GLOBALS['DeveloperToken'], 
                                                 $account->Id, 
                                                 $account->ParentCustomerId, 
                                                 "AuthenticationTokenGoesHere");
        */    

        print "\n";

        $campaigns = GetCampaignsByAccountId($account->ParentCustomerId, $account->Id);
        foreach ($campaigns->Campaign as $campaign)
        {
            OutputCampaign($campaign);
        }

        print "\n\n";
    }
}
catch (SoapFault $e)
{
  // Output the last request/response.

  print "\nLast SOAP request/response:\n";
  print $GLOBALS['proxy']->GetWsdl() . "\n";
  print $GLOBALS['proxy']->GetService()->__getLastRequest()."\n";
  print $GLOBALS['proxy']->GetService()->__getLastResponse()."\n";

    // Customer Management service operations can throw AdApiFaultDetail.
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
          case 105:  // InvalidCredentials
            break;
          default:
            print "Please see MSDN documentation for more details about the error code output above.\n";
            break;
        }
      }
    }

    // Customer Management service operations can throw ApiFault.
    elseif (isset($e->detail->ApiFault))
    {
      // Log this fault.

      print "The operation failed with the following faults:\n";

      // If the OperationError array is not null, the following are examples of error codes that may be found.
      if (!empty($e->detail->ApiFault->OperationErrors))
      {
        $errors = is_array($e->detail->ApiFault->OperationErrors->OperationError)
        ? $e->detail->ApiFault->OperationErrors->OperationError
        : array('OperationError' => $e->detail->ApiFault->OperationErrors->OperationError);

        foreach ($errors as $error)
        {
          print "OperationError\n";
          printf("Code: %d\nMessage: %s\n", $error->Code, $error->Message);

          switch ($error->Code)
          {
            case 106:   // UserIsNotAuthorized
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


// Gets a User object by the specified UserId.

function GetUser($userId)
{   
    $GLOBALS['proxy'] = $GLOBALS['customerProxy']; 

    $request = new GetUserRequest();
    $request->UserId = $userId;

    return $GLOBALS['proxy']->GetService()->GetUser($request)->User;
}

// Searches by UserId for accounts that the user can manage.

function SearchAccountsByUserId($userId)
{
    $GLOBALS['proxy'] = $GLOBALS['customerProxy']; 
  
    // Specify the page index and number of customer results per page.

    $pageInfo = new Paging();
    $pageInfo->Index = 0;    // The first page
    $pageInfo->Size = 100;   // The first 100 accounts for this page of results

    $ordering = new OrderBy();
    $ordering->Field = OrderByField::Number;
    $ordering->Order = SortOrder::Ascending;     

    $predicate = new Predicate();
    $predicate->Field = "UserId";
    $predicate->Operator = PredicateOperator::Equals;
    $predicate->Value = $userId; 

    $request = new SearchAccountsRequest();
    $request->Ordering = $ordering;
    $request->PageInfo = $pageInfo;
    $request->Predicates = array($predicate);

    return $GLOBALS['proxy']->GetService()->SearchAccounts($request)->Accounts;
}

// Gets the list of pilot features that the customer is able to use.

function GetCustomerPilotFeatures($customerId)
{   
    $GLOBALS['proxy'] = $GLOBALS['customerProxy']; 

    $request = new GetCustomerPilotFeaturesRequest();
    $request->CustomerId = $customerId;

    return $GLOBALS['proxy']->GetService()->GetCustomerPilotFeatures($request)->FeaturePilotFlags;
}

// Returns a list of campaigns for the specified account.

function GetCampaignsByAccountId($customerId, $accountId)
{
    $GLOBALS['proxy'] = $GLOBALS['campaignProxy'];

    $request = new GetCampaignsByAccountIdRequest();
    $request->AccountId = $accountId;

    return $GLOBALS['proxy']->GetService()->GetCampaignsByAccountId($request)->Campaigns;
}

// Outputs the details of the specified user.

function OutputUser($user)
{
    if(empty($user))
    {
        return;
    }

    if ($user->IsMigratedToMicrosoftAccount)
    {
        print "The user is migrated to a Microsoft account, " .
              "and the UserName field is the corresponding email address.\n\n";
    }
    else
    {
        print "The user is not yet migrated to a Microsoft account, " .
              "and the value of UserName is a legacy Bing Ads managed user.\n\n";
    }

    printf("UserName is %s\n", $user->UserName);
    printf("Bing Ads Email is %s\n", $user->ContactInfo->Email);
    printf("User Id is %d\n", $user->Id);
    printf("FirstName is %s\n", $user->Name->FirstName);
    if (!empty($user->Name->MiddleInitial))
    {
        printf("MiddleInitial is %s\n", $user->Name->MiddleInitial);
    }
    printf("LastName is %s\n\n", $user->Name->LastName);
}


// Outputs an account.

function OutputAccount($account)
{
    if(empty($account))
    {
        return;
    }

    printf("Account Id: %d\n", $account->Id);
    printf("Account Number: %s\n", $account->Number);
    printf("Account Name: %s\n", $account->Name);
    printf("Account Parent Customer Id: %d\n", $account->ParentCustomerId);
}

// Outputs a campaign.

function OutputCampaign($campaign)
{
    if(empty($campaign))
    {
        return;
    }

    printf("Campaign Id: %d\n", $campaign->Id);
    printf("Campaign Name: %s\n", $campaign->Name);
}

?>