<div class="stl-row">
	<?php
	$page_additional_users = get_option('wssm_stripe_page_additionalusers','');
	?>
	<input type="hidden" class="stl_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
	<input type="hidden" class="stl_aduserurl" value="<?php echo $page_additional_users; ?>">
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>

			<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php');
			include_once(WPSTRIPESM_DIR.'templates/sidebar.php');
			 ?>
			<div class="stl-col-md-12">
				<p class="stl_htitle"><?= _e('User list','wp_stripe_management'); ?> &nbsp;&nbsp;<button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_adduser"><?= _e('Add User','wp_stripe_management'); ?></button></p>
				<table class="stl-table" id="addinuser_tb">
					<thead>
						<tr>
							<th><?= _e('S.no','wp_stripe_management'); ?></th> 
							<th><?= _e('Name','wp_stripe_management'); ?></th>
							<th><?= _e('Email','wp_stripe_management'); ?></th>
							<th><?= _e('Phone','wp_stripe_management'); ?></th>
							<th><?= _e('Status','wp_stripe_management'); ?></th>
							<th><?= _e('Action','wp_stripe_management'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$count = 0;
							if(!empty($active_user_lists)){
								// echo "<pre>";print_r($active_user_lists);echo "</pre>";
								foreach($active_user_lists as $active_user_list)
								{
									$phone = get_user_meta($active_user_list->ID,'phone_number',true);
									$count++;
									?>
									<tr data-id='<?=$active_user_list->ID;?>' data-type="active_user">
										<td><?=$count;?></td>
										<td><?=$active_user_list->display_name;?></td>
										<td><?=$active_user_list->user_email;?></td>
										<td><?=$phone;?></td>
										<td><span class="stl-label stl-label-success"><?=_e('Verified','wp_stripe_management');?></span></td>
										<td>
											<div class="stl-dropdown">
											    <button class="stl-btn stl-btn-sm stl-btn-default stl-dropdown-toggle" type="button" data-toggle="dropdown"><?= _e('Action','wp_stripe_management'); ?><span class="caret"></span></button>
											    <ul class="stl-dropdown-menu">
											    	<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_delete_user'><?= _e('Delete','wp_stripe_management'); ?></button></li>
											    </ul>
											</div>
											<!-- <button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_edituser"><?=_e('Edit','wp_stripe_management');?></button> -->
										</td>
									</tr>
									<?php
								}
							}
							if(!empty($inactive_user_lists)){
								// echo "<pre>";print_r($inactive_user_lists);echo "</pre>";
								foreach($inactive_user_lists as $inactive_user_list)
								{
									$count++;
									?>
									<tr data-id="<?=$inactive_user_list->suser_id;?>" data-actcode="<?=$inactive_user_list->activation_code;?>" data-type="inactive_user">
										<td><?=$count;?></td>
										<td><?=$inactive_user_list->full_name;?></td>
										<td><?=$inactive_user_list->user_oldemail;?></td>
										<td><?=$inactive_user_list->phone_number;?></td>
										<td><span class="stl-label stl-label-danger"><?=_e('Waiting for email verification','wp_stripe_management');?></span></td>
										<td>
											<div class="stl-dropdown">
											    <button class="stl-btn stl-btn-sm stl-btn-default stl-dropdown-toggle" type="button" data-toggle="dropdown"><?= _e('Action','wp_stripe_management'); ?><span class="caret"></span></button>
											    <ul class="stl-dropdown-menu">
											    	<li>
											    		<button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_delete_user'><?= _e('Delete','wp_stripe_management'); ?></button>
											    	</li>
											    	<li>
											    		<button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_resenduseremail'><?= _e('Resend email','wp_stripe_management'); ?></button>
											    	</li>
											    </ul>
											</div>
											<!-- <button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_resenduseremail"><?=_e('Resend email','wp_stripe_management');?></button> -->
										</td>
									</tr>
									<?php
								}
							}
						?>
					</table>

			</div>
		</div>
	</div>
</div>

<div id="additional_user_modal" class="stl-modal">
	 <div class="stl-modal-dialog">
	 	<div class="stl_ajaxloader1">
  			<img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" />
		</div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><b><?php _e( 'User Details', 'wp_stripe_management' ); ?>:</b> <span class="payamount"></span></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-row">
					<form id="additional_user_form" method="post">
						<input type="hidden" name="action" value="saveAdditionalUser">
						<input type="hidden" name="parent_userid" value="<?= $parent_userid; ?>">
						<input type="hidden" name="additiona_user_id" class="additiona_user_id" value="">

					   	<div class="stl-col-md-12">
					   		<div class="stl-col-md-12">
						   		<div class="stl-form-group">
									<label><?= _e('Name','wp_stripe_management'); ?></label>
									<input type="text" name="full_name" class="stl-form-control full_name" value="" autofocus>
								</div>
						   	</div>
						   	<div class="stl-col-md-12">
						   		<div class="stl-form-group">
									<label><?= _e('Email','wp_stripe_management'); ?></label>
									<input type="text" name="email" class="stl-form-control email" value="">
								</div>
						   	</div>
						   	<div class="stl-col-md-12">
						   		<div class="stl-form-group">
									<label><?= _e('Phone','wp_stripe_management'); ?></label>
									<input type="text" name="phone_number" class="stl-form-control phone_number" value="">
								</div>
						   	</div>
						   	<div class="stl-col-md-12">
						   		<div class="stl-form-group">
									<label><?= _e('Password','wp_stripe_management'); ?></label>
									<input type="password" name="password" class="stl-form-control password" id="mainpassword" value="">
								</div>
						   	</div>
						   	<div class="stl-col-md-12">
						   		<div class="stl-form-group">
									<label><?= _e('Confirm Password','wp_stripe_management'); ?></label>
									<input type="password" name="confirm_password" class="stl-form-control confirm_password" id="confirm_password" value="">
								</div>
						   	</div>

					   	</div>
				         <div class="stl-col-md-12 stl-text-right">
				          	<button type="button" class="stl-btn stl-btn-default btn_modalcancel"><?php _e('Cancel','wp_stripe_management'); ?></button>
				          	<button type="submit" name="savee" class="stl-btn stl-btn-success btn_saveuser"><?php _e('Save','wp_stripe_management'); ?></button>
				        </div>
    				</form>
				</div>
	      	</div>
	    </div>
	</div>
</div>

