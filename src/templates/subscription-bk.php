<?php get_header(); ?>
<?php

	$address_line1 = $address_line2 = $city = $state = $country =$postal_code = $company_name = $email = $phone = '';
	if($subscriptiondatas['stl_status']){

		$customer_lists = $subscriptiondatas['customer_lists'];
		
		if($customer_lists['data'] !='')
		{
			$customer_list = $customer_lists['data'][0];
			// echo "<pre>";print_r($customer_list);echo "</pre>";
			$address_line1 = $customer_list['address']['line1'];
			$address_line2 = $customer_list['address']['line2'];
			$city = $customer_list['address']['city'];
			$state = $customer_list['address']['state'];
			$country = $customer_list['address']['country'];
			$postal_code = $customer_list['address']['postal_code'];

			$company_name = $customer_list['name'];
			$email = $customer_list['email'];
			$phone = $customer_list['phone'];
		}
	}
?>

<div class="stl-container">
	<input type="hidden" class="stl_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
		<div class="stl-row">
			<?php include_once(WPSTRIPESM_DIR.'templates/sidebar.php'); ?>
			<div class="stl-col-md-12">
				<h4><?= _e('Subscription','wp_stripe_management'); ?> <a href="http://stallioni.in/595/wp-stripe-management/add_subscription/" class="stl-btn stl-btn-sm stl-btn-default btn_addsubscription"><?= _e('New','wp_stripe_management'); ?></a></h4>
				<?php
					//echo "<pre>";print_r($planlists);echo "</pre>";
					echo "<pre>";print_r($subscriptiondatas);echo "</pre>";
				
					if($subscriptiondatas['stl_status'])
					{
						$subscription_lists = $subscriptiondatas['subscription_lists'];
						?>
						<table class="stl-table stlcard_table" id="subscription_tb">
							<thead>
								<tr>
									<th><?= _e('Amount','wp_stripe_management'); ?></th>
									<th><?= _e('Application','wp_stripe_management'); ?></th>
									<th><?= _e('Customer','wp_stripe_management'); ?></th>
									<th><?= _e('Next Payment','wp_stripe_management'); ?></th>
									<th><?= _e('Created','wp_stripe_management'); ?></th>
									<th><?= _e('Name','wp_stripe_management'); ?></th>
									<th><?= _e('Status','wp_stripe_management'); ?></th>
									<th><?= _e('Collection','wp_stripe_management'); ?></th>
									<th><?= _e('Action','wp_stripe_management'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=0;
								foreach($subscription_lists as $subscription_list)
								{
									$collection_method = $subscription_list['collection_method'];
									$subscription_status = $subscription_list['status'];
									$metadata = $subscription_list['metadata'];
									$application = $customer = '';
									if(!empty($metadata))
									{
										$application = (isset($metadata['application']))?$metadata['application']:'';
										$customer = (isset($metadata['customer']))?$metadata['customer']:'';
									}
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

									$plan_amt = $subscription_list['plan']['amount']/100;
									$plan_amt = number_format($plan_amt,2);

									if($subscription_status == 'active')
									{
										$data_order = 1;
										$data_status = '<span class="label label-success">Active</span>';
									}
									else if($subscription_status == 'trialing')
									{
										$data_order = 2;
										$data_status = '<span class="label label-default">Trialing</span>';
									}
									else if($subscription_status == 'past_due')
									{
										$data_order = 3;
										$data_status = '<span class="label label-warning">Past Due</span>';
									}
									else if($subscription_status == 'unpaid')
									{
										$data_order = 4;
										$data_status = '<span class="label label-warning">UnPaid</span>';
									}
									else if($subscription_status == 'canceled')
									{
										$data_order = 5;
										$data_status = '<span class="label label-danger">Canceled</span>';
									}
									else if($subscription_status == 'incomplete')
									{
										$data_order = 6;
										$data_status = '<span class="label label-danger">Incomplete</span>';
									}
									else
									{
										$data_order = 7;
										$data_status = '<span class="label label-default">Incomplete Expired</span>';
									}

									$total_amount = 0;
									$items_datas = $subscription_list['items']['data'];

									$total_amount = $subscription_list['invoice']['data'][0]['total'];


									$interval = '';
									$currency = 'usd';

									


									// echo "<pre>";print_r($items_datas);echo "</pre>";
									if(!empty($items_datas))
									{
										foreach($items_datas as $items_data)
										{
											$stl_price_val = 0;
											$stl_qty = (isset($items_data['quantity']))?$items_data['quantity']:0;
											$amount = (isset($items_data['plan']['amount']))?$items_data['plan']['amount']:0;
											$interval = (isset($items_data['plan']['interval']))?$items_data['plan']['interval']:0;
											$currency = (isset($items_data['plan']['currency']))?$items_data['plan']['currency']:'usd';

											$currency_sympol = WSSM_CURRENCY[$currency];
											break;
											
											$usage_type = $items_data['plan']['usage_type'];
											$billing_scheme = $items_data['plan']['billing_scheme'];
											$tiers_mode = $items_data['plan']['tiers_mode'];
											$tiers = $items_data['plan']['tiers'];
											$transform_usage = $items_data['plan']['transform_usage'];
											if($usage_type == 'metered')
											{
												// $amount = $items_data['amount'];
												$stl_price_val = (float)$amount;
											}
											else
											{
												if($billing_scheme == 'tiered')
												{
													$flat_amount = $unit_amount = $up_to = 0;
													if($tiers_mode == 'volume')
													{
														foreach($tiers as $key=>$value)
														{
															$flat_amount = $value['flat_amount'];
															$unit_amount = $value['unit_amount'];
															$up_to = $value['up_to'];
															if ($stl_qty <= $up_to || $up_to == '') {
															    //return false;
															    break;
															}
														}
														
														$stl_price_val = ($unit_amount * $stl_qty)+$flat_amount;
													}
													else
													{
														$remaing_qty = $stl_qty;
														$graduated_total = $from_val = 0;

														foreach($tiers as $key=>$value)
														{
															// console.log("remaing_qty = "+remaing_qty);
															if($remaing_qty > 0)
															{
																$flat_amount = $value['flat_amount'];
																$unit_amount = $value['unit_amount'];
																$up_to = $value['up_to'];
																$remaing_qty = $stl_qty - $from_val;
																if($remaing_qty > 0)
																{
																	if ($up_to != '' ) 
																	{
																		$between_val = $up_to - $from_val;
																		
																		
																		if($remaing_qty >= $between_val)
																		{
																			
																			$graduated_total += ($between_val*$unit_amount)+$flat_amount;
																		}
																		else
																		{
																			
																			$graduated_total += ($remaing_qty*$unit_amount)+$flat_amount;
																		}
																		
																	    
																	}
																	else
																	{
																		$graduated_total += ($remaing_qty*$unit_amount)+$flat_amount;
																	}
																	$from_val = $up_to;
																	
																}
															}
															else
															{
																break;
															}
															
														}
														$stl_price_val = $graduated_total;
													}
												}

												else if($billing_scheme == 'per_unit' && $transform_usage == '')
												{
													$stl_price_val = $amount * $stl_qty;
												}
												else if($billing_scheme == 'per_unit' && $transform_usage != '')
												{
													$divide_by = $transform_usage['divide_by'];
													$round = $transform_usage['round'];
													$remaing_val = $stl_qty/$divide_by;
													if($round == 'up')
													{
														$remaing_val = ceil($remaing_val);
													}
													else
													{
														$remaing_val = floor($remaing_val);
													}
													$stl_price_val = $amount * $remaing_val;
														
												}
												else
												{
													$stl_price_val = $amount * $stl_qty;
												}
											}

											$total_amount += $stl_price_val;
										}
									}

									$total_amount = $total_amount/100;
									$total_amount = number_format($total_amount,2);


									$i++;
									echo "<tr data-id='".$subscription_list['id']."' data-cusid='".$subscription_list['customer']."' data-cmthod='".$subscription_list['collection_method']."' >
											<td>".$currency_sympol." ".$total_amount."/".$interval."</td>
											<td class='td_application'>".$application."</td>
											<td class='td_customer'>".$customer."</td>
											<td>".date('Y-m-d',$subscription_list['current_period_end'])."</td>
											<td>".date('Y-m-d',$subscription_list['created'])."</td>
											<td title='".$subscription_list['id']."'>".$subscription_list['plan']['nickname']."</td>
											<td data-order='".$data_order."' data-search='".$subscription_status."'>".$data_status."</td>
											<td>".$collectiont_txt."</td>
											<td>";
											
											if($subscription_status != 'canceled' )
											{
												echo "<button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_cancelsub'>".__('Unsubscribe','wp_stripe_management')."</button>";

												echo "&nbsp; &nbsp; <button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_changepaymode'>".__('Set Autopay','wp_stripe_management')."</button>";

												/*if($collection_method == 'charge_automatically')
												{
													echo "&nbsp; &nbsp; <button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_changepaymode btn_paymanual1'>".__('Set Manual Pay','wp_stripe_management')."</button>";
												}
												else
												{
													echo "&nbsp; &nbsp; <button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_changepaymode btn_payauto1'>".__('Set Autopay','wp_stripe_management')."</button>";
												}*/
											}

											if($subscription_status == 'active' || $subscription_status == 'trialing')
											{
												echo "&nbsp; &nbsp; <button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_viewnxtinvoice'>".__('Next invoice','wp_stripe_management')."</button>";
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
				?>
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
	        	<h5 class="stl-modal-title"><?php _e( 'Next invoice', 'wp_stripe_management' ); ?></h5>
	      	</div>
	      	<div class="stl-modal-body">
	      	</div>
	    </div>
	</div>
</div>


<div id="paymode_modal" class="stl-modal">
	 <div class="stl-modal-dialog stl-modal-lg">
	 	<div class="stl_ajaxloader">
  			<img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" />
		</div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<h5 class="stl-modal-title"><?php _e( 'Set Autopay', 'wp_stripe_management' ); ?></h5>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-col-md-12">
	      			<input type="hidden" class="subscription_id" name="subscription_id">
	      			<input type="hidden" class="default_collection" name="default_collection">
	      			<label><?= _e('How would you like funds to be collected?','wp_stripe_management'); ?></label>
	      			<div class="stl-row">
	      				<br>
	      				<div class="stl-col-md-6">
	      					<label>
	      						<input type="radio" name="collection_method" class="collection_method" value="send_invoice">
	      						<?= _e('Send invoice (manual payment)','wp_stripe_management'); ?>
	      					</label>
	      				</div>
	      				<div class="stl-col-md-6">
	      					<label>
	      						<input type="radio" name="collection_method" class="collection_method" value="charge_automatically">
	      						<?= _e('Pay automatically','wp_stripe_management'); ?>
	      					</label>
	      				</div>
	      				<br>
	      				<div class="stl-col-md-12 stl_manualpay">
									<label class="stl-col-md-2">Payment due</label>
									<div class="stl-col-md-2">
										<input type="number" name="payment_due_date" class="stl-form-control payment_due_date" value="" placeholder="days" autocomplete="off">
										
									</div>
									<span class="stl-col-md-4">days after invoice is sent</span>
									<span id="payment_due_date-error" class="stl-col-md-12 stl-help-block stl-help-block-error">Please enter the payment due date value</span>
								</div>
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






<script type="application/javascript">

var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
jQuery(document).ready(function(){

	jQuery(document).on('click','.btn_changepaymode',function(){
		var sub_id = jQuery(this).closest('tr').data('id');
		var default_collection = jQuery(this).closest('tr').data('cmthod');
		jQuery(".subscription_id").val(sub_id);
		jQuery(".default_collection").val(default_collection);
		jQuery("#paymode_modal").show();
	});

	jQuery(document).on('click','.collection_method',function(){
		var collection_method = jQuery(".collection_method:checked").val();
		if(collection_method == 'send_invoice')
		{
			jQuery(".stl_manualpay").show();
		}
		else
		{
			jQuery(".stl_manualpay").hide();
		}
	});

	jQuery(document).on('click','.btn_savecmethod',function(){
		jQuery("#payment_due_date-error").hide();
		var subscription_id = jQuery(".subscription_id").val();
		var default_collection = jQuery(".default_collection").val();
		var payment_due_date = jQuery(".payment_due_date").val()
		var collection_method = jQuery(".collection_method:checked").val();
		if(collection_method == 'send_invoice' && payment_due_date == '')
		{
			jQuery("#payment_due_date-error").show();
		}
		else
		{
			var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subscription_id,'payment_type':collection_method,'pay_duedays' : payment_due_date, 'action' :'UpdateSubPaymenttype'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					//console.log(response);
					if(response['stl_status'])
					{
						toastr.options = {"closeButton": true,}
						toastr.success("<?= _e('Subscription collection type changed successfully','wp_stripe_management'); ?>", "<?= _e('Success','wp_stripe_management'); ?>");
						setTimeout(function(){
							location.reload();
							 }, 800);
					}
					else
					{
						toastr.error(response['message'], "<?= _e('Error','wp_stripe_management'); ?>");
					}
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				}
			});
		}

	})


	jQuery(document).on('click','.btn_viewnxtinvoice',function(){
		// jQuery('#edit_cardform').find("input[type=text], textarea").val("");
    	var subid = jQuery(this).closest('tr').data('id');
    	var customerid = jQuery(this).closest('tr').data('cusid');
    	var td_application = jQuery(this).closest('tr').find('.td_application').html();
    	var td_customer = jQuery(this).closest('tr').find('.td_customer').html();

    	var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	    jQuery.ajax({
	      url : stl_ajaxurl,
	      dataType : 'json',
	      type:'post',
	      data : {'subscription_id': subid,'customerid':customerid,'stltype':'arr',action:'getNextInvoiceDetails'},
	      beforeSend: function() {
	        jQuery('.stl_ajaxloader').css("visibility", "visible");
	      },
	      success : function( response ) {        
	        // response = $.parseJSON(response);       
	        if(response['stl_status']){ 
	        	var currency = response['currency']; 
	          var invoice_lineitems = response['lines']['data'];
	          var period_start = response['period_start'];
	          var period_end = response['period_end'];
	          var subtotal = response['subtotal'];
	          var discount = response['discount'];
	          var tax = response['tax'];
	          var tax_percent = response['tax_percent'];
	          var total = response['total'];
	          var amount_due = response['amount_due'];
	          period_start = new Date(period_start*1000);
	          period_end = new Date(period_end*1000);
	          var start_date = period_start.getDate();
	          var start_month = monthNames[period_start.getMonth()];
	          var start_year = period_start.getFullYear();
	          var end_date = period_end.getDate();
	          var end_month = monthNames[period_start.getMonth()];
	          var end_year = period_end.getFullYear();

	          var final_start_date = start_date+" "+start_month+","+start_year;
	          var final_end_date = end_date+" "+end_month+","+end_year;

	          var discount_tr = '';
	          var tax_tr = '';
	          if(discount !='')
	          {
	          	var discount_coupon = discount['coupon'];
	          	var coupon_name = discount_coupon['name'];
	          	var amount_off = discount_coupon['amount_off'];
	          	var percent_off = discount_coupon['percent_off'];
	          	if(amount_off !='')
	          	{
	          		amount_off = parseFloat(amount_off)/100;
	          		amount_off = amount_off.toFixed(2);
	          		discount_tr += '<tr><td colspan="5">'+coupon_name+'</td><td>-'+currency+' '+amount_off+'</td></tr>';
	          	}
	          	else
	          	{
	          		discount_tr += '<tr><td colspan="5">'+coupon_name+'</td><td>'+percent_off+'%</td></tr>';
	          	}
	          	
	          }
	          if(tax_percent !='')
	          {
	          	tax = parseFloat(tax)/100;
	          	tax = tax.toFixed(2);
	          	tax_tr += '<tr><td colspan="5">Tax ('+tax_percent+'%)</td><td>'+currency+' '+tax+'</td></tr>';
	          }

	          // console.log("period_start = "+period_start);
	          // console.log("period_end = "+period_end);

	          //var fromDate = new Date(period_start*1000);
                           // var date = new Date(period_start).toDateString("dd/mm/yyyy");

                   // console.log("fromDate = "+period_start);  
                   // console.log("date = "+date); 

                   // console.log("The current month is " + monthNames[period_start.getMonth()]);



                   // console.log(fromDate.getDate() );
                   // console.log(fromDate.getMonth() );
                   // console.log(fromDate.getFullYear() );



	          // period_start = Date.parse(period_start);
	          // period_end = Date.parse(period_end);
	          subtotal = parseFloat(subtotal)/100;
	          subtotal = subtotal.toFixed(2);
	          total = parseFloat(total)/100;
	          total = total.toFixed(2);
	          amount_due = parseFloat(amount_due)/100;
	          amount_due = amount_due.toFixed(2);

	          var modal_content="<div class='stl-col-md-12'><p>"+final_start_date+" - "+final_end_date;
	          if(invoice_lineitems)
	          {
	          	modal_content += "<table class='stl-table stl_nxtinvoice'><thead><tr><th>Plan</th><th>Application</th><th>Customer</th><th>Qty</th><th>Unit price(USD $)</th><th>Amount (USD $)</th></tr></thead><tbody>";
	          	jQuery.each(invoice_lineitems ,function(key,invoice_lineitem)
	          	{
	          		var nickname = invoice_lineitem['plan']['nickname'];
	          		var quantity = invoice_lineitem['quantity'];
	          		var amount = invoice_lineitem['amount'];
	          		var per_unit_price = invoice_lineitem['plan']['amount'];
	          		// var application = '';
	          		// var customer = '';
	          		per_unit_price = parseFloat(per_unit_price)/100;
	          		per_unit_price = per_unit_price.toFixed(2);
	          		amount = parseFloat(amount)/100;
	          		amount = amount.toFixed(2);

	          		modal_content += "<tr><td>"+nickname+"</td><td>"+td_application+"</td><td>"+td_customer+"</td><td>"+quantity+"</td><td class='stl_tdprice'>"+currency+" "+per_unit_price+"</td><td class='stl_tdprice'>"+currency+" "+amount+"</td></tr>";

	          	});
	          	modal_content += '</tbody><tfoot><tr><td colspan="5">Subtotal:</td><td>'+currency+" "+subtotal+'</td></tr>'+discount_tr+tax_tr+'<tr><td colspan="5">Total:</td><td>'+currency+" "+total+'</td></tr><tr><td colspan="5">Amount Due:</td><td>'+currency+" "+amount_due+'</td></tr></tfoot></table>';
	          }
	          modal_content += '</div>';
	          jQuery("#view_nextinvoice_modal .stl-modal-body").html(modal_content);
	          jQuery("#view_nextinvoice_modal").show();
	        }else{
	          toastr.error(response['message'], "<?= _e('Error','wp_stripe_management'); ?>");
	        }
	        
	        jQuery('.stl_ajaxloader').css("visibility", "hidden");
	      }
	    });
		
	})

	var table = jQuery('#subscription_tb').DataTable({ 
    	paging: true,
    	"pageLength": 10,
     	"lengthMenu": [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "All"]],
      	//"ordering": false,
       	"order": [[ 6, "asc" ]],
      	//"oSearch": {"sSearch": 'open' }
    });

    jQuery("#subscription_tb thead th").each( function ( i ) {
        if(i==6)
        {
        	var this_html = jQuery(this).html();
        	var select = jQuery('<select class="invoice_dataselect"><option value="">'+this_html+'</option></select>')
            .appendTo( jQuery(this).empty() )
            .on( 'change', function () {
              // console.log("changeeeeeeee = "+$(this).val());
                table.column( i )
                    .search( jQuery(this).val() )
                    .draw();
            } );

            select.append( '<option value="active">Active</option>' );
            select.append( '<option value="trialing">Trialing</option>' );
            select.append( '<option value="past_due">Past due</option>' );
            select.append( '<option value="unpaid">Unpaid</option>' );
            select.append( '<option value="canceled">Canceled</option>' );
            select.append( '<option value="incomplete">Incomplete</option>' );
            select.append( '<option value="incomplete_expired">Incomplete expired</option>' );
 
        	// table.column( i ).data().unique().sort().each( function ( d, j ) {
         //    	select.append( '<option value="'+d+'">'+d+'</option>' )
        	// });
      	}
    });


	jQuery(document).on('click','.btn_cancelsub',function(){
		var subid = jQuery(this).closest('tr').data('id');


		swal({
		  title: "<?= _e('Unsubscribe','wp_stripe_management'); ?>",
		  text: "<?= _e('Are you sure you wish to cancel your subscription?','wp_stripe_management'); ?>",
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonClass: "stl-btn-default",
		  confirmButtonClass: "stl-btn-default",
		  confirmButtonText: "Unsubscribe",
		  cancelButtonText: "Close",
		  closeOnConfirm: true
		},
		function(){

		    var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subid, 'action' :'CancelSubscription'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					//console.log(response);
					if(response['stl_status'])
					{
						toastr.options = {"closeButton": true,}
						toastr.success("<?= _e('Subscription canceled successfully','wp_stripe_management'); ?>", "<?= _e('Success','wp_stripe_management'); ?>");
						setTimeout(function(){
							location.reload();
							 }, 800);
					}
					else
					{
						toastr.error(response['message'], "<?= _e('Error','wp_stripe_management'); ?>");
					}
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				}
			});
		});
	});

	/*jQuery(document).on('click','.btn_paymanual',function(){
		var subid = jQuery(this).closest('tr').data('id');
		//var btntxt = jQuery(this).closest('tr').data('btntxt');
		//var payment_type = jQuery(this).closest('tr').data('ptype');
		// payment_type = '';
		swal({
		  title: "<?= _e('Set Autopay','wp_stripe_management'); ?>",
		  text: "<?= _e('How would you like funds to be collected?','wp_stripe_management'); ?>",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "stl-btn-default",
		  confirmButtonText: 'Send invoice (manual payment)',
		  closeOnConfirm: false,
		  type: "input",
		  inputPlaceholder: "Payment due days"
		},
		function (inputValue) {
		  if (inputValue === false) return false;
		  if (inputValue === "") {
		    swal.showInputError("You need add the payment due date");
		    return false;
		  }
		// },
		// function(isConfirm) {
			console.log("inputValue = "+inputValue);
			swal.close();
			//return false;
		  //swal("Nice!", "You wrote: " + inputValue, "success");
		    var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subid,'payment_type':'send_invoice','pay_duedays' : inputValue, 'action' :'UpdateSubPaymenttype'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					//console.log(response);
					if(response['stl_status'])
					{
						toastr.options = {"closeButton": true,}
						toastr.success("<?= _e('Subscription collection type changed successfully','wp_stripe_management'); ?>", "<?= _e('Success','wp_stripe_management'); ?>");
						setTimeout(function(){
							location.reload();
							 }, 800);
					}
					else
					{
						toastr.error(response['message'], "<?= _e('Error','wp_stripe_management'); ?>");
					}
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				}
			});
		});
	});
	
	jQuery(document).on('click','.btn_payauto',function(){
		var subid = jQuery(this).closest('tr').data('id');
		//var btntxt = jQuery(this).closest('tr').data('btntxt');
		//var payment_type = jQuery(this).closest('tr').data('ptype');
		// payment_type = '';
		swal({
		  title: "<?= _e('Set Autopay','wp_stripe_management'); ?>",
		  text: "<?= _e('How would you like funds to be collected?','wp_stripe_management'); ?>",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: 'Pay automatically',
		  closeOnConfirm: true,
		},
		function(isConfirm) {
		  //swal("Nice!", "You wrote: " + inputValue, "success");
		    var stl_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subid,'payment_type':'charge_automatically', 'action' :'UpdateSubPaymenttype'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					//console.log(response);
					if(response['stl_status'])
					{
						toastr.options = {"closeButton": true,}
						toastr.success("<?= _e('Subscription collection type changed successfully','wp_stripe_management'); ?>", "<?= _e('Success','wp_stripe_management'); ?>");
						setTimeout(function(){
							location.reload();
							 }, 800);
					}
					else
					{
						toastr.error(response['message'], "<?= _e('Error','wp_stripe_management'); ?>");
					}
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				}
			});
		});
	});*/

	

});



</script>

<?php get_footer(); ?>