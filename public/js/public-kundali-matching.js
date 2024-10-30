var kundaliMatchingMng = {};

kundaliMatchingMng.init = ()=>{

    var kundali_matching_theme_color = dapi_admin_req.kundali_matching_theme_color;

    if (kundali_matching_theme_color.length > 0) {
        document.documentElement.style.setProperty('--kundali_matching_theme_color', kundali_matching_theme_color);
        document.documentElement.style.setProperty('--kundali_matching_theme_light_color', kundali_matching_theme_color+'19');
    }

    jQuery( ".txtOnly" ).keypress(function(e) {
        var key = e.keyCode;
        var regex = /^[A-Za-z ]+$/;
        var isValid = regex.test(String.fromCharCode(key));
        if (!isValid) {
            e.preventDefault();
        }
    });

    jQuery('.cstkmbtn').on('click', function() {

        let m_id = jQuery(this).attr('mdl');
        let cls = jQuery(this).attr('cls');

        if (m_id > 0) {

            jQuery('.cstkmbtn').removeClass('cstkmbtn-active');
            jQuery('.'+cls).addClass('cstkmbtn-active');
            jQuery('.cst-km-tab-pills').hide();
            jQuery('#km_module'+m_id).show();
            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#km_module"+m_id).offset().top
            }, 1000);

        } else {

            return false;
        
        }

    });
	
	km_verified_domain()
	.then((result) => {
		
		if (result == 1) {

			jQuery('#kundali-matching-auth').hide();
			jQuery('#kdlmfrm').show();
			jQuery('#btn-get-kmrpt').on('click', kundaliMatchingMng.get_report);

		} else {

			jQuery('#kundali-matching-auth p').html("** You can use this API key only for registerd website on divine **");
			jQuery('#kdlmfrm').hide();
			jQuery('#kundali-matching-auth').show();

		}
		
	})
	.catch((error) => {
		// Handle errors
		console.error('Error:', error);
	});

};

kundaliMatchingMng.get_report = ()=>{

    try {

        jQuery('.kmclserr').hide();
        jQuery('#btn-get-kmrpt').prop('disabled', true);
        jQuery('#btn-get-kmrpt').html('Generating Report...');
        let fname = jQuery('#kmfname1').val();
        let lname = jQuery('#kmlname1').val();
        let gender = jQuery('input[name="kmgender1"]:checked').val();
        let dob = jQuery('#kmdob1').val();
        let hour = jQuery('#kmhour1').val();
        let min = jQuery('#kmmin1').val();
        let sec = jQuery('#kmsec1').val();
        let place = jQuery('#kmplace1').val();
        let tzone = jQuery('#kmtzone1').val();
        let lat = jQuery('#kmlat1').val();
        let lon = jQuery('#kmlon1').val();
        let fname2 = jQuery('#kmfname2').val();
        let lname2 = jQuery('#kmlname2').val();
        let gender2 = jQuery('input[name="kmgender2"]:checked').val();
        let dob2 = jQuery('#kmdob2').val();
        let hour2 = jQuery('#kmhour2').val();
        let min2 = jQuery('#kmmin2').val();
        let sec2 = jQuery('#kmsec2').val();
        let place2 = jQuery('#kmplace2').val();
        let tzone2 = jQuery('#kmtzone2').val();
        let lat2 = jQuery('#kmlat2').val();
        let lon2 = jQuery('#kmlon2').val();
        let lang = jQuery('input[name="kmlang"]:checked').val();
    
        var setAjaxUrl = dapi_admin_req.ajaxurl;
        setAjaxUrl += "?action=dapi_admin_ajax_req&acttask=get_km_report&rnd="+ Math.random();

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
        form_data.append('fname2', fname2);
        form_data.append('lname2', lname2);
        form_data.append('gender2', gender2);
        form_data.append('dob2', dob2);
        form_data.append('hour2', hour2);
        form_data.append('min2', min2);
        form_data.append('sec2', sec2);
        form_data.append('place2', place2);
        form_data.append('tzone2', tzone2);
        form_data.append('lat2', lat2);
        form_data.append('lon2', lon2);
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

                    jQuery('#kdlmfrm').hide();
                    jQuery('#kndlirprt').show();
                    if (lang == 'hi') {
                        jQuery('.kndlirprt-hi').show();
                    } else {
                        jQuery('.kndlirprt').show();
                    }
                    jQuery('#kndlirprt').html(result.data);
                    kundaliMatchingMng.get_kundali_data(jQuery(".cst-km-tab-pills.active").next(".cst-km-tab-pills"));

                } else if (result.tran == 2) {

                    jQuery('#kdlmfrm').hide();
                    jQuery('#kndlirprt').show();
                    jQuery('#kndlirprt').html(result.data);

                } else {

                    jQuery.each(result.msgs, function(key, val) {

                        jQuery('#'+key+'_err').html(val);
                        jQuery('#'+key+'_err').show();
                        
                    });

                }

                jQuery('#btn-get-kmrpt').prop('disabled', false);
                jQuery('#btn-get-kmrpt').html('Get Report');

            },
            error: function (jqXHR, textStatus, errorThrown) {

                jQuery('#btn-get-kmrpt').prop('disabled', false);
                jQuery('#btn-get-kmrpt').html('Get Report');
                console.log('Error in get kundali matching report async req.');

            }
        });

    } catch(e) {

        jQuery('#btn-get-kmrpt').prop('disabled', false);
                jQuery('#btn-get-kmrpt').html('Get Report');
        console.log('Error in get kundali matching report');

    }

};

kundaliMatchingMng.get_kundali_data = thiss=>{

    try {

        let fname = jQuery('#kmfname1').val();
        let lname = jQuery('#kmlname1').val();
        let gender = jQuery('input[name="kmgender1"]:checked').val();
        let dob = jQuery('#kmdob1').val();
        let hour = jQuery('#kmhour1').val();
        let min = jQuery('#kmmin1').val();
        let sec = jQuery('#kmsec1').val();
        let place = jQuery('#kmplace1').val();
        let tzone = jQuery('#kmtzone1').val();
        let lat = jQuery('#kmlat1').val();
        let lon = jQuery('#kmlon1').val();
        let fname2 = jQuery('#kmfname2').val();
        let lname2 = jQuery('#kmlname2').val();
        let gender2 = jQuery('input[name="kmgender2"]:checked').val();
        let dob2 = jQuery('#kmdob2').val();
        let hour2 = jQuery('#kmhour2').val();
        let min2 = jQuery('#kmmin2').val();
        let sec2 = jQuery('#kmsec2').val();
        let place2 = jQuery('#kmplace2').val();
        let tzone2 = jQuery('#kmtzone2').val();
        let lat2 = jQuery('#kmlat2').val();
        let lon2 = jQuery('#kmlon2').val();
        let lang = jQuery('input[name="kmlang"]:checked').val();

        var setAjaxUrl = dapi_admin_req.ajaxurl;
        setAjaxUrl += "?action=dapi_admin_ajax_req&acttask=get_kundali_matching_data&rnd="+ Math.random();

        if(thiss.hasClass("loaded") === true){
            return false;
        }
        if(thiss.hasClass("loading") === true){
            return false;
        }

        var km_module = thiss.attr("data-attr");

        var form_data = new FormData();
        form_data.append('km_module', km_module);
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
        form_data.append('fname2', fname2);
        form_data.append('lname2', lname2);
        form_data.append('gender2', gender2);
        form_data.append('dob2', dob2);
        form_data.append('hour2', hour2);
        form_data.append('min2', min2);
        form_data.append('sec2', sec2);
        form_data.append('place2', place2);
        form_data.append('tzone2', tzone2);
        form_data.append('lat2', lat2);
        form_data.append('lon2', lon2);
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
                    } else {
                        thiss.removeClass("loading");
                        thiss.addClass("loaded show active");
                        jQuery('.'+cls).hide();
                        thiss.html(`<div class="divine_auth_domain_response mt-20">
                                        <p style="color: red !important;text-align:center !important;">` + result.msg + `</p>
                                    </div>`);
                        // thiss.hide();
                    }
                                      
                    if (thiss.next(".cst-km-tab-pills").length == 1) {
                        kundaliMatchingMng.get_kundali_data(thiss.next(".cst-km-tab-pills"));
                    }

                } catch (e) {
                    console.log('Error in get kundali matching data: ' + e);
                } 

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error in kundali matching data async req. ');
            }
        });

    } catch (e) {
        console.log('Error in get kundali matching data: ' + e);
    }

};

kundaliMatchingMng.initmap = ()=>{

    const dp_elevator = new google.maps.ElevationService();
    let input = document.getElementById("kmplace1");
    let autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener("place_changed", function() {
        let place = autocomplete.getPlace();
        jQuery('#kmtzone1').val((place.utc_offset_minutes / 60));
        document.getElementById("kmplace1").value = place.formatted_address;
        kundaliMatchingMng.disp_loc_elev(place.geometry.location, dp_elevator);
    });

    let input2 = document.getElementById("kmplace2");
    let autocomplete2 = new google.maps.places.Autocomplete(input2);
    autocomplete2.addListener("place_changed", function() {
        let place = autocomplete2.getPlace();
        jQuery('#kmtzone2').val((place.utc_offset_minutes / 60));
        document.getElementById("kmplace2").value = place.formatted_address;
        kundaliMatchingMng.disp_loc_elev2(place.geometry.location, dp_elevator);
    });

};

kundaliMatchingMng.disp_loc_elev = (location,elevator)=>{

    elevator.getElevationForLocations({
        locations: [location],
    }).then(({ results }) => {
        jQuery('#kmlat1').val(results[0].location.lat());
        jQuery('#kmlon1').val(results[0].location.lng());
    }).catch((e) =>
        console.log("Elevation service failed due to: " + e)
    );

};

kundaliMatchingMng.disp_loc_elev2 = (location,elevator)=>{

    elevator.getElevationForLocations({
        locations: [location],
    }).then(({ results }) => {
        jQuery('#kmlat2').val(results[0].location.lat());
        jQuery('#kmlon2').val(results[0].location.lng());
    }).catch((e) =>
        console.log("Elevation service failed due to: " + e)
    );

};

kundaliMatchingMng.is_localhost = url=>{

    return url.includes('localhost') || url.includes('127.0.0.1');

};

async function km_verified_domain() {
			
	try {

		var verResponse = 0;
		var getRequesturl =  window.location.href;
		var getRequesthost = window.location.host;
		var set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
        jQuery('#kmsec1').val('0');
        jQuery('#kmsec2').val('0');

		if (!kundaliMatchingMng.is_localhost(getRequesturl)) {

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