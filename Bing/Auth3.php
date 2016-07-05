<?php

include "../cred/ClientCredentials3.php";

session_start();

// Generate random value for use as the 'state'.  Mitigates
// cross site request forgery attacks.
$_SESSION['state'] = rand(0,999999999);

// This is the Microsoft authentication service URL used to initiate the OAuth authentication flow
$authorizationUrlBase = 'https://login.live.com/oauth20_authorize.srf';

// URL parameters used to request an authorization token
$queryParams = array(
    'client_id' => $clientId,
    'redirect_uri' => (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] <> 'off')?'https://':'http://') .
        $_SERVER['HTTP_HOST'] . $redirectUriPath,
    'scope' => "bingads.manage",
    'response_type' => 'code',
    'state' => $_SESSION['state']
);

// Microsoft Authentication service url and params
$goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>
	<div class="container">

	<section class="row auth">
			<p>// Display a small form with a login button. In your application, you would implement code to allow
			// the user to either log into your service or create a new account.</p>
			<h2>Bing Ads OAuth</h2>

			<p>This application would like to manage your Bing Ads data. Click below to login and authorize this application.</p>

			<p>When you click OK below, you'll be redirected to the following URI:</p>
			<p><?php echo $goToUrl ?></p>

			<p>// When the user presses this button, he'll be redirected to fully formed URL to request an
			// authorization token. From here, the user will be redirected to the $redirectUriPath where the authorization
			// token can be extracted.</p>
			<input type="button" class="btn btn-primary center-block" onClick="return window.location='<?php echo $goToUrl;?>';" value="OK" />
		</section>	
	</div>
</body>	

</html>