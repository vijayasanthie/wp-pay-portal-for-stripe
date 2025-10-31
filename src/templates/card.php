<div class="stl-row">
	<input type="hidden" class="stl_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
		
			<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php'); ?>
			<?php include_once(WPSTRIPESM_DIR.'templates/sidebar.php'); ?>

			<div class="stl-col-md-12">
				<p class="stl_htitle"><?= _e('Payment Methods','wp_stripe_management'); ?> &nbsp;&nbsp;<button type="button" class="stl-btn stl-btn-default stl-btn-sm btn_addcard"><?= _e('New','wp_stripe_management'); ?></button></p>
				<?php
					// echo "<pre>";print_r($cardlists);echo "</pre>";
					// if($cardlists['stl_status'])
					// {
						// $card_lists = $cardlists['card_lists'];
						if(!empty($cardlists)){
						?>
						<table class="stl-table stlcard_table">
							<thead>
								<tr>
									
									<th style=""><?= _e('Brand','wp_stripe_management'); ?></th>
									<th style="width:10%;text-align: right;"><?= _e('Card Number','wp_stripe_management'); ?></th>
									<th style="text-align: center;"><?= _e('Expires On','wp_stripe_management'); ?></th>
									<th style=""><?= _e('Action','wp_stripe_management'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=0;
								foreach($cardlists as $card_list)
								{
									$i++;
									if($card_list['brand'] == 'Visa'){
										$brand_img = 'visa.png';
									}
									else if($card_list['brand'] == 'MasterCard'){
										$brand_img = 'master.png';
									}
									else if($card_list['brand'] == 'Diners Club'){
										$brand_img = 'diners_club.png';
									}
									else if($card_list['brand'] == 'Discover'){
										$brand_img = 'discover.png';
									}
									else if($card_list['brand'] == 'UnionPay'){
										$brand_img = 'unionPay.png';
									}
									else if($card_list['brand'] == 'JCB'){
										$brand_img = 'jcb.png';
									}
									else if($card_list['brand'] == 'American Express'){
										$brand_img = 'amex.png';
									}
									else{
										$brand_img = $card_list['brand'];
									}
									echo "<tr data-id='".$card_list['id']."' data-cusid='".$card_list['customer']."'>
											<td><img src='".IMAGE_PATH.$brand_img."' width='40'></td>
											<td class='stlcard_no' style='text-align: right;'>•••• ".$card_list['last4']."</td>
											<td style='text-align:center;'>".$card_list['exp_month']." / ".$card_list['exp_year']."</td>
											<td>
												<button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_deletecardinfo'>".__('Delete','wp_stripe_management')."</button>
												<button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_editcardinfo'>".__('Edit','wp_stripe_management')."</button>
												
											</td>
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


<div id="edit_card_modal" class="stl-modal">
	 <div class="stl-modal-dialog">
	 	<div class="stl_ajaxloader1">
  			<img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" />
		</div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><?php _e( 'Edit Card', 'wp_stripe_management' ); ?></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-row">
					<form id="edit_cardform" method="post">
						<input type="hidden" name="action" value="SaveCardInfo">
						<input type="hidden" name="card_id" class="card_id" value="">
						<input type="hidden" name="customer_id" class="customer_id" value="">
					   	<div class="stl-col-md-12">
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Name on card','wp_stripe_management'); ?></label>
									<input type="text" name="holder_name" class="stl-form-control holder_name" maxlength="100" value="" autofocus>
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Card number','wp_stripe_management'); ?></label>
									<input type="text" name="card_no" class="stl-form-control card_no" value="" readonly>
								</div>
					   		</div>
					   		
					   		<div class="stl-col-md-3">
					   			<div class="stl-form-group">
									<label><?= _e('Expires Month','wp_stripe_management'); ?></label>
									<input type="number" name="expire_month" class="stl-form-control expire_month" value="" onKeyPress="if(this.value.length==2) return false;">
								</div>
					   		</div>
					   		<div class="stl-col-md-3">
					   			<div class="stl-form-group">
									<label><?= _e('Expires Year','wp_stripe_management'); ?></label>
									<input type="number" name="expire_year" class="stl-form-control expire_year" value="" onKeyPress="if(this.value.length==4) return false;">
								</div>
					   		</div>
					   		<!-- <div class="stl-col-md-4">	

					   			<div class="stl-form-group">
									<label><?= _e('CCV','wp_stripe_management'); ?></label>
									<input type="text" name="ccv" class="stl-form-control ccv" value="" readonly>
								</div>
					   		</div> -->
					   		<div class="stl-col-md-12">	

					   			<div class="stl-form-group">
									<label><?= _e('Street Address 1','wp_stripe_management'); ?></label>
									<input type="text" name="address_line1" class="stl-form-control address_line1" maxlength="95" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Street Address 2','wp_stripe_management'); ?></label>
									<input type="text" name="address_line2" class="stl-form-control address_line2" maxlength="95" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('City','wp_stripe_management'); ?></label>
									<input type="text" name="city" class="stl-form-control city" maxlength="95" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('State/Province','wp_stripe_management'); ?></label>
									<input type="text" name="state" class="stl-form-control state" maxlength="95" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6" style="clear: both;">
					   			<div class="stl-form-group">
									<label><?= _e('Zip/Postcode','wp_stripe_management'); ?></label>
									<input type="text" name="postal_code" class="stl-form-control postal_code" maxlength="10" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Country','wp_stripe_management'); ?></label>
									<!-- <input type="text" name="country" class="stl-form-control country" value=""> -->

									<?php
									$country_data = WSSM_COUNTRY;
										
										echo '<select name="country" class="stl-form-control country">';
											foreach($country_data as $key => $value)
											{
												echo "<option value='".$key."'>".$value."</option>";
											}
										echo '</select>';
										?>

								</div>
					   		</div>
					   	</div>
				         <div class="stl-col-md-12 stl-text-right">
				          	<button type="button" class="stl-btn stl-btn-default btn_modalcancel"><?php _e('Cancel','wp_stripe_management'); ?></button>
				          	<button type="submit" name="savee" class="stl-btn stl-btn-success btn_saveainfo"><?php _e('Save Changes','wp_stripe_management'); ?></button>
				        </div>
    				</form>
				</div>
	      	</div>
	    </div>
	</div>
</div>

<div id="add_card_modal" class="stl-modal">
	 <div class="stl-modal-dialog">
	 	<div class="stl_ajaxloader">
  			<img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" />
		</div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><?php _e( 'Add Card', 'wp_stripe_management' ); ?></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-row">
					<form id="add_cardform" method="post">
						<input type="hidden" name="action" value="AddCardInfo">
						<input type="hidden" name="customer_id" class="customer_id" value="">
					   	<div class="stl-col-md-12">
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Name on card','wp_stripe_management'); ?></label>
									<input type="text" name="holder_name" class="stl-form-control" maxlength="100" value="" autofocus>
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Card number','wp_stripe_management'); ?></label>
									<input type="text" name="card_no" class="stl-form-control" value="" >
								</div>
					   		</div>
					   		
					   		<div class="stl-col-md-2">
					   			<div class="stl-form-group">
									<label><?= _e('Exp.month','wp_stripe_management'); ?></label>
									<input type="number" name="expire_month" class="stl-form-control" value="" onKeyPress="if(this.value.length==2) return false;">
								</div>
					   		</div>
					   		<div class="stl-col-md-2">
					   			<div class="stl-form-group">
									<label><?= _e('Exp.year','wp_stripe_management'); ?></label>
									<input type="number" name="expire_year" class="stl-form-control" value="" onKeyPress="if(this.value.length==4) return false;">
								</div>
					   		</div>
					   		 <div class="stl-col-md-2">	

					   			<div class="stl-form-group">
									<label><?= _e('CCV','wp_stripe_management'); ?></label>
									<input type="text" name="ccv" class="stl-form-control" value="" onKeyPress="if(this.value.length==4) return false;">
								</div>
					   		</div> 
					   		<div class="stl-col-md-12">	

					   			<div class="stl-form-group">
									<label><?= _e('Street Address 1','wp_stripe_management'); ?></label>
									<input type="text" name="card_address_line1" class="stl-form-control" maxlength="95"  value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-12">
					   			<div class="stl-form-group">
									<label><?= _e('Street Address 2','wp_stripe_management'); ?></label>
									<input type="text" name="card_address_line2" class="stl-form-control" maxlength="95" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('City','wp_stripe_management'); ?></label>
									<input type="text" name="card_city" class="stl-form-control" maxlength="95" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('State/Province','wp_stripe_management'); ?></label>
									<input type="text" name="card_state" class="stl-form-control" maxlength="95" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6" style="clear: both;">
					   			<div class="stl-form-group">
									<label><?= _e('Zip/Postcode','wp_stripe_management'); ?></label>
									<input type="text" name="card_postal_code" class="stl-form-control" maxlength="10" value="">
								</div>
					   		</div>
					   		<div class="stl-col-md-6">
					   			<div class="stl-form-group">
									<label><?= _e('Country','wp_stripe_management'); ?></label>
									<!-- <input type="text" name="country" class="stl-form-control" value=""> -->
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
				         <div class="stl-col-md-12 stl-text-right">
				          	<button type="button" class="stl-btn stl-btn-default btn_modalcancel"><?php _e('Cancel','wp_stripe_management'); ?></button>
				          	<button type="submit" name="savee" class="stl-btn stl-btn-success btn_saveainfo"><?php _e('Save Changes','wp_stripe_management'); ?></button>
				        </div>
    				</form>
				</div>
	      	</div>
	    </div>
	</div>
</div>

<script type="application/javascript">
	jQuery(document).on('click','.btn_editcardinfo',function(){
   jQuery('#edit_cardform').find("input[type=text], textarea").val("");
    var cardid = jQuery(this).closest('tr').data('id');
    var customerid = jQuery(this).closest('tr').data('cusid');
    var stl_ajaxurl = jQuery(".stl_ajaxurl").val();
    jQuery.ajax({
      url : stl_ajaxurl,
      dataType : 'json',
      type:'post',
      data : {'cardid': cardid,'customerid':customerid,'stltype':'arr',action:'getCardDetails'},
      beforeSend: function() {
        jQuery('.stl_ajaxloader').css("visibility", "visible");
        //jQuery(".stlcard_table").hide();
      },
      success : function( response ) {        
        // response = $.parseJSON(response);       
        // if(response['stl_status']){  
          // var carddetails = response['carddetails'];
          console.log(response);
          jQuery("#edit_cardform .card_id").val(response['id']);
          jQuery("#edit_cardform .customer_id").val(response['customer']);
          jQuery("#edit_cardform .holder_name").val(response['name']);
          jQuery("#edit_cardform .card_no").val("**** "+response['last4']);
          jQuery("#edit_cardform .expire_month").val(response['exp_month']);
          jQuery("#edit_cardform .expire_year").val(response['exp_year']);
          jQuery("#edit_cardform .expire_year").val(response['exp_year']);
          // jQuery("#edit_cardform .ccv").val(carddetails['cvc_check']);
          jQuery("#edit_cardform .address_line1").val(response['address_line1']);
          jQuery("#edit_cardform .address_line2").val(response['address_line2']);
          jQuery("#edit_cardform .city").val(response['address_city']);
          jQuery("#edit_cardform .state").val(response['address_state']);

          var address_country = response['address_country'];
          var country_arr = <?php echo json_encode(WSSM_COUNTRY); ?>;
          console.log(country_arr);
          if(address_country !='' && address_country in country_arr)
          {
          	// console.log("iffffffffffffffffffff");
          	jQuery('#edit_cardform .country option[value='+address_country+']').attr('selected','selected');

          }

          // jQuery("#edit_cardform .country").val(country_txt);
          jQuery("#edit_cardform .postal_code").val(response['address_zip']);

          jQuery("#edit_card_modal").show();
          jQuery(".stl-modal").find('[autofocus]').focus();
          // jQuery("#card_detailsview .stl-modal-body").html(carddetails);
        // }else{
        //   alert(response['message']);
        //   // jQuery("#card_detailsview .stl-modal-body").html('No data found');
        // }
        
        jQuery('.stl_ajaxloader').css("visibility", "hidden");
        //jQuery(".stlcard_table").show();
      },
       error:function(xhr, status, error)
       {

            toastr.error( xhr.responseText, 'Error'); //stl ajax error
            jQuery('.stl_ajaxloader').css("visibility", "hidden");
        }
    });
});

</script>