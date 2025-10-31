<?php
class WPStlStripeManagement {
	public $wssm_stripe_client_id;
    public $wssm_stripe_public_key;
    public $wssm_stripe_secret_key;
    public $wssm_stripe_mode;
    public $wssm_stripe_productid;
    public $wssm_stripe_access_token;
    public $wssm_stripe_user_id;


	public function __construct(){
		global $stl_user_id;
		$this->wssm_stripe_mode = get_option('wssm_stripe_mode','test');
		if($this->wssm_stripe_mode == 'test')
		{
			$this->wssm_stripe_client_id = get_option('wssm_test_client_id','');
        	$this->wssm_stripe_public_key = get_option('wssm_test_public_key','');
        	$this->wssm_stripe_secret_key = get_option('wssm_test_secret_key','');
        	$this->wssm_stripe_productid = get_option('wssm_test_product_id','');
        	$this->wssm_stripe_access_token = get_user_meta( $stl_user_id, 'wssm_test_access_token', true);
        	$this->wssm_stripe_user_id = get_user_meta( $stl_user_id, 'wssm_stripe_test_user_id', true);
		}
		else
		{
        	$this->wssm_stripe_client_id = get_option('wssm_live_client_id','');
        	$this->wssm_stripe_public_key = get_option('wssm_live_public_key','');
        	$this->wssm_stripe_secret_key = get_option('wssm_live_secret_key','');
        	$this->wssm_stripe_productid = get_option('wssm_live_product_id','');
        	$this->wssm_stripe_access_token = get_user_meta( $stl_user_id, 'wssm_live_access_token', true);
        	$this->wssm_stripe_user_id = get_user_meta( $stl_user_id, 'wssm_stripe_live_user_id', true);
		}

        $this->apiKey();


	}

    public function apiKey() {
        if (!isset($this->wssm_stripe_secret_key))
           throw new Exception('The Stripe key was not added correctly');
        \Stripe\Stripe::setApiKey($this->wssm_stripe_secret_key);
    }

    public function getAllCustomerlistbymail()
    {
        global $stl_user_email;
        if($stl_user_email == '') return false;

        $customers = \Stripe\Customer::all(['email' => $stl_user_email,"limit" => 3]);

        if(empty($customers['data'])) return false;
        $customer_datas = (isset($customers['data']['0']))?$customers['data']['0']:array();
        foreach ($customers->autoPagingIterator() as $customer) {
            // echo "<pre>";print_r($customer);echo "</pre>";
            $meta_select = (isset($customer['metadata']['select']))?$customer['metadata']['select']:'';
            if($meta_select == 'ok')
            {
                $customer_datas = $customer;
                break;
            }
        }


        // // echo "stl_user_email = ".$stl_user_email;
        // $customerlists =  \Stripe\Customer::all(['email' => $stl_user_email,'limit' => 10]);
        // // return $customerlists['data'];
        // // echo "<pre>";print_r($customerlists);echo "</pre>";
        // if(empty($customerlists['data'])) return true;
        //  $customer_datas['0'] = (isset($customerlists['data']['0']))?$customerlists['data']['0']:array();
        // foreach($customerlists['data'] as $customerlist)
        // {
        //     $meta_select = (isset($customerlist['metadata']['select']))?$customerlist['metadata']['select']:'';
        //     if($meta_select == 'ok')
        //     {
        //         $customer_datas['0'] = $customerlist;
        //         break;
        //     }

        // }
        return $customer_datas;
    }
    public function getAllCustomerbymail($customer_email)
    {
        $customers = \Stripe\Customer::all(['email' => strtolower($customer_email),"limit" => 3]);

        if(empty($customers['data'])) return true;
        $customer_datas = (isset($customers['data']['0']))?$customers['data']['0']:array();
        foreach ($customers->autoPagingIterator() as $customer) {
            // echo "<pre>";print_r($customer);echo "</pre>";
            $meta_select = (isset($customer['metadata']['select']))?$customer['metadata']['select']:'';
            if($meta_select == 'ok')
            {
                $customer_datas = $customer;
                break;
            }
        }
        return $customer_datas;
    }
    public function updateCustomerEmailID($customer_email,$new_emailid)
    {
        $v4uidd = $this->gen_uuid();
        $customerlists =  $this->getAllCustomerbymail($customer_email);


        // $customerlists = \Stripe\Customer::all(['email' => $customer_email,'limit' => 1]);
        // if(!empty($customerlists))
        // {
        //     foreach($customerlists['data'] as $customer_data)
        //     {
                $customerdetails = \Stripe\Customer::update($customerlists['id'],['email' => strtolower($new_emailid)],["Idempotency-Key" => $v4uidd]);
        //     }
        // }

        return $customerlists;
    }
    public function getStripeCustomerbasic(){
        try {

            $customerlists =  $this->getAllCustomerlistbymail();


            if(empty($customerlists))
                return array('stl_status' => false, 'message' => 'Stripe customer not found for this user emailid.');

            $customerdetails = $customerlists;
            $customerdetails['stl_status'] = true;
            // }
            // else
            // {
            //     $customerdetails = array('stl_status' => false, 'message' => 'Stripe customer not found for this user emailid.');
            // }                

        }
        catch(Exception $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $customerdetails = array('stl_status' => false, 'message' => $err['message']);
        }
        return $customerdetails;
    }
    public function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public function getCustomerarr($postdata){
        $company_name = (isset($postdata['company_name']))?$postdata['company_name']:'';
        if($company_name == '')
            $company_name = $postdata['full_name'];


        $customer_array = array(
            'name' => $company_name,
            'email' => strtolower($this->pdArray($postdata, 'emailid')),
            'phone' => $this->pdArray($postdata, 'phone'),
            'address' => [
                'line1' => $this->pdArray($postdata, 'address_line1'),
                'line2' => $this->pdArray($postdata, 'address_line2'),
                'city' => $this->pdArray($postdata, 'city'),
                'state' => $this->pdArray($postdata, 'state'),
                'country' => $this->pdArray($postdata, 'country'),
                'postal_code' => $this->pdArray($postdata, 'postal_code'),
                ],
                'metadata' => ['fullname' => $this->pdArray($postdata, 'full_name')]
        );
        return $customer_array;
    }
    public function getCustomerBasicarr($postdata){

        $cusarr = array(
                'name' => $this->pdArray($postdata, 'company_name'),
                // 'email' => $this->pdArray($postdata, 'emailid'),
                'phone' => $this->pdArray($postdata, 'phone'),
                'address' => [
                    'line1' => $this->pdArray($postdata, 'address_line1'),
                    'line2' => $this->pdArray($postdata, 'address_line2'),
                    'city' => $this->pdArray($postdata, 'city'),
                    'state' => $this->pdArray($postdata, 'state'),
                    'country' => $this->pdArray($postdata, 'country'),
                    'postal_code' => $this->pdArray($postdata, 'postal_code'),
                ]);

        if($postdata['old_emailid'] == $postdata['emailid'])
            $cusarr['email'] = strtolower($this->pdArray($postdata, 'emailid'));
        return $cusarr;
    }

    public function check_username_exist($original_name,$full_name,$digits = 0){

        if(!username_exists( $full_name))
            return $full_name;

        $digits = (int) $digits+1;
        $full_name = $original_name."_".$digits;

        return $this->check_username_exist($original_name,$full_name,$digits);

        
    }


    public function updateFullname($postdata){
        global $parent_userid;
        if($postdata['old_full_name'] == $postdata['full_name'])
            return true;

        $full_name = $postdata['full_name'];
        update_user_meta($parent_userid, 'nickname', $full_name);


    }

    public function saveCustomerInfo($postdata = array()){

        $customerarr = $this->getCustomerBasicarr($postdata);
        $user_activation_code = '';
        $message = __('Account information saved successfully.','wp_stripe_management');
        $customer_data = $this->saveCustomer($postdata['customer_id'],$customerarr);

        $this->updateFullname($postdata);

        if($postdata['old_emailid'] != $postdata['emailid'])
        {
            $wpstlemail =new WPStlEmailManagement();
            $user_activation_code = $wpstlemail->emailAccountinfoEmailEdit(strtolower($postdata['old_emailid']),strtolower($postdata['emailid']));
            $message = __('A verification email has been sent to your new mail id. Kindly check your mail and verify it.','wp_stripe_management');
            // $user_activation_code = 2;
        }
            
        $meat_update = $this->updateCustomerMetaUser();
        return array('message' => $message,'user_activation_code' => $user_activation_code);

    }

    public function addCustomerCuponcode($postdata = array()){
        $v4uidd = $this->gen_uuid();
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;
        // foreach($customerdatas as $customerdata)
        // {
            $customerdetails = \Stripe\Customer::update($customerdatas['id'],['coupon' => $postdata['coupon']],["Idempotency-Key" => $v4uidd]);
        // }
        return true;
    }
    public function updateEmptymeta(){
        $meta_details_arr = array();
        for($ss = 1;$ss<15;$ss++)
            {
                $meta_details_arr['email.'.$ss] = '';
                $meta_details_arr['fullname.'.$ss] = '';
                $meta_details_arr['phone.'.$ss] = '';
            }
        return $meta_details_arr;
    }

    public function getCustomerMeta(){
        global $parent_userid;
        $active_user_lists = get_users(array('meta_key' => 'parent_user_id','meta_value' => $parent_userid,'count_total' => false));
        $meta_details_arr = $this->updateEmptymeta();
        $meta_count = 0;
            foreach($active_user_lists as $active_user_list)
            {
                $meta_count++;

                // $display_name = $active_user_list->display_name;
                // $user_email = $active_user_list->user_email;
                $teuser_id = $active_user_list->ID;
                $phone = get_user_meta($teuser_id,'phone_number',true);
                $meta_details_arr['fullname.'.$meta_count] = $active_user_list->nickname;
                $meta_details_arr['email.'.$meta_count] = strtolower($active_user_list->user_email);
                $meta_details_arr['phone.'.$meta_count] = $phone;
            }
            return $meta_details_arr;
    }

    public function updateCustomerMetaUser(){
        global $parent_userid;
        $v4uidd = $this->gen_uuid();
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;
        
        $user_info = get_userdata($parent_userid);
        $username = $user_info->nickname;

        $meta_details_arr = $this->getCustomerMeta();
        $meta_details_arr['fullname'] = $username;

        // foreach($customerdatas as $customerdata)
        // {
            $customerdetails = \Stripe\Customer::update($customerdatas['id'],['metadata' => $meta_details_arr],["Idempotency-Key" => $v4uidd]);
        // }

        return $customerdetails;
    }

    public function getCustomerCardlist(){
        $card_lists = array();
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;

        $card_datas = \Stripe\Customer::allSources($customerdatas['id'],['limit' => 3,'object' => 'card']);
        foreach ($card_datas->autoPagingIterator() as $card_data) {
            $card_lists[] = $card_data;
        }
        return $card_lists;

    }
    public function getCustomerCardlistold(){
        $card_lists = array();
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;

            $card_data = \Stripe\Customer::allSources($customerdatas['id'],['limit' => 105,'object' => 'card']);
            if(isset($card_data['data']))
            {
                $card_data = $card_data['data'];
                $card_lists = array_merge($card_lists,$card_data);
            }

        return $card_lists;

    }

    public function getCustomerCardDetails($postdata){
        $card_id = $this->pdArray($postdata,'cardid');
        $customerid = $this->pdArray($postdata,'customerid'); 
        return \Stripe\Customer::retrieveSource($customerid,$card_id);
    }

    public function deleteCardInfomation($postdata = array()){
        return \Stripe\Customer::deleteSource($postdata['customer_id'],$postdata['card_id']);
    }


    public function updateCardInfo($postdata = array()){
       
        $v4uidd = $this->gen_uuid();
        return \Stripe\Customer::updateSource(
            $postdata['customer_id'],
            $postdata['card_id'],
            [
                'name' => $postdata['holder_name'],
                'exp_month' => $postdata['expire_month'],
                'exp_year' => $postdata['expire_year'],
                'address_line1' => $postdata['address_line1'],
                'address_line2' => $postdata['address_line2'],
                'address_city' => $postdata['city'],
                'address_state' => $postdata['state'],
                'address_country' => $postdata['country'],
                'address_zip' => $postdata['postal_code']
            ],
            ["Idempotency-Key" => $v4uidd]
        );

    }
    public function createStripeSource($customer_id,$postdata){
        $v4uidd2 = $this->gen_uuid();
        $carddata = \Stripe\Customer::createSource(
                        $customer_id,
                        [
                            'source' => array(
                                'object' => 'card',
                                'name' => $postdata['holder_name'],
                                'number' => $postdata['card_no'],
                                'exp_month' => $postdata['expire_month'],
                                'exp_year' => $postdata['expire_year'],
                                'cvc' => $postdata['ccv'],
                                'address_line1' => $postdata['card_address_line1'],
                                'address_line2' => $postdata['card_address_line2'],
                                'address_city' => $postdata['card_city'],
                                'address_state' => $postdata['card_state'],
                                'address_country' => $postdata['card_country'],
                                'address_zip' => $postdata['card_postal_code']
                            )
                        ],
                        ["Idempotency-Key" => $v4uidd2]
                    );
        return $carddata['id'];
    }
    public function addnewCardInfo($postdata = array()){
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;
        // foreach($customerdatas as $customerdata)
        // {
            $card_id =  $this->createStripeSource($customerdatas['id'],$postdata);
        // }
        return $card_id;
    }

    public function getCustomerInvoicelistold(){
        $invoice_lists = array();
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;
        // foreach($customerdatas as $customerdata)
        // {

            $invoice_data = \Stripe\Invoice::all(['limit' => 100,'customer' => $customerdatas['id']]);
            if(isset($invoice_data['data']))
            {
                $invoice_data = $invoice_data['data'];
                $invoice_lists = array_merge($invoice_lists,$invoice_data);
            }
        // }
        return $invoice_lists;
                


    }

        public function getCustomerInvoicelist(){
        $invoice_lists = array();
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;

        $invoice_datas = \Stripe\Invoice::all(['limit' => 10,'customer' => $customerdatas['id']]);
        foreach ($invoice_datas->autoPagingIterator() as $invoice_data) {
            $invoice_lists[] = $invoice_data;
        }
        return $invoice_lists;
    

    }

    public function getSubscriptionlistDataold($customer_id){
        $subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customer_id ]);
            if(isset($subscription_data['data']))
            {
                $subdata = array();
                foreach($subscription_data['data'] as $subscription)
                {
                    $invoice_data = \Stripe\Invoice::all(['subscription' => $subscription['id'],'limit' => 1]);
                    $subdata_inner = $subscription;
                    $subdata_inner['invoice'] = $invoice_data;
                    $subdata[] = $subdata_inner;
                }
                
            }
        return $subdata;
    }

    public function getSubscriptionItems($subscription_id){
        $subItems = array();
        $sub_datas = \Stripe\SubscriptionItem::all(['subscription' => $subscription_id,'limit' => 10]);
        foreach ($sub_datas->autoPagingIterator() as $sub_data) {
            $subItems[] = $sub_data;
        }
        return $subItems;
    }
    public function getSubscriptionDetails($subscription_id){
        $subItems = array();
        $sub_datas = \Stripe\Subscription::retrieve($subscription_id);
        
        return $sub_datas;
    }

    public function getSubscriptionlistData($customer_id){

        $subdata = array();
        $subscription_datas = \Stripe\Subscription::all(['status' => 'all','limit' => 10,'customer' => $customer_id ]);
        // echo "<pre>";print_r($subscription_datas);echo "</pre>";exit;
        foreach ($subscription_datas->autoPagingIterator() as $subscription) {
            // $sub_data = \Stripe\SubscriptionItem::all(['subscription' => $subscription['id'],'limit' => 10]);
            // echo "<pre>";print_r($sub_data);echo "</pre>";exit;
            // $invoice_data = \Stripe\Invoice::all(['subscription' => $subscription['id'],'limit' => 1]);
            // $subdata_inner = $subscription;
            // $subdata_inner['invoice'] = $invoice_data;
            // $subdata_inner['subitems'] = $this->getSubscriptionItems($subscription['id']);
            // $subdata[] = $subdata_inner;
            $subdata[] = $subscription;
        }


        // $subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customer_id ]);
        //     if(isset($subscription_data['data']))
        //     {
        //         $subdata = array();
        //         foreach($subscription_data['data'] as $subscription)
        //         {
        //             $invoice_data = \Stripe\Invoice::all(['subscription' => $subscription['id'],'limit' => 1]);
        //             $subdata_inner = $subscription;
        //             $subdata_inner['invoice'] = $invoice_data;
        //             $subdata[] = $subdata_inner;
        //         }
                
        //     }
        return $subdata;
    }

    public function getCustomerSubscriptionlist(){
        $subscription_lists = array();

        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;

        $subdata = $this->getSubscriptionlistData($customerdatas['id']);
        $subscription_lists = array_merge($subscription_lists,$subdata);

        return array( 'subscription_lists' => $subscription_lists,'customer_lists' => $customerdatas);


    }

   
    public function subCancelImmediately($subscription_id){
        $subscription_data = \Stripe\Subscription::retrieve($subscription_id);
        $subscription_data->cancel();
        return $subscription_data;
    }
    public function subCancelatEnd($subscription_id){
         $v4uidd = $this->gen_uuid();
        return  \Stripe\Subscription::update($subscription_id,['cancel_at_period_end' => true],["Idempotency-Key" => $v4uidd]);
    }
    public function cancelCustomerSubscription($subscription_id = ''){

        $wssm_stripe_cancel = get_option('wssm_stripe_cancel','immediately');
        $wssm_stripe_cancel_msg = get_option('wssm_stripe_cancel_msg','Subscription canceled');

        if($wssm_stripe_cancel == 'immediately')
            $this->subCancelImmediately($subscription_id);
        else 
            $this->subCancelatEnd($subscription_id);
           
        $subscription_data['message'] = $wssm_stripe_cancel_msg;

        return $subscription_data;
    }

    public function reactiveCustomerSubscription($subscription_id = ''){
        return \Stripe\Subscription::update($subscription_id,['cancel_at_period_end' => false]);
    }

    public function addCustomerSubscriptionCoupon($customer_id = '',$subscription_id = '',$couponid = ''){

        $v4uidd = $this->gen_uuid();
        $customerdetails = \Stripe\Customer::update($customer_id,['coupon' => $couponid],["Idempotency-Key" => $v4uidd]);
        $subscription_data = \Stripe\Subscription::update($subscription_id,['coupon' => $couponid]);
        $subscription_data->cancel();

        return $subscription_data;
    }

    public function getCustomerNextInvoiceDetails($postdata = array()){
        return \Stripe\Invoice::upcoming(["customer" => $postdata['customerid'], 'subscription' => $postdata['subscription_id']]);
    }

    public function getCustomerMeterUsageDetails($postdata = array()){

        $item = \Stripe\SubscriptionItem::retrieve($postdata['subitemid']);
        $subscription_data['usages'] = $item->usageRecordSummaries();
        $subscription_data['item'] = $item;

        return $subscription_data;
    }

    public function updateSubscriptionPaymenttype($postdata = array()){

        $v4uidd = $this->gen_uuid();

        $pay_duedays = get_option('wssm_stripe_pay_duedays',30);
        $payarra = array('collection_method' => $postdata['payment_type']);

        if($postdata['payment_type'] == 'charge_automatically')
            $payarra["default_source"] = $postdata['card_id'];
        else
            $payarra['days_until_due'] = $pay_duedays;

        return \Stripe\Subscription::update($postdata['subid'],$payarra,["Idempotency-Key" => $v4uidd]);

    }

    public function PaystripeInvoice($postdata = array()){

        $v4uidd = $this->gen_uuid();
    
        $invoice_arr = array();
        if($postdata['invpayment_type'] == 'single')
            $invoice_arr[] = (object) $postdata;
        else
            $invoice_arr = json_decode(stripslashes($postdata['invoice_arr']));


        foreach($invoice_arr as $invoice)
        {
            if($postdata['card_type'] != '1')
                $card_id = $this->createStripeSource($invoice->customer_id,$postdata);
            else
                $card_id = $postdata['card_id'];

            $create_chargedata =  \Stripe\Charge::create(
                                [
                                  "amount" => $invoice->invoice_amount,
                                  "currency" => $invoice->invoice_currency,
                                  "customer" => $invoice->customer_id,
                                  "card" => $card_id, // obtained with Stripe.js
                                  "description" => "Payment Success"
                                ],
                                ["Idempotency-Key" => $v4uidd]
            );

            $invoice_data = \Stripe\Invoice::retrieve($invoice->invoice_id);
            $invoice_data->pay();
   
        }

        return true;
    }

    public function getProductPlanList(){
        $plan_arr = array();
        $plan_datas = \Stripe\Plan::all(['limit' => 20]);
        foreach ($plan_datas->autoPagingIterator() as $plan_data) {
            $plan_arr[] = $plan_data;
        }
        return $plan_arr;
    }

    public function getTaxList(){
        $tax_arr = array();
        $tax_datas = \Stripe\TaxRate::all(['limit' => 20,'active' => true]);
        foreach ($tax_datas->autoPagingIterator() as $tax_data) {
            $tax_arr[] = $tax_data;
        }
        return $tax_arr;

            // return \Stripe\TaxRate::all(['limit' => 100,'active' => true]);
    }  

    public function saveCustomer($customer_id,$customer) {
        $v4uidd = $this->gen_uuid();
        try {
            return \Stripe\Customer::update($customer_id,$customer,["Idempotency-Key" => $v4uidd]);
        } catch (Exception $notExist) {
            return \Stripe\Customer::create($customer,["Idempotency-Key" => $v4uidd]);
        }
    }

    public function pdArray($postdata, $key) {
        return isset($postdata[$key]) ? $postdata[$key] : '';
    }

    public function saveInitialItem($customer_id,$postdata){
        $v4uidd1 = $this->gen_uuid();
        $tax_id = $postdata['tax_id'];
        $invoice_itemarr = array('customer' => $customer_id,'amount' => $postdata['initfee_subtotal_act'],'currency' => $postdata['cdefault_currency'],'description' => 'Initial Fee');
        if($tax_id !='') $invoice_itemarr['tax_rates'] = array($tax_id);

        return \Stripe\InvoiceItem::create($invoice_itemarr,["Idempotency-Key" => $v4uidd1]);
    }
    

    public function getInvoiceitems($postdata){
        $tax_id = $postdata['tax_id'];
        $items_array = array();
        $i = 0;
        foreach($postdata['product_plans'] as $product_plan)
        {


            $items_array[$i] = array('plan' => $product_plan['plan_id']);

            if($product_plan['usage_type'] != 'metered')
                $items_array[$i]['quantity'] = $product_plan['qty'];

            if($tax_id != '')
                $items_array[$i]['tax_rates'] = array($tax_id);

            $i++;

            }
        return $items_array;
    }

     

    public function saveNewSubscriptionDetails($postdata){
        // echo "<pre>";print_r($postdata);echo "</pre>";exit;
        $meta_data = array();
        $customer_id = $postdata['customer_id'];

            
        $customer_array = $this->getCustomerarr($postdata);
        $customer_data = $this->saveCustomer($customer_id,$customer_array);

        $customer_id = $customer_data['id'];
        $this->updateCustomerMetaUser();
        $this->saveInitialItem($customer_id,$postdata);


        $initfee_subtotal_act = (float)$postdata['initfee_subtotal_act']/100;
        $initfee_subtotal_act_txt = $postdata['cdefault_currency']." ".$initfee_subtotal_act;
        $meta_data['Initial Fee'] = $initfee_subtotal_act_txt;
            

        $items_array = $this->getInvoiceitems($postdata);


            
        $metadata = $postdata['metadata'];
        // $meta_data = array('application' => 'Root','customer' => 'testtttt meta viji');
        $meta_data = array('application' => $postdata['metadata_application'],'customer' => $postdata['metadata_customer']);
        foreach($metadata as $key => $value)
        {
            $meta_data[$key] = $value;
        }


        $subarr = array("customer" => $customer_id,"collection_method" => $postdata['collection_method'],"items" => $items_array,"metadata" => $meta_data,"payment_behavior" => "allow_incomplete","off_session" =>true,"trial_from_plan" => true);

        if($postdata['apply_coupon'] !='')
            $subarr['coupon'] = $postdata['apply_coupon'];

            
        if($postdata['collection_method'] == 'charge_automatically')
        {    
            $card_id = $this->pdArray($postdata, 'card_id');
            if($postdata['card_type'] != '1')
                $card_id =  $this->createStripeSource($customer_id,$postdata);
            $subarr['default_source'] = $card_id;
        }
        else
        {
            $pay_duedays = get_option('wssm_stripe_pay_duedays',30);
            $subarr['days_until_due'] = $pay_duedays;
        }
           
        $v4uidd3 = $this->gen_uuid();
        return \Stripe\Subscription::create($subarr,["Idempotency-Key" => $v4uidd3]);
            
    }


    public function getCustomerSubscriptionPlanIdsold(){
        $plan_ids = array();



            $customerdatas =  $this->getAllCustomerlistbymail();
            if(!isset($customerdatas['id'])) return false;

                // foreach($customerdatas as $customerdata)
                // {
                    $subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customerdatas['id']]);
                    if(isset($subscription_data['data']))
                    {
                        $subscription_data = $subscription_data['data'];
                        $subdata = array();
                        foreach($subscription_data as $subscription)
                        {
                            $sub_items = $subscription['items']['data'];
                            $sub_status = $subscription['status'];
                            if($sub_status !='canceled')
                            {
                                foreach($sub_items as $sub_item)
                                {
                                    $plan_item = $sub_item['plan'];
                                    if(!empty($plan_item))
                                    {
                                        $plan_ids[] = $plan_item['id'];
                                    }
                                }   
                            }
                        }
                        $plan_ids = array_merge($plan_ids,$subdata);
                    }
                // }
    
        return $plan_ids;
    }
    public function getCustomerSubscriptionPlanIds(){
        $plan_ids = array();
        $subdata = array();
        $customerdatas =  $this->getAllCustomerlistbymail();
        if(!isset($customerdatas['id'])) return false;


        $subscription_data = \Stripe\Subscription::all(['status' => 'all','limit' => 100,'customer' => $customerdatas['id']]);

        foreach ($subscription_data->autoPagingIterator() as $subscription) {

            $sub_items = $subscription['items']['data'];
            $sub_status = $subscription['status'];
            if($sub_status =='canceled')
                continue;
            
            foreach($sub_items as $sub_item)
            {
                $plan_item = $sub_item['plan'];
                if(empty($plan_item))
                    continue;
                $plan_ids[] = $plan_item['id'];
            }   
            
        }

    
        return $plan_ids;
    }
}