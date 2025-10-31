<?php
    ini_set('display_errors', 'On');
    // require __DIR__ . '/vendor/autoload.php';
    // require_once(dirname(__FILE__) .'/storage.php');
    require($_SERVER['DOCUMENT_ROOT'].'/xerosync/classes/config.php');

    // Storage Classe uses sessions for storing token > extend to your DB of choice
    $storage = new StorageClass();  

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
        echo "NO CODE";
        header("Location: index.php?error=true");
        exit();

    // Check given state against previously stored one to mitigate CSRF attack
    } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        echo "Invalid State";
        unset($_SESSION['oauth2state']);
        exit('Invalid state');
    } else {
        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
           
            $config = XeroAPI\XeroPHP\Configuration::getDefaultConfiguration()->setAccessToken( (string)$accessToken->getToken() );
          
            $config->setHost("https://api.xero.com"); 
            $identityInstance = new XeroAPI\XeroPHP\Api\IdentityApi(
                new GuzzleHttp\Client(),
                $config
            );
            
            // Get Array of Tenant Ids
            $result = $identityInstance->getConnections();


            // $access_token = $accessToken->getToken();
            // $access_expire = $accessToken->getExpires();
            // $access_tenantid = $result[0]->getTenantId();
            // $refresh_token = $accessToken->getRefreshToken();


            // Save my token, expiration and tenant_id
            $storage->setToken(
                $accessToken->getToken(),
                $accessToken->getExpires(),
                $result[0]->getTenantId(),  
                $accessToken->getRefreshToken());

         
// $access_token_str = var_export($access_token, true);
// $access_expire_str = var_export($access_expire, true);
// $access_tenantid_str = var_export($access_tenantid, true);
// $refresh_token_str = var_export($refresh_token, true);


/* $var = "<?php\n\n\$access_token = $access_token_str;\$access_expire=$access_expire_str;\$access_tenantid=$access_tenantid_str;\$refresh_token=$refresh_token_str;\n\n?>";*/
// file_put_contents(dirname(__FILE__) .'/accessdata.php', $var);


   
            header('Location: ' . './get.php');
            exit();
     
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            echo "Failed!!!";
            // Failed to get the access token or user details.
            exit($e->getMessage());
        }
    }
?>
    <html>
    <head>
        <title>My App</title>
    </head>
    <body>      
        Opps! Should have redirected to <a href="get.php">to this page</a>
    </body>
</html>
