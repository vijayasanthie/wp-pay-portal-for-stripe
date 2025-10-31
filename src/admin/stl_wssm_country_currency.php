<div class="stl-col-md-12 stl-col-sm-12 stl-col-xs-12 sppage">
    <div class="stl-row">
        <p class="sp_title"><?php _e( 'Currencies', 'wp_stripe_submang' ); ?></p>
        <div class="stl-container-fluid">
            <div class="stl-row ors-columns-outer">
                <?php
                global $wpdb;
                $table_name = WSSM_CURCOUNTRY_TABLE_NAME; 

                if(isset($_POST['stlwssm_submit']))
                {
                    $wpdb->query('TRUNCATE TABLE '. $table_name);
                    // $wpdb->delete( $table_name);
                    $wssm_default_currency = (isset($_POST['wssm_default_currency']))?$_POST['wssm_default_currency']:'';
                    $currency_data = (isset($_POST['currency_data']))?$_POST['currency_data']:'';
                    update_option( 'wssm_default_currency', $wssm_default_currency );
                    if($currency_data !='')
                    {
                        foreach($currency_data as $value)
                        {
                            $country = $value['country'];
                            $currency = $value['currency'];
                            $wpdb->insert( $table_name, array('country_code' => $country, 'currency_code' => $currency) );
                        }
                    }
                    echo "<div class='stl-alert stl-alert-success'>".__('Data saved successfully', 'wp_stripe_management' )."</div>";
                }
                $wssm_default_currency = get_option('wssm_default_currency','');
                $ccmap_results = $wpdb->get_results( "SELECT * FROM ".$table_name );

                ?>
                <form action="" class="form-horizontal" method="post" id="stl_save_infdata">
                    <div class="stl-col-md-6">
                        <div class="stl-col-md-12">
                            <br>
                            <div class="stl-form-group">
                                <label for="departmentReg" id="label" class="stl-col-md-3 control-label"><?php _e( 'Default Currency', 'wp_stripe_management' ); ?></label>
                                <div class="stl-col-md-2">
                                    <select name="wssm_default_currency" class="stl-form-control" required>
                                        <?php
                                        foreach(WSSM_CURRENCY as $key=>$value)
                                        {
                                            $selected = ($wssm_default_currency == $key)?'selected':'';
                                            echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="stl-col-md-12">
                            <input type="hidden" class="tr_count" value="<?php echo sizeof($ccmap_results); ?>"> 
                            <table class="stl-table stl_currencytb">
                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Currency</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=0;
                                    if($ccmap_results)
                                    {
                                        foreach($ccmap_results as $ccmap_result){
                                            $country = $ccmap_result->country_code;
                                            $currency = $ccmap_result->currency_code;
                                        ?>
                                        <tr>
                                        <td>
                                            <select name="currency_data[<?=$i;?>][country]" class="stl-form-control" required>
                                                <?php 
                                                foreach(WSSM_COUNTRY as $key=>$value)
                                                {
                                                    $selected = ($country == $key)?'selected':'';
                                                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="currency_data[<?=$i;?>][currency]" class="stl-form-control" required>
                                                <?php 
                                                foreach(WSSM_CURRENCY as $key=>$value)
                                                {
                                                    $selected = ($currency == $key)?'selected':'';
                                                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_additem"><i class="stl-glyphicon stl-glyphicon-plus"></i></button>
                                            <button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_removeitem"><i class="stl-glyphicon stl-glyphicon-remove"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    } }
                                    else {
                                    ?>
                                    <tr>
                                        <td>
                                            <select name="currency_data[<?=$i;?>][country]" class="stl-form-control" required>
                                                <?php 
                                                foreach(WSSM_COUNTRY as $key=>$value)
                                                {
                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="currency_data[<?=$i;?>][currency]" class="stl-form-control" required>
                                                <?php 
                                                foreach(WSSM_CURRENCY as $key=>$value)
                                                {
                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_additem"><i class="stl-glyphicon stl-glyphicon-plus"></i></button>
                                            <button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_removeitem"><i class="stl-glyphicon stl-glyphicon-remove"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="stl-form-group stl-col-md-6 stl-text-center" style="clear: both;">
                        <br><input type="submit" name="stlwssm_submit" class="stl-btn stl-btn-success" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).on('click','.btn_additem',function(){
        var tr_count = jQuery(".tr_count").val();
        tr_count = tr_count+1;
        var country_arr = <?php echo json_encode(WSSM_COUNTRY); ?>;
        var currency_arr = <?php echo json_encode(WSSM_CURRENCY); ?>;
        console.log(currency_arr);
        var country_opt = '';
        jQuery.each(country_arr,function(key,value){
            country_opt +='<option value="'+key+'">'+value+'</option>';
        });
        var currency_opt = '';
        jQuery.each(currency_arr,function(key,value){
            currency_opt +='<option value="'+key+'">'+value+'</option>';
        });

        var tr_txt = '<tr><td><select name="currency_data['+tr_count+'][country]" class="stl-form-control" required>'+country_opt+'</select></td><td><select name="currency_data['+tr_count+'][currency]" class="stl-form-control" required>'+currency_opt+'</select></td><td><button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_additem"><i class="stl-glyphicon stl-glyphicon-plus"></i></button><button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_removeitem"><i class="stl-glyphicon stl-glyphicon-remove"></i></button></td></tr>';
        jQuery(".stl_currencytb tbody").append(tr_txt);
        jQuery(".tr_count").val(tr_count);
    });
    jQuery(document).on('click','.btn_removeitem',function(){
        jQuery(this).closest('tr').remove();
    })
</script>

