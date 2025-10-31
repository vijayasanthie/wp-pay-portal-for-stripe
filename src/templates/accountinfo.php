<?php //get_header(); ?>
	<div class="stl-row">

	<div class="stl-col-md-12">
	
			<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php'); ?>
			<?php include_once(WPSTRIPESM_DIR.'templates/sidebar.php'); ?>

		<?php
		// echo "<pre>";print_r($customerdata);echo "</pre>";
		// echo "cdefault_currency = ".$cdefault_currency;


		$current_user = wp_get_current_user();
		$email = $current_user->user_email;

		$address_line1 = $address_line2 = $city = $state = $country =$postal_code = $customer_name = $phone =  $customer_id = $amount_off = $percent_off = $coupon_name = '';
		if($customerdata['stl_status']){
			$stl_address = array();
			$percent_off = '';
			if(!empty($customerdata['address']))
			{
				$stl_address[] = $customerdata['address']['line1'];
				$stl_address[] = $customerdata['address']['line2'];
				$stl_address[] = $customerdata['address']['city'];
				$stl_address[] = $customerdata['address']['state'];
				$stl_address[] = $customerdata['address']['country'];
				$stl_address[] = $customerdata['address']['postal_code'];
				$address_line1 = $customerdata['address']['line1'];
				$address_line2 = $customerdata['address']['line2'];
				$city = $customerdata['address']['city'];
				$state = $customerdata['address']['state'];
				$country = $customerdata['address']['country'];
				$postal_code = $customerdata['address']['postal_code'];

				$customer_name = $customerdata['name'];
				$email = $customerdata['email'];
				$phone = $customerdata['phone'];
				$customer_id = $customerdata['id'];

				$country_data = WSSM_COUNTRY;
				if($country !='' && array_key_exists($country,$country_data))
				{
					$country =  $country_data[$country];
				}
				else
				{
					$country =  $country;
				}

			}
			if(!empty($customerdata['discount']))
			{
				$percent_off = (isset($customerdata['discount']['coupon']['percent_off']) && $customerdata['discount']['coupon']['percent_off'] !='')?$customerdata['discount']['coupon']['percent_off']."%":'';
				$amount_off = (isset($customerdata['discount']['coupon']['amount_off']) && $customerdata['discount']['coupon']['amount_off'] !='')?$customerdata['discount']['coupon']['amount_off']:'';
				$coupon_name = (isset($customerdata['discount']['coupon']['name']) && $customerdata['discount']['coupon']['name'] !='')?$customerdata['discount']['coupon']['name']:'';
				// $amount_off_currency = isset($customerdata['discount']['coupon']['currency'])?$customerdata['discount']['coupon']['currency']:'';

				// $amount_offcurrency_sympol = WSSM_CURRENCY[$amount_off_currency];
				// $amount_offcurrency_sympol = (array_key_exists($amount_off_currency,WSSM_CURRENCY) && $amount_off_currency !='')?WSSM_CURRENCY[$amount_off_currency]:'US $';
				if($amount_off !='')
				{
					$amount_off = $amount_off/100;
					$amount_off = number_format($amount_off,2);
					$amount_off = $cdefault_currency_symbol." ".$amount_off;
				}


			}
			$fullname = '';
			if(!empty($customerdata['metadata']))
			{
				$fullname = (isset($customerdata['metadata']['fullname']))?$customerdata['metadata']['fullname']:'';
			}

			$stl_address = array_filter($stl_address);
			$stl_address = implode(', ',$stl_address);

			$balance = $customerdata['balance'];
			if($balance !='')
			{
				$balance = $balance/100;
				$balance = number_format($balance,2);
			}
			// echo "balance = ".$balance;
					
			// $currency = $customerdata['currency'];
			// $currency_sympol = (array_key_exists($currency,WSSM_CURRENCY))?WSSM_CURRENCY[$currency]:'US $';
		?>
		<div class="stl-col-md-12">
			<p class="stl_htitle"><?= _e('Account Information','wp_stripe_management'); ?> <button type="button" class="stl-btn stl-btn-info btn_editaccountinfo"><?= _e('edit','wp_stripe_management'); ?></button></p>

			<div class="stl-col-md-3">
				<p><b><?= _e('Full Name','wp_stripe_management'); ?></b><br>
				<?= $fullname; ?></p>
			</div>
			<div class="stl-col-md-3">
				<p><b><?= _e('Company Name','wp_stripe_management'); ?></b><br>
				<?= ($customerdata['name'] !='')?$customerdata['name']:'-'; ?></p>
			</div>
			<div class="stl-col-md-3 phone_formated_div">
				<p><b><?= _e('Phone','wp_stripe_management'); ?></b><br>
					<input type="text" class="phone_formated" value="<?= ($customerdata['phone'] !='')?$customerdata['phone']:'-'; ?>" readonly>
				
			</div>
			<div class="stl-col-md-3">
				<p><b><?= _e('Email','wp_stripe_management'); ?></b><br>
				<?= ($customerdata['email'] !='')?$customerdata['email']:'-'; ?></p>
			</div>
			<div class="stl-col-md-6" style="clear: both;">
				<p><b><?= _e('Address','wp_stripe_management'); ?></b><br>
				<?= ($stl_address !='')?$stl_address:'-'; ?></p>
			</div>
			<div class="stl-col-md-3">
				<p><b><?= _e('Coupon Discount','wp_stripe_management'); ?></b><br>
				<?php 
				// echo "percent_off = ".$percent_off." = amount_off = ".$amount_off;
				if($percent_off !='')
				{
					echo $coupon_name." (".$percent_off.")";
				}
				else if($amount_off !='')
				{
					echo $coupon_name." (".$amount_off.")";
				}
				else { 
					echo "";
				}
				?>
					<button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_opencoupon"><?= _e('Set Coupon','wp_stripe_management'); ?></button>

			</p>
			</div>
			<div class="stl-col-md-3">
				<p><b><?= _e('Balance','wp_stripe_management'); ?></b><br>
				<?= ($customerdata['balance'] !='')?$cdefault_currency_symbol." ".$balance:$cdefault_currency_symbol.'0.00'; ?></p>
			</div>
		</div>
		<?php } else { 
			echo "<div class='stl-col-md-12'>
					<div class='stl-alert stl-alert-danger'>".__('Stripe customer not found for this emailid.','wp_stripe_management')."
					<button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_newcustomer'>".__('Create new stripe account','wp_stripe_management')."</button>
					</div>
				</div>";
		 } ?>
		</div>
	</div>



<div id="edit_accountinfo_modal" class="stl-modal">
	 <div class="stl-modal-dialog">
	 	<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><?php _e( 'Edit Account Info', 'wp_stripe_management' ); ?></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-row">
	      			
					<form id="account_infoform" method="post">
						<input type="hidden" name="customer_id" class="customer_id" value="<?= $customer_id; ?>">
						<input type="hidden" name="action" value="SaveAccountInfo">
					   	<div class="stl-col-md-12">
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Full Name','wp_stripe_management'); ?></label>
									<input type="text" name="full_name" class="stl-form-control" value="<?= $fullname; ?>" autofocus="autofocus">
									<input type="hidden" name="old_full_name" class="stl-form-control" value="<?= $old_full_name; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Company Name','wp_stripe_management'); ?></label>
									<input type="text" name="company_name" class="stl-form-control" value="<?= $customer_name; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Email','wp_stripe_management'); ?></label>
									<input type="email" name="emailid" class="stl-form-control emailid" value="<?= $email; ?>" >
									<input type="hidden" name="old_emailid" class="old_emailid stl-form-control" value="<?= $email; ?>" >
								</div>
					   		</div>
					   		
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Phone','wp_stripe_management'); ?></label>
									<!-- <input type="hidden" name="phone" id="phone" class="stl-form-control" value="<?= $phone; ?>"> -->
									<div>
										<input type="text" id="phone_format" class="stl-form-control" value="<?= $phone; ?>">
									</div>
								</div>
					   		</div>
					   		<div class="stl-col-md-12">	

					   			<div class="stl-form-group">
									<label><?= _e('Street Address 1','wp_stripe_management'); ?></label>
									<input type="text" name="address_line1" class="stl-form-control" value="<?= $address_line1; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Street Address 2','wp_stripe_management'); ?></label>
									<input type="text" name="address_line2" class="stl-form-control" value="<?= $address_line2; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('City','wp_stripe_management'); ?></label>
									<input type="text" name="city" class="stl-form-control" value="<?= $city; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('State/Province','wp_stripe_management'); ?></label>
									<input type="text" name="state" class="stl-form-control" value="<?= $state; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Zip/Postcode','wp_stripe_management'); ?></label>
									<input type="text" name="postal_code" class="stl-form-control" value="<?= $postal_code; ?>">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Country','wp_stripe_management'); ?></label>
									<!-- <input type="text" name="country" class="stl-form-control" value="<?= $country; ?>" readonly> -->
									<?php
									if($customer_id !='')
									{
										?>
										<input type="text" name="country" class="stl-form-control" value="<?= $country; ?>" readonly>
										<?php
									}
									else
									{
										$country_data = WSSM_COUNTRY;
										
										echo '<select name="country" class="stl-form-control">';
											foreach($country_data as $key => $value)
											{
												echo "<option value='".$key."'>".$value."</option>";
											}
										echo '</select>';
										
									}
									?>

								</div>
					   		</div>
					   	</div>
				         <div class="stl-col-md-12 stl-text-right">
				          	<button type="button" class="stl-btn stl-btn-default btn_modalcancel"><?php _e('Cancel','wp_stripe_management'); ?></button>
				          	<button type="submit" name="savee" class="stl-btn stl-btn-success btn_saveainfo"><?php _e('Save Changes','wp_stripe_management'); ?></button>
				        </div>
    				</form>
    				<?php //} ?>
				</div>
	      	</div>
	    </div>
	</div>
</div>


<div id="add_coupon_modal" class="stl-modal">
	<div class="stl-modal-dialog stl-modal-sm">
	 	<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><?php _e( 'Set Coupon', 'wp_stripe_management' ); ?></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-row">
	      			<?php 
	      			if($customerdata['stl_status']){ ?>
					<form id="account_couponform" method="post">
						<input type="hidden" name="action" value="SaveAccountCupon">
					   	<div class="stl-col-md-12">
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Coupon','wp_stripe_management'); ?></label>
									<input type="text" name="coupon" class="stl-form-control" value="" placeholder="<?= _e('Code','wp_stripe_management'); ?>" autofocus>
								</div>
					   		</div>
					   	</div>
				         <div class="stl-col-md-12 stl-text-right">
				          	<button type="button" class="stl-btn stl-btn-default btn_modalcancel"><?php _e('Cancel','wp_stripe_management'); ?></button>
				          	<button type="submit" name="savee" class="stl-btn stl-btn-success btn_saveainfo"><?php _e('Set Coupon','wp_stripe_management'); ?></button>
				        </div>
    				</form>
    				<?php } ?>
				</div>
	      	</div>
	    </div>
	</div>
</div>

