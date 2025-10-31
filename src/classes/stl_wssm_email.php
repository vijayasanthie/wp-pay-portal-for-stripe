<?php
class WPStlEmailManagement {
	public $wssm_link_expire;
    public $wssm_email_subject;
    public $wssm_email_sender;
    public $wssm_email_content;

    public function __construct(){
		global $stl_user_id;
		$this->wssm_link_expire = get_option('wssm_link_expire','never');
		$this->wssm_email_subject = get_option('wssm_email_subject','');
        $this->wssm_email_sender = get_option('wssm_email_sender','');
        $this->wssm_email_content = get_option('wssm_email_content','');
	}

	public function registerVerficationEmail($emailid,$actcode,$rpage){

		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');

		if($rpage == '')
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accessreg&wssm_activationcode='.$actcode;
		else
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accessreg&rpage='.$rpage.'&wssm_activationcode='.$actcode;
		
		return $this->mailSend($emailid,$base_url);

	}

	public function additionalUserVerficationEmail($emailid,$actcode,$rpage){
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');

		if($rpage == '')
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=additional_user_add&wssm_activationcode='.$actcode;
		else
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=additional_user_add&rpage='.$rpage.'&wssm_activationcode='.$actcode;

		return $this->mailSend($emailid,$base_url);
	}

	public function loginVerficationEmail($emailid,$actcode,$rpage){
		global $wpdb;
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');


		if($rpage !='')
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accesslogin&rpage='.$rpage.'&wssm_activationcode='.$actcode;
		else
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accesslogin&wssm_activationcode='.$actcode;
    	$wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('user_oldemail' =>$emailid,'created_on' => date('Y-m-d H:i:s') ), array('activation_code' => $actcode));

		return $this->mailSend($emailid,$base_url);

	}

	public function getUserdatas($actcode){
		global $wpdb;
		$emailid = $status_type = '';
		$user_query = new WP_User_Query(array('meta_key'=>'wssm_activationcode','meta_value'=> $actcode));
		$users = $user_query->get_results();

		foreach($users as $user)
		{
			$suser_id = $user->ID;
			$emailid = $user->user_email;
		}


		$user_plans = $wpdb->get_row("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE activation_code = '".$actcode."'");
		// echo "<pre>";print_r($user_plans);echo "</pre>";
		if($user_plans)
		{
			$emailid = $user_plans->user_oldemail;
			$status_type = $user_plans->status_type;
			$wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('user_oldemail' =>$emailid,'created_on' => date('Y-m-d H:i:s') ), array('activation_code' => $actcode));
		}
		else
		{
			update_user_meta( $suser_id, 'wssm_activation_date', date('Y-m-d H:i:s'));
			update_user_meta( $suser_id, 'wssm_old_email', $emailid);
		}
		return array('emailid' => $emailid,'status_type' => $status_type);

	}

	public function resendVerficationEmail($actcode){
		// echo "actcode = ".$actcode;
		$Userdatas = $this->getUserdatas($actcode);
		// echo "<pre>";print_r($Userdatas);echo "</pre>";exit;
		$emailid = $Userdatas['emailid'];
		$status_type = $Userdatas['status_type'];
		// echo "status_type = ".$status_type;exit;

		if($emailid =='')
			throw new Exception(__('Emailid not found','wp_stripe_management'));

		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');

		if($status_type == '')
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=accesslogin&wssm_activationcode='.$actcode;
		else
			$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action='.$status_type.'&wssm_activationcode='.$actcode;

		return $this->mailSend($emailid,$base_url);

	}
	public function changeUserEmailid($old_emailid,$new_emailid,$user_activation_code){
		global $wpdb;
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');

		$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=changemail&wssm_activationcode='.$user_activation_code;

		$wpdb->update( WSSM_USERPLAN_TABLE_NAME, array('created_on' => date('Y-m-d H:i:s') ), array('activation_code' => $user_activation_code));

		return $this->mailSend($new_emailid,$base_url);

	}

	public function emailAccountinfoEmailEdit($old_emailid,$new_emailid){
		$wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');
		$user = wp_get_current_user();
    	$uid  = (int) $user->ID;
    	
		$user_activation_code = md5(rand());

		$base_url = site_url().'/'.$wssm_mail_urlredirect.'?action=update&wssm_activationcode='.$user_activation_code;
		update_user_meta( $uid, 'wssm_activationcode', $user_activation_code);
		update_user_meta( $uid, 'wssm_activation_date', date('Y-m-d H:i:s'));
		update_user_meta( $uid, 'wssm_new_email', $new_emailid);

		$this->mailSend($new_emailid,$base_url);
		return $user_activation_code;
			
	}


	public function mailSend($to_email,$base_url){
		// $headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>','cc: '.$cc_email);
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>','cc: vijayasanthi@stallioni.com');
		// $headers = array('Content-Type: text/html; charset=UTF-8','From: Info <'.$this->wssm_email_sender.'>');
		// $to_email = 'vijayasanthi@stallioni.com';
		$subject = $this->wssm_email_subject;
		$body = $this->wssm_email_content;
		$body = nl2br(htmlspecialchars($body));
		$url_txt = "<a href='".$base_url."'>Click here</a>";
		$body = str_replace("{{LINK}}",$url_txt,$body);

		if(!wp_mail( $to_email, $subject, $body, $headers ))
			throw new Exception(__('Error in mail sending','wp_stripe_management'));

		return true;

	}

}