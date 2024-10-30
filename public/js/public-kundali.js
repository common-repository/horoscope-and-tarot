var kundaliMng = {};

kundaliMng.init = ()=>{

    var kundali_theme_color = dapi_admin_req.kundali_theme_color;

    if (kundali_theme_color.length > 0) {
        document.documentElement.style.setProperty('--kundali_theme_color', kundali_theme_color);
        document.documentElement.style.setProperty('--kundali_theme_light_color', kundali_theme_color+'19');
    }

    jQuery( ".txtOnly" ).keypress(function(e) {
        var key = e.keyCode;
        var regex = /^[A-Za-z ]+$/;
        var isValid = regex.test(String.fromCharCode(key));
        if (!isValid) {
            e.preventDefault();
        }
    });

    jQuery('.cstkbtn').on('click', function() {

        let m_id = jQuery(this).attr('mdl');
        let cls = jQuery(this).attr('cls');

        if (m_id > 0) {

            jQuery('.cstkbtn').removeClass('cstkbtn-active');
            jQuery('.'+cls).addClass('cstkbtn-active');
            jQuery('.cst-tab-pills').hide();
            jQuery('#module'+m_id).show();
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#module"+m_id).offset().top
            }, 1000);

        } else {

            return false;
        
        }

    });

// 	let is_verfied = kundaliMng.verified_domain();
// 	console.log('test ' + is_verfied);
//     if (is_verfied == 1) {

//         jQuery('#kundali-auth').hide();
//         jQuery('#kdlfrm').show();
//         jQuery('#btn-get-krpt').on('click', kundaliMng.get_report);
        
//     } else {

//         jQuery('#kundali-auth p').html("** You can use this API key only for registerd website on divine **");
//         jQuery('#kdlfrm').hide();
//         jQuery('#kundali-auth').show();

//     }
	
	k_verified_domain()
	.then((result) => {
		
		if (result == 1) {

			jQuery('#kundali-auth').hide();
			jQuery('#kdlfrm').show();
			jQuery('#btn-get-krpt').on('click', kundaliMng.get_report);

		} else {

			jQuery('#kundali-auth p').html("** You can use this API key only for registerd website on divine **");
			jQuery('#kdlfrm').hide();
			jQuery('#kundali-auth').show();

		}
		
	})
	.catch((error) => {
		// Handle errors
		console.error('Error:', error);
	});

};

kundaliMng.get_report = ()=>{

    try {

        jQuery('.kclserr').hide();
        jQuery('#btn-get-krpt').prop('disabled', true);
        jQuery('#btn-get-krpt').html('Generating Report...');
        let fname = jQuery('#kfname').val();
        let lname = jQuery('#klname').val();
        let gender = jQuery('input[name="kgender"]:checked').val();
        let dob = jQuery('#kdob').val();
        let hour = jQuery('#khour').val();
        let min = jQuery('#kmin').val();
        let sec = jQuery('#ksec').val();
        let place = jQuery('#kplace').val();
        let tzone = jQuery('#ktzone').val();
        let lat = jQuery('#klat').val();
        let lon = jQuery('#klon').val();
        let lang = jQuery('input[name="klang"]:checked').val();
    
        var setAjaxUrl = dapi_admin_req.ajaxurl;
        setAjaxUrl += "?action=dapi_admin_ajax_req&acttask=get_report&rnd="+ Math.random();

        var form_data = new FormData();
        form_data.append('fname', fname);
        form_data.append('lname', lname);
        form_data.append('gender', gender);
        form_data.append('dob', dob);
        form_data.append('hour', hour);
        form_data.append('min', min);
        form_data.append('sec', sec);
        form_data.append('place', place);
        form_data.append('tzone', tzone);
        form_data.append('lat', lat);
        form_data.append('lon', lon);
        form_data.append('lang', lang);

        jQuery.ajax({
            url: setAjaxUrl,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            // dataType: 'json',
            success: function (result) {

                result = JSON.parse(result);
                if (result.tran == 1) {

                    jQuery('#kdlfrm').hide();
                    jQuery('#kndlirprt').show();
                    if (lang == 'hi') {
                        jQuery('.kndlirprt-hi').show();
                    } else {
                        jQuery('.kndlirprt').show();
                    }
                    jQuery('#kndlirprt').html(result.data);
                    kundaliMng.get_kundali_data(jQuery(".cst-tab-pills.active").next(".cst-tab-pills"));

                } else if (result.tran == 2) {

                    jQuery('#kdlfrm').hide();
                    jQuery('#kndlirprt').show();
                    jQuery('#kndlirprt').html(result.data);

                } else {

                    jQuery.each(result.msgs, function(key, val) {

                        jQuery('#'+key+'_err').html(val);
                        jQuery('#'+key+'_err').show();
                        
                    });

                }

                jQuery('#btn-get-krpt').prop('disabled', false);
                jQuery('#btn-get-krpt').html('Get Report');

            },
            error: function (jqXHR, textStatus, errorThrown) {

                jQuery('#btn-get-krpt').prop('disabled', false);
                jQuery('#btn-get-krpt').html('Get Report');
                console.log('Error in get report async req.');

            }
        });

    } catch(e) {

        jQuery('#btn-get-krpt').prop('disabled', false);
                jQuery('#btn-get-krpt').html('Get Report');
        console.log('Error in get report');

    }

};

kundaliMng.get_kundali_data = thiss=>{

    try {

        let fname = jQuery('#kfname').val();
        let lname = jQuery('#klname').val();
        let gender = jQuery('input[name="kgender"]:checked').val();
        let dob = jQuery('#kdob').val();
        let hour = jQuery('#khour').val();
        let min = jQuery('#kmin').val();
        let sec = jQuery('#ksec').val();
        let place = jQuery('#kplace').val();
        let tzone = jQuery('#ktzone').val();
        let lat = jQuery('#klat').val();
        let lon = jQuery('#klon').val();
        let lang = jQuery('input[name="klang"]:checked').val();

        var setAjaxUrl = dapi_admin_req.ajaxurl;
        setAjaxUrl += "?action=dapi_admin_ajax_req&acttask=get_kundali_data&rnd="+ Math.random();

        if(thiss.hasClass("loaded") === true){
            return false;
        }
        if(thiss.hasClass("loading") === true){
            return false;
        }

        var module = thiss.attr("data-attr");

        var form_data = new FormData();
        form_data.append('module', module);
        form_data.append('fname', fname);
        form_data.append('lname', lname);
        form_data.append('gender', gender);
        form_data.append('dob', dob);
        form_data.append('hour', hour);
        form_data.append('min', min);
        form_data.append('sec', sec);
        form_data.append('place', place);
        form_data.append('tzone', tzone);
        form_data.append('lat', lat);
        form_data.append('lon', lon);
        form_data.append('lang', lang);

        jQuery.ajax({
            url: setAjaxUrl,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            // dataType: 'json',
            beforeSend: function(){
                thiss.addClass("loading");
			},
            success: function (result) {

                try {

                    result = JSON.parse(result);
                    let cls = thiss.attr('cls');

                    if (result.tran == 1) {
                        thiss.removeClass("loading");
                        thiss.addClass("loaded show active");
                        thiss.html(result.data);
                        if (cls == 'k-vims-dsha19') {
                            jQuery('.k-vims-dsha9').hide();
                            jQuery('#module9').hide();
                        }
                    } else {
                        thiss.removeClass("loading");
                        thiss.addClass("loaded show active");
                        jQuery('.'+cls).hide();
                        thiss.html(`<div class="divine_auth_domain_response mt-20">
                                        <p style="color: red !important;text-align:center !important;">` + result.msg + `</p>
                                    </div>`);
                        // thiss.hide();
                    }
                                      
                    if (thiss.next(".cst-tab-pills").length == 1) {
                        kundaliMng.get_kundali_data(thiss.next(".cst-tab-pills"));
                    }

                } catch (e) {
                    console.log('Error in get kundali data: ' + e);
                } 

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error in kundali data async req. ');
            }
        });

    } catch (e) {
        console.log('Error in get kundali data: ' + e);
    }

};

kundaliMng.initmap = ()=>{

    const dp_elevator = new google.maps.ElevationService();
    let input = document.getElementById("kplace");
    let autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener("place_changed", function() {
        let place = autocomplete.getPlace();
        jQuery('#ktzone').val((place.utc_offset_minutes / 60));
        document.getElementById("kplace").value = place.formatted_address;
        kundaliMng.disp_loc_elev(place.geometry.location, dp_elevator);
    });

};

kundaliMng.disp_loc_elev = (location,elevator)=>{

    elevator.getElevationForLocations({
        locations: [location],
    }).then(({ results }) => {
        jQuery('#klat').val(results[0].location.lat());
        jQuery('#klon').val(results[0].location.lng());
    }).catch((e) =>
        console.log("Elevation service failed due to: " + e)
    );

};

kundaliMng.is_localhost = url=>{

    return url.includes('localhost') || url.includes('127.0.0.1');

};

async function k_verified_domain() {
			
	try {

		var verResponse = 0;
		var getRequesturl =  window.location.href;
		var getRequesthost = window.location.host;
		var set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
        jQuery('#ksec').val('0');
		if (!kundaliMng.is_localhost(getRequesturl)) {

			var subdomain = getRequesthost.split('.')[0];
			const result2 = Array.from(set).includes(subdomain);

			if (result2) {

				var sub = subdomain+'.';
				getRequesthost = getRequesthost.replace(sub, "");

			}

			var setAjaxUrl = dapi_admin_req.ajaxurl;
			setAjaxUrl += "?action=dapi_admin_ajax_req&acttask=verify_domain&rnd="+ Math.random();

			var form_data = new FormData();
			form_data.append('domain', getRequesthost);

			var resp = await jQuery.ajax({
				url: setAjaxUrl,
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
			});

			var ret_resp = jQuery.parseJSON(resp);

			if (ret_resp.status == 1) {
				return ret_resp.data.success;
			} else {
				return 0;
			}

		} else {

			return 1;

		}

	} catch(e) {

		console.log('Error in verified domain');
		return 0;

	}
		
}