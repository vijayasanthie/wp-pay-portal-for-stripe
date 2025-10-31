<?php
	ini_set('display_errors', 'On');
	// require __DIR__ . '/vendor/autoload.php';
	// require_once(dirname(__FILE__) .'/storage.php');
require($_SERVER['DOCUMENT_ROOT'].'/xerosync/classes/config.php');

// echo "<pre>";print_r($_SERVER);echo "</pre>";
// echo "<pre>";print_r($config);echo "</pre>";exit;

	// Storage Classe uses sessions for storing access token > extend to your DB of choice
	$storage = new StorageClass();

	session_start();

	/*$provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => 'DB6621570BCD4E48B6837C51C7A2124C',   
        'clientSecret'            => 'vXf8y7PhxNgVYRFURhZXL71T8y_ZkaReVSee4mfCVFf3yG51',
        'redirectUri'             => 'https://mailarchiva.net/xerosync/xerooauth2/callback.php',
	    'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
	    'urlAccessToken'          => 'https://identity.xero.com/connect/token',
	    'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation'
	]);*/

	$provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => $config['consumer']['key'],   
		'clientSecret'            => $config['consumer']['secret'],
		'redirectUri'             => $config['xero_redirectUri'],
		'urlAuthorize'            => $config['xero_urlAuthorize'],
		'urlAccessToken'          => $config['xero_urlAccessToken'],
		'urlResourceOwnerDetails' => $config['xero_urlResourceOwnerDetails']
	]);


	// If we don't have an authorization code then get one
	if (!isset($_GET['code'])) {
		$options = [
	    	'scope' => ['openid email profile offline_access accounting.settings accounting.transactions accounting.contacts accounting.journals.read accounting.reports.read accounting.attachments']
		];

	    // Fetch the authorization URL from the provider; this returns the urlAuthorize option and generates and applies any necessary parameters (e.g. state).
	    $authorizationUrl = $provider->getAuthorizationUrl($options);

	    // Get the state generated for you and store it to the session.
	    $_SESSION['oauth2state'] = $provider->getState();

	    // Redirect the user to the authorization URL.
	    header('Location: ' . $authorizationUrl);
	    exit();

	// Check given state against previously stored one to mitigate CSRF attack
	} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
	    unset($_SESSION['oauth2state']);
	    exit('Invalid state');
	} else {

	}
?>
	<html>
	<head>
		<title>My App</title>
	</head>
	<body>
		Opps! Problem redirecting .....
	</body>
</html>
