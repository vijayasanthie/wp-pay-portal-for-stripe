jQuery(document).ready(function(){
	var utils_jsfile = jQuery(".utils_jsfile").val();
	var customer_id = jQuery(".customer_id").val() || '';
	console.log(customer_id);
	if(customer_id !='')
	{

		var input1 = document.querySelector(".phone_formated");
		window.intlTelInput(input1, {
			allowDropdown: false,
			autoHideDialCode: false,
		  utilsScript: "",
		});
	}

	var input = document.querySelector("#phone_format");
	window.intlTelInput(input, {
	    hiddenInput: "phone",
	    utilsScript: utils_jsfile,
	});
});