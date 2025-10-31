<?php
$logreg_url = get_option('wssm_mail_urlredirect','');
$actcode = (isset($_GET['wssm_activationcode']))?$_GET['wssm_activationcode']:'';
?>
<div class="stl-row">
	<!-- <input type="hidden" class="suser_id" value="<?= $suser_id; ?>"> -->
	<input type="hidden" class="actcode" value="<?= $actcode; ?>">
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
		<input type="hidden" class="logreg_url" value="<?php echo site_url().'/'.$logreg_url."/?wssm_activationcode=".$actcode; ?>">
		<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php'); ?>
		<div class="stl-col-md-12">
			<?php echo $message; 
			// echo "error_status = ".$error_status;
			if($error_status == '1')
			{
				?>
			<p><?= _e('A verification email has been sent to','wp_stripe_management'); ?> <b><?php echo $new_email; ?></b>.</p>

			<p><?= _e('Click on the email link provided to verify your email address.','wp_stripe_management'); ?> </p>

			<p><?= _e('If you did not receive it,','wp_stripe_management'); ?> <a href="javascript:void(0);" class="btn_actmailresend"><?= _e('Click Here','wp_stripe_management'); ?></a> <?= _e('to resend.','wp_stripe_management'); ?></p>
			<?php } ?>
		</div>
	</div>
</div>
