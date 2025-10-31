<?php
if($wssm_customer_id !=''){?>
<ul class="wssm_menulist">
	<?php
	$page_actinfo = get_option('wssm_stripe_page_acounttinfo','');
	$page_card = get_option('wssm_stripe_page_card','');
	$page_invoice = get_option('wssm_stripe_page_invoice','');
	$page_sub = get_option('wssm_stripe_page_subscription','');
	$page_addusers = get_option('wssm_stripe_page_additionalusers','');

	?>
	<li class="<?php echo ($active_menu  == 'accountinfo')?'active':''; ?>">
		<a href="<?php echo site_url().'/'.$page_actinfo; ?>"><?php _e( 'Account Info', 'wp_stripe_management' ); ?></a>
	</li>
	<li class="<?php echo ($active_menu  == 'card')?'active':''; ?>">
		<a href="<?php echo site_url().'/'.$page_card; ?>"><?php _e( 'Payment Methods', 'wp_stripe_management' ); ?></a>
	</li>
	<li class="<?php echo ($active_menu  == 'invoice')?'active':''; ?>">
		<a href="<?php echo site_url().'/'.$page_invoice; ?>"><?php _e( 'Invoices', 'wp_stripe_management' ); ?></a>
	</li>
	<li class="<?php echo ($active_menu  == 'subcription')?'active':''; ?>">
		<a href="<?php echo site_url().'/'.$page_sub; ?>"><?php _e( 'Subscriptions', 'wp_stripe_management' ); ?></a>
	</li>
	<li class="<?php echo ($active_menu  == 'additional_users')?'active':''; ?>">
		<a href="<?php echo site_url().'/'.$page_addusers; ?>"><?php _e( 'More Users', 'wp_stripe_management' ); ?></a>
	</li>

	
</ul>
<?php } ?>