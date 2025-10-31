<?php
class WPStlTemplatecls extends WPStlStripeManagement {

	public $cdefault_currency = 'usd';
	public $cdefault_currency_symbol = 'US $';
	public $wssm_customer_id = '';
	public $parent_userid = '';
	public function __construct(){
		parent::__construct();
		global $parent_userid;
		

		// echo "parent_userid ss = ".$parent_userid;
		$this->parent_userid = $parent_userid;

		$customerdata = parent::getStripeCustomerbasic();
		// echo "<pre>";print_r($customerdata);echo "</prE>";
		if($customerdata['stl_status']){
			$currency = ($customerdata['currency'] !='')?$customerdata['currency']:$this->getCurrency($customerdata);
			// echo "currency = ".$currency;
			// if($currency == '')
			// {
				
			// 	echo "emptyyyy";
			// 	$this->getCurrency($customerdata);
			// }
			// else
			// {
			// 	echo "noooooo";
			// }
			// echo "currency = ".$currency;
			$this->cdefault_currency = $currency;
			$this->cdefault_currency_symbol = (array_key_exists($currency,WSSM_CURRENCY))?WSSM_CURRENCY[$currency]:$currency;
			$this->wssm_customer_id = $customerdata['id'];
			// echo "symbol = ".$this->cdefault_currency_symbol;

		}
	}
	
	public function getCurrency($customerdata){
		global $wpdb;
		// $table_name = WSSM_CURCOUNTRY_TABLE_NAME;
		// echo "<pre>";print_r($customerdata);echo "</pre>";
		$customer_country = (isset($customerdata['address']['country']))?$customerdata['address']['country']:'';
		if($customer_country == '') 
			$customer_country = $this->getGioCountry();
		$ccmap_results = $wpdb->get_row( "SELECT * FROM ".WSSM_CURCOUNTRY_TABLE_NAME ." where country_code='".$customer_country."' or currency_code='".$customer_country."'");
		if(!empty($ccmap_results))
			return $ccmap_results->currency_code;
		else
			return 'usd';
	}
	public function getGioCountry(){
		$ipAddress = '';
	    if (getenv('HTTP_CLIENT_IP')){$ipAddress = getenv('HTTP_CLIENT_IP');}
	    else if(getenv('HTTP_X_FORWARDED_FOR')){$ipAddress = getenv('HTTP_X_FORWARDED_FOR');}
	    else if(getenv('HTTP_X_FORWARDED')){$ipAddress = getenv('HTTP_X_FORWARDED');}
	    else if(getenv('HTTP_FORWARDED_FOR')){$ipAddress = getenv('HTTP_FORWARDED_FOR');}
	    else if(getenv('HTTP_FORWARDED')){$ipAddress = getenv('HTTP_FORWARDED');}
	    else if(getenv('REMOTE_ADDR')){$ipAddress = getenv('REMOTE_ADDR');}
	    else{$ipAddress = 'UNKNOWN';}

		$geo_json = file_get_contents('http://geoip-db.com/json/'.$ipAddress);
		$geoip_data = json_decode($geo_json);

		if(!empty($geoip_data))
			return $geoip_data->country_code;
		return false;
	}
	public function pageRedirect(){
		// echo "ssssss";echo $this->wssm_customer_id;exit;
		if($this->wssm_customer_id != '')
			return true;
	
		$page_addsub = get_option('wssm_stripe_page_acounttinfo','');
		$page_addsub_url = site_url()."/".$page_addsub;
		echo "<script>window.location='".$page_addsub_url."'</script>";exit;

	}
	public function pageActRedirect(){
		// echo "ssssss";echo $this->wssm_customer_id;exit;
		if($this->wssm_customer_id != '' || is_user_logged_in())
			return true;
	
		$page_addsub = get_option('wssm_stripe_page_addsubscription','');
		$page_addsub_url = site_url()."/".$page_addsub;
		echo "<script>window.location='".$page_addsub_url."'</script>";exit;

	}
	public function getAcccountInfoTemplate(){	
		try {
			$this->pageActRedirect();

			$active_menu = 'accountinfo';	
			wp_enqueue_script('stl_wssm_accountinfo_js');
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			$customerdata = parent::getStripeCustomerbasic();

			include_once(WPSTRIPESM_DIR.'templates/accountinfo.php');

		}
		catch(Exception $e) {
            echo $e->getJsonBody();
        }

	}
	public function getCardTemplate(){
		try {
			$this->pageRedirect();

			$active_menu = 'card';		
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			$cardlists = parent::getCustomerCardlist();
			include_once(WPSTRIPESM_DIR.'templates/card.php');

		}
		catch(Exception $e) {
            echo $e->getJsonBody();
        }
	}
	public function getHasExpired()
	{	
		$expire_time = get_option('wssm_xero_expire_time','');
			if(time() > $expire_time)
				return true;
			else 
				return false;
		
	}
	public function refreshAccessToken(){
  
        	$xerocallback = get_option('wssm_stripe_page_xerocallback','');
        	$xero_tenantid = get_option('wssm_xero_tenantid','');
        	$refresh_token = get_option('wssm_xero_refresh_token','');

	    	if ($this->getHasExpired()) {
				$provider = new \League\OAuth2\Client\Provider\GenericProvider([
		          'clientId'                => get_option('wssm_xero_consumer_key',''),   
		          'clientSecret'            => get_option('wssm_xero_consumer_secret',''),
		          'redirectUri'             => site_url()."/".$xerocallback."/index.php",
		          'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
		          'urlAccessToken'          => 'https://identity.xero.com/connect/token',
		          'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation'
				]);
			    $newAccessToken = $provider->getAccessToken('refresh_token', [
			        'refresh_token' => $refresh_token
			    ]);

		        $access_token = $newAccessToken->getToken();
	            $expire_time = $newAccessToken->getExpires();
	            $tenantid = $xero_tenantid;
	            $refresh_token = $newAccessToken->getRefreshToken();

	            update_option( 'wssm_xero_access_token', $access_token );
	            update_option( 'wssm_xero_expire_time', $expire_time );
	            update_option( 'wssm_xero_tenantid', $tenantid );
	            update_option( 'wssm_xero_refresh_token', $refresh_token );
			}
			return true;

    }
    public function xeroAllInvoices(){
    	$refresh_data = $this->refreshAccessToken();


	    $access_token = get_option('wssm_xero_access_token','');
	    $xero_tenantid = get_option('wssm_xero_tenantid','');

		$config = XeroAPI\XeroPHP\Configuration::getDefaultConfiguration()->setAccessToken( (string)$access_token );
		$config->setHost("https://api.xero.com/api.xro/2.0");   

		$apiInstance = new XeroAPI\XeroPHP\Api\AccountingApi(new GuzzleHttp\Client(),$config);
		$result2 = $apiInstance->getInvoices($xero_tenantid);
		return $result2->getInvoices();

    }
    public function getXeroInvoices($wssm_invoice_mode){
    	 
		$allXeroInvoices = array();
	    if($wssm_invoice_mode == 'xero')
	    {
	        $refresh_data = $this->refreshAccessToken();
			$allXeroInvoicesData = $this->xeroAllInvoices();
			$allXeroInvoices = (array)$allXeroInvoicesData;
		}
		return $allXeroInvoices;
    }
	public function getInvoiceTemplate(){
		try {
			$this->pageRedirect();

			$active_menu = 'invoice';		
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			$wssm_invoice_mode = get_option('wssm_invoice_mode','stripe');
			$cardlists = parent::getCustomerCardlist();
			$invoicelists = parent::getCustomerInvoicelist();
			$customerdata = parent::getStripeCustomerbasic();
			$allXeroInvoices = $this->getXeroInvoices($wssm_invoice_mode);

			include_once(WPSTRIPESM_DIR.'templates/invoices.php');

		}
		catch(Exception $e) {
			// echo "<pre>";print_r($e);echo "</pre>";
            echo  $e->getMessage();
        }
	}
	public function getSubscriptionTemplate(){
		try {	
			
			$this->pageRedirect();

			$active_menu = 'subcription';	
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			// $subscriptiondatas = parent::getCustomerSubscriptionlist();
			$customerdata = parent::getStripeCustomerbasic();
			$cardlists = parent::getCustomerCardlist();
			$planlists = parent::getProductPlanList();
					
			include_once(WPSTRIPESM_DIR.'templates/subscriptions.php');


		}
		catch(Exception $e) {
            echo $e->getJsonBody();
        }
	}

	public function addSubPageRedirect(){
		$page_actinfo = get_option('wssm_stripe_page_acounttinfo','');
		$page_actinfo_url = site_url()."/".$page_actinfo;

		$actcode = (isset($_GET['wssm_activationcode']))?$_GET['wssm_activationcode']:'';
		if($actcode == '') return true;

		$Userplan = $this->getUserplan($actcode);
		echo "<pre>";print_r($Userplan);echo "</pre>";exit;
		$plan_details = $Userplan->plan_details;
		if(empty($plan_details) || $plan_details == '')
			echo "<script>window.location='".$page_actinfo_url."'</script>";

		return true;
	}


	public function addSubscriptionTemplate(){	
		try {

			$this->addSubPageRedirect();
			$active_menu = 'subcription';
			
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			$customerdata = parent::getStripeCustomerbasic();
			$planlists = parent::getProductPlanList();
			$cardlists = parent::getCustomerCardlist();
			
			$taxlists = parent::getTaxList();

			$subplainids = parent::getCustomerSubscriptionPlanIds();
				// echo "sucsscc";exit;
			include_once(WPSTRIPESM_DIR.'templates/add_subscriptions.php');

		}
		catch(Exception $e) {
            echo $e->getJsonBody();
        }
	}

	public function getInActiveUserList(){
		global $wpdb;
		// $parent_userid = $this->parent_userid;
		return $wpdb->get_results("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE status_type = 'additional_user_add' and plan_details = '".$this->parent_userid."'");
	}

	public function getActiveUserList(){
		$parent_userid = $this->parent_userid;
		// echo "parent_userid = ".$parent_userid;
		return  get_users(array('meta_key' => 'parent_user_id','meta_value' => $parent_userid,'count_total' => false));
	}

	public function getAdditionalUsersTemplate(){
		try {
			$this->pageRedirect();

			$active_menu = 'additional_users';		
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			$parent_userid = $this->parent_userid;
			$user_lists = array();
			$inactive_user_lists = $this->getInActiveUserList();
			$active_user_lists = $this->getActiveUserList();
			include_once(WPSTRIPESM_DIR.'templates/additional_users.php');
		}
		catch(Exception $e) {
            echo $e->getJsonBody();
        }

		
	}


	public function check_username_exist($original_name,$full_name,$digits = 0){

		if(!username_exists( $full_name))
			return $full_name;

		$digits = (int) $digits+1;
		$full_name = $original_name."_".$digits;

		return $this->check_username_exist($original_name,$full_name,$digits);

		
	}

	public function getRedirectURL($getdata){
		$rpage = (isset($getdata['rpage']))?$getdata['rpage']:'';
		switch($rpage)
		{
			case 'accountinfo':
				$lredirect_url = get_option('wssm_stripe_page_acounttinfo','');
				break;
			case 'card':
				$lredirect_url = get_option('wssm_stripe_page_card','');
				break;
			case 'invoice':
				$lredirect_url = get_option('wssm_stripe_page_invoice','');
				break;
			case 'additional_users':
				$lredirect_url = get_option('wssm_stripe_page_additionalusers','');
				break;
			case 'subscription':
				$lredirect_url = get_option('wssm_stripe_page_subscription','');
				break;
			default:
				$lredirect_url = get_option('wssm_stripe_page_addsubscription','');break;
		}
		return $lredirect_url;
	}
	public function getRegistRedirectURL($getdata){
		$rpage = (isset($getdata['rpage']))?$getdata['rpage']:'';
		if($rpage == '')
			$lredirect_url = get_option('wssm_stripe_page_addsubscription','');
		else
			$lredirect_url = get_option('wssm_stripe_page_acounttinfo','');
		// switch($rpage)
		// {
		// 	case 'add_subscription':
		// 		$lredirect_url = get_option('wssm_stripe_page_addsubscription','');
		// 		break;
		// 	default:
		// 		$lredirect_url = get_option('wssm_stripe_page_acounttinfo','');break;
		// }
		return $lredirect_url;
	}
	public function checkEmailVerification()
	{
		$lredirect_url = $this->getRedirectURL($_GET);
		$reg_lredirect_url = $this->getRegistRedirectURL($_GET);
		$page_addsub_url = site_url()."/".get_option('wssm_stripe_page_addsubscription','');
		$error_status = 0; $message = $suser_id = $user_email = '';
		$link_expire = get_option('wssm_link_expire','never');

		try{
			if(!isset($_GET['wssm_activationcode']))
				echo "<script>window.location='".$page_addsub_url."'</script>";

			$actcode = (isset($_GET['wssm_activationcode']))?$_GET['wssm_activationcode']:'';

			if($actcode == '')
				echo "<script>window.location='".$page_addsub_url."'</script>";

			if(!isset($_GET['action']))
				$this->checkMailWithoutAction($actcode);

			if(isset($_GET['wssm_activationcode']) &&  isset($_GET['action']))
			{
				if($_GET['action'] == 'update')
				{
					$user_query = new WP_User_Query(array('meta_key'=>'wssm_activationcode','meta_value'=> $actcode));
					$users = $user_query->get_results();
					foreach($users as $user)
					{
						$suser_id = $user->ID;
						$user_email = strtolower($user->user_email);
					}

					$actdate = get_user_meta( $suser_id, 'wssm_activation_date',true);
					$new_email = strtolower(get_user_meta( $suser_id, 'wssm_new_email',true));

				}
				else if($_GET['action'] == 'accesslogin'  || $_GET['action'] == 'changemail' || $_GET['action'] == 'additional_user_add' || $_GET['action'] == 'reglogin' || $_GET['action'] == 'accessreg'){
					$user_plans = $this->getUserplan($actcode);
					$new_email = $this->getNewEmail($user_plans);
					$suser_id = $user_plans->suser_id;
					$actdate = $user_plans->created_on;
					
				}
				else
					throw new Exception( __('Action type is not valid. Please try again.','wp_stripe_management'));


				if($suser_id =='')
					throw new Exception( __('The activation code is not valid.','wp_stripe_management'));


				// echo "lredirect_url = ".$lredirect_url;
				$lred_suser_url = site_url()."/".$lredirect_url."/?suser_id=".$suser_id;
				$reg_suser_url = site_url()."/".$reg_lredirect_url."/?suser_id=".$suser_id;
				$page_addsub_suser_url = $page_addsub_url."/?suser_id=".$suser_id;
				$time_differ = round(abs(strtotime(date('Y-m-d H:i:s')) - strtotime($actdate)) / 60);

				// echo "new_email = ".$new_email." = lred_suser_url = ".$lred_suser_url;exit;
				if(($link_expire == '10mins' && $time_differ <= 10) || ($link_expire == '20mins' && $time_differ <= 20) || ($link_expire == '1hr' && $time_differ <= 60) || $link_expire == 'never')
				{
					switch($_GET['action'])
					{
						case 'update':
							$this->userUpdate($new_email,$user_email,$suser_id);break;
						case 'changemail':
							$this->changeEmail($actcode,$page_addsub_suser_url);break;
						case 'accesslogin':
							$this->userLogin('email',$new_email,$lred_suser_url);break;
						case 'reglogin':
							$this->userLogin('email',$new_email,$lred_suser_url);break;
						case 'accessreg':
							$this->accessRegister($actcode,$reg_suser_url);break;
						case 'additional_user_add':
							$this->addtionalUserAdd($actcode,$lred_suser_url,$lredirect_url);break;
						default:
							break;
					}

				}
				else
				{
					$message = '<div class="stl-alert stl-alert-danger">'.__('The link is expired.','wp_stripe_management').' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
				}

				if(file_exists(WPSTRIPESM_DIR.'templates/emailactivation.php')){
					include_once(WPSTRIPESM_DIR.'templates/emailactivation.php');
				}
			}

		}
        catch(Exception $e) {
        	$message = '<div class="stl-alert stl-alert-danger">'. $e->getMessage().' <a href="javascript:void(0);" class="btn_actmailresend">'.__('Click Here','wp_stripe_management').' </a>'.__('to resend.','wp_stripe_management').'</div>';
        	if(file_exists(WPSTRIPESM_DIR.'templates/emailactivation.php')){
				include_once(WPSTRIPESM_DIR.'templates/emailactivation.php');
			}
        }

	}
	public function checkMailWithoutAction($actcode){
		$page_addsub_url = site_url()."/".get_option('wssm_stripe_page_addsubscription','');
		$user_plans = $this->getUserplan($actcode);
		$new_email = $this->getNewEmail($user_plans);

		$user_query = new WP_User_Query(array('meta_key'=>'wssm_activationcode','meta_value'=> $actcode));
		$users = $user_query->get_results();
		if(!empty($users))
		{
			foreach($users as $user)
			{
				$suser_id = $user->ID;
				$user_email = strtolower($user->user_email);
			}
			$new_email = strtolower(get_user_meta( $suser_id, 'wssm_new_email',true));
		}


		if(empty($user_plans) && empty($users))
			echo "<script>window.location='".$page_addsub_url."'</script>";
		

		$error_status = 1;

		if(file_exists(WPSTRIPESM_DIR.'templates/emailactivation.php')){
			include_once(WPSTRIPESM_DIR.'templates/emailactivation.php');
		}
	}
	public function getUserplan($actcode){
		global $wpdb;
		return $wpdb->get_row("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE activation_code = '".$actcode."'");

	}
	public function userUpdate($new_email,$user_email,$suser_id){
		$actinfo_url = site_url().'/'.get_option('wssm_stripe_page_acounttinfo','');

		if($new_email == '' || email_exists( $new_email))
			echo "<script>window.location='".$actinfo_url."'</script>";

		try{
			$customer_details = parent::updateCustomerEmailID($user_email,$new_email);				
			$args = array('ID'         => $suser_id,'user_email' => esc_attr( $new_email ));
			wp_update_user( $args );
			echo "<script>window.location='".$actinfo_url."'</script>";exit;
		}
		catch(Exception $e) 
		{
			echo "<script>window.location='".$actinfo_url."'</script>";exit;
		}
	}
	public function getNewEmail($user_plans){
		$status_type = $user_plans->status_type;
		$new_email = $user_plans->user_oldemail;
		if($status_type == 'changeemail')
			$new_email = $user_plans->user_newemail;

		return strtolower($new_email);
	}
	public function addtionalUserAdd($actcode,$lred_suser_url,$lredirect_url){
		global $wpdb;

		$user_plans = $this->getUserplan($actcode);
		$new_email = $this->getNewEmail($user_plans);
		$full_name = $user_plans->full_name;
		$lred_url = site_url()."/".$lredirect_url;
		$suser_id = $user_plans->suser_id;

		if(email_exists( $new_email))
			$this->userLogin('email',$new_email,$lred_suser_url);

		$user_name = $this->check_username_exist($full_name,$full_name,0);

		if($user_name == '')
		{
			$wpdb->query('DELETE  FROM '.WSSM_USERPLAN_TABLE_NAME .' WHERE suser_id = "'.$suser_id.'"');
			$this->userLogin('login',$full_name,$lred_url);	
		}

		$status = $this->userRegister($user_plans->password,$user_name,$full_name,$new_email);

		update_user_meta( $status, 'parent_user_id', $user_plans->plan_details );
		update_user_meta( $status, 'phone_number', $user_plans->phone_number);
		global $parent_userid; global $stl_user_email;
		$parent_userid = $user_plans->plan_details;
		$stl_user_email = $new_email;

		$meat_update = parent::updateCustomerMetaUser();

		$wpdb->query('DELETE  FROM '.WSSM_USERPLAN_TABLE_NAME.' where suser_id = "'.$suser_id.'"');

		if(is_user_logged_in())
			echo "<script>window.location='".$lred_url."'</script>";
		else
			$this->userLogin('email',$new_email,$lred_url);

		return true;
	}
	public function accessRegister($actcode,$lred_suser_url){
		// echo "lred_suser_url = ".$lred_suser_url;exit;
		$user_plans = $this->getUserplan($actcode);
		$new_email = $this->getNewEmail($user_plans);
		$full_name = $user_plans->full_name;

		if(email_exists( $new_email))
			$this->userLogin('email',$new_email,$lred_suser_url);

		$user_name = $this->check_username_exist($full_name,$full_name,0);
							
		if($user_name == '')
			$this->userLogin('login',$full_name,$lred_suser_url);

		$this->userRegister($user_plans->password,$user_name,$full_name,$new_email);
		$this->userLogin('email',$new_email,$lred_suser_url);
		return true;

	}
	public function changeEmail($actcode,$page_addsub_suser_url){
		$user_plans = $this->getUserplan($actcode);
		$new_email = $this->getNewEmail($user_plans);

		if($new_email == '' || email_exists( $new_email))
			echo "<script>window.location='".$page_addsub_suser_url."'</script>";

		$old_user = get_user_by( 'email', strtolower($user_plans->user_oldemail) );
		$user_id = $old_user->ID;
		$args = array('ID' => $user_id,'user_email' => esc_attr( $new_email ));
		wp_update_user( $args );

		$this->userLogin('email',$new_email,$page_addsub_suser_url);
		return true;

	}
	public function userRegister($password,$user_name,$full_name,$new_email){
		$userdata = array(
			'user_pass'             => $password, 
			'user_login'            => $user_name, 
			'user_nicename'         => $full_name,  
			'user_email'            => $new_email,  
			'display_name'          => $full_name, 
			'nickname'              => $full_name, 
			'first_name'            => $full_name,  
		);
 
		$status = wp_insert_user( $userdata ) ;
                // echo $status;									 
		if( is_wp_error($status) )
			throw new Exception(__('Error in user creation. Please try again later.','wp_stripe_management'));
		return $status;
	}
	public function userLogin($loginby = 'email',$logindata = '',$redirect_url = ''){

		$user_verify = get_user_by($loginby, $logindata );

		if ( is_wp_error( $user_verify ) || empty($user_verify) )
			throw new Exception( __('Invalid email id. Try with another email.','wp_stripe_management'));

		wp_clear_auth_cookie();
		wp_set_current_user ( $user_verify->ID );
		wp_set_auth_cookie  ( $user_verify->ID );


		echo "<script>window.location='".$redirect_url."'</script>";exit;
	}
	public function loginRegister(){	

		if(file_exists(WPSTRIPESM_DIR.'templates/loginregister.php')){
			$cdefault_currency = $this->cdefault_currency;
			$cdefault_currency_symbol = $this->cdefault_currency_symbol;
			$wssm_customer_id = $this->wssm_customer_id;
			include_once(WPSTRIPESM_DIR.'templates/loginregister.php');
		}

	}
	

}

