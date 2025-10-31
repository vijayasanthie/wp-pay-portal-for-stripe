<div class="stl_preloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>
<input type="hidden" class="stl_admin_ajaxjs" value="<?php echo admin_url('admin-ajax.php'); ?>">
<input type="hidden" class="stl_admin_urlredirect" value="<?php echo site_url()."/".get_option('wssm_mail_urlredirect',''); ?>">

<input type="hidden" class="utils_jsfile" value="<?php echo UTILS_JS; ?>">
<input type="hidden" class="cdefault_currency" value="<?php echo $cdefault_currency; ?>">
<input type="hidden" class="cdefault_currency_symbol" value="<?php echo $cdefault_currency_symbol; ?>">


<!-- jquery validate message -->
<input type="hidden" class="stl_errormsg_cmpname" value="<?= _e('Please enter the company name','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_email" value="<?= _e('Please enter the emailid','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_streetadr" value="<?= _e('Please enter the street address line1','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_city" value="<?= _e('Please enter the city','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_state" value="<?= _e('Please Enter the state','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_postalcode" value="<?= _e('Please Enter the postal code','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_country" value="<?= _e('Please Enter the country name','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_couponcode" value="<?= _e('Please enter the coupon code','wp_stripe_management'); ?>">

<input type="hidden" class="stl_errormsg_chname" value="<?= _e('Please enter the card holder name','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_cardno" value="<?= _e('Please enter the card number','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_emonth" value="<?= _e('Please enter the card expire month','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_eyear" value="<?= _e('Please enter the card expire year','wp_stripe_management'); ?>">
<input type="hidden" class="stl_errormsg_cvv" value="<?= _e('Please enter the CCV','wp_stripe_management'); ?>">



<!-- toaster message -->
<input type="hidden" class="stl_sucsmsg_auctinfo" value="<?= _e('Account information saved successfully','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_success" value="<?= _e('Success','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_error" value="<?= _e('Error','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_couponsave" value="<?= _e('Coupon code saved successfully','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_carddelt" value="<?= _e('Card details deleted successfully','wp_stripe_management'); ?>">

<input type="hidden" class="stl_sucsmsg_cardsave" value="<?= _e('Card details saved successfully','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_invsuc" value="<?= _e('Invoice amount paid successfully','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_subcolsave" value="<?= _e('Subscription collection type changed successfully','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_subreactsuc" value="<?= _e('Subscription reactivated successfully','wp_stripe_management'); ?>">
<input type="hidden" class="stl_sucsmsg_coupaplysuc" value="<?= _e('Coupon code applied successfully','wp_stripe_management'); ?>">


<!-- sweet alert message --->
<input type="hidden" class="stl_swt_dtcardinfo" value="<?= _e('Delete Card info','wp_stripe_management'); ?>">

<input type="hidden" class="stl_swt_dtcardcnf" value="<?= _e('Are you sure you wish to delete card','wp_stripe_management'); ?>">
<input type="hidden" class="stl_swt_unsub" value="<?= _e('Unsubscribe','wp_stripe_management'); ?>">
<input type="hidden" class="stl_swt_unsubinfo" value="<?= _e('Are you sure you wish to cancel your subscription?','wp_stripe_management'); ?>">
<input type="hidden" class="stl_swt_reactive" value="<?= _e('Re-active','wp_stripe_management'); ?>">
<input type="hidden" class="stl_swt_reactiveinfo" value="<?= _e('Are you sure you wish to reactive this subscription?','wp_stripe_management'); ?>">
<input type="hidden" class="stl_swt_dtcardinfo" value="<?= _e('Delete Card info','wp_stripe_management'); ?>">
<input type="hidden" class="stl_swt_dtcardinfo" value="<?= _e('Delete Card info','wp_stripe_management'); ?>">


<!-- login messages -->
<input type="hidden" class="stl_lg_email" value="<?= _e('Enter your email address','wp_stripe_management'); ?>">
<input type="hidden" class="stl_lg_password" value="<?= _e('Enter your password','wp_stripe_management'); ?>">
<input type="hidden" class="stl_lg_fname" value="<?= _e('Enter your full name','wp_stripe_management'); ?>">
<input type="hidden" class="stl_lg_cnpassword" value="<?= _e('Enter confirm password','wp_stripe_management'); ?>">
<input type="hidden" class="stl_lg_password" value="<?= _e('Enter your password','wp_stripe_management'); ?>">
<input type="hidden" class="stl_lg_password" value="<?= _e('Enter your password','wp_stripe_management'); ?>">
<input type="hidden" class="stl_lg_emailexit" value="<?= _e('Email already in use!','wp_stripe_management'); ?>">
<input type="hidden" class="stl_lg_unameexit" value="<?= _e('Username already in use!','wp_stripe_management'); ?>">





