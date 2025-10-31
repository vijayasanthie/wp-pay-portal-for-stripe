<div class="stl-col-md-12 stl-col-sm-12 stl-col-xs-12 sppage">
    <div class="stl-row">
        <p class="sp_title"><?php _e( 'Email Verification', 'wp_stripe_submang' ); ?></p>
        <div class="stl-container-fluid">
            <div class="stl-row ors-columns-outer">
                <?php
                if(isset($_POST['stlwssm_submit']))
                {

                    $wssm_mail_urlredirect = (isset($_POST['wssm_mail_urlredirect']))?$_POST['wssm_mail_urlredirect']:'';
                    $wssm_link_expire = (isset($_POST['wssm_link_expire']))?$_POST['wssm_link_expire']:'';
                    $wssm_email_subject = (isset($_POST['wssm_email_subject']))?$_POST['wssm_email_subject']:'';
                    $wssm_email_sender = (isset($_POST['wssm_email_sender']))?$_POST['wssm_email_sender']:'';
                    $wssm_email_content = (isset($_POST['wssm_email_content']))?$_POST['wssm_email_content']:'';

                    update_option( 'wssm_mail_urlredirect', $wssm_mail_urlredirect );
                    update_option( 'wssm_link_expire', $wssm_link_expire );
                    update_option( 'wssm_email_subject', $wssm_email_subject );
                    update_option( 'wssm_email_sender', $wssm_email_sender );
                    update_option( 'wssm_email_content', $wssm_email_content );


                }

                $wssm_mail_urlredirect = get_option('wssm_mail_urlredirect','');
                $wssm_link_expire = get_option('wssm_link_expire','');
                $wssm_email_subject = get_option('wssm_email_subject','Email Verification');
                $wssm_email_sender = get_option('wssm_email_sender','');
                $wssm_email_content = get_option('wssm_email_content','Greetings,

Someone requested an email login link to your account.

{{LINK}} to access the Account Manager.

This link is set to expire 10 minutes from creation.

If you are experiencing difficulties accessing your account, please contact support@mailarchiva.com.');

                ?>
                <form action="" class="form-horizontal" method="post" id="stl_save_infdata"><br>
                    <div class="stl-col-md-5">
                        <div class="stl-col-md-12 stl-form-group">
                            <label class="stl-col-md-3 control-label"><?php _e( 'Link Expiry', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <select class="stl-form-control" name="wssm_link_expire">
                                    <option value="never" <?php echo ($wssm_link_expire=='never')?'selected':''; ?> ><?php _e( 'Never', 'wp_stripe_management' ); ?></option>
                                    <option value="10mins" <?php echo ($wssm_link_expire=='10mins')?'selected':''; ?>><?php _e( '10 minutes', 'wp_stripe_management' ); ?></option>
                                    <option value="20mins" <?php echo ($wssm_link_expire=='20mins')?'selected':''; ?>><?php _e( '20 minutes', 'wp_stripe_management' ); ?></option>
                                    <option value="1hr" <?php echo ($wssm_link_expire=='1hr')?'selected':''; ?>><?php _e( '1 hour', 'wp_stripe_management' ); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="stl-col-md-7">
                        <div class="stl-col-md-12 stl-form-group">
                            <label class="stl-col-md-3 control-label"><?php _e( 'Url Redirect', 'wp_stripe_management' ); ?>
                                <br><span class="stl-small">[WSSM_EMAIL_VERIFICATION]</span>
                            </label>
                            <div class="stl-col-md-9">
                                <select name="wssm_mail_urlredirect" class="stl-form-control">
                                        <option value=""><?php _e( 'Choose page', 'wp_stripe_management' ); ?></option>
                                        <?php
                                            $args = array('sort_order' => 'asc','sort_column' => 'post_title','post_type' => 'page','post_status' => 'publish'); 
                                            $wppages = get_pages();
                                            if($wppages){
                                                foreach($wppages as $wppage)
                                                {
                                                    $selected = ($wppage->post_name == $wssm_mail_urlredirect)?'selected':'';
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
                            <label class="stl-col-md-3 control-label"><?php _e( 'Email Subject', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_email_subject" type="text" value="<?php echo $wssm_email_subject; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="stl-col-md-6">   
                        <div class="stl-col-md-12 stl-form-group">
                            <label class="stl-col-md-3 control-label"><?php _e( 'Email Sender', 'wp_stripe_management' ); ?></label>
                            <div class="stl-col-md-9">
                                <input class="stl-form-control" name="wssm_email_sender" type="text" value="<?php echo $wssm_email_sender; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="stl-col-md-9">   
                        <div class="stl-col-md-12 stl-form-group">
                            <label class="stl-col-md-4 control-label"><?php _e( 'Email Content', 'wp_stripe_management' ); ?>
                                <br><span class="stl-small">Use the shortcode {{LINK}} to display the link.</span>
                            </label>
                            <div class="stl-col-md-8">
                                <textarea class="stl-form-control" name="wssm_email_content" rows="10" cols="50"><?php echo $wssm_email_content; ?></textarea>
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

