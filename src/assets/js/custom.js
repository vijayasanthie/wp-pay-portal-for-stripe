jQuery(document).on('click','.stl-modal .stl-close, .stl-modal .btn_modalcancel',function(){
  jQuery(".stl-modal").hide();
});

jQuery(window).load(function(){
    jQuery('.stl_preloader').css("visibility", "hidden");
})

// jQuery(document).on('shown.bs.modal', function (e) {
//   jQuery(e.target, '[autofocus]').focus()
// })
// jQuery(document).on('shown.bs.modal', function (e) {
//         jQuery('[autofocus]', e.target).focus();
//       });


jQuery(document).ready(function(){

	
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	var stl_ajaxurl = jQuery(".stl_admin_ajaxjs").val() || '';
	var cdefault_currency = jQuery(".cdefault_currency").val() || 'usd';
	var cdefault_currency_symbol = jQuery(".cdefault_currency_symbol").val() || 'US $';

	var stl_sucsmsg_success = jQuery(".stl_sucsmsg_success").val() || 'Success';
	var stl_sucsmsg_error = jQuery(".stl_sucsmsg_error").val() || 'Error';

	var stl_errormsg_streetadr = jQuery(".stl_errormsg_streetadr").val() || 'Please enter the street address line1';
	var stl_errormsg_city = jQuery(".stl_errormsg_city").val() || 'Please enter the city';
	var stl_errormsg_state = jQuery(".stl_errormsg_state").val() || 'Please Enter the state';
	var stl_errormsg_postalcode = jQuery(".stl_errormsg_postalcode").val() || 'Please Enter the postal code';
	var stl_errormsg_cmpname = jQuery(".stl_errormsg_cmpname").val() || 'Please enter the company name';
	var stl_errormsg_country = jQuery(".stl_errormsg_country").val() || 'Please Enter the country name';
	var stl_errormsg_email = jQuery(".stl_errormsg_email").val() || 'Please enter the emailid';
	var stl_errormsg_chname = jQuery(".stl_errormsg_chname").val() || 'Please enter the card holder name';
	var stl_errormsg_emonth = jQuery(".stl_errormsg_emonth").val() || 'Please enter the card expire month';
	var stl_errormsg_eyear = jQuery(".stl_errormsg_eyear").val() || 'Please enter the card expire year';
	var stl_errormsg_cvv = jQuery(".stl_errormsg_cvv").val() || 'Please enter the CCV';
	var stl_errormsg_cardno = jQuery(".stl_errormsg_cardno").val() || 'Please enter the card number';


	// var stl_sucsmsg_error = jQuery(".stl_sucsmsg_error").val() || 'Error';
	// var stl_sucsmsg_error = jQuery(".stl_sucsmsg_error").val() || 'Error';


	var utils_jsfile = jQuery(".utils_jsfile").val();


	/*********** account info js  start *************/

	jQuery(document).on('click','.btn_editaccountinfo,.btn_newcustomer',function(e){
        // console.log("popupppp");
	   jQuery("#edit_accountinfo_modal").show();
        jQuery(".stl-modal").find('[autofocus]').focus();
	});
	var customer_id = jQuery(".customer_id").val() || '';



    var account_form1 = jQuery('#account_infoform');


    account_form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        messages: {              
			'company_name': {
                required: stl_errormsg_cmpname,
            },
            'emailid': {
                required: stl_errormsg_email,
                remote : stl_lg_emailexit
            },
            'address_line1': {
                required: stl_errormsg_streetadr,
            },
            'city': {
                required: stl_errormsg_city,
            },
            'state': {
                required: stl_errormsg_state,
            },
            'postal_code': {
                required: stl_errormsg_postalcode,
            },

        },
        rules: {
            company_name: {required: true}, 
            address_line1: {required: true}, 
            city: {required: true}, 
            state: {required: true}, 
            postal_code: {required: true}, 
            emailid: {required: true,
                remote : {
                    url: stl_ajaxurl,
                    type: "post",
                    data: {
                        'action': 'checkEmailalreadyexists',
                        'emailtype': 'accountedit',
                        old_emailid: function(){
                            return jQuery(".old_emailid").val();
                        }
                    }
                }
            }, 
        },

        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },

        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },

        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function(form,event) {
        	setTimeout(function(){

				var $form = jQuery(form);
                var newemailid = jQuery(".emailid").val() || '';
                var old_emailid = jQuery(".old_emailid").val() || '';
				jQuery.ajax({
					url : stl_ajaxurl,
					type: 'POST',
					data: $form.serialize(),
					dataType:'json',
					beforeSend: function() {
				        jQuery('.stl_ajaxloader').css("visibility", "visible");
				    },
					success:function(response){
                        // console.log("successs");
						// if(response['stl_status'])
						// {

							var stl_sucsmsg_auctinfo = jQuery(".stl_sucsmsg_auctinfo").val();
                            var stl_admin_urlredirect = jQuery(".stl_admin_urlredirect").val();
							toastr.options = {"closeButton": true,}
							// if(response['message'] == '')
							// {
							// 	toastr.success(stl_sucsmsg_auctinfo, stl_sucsmsg_success);
							// }
							// else
							// {
								toastr.success(response['message'], stl_sucsmsg_success);
							// }
							
							
							setTimeout(function(){
                                if(response['user_activation_code'] =='')
                                    location.reload();
                                else
                                {
                                    location.reload();
                                    window.location.href = stl_admin_urlredirect+"?wssm_activationcode="+response['user_activation_code'];

                                    
                                }
								
							}, 800);
						// }
						// else
						// {
						// 	toastr.error(response['message'], stl_sucsmsg_error);
						// }
						jQuery('.stl_ajaxloader').css("visibility", "hidden");
										
					},
                    error:function(xhr, status, error)
                    {
                        // console.log("eroorrrrr");
                        // toastr.error('Error', stl_sucsmsg_error);
                        toastr.error( xhr.responseText, stl_sucsmsg_error); //stl ajax error
                        jQuery('.stl_ajaxloader').css("visibility", "hidden");
                    }
				});
			}, 500);
			return false;
        }
   	});


    jQuery(document).on('click','.btn_opencoupon',function(){
    	jQuery("#add_coupon_modal").show();
        jQuery(".stl-modal").find('[autofocus]').focus();

    })

    var form2 = jQuery('#account_couponform');


   	form2.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        messages: {              
			'coupon': {
                required: jQuery(".stl_errormsg_couponcode").val(),
            },
        },
        rules: {
            coupon: {required: true}, 
        },

        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },

        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },

        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function(form,event) {

			var $form = jQuery(form);
			jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: $form.serialize(),
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_couponsave = jQuery(".stl_sucsmsg_couponsave").val();
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_couponsave, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
						}, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    // toastr.error('Error', stl_sucsmsg_error);
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
			return false;
        }
   	});

   	/********** /account info js end *****************/

   	/************* card page js start ***********/

   	jQuery(document).on('click','.btn_deletecardinfo',function(){
		var card_id = jQuery(this).closest('tr').data('id');
		var customer_id = jQuery(this).closest('tr').data('cusid');
		var stlcard_no = jQuery(this).closest('tr').find('.stlcard_no').html();
		swal({
		  title: jQuery(".stl_swt_dtcardinfo").val(),
		  text: jQuery(".stl_swt_dtcardcnf").val()+" "+stlcard_no+"?" ,
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonClass: "stl_swat_cancel",
		  confirmButtonClass: "stl_swat_success",
		  confirmButtonText: "Delete it",
		  closeOnConfirm: true
		},
		function(){
			jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {action: 'DeleteCardInfo','card_id':card_id,'customer_id':customer_id},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_carddelt = jQuery(".stl_sucsmsg_carddelt").val();
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_carddelt, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
						}, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    // toastr.error('Error', stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
		});
	})

	jQuery(document).on('click','.btn_addcard',function(){
		jQuery("#add_card_modal").show();
        jQuery(".stl-modal").find('[autofocus]').focus();
	});

	var form = jQuery('#add_cardform');
	form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        messages: {              
			'holder_name': {
                required: stl_errormsg_chname,
            },
            'card_no': {
                required: stl_errormsg_cardno,
            },
            'expire_month': {
                required: stl_errormsg_emonth,
            },
            'expire_year': {
                required: stl_errormsg_eyear,
            },
            'ccv': {
                required: stl_errormsg_cvv,
            },
            'card_address_line1': {
                required: stl_errormsg_streetadr,
            },
            'card_city': {
                required: stl_errormsg_city,
            },
            // 'card_state': {
            //     required: stl_errormsg_state,
            // },
            'card_postal_code': {
                required: stl_errormsg_postalcode,
            },
            'card_country': {
                required: stl_errormsg_country,
            },
        },
        rules: {
            holder_name: {required: true,maxlength: 100}, 
            card_no: {required: true}, 
            expire_month: {required: true,maxlength: 2}, 
            expire_year: {required: true,maxlength: 4}, 
            ccv: {required: true,maxlength: 4}, 
            card_address_line1: {required: true,maxlength: 95}, 
            card_address_line2: {maxlength: 95}, 
            card_city: {required: true,maxlength: 95}, 
            card_state: {maxlength: 95}, 
            card_postal_code: {required: true,maxlength: 10}, 
            card_country: {required: true}, 
        },

        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },

        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },

        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function(form,event) {
			var $form = jQuery(form);
			jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: $form.serialize(),
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_cardsave = jQuery(".stl_sucsmsg_cardsave").val();
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_cardsave, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
						}, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    // toastr.error('Error', stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
			return false;
        }
   	});

    var card_form1 = jQuery('#edit_cardform');


    card_form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        messages: {              
			'holder_name': {
                required: stl_errormsg_chname,
            },
            'expire_month': {
                required: stl_errormsg_emonth,
            },
            'expire_year': {
                required: stl_errormsg_eyear,
            },
            'address_line1': {
                required: stl_errormsg_streetadr,
            },
            'city': {
                required: stl_errormsg_city,
            },
            'state': {
                required: stl_errormsg_state,
            },
            'postal_code': {
                required: stl_errormsg_postalcode,
            },
            'country': {
                required: stl_errormsg_country,
            },
        },
        rules: {
            // holder_name: {required: true}, 
            // expire_month: {required: true}, 
            // expire_year: {required: true}, 
            // address_line1: {required: true}, 
            // city: {required: true}, 
            // state: {required: true}, 
            // postal_code: {required: true}, 
            // country: {required: true}, 
             holder_name: {required: true,maxlength: 100}, 
            expire_month: {required: true,maxlength: 2}, 
            expire_year: {required: true,maxlength: 4}, 
            address_line1: {required: true,maxlength: 95}, 
            address_line2: {maxlength: 95}, 
            city: {required: true,maxlength: 95}, 
            state: {maxlength: 95}, 
            postal_code: {required: true,maxlength: 10}, 
            country: {required: true}, 
        },

        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },

        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },

        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function(form,event) {
			var $form = jQuery(form);
			jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: $form.serialize(),
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader1').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_cardsave = jQuery(".stl_sucsmsg_cardsave").val();
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_cardsave, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
						}, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader1').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    // toastr.error('Error', stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
			return false;
        }
   	});

   	
   	/************ card page js end ************/


   	/******* invoice js start **********/


   	jQuery(document).on('click','.card_paytype',function(){
		var card_type = jQuery('input[name=card_type]:checked').val();
		if(card_type == '1')
		{
			jQuery(".card_hiddendiv").hide();
		}
		else
		{
			jQuery(".card_hiddendiv").show();
		}
	})

	var runningTotal = 0;

	var invoice_table = jQuery('#invoice_tb').DataTable({ 
    	paging: true,
    	"pageLength": 10,
     	"lengthMenu": [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "All"]],
      	//"ordering": false,
       	"order": [[ 3, "asc" ]],
      	//"oSearch": {"sSearch": 'open' }
    });


	jQuery("#invoice_tb thead th").each( function ( i ) {
        if(i==3)
        {
        	var this_html = jQuery(this).html();
        	var select = jQuery('<select class="invoice_dataselect"><option value="">'+this_html+'</option></select>')
            .appendTo( jQuery(this).empty() )
            .on( 'change', function () {
                invoice_table.column( i )
                    .search( jQuery(this).val() )
                    .draw();
            } );

            select.append( '<option value="open">Open</option>' );
            select.append( '<option value="past_due">Past due</option>' );
            select.append( '<option value="draft">Draft</option>' );
            select.append( '<option value="paid">Paid</option>' );
            select.append( '<option value="uncollectible">Uncollectible</option>' );
            // select.append( '<option value="void">Void</option>' );
 
        	// table.column( i ).data().unique().sort().each( function ( d, j ) {
         //    	select.append( '<option value="'+d+'">'+d+'</option>' )
        	// });
      	}
    });


    var addinuser_table = jQuery('#addinuser_tb').DataTable({ 
        paging: true,
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "All"]],
        //"ordering": false,
        "order": [[ 3, "asc" ]],
        //"oSearch": {"sSearch": 'open' }
    });


    // jQuery("#addinuser_tb thead th").each( function ( i ) {
    //     if(i==3)
    //     {
    //         var this_html = jQuery(this).html();
    //         var select = jQuery('<select class="invoice_dataselect"><option value="">'+this_html+'</option></select>')
    //         .appendTo( jQuery(this).empty() )
    //         .on( 'change', function () {
    //             addinuser_table.column( i )
    //                 .search( jQuery(this).val() )
    //                 .draw();
    //         } );

    //         select.append( '<option value="open">Verified</option>' );
    //         select.append( '<option value="past_due">Waiting</option>' );
    //         select.append( '<option value="draft">Draft</option>' );
    //         select.append( '<option value="paid">Paid</option>' );
    //         select.append( '<option value="uncollectible">Uncollectible</option>' );
    //         // select.append( '<option value="void">Void</option>' );
 
    //         // table.column( i ).data().unique().sort().each( function ( d, j ) {
    //      //     select.append( '<option value="'+d+'">'+d+'</option>' )
    //         // });
    //     }
    // });


	jQuery("#selectall").click(function() {
    	if (runningTotal == invoice_table.rows().count()) {
      		invoice_table.rows().every(function(rowIdx, tableLoop, rowLoop) {
        		let clone = invoice_table.row(rowIdx).data().slice(0);
        		clone[[0]] = '<input type="checkbox" class="record">'
        		invoice_table.row(rowIdx).data(clone);
      		});
    	} else {
      		invoice_table.rows().every(function(rowIdx, tableLoop, rowLoop) {
        		let clone = invoice_table.row(rowIdx).data().slice(0);
        		clone[[0]] = '<input type="checkbox" class="record" checked="checked">'
        		invoice_table.row(rowIdx).data(clone);
      		});
    	}
    	runningTotal = 0;
    	invoice_table.rows().every(function(rowIdx, tableLoop, rowLoop) {
      		var data = this.data();
      		if (jQuery(data[0]).prop("checked")) {
        		runningTotal++
      		}
    	});
    	jQuery('#dvcount').html(runningTotal);
  	});

	jQuery('#invoice_tb tbody').on("click", ".record", function() {
    	let clone = invoice_table.row(jQuery(this).closest('tr')).data().slice(0);
    	let checkbox = clone[clone.length - 1];
    	if (jQuery(checkbox).prop("checked")) {
      	clone[[0]] = '<input type="checkbox" class="record">'
    	} else {
      	clone[[0]] = '<input type="checkbox" class="record" checked="checked">';
    	}
    	invoice_table.row(jQuery(this).closest('tr')).data(clone);
    	runningTotal = 0;
    	invoice_table.rows().every(function(rowIdx, tableLoop, rowLoop) {
      	var data = this.data();

      	if (jQuery(data[0]).prop("checked")) {
        	runningTotal++
      	}
    	});
    	jQuery('#dvcount').html(runningTotal);
  	});


	jQuery(document).on('click','.btn_payall',function(){

		var payamt = 0;
		var currency = cdefault_currency;
		var currency_symp = cdefault_currency_symbol;
		var invoice_details = [];
	  	var kk = 0;
    	var selectedadvids = invoice_table.$('input:checked').map(function () {
      		var invoice_id = jQuery(this).closest('tr').data('id');
			//jQuery(".invoice_id").val(invoice_id);
			var amt = jQuery(this).closest('tr').data('amt');
			//jQuery(".invoice_amount").val(amt);
			currency = jQuery(this).closest('tr').data('currency');
			currency_symp = jQuery(this).closest('tr').data('currency_symp');
			var customer_id = jQuery(this).closest('tr').data('cusid');



			invoice_details[kk] = {};
			invoice_details[kk].invoice_id = invoice_id;
			invoice_details[kk].invoice_amount = amt;
			invoice_details[kk].invoice_currency = currency;
			invoice_details[kk].customer_id = customer_id;
			payamt += parseFloat(amt);
			kk++;

		 	jQuery(".invpayment_type").val('bulk');
      		return invoice_details;
    	});


    	if(selectedadvids !='')
    	{
			var invoicedata = JSON.stringify(invoice_details);
    		jQuery(".invoice_arr").val(invoicedata);

    		var payamount = parseFloat(payamt)/100;
			payamount = payamount.toFixed(2);
			jQuery(".payamount").html(currency_symp+" "+payamount);

    	 	jQuery("#pay_invoice_modal").show();
            jQuery(".stl-modal").find('[autofocus]').focus();
    	}
	});


	jQuery(document).on('click','.btn_payinvoicemodal',function(){
		var invoice_id = jQuery(this).closest('tr').data('id');
		jQuery(".invoice_id").val(invoice_id);
		var amt = jQuery(this).closest('tr').data('amt');
		jQuery(".invoice_amount").val(amt);
		var currency = jQuery(this).closest('tr').data('currency');
		var currency_symp = jQuery(this).closest('tr').data('currency_symp');
		jQuery(".invoice_currency").val(currency);

		var customer_id = jQuery(this).closest('tr').data('cusid');
		jQuery(".customer_id").val(customer_id);
		
		jQuery(".invpayment_type").val('single');

		var payamount = parseFloat(amt)/100;
		payamount = payamount.toFixed(2);
		jQuery(".payamount").html(currency_symp+" "+payamount);
		 jQuery("#pay_invoice_modal").show();
         jQuery(".stl-modal").find('[autofocus]').focus();
	});


	var pay_invoice_form1 = jQuery('#pay_invoice');


    pay_invoice_form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        messages: {              
			'holder_name': {
                required: stl_errormsg_chname,
            },
            'card_no': {
                required: stl_errormsg_cardno,
            },
            'expire_month': {
                required: stl_errormsg_emonth,
            },
            'expire_year': {
                required: stl_errormsg_eyear,
            },
            'ccv': {
                required: stl_errormsg_cvv,
            },
        },
        rules: {
            holder_name: {
            	required: function (element) {
            		var card_type = jQuery('input[name=card_type]:checked').val();
                    if(card_type == 2){
                        return true;
                    }else {
                        return false;
                    }
                },
                maxlength: 100
            }, 
            card_no: {
            	required: function (element) {
            		var card_type = jQuery('input[name=card_type]:checked').val();
                    if(card_type == 2){
                        return true;
                    }else {
                        return false;
                    }
                }
            	//required: true
            }, 
            expire_month: {
            	required: function (element) {
            		var card_type = jQuery('input[name=card_type]:checked').val();
                    if(card_type == 2){
                        return true;
                    }else {
                        return false;
                    }
                },
                maxlength: 2
            	//required: true
            }, 
            expire_year: {
            	required: function (element) {
            		var card_type = jQuery('input[name=card_type]:checked').val();
                    if(card_type == 4){
                        return true;
                    }else {
                        return false;
                    }
                },
                maxlength: 4
            	//required: true
            }, 
            ccv: {
            	required: function (element) {
            		var card_type = jQuery('input[name=card_type]:checked').val();
                    if(card_type == 4){
                        return true;
                    }else {
                        return false;
                    }
                },
                maxlength: 4
            	//required: true
            },
            card_address_line1: {maxlength: 95}, 
            card_address_line2: {maxlength: 95}, 
            card_city: {maxlength: 95}, 
            card_state: {maxlength: 95}, 
            card_postal_code: {maxlength: 10} 

        },

        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },

        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },

        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function(form,event) {
        	//return false;
			var $form = jQuery(form);
			jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: $form.serialize(),
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader1').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_invsuc = jQuery(".stl_sucsmsg_invsuc").val();
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_invsuc, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
						}, 800);

					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader1').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    // toastr.error('Error', stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader1').css("visibility", "hidden");
                }
			});
			return false;
        }
   	});

   	/******** invoice js end ***************/


   	/********** subscrtiption js start *********/


   	jQuery(document).on('click','.btn_changepaymode',function(){
		var sub_id = jQuery(this).closest('tr').data('id');
		var default_collection = jQuery(this).closest('tr').data('cmthod');
		if(default_collection == 'send_invoice')
		{
			jQuery("input[name=collection_method][value=send_invoice]").attr('checked', true);
		}
		else
		{
			jQuery("input[name=collection_method][value=charge_automatically]").attr('checked', true);
		}
		jQuery(".subscription_id").val(sub_id);
		jQuery(".default_collection").val(default_collection);
		jQuery("#paymode_modal").show();
        jQuery(".stl-modal").find('[autofocus]').focus();
	});

	jQuery(document).on('click','.collection_method',function(){
		var collection_method = jQuery(".collection_method:checked").val();

	});

	jQuery(document).on('click','.btn_savecmethod',function(){
		var subscription_id = jQuery(".subscription_id").val();
		var default_collection = jQuery(".default_collection").val();
		// var payment_due_date = jQuery(".payment_due_date").val()
		var collection_method = jQuery(".collection_method:checked").val();

		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subscription_id,'payment_type':collection_method, 'action' :'UpdateSubPaymenttype'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader1').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_subcolsave = jQuery(".stl_sucsmsg_subcolsave").val();
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_subcolsave, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
							 }, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader1').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    // toastr.error('Error', stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
		// }

	})

	jQuery(document).on('click','.btn_viewusage',function(){
		var subitemid = jQuery(this).data('subitemid');
		jQuery.ajax({
	      url : stl_ajaxurl,
	      dataType : 'json',
	      type:'post',
	      data : {'subitemid': subitemid,action:'getMeterUsageDetails'},
	      beforeSend: function() {
	        jQuery('.stl_ajaxloader').css("visibility", "visible");
	      },
	      success : function( response ) {

	      	var tbody_tr = '';
	      	// if(response['stl_status'])
	      	// {
	      		var planname = response['item']['plan']['nickname'];
	      		jQuery("#view_usage_modal .modal_subtitle").html(planname);
	      		var usages = response['usages']['data'];
	      		if(usages != null)
	      		{
	      			jQuery.each(usages,function(key,value){
	      				var final_start_date = '';
	      				var final_end_date = '';
	      				var date_for = '';
	      				var period_start = value['period']['start'];
	      				var period_end = value['period']['end'];
	      				if(period_start != null)
	      				{
	      					period_start = new Date(period_start*1000);
	          				var start_date = period_start.getDate();
	          				var start_month = monthNames[period_start.getMonth()];
	          				var start_year = period_start.getFullYear();
	          				final_start_date = start_date+" "+start_month+","+start_year;
	      				}
	      				if(period_end != null)
	      				{
	          				period_end = new Date(period_end*1000);
	          				var end_date = period_end.getDate();
	          				var end_month = monthNames[period_start.getMonth()];
	          				var end_year = period_end.getFullYear();
	          				final_end_date = end_date+" "+end_month+","+end_year;
	      				}
	      				if(final_end_date =='')
	      				{
	      					date_for = "Since "+final_start_date;
	      				}
	      				else
	      				{
	      					date_for = final_start_date+" to "+final_end_date;
	      				}
	      				
	      					tbody_tr += "<tr><td>"+value['total_usage']+"</td><td>"+date_for+"</td></tr>";
	      				
	      				
	      			});
	      		}
	      		jQuery("#view_usage_modal .stl-modal-body tbody").html(tbody_tr);
	      	// }
	      	jQuery("#view_usage_modal").show();
	      	jQuery('.stl_ajaxloader').css("visibility", "hidden");


	      },
	      error: function(e){
            toastr.error( xhr.responseText, stl_sucsmsg_error);
	      	// toastr.error(e['responseText'], stl_sucsmsg_error);
	      	jQuery('.stl_ajaxloader').css("visibility", "hidden");
	      }
	  });
	})

	jQuery(document).on('click','.btn_viewnxtinvoice',function(){
		// jQuery('#edit_cardform').find("input[type=text], textarea").val("");
    	var subid = jQuery(this).closest('tr').data('id');
    	var customerid = jQuery(this).closest('tr').data('cusid');
    	var stub_metatd = jQuery(this).closest('tr').find('.stub_metatd') || '';
    	var stub_metath = jQuery('.stub_metath') || '';


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
	        // if(response['stl_status']){ 

	           var invoice_lineitems = response['lines']['data'];
	           var period_start = response['period_start'];
	           var period_end = response['period_end'];
	           var subtotal_org = response['subtotal'];
	           var discount = response['discount'];
	           var tax_amt = response['tax'];
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
	         

                var total_tdcount = 3;

	           // period_start = Date.parse(period_start);
	           // period_end = Date.parse(period_end);
	           subtotal = parseFloat(subtotal_org)/100;
	           subtotal = subtotal.toFixed(2);
	           total = parseFloat(total)/100;
	           total = total.toFixed(2);
	           amount_due = parseFloat(amount_due)/100;
	           amount_due = amount_due.toFixed(2);

	           var modal_content="<div class='stl-col-md-12'><p>"+final_start_date+" - "+final_end_date;
	           if(invoice_lineitems)
	           {
	          	    modal_content += "<table class='stl-table stl_nxtinvoice'><thead><tr><th>Plan</th>";

	          	    jQuery(stub_metath).each(function(){
	          		   var this_html = jQuery(this).html();
	          		   modal_content += "<th>"+this_html+"</th>";
	          	    });

	          	    modal_content += "<th class='stl-text-right'>Qty</th><th class='stl-text-right'>Unit ("+cdefault_currency_symbol+")</th><th class='stl-text-right'>Amount ("+cdefault_currency_symbol+")</th></tr></thead><tbody>";
	          	    jQuery.each(invoice_lineitems ,function(key,invoice_lineitem)
	          	    {
	          		   var nickname = invoice_lineitem['plan']['nickname'];
	          		   var quantity = invoice_lineitem['quantity'];
	          		   var amount = invoice_lineitem['amount'];
	          		   var per_unit_price = invoice_lineitem['plan']['amount'];
	          		   var billing_scheme = invoice_lineitem['plan']['billing_scheme'];
	          		   // var application = '';
	          		   // var customer = '';
    	          		if(billing_scheme != 'tiered')
    	          		{
    	          			per_unit_price = parseFloat(per_unit_price)/100;
    	          			per_unit_price = per_unit_price.toFixed(2);
    	          		}
    	          		else
    	          		{
    	          			per_unit_price = '-';
    	          		}
	          		
	          		   amount = parseFloat(amount)/100;
	          		   amount = amount.toFixed(2);

	          		   modal_content += "<tr><td>"+nickname+"</td>";

    	          		jQuery(stub_metatd).each(function(){
    	          			total_tdcount++;
    		          		var this_html = jQuery(this).html();
    		          		modal_content += "<td>"+this_html+"</td>";
    		          	});

	          		   modal_content += "<td class='stl-text-right'>"+quantity+"</td><td class='stl_tdprice'>"+per_unit_price+"</td><td class='stl_tdprice'>"+amount+"</td></tr>";

	          	    });



	          	    if(discount != null)
	                {
        	          	var discount_coupon = discount['coupon'];
        	          	var coupon_name = discount_coupon['name'];
        	          	var amount_off = discount_coupon['amount_off'];
        	          	var percent_off = discount_coupon['percent_off'];
        	          	if(amount_off != null)
        	          	{
        	          		amount_off = parseFloat(amount_off)/100;
        	          		amount_off = amount_off.toFixed(2);
        	          		discount_tr += '<tr><td colspan="'+total_tdcount+'">'+coupon_name+' ('+amount_off+')</td><td>-'+amount_off+'</td></tr>';
        	          	}
        	          	else
        	          	{
        	          		amount_off =0;
        	          		if(tax_amt !=null)
        					{
        						var tax_inclusive = response['total_tax_amounts'][0]['inclusive'] || '';
        						if(tax_inclusive)
        						{
        							amount_off = (subtotal_org * percent_off)/100;
        						}
        						else
        						{
        							amount_off = (subtotal_org * percent_off)/100;
        						}
        					}
        					else
        					{
        						amount_off = (subtotal_org * percent_off)/100;
        					}
        					amount_off = parseFloat(amount_off)/100;
        	          		amount_off = amount_off.toFixed(2);
        	          		discount_tr += '<tr><td colspan="'+total_tdcount+'">'+coupon_name+' ('+percent_off+'%)</td><td>-'+amount_off+'</td></tr>';
        	          	}
	
	                }


	          	    if(tax_amt !=null)
	                {
	          	        tax = parseFloat(tax_amt)/100;
	          	        tax = tax.toFixed(2);
	          	        if(tax_percent != null)
	          		       tax_tr += '<tr><td colspan="'+total_tdcount+'">Tax ('+tax_percent+'%)</td><td>'+tax+'</td></tr>';
	          	        else
	          		       tax_tr += '<tr><td colspan="'+total_tdcount+'">Tax</td><td>'+tax+'</td></tr>';
	               }


	          	    modal_content += '</tbody><tfoot><tr><td colspan="'+total_tdcount+'">Subtotal:</td><td>'+subtotal+'</td></tr>'+discount_tr+tax_tr+'<tr><td colspan="'+total_tdcount+'">Total:</td><td>'+total+'</td></tr><tr><td colspan="'+total_tdcount+'">Amount Due:</td><td>'+amount_due+'</td></tr></tfoot></table>';
	            }
	            modal_content += '</div>';
	            jQuery("#view_nextinvoice_modal .stl-modal-body").html(modal_content);
	            jQuery("#view_nextinvoice_modal").show();
	        // }
         //    else{
	        //   toastr.error(response['message'], stl_sucsmsg_error);
	        // }
	        
	        jQuery('.stl_ajaxloader').css("visibility", "hidden");
	      },
            error: function(xhr, status, error){
                toastr.error( xhr.responseText, stl_sucsmsg_error);
                jQuery('.stl_ajaxloader').css("visibility", "hidden");
            },
	    });
		
	})

var ftable_results_count = jQuery(".ftable_results_count").val();
var status_td_position = 4+parseInt(ftable_results_count);

	var subscription_table = jQuery('#subscription_tb').DataTable({ 
    	paging: true,
    	"pageLength": 10,
     	"lengthMenu": [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "All"]],
      	//"ordering": false,
       	"order": [[ status_td_position, "asc" ]],
      	//"oSearch": {"sSearch": 'open' }
    });

    jQuery("#subscription_tb thead th").each( function ( i ) {
        if(i==status_td_position)
        {
        	var this_html = jQuery(this).html();
        	var select = jQuery('<select class="invoice_dataselect"><option value="">'+this_html+'</option></select>')
            .appendTo( jQuery(this).empty() )
            .on( 'change', function () {
                subscription_table.column( i )
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
		  title: jQuery(".stl_swt_unsub").val(),
		  text: jQuery(".stl_swt_unsubinfo").val(),
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonClass: "stl_swat_cancel",
		  confirmButtonClass: "stl_swat_cancel",
		  confirmButtonText: "Unsubscribe",
		  cancelButtonText: "Close",
		  closeOnConfirm: true
		},
		function(){

		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subid, 'action' :'CancelSubscription'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						toastr.options = {"closeButton": true,}
						toastr.success(response['message'], stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
							 }, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
		});
	});

	jQuery(document).on('click','.btn_reactivesub',function(){
		var subid = jQuery(this).closest('tr').data('id');


		swal({
		  title: jQuery(".stl_swt_reactive").val(),
		  text: jQuery(".stl_swt_reactiveinfo").val(),
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonClass: "stl_swat_cancel",
		  confirmButtonClass: "stl_swat_success",
		  confirmButtonText: "Re-active",
		  cancelButtonText: "Close",
		  closeOnConfirm: true
		},
		function(){

		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subid, 'action' :'ReactiveSubscription'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_subreactsuc = jQuery(".stl_sucsmsg_subreactsuc").val()
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_subreactsuc, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
							 }, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
		});
	});


	jQuery(document).on('click','.btn_savecoupon',function(){
		var subid = jQuery("#coupon_subid").val();
		var couponid = jQuery(".sub_coupon_id").val();
		var customer_id = jQuery("#sub_customer_id").val();

		    jQuery.ajax({
				url : stl_ajaxurl,
				type: 'POST',
				data: {'subid' : subid,'couponid':couponid,'customer_id':customer_id, 'action' :'addSubscriptionCoupon'},
				dataType:'json',
				beforeSend: function() {
			        jQuery('.stl_ajaxloader1').css("visibility", "visible");
			    },
				success:function(response){
					// if(response['stl_status'])
					// {
						var stl_sucsmsg_coupaplysuc = jQuery(".stl_sucsmsg_coupaplysuc").val()
						toastr.options = {"closeButton": true,}
						toastr.success(stl_sucsmsg_coupaplysuc, stl_sucsmsg_success);
						setTimeout(function(){
							location.reload();
							 }, 800);
					// }
					// else
					// {
					// 	toastr.error(response['message'], stl_sucsmsg_error);
					// }
					jQuery('.stl_ajaxloader1').css("visibility", "hidden");
									
				},
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    // toastr.error('Error', stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
			});
			});
	jQuery(document).on('click','.btn_applycoupon',function(){
		var subid = jQuery(this).closest('tr').data('id');
		var cusidid = jQuery(this).closest('tr').data('cusid');
		// var couponid = jQuery(this).closest('tr').data('coupon');
		jQuery("#coupon_subid").val(subid);
		jQuery("#sub_customer_id").val(cusidid);
		jQuery("#update_coupon_modal").show();
        jQuery(".stl-modal").find('[autofocus]').focus();

	});

   	/********* subscription js end ***************/


    /*********** login register js start **********/

    jQuery.validator.addMethod("CheckMathCaptcha", function(value, element) {
        var captcha_total = jQuery(".captcha_total").val();
        var try_count = jQuery('.try_count').val() || 0;
        if(try_count>0)
        {
            if(captcha_total == value){return true;}
            else{return false;}
        }
        else
        {
            return true;
        }
        
    }, "Entered captcha input is not valid. Please enter valid captcha value");

    jQuery.validator.addMethod("CheckMathCaptchaRegister", function(value, element) {
        var captcha_total = jQuery(".captcha_total").val();
        
            if(captcha_total == value){return true;}
            else{return false;}
       
        
    }, "Entered captcha input is not valid. Please enter valid captcha value");


    jQuery(document).on('click','.stl_select_login',function(){
         var stl_lrgform = jQuery("input[name='stl_lrgform']:checked").val();
        if(stl_lrgform == 'login'){
            jQuery("#stl_loginform").show();
            jQuery("#stl_loginform").find('[autofocus]').focus();
            jQuery("#stl_regsform").hide();
        }
        else{
            jQuery("#stl_loginform").hide();
            jQuery("#stl_regsform").show();
            jQuery("#stl_regsform").find('[autofocus]').focus();
        }
    })

    var login_form1 = jQuery('#stl_loginform');
    var stl_lg_email = jQuery(".stl_lg_email").val();
    var stl_lg_password = jQuery(".stl_lg_password").val();

    login_form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            email:{
                email: true,
                required:true,
                remote : {
                    url: stl_ajaxurl,
                    type: "post",
                    data: {
                        'action': 'checkEmailalreadyexists',
                        'emailtype': 'logincheck',

                    }
                }
            },
            password:{
                required: function (element) {
                    var login_pwd = jQuery('.login_pwdrequired').val() || '';
                    if(login_pwd == ''){
                        return true;
                    }else {
                        return false;
                    }
                },
            },
            captcha_input:{
                required: function (element) {
                    var login_pwd = jQuery('.login_pwdrequired').val() || '';
                    var try_count = jQuery('.try_count').val() || '';
                    if(login_pwd == '' && try_count >=1){
                        return true;
                    }else {
                        return false;
                    }
                },
                CheckMathCaptcha: true,
            },
        },
        messages: {
            email: 
            {
                required: stl_lg_email,
                remote: 'Email id not exists. Please enter valid email id.'
            },
            
            password: stl_lg_password,  
            // captcha_input: {
            //    CheckMathCaptcha: 'Captcha value is no' 
            // }       
        },
        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },
        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },
        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },
        submitHandler: function(form) {
            var $form = jQuery(form);

            jQuery.ajax({
                url: stl_ajaxurl,
                data: $form.serialize(),
                method:'POST',
                dataType:'json',
                beforeSend: function() {
                    jQuery('.stl_ajaxloader').css("visibility", "visible");
                },
                success:function(response){
                    if(response['login_success'])
                    {
                        var login_redirect = jQuery(".login_redirect").val();
                        var rpage = jQuery(".rpage").val();
                        var actcode = jQuery(".actcode").val();
                        toastr.options = {"closeButton": true,}
                        toastr.success(response['message'], stl_sucsmsg_success);
                        setTimeout(function(){
                            window.location.href = login_redirect+"?wssm_activationcode="+actcode; 
                        }, 800);

                    }
                    else
                    {
                        jQuery(".try_count").val(response['try_count']);
                        if(response['try_count']>0)
                        {
                            jQuery(".captcha_div").show();
                        }
                        else
                        {
                            jQuery(".captcha_div").hide();
                        }
                        toastr.error(response['message'], stl_sucsmsg_error);
                    }
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                                    
                },
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
            });
            return false;
        }
    });


    var reg_form1 = jQuery('#stl_regsform');
    var stl_lg_email = jQuery(".stl_lg_email").val();
    var stl_lg_emailexit = jQuery(".stl_lg_emailexit").val();
    var stl_lg_unameexit = jQuery(".stl_lg_unameexit").val();
    var stl_lg_password = jQuery(".stl_lg_password").val();
    var stl_lg_fname = jQuery(".stl_lg_fname").val();
    var stl_lg_cnpassword = jQuery(".stl_lg_cnpassword").val();

    reg_form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            full_name:{required:true,
            // remote : {
            //         url: stl_ajaxurl,
            //         type: "post",
            //         data: {
            //             'action': 'checkEmailalreadyexists',
            //             'emailtype': 'accountunameadd',

            //         }
            //     }
            },
            email:{ 
                email: true,
                required:true,
                remote : {
                    url: stl_ajaxurl,
                    type: "post",
                    data: {
                        'action': 'checkEmailalreadyexists',
                        'emailtype': 'accountadd',

                    }
                }

            },
            password:{
                required: true,
                minlength: 8,
                maxlength: 64,
               // passwordcheck : true
            },
            confirm_password:{
                required: true,
                equalTo: '#mainpassword',
                minlength: 8,
                maxlength: 64
            },
            captcha_input:{
                required: true,
                CheckMathCaptchaRegister: true,
            },
        },
        messages: {
            email: 
            {
                required: stl_lg_email,
                remote: stl_lg_emailexit
            },
            full_name: 
            {
                required: stl_lg_fname,
                // remote: stl_lg_unameexit
            },

            password: {
                required: stl_lg_password,
                maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                minlength: jQuery.validator.format("Weak (should be atleast {0} characters.)"),
            },
            confirm_password: 
            {
                required: stl_lg_cnpassword,
                maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                minlength: jQuery.validator.format("Please enter at least {0} characters."),
            },        
        },
        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },
        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },
        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },
        submitHandler: function(form) {
            var $form = jQuery(form);

            jQuery.ajax({
                url: stl_ajaxurl,
                data: $form.serialize(),
                method:'POST',
                dataType:'json',
                beforeSend: function() {
                    jQuery('.stl_ajaxloader').css("visibility", "visible");
                },
                success:function(response){
                    // if(response['stl_status'])
                    // {
                        var reg_redirect = jQuery(".reg_redirect").val();
                        var actcode = jQuery(".actcode").val();
                        toastr.options = {"closeButton": true,}
                        toastr.success(response['message'], response['message']);
                        setTimeout(function(){
                            window.location.href = reg_redirect+"?wssm_activationcode="+actcode; 
                        }, 800);

                    // }
                    // else
                    // {
                    //     toastr.error(response['message'], stl_sucsmsg_error);
                    // }
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                                    
                },
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
            });
            return false;
        }
    });



    /*********** login register js end **********/

    /********* verification email resend start ****/

    jQuery(document).on('click','.btn_actmailresend',function(){
        // console.log("resendddddddddddd");
        var actcode = jQuery(".actcode").val() || '';
        if(actcode !='')
        {
            jQuery.ajax({
                url: stl_ajaxurl,
                data: {'actcode':actcode,'action':'resendEmailVerification'},
                method:'POST',
                dataType:'json',
                beforeSend: function() {
                    jQuery('.stl_ajaxloader').css("visibility", "visible");
                },
                success:function(response){
                    // if(response['stl_status'])
                    // {
                        var logreg_url = jQuery(".logreg_url").val();
                        toastr.options = {"closeButton": true,}
                        toastr.success(response['message'], stl_sucsmsg_success);
                        setTimeout(function(){
                            window.location.href = logreg_url;
                        }, 800);

                    // }
                    // else
                    // {
                    //     toastr.error(response['message'], stl_sucsmsg_error);
                    // }
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                                    
                },
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
            });
        }
        else
        {
            toastr.error('Error', stl_sucsmsg_error);
        }

    })
    /********* verification email resend end *********/

    /******************** additional user js start **********/
    jQuery(document).on('click','.btn_adduser',function(){
        jQuery("#additional_user_modal").show();
        jQuery(".stl-modal").find('[autofocus]').focus();
    });
    var additional_user_form = jQuery('#additional_user_form');


    additional_user_form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'stl-help-block stl-help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        messages: {              
            'full_name': {
                required: stl_lg_fname,
            },
            'email': {
                required: stl_lg_email,
                remote: stl_lg_emailexit
            },
            password: {
                required: stl_lg_password,
                maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                minlength: jQuery.validator.format("Weak (should be atleast {0} characters.)"),
            },
            confirm_password: 
            {
                required: stl_lg_cnpassword,
                maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                minlength: jQuery.validator.format("Please enter at least {0} characters."),
            }, 
        },
        rules: {
            full_name: {required: true}, 
            email: {email: true,
                required:true,
                remote : {
                    url: stl_ajaxurl,
                    type: "post",
                    data: {
                        'action': 'checkEmailalreadyexists',
                        'emailtype': 'accountadd',

                    }
                }
            }, 
            password: {
                required: function (element) {
                    var add_userid = jQuery('.additiona_user_id').val();
                    if(add_userid == ''){
                        return true;
                    }else {
                        return false;
                    }
                },
                minlength: 8,
                maxlength: 64,

                //required: true
            }, 
            confirm_password: {
                required: function (element) {
                    var add_userid = jQuery('.additiona_user_id').val();
                    if(add_userid == ''){
                        return true;
                    }else {
                        return false;
                    }
                },
                equalTo: '#mainpassword',
                minlength: 8,
                maxlength: 64
                //required: true
            }

        },

        highlight: function(element) { // hightlight error inputs
            jQuery(element).closest('.stl-form-group').addClass('stl-has-error'); // set error class to the control group
        },

        unhighlight: function(element) { // revert the change done by hightlight
            jQuery(element).closest('.stl-form-group').removeClass('stl-has-error'); // set error class to the control group
        },

        success: function(label) {
            label.closest('.stl-form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function(form,event) {
            //return false;
            var $form = jQuery(form);
            jQuery.ajax({
                url : stl_ajaxurl,
                type: 'POST',
                data: $form.serialize(),
                dataType:'json',
                beforeSend: function() {
                    jQuery('.stl_ajaxloader1').css("visibility", "visible");
                },
                success:function(response){
                    // if(response['stl_status'])
                    // {
                        toastr.options = {"closeButton": true,}
                        toastr.success(response['message'], stl_sucsmsg_success);
                        setTimeout(function(){
                            location.reload();
                        }, 800);

                    // }
                    // else
                    // {
                    //     toastr.error(response['message'], stl_sucsmsg_error);
                    // }
                    jQuery('.stl_ajaxloader1').css("visibility", "hidden");
                                    
                },
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader1').css("visibility", "hidden");
                }
            });
            return false;
        }
    });

    jQuery(document).on('click','.btn_resenduseremail',function(){
        // console.log("resendddddddddddd");

        var actcode = jQuery(this).closest('tr').data("actcode") || '';
        if(actcode !='')
        {
            jQuery.ajax({
                url: stl_ajaxurl,
                data: {'actcode':actcode,'action':'resendEmailVerification'},
                method:'POST',
                dataType:'json',
                beforeSend: function() {
                    jQuery('.stl_ajaxloader').css("visibility", "visible");
                },
                success:function(response){
                    // if(response['stl_status'])
                    // {
                        var logreg_url = jQuery(".stl_aduserurl").val();
                        toastr.options = {"closeButton": true,}
                        toastr.success(response['message'], stl_sucsmsg_success);
                        // setTimeout(function(){
                        //     window.location.href = logreg_url;
                        // }, 800);

                    // }
                    // else
                    // {
                    //     toastr.error(response['message'], stl_sucsmsg_error);
                    // }
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                                    
                },
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
            });
        }
        else
        {
            toastr.error('Error', stl_sucsmsg_error);
        }

    });

    jQuery(document).on('click','.btn_delete_user',function(){
        var user_id = jQuery(this).closest('tr').data("id") || '';
        var user_type = jQuery(this).closest('tr').data("type") || '';

        jQuery.ajax({
                url: stl_ajaxurl,
                data: {'user_id':user_id,'user_type':user_type,'action':'deleteAdditionalUser'},
                method:'POST',
                dataType:'json',
                beforeSend: function() {
                    jQuery('.stl_ajaxloader').css("visibility", "visible");
                },
                success:function(response){
                    // if(response['stl_status'])
                    // {
                        var stl_aduserurl = jQuery(".stl_aduserurl").val();
                        toastr.options = {"closeButton": true,}
                        toastr.success(response['message'], stl_sucsmsg_success);
                        setTimeout(function(){
                            window.location.href = stl_aduserurl;
                        }, 800);

                    // }
                    // else
                    // {
                    //     toastr.error(response['message'], stl_sucsmsg_error);
                    // }
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                                    
                },
                error:function(xhr, status, error)
                {
                    toastr.error( xhr.responseText, stl_sucsmsg_error);
                    jQuery('.stl_ajaxloader').css("visibility", "hidden");
                }
            });


    })
    /******************** additional user js end **********/

});



function checkPasswordStrength() {
var number = /([0-9])/;
var alphabets = /([a-zA-Z])/;
var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
if(jQuery('#mainpassword').val().length<8) {
jQuery('#password-strength-status').removeClass();
// jQuery('#password-strength-status').addClass('weak-password');
jQuery('#password-strength-status').html("");
} else {    
if(jQuery('#mainpassword').val().match(number) && jQuery('#mainpassword').val().match(alphabets) && jQuery('#mainpassword').val().match(special_characters)) {            
jQuery('#password-strength-status').removeClass();
jQuery('#password-strength-status').addClass('strong-password');
jQuery('#password-strength-status').html("Strong");
} else {
jQuery('#password-strength-status').removeClass();
jQuery('#password-strength-status').addClass('medium-password');
jQuery('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
}
}

}




