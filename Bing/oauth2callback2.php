<?php
include "../cred/ClientCredentials2.php";

// Initialize the session
session_start();

// A helper class used to construct an URL with parameters and execute
// HTTP POST operations.
class HttpClient {
     public function postData($url, $postData) {
        $ch = curl_init();

        $query = "";

        while(list($key, $val) = each($postData))
        {
            if(strlen($query) > 0)
            {
                $query = $query . '&';
            }

            $query = $query . $key . '=' . $val;
        }

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $query);

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        if(FALSE === $response)
        {
            $curlErr = curl_error($ch);
            $curlErrNum = curl_errno($ch);

            curl_close($ch);
            throw new Exception($curlErr, $curlErrNum);
        }

        curl_close($ch);

        return $response;
    }
}

// This is the URL used to exchange the authorization token for an
// access token and a refresh token.
$accessTokenExchangeUrl = "https://login.live.com/oauth20_token.srf";

// Get the authorization code from the URL as well as the cross site forgery mitigation value.
$code = $_GET['code'];
$state = $_GET['state'];

// Verify the 'state' value is the same random value we created
// when initiating the authorization request.
if ((! is_numeric($state)) || ($state != $_SESSION['state']))
{
    throw new Exception('Error validating state.  Possible cross-site request forgery.');
}

$redirectUri = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] <> 'off')?'https://':'http://') .
    $_SERVER['HTTP_HOST'] . $redirectUriPath;

// These params will be added to the URL used in 
// HTTP POST below to request an access token
$accessTokenExchangeParams = array(
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirectUri
);

// Create an HTTP client and execute an HTTP POST request to
// exchange the authorization token for an access token and
// refresh token.
$httpClient = new HttpClient();
$responseJson = $httpClient->postData(
    $accessTokenExchangeUrl,
    $accessTokenExchangeParams);

// The response formatted in json
$responseArray = json_decode($responseJson, TRUE);

// If the response contains an access_token element, it was successful.
// If not, an error occurred and the description will be displayed below 
if(isset($responseArray['access_token']))
{
    $accessToken = $responseArray['access_token'];
    $expiresIn = $responseArray['expires_in'];
    $refreshToken = $responseArray['refresh_token'];

    $_SESSION['access_token'] = $accessToken;
    $_SESSION['refresh_token'] = $refreshToken;

    // Redirect to the URL that will finally access BingAds data.
    header('Location: ' . $getDataRedirectUriPath);
}
else
{
    $errorDesc = $responseArray['error_description'];
    $errorName = $responseArray['error'];
    printf("<p>OAuth failed Failed: %s - %s</p>", $errorName, $errorDesc);
}
