<div class="stl-col-md-12 stl-col-sm-12 stl-col-xs-12 sppage">
    <div class="stl-row">
        <p class="sp_title"><?php _e( 'Meta Data', 'wp_stripe_submang' ); ?></p>
        <div class="stl-container-fluid">
            <div class="stl-row ors-columns-outer">
                <?php
                global $wpdb;
                $table_name = WSSM_METADATA_TABLE_NAME; 

                if(isset($_POST['stlwssm_submit']))
                {
                    $wpdb->query('TRUNCATE TABLE '. $table_name);

                    $meta_data = (isset($_POST['meta_data']))?$_POST['meta_data']:'';

                    // echo "<pre>";print_r($meta_data);echo "</pre>";exit;
                    if($meta_data !='')
                    {
                        foreach($meta_data as $value)
                        {
                            $stripe_fname = $value['stripe_fname'];
                            $sublist_activation = (isset($value['sublist_activation']))?$value['sublist_activation']:'0';
                            $sublist_activation_label = $value['sublist_activation_label'];
                            $newsub_activation = (isset($value['newsub_activation']))?$value['newsub_activation']:'0';
                            $newsub_activation_label = $value['newsub_activation_label'];
                            $wpdb->insert( $table_name, array('stripe_fname' => $stripe_fname, 'sublist_activation' => $sublist_activation,'sublist_activation_label' => $sublist_activation_label,'newsub_activation' => $newsub_activation,'newsub_activation_label' => $newsub_activation_label) );
                        }
                    }
                    echo "<div class='stl-alert stl-alert-success'>".__('Data saved successfully', 'wp_stripe_management' )."</div>";
                }

                $ccmap_results = $wpdb->get_results( "SELECT * FROM ".$table_name );

                ?>
                <form action="" class="form-horizontal" method="post" id="stl_save_infdata">
                    <div class="stl-col-md-8">
     
                        <div class="stl-col-md-12">
                            <br>
                            <input type="hidden" class="tr_count" value="<?php echo sizeof($ccmap_results); ?>"> 
                            <table class="stl-table stl_currencytb">
                                <thead>
                                    <tr>
                                        <th><?php _e( 'Field Name', 'wp_stripe_management' ); ?></th>
                                        <th><?php _e( 'Subs List', 'wp_stripe_management' ); ?></th>
                                        <th><?php _e( 'New Subscription', 'wp_stripe_management' ); ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=0;
                                    if($ccmap_results)
                                    {
                                        foreach($ccmap_results as $ccmap_result){
                                            $stripe_fname = $ccmap_result->stripe_fname;
                                            $sublist_activation = $ccmap_result->sublist_activation;
                                            $sublist_activation_label = $ccmap_result->sublist_activation_label;
                                            $newsub_activation = $ccmap_result->newsub_activation;
                                            $newsub_activation_label = $ccmap_result->newsub_activation_label;
                                            $achecked1 = ($sublist_activation == '1')?'checked':'';
                                            $achecked2 = ($newsub_activation == '1')?'checked':'';
                                        ?>
                                        <tr>
                                        <td>
                                            <input type="text" name="meta_data[<?=$i;?>][stripe_fname]" class="stl-form-control" value="<?=$stripe_fname; ?>">
                                        </td>
                                        <td>
                                            <input type="checkbox" name="meta_data[<?=$i;?>][sublist_activation]" value="1" <?=$achecked1; ?> >
                                            <input type="text" name="meta_data[<?=$i;?>][sublist_activation_label]" class="stl-form-control stl_inline_input"  value="<?=$sublist_activation_label; ?>">
                                        </td>
                                        <td>
                                            <input type="checkbox" name="meta_data[<?=$i;?>][newsub_activation]" value="1" <?=$achecked2; ?> >
                                            <input type="text" name="meta_data[<?=$i;?>][newsub_activation_label]" class="stl-form-control stl_inline_input" value="<?=$newsub_activation_label; ?>">
                                            
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
                                            <input type="text" name="meta_data[<?=$i;?>][stripe_fname]" class="stl-form-control">
                                        </td>
                                        <td>
                                            <input type="checkbox" name="meta_data[<?=$i;?>][sublist_activation]" value="1" >
                                            <input type="text" name="meta_data[<?=$i;?>][sublist_activation_label]" class="stl-form-control stl_inline_input">
                                        </td>
                                        <td>
                                            <input type="checkbox" name="meta_data[<?=$i;?>][newsub_activation]" value="1" >
                                            <input type="text" name="meta_data[<?=$i;?>][newsub_activation_label]" class="stl-form-control stl_inline_input" >
                                            
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


        var tr_txt = '<tr><td><input type="text" name="meta_data['+tr_count+'][stripe_fname]" class="stl-form-control"></td><td><input type="checkbox" name="meta_data['+tr_count+'][sublist_activation]" value="1" > <input type="text" name="meta_data['+tr_count+'][sublist_activation_label]" class="stl-form-control stl_inline_input"></td><td><input type="checkbox" name="meta_data['+tr_count+'][newsub_activation]" value="1" > <input type="text" name="meta_data['+tr_count+'][newsub_activation_label]" class="stl-form-control stl_inline_input" ></td><td><button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_additem"><i class="stl-glyphicon stl-glyphicon-plus"></i></button> <button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_removeitem"><i class="stl-glyphicon stl-glyphicon-remove"></i></button></td></tr>';
        jQuery(".stl_currencytb tbody").append(tr_txt);
        jQuery(".tr_count").val(tr_count);
    });
    jQuery(document).on('click','.btn_removeitem',function(){
        jQuery(this).closest('tr').remove();
    })
</script>

