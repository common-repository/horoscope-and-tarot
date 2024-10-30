;(function($) {
    "use strict";
    // console.log('From admin js');
	var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
	var apiShortWordArr = ['cdr', 'ar', 'dct', 'ep', 'el', 'exf', 'fl', 'idl', 'kf', 'meo', 'plc', 'pl', 'dmr', 'hr', 'wr', 'ch', 'nh', 'ppf', 'ltr', 'ia', 'dp', 'cho', 'ku', 'kum', 'natal', 'transit', 'synastry'];
	var api_id_arr = ["17", "16", "18", "11", "10", "12", "9", "8", "15", "13", "24", "14", "23", "20", "22", "26", "25", "27", "21", "19", "30", "32", "40", "45", "46", "46", "46"];

	// var api_base_url = 'https://dev.divineapi.com/api/1.0/'; 
	// var domain_base_url = 'https://dev.divineapi.com'; 
	var api_base_url = 'https://divineapi.com/api/1.0/'; 
	var domain_base_url = 'https://divineapi.com'; 
	var host = window.location.host;
	var getRequesturl =  window.location.href;

    $(document).ready(function(){

			function isLocalhost(url) {
				return url.includes('localhost') || url.includes('127.0.0.1');
			}
	    // Connection
			var api_key = document.getElementById('api_key').value;

			
			$.ajax({
				url: domain_base_url+'/divines/saveDomain',
				method: 'post',
				data: {api_key: api_key, domain:host, type:'plugin'},
				success: function(data){
				}
			});

			if (api_key.length > 0) 
			{
		        var api_url = api_base_url+"wordpress_plugin_connection.php";
		        $.ajax({
		        	url: api_url,
		        	method: 'post',
		        	data: {api_key: api_key},
		        	success: function (data){
		        		var response = $.parseJSON(data);
		        		if (response.success == 1) 
		        		{
		        			$('#alert-box').html(response.message);
		        			$('#alert-box').removeClass('alert-danger'); 
		        			$('#alert-box').addClass('alert-success');
		        			if(response.trial_msg != "")
		        			{
		        				$('#alert-box').parent().prepend('<br><span class="divine__text__primary">'+response.trial_msg+'</span>');
		        			}
		                }
		                else
		                {
		        			$('#alert-box').html(response.message);
		        			$('#alert-box').parent().prepend('<br><span class="alert-info">Sign Up at Divine API to get your API Key - <a target="blank" href="https://divineapi.com">Click Here</a></span>');
		        			$('#alert-box').removeClass('alert-success'); 
		        			$('#alert-box').addClass('alert-danger');
		                }
		        	}
		        });
				
				if(!isLocalhost(getRequesturl)) {
					var subdomain = host.split('.')[0];
		
					const result2 = Array.from(set).includes(subdomain);
					if(result2) 
					{
						var sub = subdomain+'.';
						host = host.replace(sub, "");
					}
					jQuery.ajax({
						url: api_base_url+"wordpress_plugin_authorized_site.php",
						method: 'post',
						async: false,
						data: {api_key: api_key, domain: host},
						success: function(data){
							var response = jQuery.parseJSON(data);
							if (response.success == 1) 
							{
								$('#divine-site-status').html('');
								$('#divine-site-status').html('<span class="msg-success">'+response.message+'</span>');
							}
							else
							{
								$('#divine-site-status').html('');
								//$('#divine-site-status').html(response.message);
								$('#divine-site-status').html('<span class="msg-error">Your site is not authorized - <a target="blank" href="https://divineapi.com/website-authorization">Click Here</a> to authorized your site</span>');
							}
						}
					});
					
				}

				
		        
			}
			else
			{
    			$('#alert-box').html('Sign Up at Divine API to get your API Key - <a target="blank" href="https://divineapi.com">Click Here</a>');
    			$('#alert-box').removeClass('alert-danger'); 
    			$('#alert-box').addClass('alert-info');
			}
		// End Connection

		// love compatibility Sign Style
		let compat_selected_sign = $('input[type=radio][name=love_compatibility_settings_sign_field]:checked').val();
		if(compat_selected_sign == 3)
		{
	        $('#divine-lc-sign-set-1').hide();
	        $('#divine-lc-sign-set-2').hide();
			$('#divine-lc-sign-set-3').show();
		}
		else if(compat_selected_sign == 2)
		{
	        $('#divine-lc-sign-set-1').hide();
	        $('#divine-lc-sign-set-2').show();
			$('#divine-lc-sign-set-3').hide();
	    }
		else {
			$('#divine-lc-sign-set-1').show();
	        $('#divine-lc-sign-set-2').hide();
			$('#divine-lc-sign-set-3').hide();
		}

		$('input[type=radio][name=love_compatibility_settings_sign_field]').change(function() {
		    if (this.value == 3) {
				$('#divine-lc-sign-set-1').hide();
				$('#divine-lc-sign-set-2').hide();
				$('#divine-lc-sign-set-3').show();
		    }
		    else if (this.value == 2) {
				$('#divine-lc-sign-set-1').hide();
				$('#divine-lc-sign-set-2').show();
				$('#divine-lc-sign-set-3').hide();
		    }
			else if (this.value == 1) {
				$('#divine-lc-sign-set-1').show();
	        	$('#divine-lc-sign-set-2').hide();
				$('#divine-lc-sign-set-3').hide();
		    }
		});

		// Horoscope Sign Style

		let selected_sign = $('input[type=radio][name=horoscope_settings_sign_field]:checked').val();

		if(selected_sign == 3)
		{
	        $('#divine-dh-sign-set-1').hide();
	        $('#divine-dh-sign-set-2').hide();
			$('#divine-dh-sign-set-3').show();
		}
		else if(selected_sign == 2)
		{
	        $('#divine-dh-sign-set-1').hide();
	        $('#divine-dh-sign-set-2').show();
			$('#divine-dh-sign-set-3').hide();
	    }
		else {
			$('#divine-dh-sign-set-1').show();
	        $('#divine-dh-sign-set-2').hide();
			$('#divine-dh-sign-set-3').hide();
		}

		$('input[type=radio][name=horoscope_settings_sign_field]').change(function() {
		    if (this.value == 3) {
				$('#divine-dh-sign-set-1').hide();
				$('#divine-dh-sign-set-2').hide();
				$('#divine-dh-sign-set-3').show();
		    }
		    else if (this.value == 2) {
				$('#divine-dh-sign-set-1').hide();
				$('#divine-dh-sign-set-2').show();
				$('#divine-dh-sign-set-3').hide();
		    }
			else if (this.value == 1) {
				$('#divine-dh-sign-set-1').show();
	        	$('#divine-dh-sign-set-2').hide();
				$('#divine-dh-sign-set-3').hide();
		    }
		});
		// Horoscope Sign Style

		// Daily Tarot Card Style
		let selected_dt_card = $('input[type=radio][name=daily_tarot_settings_card_field]:checked').val();

		if(selected_dt_card == 1)
		{
	        $('#divine-dt-card-set-1').show();
	        $('#divine-dt-card-set-2').hide();
		}
		else
		{
	        $('#divine-dt-card-set-1').hide();
	        $('#divine-dt-card-set-2').show();
	    }

		$('input[type=radio][name=daily_tarot_settings_card_field]').change(function() {
		    if (this.value == 1) {
		        $('#divine-dt-card-set-1').show();
		        $('#divine-dt-card-set-2').hide();
		    }
		    else if (this.value == 2) {
		        $('#divine-dt-card-set-2').show();
		        $('#divine-dt-card-set-1').hide();
		    }
		});
		// Daily Tarot Card Style
	
		// Yes No Tarot Card Style
		let selected_yn_card = $('input[type=radio][name=yes_no_tarot_settings_card_field]:checked').val();

		if(selected_yn_card == 1)
		{
	        $('#divine-yn-card-set-1').show();
	        $('#divine-yn-card-set-2').hide();
		}
		else
		{
	        $('#divine-yn-card-set-1').hide();
	        $('#divine-yn-card-set-2').show();
	    }

		$('input[type=radio][name=yes_no_tarot_settings_card_field]').change(function() {
		    if (this.value == 1) {
		        $('#divine-yn-card-set-1').show();
		        $('#divine-yn-card-set-2').hide();
		    }
		    else if (this.value == 2) {
		        $('#divine-yn-card-set-2').show();
		        $('#divine-yn-card-set-1').hide();
		    }
		});
		// Yes No Tarot Card Style
		// Horoscope Status
	        $.ajax({
	        	url: api_base_url+'wordpress_plugin_api_status.php',
	        	method: 'post',
	        	data: {api_key: api_key,api_id: "1"},
	        	success: function (data){
	        		var response = $.parseJSON(data);
	    			$('#divine-dh-status').html(response.message);
	        		if (response.success == 1) 
	        		{
	        			$('#divine-dh-alert-box').html('Active');
	        			$('#divine-dh-alert-box').removeClass('alert-danger'); 
	        			$('#divine-dh-alert-box').addClass('alert-success');
	        			$('#divine-dh-status').addClass('divine__text__primary');
	                }
	                else
	                {
	        			$('#divine-dh-alert-box').html('Inactive');
	        			$('#divine-dh-alert-box').removeClass('alert-success'); 
	        			$('#divine-dh-alert-box').addClass('alert-danger');
	        			$('#divine-dh-status').addClass('divine__text__warning');
	                }
	        	}
	        });	
	    // End Horoscope Status 

		// Daily Tarot Status
	        $.ajax({
	        	url: api_base_url+'wordpress_plugin_api_status.php',
	        	method: 'post',
	        	data: {api_key: api_key, api_id: "3"},
	        	success: function (data){
	        		var response = $.parseJSON(data);
	    			$('#divine-dt-status').html(response.message);
	        		if (response.success == 1) 
	        		{
	        			$('#divine-dt-alert-box').html('Active');
	        			$('#divine-dt-alert-box').removeClass('alert-danger'); 
	        			$('#divine-dt-alert-box').addClass('alert-success');
	        			$('#divine-dt-status').addClass('divine__text__primary');
	                }
	                else
	                {
	        			$('#divine-dt-alert-box').html('Inactive');
	        			$('#divine-dt-alert-box').removeClass('alert-success'); 
	        			$('#divine-dt-alert-box').addClass('alert-danger');
	        			$('#divine-dt-status').addClass('divine__text__warning');
	                }
	        	}
	        });	
	    // End Daily Tarot Status    

		// Yes No Tarot Status
	        $.ajax({
	        	url: api_base_url+'wordpress_plugin_api_status.php',
	        	method: 'post',
	        	data: {api_key: api_key, api_id: "2"},
	        	success: function (data){
	        		var response = $.parseJSON(data);
	    			$('#divine-yn-status').html(response.message);
	        		if (response.success == 1) 
	        		{
	        			$('#divine-yn-alert-box').html('Active');
	        			$('#divine-yn-alert-box').removeClass('alert-danger'); 
	        			$('#divine-yn-alert-box').addClass('alert-success');
	        			$('#divine-yn-status').addClass('divine__text__primary');
	                }
	                else
	                {
	        			$('#divine-yn-alert-box').html('Inactive');
	        			$('#divine-yn-alert-box').removeClass('alert-success'); 
	        			$('#divine-yn-alert-box').addClass('alert-danger');
	        			$('#divine-yn-status').addClass('divine__text__warning');
	                }
	        	}
	        });	
	    // End Yes No Tarot Status 

		// Fortune Cookie Status
	        $.ajax({
	        	url: api_base_url+'wordpress_plugin_api_status.php',
	        	method: 'post',
	        	data: {api_key: api_key, api_id: "5"},
	        	success: function (data){
	        		var response = $.parseJSON(data);
	    			$('#divine-fc-status').html(response.message);
	        		if (response.success == 1) 
	        		{
	        			$('#divine-fc-alert-box').html('Active');
	        			$('#divine-fc-alert-box').removeClass('alert-danger'); 
	        			$('#divine-fc-alert-box').addClass('alert-success');
	        			$('#divine-fc-status').addClass('divine__text__primary');
	                }
	                else
	                {
	        			$('#divine-fc-alert-box').html('Inactive');
	        			$('#divine-fc-alert-box').removeClass('alert-success'); 
	        			$('#divine-fc-alert-box').addClass('alert-danger');
	        			$('#divine-fc-status').addClass('divine__text__warning');
	                }
	        	}
	        });	
	    // End Fortune Cookie Status

		// Coffee Cup Status
	        $.ajax({
	        	url: api_base_url+'wordpress_plugin_api_status.php',
	        	method: 'post',
	        	data: {api_key: api_key, api_id: "4"},
	        	success: function (data){
	        		var response = $.parseJSON(data);
	    			$('#divine-cc-status').html(response.message);
	        		if (response.success == 1) 
	        		{
	        			$('#divine-cc-alert-box').html('Active');
	        			$('#divine-cc-alert-box').removeClass('alert-danger'); 
	        			$('#divine-cc-alert-box').addClass('alert-success');
	        			$('#divine-cc-status').addClass('divine__text__primary');
	                }
	                else
	                {
	        			$('#divine-cc-alert-box').html('Inactive');
	        			$('#divine-cc-alert-box').removeClass('alert-success'); 
	        			$('#divine-cc-alert-box').addClass('alert-danger');
	        			$('#divine-cc-status').addClass('divine__text__warning');
	                }
	        	}
	        });	
	    // End Coffee Cup Status

		// Love Compatibility Status
		$.ajax({
			url: api_base_url+'wordpress_plugin_api_status.php',
			method: 'post',
			data: {api_key: api_key, api_id: "7"},
			success: function (data){
				var response = $.parseJSON(data);
				$('#divine-lc-status').html(response.message);
				if (response.success == 1) 
				{
					$('#divine-lc-alert-box').html('Active');
					$('#divine-lc-alert-box').removeClass('alert-danger'); 
					$('#divine-lc-alert-box').addClass('alert-success');
					$('#divine-lc-status').addClass('divine__text__primary');
				}
				else
				{
					$('#divine-lc-alert-box').html('Inactive');
					$('#divine-lc-alert-box').removeClass('alert-success'); 
					$('#divine-lc-alert-box').addClass('alert-danger');
					$('#divine-lc-status').addClass('divine__text__warning');
				}
			}
		});	
		for (let i=0; i< api_id_arr.length; i++) {
			$.ajax({
				url: api_base_url+'wordpress_plugin_api_status.php',
				method: 'post',
				data: {api_key: api_key, api_id: api_id_arr[i]},
				success: function (data){
					var response = $.parseJSON(data);
					$('#divine-'+apiShortWordArr[i]+'-status').html(response.message);
					if (response.success == 1) 
					{
						$('#divine-'+apiShortWordArr[i]+'-alert-box').html('Active');
						$('#divine-'+apiShortWordArr[i]+'-alert-box').removeClass('alert-danger'); 
						$('#divine-'+apiShortWordArr[i]+'-alert-box').addClass('alert-success');
						$('#divine-'+apiShortWordArr[i]+'-status').addClass('divine__text__primary');
					}
					else
					{
						$('#divine-'+apiShortWordArr[i]+'-alert-box').html('Inactive');
						$('#divine-'+apiShortWordArr[i]+'-alert-box').removeClass('alert-success'); 
						$('#divine-'+apiShortWordArr[i]+'-alert-box').addClass('alert-danger');
						$('#divine-'+apiShortWordArr[i]+'-status').addClass('divine__text__warning');
					}
				}
			});	
		}

		$( ".font_size_stt" ).focusout(function() {
			var key = jQuery(this).val();
			var id = jQuery(this).attr('id');
			var regex = /^[0-9]+$/;
			var isValid = regex.test(key);
			if (!isValid || key == 0) {
				$('#'+id).val('');
				$('#'+id+'_err').show();
			}else{
				$('#'+id+'_err').hide();
			}
		});

		//Daily Horoscope Form Validation start
		$('#submit-two').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-dh-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-dh-1_err').show();
				return false;
			} else {
				$('#frm_dh').submit();
			}
			
		});
		//Daily Horoscope Form Validation end

		//Chinese Horoscope Form Validation start
		$('#submit-twenty-five').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-ch-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-ch-1_err').show();
				return false;
			} else {
				$('#frm_ch').submit();
			}
			
		});
		//Chinese Horoscope Form Validation end

		//Numerology Horoscope Form Validation start
		$('#submit-twenty-six').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-nh-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-nh-1_err').show();
				return false;
			} else {
				$('#frm_nh').submit();
			}
			
		});
		//Numerology Horoscope Form Validation end

		//Single Tarot Form Validation start
		$('.d_single_tarot').on('click', function() {

			let frm_id = $(this).attr('frmid')
			$('.clserr').hide();
			let font_size = $('#font-size-st-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-st-1_err').show();
				return false;
			} else {
				$('#frm_'+frm_id).submit();
			}
			
		});
		//Single Tarot Form Validation end

		//Daily Tarot Form Validation start
		$('#submit-three').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-dt-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-dt-1_err').show();
				return false;
			} else {
				$('#frm_dt').submit();
			}
			
		});
		//Daily Tarot Form Validation end

		//Yes No Tarot Form Validation start
		$('#submit-four').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-ynt-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-ynt-1_err').show();
				return false;
			} else {
				$('#frm_ynt').submit();
			}
			
		});
		//Yes No Tarot Form Validation end

		//Which Animal Are You Form Validation start
		$('#submit-twenty-seven').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-way-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-way-1_err').show();
				return false;
			} else {
				$('#frm_way').submit();
			}
			
		});
		//Which Animal Are You Form Validation end

		//Fortune Cookie Form Validation start
		$('#submit-five').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-fc-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-fc-1_err').show();
				return false;
			} else {
				$('#frm_fc').submit();
			}
			
		});
		//Fortune Cookie Form Validation end

		//Coffe Cup Form Validation start
		$('#submit-six').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-cc-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-cc-1_err').show();
				return false;
			} else {
				$('#frm_cc').submit();
			}
			
		});
		//Coffee Cup Form Validation end
		
		//Love Compatibility Form Validation start
		$('#submit-seven').on('click', function() {

			$('.clserr').hide();
			let font_size = $('#font-size-lc-1').val();
			if(font_size == '' || font_size <= 0) {
				$('#font-size-lc-1_err').show();
				return false;
			} else {
				$('#frm_lc').submit();
			}
			
		});
		//Love Compatibility Form Validation end
		
    });

	// Colorpicker Horoscope
		$('#colorpicker-dh-1').ColorPicker({
			color: $('#colorpicker-dh-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-dh-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dh-2').ColorPicker({
			color: $('#colorpicker-dh-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-dh-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dh-3').ColorPicker({
			color: $('#colorpicker-dh-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-dh-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dh-bgdeflt').ColorPicker({
			color: $('#colorpicker-dh-bgdeflt').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-dh-bgdeflt').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
    // End Colorpicker Horoscope

    // Colorpicker Daily Tarot
		$('#colorpicker-dt-1').ColorPicker({
			color: $('#colorpicker-dt-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-dt-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dt-2').ColorPicker({
			color: $('#colorpicker-dt-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-dt-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dt-3').ColorPicker({
			color: $('#colorpicker-dt-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-dt-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	
		
		
		$('#colorpicker-lc-2').ColorPicker({
			color: $('#colorpicker-lc-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-lc-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	

		$('#colorpicker-lc-3').ColorPicker({
			color: $('#colorpicker-lc-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-lc-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-lc-4').ColorPicker({
			color: $('#colorpicker-lc-4').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-lc-4').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-lc-5').ColorPicker({
			color: $('#colorpicker-lc-5').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-lc-5').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-lc-6').ColorPicker({
			color: $('#colorpicker-lc-6').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-lc-6').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-lc-7').ColorPicker({
			color: $('#colorpicker-lc-7').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-lc-7').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		
	// End Colorpicker Daily Tarot

    // Colorpicker Yes No Tarot
		$('#colorpicker-yn-1').ColorPicker({
			color: $('#colorpicker-yn-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-yn-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		$('#colorpicker-yn-2').ColorPicker({
			color: $('#colorpicker-yn-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-yn-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		$('#colorpicker-yn-3').ColorPicker({
			color: $('#colorpicker-yn-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-yn-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
    // End Colorpicker Yes No Tarot

    // Fortune Cookie
		$('#colorpicker-fc-1').ColorPicker({
			color: $('#colorpicker-fc-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-fc-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	

		$('#colorpicker-fc-2').ColorPicker({
			color: $('#colorpicker-fc-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-fc-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-fc-3').ColorPicker({
			color: $('#colorpicker-fc-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-fc-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
    // End Fortune Cookie

    // Coffee Cup
		$('#colorpicker-cc-1').ColorPicker({
			color: $('#colorpicker-cc-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-cc-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-cc-2').ColorPicker({
			color: $('#colorpicker-cc-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-cc-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-cc-3').ColorPicker({
			color: $('#colorpicker-cc-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-cc-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
    // Coffee Cup

		//Single ard tarot//
		
		$('#colorpicker-'+apiShortWordArr[0]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[0]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[0]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[0]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[0]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[0]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[0]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[0]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[0]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[1]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[1]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[1]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[1]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[1]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[1]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[1]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[1]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[1]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[2]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[2]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[2]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[2]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[2]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[2]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[2]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[2]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[2]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[3]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[3]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[3]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[3]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[3]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[3]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[3]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[3]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[3]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[4]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[4]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[4]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[4]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[4]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[4]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[4]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[4]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[4]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[5]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[5]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[5]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[5]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[5]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[5]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[5]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[5]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[5]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[6]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[6]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[6]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[6]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[6]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[6]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[6]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[6]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[6]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[7]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[7]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[7]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[7]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[7]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[7]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[7]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[7]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[7]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	

		$('#colorpicker-'+apiShortWordArr[8]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[8]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[8]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[8]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[8]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[8]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[8]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[8]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[8]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	

		$('#colorpicker-'+apiShortWordArr[9]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[9]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[9]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[9]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[9]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[9]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[9]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[9]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[9]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	

		$('#colorpicker-'+apiShortWordArr[10]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[10]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[10]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[10]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[10]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[10]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[10]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[10]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[10]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	

		$('#colorpicker-'+apiShortWordArr[11]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[11]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[11]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[11]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[11]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[11]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[11]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[11]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[11]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[12]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[12]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[12]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[12]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[12]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[12]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[12]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[12]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[12]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[13]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[13]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[13]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[13]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[13]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[13]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[13]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[13]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[13]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-'+apiShortWordArr[14]+'-1').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[14]+'-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[14]+'-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[14]+'-2').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[14]+'-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[14]+'-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-'+apiShortWordArr[14]+'-3').ColorPicker({
			color: $('#colorpicker-'+apiShortWordArr[14]+'-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-'+apiShortWordArr[14]+'-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});	


		$('#colorpicker-ch-1').ColorPicker({
			color: $('#colorpicker-ch-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ch-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ch-2').ColorPicker({
			color: $('#colorpicker-ch-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ch-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ch-3').ColorPicker({
			color: $('#colorpicker-ch-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ch-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});


		$('#colorpicker-nh-1').ColorPicker({
			color: $('#colorpicker-nh-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-nh-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-nh-2').ColorPicker({
			color: $('#colorpicker-nh-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-nh-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-nh-3').ColorPicker({
			color: $('#colorpicker-nh-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-nh-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});



		$('#colorpicker-ppf-1').ColorPicker({
			color: $('#colorpicker-ppf-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ppf-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ppf-2').ColorPicker({
			color: $('#colorpicker-ppf-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ppf-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ppf-3').ColorPicker({
			color: $('#colorpicker-ppf-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ppf-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});




		$('#colorpicker-ltr-1').ColorPicker({
			color: $('#colorpicker-ltr-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ltr-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ltr-2').ColorPicker({
			color: $('#colorpicker-ltr-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ltr-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ltr-3').ColorPicker({
			color: $('#colorpicker-ltr-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ltr-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});


		$('#colorpicker-ia-1').ColorPicker({
			color: $('#colorpicker-ia-1').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ia-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ia-2').ColorPicker({
			color: $('#colorpicker-ia-2').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ia-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-ia-3').ColorPicker({
			color: $('#colorpicker-ia-3').val(),
			onChange: function (hsb, hex, rgb) {
		        $('#colorpicker-ia-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		


		$(".divine__copy").click(function () {
		    var $temp = $("<input>");
		    $("body").append($temp);
		    $temp.val($(this).attr("code")).select();
		    document.execCommand("copy");
		    $temp.remove();
		    var btn = $(this);
		    btn.addClass('divine__copy__active');
		    $(this).html('Copied');
			setTimeout(function() { 
		        btn.html('Copy');
		        btn.removeClass('divine__copy__active');
			}, 3000);    
		});

		/**
		 * Color Picker Choghadiya
		 */
		$('#colorpicker-choghadiya-0').ColorPicker({
			color: $('#colorpicker-choghadiya-0').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-0').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-1').ColorPicker({
			color: $('#colorpicker-choghadiya-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-2').ColorPicker({
			color: $('#colorpicker-choghadiya-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-3').ColorPicker({
			color: $('#colorpicker-choghadiya-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-4').ColorPicker({
			color: $('#colorpicker-choghadiya-4').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-4').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-5').ColorPicker({
			color: $('#colorpicker-choghadiya-5').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-5').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-6').ColorPicker({
			color: $('#colorpicker-choghadiya-6').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-6').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-7').ColorPicker({
			color: $('#colorpicker-choghadiya-7').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-7').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-8').ColorPicker({
			color: $('#colorpicker-choghadiya-8').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-8').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-9').ColorPicker({
			color: $('#colorpicker-choghadiya-9').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-9').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-10').ColorPicker({
			color: $('#colorpicker-choghadiya-10').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-10').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-choghadiya-11').ColorPicker({
			color: $('#colorpicker-choghadiya-11').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-choghadiya-11').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		/**
		 * ColorPicker Daily Panchang
		 */
		$('#colorpicker-dp-1').ColorPicker({
			color: $('#colorpicker-dp-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-2').ColorPicker({
			color: $('#colorpicker-dp-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-3').ColorPicker({
			color: $('#colorpicker-dp-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-4').ColorPicker({
			color: $('#colorpicker-dp-4').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-4').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-5').ColorPicker({
			color: $('#colorpicker-dp-5').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-5').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-6').ColorPicker({
			color: $('#colorpicker-dp-6').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-6').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-7').ColorPicker({
			color: $('#colorpicker-dp-7').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-7').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-8').ColorPicker({
			color: $('#colorpicker-dp-8').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-8').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-9').ColorPicker({
			color: $('#colorpicker-dp-9').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-9').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-10').ColorPicker({
			color: $('#colorpicker-dp-10').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-10').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-11').ColorPicker({
			color: $('#colorpicker-dp-11').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-11').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-12').ColorPicker({
			color: $('#colorpicker-dp-12').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-12').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-13').ColorPicker({
			color: $('#colorpicker-dp-13').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-13').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-14').ColorPicker({
			color: $('#colorpicker-dp-14').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-14').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-15').ColorPicker({
			color: $('#colorpicker-dp-15').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-15').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-16').ColorPicker({
			color: $('#colorpicker-dp-16').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-16').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-17').ColorPicker({
			color: $('#colorpicker-dp-17').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-17').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-18').ColorPicker({
			color: $('#colorpicker-dp-18').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-18').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-19').ColorPicker({
			color: $('#colorpicker-dp-19').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-19').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-21').ColorPicker({
			color: $('#colorpicker-dp-21').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-21').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-22').ColorPicker({
			color: $('#colorpicker-dp-22').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-22').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-dp-0').ColorPicker({
			color: $('#colorpicker-dp-0').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-dp-0').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-festival-0').ColorPicker({
			color: $('#colorpicker-festival-0').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-festival-0').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-festival-1').ColorPicker({
			color: $('#colorpicker-festival-1').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-festival-1').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-festival-2').ColorPicker({
			color: $('#colorpicker-festival-2').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-festival-2').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		$('#colorpicker-festival-3').ColorPicker({
			color: $('#colorpicker-festival-3').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-festival-3').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});

		//=======================================================
		//======== HOROSCOPE SHORTCODE THEME SETTINGS ===========
		//=======================================================
		let h_theme = $('#horoscope_theme_no_field').val();

		if (h_theme == 2) {
			$('.theme_options_1').css('display', 'none');
			$('.theme_options_1').closest("tr").hide();
			$('.theme_options_2').css('display', 'block');
			$('.theme_options_2').closest("tr").show();
		} else {
			$('.theme_options_2').css('display', 'none');
			$('.theme_options_2').closest("tr").hide();
			$('.theme_options_1').css('display', 'block');
			$('.theme_options_1').closest("tr").show();
		}

		$('#horoscope_theme_1').on('click', function() {
			$('.theme_options_2').css('display', 'none');
			$('.theme_options_2').closest("tr").hide();
			$('.theme_options_1').css('display', 'block');
			$('.theme_options_1').closest("tr").show();
			$(this).removeClass('w3-light-grey');
			$(this).addClass('w3-blue');
			$('#horoscope_theme_2').removeClass('w3-blue');
			$('#horoscope_theme_2').addClass('w3-light-grey');
			$('#horoscope_theme_no_field').val(1);
		});

		$('#horoscope_theme_2').on('click', function() {
			$('.theme_options_1').css('display', 'none');
			$('.theme_options_1').closest("tr").hide();
			$('.theme_options_2').css('display', 'block');
			$('.theme_options_2').closest("tr").show();
			$(this).removeClass('w3-light-grey');
			$(this).addClass('w3-blue');
			$('#horoscope_theme_1').removeClass('w3-blue');
			$('#horoscope_theme_1').addClass('w3-light-grey');
			$('#horoscope_theme_no_field').val(2);
		});

		$('input[name="horoscope_tabs_position_field"]').on('change', function() {
			let selected_position = $(this).val();
			$('.theme_2_tabs').hide();
			if (selected_position == 'top') {
				$('#theme-2-tabs-top').show();
			} else if (selected_position == 'middle') {
				$('#theme-2-tabs-middle').show();
			} else {
				$('#theme-2-tabs-bottom').show();
			}
		});

		var theme_2_button_position = $('input[name="horoscope_buttons_position_field"]:checked').val();
		var theme_2_button_type = $('input[name="horoscope_buttons_type_field"]:checked').val();
		var theme_2_button_with_icons = ($('#tabs_with_icons').prop('checked') == true) ? true: false;
		
		$('input[name="horoscope_buttons_position_field"]').on('change', function() {
			theme_2_button_position = $('input[name="horoscope_buttons_position_field"]:checked').val();
			// let button_type = $('input[name="horoscope_buttons_type_field"]').val();
			// let button_with_icons = ($('#tabs_with_icons').prop('checked') == true) ? true: false;
			if (theme_2_button_type == 'rectangle' && theme_2_button_with_icons) {
				//rectangle buttons with icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-buttons-with-icons-middle').show();
				} else {
					$('#theme-2-buttons-with-icons-bottom').show();
				}
			} else if (theme_2_button_type == 'rectangle' && !theme_2_button_with_icons) {
				//rectangle buttons without icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-buttons-middle').show();
				} else {
					$('#theme-2-buttons-bottom').show();
				}
			} else if (theme_2_button_type == 'square' && theme_2_button_with_icons) {
				//square buttons with icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-square-buttons-with-icons-middle').show();
				} else {
					$('#theme-2-square-buttons-with-icons-bottom').show();
				}
			} else if (theme_2_button_type == 'square' && !theme_2_button_with_icons) {
				//square buttons without icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-square-buttons-middle').show();
				} else {
					$('#theme-2-square-buttons-bottom').show();
				}
			} else {
				return false;
			}
		});

		$('input[name="horoscope_buttons_type_field"]').on('change', function() {
			theme_2_button_type = $('input[name="horoscope_buttons_type_field"]:checked').val();
			// let selected_position = $('input[name="horoscope_buttons_position_field"]').val();
			// let button_with_icons = ($('#tabs_with_icons').prop('checked') == true) ? true: false;
			if (theme_2_button_type == 'rectangle' && theme_2_button_with_icons) {
				//rectangle buttons with icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-buttons-with-icons-middle').show();
				} else {
					$('#theme-2-buttons-with-icons-bottom').show();
				}
			} else if (theme_2_button_type == 'rectangle' && !theme_2_button_with_icons) {
				//rectangle buttons without icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-buttons-middle').show();
				} else {
					$('#theme-2-buttons-bottom').show();
				}
			} else if (theme_2_button_type == 'square' && theme_2_button_with_icons) {
				//square buttons with icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-square-buttons-with-icons-middle').show();
				} else {
					$('#theme-2-square-buttons-with-icons-bottom').show();
				}
			} else if (theme_2_button_type == 'square' && !theme_2_button_with_icons) {
				//square buttons without icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-square-buttons-middle').show();
				} else {
					$('#theme-2-square-buttons-bottom').show();
				}
			} else {
				return false;
			}
		});

		$('#tabs_with_icons').on('click', function() {
			theme_2_button_with_icons = ($('#tabs_with_icons').prop('checked') == true) ? true: false;
			// let selected_position = $('input[name="horoscope_buttons_position_field"]').val();
			// let button_with_icons = ($('#tabs_with_icons').prop('checked') == true) ? true: false;
			if (theme_2_button_type == 'rectangle' && theme_2_button_with_icons) {
				//rectangle buttons with icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-buttons-with-icons-middle').show();
				} else {
					$('#theme-2-buttons-with-icons-bottom').show();
				}
			} else if (theme_2_button_type == 'rectangle' && !theme_2_button_with_icons) {
				//rectangle buttons without icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-buttons-middle').show();
				} else {
					$('#theme-2-buttons-bottom').show();
				}
			} else if (theme_2_button_type == 'square' && theme_2_button_with_icons) {
				//square buttons with icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-square-buttons-with-icons-middle').show();
				} else {
					$('#theme-2-square-buttons-with-icons-bottom').show();
				}
			} else if (theme_2_button_type == 'square' && !theme_2_button_with_icons) {
				//square buttons without icons
				$('.theme_2_buttons').hide();
				if (theme_2_button_position == 'middle') {
					$('#theme-2-square-buttons-middle').show();
				} else {
					$('#theme-2-square-buttons-bottom').show();
				}
			} else {
				return false;
			}
		});

		// $('input[name="horoscope_tabs_position_field"]').change();
		// $('input[name="horoscope_buttons_position_field"]').change();
		// $('input[name="horoscope_buttons_type_field"]').change();
		// $('#tabs_with_icons').click();
		
		//=======================================================
		//======== HOROSCOPE SHORTCODE THEME SETTINGS ===========
		//=======================================================

		/**
		 * Color Picker Kundali Start
		 */
		$('#colorpicker-kundali-0').ColorPicker({
			color: $('#colorpicker-kundali-0').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-kundali-0').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		/**
		 * Color Picker Kundali End
		 */

		/**
		 * Color Picker Kundali Matching Start
		 */
		$('#colorpicker-kundali-matching-0').ColorPicker({
			color: $('#colorpicker-kundali-matching-0').val(),
			onChange: function (hsb, hex, rgb) {
				$('#colorpicker-kundali-matching-0').val('#' + hex.toUpperCase());
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		/**
		 * Color Picker Kundali Matching End
		 */

})(jQuery);

function getWidgetsList(widget_name, shortcode){
	console.log(widget_name);
	let domain_base_url = 'https://divineapi.com/'; 
	let host = window.location.host;
	let api_key = document.getElementById('api_key').value;
	// console.log(domain_base_url);
	// console.log(host);
	// console.log(api_key);

	jQuery.ajax({
		url: domain_base_url+'get_widget_list/' + widget_name,
		// url: domain_base_url,
		method: 'post',
		data: {api_key: api_key, domain:host, type:'plugin'},
		success: function(data){
			data = JSON.parse(data);
			// console.log(data);
			let html = '';
			for (const property in data) {
				// console.log(`${property}: ${data[property]['name']}`);
				html += `<p><b>${data[property]['name']} Shortcode:</b> <code class="divine__shortcode">[${shortcode} setting="${data[property]['id']}"]</code><button class="divine__copy" code="[${shortcode} setting='${data[property]['id']}']">Copy</button> <button class="divine__add-btn  divine_customize_btn" data-id="${data[property]['id']}" data-widget="${widget_name}">Customize</button></p>`;
			}
			
			jQuery('#' +widget_name+'-shortcode').html(html);
			newcopy();
			editModal();
		}
	});
}
// editModal();
function editModal(){
	jQuery('.divine_customize_btn').on('click', function(){
		let data_id = jQuery(this).data('id');
		let data_widget = jQuery(this).data('widget');
		let btn_txt = jQuery(this).html();
		jQuery(this).html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i>');
		setTimeout(() => {
			jQuery(this).html(btn_txt);
		}, 1000);
		getWidgetSetting(data_widget, data_id);
	});
}

jQuery('.divine_add_btn').on('click', function(){
	let data_id = jQuery(this).data('id');
	let data_widget = jQuery(this).data('widget');
	let btn_txt = jQuery(this).html();
	jQuery(this).html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i>');
	setTimeout(() => {
		jQuery(this).html(btn_txt);
	}, 1000);
	getWidgetSetting(data_widget, data_id);
});
	
function getWidgetSetting(widget_name, widget_id){
	console.log(widget_name);
	let domain_base_url = 'https://divineapi.com/'; 
	let host = window.location.host;
	let api_key = document.getElementById('api_key').value;
	// console.log(domain_base_url);
	// console.log(host);
	// console.log(api_key);

	jQuery.ajax({
		url: domain_base_url+'get_widget_edit_modal/' + widget_name + '/' + widget_id,
		// url: domain_base_url,
		method: 'post',
		data: {api_key: api_key, domain:host, type:'plugin'},
		success: function(data){
			data = JSON.parse(data);
			// console.log(data.model);
			
			jQuery('#divine-setting-dynamic-inner').html('<div class="close">X</div>' + data.model);
			jQuery('#divine-setting-dynamic').removeClass('hide');
			
			jQuery('#divine-setting-dynamic .close').on('click', function(){
				jQuery('#divine-setting-dynamic').addClass('hide');
			});
			
		}
	});
}

function newcopy(){
	jQuery(".divine__copy").click(function () {
		var $temp = jQuery("<input>");
		jQuery("body").append($temp);
		$temp.val(jQuery(this).attr("code")).select();
		document.execCommand("copy");
		$temp.remove();
		var btn = jQuery(this);
		btn.addClass('divine__copy__active');
		jQuery(this).html('Copied');
		setTimeout(function() { 
			btn.html('Copy');
			btn.removeClass('divine__copy__active');
		}, 3000);    
	});
}

function openSection(tab_id) 
{
	if(tab_id == '34'){
		getWidgetsList('dapi-widget-natal-basic', 'divine_natal');
	}
	if(tab_id == '35'){
		getWidgetsList('dapi-widget-natal-basic-transit', 'divine_natal_transit');
	}
	if(tab_id == '36'){
		getWidgetsList('dapi-widget-natal-synastry', 'divine_natal_synastry');
	}
	var i;
	var x = document.getElementsByClassName("city");
	var active_tab = document.getElementsByClassName("w3-blue");

	active_tab[0].classList.add('w3-light-grey');
	active_tab[0].classList.remove('w3-blue');
	for (i = 0; i < x.length; i++) {
	x[i].style.display = "none";  
	}
	document.getElementById('divine-setting-btn-'+tab_id).classList.remove('w3-light-grey');
	document.getElementById('divine-setting-btn-'+tab_id).classList.add('w3-blue');
	document.getElementById('divine-setting-tab-'+tab_id).style.display = "block";  
	if(tab_id == 2 || tab_id == 25 || tab_id == 26) {
		document.getElementById('divine-setting-tab-2-1').style.display = "block";
	}
	else if(tab_id == 8 || tab_id == 3 || tab_id == 4 || tab_id == 9 || tab_id == 10 || tab_id == 11 || tab_id == 12 || tab_id == 13 || tab_id == 14 || tab_id == 15 || tab_id == 16 || tab_id == 17 || tab_id == 18 || tab_id == 19 || tab_id == 27) {
		document.getElementById('divine-setting-tab-3-1').style.display = "block";
	}
	else if(tab_id == 20 || tab_id == 21 || tab_id == 22) {
		document.getElementById('divine-setting-tab-4-1').style.display = "block";
	}
	else if(tab_id == 23 || tab_id == 24) {
		document.getElementById('divine-setting-tab-5-1').style.display = "block";
	}


	if (tab_id == '2-1') { 
		openSection(2);
	}
	else if (tab_id == '3-1') { 
		openSection(8);
	}
	else if (tab_id == '4-1') { 
		openSection(20);
	}
	else if (tab_id == '5-1') { 
		openSection(24);
	}

}