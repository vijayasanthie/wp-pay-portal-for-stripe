<?php

	$new_sub_btn_enable = '';

	// if($planlists['stl_status']){
		if(!empty($planlists))
		{
			// $plandatas = $planlists['data'];
			foreach($planlists as $key => $value)
			{
				$meta_webshop = '';
				$plan_currency = $value['currency'];
				$nickname = $value['nickname'];
		    		$interval = $value['interval'];
		    		$meta_data = $value['metadata'];

		    		if($meta_data !='')
		    		{
		    			$meta_webshop = $meta_data['webshop'];

		    		}

				if($cdefault_currency == $plan_currency && $nickname !='' && $meta_webshop !='')
		    	{
		    		$new_sub_btn_enable = '1';
		    	}

			}
		}
	// }
	
	// $address_line1 = $address_line2 = $city = $state = $country =$postal_code = $company_name = $email = $phone = '';
	// // if($subscriptiondatas['stl_status']){

	// 	$customer_lists = $subscriptiondatas['customer_lists'];
	// 	if(!empty($customer_lists['data']))
	// 	{
	// 		$customer_list = $customer_lists['data'][0];
	// 		// echo "<pre>";print_r($customer_list);echo "</pre>";
	// 		$address_line1 = $customer_list['address']['line1'];
	// 		$address_line2 = $customer_list['address']['line2'];
	// 		$city = $customer_list['address']['city'];
	// 		$state = $customer_list['address']['state'];
	// 		$country = $customer_list['address']['country'];
	// 		$postal_code = $customer_list['address']['postal_code'];

	// 		$company_name = $customer_list['name'];
	// 		$email = $customer_list['email'];
	// 		$phone = $customer_list['phone'];
	// 	}
	// }

	$coupon_id = '';
	// echo "<pre>";print_r($customerdata);echo "</pre>";
	// echo "  ==== ".$customerdata['discount']['coupon']['id'];
	if($customerdata['stl_status'])
	{
		if(!empty($customerdata['discount']))
			{
				$coupon_id = isset($customerdata['discount']['coupon']['id'])?$customerdata['discount']['coupon']['id']:'';
			}
	}
	// echo "coupon_id = ".$coupon_id;
?>

<div class="stl-row">
	<input type="hidden" class="stl_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
		
			<?php 
			$page_addsub = get_option('wssm_stripe_page_addsubscription','');

			include_once(WPSTRIPESM_DIR.'templates/common_input.php');
			include_once(WPSTRIPESM_DIR.'templates/sidebar.php'); ?>
			<div class="stl-col-md-12">
				<p class="stl_htitle"><?= _e('Subscriptions','wp_stripe_management'); ?> 
				<?php
				if($new_sub_btn_enable == ''){ ?>
					<a href="javascript:void(0);" class="stl-btn stl-btn-sm stl-btn-default btn_addsubscription" disabled><?= _e('New','wp_stripe_management'); ?></a>
				<?php } else { ?>
					<a href="<?php echo site_url().'/'.$page_addsub; ?>" class="stl-btn stl-btn-sm stl-btn-default btn_addsubscription" ><?= _e('New','wp_stripe_management'); ?></a>
				<?php } ?>
			</p>
			<div class="stl_preloader"><img src="<?php echo SUBPRELOADER_IMG; ?>" class="img-responsive" /></div>

				<?php
					$stripecls = new WPStlStripeManagement();
					$subscriptiondatas = $stripecls->getCustomerSubscriptionlist();
					//echo "<pre>";print_r($planlists);echo "</pre>";
					// echo "<pre>";print_r($subscriptiondatas);echo "</pre>";
				
					// if($subscriptiondatas['stl_status'])
					// {
						$subscription_lists = $subscriptiondatas['subscription_lists'];
						if(!empty($subscription_lists)) {
						 global $wpdb;
						
                		$table_name = WSSM_METADATA_TABLE_NAME; 
                		$ftable_results = $wpdb->get_results( "SELECT * FROM ".$table_name." where sublist_activation='1'" );
                		$ftable_results_count = sizeof($ftable_results);
						?>
						<input type="hidden" class="ftable_results_count" value="<?=$ftable_results_count; ?>">
						<table class="stl-table stlcard_table" id="subscription_tb">
							<thead>
								<tr>
									<th class="stl-text-right padrighttd"><?= _e('Amt','wp_stripe_management'); ?> (<?=$cdefault_currency_symbol;?>)</th>
                                    <th><?= _e('Qty','wp_stripe_management'); ?></th>
                                    <?php
									// if($ftable_results)
									// {
										foreach($ftable_results as $ftable_result)
										{
											echo '<th class="stub_metath">'.$ftable_result->sublist_activation_label.'</th>';
										}
									// }
									?>
									<!-- <th class="stl-text-left"><?= _e('Application','wp_stripe_management'); ?></th> -->
									<!-- <th class="stl-text-left"><?= _e('Customer','wp_stripe_management'); ?></th> -->
									<th><?= _e('Next Payment','wp_stripe_management'); ?></th>
									<!-- <th><?= _e('Created','wp_stripe_management'); ?></th> -->
									<th><?= _e('Name','wp_stripe_management'); ?></th>
									
									<th class='stl-text-center'><?= _e('Status','wp_stripe_management'); ?></th>
									<th><?= _e('Collection','wp_stripe_management'); ?></th>
									<th><?= _e('Action','wp_stripe_management'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=0;
								foreach($subscription_lists as $subscription_list)
								{
									
									$cmncls = new WPStlCommoncls();
									$total_amount = $cmncls->getSubscriptionTotal($subscription_list['id'],$subscription_list['discount']);

									$collection_method = $subscription_list['collection_method'];
									$subscription_status = $subscription_list['status'];
									$metadata = $subscription_list['metadata'];
									// $application = $customer = '';
									// if(!empty($metadata))
									// {
									// 	$application = (isset($metadata['application']))?$metadata['application']:'';
									// 	$customer = (isset($metadata['customer']))?$metadata['customer']:'';
									// }
									$collectiont_txt = get_collectiontype($collection_method);
									$payment_type = WSSM_PAYMENT_TYPES;
									// if($collection_method == 'charge_automatically')
									// {
									// 	$btn_txt = 'Send invoice (manual payment)';
									// 	$ptype = 'send_invoice';
									// }
									// else
									// {
									// 	$btn_txt = 'Pay automatically';
									// 	$ptype = 'charge_automatically';
									// }

									$cancel_at_period_end = $subscription_list['cancel_at_period_end'];
									$cancel_at = $subscription_list['cancel_at'];

									// echo "cancel_at = ".$cancel_at." === ".strtotime(date('Y-m-d'))."<br>";
									$cancel_txt = '';
									if($cancel_at_period_end == 1)
									{
										$cancel_txt = " <br><small>Ends ".date('Y-m-d',$cancel_at)."</small>";
									}

									$plan_amt = $subscription_list['plan']['amount']/100;
									$plan_amt = number_format($plan_amt,2);

									if($subscription_status == 'active')
									{
										$data_order = 1;
										$data_status = '<span class="stl-label stl-label-success">Active</span>'.$cancel_txt;
									}
									else if($subscription_status == 'trialing')
									{
										$trial_end = $subscription_list['trial_end'];
										$trial_end = date('Y-m-d',$trial_end);
										$date2=date_create($trial_end);
										$date1=date_create(date('Y-m-d'));
										$diff=date_diff($date1,$date2);
										$remaining_date = 
										$data_order = 2;
										$data_status = '<span class="stl-label stl-label-default">Trialing '.$diff->format("(%a days left)").'</span> '.$cancel_txt;
									}
									else if($subscription_status == 'past_due')
									{
										$data_order = 3;
										$data_status = '<span class="stl-label stl-label-warning">Past Due</span> '.$cancel_txt;
									}
									else if($subscription_status == 'unpaid')
									{
										$data_order = 4;
										$data_status = '<span class="stl-label stl-label-warning">UnPaid</span> '.$cancel_txt;
									}
									else if($subscription_status == 'canceled')
									{
										$data_order = 5;
										$data_status = '<span class="stl-label stl-label-danger">Canceled</span>';
									}
									else if($subscription_status == 'incomplete')
									{
										$data_order = 6;
										$data_status = '<span class="stl-label stl-label-danger">Incomplete</span>';
									}
									else
									{
										$data_order = 7;
										$data_status = '<span class="stl-label stl-label-default">Incomplete Expired</span>';
									}

									// $total_amount = 0;
									$items_datas = $subscription_list['items']['data'];

									// $total_amount = $subscription_list['invoice']['data'][0]['total'];



									$interval = '';
									$currency = '<?=$cdefault_currency;?>';

									
									$plan_nicknames = array();

									$meter_sub = 0;
									$meter_subids = array();
									$stl_total_qty = 0;
									// echo "<pre>";print_r($items_datas);echo "</pre>";
									if(!empty($items_datas))
									{
										foreach($items_datas as $items_data)
										{
											$stl_price_val = 0;
											$stl_qty = (isset($items_data['quantity']))?$items_data['quantity']:0;
											$amount = (isset($items_data['plan']['amount']))?$items_data['plan']['amount']:0;
											$interval = (isset($items_data['plan']['interval']))?$items_data['plan']['interval']:0;
											// $currency = (isset($items_data['plan']['currency']))?$items_data['plan']['currency']:'usd';
											$nickname = (isset($items_data['plan']['nickname']))?$items_data['plan']['nickname']:'';
											$usage_type = (isset($items_data['plan']['usage_type']))?$items_data['plan']['usage_type']:'';
											$subitem_id = (isset($items_data['id']))?$items_data['id']:'';
											if($usage_type == 'metered')
											{
												$meter_sub = 1;
												$meter_subids[] = $subitem_id;
											}
											// $currency_sympol = WSSM_CURRENCY[$currency];
											$plan_nicknames[] = $nickname;
											$stl_total_qty += $stl_qty;
											// echo "stl_qty = ".$stl_qty;
											// break;


											
										}
									}
									// echo "stl_total_qty = ".$stl_total_qty;

									$meter_subids = implode(',',$meter_subids);

									$plan_nicknames = array_unique($plan_nicknames);
									$plan_nicknames = implode(', ',$plan_nicknames);

									$plan_nicknames = strlen($plan_nicknames) > 40 ? substr($plan_nicknames,0,40)."..." : $plan_nicknames;



									$total_amount = $total_amount/100;
									$total_amount = number_format($total_amount,2);
									


									$i++;
									echo "<tr data-id='".$subscription_list['id']."' data-cusid='".$subscription_list['customer']."' data-cmthod='".$subscription_list['collection_method']."' data-coupon='".$coupon_id."'>
											<td class='stl-text-right padrighttd'>".$total_amount."/".$interval."</td><td>".$stl_total_qty."</td>";

											if($ftable_results)
									{
										foreach($ftable_results as $ftable_result)
										{
											$stripe_fname = $ftable_result->stripe_fname;
											// echo '<th class="stl-text-left">'.$ftable_result->sublist_activation_label.'</th>';
											$stripe_response = (isset($metadata[$stripe_fname]))?$metadata[$stripe_fname]:'';
											echo "  <td class='stub_metatd'>".$stripe_response."</td>";
										}
									}

											// <td class='stl-text-left td_application'>".$application."</td>
											// <td class='stl-text-left td_customer'>".$customer."</td>
											echo "  <td>".date('d M, Y',$subscription_list['current_period_end'])."</td>
											
											<td class='subtb_nickname' title='".$subscription_list['id']."'>".$plan_nicknames."</td>
											<td class='stl-text-center' data-order='".$data_order."' data-search='".$subscription_status."'>".$data_status."</td>
											<td>".$collectiont_txt."</td>
											<td>";
											$lilist = '';
											
											if($subscription_status == 'active' || $subscription_status == 'trialing')
											{
												$lilist .=  "<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_viewnxtinvoice'>".__('Next invoice','wp_stripe_management')."</button></li>";
												// if($coupon_id !='')
												// {
													$lilist .=  "<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_applycoupon'>".__('Set coupon','wp_stripe_management')."</button></li>";

												// }
											}

											if($subscription_status != 'canceled' )
											{
												$lilist .=  "<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_changepaymode'>".__('Set Autopay','wp_stripe_management')."</button></li>";

												if($cancel_at_period_end == 1 && strtotime(date('Y-m-d')) <= $cancel_at)
												{
													//$lilist .= "<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_reactivesub'>".__('Re-active','wp_stripe_management')."</button></li>";
												}
												else
												{
													$lilist .=  "<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_cancelsub'>".__('Unsubscribe','wp_stripe_management')."</button></li>";
												}

												

												/*if($collection_method == 'charge_automatically')
												{
													echo "&nbsp; &nbsp; <button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_changepaymode btn_paymanual1'>".__('Set Manual Pay','wp_stripe_management')."</button>";
												}
												else
												{
													echo "&nbsp; &nbsp; <button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_changepaymode btn_payauto1'>".__('Set Autopay','wp_stripe_management')."</button>";
												}*/
											}

											if($meter_sub)
											{
												$lilist .=  "<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_viewusage' data-subitemid='".$meter_subids."'>".__('View Usage','wp_stripe_management')."</button></li>";
											}

											

										    if($lilist !='' && $subscription_status != 'incomplete_expired')
										    {
										    	echo '  <div class="stl-dropdown">
										    <button class="stl-btn stl-btn-sm stl-btn-default stl-dropdown-toggle" type="button" data-toggle="dropdown">'.__('Action','wp_stripe_management').'
										    <span class="caret"></span></button>
										    <ul class="stl-dropdown-menu">'.$lilist.'</ul></div>';
										    }
 

											//echo "<button type='button' class='stl-btn stl-btn-sm stl-btn-info btn_editcardinfo1'>".__('Edit','wp_stripe_management')."</button>";

											echo "</td>
										</tr>";
								}
								?>
							</tbody>
						</table>
						<?php
						}
						else
						{
							echo __('No records found','wp_stripe_management');
						}
					// }
				?>
			</div>
		</div>
	</div>



<div id="update_coupon_modal" class="stl-modal">
	<div class="stl-modal-dialog stl-modal-sm">
	 	<div class="stl_ajaxloader1"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
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
						<input type="hidden" name="coupon_subid" id="coupon_subid">
						<input type="hidden" name="sub_customer_id" id="sub_customer_id">
						
					   	<div class="stl-col-md-12">
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Coupon','wp_stripe_management'); ?></label>
									<input type="text" name="coupon" class="stl-form-control sub_coupon_id" value="" placeholder="Code" autofocus>
								</div>
					   		</div>
					   	</div>
				         <div class="stl-col-md-12 stl-text-right">
				          	<button type="button" class="stl-btn stl-btn-default btn_modalcancel"><?php _e('Cancel','wp_stripe_management'); ?></button>
				          	<button type="button" name="savee" class="stl-btn stl-btn-success btn_savecoupon"><?php _e('Set Coupon','wp_stripe_management'); ?></button>
				        </div>
    				</form>
    				<?php } ?>
				</div>
	      	</div>
	    </div>
	</div>
</div>


<div id="view_nextinvoice_modal" class="stl-modal">
	 <div class="stl-modal-dialog stl-modal-lg">
	 	<div class="stl_ajaxloader">
  			<img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" />
		</div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><?php _e( 'Next invoice', 'wp_stripe_management' ); ?></p>
	      	</div>
	      	<div class="stl-modal-body">
	      	</div>
	    </div>
	</div>
</div>


<div id="view_usage_modal" class="stl-modal">
	 <div class="stl-modal-dialog stl-modal-lg">
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><?php _e( 'Metered Usage For Subscription', 'wp_stripe_management' ); ?> <span class="modal_subtitle"></span></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<table class="stl-table">
	      			<thead>
	      				<tr>
	      					<td><?php _e( 'QUANTITY', 'wp_stripe_management' ); ?></td>
	      					<td><?php _e( 'PERIOD', 'wp_stripe_management' ); ?></td>
	      				</tr>
	      			</thead>
	      			<tbody>
	      			</tbody>
	      		</table>
	      	</div>
	    </div>
	</div>
</div>

<div id="paymode_modal" class="stl-modal">
	 <div class="stl-modal-dialog stl-modal-md">
	 	<div class="stl_ajaxloader1">
  			<img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" />
		</div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><?php _e( 'Set Autopay', 'wp_stripe_management' ); ?></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-col-md-12">
	      			<input type="hidden" class="subscription_id" name="subscription_id">
	      			<input type="hidden" class="default_collection" name="default_collection">
	      			<label><?= _e('How would you like funds to be collected?','wp_stripe_management'); ?></label>
	      			<div class="stl-row">
	      				<br>
	      				<div class="stl-col-md-5">
	      					<label style="font-weight: normal;">
	      						<input type="radio" name="collection_method" class="collection_method" value="send_invoice">
	      						<?= _e('Send invoice (manual payment)','wp_stripe_management'); ?>
	      					</label>
	      				</div>
	      				<div class="stl-col-md-7">
	      					<label style="font-weight: normal;">
	      						<input type="radio" name="collection_method" class="collection_method" value="charge_automatically">
	      						<?= _e('Pay automatically using card','wp_stripe_management'); ?>&nbsp;
	      						<?php
									// if($cardlists['stl_status'])
									// {
										if(!empty($cardlists)){
											echo '<select name="card_id" class="stl-form-control subcardid">';
											// $card_lists = $cardlists['card_lists'];
											foreach($cardlists as $card_list)
											{
												echo '<option value="'.$card_list['id'].'">•••• '.$card_list['last4'].'</option>';
											}
											echo '</select>';
										}
									// }
								?>
	      					</label>
	      				</div>
	      				<br>
	      				<!-- <div class="stl-col-md-12 stl_manualpay">
									<label class="stl-col-md-2">Payment due</label>
									<div class="stl-col-md-2">
										<input type="number" name="payment_due_date" class="stl-form-control payment_due_date" value="" placeholder="days" autocomplete="off">
										
									</div>
									<span class="stl-col-md-4">days after invoice is sent</span>
									<span id="payment_due_date-error" class="stl-col-md-12 stl-help-block stl-help-block-error">Please enter the payment due date value</span>
								</div> -->
	      			</div>
	      		</div>
	      	</div>
	      	<div class="stl-modal-footer">
        		<button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_modalcancel">Cancel</button>
        		<button type="button" class="stl-btn stl-btn-sm stl-btn-success btn_savecmethod">Save Changes</button>
      		</div>
	    </div>
	</div>
</div>
