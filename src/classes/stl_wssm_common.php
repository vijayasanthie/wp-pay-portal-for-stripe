<?php
class WPStlCommoncls extends WPStlStripeManagement {

	public $emailvalidation_url = 'wssm_email_validation'; 



	public function __construct(){
		parent::__construct();
		//add_action('init', array( $this,'stl_common_initfn'));
		//add_action( 'template_redirect',array( $this,'stl_common_templredirect'));
		add_action('wp_ajax_SaveAccountInfo', array( $this,'SaveAccountInfo'));
		add_action( 'wp_ajax_nopriv_SaveAccountInfo', array( $this,'SaveAccountInfo') );
		add_action('wp_ajax_SaveAccountCupon', array( $this,'SaveAccountCupon'));
		add_action( 'wp_ajax_nopriv_SaveAccountCupon', array( $this,'SaveAccountCupon') );
		add_action('wp_ajax_getCardDetails', array( $this,'getCardDetails'));
		add_action( 'wp_ajax_nopriv_getCardDetails', array( $this,'getCardDetails') );
		add_action('wp_ajax_SaveCardInfo', array( $this,'SaveCardInfo'));
		add_action( 'wp_ajax_nopriv_SaveCardInfo', array( $this,'SaveCardInfo') );
		add_action('wp_ajax_AddCardInfo', array( $this,'AddCardInfo'));
		add_action( 'wp_ajax_nopriv_AddCardInfo', array( $this,'AddCardInfo') );
		add_action('wp_ajax_DeleteCardInfo', array( $this,'DeleteCardInfo'));
		add_action( 'wp_ajax_nopriv_DeleteCardInfo', array( $this,'DeleteCardInfo') );
		add_action('wp_ajax_CancelSubscription', array( $this,'CancelSubscription'));
		add_action( 'wp_ajax_nopriv_CancelSubscription', array( $this,'CancelSubscription') );
		add_action('wp_ajax_ReactiveSubscription', array( $this,'ReactiveSubscription'));
		add_action( 'wp_ajax_nopriv_ReactiveSubscription', array( $this,'ReactiveSubscription') );
		add_action('wp_ajax_addSubscriptionCoupon', array( $this,'addSubscriptionCoupon'));
		add_action( 'wp_ajax_nopriv_addSubscriptionCoupon', array( $this,'addSubscriptionCoupon') );
		add_action('wp_ajax_UpdateSubPaymenttype', array( $this,'UpdateSubPaymenttype'));
		add_action( 'wp_ajax_nopriv_UpdateSubPaymenttype', array( $this,'UpdateSubPaymenttype') );
		add_action('wp_ajax_PayInvoice', array( $this,'PayInvoice'));
		add_action( 'wp_ajax_nopriv_PayInvoice', array( $this,'PayInvoice') );
		add_action('wp_ajax_getMeterUsageDetails', array( $this,'getMeterUsageDetails'));
		add_action( 'wp_ajax_nopriv_getMeterUsageDetails', array( $this,'getMeterUsageDetails') );
		add_action('wp_ajax_getNextInvoiceDetails', array( $this,'getNextInvoiceDetails'));
		add_action( 'wp_ajax_nopriv_getNextInvoiceDetails', array( $this,'getNextInvoiceDetails') );
		add_action('wp_ajax_addNewsubscription', array( $this,'addNewsubscription'));
		add_action( 'wp_ajax_nopriv_addNewsubscription', array( $this,'addNewsubscription') );
		add_action('wp_ajax_savePlanBeforeReglogin', array( $this,'savePlanBeforeReglogin'));
		add_action( 'wp_ajax_nopriv_savePlanBeforeReglogin', array( $this,'savePlanBeforeReglogin') );

		add_action('wp_ajax_changeEmailid', array( $this,'changeEmailid'));
		add_action( 'wp_ajax_nopriv_changeEmailid', array( $this,'changeEmailid') );

		add_action('wp_ajax_registerAction', array( $this,'registerAction'));
		add_action( 'wp_ajax_nopriv_registerAction', array( $this,'registerAction') );

		add_action('wp_ajax_loginAction', array( $this,'loginAction'));
		add_action( 'wp_ajax_nopriv_loginAction', array( $this,'loginAction') );

		add_action('wp_ajax_resendEmailVerification', array( $this,'resendEmailVerification'));
		add_action( 'wp_ajax_nopriv_resendEmailVerification', array( $this,'resendEmailVerification') );
		add_action('wp_ajax_checkEmailalreadyexists', array( $this,'checkEmailalreadyexists'));
		add_action( 'wp_ajax_nopriv_checkEmailalreadyexists', array( $this,'checkEmailalreadyexists') );

		add_action('wp_ajax_saveAdditionalUser', array( $this,'saveAdditionalUser'));
		add_action( 'wp_ajax_nopriv_saveAdditionalUser', array( $this,'saveAdditionalUser') );
		add_action('wp_ajax_deleteAdditionalUser', array( $this,'deleteAdditionalUser'));
		add_action( 'wp_ajax_nopriv_deleteAdditionalUser', array( $this,'deleteAdditionalUser') );

	}

	public function SaveAccountInfo(){
		try{
			$customerdata = parent::saveCustomerInfo($_POST);
			echo json_encode($customerdata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	public function SaveAccountCupon(){
		try{
			$customerdata = parent::addCustomerCuponcode($_POST);
			echo json_encode($customerdata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	
	public function getCardDetails(){
		try{
			
			$customerdata = parent::getCustomerCardDetails($_POST);
			echo json_encode($customerdata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	public function SaveCardInfo(){
		try{
			$customerdata = parent::updateCardInfo($_POST);
			echo json_encode($customerdata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}
	public function AddCardInfo(){
		try{
			$customerdata = parent::addnewCardInfo($_POST);
			echo json_encode($customerdata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	public function DeleteCardInfo(){
		try{
			$customerdata = parent::deleteCardInfomation($_POST);
			echo json_encode($customerdata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	
	public function CancelSubscription(){
		try{
			$subid = (isset($_POST['subid']))?$_POST['subid']:'';
			$subscriptiondata = parent::cancelCustomerSubscription($subid);
			echo json_encode($subscriptiondata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}
	public function ReactiveSubscription(){
		try{
			$subid = (isset($_POST['subid']))?$_POST['subid']:'';
			$subscriptiondata = parent::reactiveCustomerSubscription($subid);
			echo json_encode($subscriptiondata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}
	public function addSubscriptionCoupon(){
		try{
			$subid = (isset($_POST['subid']))?$_POST['subid']:'';
			$couponid = (isset($_POST['couponid']))?$_POST['couponid']:'';
			$customer_id = (isset($_POST['customer_id']))?$_POST['customer_id']:'';
			$subscriptiondata = parent::addCustomerSubscriptionCoupon($customer_id,$subid,$couponid);
			echo json_encode($subscriptiondata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}
	
	public function UpdateSubPaymenttype(){
		try{
			$subid = (isset($_POST['subid']))?$_POST['subid']:'';
			$payment_type = (isset($_POST['payment_type']))?$_POST['payment_type']:'';
			$subscriptiondata = parent::updateSubscriptionPaymenttype($_POST);
			echo json_encode($subscriptiondata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	public function PayInvoice(){
		try{
			$customerdata = parent::PaystripeInvoice($_POST);
			echo json_encode($customerdata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	public function getNextInvoiceDetails(){
		try{
			$invoicedata = parent::getCustomerNextInvoiceDetails($_POST);
			echo json_encode($invoicedata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}
	public function getMeterUsageDetails(){
		try{
			$invoicedata = parent::getCustomerMeterUsageDetails($_POST);
			echo json_encode($invoicedata);
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	public function addNewsubscription(){
		try{
			$successdata = parent::saveNewSubscriptionDetails($_POST);
			echo json_encode($successdata);
		}
		catch (Exception $e) {
			// echo "<pre>";print_r($e);echo "</pre>";
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	}

	public function savePlanBeforeReglogin(){
		try{
			global $wpdb;
			// echo "<pre>";print_r($_POST);echo "</pre>";
			$product_plans = (isset($_POST['product_plans']))?$_POST['product_plans']:'';
			$product_plans=serialize($product_plans);
			$user_activation_code = md5(rand());
			$wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('plan_details' => $product_plans,'activation_code' => $user_activation_code, 'status_type' => 'reglogin') );
			$lastid = $wpdb->insert_id;
			echo json_encode(array('actcode' => $user_activation_code));
		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	
	}

	public function postArray($postdata,$key){
		return isset($postdata[$key]) ? $postdata[$key] : '';
	}

	public function updateUserMeta($uid , $postdata){
		update_user_meta( $uid, 'wssm_company_name', $this->postArray($postdata,'company_name'));
			update_user_meta( $uid, 'wssm_address_line1', $this->postArray($postdata,'address_line1'));
			update_user_meta( $uid, 'wssm_address_line2', $this->postArray($postdata,'address_line2'));
			update_user_meta( $uid, 'wssm_city', $this->postArray($postdata,'city'));
			update_user_meta( $uid, 'wssm_state', $this->postArray($postdata,'state'));
			update_user_meta( $uid, 'wssm_postal_code', $this->postArray($postdata,'postal_code'));
			update_user_meta( $uid, 'wssm_country', $this->postArray($postdata,'country'));
			update_user_meta( $uid, 'wssm_phone', $this->postArray($postdata,'phone'));
	}

	public function changeEmailid(){
		try{
			global $wpdb;
			$user = wp_get_current_user();
	    	$uid  = (int) $user->ID;

	    	$emailid = (isset($_POST['emailid']))?$_POST['emailid']:'';
			$oldemailid = (isset($_POST['oldemailid']))?$_POST['oldemailid']:'';

			if(email_exists( $emailid ))
				throw new Exception(__('Email already in use!','wp_stripe_management'));
			
			$this->updateUserMeta($uid,$_POST);
			$product_plans=serialize($this->postArray($_POST,'product_plans'));

			$user_activation_code = md5(rand());

			$wpdb->insert( WSSM_USERPLAN_TABLE_NAME, array('plan_details' => $product_plans, 'user_oldemail' => $oldemailid,'user_newemail' => $emailid,'status_type' => 'changeemail','activation_code' => $user_activation_code) );

			$wpstlemail =new WPStlEmailManagement();
			$wpstlemail->changeUserEmailid($oldemailid,$emailid,$user_activation_code);

			echo json_encode(array('actcode' => $user_activation_code,'message' =>  __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management')));

		}
		catch (Exception $e) {
			http_response_code(403);
			echo $e->getMessage();
		}
		exit;
	
	}

	public function pdArray($postdata, $key) {
        return isset($postdata[$key]) ? $postdata[$key] : '';
    }

    public function userplanUpdate($data_arr,$where_arr){
    	global $wpdb;
    	return $wpdb->update( WSSM_USERPLAN_TABLE_NAME, $data_arr, $where_arr);
    }
    public function userplanCreate($data_arr){
    	global $wpdb;
    	return $wpdb->insert( WSSM_USERPLAN_TABLE_NAME, $data_arr);
    }

	public function registerAction(){
		try{
			
			$actcode = $this->pdArray($_POST, 'actcode');
			$email = $this->pdArray($_POST, 'email');

			$data_arr = array('full_name' => $this->pdArray($_POST, 'full_name'),'password' => $this->pdArray($_POST, 'password'),'user_oldemail' =>$email,'created_on' => date('Y-m-d H:i:s'),'status_type' => 'accessreg' );

			if($actcode !='')
				$update_status = $this->userplanUpdate($data_arr,array('activation_code' => $actcode));
			else
			{
				$actcode = md5(rand());
				$data_arr['activation_code'] = $actcode;
				$update_status = $this->userplanCreate($data_arr);
			}
			
			if(!$update_status)
				throw new Exception(__('Error in user creation. Please try again!','wp_stripe_management'));


			$wpstlemail =new WPStlEmailManagement();
	        $wpstlemail->registerVerficationEmail($email,$actcode,$this->pdArray($_POST, 'rpage'));

	        $return_data = array('message' => __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management'));


	        echo json_encode($return_data);
		}
		  catch(Exception $e) {
            http_response_code(403);
			echo $e->getMessage();
        }
    	exit;
	}
	public function loginAction(){
		try{
			if (!session_id())
    			session_start();
			global $wpdb;
			$try_count = 0;
			
			$login_pwdrequired = (isset($_POST['login_pwdrequired']))?$_POST['login_pwdrequired']:'';
			
		
    		if($login_pwdrequired == '')
    			$return_data = $this->loginWithPassword($_POST,$try_count);
    		else
    			$return_data = $this->loginWithoutPassword($_POST);
    	
    		echo json_encode($return_data);

    	}
		catch(Exception $e) {
			// echo "<pre>";print_r($e);echo "</pre>";
            http_response_code(403);
			echo $e->getMessage();
        }

    	exit;
	}
	public function loginWithPassword($postdata,$try_count){
		$login_data = array();  
		$stl_transient_name = $this->pdArray($_SESSION,'stl_transient_name'); 
		$stl_transient_mail = $this->pdArray($postdata,'email'); 
    	$stl_transient_new = 'attempted_login_'.$stl_transient_mail;
    	$login_data['user_login'] = $stl_transient_mail;  
		$login_data['user_password'] = $postdata['password'];
		$until = get_option( '_transient_timeout_' . $stl_transient_name );

		if ( $stl_transient_name !='' && $stl_transient_new == $stl_transient_name  && get_transient( $stl_transient_name ) ) {

    		$datas = get_transient( $stl_transient_name );
    		$try_count = $datas['tried'];

    		if ( $datas['tried'] < 4 ) 
    			return $this->checkLogin($login_data,$try_count);
			else
				return array('login_success'=>false,'message' => 'You have reached authentication limit, you will be able to try again in '.time_to_go( $until ).'.' );
	    } 
	    else
	    	return $this->checkLogin($login_data,$try_count);


	}
	public function checkLogin($login_data,$try_count){

		$user_verify = wp_signon( $login_data, true );   
		if ( !is_wp_error($user_verify) )   
			return array('login_success'=>true,'message' => __('Logged in successfully','wp_stripe_management'));
		else
		{
			$try_count++;
			return array('login_success'=>false,'try_count' => $try_count,'message' => __('Invalid username or password. Please try again!','wp_stripe_management'));

		}
		

	}
	public function loginWithoutPassword($postdata){
		$actcode = $this->pdArray($postdata,'actcode');
		$rpage = $this->pdArray($postdata,'rpage'); 

		if($actcode =='')
		{
			$actcode = md5(rand());
			$data_arr = array('user_oldemail' => $postdata['email'],'created_on' => date('Y-m-d H:i:s'),'status_type' => 'accesslogin','activation_code' => $actcode);
			$this->userplanCreate($data_arr);
			// echo "actcode = ".$actcode;exit;
		}
		// echo "actcode = ".$actcode;exit;
    	$wpstlemail =new WPStlEmailManagement();
        $stl_status =  $wpstlemail->loginVerficationEmail($postdata['email'],$actcode,$rpage);

        return array('login_success'=>true,'message' => __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management'));
	}

	public function saveAdditionalUser(){
		try{

			$email =$_POST['email'];
			$actcode = md5(rand());

			$update_status = $this->userplanCreate(array('full_name' => $_POST['full_name'],'password' => $_POST['password'],'user_oldemail' =>$email,'phone_number' => $_POST['phone_number'],'created_on' => date('Y-m-d H:i:s'),'status_type' => 'additional_user_add' ,'activation_code' => $actcode,'plan_details' => $_POST['parent_userid']));

			if(!$update_status)
				throw new Exception(__('Error in user creation. Please try again!','wp_stripe_management'));

			$wpstlemail =new WPStlEmailManagement();
	        $wpstlemail->additionalUserVerficationEmail($email,$actcode,'additional_users');

	        $return_data = array('stl_status'=>true,'message' => __('Email Verification send to the user mail id. Please check the added mail and verify it','wp_stripe_management'));
	      
			echo json_encode($return_data);
		}
		catch(Exception $e) {
            http_response_code(403);
			echo $e->getMessage();
        }

 
    	exit;
	}

	public function deleteAdditionalUser(){
		global $wpdb;
		try{

			if($_POST['user_type'] == 'inactive_user')
			{
				$update_status = $wpdb->query("DELETE  FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE suser_id = '".$_POST['user_id']."'");
				if(!$update_status)
					throw new Exception(__('Error in user deletion. Please try again!','wp_stripe_management'));

			}
			else{
				wp_delete_user($_POST['user_id']);
				$meat_update = parent::updateCustomerMetaUser();
			}
			echo json_encode(array('message' => __('User details deleted successfully','wp_stripe_management')));
		
		}
		catch(Exception $e) {
            http_response_code(403);
			echo $e->getMessage();
        }

 		
    	exit;
	}

	public function resendEmailVerification(){
		try{
			$actcode = $this->pdArray($_POST,'actcode');

			$wpstlemail =new WPStlEmailManagement();
	        $stl_status =  $wpstlemail->resendVerficationEmail($actcode);

			echo json_encode(array('message' => __('Email Verification send to your mail id. Please check your mail and verify it','wp_stripe_management')));
		}
		catch(Exception $e) {
            http_response_code(403);
			echo $e->getMessage();
        }
		exit;
	}

	public function checkEmailalreadyexists(){
		// require_once("../../../../wp-load.php");
		// echo "<pre>";print_r($_POST);echo "</pre>";
		
		$check_status = 'true';
		$emailtype  =(isset($_POST['emailtype']))?$_POST['emailtype']:'accountadd';
		
		switch($emailtype)
		{
			case 'logincheck':
				$email = $this->pdArray($_POST,'email');
				$email_exitid = email_exists( $email );
				if($email_exitid)
					$check_status = 'true';
				else
					$check_status = 'false';
				break;
			case 'accountadd':
				$email = $this->pdArray($_POST,'email');
				$email_exitid = email_exists( $email );
				if($email_exitid)
					$check_status = 'false';
				else
					$check_status = 'true';
				break;
			case 'accountunameadd':
				$full_name = $this->pdArray($_POST,'full_name');
				$uname_exitid = username_exists( $full_name );
				if($uname_exitid)
					$check_status = 'false';
				else
					$check_status = 'true';
				break;
			case 'accountedit':
				$email = $this->pdArray($_POST,'emailid');
				$old_emailid = $this->pdArray($_POST,'old_emailid');
				if($old_emailid != $email)
				{
					$email_exitid = email_exists( $email );
					// echo "email_exitid = ".$email_exitid;
					if($email_exitid)
						$check_status = 'false';
					else
						$check_status = 'true';
				}
				else 
					$check_status = 'true';
				break;
			default:
				$check_status = 'true';
		}
		echo $check_status;
		// if($emailtype == 'accountadd')
		// {
		// 	$email = $this->pdArray($_POST,'email');
		// 	$email_exitid = email_exists( $email );
		// 	if($email_exitid)
		// 	{
		// 		echo 'false';
		// 	}
		// 	else
		// 	{
		// 		echo 'true';
		// 	}
		// }
		// else if($emailtype == 'accountunameadd')
		// {
		// 	$full_name = $this->pdArray($_POST,'full_name');
		// 	$uname_exitid = username_exists( $full_name );
		// 	if($uname_exitid)
		// 	{
		// 		echo 'false';
		// 	}
		// 	else
		// 	{
		// 		echo 'true';
		// 	}
		// }
		// else if($emailtype == 'accountedit' )
		// {
		// 	$email = $this->pdArray($_POST,'emailid');
		// 	$old_emailid = $this->pdArray($_POST,'old_emailid');
		// 	if($old_emailid != $email)
		// 	{
		// 		$email_exitid = email_exists( $email );
		// 		// echo "email_exitid = ".$email_exitid;
		// 		if($email_exitid)
		// 		{
		// 			echo 'false';
		// 		}
		// 		else
		// 		{
		// 			echo 'true';
		// 		}
		// 	}
		// 	else{echo 'true';}
		// }
		// else{echo 'true';}
		exit;
	}

	public function volumePlanPrice($tiers,$stl_qty){
		foreach($tiers as $key=>$value){
			if ($stl_qty <= $value['up_to'] || $value['up_to'] == '')
				return ($value['unit_amount'] * $stl_qty)+$value['flat_amount'];
		}
	}
	public function nonvolumePlanPrice($tiers,$stl_qty){
		$flat_amount = $unit_amount = $up_to = 0;
		$remaing_qty = $stl_qty;
		$graduated_total = $from_val = 0;

		foreach($tiers as $key=>$value){
			if($remaing_qty <= 0)
				break;

			$up_to = $value['up_to'];
			$remaing_qty = $stl_qty - $from_val;
			if($remaing_qty > 0)
			{
				if ($up_to != '' ) 
				{
					$between_val = $up_to - $from_val;
					if($remaing_qty >= $between_val)
						$graduated_total += ($between_val*$value['unit_amount'])+$value['flat_amount'];
					else
						$graduated_total += ($remaing_qty*$value['unit_amount'])+$value['flat_amount'];
				}
				else
					$graduated_total += ($remaing_qty*$value['unit_amount'])+$value['flat_amount'];
				$from_val = $up_to;
			}

		}
		return $graduated_total;
	}
	public function getNonMeteredProductPrice($plandata,$subitem){
		$tiers = $plandata->tiers;
		$stl_qty = $subitem->quantity;
		$amount = $plandata->amount;
		$transform_usage = $plandata->transform_usage;

		switch($plandata->billing_scheme)
		{
			case 'tiered':
				if($plandata->tiers_mode == 'volume')
					$stl_price_val = $this->volumePlanPrice($tiers,$stl_qty);
				else
					$stl_price_val =  $this->nonvolumePlanPrice($tiers,$stl_qty);
				break;
			case ('per_unit' && $transform_usage == null):
				$stl_price_val = $amount * $stl_qty;
				break;
			case ('per_unit' && $transform_usage != null):
				$remaing_val = $stl_qty/$transform_usage['divide_by'];	
				if($transform_usage['round'] == 'up')
					$remaing_val = ceil($remaing_val);
				else
					$remaing_val = floor($remaing_val);
				$stl_price_val = $amount * $remaing_val;
				break;
			default:
				$stl_price_val = $amount * $stl_qty;
				break;

		}
		return $stl_price_val;
	}
	public function calculateTaxPrice($subitem,$stl_price_val){
		foreach($subitem->tax_rates as $tax_rate)
		{
			$tax_percentage = $tax_rate->percentage;
			if($tax_rate->inclusive !='')		
				$tax_off = ($stl_price_val*$tax_percentage)/($tax_percentage+100);
			else
			{		
				$tax_off = ($stl_price_val * $tax_percentage)/100;
				if($tax_off > 1)
					$stl_price_val = $stl_price_val + $tax_off;			
			}
		}
		return $stl_price_val;
	}
	public function getTaxInclusive($subitem){
		foreach($subitem->tax_rates as $tax_rate)
		{
			return $tax_rate->inclusive;
		}
	}
	public function getTaxPercentage($subitem){
		foreach($subitem->tax_rates as $tax_rate)
		{
			return $tax_rate->percentage;
		}
	}
	public function getSubscriptionTotal($subscription_id,$discount)
	{
		$plan_subtotal = 0;

		$subitems = parent::getSubscriptionItems($subscription_id);
		foreach($subitems as $subitem){
			$plan_total = 0;
			$plandata = $subitem->plan;
			
			if($plandata !='')
			{
				$stl_price_val = 0;
				
				if($plandata->usage_type == 'metered')
					$plan_total = 0;
				else
				{
					$stl_price_val = $this->getNonMeteredProductPrice($plandata,$subitem);
					$stl_price_val = $this->calculateTaxPrice($subitem,$stl_price_val);
					$plan_subtotal += $stl_price_val;
				}
			}
		}


		// $plan_total = $plan_subtotal;
		$plan_total = $this->applyCouponCode($discount,$subitem,$plan_subtotal);

		$plan_total_txt = number_format($plan_total,2);
		return $plan_total;
	}
	public function applyCouponCode($discount,$subitem,$plan_total){
		$apply_coupon = (isset($discount['coupon']))?$discount['coupon']:'';
		$amount_off = (isset($discount['coupon']['amount_off']))?$discount['coupon']['amount_off']:'';
		$percent_off = (isset($discount['coupon']['percent_off']))?$discount['coupon']['percent_off']:'';

		if($apply_coupon == '')
		{
			$customerdata = parent::getStripeCustomerbasic();
			if(empty($customerdata['discount'])) return $plan_total;
			
			$apply_coupon = $customerdata['discount']['coupon'];
			$percent_off = isset($apply_coupon['percent_off'])?$apply_coupon['percent_off']:'';
			$amount_off = isset($apply_coupon['amount_off'])?$apply_coupon['amount_off']:'';
			
		}
		if($apply_coupon =='') return $plan_total;
				
		// $tax_inclusive = $this->getTaxInclusive($subitem);
		// $tax_percentage = $this->getTaxPercentage($subitem);

		if($percent_off !='')
			$amount_off = ($plan_total * $percent_off)/100;
		$plan_total = $plan_total - $amount_off;	

		// if($tax_inclusive !='')
		// {	
		// 	if($percent_off !='')
		// 		$amount_off = ($plan_total * $percent_off)/100;
		// 	$plan_total = $plan_total - $amount_off;
		// }

		// else if($tax_percentage !='')
		// {
		// 	if($percent_off !='')
		// 		$amount_off = ($plan_total * $percent_off)/100;
		// 	$plan_total = $plan_total - $amount_off;
		// }
		// else
		// {
		// 	if($percent_off !='')
		// 		$amount_off = ($plan_total * $percent_off)/100;
		// 	$plan_total = $plan_total - $amount_off;	
		// }
		return $plan_total;
	}
	

}