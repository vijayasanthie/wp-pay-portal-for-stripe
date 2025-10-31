<div class="stl-col-md-12 stl-col-sm-12 stl-col-xs-12 sppage">
    <div class="stl-row">
        <p class="sp_title"><?php _e( 'Settings', 'wp_stripe_submang' ); ?></p>
        <div class="stl-container-fluid">
            <div class="stl-row ors-columns-outer">
                <?php
                if(isset($_POST['stlwssm_submit']))
                {
                    $wssm_test_client_id = (isset($_POST['wssm_test_client_id']))?$_POST['wssm_test_client_id']:'';
                    $wssm_test_public_key = (isset($_POST['wssm_test_public_key']))?$_POST['wssm_test_public_key']:'';
                    $wssm_test_secret_key = (isset($_POST['wssm_test_secret_key']))?$_POST['wssm_test_secret_key']:'';
                    $wssm_test_product_id = (isset($_POST['wssm_test_product_id']))?$_POST['wssm_test_product_id']:'';
                    update_option( 'wssm_test_client_id', $wssm_test_client_id );
                    update_option( 'wssm_test_public_key', $wssm_test_public_key );
                    update_option( 'wssm_test_secret_key', $wssm_test_secret_key );
                    update_option( 'wssm_test_product_id', $wssm_test_product_id );

                    $wssm_live_client_id = (isset($_POST['wssm_live_client_id']))?$_POST['wssm_live_client_id']:'';
                    $wssm_live_public_key = (isset($_POST['wssm_live_public_key']))?$_POST['wssm_live_public_key']:'';
                    $wssm_live_secret_key = (isset($_POST['wssm_live_secret_key']))?$_POST['wssm_live_secret_key']:'';
                    $wssm_live_product_id = (isset($_POST['wssm_live_product_id']))?$_POST['wssm_live_product_id']:'';
                    update_option( 'wssm_live_client_id', $wssm_live_client_id );
                    update_option( 'wssm_live_public_key', $wssm_live_public_key );
                    update_option( 'wssm_live_secret_key', $wssm_live_secret_key );
                    update_option( 'wssm_live_product_id', $wssm_live_product_id );

                    $wssm_stripe_mode = (isset($_POST['wssm_stripe_mode']))?$_POST['wssm_stripe_mode']:'test';
                    update_option( 'wssm_stripe_mode', $wssm_stripe_mode );

                    $wssm_stripe_cancel = (isset($_POST['wssm_stripe_cancel']))?$_POST['wssm_stripe_cancel']:'immediately';
                    update_option( 'wssm_stripe_cancel', $wssm_stripe_cancel );

                    $wssm_stripe_cancel_msg = (isset($_POST['wssm_stripe_cancel_msg']))?$_POST['wssm_stripe_cancel_msg']:'immediately';
                    update_option( 'wssm_stripe_cancel_msg', $wssm_stripe_cancel_msg );

                    $wssm_stripe_pay_duedays = (isset($_POST['wssm_stripe_pay_duedays']))?$_POST['wssm_stripe_pay_duedays']:'30';
                    update_option( 'wssm_stripe_pay_duedays', $wssm_stripe_pay_duedays );

                    $page_actinfo = (isset($_POST['page_actinfo']))?$_POST['page_actinfo']:'';
                    $page_card = (isset($_POST['page_card']))?$_POST['page_card']:'';
                    $page_invoice = (isset($_POST['page_invoice']))?$_POST['page_invoice']:'';
                    $page_sub = (isset($_POST['page_sub']))?$_POST['page_sub']:'';
                    $page_addsub = (isset($_POST['page_addsub']))?$_POST['page_addsub']:'';
                    $page_subsuccess = (isset($_POST['page_subsuccess']))?$_POST['page_subsuccess']:'';

                    $page_emailver = (isset($_POST['page_emailver']))?$_POST['page_emailver']:'';
                    $page_logreg = (isset($_POST['page_logreg']))?$_POST['page_logreg']:'';

                    update_option( 'wssm_stripe_page_acounttinfo', $page_actinfo );
                    update_option( 'wssm_stripe_page_card', $page_card );
                    update_option( 'wssm_stripe_page_invoice', $page_invoice );
                    update_option( 'wssm_stripe_page_subscription', $page_sub );
                    update_option( 'wssm_stripe_page_addsubscription', $page_addsub );
                    update_option( 'wssm_stripe_page_subsuccess', $page_subsuccess );

                    update_option( 'wssm_mail_urlredirect', $page_emailver );
                    update_option( 'wssm_logreg_urlredirect', $page_logreg );

                    $loginreg_status = (isset($_POST['loginreg_status']))?$_POST['loginreg_status']:'';
                    $password_status = (isset($_POST['password_status']))?$_POST['password_status']:'';
                    update_option( 'wssm_stripe_loginreg_status', $loginreg_status );
                    update_option( 'wssm_stripe_password_status', $password_status );

                    $additional_users = (isset($_POST['additional_users']))?$_POST['additional_users']:'';
                    update_option( 'wssm_stripe_page_additionalusers', $additional_users );

                    $xeroauth = (isset($_POST['xeroauth']))?$_POST['xeroauth']:'';
                    update_option( 'wssm_stripe_page_xeroauth', $xeroauth );
                    $xerocallback = (isset($_POST['xerocallback']))?$_POST['xerocallback']:'';
                    update_option( 'wssm_stripe_page_xerocallback', $xerocallback );

                    $wssm_invoice_mode = (isset($_POST['wssm_invoice_mode']))?$_POST['wssm_invoice_mode']:'';
                    $wssm_xero_consumer_key = (isset($_POST['wssm_xero_consumer_key']))?$_POST['wssm_xero_consumer_key']:'';
                    $wssm_xero_consumer_secret = (isset($_POST['wssm_xero_consumer_secret']))?$_POST['wssm_xero_consumer_secret']:'';
                    $public_old = (isset($_POST['public_old']))?$_POST['public_old']:'';
                    $private_old = (isset($_POST['private_old']))?$_POST['private_old']:'';
                    update_option( 'wssm_invoice_mode', $wssm_invoice_mode );
                    update_option( 'wssm_xero_consumer_key', $wssm_xero_consumer_key );
                    update_option( 'wssm_xero_consumer_secret', $wssm_xero_consumer_secret );
                    update_option( 'wssm_xero_public_key_file', $public_old );
                    update_option( 'wssm_xero_private_key_file', $private_old );


                    $target_dir = WPSTRIPESM_DIR."libraries/";

                    $public_file_name = basename($_FILES["public_key"]["name"]);
                    $target_public_file = $target_dir . $public_file_name;
                    if(!empty($_FILES["public_key"])){
                        if (move_uploaded_file($_FILES["public_key"]["tmp_name"], $target_public_file)) {
                            update_option( 'wssm_xero_public_key_file', $public_file_name );
                        } 
                    }

                    $private_file_name = basename($_FILES["private_key"]["name"]);
                    $target_private_file = $target_dir . $private_file_name;
                    if(!empty($_FILES["private_key"])){
                        if (move_uploaded_file($_FILES["private_key"]["tmp_name"], $target_private_file)) {
                            update_option( 'wssm_xero_private_key_file', $private_file_name );
                        } 
                    }



                }
                $wssm_test_client_id = get_option('wssm_test_client_id','');
                $wssm_test_public_key = get_option('wssm_test_public_key','');
                $wssm_test_secret_key = get_option('wssm_test_secret_key','');
                $wssm_test_product_id = get_option('wssm_test_product_id','');

                $wssm_live_client_id = get_option('wssm_live_client_id','');
                $wssm_live_public_key = get_option('wssm_live_public_key','');
                $wssm_live_secret_key = get_option('wssm_live_secret_key','');
                $wssm_live_product_id = get_option('wssm_live_product_id','');

                $wssm_stripe_mode = get_option('wssm_stripe_mode','test');
                $wssm_stripe_cancel = get_option('wssm_stripe_cancel','immediately');
                $wssm_stripe_cancel_msg = get_option('wssm_stripe_cancel_msg','Subscription canceled');
                $wssm_stripe_pay_duedays = get_option('wssm_stripe_pay_duedays','30');

                $page_actinfo = get_option('wssm_stripe_page_acounttinfo','');
                $page_card = get_option('wssm_stripe_page_card','');
                $page_invoice = get_option('wssm_stripe_page_invoice','');
                $page_sub = get_option('wssm_stripe_page_subscription','');
                $page_addsub = get_option('wssm_stripe_page_addsubscription','');
                $page_subsuccess = get_option('wssm_stripe_page_subsuccess','');
                $page_logreg = get_option('wssm_logreg_urlredirect','');
                $page_emailver = get_option('wssm_mail_urlredirect','');

                $loginreg_status = get_option('wssm_stripe_loginreg_status','');
                $password_status = get_option('wssm_stripe_password_status','');

                $additional_users = get_option('wssm_stripe_page_additionalusers','');
                $xeroauth = get_option('wssm_stripe_page_xeroauth','');
                $xerocallback = get_option('wssm_stripe_page_xerocallback','');

                $wssm_invoice_mode = get_option('wssm_invoice_mode','');
                $wssm_xero_consumer_key = get_option('wssm_xero_consumer_key','');
                $wssm_xero_consumer_secret = get_option('wssm_xero_consumer_secret','');
                $wssm_xero_public_key_file = get_option('wssm_xero_public_key_file','');
                $wssm_xero_private_key_file = get_option('wssm_xero_private_key_file','');

                $public_file = $private_file = '';
                if($wssm_xero_public_key_file !='')
                {
                    $public_file = "<a href='".WPSTRIPESM_URL."/libraries/".$wssm_xero_public_key_file."'>".$wssm_xero_public_key_file."</a>";
                }
                if($wssm_xero_private_key_file !='')
                {
                    $private_file = "<a href='".WPSTRIPESM_URL."/libraries/".$wssm_xero_private_key_file."'>".$wssm_xero_private_key_file."</a>";
                }
                ?>
                <form action="" class="form-horizontal" method="post" id="stl_save_infdata" enctype="multipart/form-data">
                    <div class="stl-col-md-6">
                        <h4 class="sp_subtitle"><?php _e( 'Stripe Test Information', 'wp_stripe_management' ); ?></h4>
                        
                        <div class="stl-col-md-12 stl-form-group" style="display: none;">
                            <label for="departmentReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Client ID', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_test_client_id" type="text" id="wssm_test_client_id" value="<?php echo $wssm_test_client_id; ?>">
                            </div>
                        </div>
                        
                       
                        <div class="stl-col-md-12 stl-form-group">
                            <label for="jobTitleReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Public Key', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_test_public_key" type="text" id="wssm_test_public_key" value="<?php echo $wssm_test_public_key; ?>">
                            </div>
                        </div>
                        
                        
                        <div class="stl-col-md-12 stl-form-group">
                            <label for="jobTitleReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Secret Key', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_test_secret_key" type="password" id="wssm_test_secret_key" value="<?php echo $wssm_test_secret_key; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="stl-col-md-6">
                        <h4 class="sp_subtitle"><?php _e( 'Stripe Live Information', 'wp_stripe_management' ); ?></h4>
                        <div class="stl-col-md-12 stl-form-group" style="display: none;">
                            <label for="departmentReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Client ID', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_live_client_id" type="text" id="wssm_live_client_id" value="<?php echo $wssm_live_client_id; ?>">
                            </div>
                        </div>

                        <div class="stl-col-md-12 stl-form-group">
                            <label for="jobTitleReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Public Key', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_live_public_key" type="text" id="wssm_live_public_key" value="<?php echo $wssm_live_public_key; ?>">
                            </div>
                        </div>

                        <div class="stl-col-md-12 stl-form-group">
                            <label for="jobTitleReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Secret Key', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_live_secret_key" type="password" id="wssm_live_secret_key" value="<?php echo $wssm_live_secret_key; ?>">
                            </div>
                        </div>
                    </div>
 
                    <div class="stl-col-md-6">
                        <div class="stl-col-md-12 stl-form-group">
                            <label for="jobTitleReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Stripe Mode', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input name="wssm_stripe_mode" id="wssm_stripe_mode_test" type="radio" value="test" <?php echo ($wssm_stripe_mode == 'test')?'checked':''; ?> > <labe for="wssm_stripe_mode_test"><?php _e( 'Test', 'wp_stripe_management' ); ?></labe>
                                <input name="wssm_stripe_mode" id="wssm_stripe_mode_live" type="radio" value="live" <?php echo ($wssm_stripe_mode == 'live')?'checked':''; ?> > <labe for="wssm_stripe_mode_live"><?php _e( 'Live', 'wp_stripe_management' ); ?></labe>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="stl-col-md-12" style="clear: both;">
                        <h4 class="sp_subtitle"><?php _e( 'Invoice Mode', 'wp_stripe_management' ); ?></h4>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="jobTitleReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Invoice Mode', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-9">
                                    <input name="wssm_invoice_mode" id="wssm_invoice_mode_stripe" type="radio" value="stripe" <?php echo ($wssm_invoice_mode == 'stripe')?'checked':''; ?> > <labe for="wssm_invoice_mode_stripe"><?php _e( 'Stripe', 'wp_stripe_management' ); ?></labe>
                                    <input name="wssm_invoice_mode" id="wssm_invoice_mode_xero" type="radio" value="xero" <?php echo ($wssm_invoice_mode == 'xero')?'checked':''; ?> > <labe for="wssm_invoice_mode_xero"><?php _e( 'Xero', 'wp_stripe_management' ); ?></labe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stl-col-md-12" style="clear: both;">
                        <h4 class="sp_subtitle"><?php _e( 'Xero', 'wp_stripe_management' ); ?></h4>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="wssm_xero_consumer_key" class="stl-col-md-3 control-label"><?php _e( 'Consumer Key', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-9">
                                    <input class="stl-form-control" name="wssm_xero_consumer_key" type="text" id="wssm_xero_consumer_key" value="<?php echo $wssm_xero_consumer_key; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="wssm_xero_consumer_secret" class="stl-col-md-3 control-label"><?php _e( 'Consumer Secret', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-9">
                                    <input class="stl-form-control" name="wssm_xero_consumer_secret" type="text" id="wssm_xero_consumer_secret" value="<?php echo $wssm_xero_consumer_secret; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6" style="clear: both;">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Authorization Page', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_STRIPE_XERO_AUTHORIZATION]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="xeroauth" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $xeroauth)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Callback Page', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_STRIPE_XERO_CALLBACK]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="xerocallback" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $xerocallback)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php
                        if($wssm_xero_consumer_key !='' && $wssm_xero_consumer_secret !='' && $xeroauth !='' && $xeroauth !='')
                        {
                        ?>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <a href="<?php echo site_url()."/".$xeroauth; ?>" class="stl-btn stl-btn-success" target="_blank"><?php _e( 'Connect', 'wp_stripe_management' ); ?></a>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <!-- <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="public_key" class="stl-col-md-3 control-label"><?php _e( 'Public Key File', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-9">
                                    <input name="public_key" type="file" id="public_key" value="">
                                    <span>File URL: <?php echo $public_file; ?></span>
                                    <input type="hidden" name="public_old" value="<?php echo $wssm_xero_public_key_file; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="private_key" class="stl-col-md-3 control-label"><?php _e( 'Private Key File', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-9">
                                    <input name="private_key" type="file" id="private_key" >
                                    <span>File URL: <?php echo $private_file; ?></span>
                                    <input type="hidden" name="private_old" value="<?php echo $wssm_xero_private_key_file; ?>">
                                </div>
                            </div>
                        </div> -->
                        
                    </div>


                    <div class="stl-col-md-12" style="clear: both;">
                        <h4 class="sp_subtitle"><?php _e( 'Subscription Cancel', 'wp_stripe_management' ); ?></h4>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="jobTitleReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Cancel type', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-9">
                                    <input name="wssm_stripe_cancel" id="wssm_stripe_cancel1" type="radio" value="immediately" <?php echo ($wssm_stripe_cancel == 'immediately')?'checked':''; ?> > <labe for="wssm_stripe_cancel1"><?php _e( 'Cancelled immediately', 'wp_stripe_management' ); ?></labe>
                                    <input name="wssm_stripe_cancel" id="wssm_stripe_cancel2" type="radio" value="endofcycle" <?php echo ($wssm_stripe_cancel == 'endofcycle')?'checked':''; ?> > <labe for="wssm_stripe_cancel2"><?php _e( 'End of the billing cycle', 'wp_stripe_management' ); ?></labe>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Cancellation Message', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-9">
                                    <input class="stl-form-control" name="wssm_stripe_cancel_msg" type="text" id="wssm_stripe_cancel_msg" value="<?php echo $wssm_stripe_cancel_msg; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="stl-col-md-12" style="clear: both;">
                        <h4 class="sp_subtitle"><?php _e( 'Invoicing', 'wp_stripe_management' ); ?></h4>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Due days', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-4">
                                    <input class="stl-form-control" name="wssm_stripe_pay_duedays" type="number" id="wssm_stripe_pay_duedays" value="<?php echo $wssm_stripe_pay_duedays; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="stl-col-md-12" style="clear: both;">
                        <h4 class="sp_subtitle"><?php _e( 'Pages', 'wp_stripe_management' ); ?></h4>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Account Info', 'wp_stripe_management' ); ?>
                                        <span class="stl-small">[WSSM_STRIPE_MANAGEMENT]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_actinfo" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_actinfo)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Payment Methods', 'wp_stripe_management' ); ?>
                                        <span class="stl-small">[WSSM_STRIPE_CARD]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_card" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_card)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Invoices', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_STRIPE_INVOICE]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_invoice" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_invoice)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Subscriptions', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_STRIPE_SUBSCRIPTION]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_sub" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_sub)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Add Subscriptions', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_STRIPE_ADDSUBSCRIPTION]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_addsub" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_addsub)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Success Subscribe', 'wp_stripe_management' ); ?>
                                    <span class="stl-small"></span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_subsuccess" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_subsuccess)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        

                        <div class="stl-col-md-6" style="clear: both;">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Login/Register', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_LOGIN_REGISTER]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_logreg" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_logreg)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Email Verification', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_EMAIL_VERIFICATION]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="page_emailver" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $page_emailver)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-6" style="clear: both;">
                            <div class="stl-col-md-12 stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-4 control-label"><?php _e( 'Additional Users', 'wp_stripe_management' ); ?>
                                    <span class="stl-small">[WSSM_STRIPE_ADDITIONAL_USERS]</span>
                                </label>
                                <div class="stl-col-md-8">
                                    <select name="additional_users" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $additional_users)?'selected':'';
                                                    echo "<option value='".$wppage->post_name."' ".$selected.">".$wppage->post_title."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="stl-col-md-12" style="clear: both;">
                        <h4 class="sp_subtitle"><?php _e( 'Registration', 'wp_stripe_management' ); ?></h4>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label>
                                    <input name="loginreg_status" type="checkbox" value="1" <?php echo ($loginreg_status == '1')?'checked':''; ?> > <?php _e('Allow users to register / login on new subscription','wp_stripe_management' ); ?>
                                </label>
                            </div>
                        </div>
                        <div class="stl-col-md-6">
                            <div class="stl-col-md-12 stl-form-group">
                                <label>
                                    <input name="password_status" type="checkbox" value="1" <?php echo ($password_status == '1')?'checked':''; ?>> <?php _e('Login via email (no password)','wp_stripe_management' ); ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    
                   
                    <div class="stl-form-group stl-col-md-12 stl-text-center">
                        <br><input type="submit" name="stlwssm_submit" class="stl-btn stl-btn-success" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

