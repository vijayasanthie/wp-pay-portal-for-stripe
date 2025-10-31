<?php
class WPStlShortcode {
	public function __construct(){
		// add_shortcode('WSSM_STRIPE_CONNECT', array( $this,'stl_stripe_connectbtn'));
		add_shortcode('WSSM_STRIPE_MANAGEMENT', array( $this,'stl_stripe_managementfn'));
		add_shortcode('WSSM_STRIPE_CARD', array( $this,'stl_stripe_cardfn'));
		add_shortcode('WSSM_STRIPE_INVOICE', array( $this,'stl_stripe_invoicefn'));
		add_shortcode('WSSM_STRIPE_SUBSCRIPTION', array( $this,'stl_stripe_subscriptionfn'));
		add_shortcode('WSSM_STRIPE_ADDSUBSCRIPTION', array( $this,'stl_stripe_addsubscriptionfn'));
		add_shortcode('WSSM_EMAIL_VERIFICATION', array( $this,'stl_stripe_emailverficationfn'));
		add_shortcode('WSSM_LOGIN_REGISTER', array( $this,'stl_stripe_loginregisterfn'));
		add_shortcode('WSSM_STRIPE_ADDITIONAL_USERS', array( $this,'stl_stripe_additionalusersfn'));

		add_shortcode('WSSM_STRIPE_XERO_AUTHORIZATION', array( $this,'stl_stripe_xeroauthfn'));
		add_shortcode('WSSM_STRIPE_XERO_CALLBACK', array( $this,'stl_stripe_xerocallbackfn'));

		$this->wpstltemplate =new WPStlTemplatecls();

	}
	public function logregRedirect($rpage){
		if ( !is_user_logged_in() ) {
			$page_logreg = get_option('wssm_logreg_urlredirect','');
			$rpage_url = ($rpage !='')?'?rpage='.$rpage:'';
			$page_logreg_url = site_url()."/".$page_logreg.$rpage_url;
			echo "<script>window.location='".$page_logreg_url."'</script>";exit;
		}
	}
	function stl_stripe_managementfn(){

		$this->logregRedirect('accountinfo');


		ob_start();
		$this->wpstltemplate->getAcccountInfoTemplate();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;

	}
	function stl_stripe_cardfn(){
		$this->logregRedirect('card');

		ob_start();
		$this->wpstltemplate->getCardTemplate();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;

	}
	function stl_stripe_invoicefn(){
		$this->logregRedirect('invoice');

		ob_start();
		$this->wpstltemplate->getInvoiceTemplate();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;

	}
	function stl_stripe_subscriptionfn(){
		$this->logregRedirect('subscription');
			
		ob_start();
		$this->wpstltemplate->getSubscriptionTemplate();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;

	}
	function stl_stripe_addsubscriptionfn(){
		
		$loginreg_status = get_option('wssm_stripe_loginreg_status','');

		if ( is_user_logged_in() || $loginreg_status == '1' ) {
			ob_start();
			$this->wpstltemplate->addSubscriptionTemplate();
			$output = ob_get_contents();
    		ob_end_clean(); 
    		return  $output;
		}
		else
		{
			$page_logreg = get_option('wssm_logreg_urlredirect','');
			$page_logreg_url = site_url()."/".$page_logreg;
			echo "<script>window.location='".$page_logreg_url."'</script>";exit;
		}
	}

	function stl_stripe_emailverficationfn(){
		ob_start();
		$this->wpstltemplate->checkEmailVerification();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;
	}

	function stl_stripe_loginregisterfn(){
		ob_start();
		$this->wpstltemplate->loginRegister();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;
	}

	function stl_stripe_additionalusersfn(){
		$this->logregRedirect('additional_users');

		ob_start();
		$this->wpstltemplate->getAdditionalUsersTemplate();
		$output = ob_get_contents();
    	ob_end_clean(); 
    	return  $output;

	}

	function stl_stripe_xeroauthfn(){
        $xerocallback = get_option('wssm_stripe_page_xerocallback','');

		$provider = new \League\OAuth2\Client\Provider\GenericProvider([
	        'clientId'                => get_option('wssm_xero_consumer_key',''),   
	        'clientSecret'            => get_option('wssm_xero_consumer_secret',''),
	        'redirectUri'             => site_url()."/".$xerocallback."/index.php",
		    'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
		    'urlAccessToken'          => 'https://identity.xero.com/connect/token',
		    'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation'
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

		    // echo "<pre>";print_r($_SESSION);echo "</pre>";
		    // echo "authorizationUrl = ".$authorizationUrl;exit;
		    echo "<script>window.location='".$authorizationUrl."'</script>";exit;

		    // Redirect the user to the authorization URL.
		    // header('Location: ' . $authorizationUrl);
		    exit();

		// Check given state against previously stored one to mitigate CSRF attack
		} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
		    unset($_SESSION['oauth2state']);
		    echo 'Invalid state';
		} else {

		}
		
	}

	function stl_stripe_xerocallbackfn(){

		$wssm_xero_consumer_key = get_option('wssm_xero_consumer_key','');
        $wssm_xero_consumer_secret = get_option('wssm_xero_consumer_secret','');
        $xerocallback = get_option('wssm_stripe_page_xerocallback','');
	    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
	        'clientId'                => $wssm_xero_consumer_key,   
	        'clientSecret'            => $wssm_xero_consumer_secret,
	        'redirectUri'             => site_url()."/".$xerocallback."/index.php",
		    'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
		    'urlAccessToken'          => 'https://identity.xero.com/connect/token',
		    'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation'
		]);
  
	    // If we don't have an authorization code then get one
	    if (!isset($_GET['code'])) {
	        echo "NO CODE";
	        exit();

	    } 

	    else {
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


	            $access_token = $accessToken->getToken();
	            $expire_time = $accessToken->getExpires();
	            $tenantid = $result[0]->getTenantId();
	            $refresh_token = $accessToken->getRefreshToken();

	            update_option( 'wssm_xero_access_token', $access_token );
	            update_option( 'wssm_xero_expire_time', $expire_time );
	            update_option( 'wssm_xero_tenantid', $tenantid );
	            update_option( 'wssm_xero_refresh_token', $refresh_token );

	            echo "App connected successfully";

	             exit();
     
	        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
	            echo "Failed!!!";
	            // Failed to get the access token or user details.
	            echo $e->getMessage();
	        }
    	}

		
	}
	

	
	
}