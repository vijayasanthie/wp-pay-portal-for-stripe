<?php
// echo "tttttttttt";exit;
// echo "<pre>";print_r($subplainids);echo "</pre>";
	$user_plan_details = array();
	$status_type = '';
	$total_txt = __('Total','wp_stripe_management');;
	global $wpdb;
	$suser_id = (isset($_GET['suser_id']))?$_GET['suser_id']:'';
	$wssm_activationcode = (isset($_GET['wssm_activationcode']))?$_GET['wssm_activationcode']:'';
	if($suser_id !='')
	{
		$user_plans = $wpdb->get_row("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE suser_id = '".$suser_id."'");
		// echo "<pre>";print_r($user_plans);echo "</pre>";
		if($user_plans)
		{
			$user_plan_details = $user_plans->plan_details;
			$status_type = $user_plans->status_type;
			$user_plan_details=unserialize($user_plan_details);
			// echo "<pre>";print_r($user_plan_details);echo "</pre>";
		}
	}
	else if($wssm_activationcode !='')
	{
		$user_plans = $wpdb->get_row("SELECT * FROM ".WSSM_USERPLAN_TABLE_NAME." WHERE activation_code = '".$wssm_activationcode."'");
		// echo "<pre>";print_r($user_plans);echo "</pre>";
		if($user_plans)
		{
			$user_plan_details = $user_plans->plan_details;
			$status_type = $user_plans->status_type;
			$user_plan_details=unserialize($user_plan_details);
			// echo "<pre>";print_r($user_plan_details);echo "</pre>";
		}
	}

    $table_name = WSSM_CURCOUNTRY_TABLE_NAME;
	$wssm_default_currency = get_option('wssm_default_currency','');
    $ccmap_results = $wpdb->get_results( "SELECT * FROM ".$table_name );
    // echo "<pre>";print_r($ccmap_results);echo "</pre>";
    $ccmap_json =  json_encode($ccmap_results);
    $planlists_json = json_encode($planlists);
    $subplainids_json = json_encode($subplainids);

    // echo "<pre>";print_r($planlists);echo "</pre>";



	$plan_options = '<option value="">Select product plan</option>';

	    // $planlists_data = $planlists['data'];
	    // echo "<pre>";print_r($planlists_data);echo "</pre>";
	    foreach($planlists as $planlist)
	    {
	    	 $plandata = htmlspecialchars( json_encode($planlist), ENT_COMPAT );
	    	 $plan_id = $planlist['id'];
	    	 if($planlist['nickname'] !='' && !in_array($plan_id, $subplainids))
	    	 {
	    	 	$plan_options .= '<option value="'.$planlist['id'].'" data-interval="'.$planlist['interval'].'" data-plandata="'.$plandata.'">'.$planlist['nickname'].'</option>';
	    	 }
	      	
	    }
	



	$current_user = wp_get_current_user();
	// echo "<pre>";print_r($current_user);echo "</pre>";
	$email = $current_user->user_email;
	$full_name = $current_user->user_login;
	if($full_name == 'Anonymous' || $full_name == 'anonymous')
	{
		$full_name ='';
	}

	$address_line1 = $address_line2 = $city = $state = $country =$postal_code = $company_name = $phone = $customer_id = $percent_off = $amount_off = $amount_off_currency = $coupon_name = $coupon_id = $coupon_price_txt = '';
	if($customerdata['stl_status']){

			// $customer_list = $customer_lists['data'][0];
			// echo "<pre>";print_r($customer_list);echo "</pre>";
			$address_line1 = $customerdata['address']['line1'];
			$address_line2 = $customerdata['address']['line2'];
			$city = $customerdata['address']['city'];
			$state = $customerdata['address']['state'];
			$country = $customerdata['address']['country'];
			$postal_code = $customerdata['address']['postal_code'];

			$company_name = $customerdata['name'];
			$email = $customerdata['email'];
			$phone = $customerdata['phone'];
			$customer_id = $customerdata['id'];

			if(!empty($customerdata['discount']))
			{
				$percent_off = isset($customerdata['discount']['coupon']['percent_off'])?$customerdata['discount']['coupon']['percent_off']:'';
				$amount_off = isset($customerdata['discount']['coupon']['amount_off'])?$customerdata['discount']['coupon']['amount_off']:'';
				$amount_off_currency = isset($customerdata['discount']['coupon']['currency'])?$customerdata['discount']['coupon']['currency']:'';
				$coupon_name = isset($customerdata['discount']['coupon']['name'])?$customerdata['discount']['coupon']['name']:'';
				$coupon_id = isset($customerdata['discount']['coupon']['id'])?$customerdata['discount']['coupon']['id']:'';
				
				if($amount_off !='')
				{
					$amount_off_txt = $amount_off/100;
					$amount_off_txt = number_format($amount_off_txt,2);
					$coupon_price_txt = $amount_off_txt;
				}
				else if($percent_off !='')
				{
					$coupon_price_txt = $percent_off."%";
				}
				else{}


			}
		
	}
	else
	{
		// $total_txt = __('Monthly','wp_stripe_management');
	}


	// $total_txt = __('Monthly','wp_stripe_management');


	if($status_type == 'changeemail' && $customer_id == '' && is_user_logged_in())
	{
		$user = wp_get_current_user();
    	$uid  = (int) $user->ID;


		$address_line1 = get_user_meta( $uid, 'wssm_address_line1',true);
			$address_line2 = get_user_meta( $uid, 'wssm_address_line2',true);
			$city = get_user_meta( $uid, 'wssm_city',true);
			$state = get_user_meta( $uid, 'wssm_state',true);
			$country = get_user_meta( $uid, 'wssm_country',true);
			$postal_code = get_user_meta( $uid, 'wssm_postal_code',true);

			$company_name = get_user_meta( $uid, 'wssm_company_name',true);
			$phone = get_user_meta( $uid, 'wssm_phone',true);

	}

		global $wpdb;
    $table_name = WSSM_METADATA_TABLE_NAME; 
    $metadata_results = $wpdb->get_results( "SELECT * FROM ".$table_name );
    $metadata_count = sizeof($metadata_results);

    $page_sub = get_option('wssm_stripe_page_subscription','');
    $page_subsuccess = get_option('wssm_stripe_page_subsuccess','');

    if($country == ''){
    	// echo "<pre>";print_r($_SERVER);echo "</pre>";
	    // $ipAddress = $_SERVER['REMOTE_ADDR'];
	    

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
		// echo "<pre>";print_r($geoip_data);echo "</pre>";
		if(!empty($geoip_data))
		{
			$country = $geoip_data->country_code;
		}
	}

	// echo "country = ".$country;
	$logreg_url = get_option('wssm_logreg_urlredirect','');
	$mailred_url = get_option('wssm_mail_urlredirect','');

	$tax_tr_data = '';
	$taxlists_json = json_encode($taxlists);
	// echo "<pre>";print_r($taxlists);echo "</pre>";
	if($country !='')
	{
		$country_key = array_search ($country, WSSM_COUNTRY);
		// if($taxlists['stl_status']){ 
			// $tax_datas = $taxlists['data'];
			if(!empty($taxlists))
			{
				foreach($taxlists as $tax_data)
				{
					$jurisdiction = $tax_data['jurisdiction'];
					$tax_id = $tax_data['tax_id'];
					if($country == $jurisdiction ||$country_key == $jurisdiction )
					{
		      			$tax_tr_data .= "<th colspan='2'>";
			      						
			      		if($tax_data['inclusive'] !='')
			      		{
			      			$tax_tr_data .= "<input type='hidden' name='tax_id' class='addsub_taxoption' value='".$tax_data['id']."' data-percentage='".$tax_data['percentage']."' data-inclusive='".$tax_data['inclusive']."'>".$tax_data['display_name']."-".$tax_data['jurisdiction']." (".$tax_data['percentage']."% incl.)";
			      		}
			      		else
			      		{
			      			$tax_tr_data .= "<input type='hidden'  name='tax_id' class='addsub_taxoption' value='".$tax_data['id']."' data-percentage='".$tax_data['percentage']."' data-inclusive='".$tax_data['inclusive']."'>".$tax_data['display_name']."-".$tax_data['jurisdiction']." (".$tax_data['percentage']."%)";
			      		}
			      						
			      		$tax_tr_data .= "</th><th class='initialfee_cls'><span class='initfee_tax'></span></th><th><span class='tax_amt'>0.00</span></th><th></th>";
					}
				}
			}
		// }
	}

// if($customer_id ==''){$inital_fee_cls = 'inital_fee_cls_show';}
// else{$inital_fee_cls = 'inital_fee_cls_hide';}




?>



<div class="stl-row">
	<input type="hidden" class="page_sub" value="<?php echo $page_sub; ?>">
	<input type="hidden" class="page_subsuccess" value="<?php echo $page_subsuccess; ?>">
	<input type="hidden" class="stl_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
	<input type="hidden" class="stl_geo_country" value="<?= $country; ?>">
	<input type="hidden" class="check_userlogin" value="<?= is_user_logged_in(); ?>">
	<input type="hidden" class="logreg_url" value="<?= $logreg_url; ?>">
	<input type="hidden" class="mailred_url" value="<?=$mailred_url; ?>">
	<input type="hidden" class="initialfee_cls_count" value="0">


	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
	
			<?php include_once(WPSTRIPESM_DIR.'templates/sidebar.php'); ?>
			<div class="stl-col-md-12">
				<p class="stl_htitle"><?= _e('New Subscription','wp_stripe_management'); ?> </p>
				
				<form class="add_subscriptionform">
					<?php if(is_user_logged_in()){ ?>
		      			<input type="hidden" name="action" class="frm_action" value="addNewsubscription">
		      		<?php } else { ?>
		      			<input type="hidden" name="action" class="frm_action" value="savePlanBeforeReglogin">
		      		<?php } ?>
	      			
	      			<input type="hidden" name="plan_subtotal" class="plan_subtotal" value="0">
	      			<input type="hidden" name="initfee_subtotal" class="initfee_subtotal" value="0">
	      			<input type="hidden" name="initfee_subtotal_act" class="initfee_subtotal_act" value="0">
	      			
	      			<input type="hidden" name="initfee_fst_subtotal" class="initfee_fst_subtotal" value="0">
	      			<input type="hidden" name="plan_total" class="plan_total" value="0">
	      			<input type="hidden" name="initfee_total" class="initfee_total" value="0">
	      			<input type="hidden" name="initfee_fst_total" class="initfee_fst_total" value="0">
	      			
	      			<input type="hidden" name="customer_id" class="customer_id" value="<?= $customer_id; ?>">
	      			<input type="hidden" name="coupon_id" class="coupon_id" value="<?= $coupon_id; ?>">
	      			<input type="hidden" name="amount_off" class="amount_off" value="<?= $amount_off; ?>">
	      			<input type="hidden" name="percent_off" class="percent_off" value="<?= $percent_off; ?>">
	      			<input type="hidden" name="status_type" class="status_type" value="<?= $status_type; ?>">
	      			<input type="hidden" name="cdefault_currency" class="cdefault_currency" value="<?= $cdefault_currency; ?>">

	      			<div class="subplan_step1 subplan_steps" style="<?php echo ($customer_id !='')?'display:block;':'';?>">
	      				<!-- <p class="sub_formheading"><?php _e( 'Products', 'wp_stripe_management' ); ?> </p> -->
	      				
	      				<table class="stl-table pricelist_tb">
	      					<thead>
	      						<tr>
	      							<th><?= _e('Pricing Plan','wp_stripe_management'); ?></th>
	      							<th class="stl_addsub_qty"><?= _e('Qty','wp_stripe_management'); ?></th>
	      							<th class="stl-text-right initialfee_cls plan_initialth"><?= _e('First month','wp_stripe_management'); ?> (<?=$cdefault_currency_symbol; ?>)</th>
	      							<th class="stl-text-right plan_totalth"><?= $total_txt; ?> (<?=$cdefault_currency_symbol; ?>)</th>
	      							<th></th>
	      						</tr>
	      					</thead>
	      					<tbody>
	      						<?php
	      						$kk=0;
	      						if(!empty($user_plan_details)){ 
	      							foreach($user_plan_details as $user_plan_detail){ 
	      								$kk++;
	      								$plan_id = $user_plan_detail['plan_id'];
	      								if(!in_array($plan_id, $subplainids))
	    	 							{
	      								?>
	      						<tr id='plan_count_<?= $kk; ?>'>
	      							<td>
	      								<select name="product_plans[<?= $kk; ?>][plan_id]" class="stl-form-control stl_plan stl_productplan" autofocus>
		      								<?php
		      									$plan_options = '<option value="">Select product plan</option>';
												// if($planlists['stl_status'])
												// {
												    // $planlists_data = $planlists['data'];
												    foreach($planlists as $planlist)
												    {
												    	$plandata = htmlspecialchars( json_encode($planlist), ENT_COMPAT );
												    	if($planlist['nickname'] !='')
												    	{
												    	 	$selected = ($plan_id == $planlist['id'])?'selected':'';
												    	 	echo '<option value="'.$planlist['id'].'" data-interval="'.$planlist['interval'].'" data-plandata="'.$plandata.'" '.$selected.'>'.$planlist['nickname'].'</option>';
												    	}
												    }
												// }
											?>
		      							</select>
		      						</td>
		      						<!-- oninput="validity.valid||(value='');" -->
		      						<td class="stl_addsub_qty">
		      							<input type="number" class="stl-form-control stl_qty" name="product_plans[<?= $kk; ?>][qty]" placeholder="Qty" value="<?= $user_plan_detail['qty']; ?>"  min="1" >
		      						</td>
		      						<td class="stl-text-right initialfee_cls stl_initial_fee">
		      							<input type="hidden" class="stl-form-control stl_initial_feeval" name="product_plans[<?= $kk; ?>][initial_fee]" value="0">
		      							<p>0.00</p>
		      						</td>
		      						<td class="stl-text-right">
		      							<input type="hidden" name="product_plans[<?= $kk; ?>][usage_type]" class="usage_type" value="<?= $user_plan_detail['usage_type']; ?>">
		      							<input type="hidden" name="product_plans[<?= $kk; ?>][plan_price]" class="stl-form-control stl_price" value="<?= $user_plan_detail['plan_price']; ?>" placeholder="Price" >
		      							<p class="stl_price_txt">0.00</p>
		      						</td>
		      						
		      						<td>
		      							<button type="button" class="stl-btn stl-btn-sm stl-btn-info btn_addplan"><i class="stl-glyphicon stl-glyphicon-plus"></i></button>
		      						</td>

	      						</tr>
	      						<?php } } } else { 
	      							$kk = 1;
	      							?>
	      						<tr id='plan_count_1'>
	      							<td>
	      								<select name="product_plans[1][plan_id]" class="stl-form-control stl_plan stl_productplan" autofocus>
		      								<?= $plan_options; ?>
		      							</select>
		      						</td>
		      						<td class="stl_addsub_qty">
		      							<input type="number" class="stl-form-control stl_qty" name="product_plans[1][qty]" placeholder="Qty" value="1" min="1" >
		      						</td>
		      						<td class="stl-text-right initialfee_cls stl_initial_fee">
		      							<input type="hidden" class="stl-form-control stl_initial_feeval" name="product_plans[1][initial_fee]" value="0">
		      							<p>0.00</p>
		      						</td>
		      						<td class="stl-text-right">
		      							<input type="hidden" name="product_plans[1][usage_type]" class="usage_type" value="">
		      							<input type="hidden" name="product_plans[1][plan_price]" class="stl-form-control stl_price" value="" placeholder="Price" >
		      							<p class="stl_price_txt">0.00</p>
		      						</td>

		      						<td>
		      							<button type="button" class="stl-btn stl-btn-sm stl-btn-info btn_addplan"><i class="stl-glyphicon stl-glyphicon-plus"></i></button>
		      						</td>
	      						</tr>
	      						<?php } ?>
	      					</tbody>
	      					<tfoot>
	      						<tr>
	      							<th colspan="2"><?= _e('Subtotal','wp_stripe_management'); ?></th>
	      							<th class="initialfee_cls"><span class="initfee_subtotal_txt">0.00</span></th>
	      							<th><span class="plan_subtotal_txt">0.00</span></th>
	      							<th></th>
	      						</tr>
	      						<?php if($coupon_id !='') { ?>
		      						<tr>
		      							<th colspan="2">
		      								<label><input type="checkbox" name="apply_coupon" class="apply_coupon" value="<?= $coupon_id; ?>"  style="display:none;" checked>Discount (<?php echo $coupon_price_txt; ?>)</label>
		      							</th>
		      							<th class="initialfee_cls"><span class="initfee_ctotal"></span></th>
		      							<th><span class="apply_coupon_th">- <?= $coupon_price_txt; ?></span></th>
		      							<th></th>
		      						</tr>
		      					<?php } ?>
		      					<tr class="tax_tr_data"><?=$tax_tr_data; ?>
		      					<tr>
	      							<th class="inv_total_txt" colspan="2"><?= $total_txt; ?></th>
	      							<th class="initialfee_cls initfee_total_txt">0.00</th>
	      							<th class="plan_total_txt">0.00</th>
	      							<th></th>
	      						</tr>

	      						

	      					</tfoot>
	      				</table>

	      				<div class="stl-col-md-6"></div>
		      			<div class="stl-col-md-6 stl-text-right">
		      				<input type="hidden" class="plan_count" value="<?= $kk; ?>">
		      				<button type="button" class="stl-btn stl-btn-success btn_nxtstep1"><?php _e( 'Next', 'wp_stripe_management' ); ?></button>
		      			</div>
		      		</div>
		      		
		      		<div class="subplan_step2 subplan_steps" style="<?php echo ($customer_id !='')?'display:none;':'';?>">
		      			<p class="sub_formheading"><?php _e( 'Customer Information', 'wp_stripe_management' ); ?></p>

		      			<div class="stl-col-md-12">
		      				<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Your Full Name','wp_stripe_management'); ?></label>
									<input type="text" name="full_name" class="stl-form-control" value="<?= $full_name; ?>" <?= ($full_name != '')?'readonly':''; ?> >
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Company Name','wp_stripe_management'); ?></label>
									<input type="text" name="company_name" class="stl-form-control" value="<?= $company_name; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Email','wp_stripe_management'); ?></label>
									<input type="email" name="emailid" class="stl-form-control emailid" value="<?= $email; ?>"  >
									<input type="hidden" name="oldemailid" class="stl-form-control oldemailid" value="<?= $email; ?>"  >
								</div>
					   		</div>
					   		
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Phone','wp_stripe_management'); ?></label>
									<!-- <input type="hidden" name="phone" id="phone" value="<?= $phone; ?>"> -->
									<div>
										<input type="text" id="phone_format" class="stl-form-control" value="<?= $phone; ?>">
									</div>
								</div>
					   		</div>
					   		<div style="clear: both;"></div>
					   		<div class="stl-col-md-6">	

					   			<div class="stl-form-group">
									<label><?= _e('Street Address 1','wp_stripe_management'); ?></label>
									<input type="text" name="address_line1" class="stl-form-control" value="<?= $address_line1; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Street Address 2','wp_stripe_management'); ?></label>
									<input type="text" name="address_line2" class="stl-form-control" value="<?= $address_line2; ?>">
								</div>
					   		</div>
					   		<div style="clear: both;"></div>
					   		<div class="stl-col-md-3">
					   			<div class="stl-form-group">
									<label><?= _e('City','wp_stripe_management'); ?></label>
									<input type="text" name="city" class="stl-form-control" value="<?= $city; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-3">
					   			<div class="stl-form-group">
									<label><?= _e('State/Province','wp_stripe_management'); ?></label>
									<input type="text" name="state" class="stl-form-control" value="<?= $state; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-3">
					   			<div class="stl-form-group">
									<label><?= _e('Zip/Postcode','wp_stripe_management'); ?></label>
									<input type="text" name="postal_code" class="stl-form-control" value="<?= $postal_code; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-3">
					   			<div class="stl-form-group">
									<label><?= _e('Country','wp_stripe_management'); ?></label>
									<?php
									if($customer_id !='')
									{
										?>
										<input type="text" name="country" class="stl-form-control customer_country" value="<?= $country; ?>" readonly>
										<?php
									}
									else
									{
										$country_data = WSSM_COUNTRY;
										
										echo '<select name="country" class="stl-form-control customer_country">';
											foreach($country_data as $key => $value)
											{
												$selected = ($country == $key)?'selected':'';
												echo "<option value='".$key."' ".$selected.">".$value."</option>";
											}
										echo '</select>';
										
									}
									?>
								</div>
					   		</div>
					   	</div>
					   	<div style="clear: both;"></div>
		      			<div class="stl-col-md-6">
		      				<button type="button" class="stl-btn stl-btn-success btn_prevstep2"><?php _e( 'Back', 'wp_stripe_management' ); ?></button>
		      			</div>
		      			<div class="stl-col-md-6 stl-text-right">
		      				<button type="button" class="stl-btn stl-btn-success btn_nxtstep2"><?php _e( 'Next', 'wp_stripe_management' ); ?></button>
		      			</div>
		      			
		      		</div>

		      		<div class="subplan_step3 subplan_steps">
		      			<p class="sub_formheading"><?php _e( 'Billing method', 'wp_stripe_management' ); ?></p>
		      			<div class="stl-col-md-12">
		      				<div class="stl-col-md-12" style="display: none;">
					   			<div class="stl-form-group">
									<input type="radio" name="collection_method" class="collection_method" value="charge_automatically" checked >
									&nbsp;<label><?= _e('Automatically charge a payment source on file','wp_stripe_management'); ?></label>
								</div>
					   		</div>
					   		<div class="pay_automethod">
					   			<?php
					   			$cardpay1 = '';
					   			$cardpay2 = 'checked';
					   			$cardpay2_style = 'display:block;';
					   			$cardpay1_style = 'display:none;';
					   // 			if($cardlists['stl_status'])
								// {
									// echo "qqqqqqqqqqqqq";
									// $card_lists = $cardlists['card_lists'];
									if(!empty($cardlists))
									{
										// echo "iffffffff";
										$cardpay1 = 'checked';
										$cardpay2 = '';
										$cardpay2_style = 'display:none;';
										$cardpay1_style = 'display:block;';
									}
								// }
								?>
						   		<div class="stl-col-md-4" style="<?=$cardpay1_style; ?>">
						   			<div class="stl-form-group">
										<input type="radio" name="card_type" class="card_paytype" value="1" <?= $cardpay1; ?> >&nbsp;<label><?= _e('Pay automatically using card','wp_stripe_management'); ?></label>
									</div>
						   		</div>
						   		<div class="stl-col-md-2" style="<?=$cardpay1_style; ?>">
						   			<div class="stl-form-group">
										<select name="card_id" class="stl-form-control">
											<?php
												// if($cardlists['stl_status'])
												// {
													// $card_lists = $cardlists['card_lists'];
													foreach($cardlists as $card_list)
													{
														echo '<option value="'.$card_list['id'].'">•••• '.$card_list['last4'].'</option>';
													}
												// }
											?>
										</select>
									</div>
						   		</div>
						   		<div class="stl-col-md-4">
						   			<div class="stl-form-group">
										<input type="radio" name="card_type" class="card_paytype" value="2" <?=$cardpay2; ?> >&nbsp;<label><?= _e('Pay automatically using new card','wp_stripe_management'); ?></label>
									</div>
						   		</div>
						   		<div class="card_hiddendiv" style="<?=$cardpay2_style; ?>clear:both;">
						   			<div class="stl-col-md-3">
							   			<div class="stl-form-group">
											<label><?= _e('Name on card','wp_stripe_management'); ?></label>
											<input type="text" name="holder_name" class="stl-form-control holder_name"  maxlength="100" value="" checked>
										</div>
							   		</div>
							   		<div class="stl-col-md-3">
							   			<div class="stl-form-group">
											<label><?= _e('Card number','wp_stripe_management'); ?></label>
											<input type="text" name="card_no" class="stl-form-control card_no" value="">
										</div>
							   		</div>
						   		
							   		<div class="stl-col-md-2">
							   			<div class="stl-form-group">
											<label><?= _e('Exp.month','wp_stripe_management'); ?></label>
											<input type="number" name="expire_month" class="stl-form-control expire_month" onKeyPress="if(this.value.length==2) return false;" value="">
										</div>
							   		</div>
							   		<div class="stl-col-md-2">
							   			<div class="stl-form-group">
											<label><?= _e('Exp.year','wp_stripe_management'); ?></label>
											<input type="number" name="expire_year" class="stl-form-control expire_year" onKeyPress="if(this.value.length==4) return false;" value="">
										</div>
							   		</div>
							   		<div class="stl-col-md-2">	

							   			<div class="stl-form-group">
											<label><?= _e('CCV','wp_stripe_management'); ?></label>
											<input type="text" name="ccv" class="stl-form-control ccv" onKeyPress="if(this.value.length==4) return false;" value="">
										</div>
							   		</div>
							   		<div style="clear: both;"></div>
							   		<div class="stl-col-md-6">	

							   			<div class="stl-form-group">
											<label><?= _e('Street Address 1','wp_stripe_management'); ?></label>
											<input type="text" name="card_address_line1" class="stl-form-control"  maxlength="95" value="">
										</div>
							   		</div>
							   		<div class="stl-col-md-6">
							   			<div class="stl-form-group">
											<label><?= _e('Street Address 2','wp_stripe_management'); ?></label>
											<input type="text" name="card_address_line2" class="stl-form-control" maxlength="95" value="">
										</div>
							   		</div>
							   		<div style="clear: both;"></div>
							   		<div class="stl-col-md-3">
							   			<div class="stl-form-group">
											<label><?= _e('City','wp_stripe_management'); ?></label>
											<input type="text" name="card_city" class="stl-form-control" maxlength="95" value="">
										</div>
							   		</div>
							   		<div class="stl-col-md-3">
							   			<div class="stl-form-group">
											<label><?= _e('State','wp_stripe_management'); ?></label>
											<input type="text" name="card_state" class="stl-form-control" maxlength="95" value="">
										</div>
							   		</div>
							   		<div class="stl-col-md-3">
							   			<div class="stl-form-group">
											<label><?= _e('Postal Code','wp_stripe_management'); ?></label>
											<input type="text" name="card_postal_code" class="stl-form-control" maxlength="10" value="">
										</div>
							   		</div>
							   		<div class="stl-col-md-3">
							   			<div class="stl-form-group">
											<label><?= _e('Country','wp_stripe_management'); ?></label>
											<!-- <input type="text" name="card_country" class="stl-form-control" value=""> -->
											<?php
												$country_data = WSSM_COUNTRY;
											
												echo '<select name="card_country" class="stl-form-control">';
													foreach($country_data as $key => $value)
													{
														echo "<option value='".$key."'>".$value."</option>";
													}
												echo '</select>';
											?>
										</div>
							   		</div>
							   	</div>
						   	</div>
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<input type="radio" name="collection_method" class="collection_method" value="send_invoice"> <label><?= _e('Email invoices for manual payment','wp_stripe_management'); ?></label>
								</div>
					   		</div>
					   		<!-- <div class="stl-col-md-12 pay_manualmethod" style="display: none;">
					   			<div class="stl-form-group">
									<label class="stl-col-md-2"><?= _e('Payment due','wp_stripe_management'); ?></label>
									<div class="stl-col-md-2">
										<input type="text" name="payment_due_date" class="stl-form-control" value="" placeholder="days">
									</div>
									<span class="stl-col-md-4"><?= _e('days after invoice is sent','wp_stripe_management'); ?></span>
								</div>
					   		</div> -->
		      			</div>
		      			
		      			<div class="stl-col-md-6">
		      				<button type="button" class="stl-btn stl-btn-success btn_prevstep3"><?php _e( 'Back', 'wp_stripe_management' ); ?></button>
		      			</div>
		      			<div class="stl-col-md-6">
		      				<button type="button" class="stl-btn stl-btn-success btn_nxtstep3"><?php _e( 'Next', 'wp_stripe_management' ); ?></button>
		      			</div>
		      		</div>

		      		<div class="subplan_step4 subplan_steps">
		      			<p class="sub_formheading"><?php _e( 'Subscription Info', 'wp_stripe_management' ); ?></p>
		      			<div class="stl-row">
		      				<?php
		      				$step4_show = 0;
		      					if($metadata_results)
		      					{
		      						foreach($metadata_results as $metadata_result)
		      						{
		      							$newsub_activation_label = $metadata_result->newsub_activation_label;
		      							$stripe_fname = $metadata_result->stripe_fname;
		      							$newsub_activation = $metadata_result->newsub_activation;
		      							if($newsub_activation == 1)
		      							{
		      								$step4_show = 1;
		      							?>
									   	<div class="stl-col-md-12">
									   		<div class="stl-form-group">
									   			<label class="stl-col-md-12"><?= $newsub_activation_label; ?></label>
									   			<div class="stl-col-md-3">
													<input type="text" name="metadata[<?=$stripe_fname;?>]" class="stl-form-control meta_required" value="">
												</div>
											</div>
									   	</div>
									   	<?php
									   }
									   else
									   {
									   	echo "<input type='hidden' name='metadata[".$stripe_fname."]' value='".$newsub_activation_label."'>";
									   }
									}
								}
							?>
		      			</div>
		      			<div class="stl-col-md-6">
		      				<button type="button" class="stl-btn stl-btn-success btn_prevstep4"><?php _e( 'Back', 'wp_stripe_management' ); ?></button>
		      			</div>
		      			<div class="stl-col-md-6">
		      				<button type="button" class="stl-btn stl-btn-success btn_nxtstep4"><?php _e( 'Subscribe', 'wp_stripe_management' ); ?></button>
		      			</div>
		      		</div>
	      		</form>
			</div>
		</div>
	</div>







<script type="application/javascript">

jQuery(document).ready(function(){

	var customer_id = jQuery(".customer_id").val();
	// if(customer_id !='')
	// {
	// 	retriveplans("plan_count_1");
	// }

	var status_type = jQuery(".status_type").val();
	if(status_type == 'reglogin' || status_type== 'accessreg')
	{
		product_paln_price_calculation();
		jQuery(".subplan_steps").hide();
		if(customer_id == '')
		{
			jQuery(".subplan_step2").show();
		}
		else
		{
			jQuery(".subplan_step3").show();
			var step4_show = "<?php echo $step4_show; ?>";
				if(step4_show > 0)
				{
					jQuery(".btn_nxtstep3").html('<?= __('Next','wp_stripe_management'); ?>');
				}
				else
				{
					jQuery(".btn_nxtstep3").html('<?= __('Subscribe','wp_stripe_management'); ?>');
				}
				
		}
		
	}
	else if(status_type == 'changeemail')
	{
		product_paln_price_calculation();
		jQuery(".subplan_steps").hide();
		
		jQuery(".subplan_step3").show();
		
		var step4_show = "<?php echo $step4_show; ?>";
				if(step4_show > 0)
				{
					jQuery(".btn_nxtstep3").html('<?= __('Next','wp_stripe_management'); ?>');
				}
				else
				{
					jQuery(".btn_nxtstep3").html('<?= __('Subscribe','wp_stripe_management'); ?>');
				}

	}
	else
	{

	}
	retriveplans("plan_count_1");


	// jQuery(document).on('change','.apply_coupon',function(){
	// 	var apply_coupon = jQuery(".apply_coupon:checked").val() || '';
	// 	if(apply_coupon !='')
	// 	{
	// 		jQuery(".apply_coupon_th").show();
	// 	}
	// 	else
	// 	{
	// 		jQuery(".apply_coupon_th").hide();
	// 	}
	// 	product_paln_price_calculation();
	// })

	var input = document.querySelector("#phone_format");
   var iti =  window.intlTelInput(input, {
      hiddenInput: "phone",
      utilsScript: "<?php echo UTILS_JS; ?>",
    });

	var form = jQuery(".add_subscriptionform");
	form.validate({errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
    });


	jQuery(document).on('click','.btn_addplan',function(){
		var initialfee_cls_count = jQuery(".initialfee_cls_count").val() || 0;
		var plan_tr_count = jQuery(".pricelist_tb tbody tr").length;
		if(plan_tr_count < 20)
		{
			var plan_count = jQuery(".plan_count").val();
			plan_count = parseInt(plan_count)+1;
			// var product_plan_interval = jQuery(".stl_productplan").find(':selected').data('interval');
			var product_plan = jQuery(".stl_productplan").find(':selected').val();
			if(product_plan !='')
			{
				// jQuery(this).hide();
				var plan_datas = '<tr id="plan_count_'+plan_count+'"><td><select name="product_plans['+plan_count+'][plan_id]" class="stl-form-control stl_plan stl_productplan_another"><?php echo $plan_options; ?></select></td><td class="stl_addsub_qty"><input type="number" class="stl-form-control stl_qty" name="product_plans['+plan_count+'][qty]" placeholder="qty" value="1"  min="1"></td><td class="stl-text-right initialfee_cls stl_initial_fee"><input type="hidden" class="stl-form-control stl_initial_feeval" name="product_plans[1][initial_fee]" value="0"><p>0.00</p></td><td class="stl-text-right"><input type="hidden" name="product_plans['+plan_count+'][usage_type]" class="stl-form-control usage_type" value="" ><input type="hidden" name="product_plans['+plan_count+'][plan_price]" class="stl-form-control stl_price" value="" placeholder="Price" ><p class="stl_price_txt">0.00</p></td><td><button type="button" class="stl-btn stl-btn-sm stl-btn-danger btn_removeplan"><i class="stl-glyphicon stl-glyphicon-remove"></i></button>&nbsp;<button type="button" class="stl-btn stl-btn-sm stl-btn-info btn_addplan"><i class="stl-glyphicon stl-glyphicon-plus"></i></button></td></tr>';
				jQuery(".pricelist_tb tbody").append(plan_datas);
				jQuery(".plan_count").val(plan_count);
				// disaple_otherplans();
				retriveplans("plan_count_"+plan_count);
			}
			else
			{
				alert("Please select the product plan");
			}
		}
		else
		{
			alert("You are exit the max plan selection");
		}

		if(initialfee_cls_count >0)
		{
			jQuery(".initialfee_cls").show();
		}
		else
		{
			jQuery(".initialfee_cls").hide();
		}
	});

	jQuery(document).on('change','.stl_plan',function(){
		var this_selected_min = jQuery(this).find(':selected').data('min');
		var this_selected_max = jQuery(this).find(':selected').data('max');
		// console.log("this_selected_min = "+this_selected_min+" = this_selected_max = "+this_selected_max);
		jQuery(this).closest('tr').find('.stl_qty').attr('min',this_selected_min);
		jQuery(this).closest('tr').find('.stl_qty').attr('max',this_selected_max);
		// console.log("changedddddddd");

		// var product_plan_interval = jQuery(".stl_productplan").find(':selected').data('interval');
		// jQuery('.stl_productplan_another option').removeAttr('selected');
		// disaple_otherplans();

	});

	jQuery(document).on('change','.stl_productplan',function(){
		retriveplans("plan_count_1");
		// var product_plan_interval = jQuery(".stl_productplan").find(':selected').data('interval');
		// jQuery('.stl_productplan_another option').removeAttr('selected');
		// disaple_otherplans();

	});

	// function disaple_otherplans(){
	// 	var product_plan_interval = jQuery(".stl_productplan").find(':selected').data('interval');
	// 	jQuery(".stl_productplan_another option").removeAttr("disabled");
	// 	jQuery(".stl_productplan_another option[data-interval]:not([data-interval*='" + product_plan_interval + "'])").attr("disabled", "true");
	// }

	jQuery(document).on('click','.btn_removeplan',function(){
		jQuery(this).closest('tr').remove();
		product_paln_price_calculation();
	});



	// jQuery(document).on('click','.collection_method',function(){
	// 	var collection_method = jQuery("input[name='collection_method']:checked").val();
	// 	if(collection_method == 'charge_automatically')
	// 	{
	// 		jQuery(".pay_automethod").show();
	// 		jQuery(".pay_manualmethod").hide();
	// 	}
	// 	else
	// 	{
	// 		jQuery(".pay_automethod").hide();
	// 		jQuery(".pay_manualmethod").show();
	// 	}
	// });

	jQuery(document).on('click','.collection_method',function(){
		var collection_method = jQuery("input[name='collection_method']:checked").val();
		if(collection_method == 'send_invoice')
		{
			jQuery(".card_paytype").removeAttr('checked');
			// jQuery(".pay_manualmethod").show();
			jQuery(".card_hiddendiv").hide();
		}
		// else
		// {

		// 	jQuery(".pay_manualmethod").hide();
		// }
	});

	jQuery(document).on('click','.card_paytype',function(){
		jQuery("input[name=collection_method][value=charge_automatically]").attr('checked', 'checked');

		var card_type = jQuery('input[name=card_type]:checked').val();
		if(card_type == '1')
		{
			jQuery(".card_hiddendiv").hide();
		}
		else
		{
			jQuery(".card_hiddendiv").show();
		}
	})


	jQuery(document).on('click','.btn_prevstep2',function(){
		jQuery(".subplan_steps").hide();
		jQuery(".subplan_step1").show();
	});
	jQuery(document).on('click','.btn_prevstep3',function(){
		
		// jQuery(".subplan_steps").hide();
		// 	jQuery(".subplan_step2").show();

		var customer_id = jQuery(".customer_id").val();
		if(customer_id == '')
		{
			jQuery(".subplan_steps").hide();
			jQuery(".subplan_step2").show();
		}
		else
		{
			jQuery(".subplan_steps").hide();
			jQuery(".subplan_step1").show();
		}


	});
	jQuery(document).on('click','.btn_prevstep4',function(){
		jQuery(".subplan_steps").hide();
		jQuery(".subplan_step3").show();
	});

	jQuery(document).on('click','.btn_nxtstep2',function(){
		var customer_id = jQuery(".customer_id").val();
		var oldemailid = jQuery(".oldemailid").val();
		var emailid = jQuery(".emailid").val();

		// jQuery("input[name=company_name]").rules("add", { required:true,  });
		jQuery("input[name=emailid]").rules("add", { required:true,email: true  });
		if(customer_id =='')
		{
			jQuery("input[name=address_line1]").rules("add", { required:true});
			jQuery("input[name=city]").rules("add", { required:true});
			jQuery("input[name=state]").rules("add", { required:true});
			jQuery("input[name=postal_code]").rules("add", { required:true});
			jQuery("input[name=country]").rules("add", { required:true});
		}
		



		if (form.valid() == true){

			var step4_show = "<?php echo $step4_show; ?>";
				if(step4_show > 0)
				{
					jQuery(".btn_nxtstep3").html('<?= __('Next','wp_stripe_management'); ?>');
				}
				else
				{
					jQuery(".btn_nxtstep3").html('<?= __('Subscribe','wp_stripe_management'); ?>');
				}

				

			if(oldemailid == emailid){
			var country_const = <?php echo json_encode(WSSM_COUNTRY); ?>;
			var customer_country = jQuery(".customer_country").val() || '';
			// $ = array_search ($country, country_const);
			 var country_key = jQuery.map(country_const, function(element,index) {

			 	if(element == customer_country)
			 	return index;
			 })

			 // var country_key = country_const.indexOf(customer_country)

			var taxlists_json = <?php echo $taxlists_json; ?>;
			var tax_tr_data = '';
			if(taxlists_json)
			{
				// if(taxlists_json['stl_status'])
				// {
					// var taxlists_datas = taxlists_json['data'];
					if(taxlists_json !='')
					{
						jQuery.each(taxlists_json,function(key,tax_data){
							var jurisdiction = tax_data['jurisdiction'];
							var tax_id = tax_data['tax_id'];
							if(customer_country == jurisdiction ||country_key == jurisdiction )
							{
								tax_tr_data += "<th colspan='2'>";
			      						
			      							if(tax_data['inclusive'] !='')
			      							{
			      								tax_tr_data +=  "<input type='hidden'  name='tax_id' class='addsub_taxoption' value='"+tax_data['id']+"' data-percentage='"+tax_data['percentage']+"' data-inclusive='"+tax_data['inclusive']+"'>"+tax_data['display_name']+"-"+tax_data['jurisdiction']+" ("+tax_data['percentage']+"% incl.)";
			      							}
			      							else
			      							{
			      								tax_tr_data +=  "<input type='hidden'  name='tax_id' class='addsub_taxoption' value='"+tax_data['id']+"' data-percentage='"+tax_data['percentage']+"' data-inclusive='"+tax_data['inclusive']+"'>"+tax_data['display_name']+"-"+tax_data['jurisdiction']+" ("+tax_data['percentage']+"%)";
			      							}
			      						
			      						tax_tr_data +=  "</th><th><span class='tax_amt'>0.00</span></th><th></th>";
							}
						})
					}
				// }
			}
			jQuery(".tax_tr_data").html(tax_tr_data);

			var stl_geo_country = jQuery(".stl_geo_country").val();
			var customer_country = jQuery(".customer_country").val();
			if(customer_id =='' && stl_geo_country != customer_country)
			{
				retriveplans('plan_count_1');
				jQuery(".subplan_steps").hide();
				jQuery(".subplan_step1").show();
				jQuery(".stl_geo_country").val(customer_country);
			}
			else
			{
				jQuery(".subplan_steps").hide();
				jQuery(".subplan_step3").show();
			}

		}
		else
		{
			var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			jQuery.ajax({
					url : stl_ajaxurl,
					type: 'POST',
					data: {'action':'checkEmailalreadyexists','emailtype':'accountadd','email':emailid},
					dataType:'json',
					beforeSend: function() {
				        jQuery('.stl_ajaxloader').css("visibility", "visible");
				    },
					success:function(response_status){
						console.log(response_status);

						if(response_status)
						{
						
							jQuery(".frm_action").val('changeEmailid');
							// var product_plans = jQuery("input[name='product_plans']").val();
							// var x = jQuery('input[name="product_plans[]"]').val();
							var $form = jQuery(".add_subscriptionform");
							jQuery.ajax({
								url : stl_ajaxurl,
								type: 'POST',
								data: $form.serialize(),
								dataType:'json',
								beforeSend: function() {
							        jQuery('.stl_ajaxloader').css("visibility", "visible");
							    },
								success:function(response){
									console.log(response);


										var mailred_url = jQuery(".mailred_url").val();
										// toastr.options = {"closeButton": true,}
										// toastr.success("<?= _e('New subscription added successfully','wp_stripe_management'); ?>", "<?= _e('Success','wp_stripe_management'); ?>");
										setTimeout(function(){
											window.location.href = "<?php echo site_url(); ?>"+"/"+mailred_url+"?wssm_activationcode="+response['actcode'];
										}, 800);


									jQuery('.stl_ajaxloader').css("visibility", "hidden");
													
								},
								error: function(xhr, status, error){
									console.log("errorrrrrr");
							        toastr.error('Error', xhr.responseText);
							        jQuery('.stl_ajaxloader').css("visibility", "hidden");
							    },
							});
						}
						else
						{
							toastr.error("email id already exit", "<?= _e('Error','wp_stripe_management'); ?>");
						}
						jQuery('.stl_ajaxloader').css("visibility", "hidden");
										
					},
					error: function(){
						toastr.error('Error', "<?= _e('Error','wp_stripe_management'); ?>");
					}
				});

			return false;

			var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			
		}


			
		}

		// jQuery(".subplan_steps").hide();
		// jQuery(".subplan_step2").show();


		

	});


	
	jQuery(document).on('click','.btn_nxtstep1',function(){

		var check_userlogin = jQuery(".check_userlogin").val() || 0;

		jQuery(".stl_productplan").rules("add", { required:true,  });
		// jQuery(".stl_productplan_another").rules("add", { required:true,  });
		// jQuery(".stl_qty").rules("add", { required:true,  });

		jQuery('.stl_productplan_another').each(function () { 
		    jQuery(this).rules("add", {
		        required: true
		    });
		});

		jQuery('.stl_qty').each(function () { 
		    jQuery(this).rules("add", {
		        required: true
		    });
		});


		if (form.valid() == true){

			if(check_userlogin){
				var step4_show = "<?php echo $step4_show; ?>";
				if(step4_show > 0)
				{
					jQuery(".btn_nxtstep3").html('<?= __('Next','wp_stripe_management'); ?>');
				}
				else
				{
					jQuery(".btn_nxtstep3").html('<?= __('Subscribe','wp_stripe_management'); ?>');
				}

				var customer_id = jQuery(".customer_id").val();
				if(customer_id == '')
				{
					jQuery(".subplan_steps").hide();
					jQuery(".subplan_step2").show();
				}
				else
				{
					jQuery(".subplan_steps").hide();
					jQuery(".subplan_step3").show();
				}
			}
			else
			{
				var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				var product_plans = jQuery("input[name='product_plans']").val();
				var x = jQuery('input[name="product_plans[]"]').val();

				var $form = jQuery(".add_subscriptionform");

				jQuery.ajax({
					url : stl_ajaxurl,
					type: 'POST',
					data: $form.serialize(),
					dataType:'json',
					beforeSend: function() {
				        jQuery('.stl_ajaxloader').css("visibility", "visible");
				    },
					success:function(response){
						console.log("scccccccccccc");
						// if(response['stl_status'])
						// {
							var logreg_url = jQuery(".logreg_url").val();
							// toastr.options = {"closeButton": true,}
							// toastr.success("<?= _e('New subscription added successfully','wp_stripe_management'); ?>", "<?= _e('Success','wp_stripe_management'); ?>");
							setTimeout(function(){
								window.location.href = "<?php echo site_url(); ?>"+"/"+logreg_url+"?wssm_activationcode="+response['actcode'];
							}, 800);

						// }
						// else
						// {
						// 	toastr.error(response['message'], "<?= _e('Error','wp_stripe_management'); ?>");
						// }
						jQuery('.stl_ajaxloader').css("visibility", "hidden");
										
					},
					error: function(xhr, status, error){
						console.log("errrrrrrrrrrsssssssss");
						toastr.error( xhr.responseText, "<?= _e('Error','wp_stripe_management'); ?>");
						jQuery('.stl_ajaxloader').css("visibility", "hidden");
						// toastr.error('Error', "<?= _e('Error','wp_stripe_management'); ?>");
					}
				});
			}

				
			
			
		}

	});
	jQuery(document).on('click','.btn_nxtstep3',function(){
		var collection_method = jQuery(".collection_method:checked").val();
		if(collection_method == 'charge_automatically')
		{
			var card_paytype = jQuery(".card_paytype:checked").val();
			if(card_paytype == 1)
			{
				jQuery("input[name=card_id]").rules("add", { required:true});
			}
			else
			{
				jQuery("input[name=holder_name]").rules("add", { required:true});
				jQuery("input[name=card_no]").rules("add", { required:true});
				jQuery("input[name=expire_month]").rules("add", { required:true});
				jQuery("input[name=expire_year]").rules("add", { required:true});
				jQuery("input[name=ccv]").rules("add", { required:true});
				jQuery("input[name=card_address_line1]").rules("add", { required:true});
				jQuery("input[name=card_city]").rules("add", { required:true});
				// jQuery("input[name=card_state]").rules("add", { required:true});
				jQuery("input[name=card_postal_code]").rules("add", { required:true});
				jQuery("input[name=card_country]").rules("add", { required:true});
			}
		}
		else
		{
			// jQuery("input[name=payment_due_date]").rules("add", { required:true});
		}

		if (form.valid() == true){
			var step4_show = "<?php echo $step4_show; ?>";
			if(step4_show > 0)
			{
				jQuery(".subplan_steps").hide();
				jQuery(".subplan_step4").show();
			}
			else
			{
				jQuery(".btn_nxtstep4").trigger('click');
			}
			
		}
	});
	

	jQuery(document).on('click','.btn_nxtstep4',function(){
		jQuery('.meta_required').each(function () { 
		    jQuery(this).rules("add", {
		        required: true
		    });
		});
		// jQuery(".meta_required").rules("add", { required:true,  });
		if (form.valid() == true){
			setTimeout(function(){
				var intlNumber =  iti.getNumber();
				jQuery("input[name=phone]").val(intlNumber);
					// var intlNumber = jQuery("#phone_format").intlTelInput("getNumber");
				new_subscription_submitfn();
			}, 500);
		}
	});

	product_paln_price_calculation();

	jQuery(document).on('change','.stl_plan, .addsub_taxoption',function(){
		//jQuery("input[name=metadata_customer]").rules("add", { required:true});
		//if (form.valid() == true){
			product_paln_price_calculation();
		//}
	});


var max_chars = 7;

jQuery(document).on('keydown','.stl_qty',function(){
    if (jQuery(this).val().length >= max_chars) { 
        jQuery(this).val(jQuery(this).val().substr(0, max_chars));
    }
});

jQuery(document).on('keyup','.stl_qty',function(){
    if (jQuery(this).val().length >= max_chars) { 
        jQuery(this).val(jQuery(this).val().substr(0, max_chars));
    }
});

jQuery(document).on('change','.stl_qty',function(){
	// console.log("dddddddddddddd");
	var min_val = jQuery(this).attr('min');
	var max_val = jQuery(this).attr('max');
	var this_val = jQuery(this).val();
	// console.log("this_val = "+this_val+" = min_val = "+min_val+" = max_val = "+max_val);
	if(parseInt(this_val) < parseInt(min_val))
	{
		// console.log("minnnnnnnnn");
		jQuery(this).val(min_val);
	}
	if(parseInt(this_val) > parseInt(max_val))
	{
		// console.log("maxxxxxxxx");
		jQuery(this).val(max_val);
	}

});


	jQuery(document).on('keypress keydown change','.stl_qty',function(){
		//jQuery("input[name=metadata_customer]").rules("add", { required:true});
		//if (form.valid() == true){


			setTimeout(function(){product_paln_price_calculation(); }, 500);

		//}
	});



	function product_paln_price_calculation(){
		var plan_subtotal = initfee_subtotal = 0;
		var currency = '$';
		var initialfee_cls_count = initfee_orignal_subtotal = 0;
		
		jQuery('.pricelist_tb tbody tr').each(function(){
			var stl_plan = jQuery(this).find('.stl_plan').val() || '';
			var plandata = jQuery(this).find('.stl_plan :selected').data('plandata') || '';
			// var amount = jQuery(this).find('.stl_plan :selected').data('amount') || 0;
			var stl_qty = jQuery(this).find('.stl_qty').val() || '';
			// var stl_price = jQuery(this).find('.stl_price').val() || '';
			if(plandata !='')
			{
				var stl_price_val = 0;
				var stl_price_txt = 0;
				var amount = plandata['amount'];
				currency = plandata['currency'];
				var billing_scheme = plandata['billing_scheme'];
				var tiers = plandata['tiers'];
				var tiers_mode = plandata['tiers_mode'];
				var transform_usage = plandata['transform_usage'];
				var trial_period_days = plandata['trial_period_days'];
				var interval = plandata['interval'];
				var interval_count = plandata['interval_count'];
				var trial_period_days = plandata['trial_period_days'];
				var tiers_mode = plandata['tiers_mode'];
				var usage_type = plandata['usage_type'];

				var plan_metadata = plandata['metadata'];
				var initial_fee = 0;
				var initial_fee_type = 'fixed';
				if(plan_metadata !='' )
				{
					jQuery.each(plan_metadata,function(key,val){
						if(key == 'initialfee')
						{
							initial_fee = parseInt(val);
							initial_fee = initial_fee * 100;
							initialfee_cls_count++;
						}
						else if(key == 'initialfeepercent')
						{
							initial_fee_type = 'percentage';
							initial_fee = parseInt(val);
							initial_fee = initial_fee;
							initialfee_cls_count++;
						}
					})
				}
				


				jQuery(this).find('.usage_type').val(usage_type);

				if(usage_type == 'metered')
				{
					jQuery(this).find('.stl_price').val(0);
					jQuery(this).find('.stl_price_txt').html('Varies with usage');
					jQuery(this).find('.stl_qty').attr('readonly',true);
				}
				else
				{
					jQuery(this).find('.stl_qty').attr('readonly',false);

					if(billing_scheme == 'tiered')
					{
						var flat_amount = unit_amount = up_to = 0;
						if(tiers_mode == 'volume')
						{
							jQuery.each(tiers,function(key,value){
								flat_amount = value['flat_amount'];
								unit_amount = value['unit_amount'];
								up_to = value['up_to'];
								if (stl_qty <= up_to || up_to == '') {
								    return false;
								}
							});
							stl_price_val = (unit_amount * stl_qty)+flat_amount;
						}
						else
						{
							var remaing_qty = stl_qty;
							var graduated_total = from_val = 0;

							jQuery.each(tiers,function(key,value){
								if(remaing_qty > 0)
								{
									flat_amount = value['flat_amount'];
									unit_amount = value['unit_amount'];
									up_to = value['up_to'];
									remaing_qty = stl_qty - from_val;
									if(remaing_qty > 0)
									{
										if (up_to != null ) 
										{
											between_val = up_to - from_val;
											if(remaing_qty >= between_val)
											{
												graduated_total += (between_val*unit_amount)+flat_amount;
											}
											else
											{
												graduated_total += (remaing_qty*unit_amount)+flat_amount;
											}
										}
										else
										{
											graduated_total += (remaing_qty*unit_amount)+flat_amount;
										}
										from_val = up_to;
									}
								}
								else
								{
									return false;
								}
							});
							stl_price_val = graduated_total;
						}
					}
					else if(billing_scheme == 'per_unit' && transform_usage == null)
					{
						stl_price_val = amount * stl_qty;
					}
					else if(billing_scheme == 'per_unit' && transform_usage != null)
					{
						divide_by = transform_usage['divide_by'];
						round = transform_usage['round'];
						remaing_val = stl_qty/divide_by;
						
						if(round == 'up')
						{
							remaing_val = Math.ceil(remaing_val);
						}
						else
						{
							remaing_val = Math.floor(remaing_val);
						}
						stl_price_val = amount * remaing_val;
					}
					else
					{
						stl_price_val = amount * stl_qty;
					}

					stl_price_txt = parseFloat(stl_price_val)/100;
					stl_price_txt = stl_price_txt.toFixed(2);

					plan_subtotal += stl_price_val;
					jQuery(this).find('.stl_price').val(stl_price_val);
					jQuery(this).find('.stl_price_txt').html(stl_price_txt);

					/*********** initial fee calculation *******/
					if(initial_fee_type == 'fixed')
					{
						initfee_orignal = initial_fee;
						initial_fee = initial_fee+stl_price_val;
						initial_fee_txt = parseFloat(initial_fee)/100;
						initial_fee_txt = parseInt(initial_fee_txt).toFixed(2);
						jQuery(this).find('.stl_initial_fee .stl_initial_feeval').val(initial_fee);
						jQuery(this).find('.stl_initial_fee p').html(initial_fee_txt);
					}
					else
					{
						initial_fee = (stl_price_val*initial_fee)/100;
						initfee_orignal = initial_fee;
						initial_fee = initial_fee+stl_price_val;
						initial_fee_txt = parseFloat(initial_fee)/100;
						initial_fee_txt = initial_fee_txt.toFixed(2);
						jQuery(this).find('.stl_initial_fee .stl_initial_feeval').val(initial_fee);
						jQuery(this).find('.stl_initial_fee p').html(initial_fee_txt);
					}
					initfee_subtotal += initial_fee;
					initfee_orignal_subtotal += initfee_orignal;
				}
			}
		});
		
		plan_subtotal_txt = parseFloat(plan_subtotal)/100;
		plan_subtotal_txt = plan_subtotal_txt.toFixed(2);

		jQuery(".plan_subtotal").val(plan_subtotal);
		jQuery(".plan_subtotal_txt").html(plan_subtotal_txt);

		initfee_subtotal_txt = parseFloat(initfee_subtotal)/100;
		initfee_subtotal_txt = initfee_subtotal_txt.toFixed(2);

		jQuery(".initfee_subtotal").val(initfee_subtotal);
		jQuery(".initfee_subtotal_txt").html(initfee_subtotal_txt);

		// initfee_fst_subtotal = plan_subtotal+initfee_subtotal;
		// initfee_fst_subtotal_txt = parseFloat(initfee_fst_subtotal)/100;
		// initfee_fst_subtotal_txt = initfee_fst_subtotal_txt.toFixed(2);

		// jQuery(".initfee_fst_subtotal").val(initfee_fst_subtotal);
		// jQuery(".initfee_fst_subtotal_txt").html(initfee_fst_subtotal_txt);

		var initfee_total = initfee_subtotal;
		// var initfee_fst_total = initfee_fst_subtotal;
		var plan_total = plan_subtotal;
		var apply_coupon = jQuery(".apply_coupon:checked").val() || '';
		var amount_off = jQuery(".amount_off").val();
		var amount_off_initfee = jQuery(".amount_off").val();
		var amount_off_initfee_fst = jQuery(".amount_off").val();
		var percent_off = jQuery(".percent_off").val();
		var addsub_taxoption = jQuery(".addsub_taxoption").val() || '';
		
		if(addsub_taxoption !='')
		{
			var tax_percentage = jQuery(".addsub_taxoption").data('percentage') || '';
			var tax_inclusive = jQuery(".addsub_taxoption").data('inclusive') || '';
			if(tax_inclusive !='')
			{	
				
				
				if(apply_coupon !='')
				{
					if(percent_off !='')
					{
						amount_off = (plan_total * percent_off)/100;
						amount_off_initfee = (initfee_total * percent_off)/100;
					}
					plan_total = plan_total - amount_off;
					initfee_total = initfee_total - amount_off_initfee;
				}

				tax_off = (plan_total*tax_percentage)/(tax_percentage+100);
				tax_off_initfee = (initfee_total*tax_percentage)/(tax_percentage+100);
				// if(tax_off > 1)
				// {
				// 	plan_total = plan_total + tax_off;
				// }

				// if(tax_off_initfee > 1)
				// {
				// 	initfee_total = initfee_total + tax_off_initfee;
				// }



			}
			else
			{
				if(apply_coupon !='')
				{
					if(percent_off !='')
					{
						amount_off = (plan_total * percent_off)/100;
						amount_off_initfee = (initfee_total * percent_off)/100;
					}
					plan_total = plan_total - amount_off;
					initfee_total = initfee_total - amount_off_initfee;
				}
				tax_off = (plan_total * tax_percentage)/100;
				tax_off_initfee = (initfee_total * tax_percentage)/100;

				if(tax_off > 1)
				{
					plan_total = plan_total + tax_off;
				}
				if(tax_off_initfee > 1)
				{
					initfee_total = initfee_total + tax_off_initfee;
				}
			}
			tax_off_txt = tax_off/100;
			tax_off_txt = tax_off_txt.toFixed(2);
			jQuery(".tax_amt").html(tax_off_txt);

			tax_off_initfee_txt = tax_off_initfee/100;
			tax_off_initfee_txt = tax_off_initfee_txt.toFixed(2);
			jQuery(".initfee_tax").html(tax_off_initfee_txt);


			// tax_off_initfee_fst = tax_off+tax_off_initfee;
			// tax_off_initfee_fst_txt = tax_off_initfee_fst/100;
			// tax_off_initfee_fst_txt = tax_off_initfee_fst_txt.toFixed(2);
			// jQuery(".initfee_fst_txt").html(tax_off_initfee_fst_txt);


		}
		else
		{
			if(apply_coupon !='')
				{
					if(percent_off !='')
					{
						amount_off = (plan_total * percent_off)/100;
						amount_off_initfee = (initfee_total * percent_off)/100;
					}
					plan_total = plan_total - amount_off;
					initfee_total = initfee_total - amount_off_initfee;
				}
				
		}
		amount_off_txt = amount_off/100;
		amount_off_txt = amount_off_txt.toFixed(2);
		jQuery(".apply_coupon_th").html("-"+amount_off_txt);



		amount_off_initfee_txt = amount_off_initfee/100;
		amount_off_initfee_txt = amount_off_initfee_txt.toFixed(2);
		jQuery(".initfee_ctotal").html("-"+amount_off_initfee_txt);

		// amount_off_initfee_fst = parseFloat(amount_off)+parseFloat(amount_off_initfee);
		// amount_off_initfee_fst_txt = amount_off_initfee_fst/100;
		// amount_off_initfee_fst_txt = amount_off_initfee_fst_txt.toFixed(2);
		// jQuery(".initfee_fst_ctotal").html("-"+amount_off_initfee_fst_txt);


		initfee_subtotal_act = initfee_orignal_subtotal;
		jQuery(".initfee_subtotal_act").val(initfee_subtotal_act);

		plan_total_txt = parseFloat(plan_total)/100;
		plan_total_txt = plan_total_txt.toFixed(2);
		jQuery(".plan_total").val(plan_total);
		jQuery(".plan_total_txt").html(plan_total_txt);

		initfee_total_txt = parseFloat(initfee_total)/100;
		initfee_total_txt = initfee_total_txt.toFixed(2);
		jQuery(".initfee_total").val(initfee_total);
		jQuery(".initfee_total_txt").html(initfee_total_txt);

		initfee_fst_total = plan_total+initfee_total;
		initfee_fst_total_txt = parseFloat(initfee_fst_total)/100;
		initfee_fst_total_txt = initfee_fst_total_txt.toFixed(2);
		// jQuery(".initfee_fst_total").val(initfee_fst_total);
		jQuery(".initfee_fst_total_txt").html(initfee_fst_total_txt);




		if(initialfee_cls_count > 0)
		{
			jQuery(".initialfee_cls").show();
		}
		else
		{
			jQuery(".initialfee_cls").hide();
		}
		jQuery(".initialfee_cls_count").val(initialfee_cls_count);
	
	}

	function escapeHtml(str)
	{
	    var map =
	    {
	        '&': '&amp;',
	        '<': '&lt;',
	        '>': '&gt;',
	        '"': '&quot;',
	        "'": '&#039;'
	    };
	    return str.replace(/[&<>"']/g, function(m) {return map[m];});
	}


	function retriveplans(trid){
		console.log("retriveddddddddd planssssssssssss");

		var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		var customer_country = jQuery(".customer_country").val();

		var stl_productplan = jQuery(".stl_productplan").find(':selected').val() || '';
		var product_plan_interval = jQuery(".stl_productplan").find(':selected').data('interval') || '';
		var ccmap_json = <?php echo $ccmap_json; ?>;
		var planlists_json = <?php echo $planlists_json; ?>;
		var subplainids_json = <?php echo $subplainids_json; ?>;
		var default_currency = "<?php echo $wssm_default_currency; ?>";
		var cdefault_currency_symbol = "<?php echo $cdefault_currency_symbol; ?>";
		var cdefault_currency = "<?php echo $cdefault_currency; ?>";
		var cdefault_currency_code = "<?php echo $cdefault_currency; ?>";
		var currency_const = <?php echo json_encode(WSSM_CURRENCY); ?>;
		var customer_id = jQuery(".customer_id").val();

		console.log("cdefault_currency = "+cdefault_currency);

		var plan_totalth = "<?= $total_txt ?>";
		var total_txt = "<?= __('Total','wp_stripe_management'); ?>";
		var monthly_txt = "<?= __('Monthly','wp_stripe_management'); ?>";
		var month_txt = "<?= __('Month','wp_stripe_management'); ?>";
		var dailyly_txt = "<?= __('Daily','wp_stripe_management'); ?>";
		var day_txt = "<?= __('Day','wp_stripe_management'); ?>";
		var yearly_txt = "<?= __('Yearly','wp_stripe_management'); ?>";
		var year_txt = "<?= __('Year','wp_stripe_management'); ?>";
		var initfee_txt = "<?= __('First','wp_stripe_management'); ?>";
		var first_txt = "<?= __('First','wp_stripe_management'); ?>";

		
		if(customer_id == '')
		{
			if(ccmap_json.length > 0)
			{
				jQuery.each(ccmap_json,function(ckey,cvalue){
					var country_code = cvalue['country_code'];
					var currency_code = cvalue['currency_code'];
					if(country_code == customer_country)
					{
						default_currency=currency_code;
						cdefault_currency_symbol = currency_code;
						cdefault_currency_code = currency_code;
						if(currency_const[currency_code] != undefined) {
							cdefault_currency_symbol = currency_const[currency_code];
						}
						else
						{
							cdefault_currency_symbol = 'US $';
						}
						// (array_key_exists($currency,WSSM_CURRENCY))?WSSM_CURRENCY[$currency]:'US $';

					}
				});
			}
		}
		else
		{
			default_currency=cdefault_currency;
			cdefault_currency_code = default_currency;
		}

	

		var plan_options = '<option value="">Select product plan</option>';
		
		// if(planlists_json['stl_status'])
		// {
		    // planlists_data = planlists_json['data'];
		    if(planlists_json.length>0)
		    {
		    	jQuery.each(planlists_json,function(key,value){

		    		
		    		if(jQuery.inArray(value['id'], subplainids_json) == -1){
			    		var plan_currency = value['currency'];
			    		var nickname = value['nickname'];
			    		var interval = value['interval'];
			    		var meta_data = value['metadata'];

			    		var plandata = JSON.stringify(value);
			    		var meta_webshop = '';
			    		var meta_min = 1;
			    		var meta_max = 10000000000;

			    		// console.log(meta_data);

			    		if(meta_data !='')
			    		{
			    			meta_webshop = meta_data['webshop'];
			    			meta_min = meta_data['min'];
			    			meta_max = meta_data['max'];
			    		}
			    		if(typeof meta_min === "undefined" || meta_min == '' || meta_min<1)
			    		{
			    			meta_min = 1;
			    		}
			    		if(typeof meta_max === "undefined" || meta_max == '' || meta_max<0)
			    		{
			    			meta_max = 100;
			    		}


			    		plandata = escapeHtml(plandata);

			    		if(default_currency == plan_currency && nickname !='' && nickname !=null && meta_webshop !='' && typeof meta_webshop !== "undefined")
			    		{
			    			if(product_plan_interval =='')
			    			{
			    				plan_options += '<option value="'+value['id']+'" data-interval="'+interval+'" data-plandata="'+plandata+'" data-min="'+meta_min+'" data-max="'+meta_max+'">'+nickname+'</option>';
			    			}
			    			else if(product_plan_interval == interval)
			    			{
			    				plan_options += '<option value="'+value['id']+'" data-interval="'+interval+'" data-plandata="'+plandata+'" data-min="'+meta_min+'" data-max="'+meta_max+'">'+nickname+'</option>';
			    			}
			    			else{}
			    		}
			    	}
		    		
		    	})
		    }

		// }

		if(trid == 'plan_count_1')
		{
			jQuery(".stl_productplan_another").html(plan_options);
			jQuery("#"+trid+" .stl_productplan_another").focus();
		}
		if(stl_productplan == '')
		{
			jQuery("#"+trid+" .stl_productplan").html(plan_options);
			jQuery("#"+trid+" .stl_productplan").focus();
			
		}
		else
		{

			jQuery("#"+trid+" .stl_productplan_another").html(plan_options);
			jQuery("#"+trid+" .stl_productplan_another").focus();
		}



		// if(customer_id !='')
		// {
		// 	plan_totalth = total_txt;
		// }
		// else
		// {
			plan_totalth = monthly_txt;
		// }

		plan_fstth = month_txt;
		var plan_totalth_txt = plan_totalth+" ("+cdefault_currency_symbol+")";
		// var inv_total_txt = plan_totalth;
		// var plan_fstmonth_txt = first_txt+" "+month_txt+" ("+cdefault_currency_symbol+")";
		if(product_plan_interval !='')
		{
			// if(customer_id !='')
			// {
			// 	plan_totalth = total_txt;
				
			// }
			// else
			// {
				if(product_plan_interval == 'day'){plan_totalth = dailyly_txt;initfee_txt = initfee_txt+" "+day_txt;}
				else if(product_plan_interval == 'year'){plan_totalth = yearly_txt;initfee_txt = initfee_txt+" "+year_txt;}
				else{plan_totalth = monthly_txt;initfee_txt = initfee_txt+" "+month_txt;}
			// }
			plan_totalth_txt = plan_totalth+" ("+cdefault_currency_symbol+"/"+product_plan_interval+")";
			// plan_fstmonth_txt = first_txt+' '+plan_fstth+" ("+cdefault_currency_symbol+")";
		}
		
		jQuery(".plan_totalth").html(plan_totalth_txt);
		// jQuery(".inv_total_txt").html(inv_total_txt);
		jQuery(".cdefault_currency").val(cdefault_currency_code);

		jQuery(".plan_initialth").html(initfee_txt+" ("+cdefault_currency_symbol+")");


		console.log("cdefault_currency_code = "+cdefault_currency_code);
		console.log("cdefault_currency_symbol = "+cdefault_currency_symbol);
		console.log(jQuery(".cdefault_currency").val());




		
		// jQuery(".plan_fstmonth").html(plan_fstmonth_txt);

	}
	
	function new_subscription_submitfn(){
			var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			var $form = jQuery(".add_subscriptionform");
			jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: $form.serialize(),
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){

					// if(response['stl_status'])
					// {
						toastr.options = {"closeButton": true,}
						toastr.success("<?= _e('New subscription added successfully','wp_stripe_management'); ?>", "<?= _e('Success','wp_stripe_management'); ?>");
						setTimeout(function(){
							// location.reload();
							var page_sub = jQuery(".page_sub").val();
							var page_subsuccess = jQuery(".page_subsuccess").val();
							if(page_subsuccess !='')
							{
								window.location.href = "<?php echo site_url(); ?>"+"/"+page_subsuccess;
							}
							else
							{
								window.location.href = "<?php echo site_url(); ?>"+"/"+page_sub;
							}
							

						}, 800);

					// }
					// else
					// {
					// 	toastr.error(response['message'], "<?= _e('Error','wp_stripe_management'); ?>");
					// 	if(response['customer_id'] !='')
					// 	{
					// 		jQuery(".customer_id").val(response['customer_id']);
					// 	}
					// }
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				},
				error: function(xhr, status, error){
					toastr.error( xhr.responseText, "<?= _e('Error','wp_stripe_management'); ?>");
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
					// toastr.error('Error', "<?= _e('Error','wp_stripe_management'); ?>");
				}
			});
	}
	



	

});



</script>

