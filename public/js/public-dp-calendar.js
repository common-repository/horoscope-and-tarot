(function($) {
    "use strict";
    
    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var api_key =            dp_options.api_key;
    var access_token =       dp_options.access_token;
    var timezone =           dp_options.timezone;
    var lat =                dp_options.lat;
    var lon =                dp_options.lon;
    var widget_date_prev =   '';
    var background_color = dp_options.background_color;
    var other_calendar_and_epoch_section_color = dp_options.other_calendar_and_epoch_section_color;
    var other_calendar_and_epoch_label_color = dp_options.other_calendar_and_epoch_label_color;

    var plgn_base_url = dp_options.plgn_base_url;
    var day_type = 'current';
    var selected_location = '';
    // let dp_color_text =      dp_options.color_text;
    // let dp_font_size =      dp_options.font_size;
    // let dp_color_theme =     dp_options.color_theme;
    // let dp_color_category =  dp_options.color_category;

    api_key = atob(dp_options.api_key);
    access_token = atob(dp_options.access_token);

    access_token = "Bearer " + access_token;

    if (background_color.length > 0) 
    {
        document.documentElement.style.setProperty('--background_color', background_color);
    }

    if (other_calendar_and_epoch_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--other_calendar_and_epoch_label_color', other_calendar_and_epoch_label_color);
    }

    if (other_calendar_and_epoch_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--other_calendar_and_epoch_section_color', other_calendar_and_epoch_section_color);
    }

    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapEpoch', function() {
            //     // alert('Load was performed.');
                
            // });
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMapEpoch();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapEpoch();
            //     });
            // }
            selected_location = $('#dapi-location-epoch').val();
            $('#dapi-location-epoch').on('focusout', function(){
                if($('#dapi-location-epoch').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-epoch').val(get_current_date());


            $('.dapi-dbtns-epoch').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-epoch').val();
                widget_date = (widget_date.length > 0) ? widget_date : get_current_date();

                if (day_type != 'current') {
                    if(day_type == 'prev') {
                        widget_date = getPreviousDay(new Date(widget_date));
                    } else {
                        widget_date = getNextDay(new Date(widget_date));
                    }
                } else {
                    widget_date = get_current_date();
                }
                $('#wdate-epoch').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-epoch').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-epoch').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location-epoch').on('click', function(){
                selected_location = $('#dapi-location-epoch').val();

                $('#dapi-location-epoch').val('');

            });

            $('#dapi-location-epoch').on('focusout', function() {

                $('#dapi-location-epoch').val(selected_location);

            });

            get_all_data(lat, lon, timezone);

        }
        else {
            $('#panchang-auth p').html("** You can use this API key only for registerd website on divine **");
            $('.dapi-sec-panchang').hide();
        }

        
    });

    function isLocalhost(url) {
        return url.includes('localhost') || url.includes('127.0.0.1');
    }
    
    function verified_domain(api_key) {
        var verResponse = 0;
        var getRequesturl =  window.location.href;
        var getRequesthost = window.location.host;
        if(!isLocalhost(getRequesturl)) {
            var subdomain = getRequesthost.split('.')[0];

            const result2 = Array.from(set).includes(subdomain);
            if(result2) 
            {
                var sub = subdomain+'.';

                getRequesthost = getRequesthost.replace(sub, "");
            }
            jQuery.ajax({
                url: ajaxUrl,
                method: 'post',
                async: false,
                data: {api_key: api_key, domain: getRequesthost},
                success: function(data){
                    var response = jQuery.parseJSON(data);
                    verResponse = response.success;
                }
            });
            return verResponse;
        }else{
            return true;
        }
    }

    function get_sunrise_and_moonrise(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac1').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr1"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-2.divineapi.com/indian-api/v1/find-sun-and-moon',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        let result = response.data;
                        
                        let sunrise = result.sunrise;
                        let sunrise_data = sunrise.split(" ");
                        let sunrise_time = sunrise_data[0];
                        let sunrise_ampm = sunrise_data[1];

                        let sunset = result.sunset;
                        let sunset_data = sunset.split(" ");
                        let sunset_time = sunset_data[0];
                        let sunset_ampm = sunset_data[1];

                        let moonrise = result.moonrise;
                        let moonrise_data = moonrise.split(" ");
                        let moonrise_time = moonrise_data[0];
                        let weekday = result.weekday;

                        let moonrise_ampm = moonrise_data[1];
                        if (typeof(moonrise_data[2]) != 'undefined' && moonrise_data[2].length > 0) {
                            moonrise_ampm += ' ' + moonrise_data[2];
                        } 
                        if (typeof(moonrise_data[3]) != 'undefined' && moonrise_data[3].length > 0) {
                            moonrise_ampm += ' ' + moonrise_data[3];
                        }

                        let moonset = result.moonset;
                        let moonset_data = moonset.split(" ");
                        let moonset_time = (typeof(moonset_data[0]) != 'undefined') ? moonset_data[0] : '';
                        let moonset_ampm = (typeof(moonset_data[1]) != 'undefined') ? moonset_data[1] : '';

                        // $('#divine__dh__overlay').hide();
                        
                        let sun_moon_html_new = `<div class="divine-row dapi-row">
                                <div class="dapi-col-6 dapi-custom">
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Sunrise</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/sun-moon/sunrise.svg"/>`+sunrise_time+` <span class="dapi-bold">`+sunrise_ampm+`</span></p>
                                    
                                        </div>
                                    </div>
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Sunset</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/sun-moon/sunset.svg"/>`+sunset_time+` <span class="dapi-bold">`+sunset_ampm+`</span></p>
                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="dapi-col-6 dapi-custom">
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Moonrise</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/sun-moon/moonrise.svg"/>`+moonrise_time+` <span class="dapi-bold">`+moonrise_ampm+`</span></p>
                                    
                                        </div>
                                    </div>
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Moonset</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/sun-moon/moonset.svg"/>`+moonset+`</span></p>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        

                        let sun_moon_html = '<div class="divine-row dapi-row divine-row-pdd">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Sunrise</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/sun-moon/sunrise.svg"/>'+sunrise_time+' <span class="dapi-bold">'+sunrise_ampm+'</span></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Sunset</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/sun-moon/sunset.svg"/>'+sunset_time+' <span class="dapi-bold">'+sunset_ampm+'</span></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Moonrise</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/sun-moon/moonrise.svg"/>'+moonrise_time+' <span class="dapi-bold">'+moonrise_ampm+'</span></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Moonset</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    // +'<p class="dapi-p">'+moonset_time+' <span class="dapi-bold">'+moonset_ampm+'</span></p>'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/sun-moon/moonset.svg"/>'+moonset+'</span></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd">'

                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Weekday</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7">'
                                    +'<p class="dapi-p">'+weekday+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    // +'<p class="dapi_sub_ttl_1">Weekday</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7">'
                                    // +'<p class="dapi-p">PENDING</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'</div>';

                        $('#dapiac1').html(sun_moon_html);
                        handle_acordian('dapiac1');

                    } else {
                        $('#dapiac1').html('<p class="text-danger">Something went wrong while fetching sunrise and moonrise details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get sunrise and moonrise: ' + e);

        }

    }

    function get_panchang(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac2').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr2"></div></div></div>');
            $('#dapiac4').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr4"></div></div></div>');
          
            $.ajax({
                url: 'https://astroapi-1.divineapi.com/indian-api/v1/find-panchang',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {

                        if (show_rashi_and_nakshatra_section == 'on') {

                            get_rashi_and_nakshatra(response, widget_day, widget_month, widget_year);

                        }
                        
                        let selected_date = widget_day+'/'+widget_month+'/'+widget_year;

                        let panchang_res_data = response.data;

                        let nakshatras = panchang_res_data.nakshatras.nakshatra_list;
                        let tithis = panchang_res_data.tithis;

                        let rows;
                        if (nakshatras.length > tithis.length) {
                            rows = nakshatras.length;
                        } else if (tithis.length > 0) {
                            rows = tithis.length;
                        } else {
                            rows = nakshatras.length;
                        }

                        //tithis
                        let tithi_one_ends_at = convert_date_to_hours_mins_ampm(tithis[0].end_time);
                        tithi_one_ends_at = tithi_one_ends_at.split(" ");
                        let tithi_one_end = convert_date_in_d_m_y_format(tithis[0].end_time); 
                        let tithi_one_end_content = convert_date_in_d_M_format(tithis[0].end_time);
                        let tithi_one_end_date = (selected_date != tithi_one_end) ? ', ' + tithi_one_end_content : '';
                        let tithi_paksha = tithis[0].paksha + ' Paksha';
                        let paksha = tithis[0].paksha;

                        let tithi_two_ends_at = convert_date_to_hours_mins_ampm(tithis[1].end_time);
                        tithi_two_ends_at = tithi_two_ends_at.split(" ");
                        let tithi_two_end = convert_date_in_d_m_y_format(tithis[1].end_time); 
                        let tithi_two_end_content = convert_date_in_d_M_format(tithis[1].end_time);
                        let tithi_two_end_date = (selected_date != tithi_two_end && tithi_two_end.length > 0) ? ', ' + tithi_two_end_content : '';
                        let tithi_two_end_text = (rows == 3 && tithis[2] !== null) ? 'upto '+tithi_two_ends_at[0]+' <span class="dapi-bold">'+tithi_two_ends_at[1]+'</span>' + tithi_two_end_date : '';

                        let tithi_three = (typeof(tithis[2]) != "undefined" && tithis[2] != null) ? tithis[2].tithi : '';

                        //nakshatras
                        let nakshatra_one_ends_at = new Array();
                        let nakshatra_one_end, nakshatra_one_end_content, nakshatra_one_end_date;
                        if (nakshatras[0].end_time != '') {
                            nakshatra_one_ends_at = convert_date_to_hours_mins_ampm(nakshatras[0].end_time);
                            nakshatra_one_ends_at = nakshatra_one_ends_at.split(" ");
                            nakshatra_one_end = convert_date_in_d_m_y_format(nakshatras[0].end_time);
                            nakshatra_one_end_content = convert_date_in_d_M_format(nakshatras[0].end_time);
                            nakshatra_one_end_date = (selected_date != nakshatra_one_end) ? ', ' + nakshatra_one_end_content : '';
                        } else {
                            nakshatra_one_ends_at[0] = 'Full Night';
                            nakshatra_one_ends_at[1] = '';
                            nakshatra_one_end_date = '';
                        }
                        
                        let nakshatra_two_ends_at = '';
                        let nakshatra_two_end = '';
                        let nakshatra_two_end_content =  '';
                        let nakshatra_two_end_date = '';
                        let nakshatra_two_end_text = '';
                        if (typeof(nakshatras[1]) != 'undefined') {
                            nakshatra_two_ends_at = convert_date_to_hours_mins_ampm(nakshatras[1].end_time); //date('h:i A', strtotime($nakshatras[1]->end_time));
                            nakshatra_two_ends_at = nakshatra_two_ends_at.split(" ");
                            nakshatra_two_end = convert_date_in_d_m_y_format(nakshatras[1].end_time);
                            nakshatra_two_end_content = convert_date_in_d_M_format(nakshatras[1].end_time);
                            nakshatra_two_end_date = (selected_date != nakshatra_two_end && nakshatra_two_end.length > 0) ? ', ' + nakshatra_two_end_content : '';
                            nakshatra_two_end_text = (rows == 3 && typeof(nakshatras[2]) != "undefined" && nakshatras[2] != null) ? 'upto '+nakshatra_two_ends_at[0]+' <span class="dapi-bold">'+nakshatra_two_ends_at[1]+'</span>' + nakshatra_two_end_date : '';
                        }

                        let nakshatra_three = (typeof(nakshatras[2]) != "undefined" && nakshatras[2] != null) ? nakshatras[2].nak_name : '';

                        let tithi_third_row_show = (rows > 2) ? true : false;

                        let yogas = panchang_res_data.yogas;
                        let karnas = panchang_res_data.karnas;

                        let yoga_karna_rows;
                        if (karnas.length > yogas.length) {
                            yoga_karna_rows = karnas.length;
                        } else if (yogas.length > 0) {
                            yoga_karna_rows = yogas.length;
                        } else {
                            yoga_karna_rows = karnas.length;
                        }

                        //yogas
                        let yoga_one_ends_at = convert_date_to_hours_mins_ampm(yogas[0].end_time); 
                        yoga_one_ends_at = yoga_one_ends_at.split(" ");
                        let yoga_one_end = convert_date_in_d_m_y_format(yogas[0].end_time);
                        let yoga_one_end_content = convert_date_in_d_M_format(yogas[0].end_time);
                        let yoga_one_end_date = (selected_date != yoga_one_end) ? ', ' + yoga_one_end_content : '';
                        
                        let yoga_two_ends_at = convert_date_to_hours_mins_ampm(yogas[1].end_time); 
                        yoga_two_ends_at = yoga_two_ends_at.split(" ");
                        let yoga_two_end = convert_date_in_d_m_y_format(yogas[1].end_time);
                        let yoga_two_end_content = convert_date_in_d_M_format(yogas[1].end_time);
                        let yoga_two_end_date = (selected_date != yoga_two_end && yoga_two_end.length > 0) ? ', ' + yoga_two_end_content : '';
                        let yoga_two_end_text = (yoga_karna_rows == 3 && typeof(yogas[2]) != "undefined" &&  yogas[2] != null) ? 'upto '+yoga_two_ends_at[0]+' <span class="dapi-bold">'+yoga_two_ends_at[1]+'</span>' + yoga_two_end_date : '';

                        let yoga_three = (typeof(yogas[2]) != "undefined" && yogas[2] != null) ? yogas[2].yoga_name : '';

                        //karnas
                        let karna_one_ends_at = convert_date_to_hours_mins_ampm(karnas[0].end_time); 
                        karna_one_ends_at = karna_one_ends_at.split(" ");
                        let karna_one_end = convert_date_in_d_m_y_format(karnas[0].end_time);
                        let karna_one_end_content = convert_date_in_d_M_format(karnas[0].end_time);
                        let karna_one_end_date = (selected_date != karna_one_end) ? ', ' + karna_one_end_content : '';
                        
                        let karna_two_ends_at = convert_date_to_hours_mins_ampm(karnas[1].end_time); 
                        karna_two_ends_at = karna_two_ends_at.split(" ");
                        let karna_two_end = convert_date_in_d_m_y_format(karnas[1].end_time);
                        let karna_two_end_content = convert_date_in_d_M_format(karnas[1].end_time);
                        let karna_two_end_date = (selected_date != karna_two_end && karna_two_end.length > 0) ? ', ' + karna_two_end_content : '';
                        let karna_two_end_text = (yoga_karna_rows == 3 && typeof(karnas[2]) != "undefined" && karnas[2] != null) ? 'upto '+karna_two_ends_at[0]+' <span class="dapi-bold">'+karna_two_ends_at[1]+'</span>' + karna_two_end_date : '';

                        let karna_three = (typeof(karnas[2]) != "undefined" && karnas[2] !== null) ? karnas[2].karana_name : '';

                        let yoga_third_row_style = (yoga_karna_rows > 2) ? '' : 'style="display:none;"';

                        let tithis_html = `<div class="divine-row dapi-row sec-panchang">
                                <div class="dapi-col-5 dapi-col">
                                    <p class="dapi_sub_ttl_1">Tithi</p>
                            
                                </div>
                                <div class="dapi-col-7 dapi-col">
                                    <p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/`+paksha+`-tithis/`+tithis[0].tithi.toLowerCase()+`.svg"/>`+tithis[0].tithi+`</span> upto `+tithi_one_ends_at[0]+` <span class="dapi-bold">`+tithi_one_ends_at[1]+`</span>`+tithi_one_end_date+`</p>

                                </div>
                            </div>`;
    let panchang_html_new = `<div class="divine-row dapi-row">
                                <div class="dapi-col-6 dapi-custom">
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Tithi</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/`+paksha+`-tithis/`+tithis[0].tithi.toLowerCase()+`.svg"/>`+tithis[0].tithi+`</span> upto `+tithi_one_ends_at[0]+` <span class="dapi-bold">`+tithi_one_ends_at[1]+`</span>`+tithi_one_end_date+`</p>

                                        </div>
                                    </div>
                                    `;
                                    if (typeof(tithis[1]) != 'undefined') {
                panchang_html_new +=    `<div class="divine-row dapi-row sec-panchang">
                                            <div class="dapi-col-5 dapi-col">
                                                <p class="dapi_sub_ttl_1"></p>
                                        
                                            </div>
                                            <div class="dapi-col-7 dapi-col">
                                                <p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/`+paksha+`-tithis/`+tithis[1].tithi.toLowerCase()+`.svg"/>`+tithis[1].tithi+`</span> `+tithi_two_end_text+`</p>

                                            </div>
                                        </div>`;
                                    }
                                    if (tithi_three) {
                panchang_html_new +=    `<div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1"></p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/`+paksha+`-tithis/`+tithi_three.toLowerCase()+`.svg"/>`+tithi_three+`</span></p>
    
                                        </div>
                                    </div>`;
                                    }
                                    
                panchang_html_new +=    `<div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Yoga</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><span class="dapi-bold">`+yogas[0].yoga_name+`</span> upto `+yoga_one_ends_at[0]+` <span class="dapi-bold">`+yoga_one_ends_at[1]+`</span>`+yoga_one_end_date+`</p>
    
                                        </div>
                                    </div>
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1"></p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><span class="dapi-bold">`+yogas[1].yoga_name+`</span> `+yoga_two_end_text+`</p>
    
                                        </div>
                                    </div>
                                    <div class="divine-row dapi-row sec-panchang ` + yoga_third_row_style + `">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1"></p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><span class="dapi-bold">`+yoga_three+`&nbsp;</span></p>
    
                                        </div>
                                    </div>`;
                                    // }
                    panchang_html_new +=    `<div class="divine-row dapi-row sec-panchang">
                                            <div class="dapi-col-5 dapi-col">
                                                <p class="dapi_sub_ttl_1">Weekday</p>
                                        
                                            </div>
                                            <div class="dapi-col-7 dapi-col">
                                                <p class="dapi-p"><span class="dapi-bold">`+`PENDING`+`</span></p>
        
                                            </div>
                                        </div>`;

            panchang_html_new += `</div>`;

        panchang_html_new +=    `<div class="dapi-col-6 dapi-custom">
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Nakshatra</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/nakshatras/`+nakshatras[0].nak_name.toLowerCase()+`.svg"/>`+nakshatras[0].nak_name+`</span> upto `+nakshatra_one_ends_at[0]+` <span class="dapi-bold">`+nakshatra_one_ends_at[1]+`</span>`+nakshatra_one_end_date+`</p>
                                    
                                        </div>
                                    </div>`;

                        if (typeof(nakshatras[1]) != 'undefined') {
            panchang_html_new +=  `<div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1"></p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/nakshatras/`+nakshatras[1].nak_name.toLowerCase()+`.svg"/>`+nakshatras[1].nak_name+`</span> `+nakshatra_two_end_text+`</p>

                                        </div>
                                    </div>`;
                                }
                                
                        if (nakshatra_three) {
        panchang_html_new +=    `<div class="divine-row dapi-row sec-panchang">
                                    <div class="dapi-col-5 dapi-col">
                                        <p class="dapi_sub_ttl_1"></p>
                                
                                    </div>
                                    <div class="dapi-col-7 dapi-col">
                                        <p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/`+nakshatras+`-tithis/`+nakshatra_three.toLowerCase()+`.svg"/>`+nakshatra_three+`</span></p>

                                    </div>
                                </div>`;
                                }
        panchang_html_new +=    `<div class="divine-row dapi-row sec-panchang">
                                <div class="dapi-col-5 dapi-col">
                                    <p class="dapi_sub_ttl_1">Karana</p>
                            
                                </div>
                                <div class="dapi-col-7 dapi-col">
                                    <p class="dapi-p"><span class="dapi-bold">`+karnas[0].karana_name+`</span> upto `+karna_one_ends_at[0]+` <span class="dapi-bold">`+karna_one_ends_at[1]+`</span>`+karna_one_end_date+`</p>

                                </div>
                            </div>
                            <div class="divine-row dapi-row sec-panchang">
                                <div class="dapi-col-5 dapi-col">
                                    <p class="dapi_sub_ttl_1"></p>
                            
                                </div>
                                <div class="dapi-col-7 dapi-col">
                                    <p class="dapi-p"><span class="dapi-bold">`+karnas[1].karana_name+`</span> `+karna_two_end_text+`</p>

                                </div>
                            </div>
                            <div class="divine-row dapi-row sec-panchang">
                                <div class="dapi-col-5 dapi-col">
                                    <p class="dapi_sub_ttl_1"></p>
                            
                                </div>
                                <div class="dapi-col-7 dapi-col">
                                    <p class="dapi-p"><span class="dapi-bold">`+karna_three+`</span></p>

                                </div>
                            </div>`;
                            
        panchang_html_new +=    `<div class="divine-row dapi-row sec-panchang">
                        <div class="dapi-col-5 dapi-col">
                            <p class="dapi_sub_ttl_1">Paksha</p>
                    
                        </div>
                        <div class="dapi-col-7 dapi-col">
                            <p class="dapi-p"><img class="dapi_img" src="`+plgn_base_url+`public/images/panchang/pakshas/`+tithi_paksha+`.svg"/>`+tithi_paksha+`</p>

                        </div>
                    </div>`;

        panchang_html_new += `</div>
                        </div>`;

                        let panchang_html = '<div class="divine-row dapi-row divine-row-pdd dapi-extra-row">'
                                            +'<div class="dapi-col-6 dapi-col">'

                                            +'<div class="divine-row dapi-response">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Tithi</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/'+paksha.toLowerCase()+'-tithis/'+tithis[0].tithi.toLowerCase()+'.svg"/>'+tithis[0].tithi+'</span> upto '+tithi_one_ends_at[0]+' <span class="dapi-bold">'+tithi_one_ends_at[1]+'</span>'+tithi_one_end_date+'</p>'
                                            +'</div>'
                                            +'</div>';

                                            if (typeof(tithis[1]) != 'undefined') {
                                panchang_html += '<div class="divine-row dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/'+paksha.toLowerCase()+'-tithis/'+tithis[1].tithi.toLowerCase()+'.svg"/>'+tithis[1].tithi+'</span> '+tithi_two_end_text+'</p>'
                                                +'</div>'
                                                +'</div>';
                                            }
                                            if (typeof(tithis[2]) != 'undefined') {
                                panchang_html += '<div class="divine-row dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/'+paksha.toLowerCase()+'-tithis/'+tithis[2].tithi.toLowerCase()+'.svg"/>'+tithis[2].tithi+'</span></p>'
                                                +'</div>'
                                                +'</div>';
                                            }

                            panchang_html +='</div>'

                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd dapi-response">'
                                            
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Nakshatra</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+nakshatras[0].nak_name.toLowerCase()+'.svg"/>'+nakshatras[0].nak_name+'</span> upto '+nakshatra_one_ends_at[0]+' <span class="dapi-bold">'+nakshatra_one_ends_at[1]+'</span>'+nakshatra_one_end_date+'</p>'
                                            +'</div>'
                                            +'</div>';

                                            if (typeof(nakshatras[1]) != 'undefined') {
                                panchang_html += '<div class="divine-row dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+nakshatras[1].nak_name.toLowerCase()+'.svg"/>'+nakshatras[1].nak_name+'</span> '+nakshatra_two_end_text+'</p>'
                                                +'</div>'
                                                +'</div>';
                                            }
                                            if (typeof(nakshatras[2]) != 'undefined') {
                                panchang_html += '<div class="divine-row dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+nakshatra_three.toLowerCase()+'.svg"/>'+nakshatra_three+'</span></p>'
                                                +'</div>'
                                                +'</div>';
                                            }

                                panchang_html += '</div>'
                                            +'</div>';

                                            if (typeof(tithis[1]) != 'undefined' || typeof(nakshatras[1] != 'undefined')) {

                            panchang_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">';

                                            if (typeof(tithis[1]) != 'undefined') {

                            panchang_html += '<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/'+paksha.toLowerCase()+'-tithis/'+tithis[1].tithi.toLowerCase()+'.svg"/>'+tithis[1].tithi+'</span> '+tithi_two_end_text+'</p>';

                                            }

                            panchang_html += '</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">';

                                            if (typeof(nakshatras[1]) != 'undefined') {

                            panchang_html += '<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+nakshatras[1].nak_name.toLowerCase()+'.svg"/>'+nakshatras[1].nak_name+'</span> '+nakshatra_two_end_text+'</p>';

                                            }

                            panchang_html += '</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            }

                                            if (tithi_third_row_show) {

                            panchang_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">';
                                if(tithi_three){
                                    panchang_html += '<p class="dapi-p"><span class="dapi-bold"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/'+paksha.toLowerCase()+'-tithis/'+tithi_three.toLowerCase()+'.svg"/>'+tithi_three+'</span></p>';
                                }
                                panchang_html += '</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold">';
                                            if(nakshatra_three){
                                                panchang_html += '<img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+nakshatra_three.toLowerCase()+'.svg"/>';

                                            }
                                    panchang_html += nakshatra_three+'</span></p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>';

                                            }

                            panchang_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-row">'

                                            +'<div class="dapi-col-6 dapi-col">'

                                            +'<div class="divine-row dapi-response">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Yoga</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold">'+yogas[0].yoga_name+'</span> upto '+yoga_one_ends_at[0]+' <span class="dapi-bold">'+yoga_one_ends_at[1]+'</span>'+yoga_one_end_date+'</p>'
                                            +'</div>'
                                            +'</div>';

                                            if(yogas[1].yoga_name){
                            panchang_html += '<div class="divine-row dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold">'+yogas[1].yoga_name+'</span> '+yoga_two_end_text+'</p>'
                                                +'</div>'
                                                +'</div>';
                                            }

                                            if(yoga_three){
                            panchang_html += '<div class="divine-row dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold">'+yoga_three+'</span> </p>'
                                                +'</div>'
                                                +'</div>';
                                            }

                            panchang_html +='</div>'

                                            +'<div class="dapi-col-6 dapi-col">'

                                            +'<div class="divine-row dapi-row-lpdd dapi-response">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Karana</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold">'+karnas[0].karana_name+'</span> upto '+karna_one_ends_at[0]+' <span class="dapi-bold">'+karna_one_ends_at[1]+'</span>'+karna_one_end_date+'</p>'
                                            +'</div>'
                                            +'</div>';

                                            if(karnas[1].karana_name){
                            panchang_html += '<div class="divine-row dapi-row-lpdd dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold">'+karnas[1].karana_name+'</span> '+karna_two_end_text+'</p>'
                                                +'</div>'
                                                +'</div>';
                                            }
                                            if(karna_three){
                            panchang_html += '<div class="divine-row dapi-row-lpdd dapi-extra-response">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p"><span class="dapi-bold">'+karna_three+'</span></p>'
                                                +'</div>'
                                                +'</div>';
                                            }

                            panchang_html += '</div>'
                                            +'</div>';

                            panchang_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold">'+yogas[1].yoga_name+'</span> '+yoga_two_end_text+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold">'+karnas[1].karana_name+'</span> '+karna_two_end_text+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop" '+yoga_third_row_style+'>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold">'+yoga_three+'</span></p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                                            
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><span class="dapi-bold">'+karna_three+'</span></p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd">'

                                            // +'<div class="dapi-col-6 dapi-col">'
                                            // +'<div class="divine-row">'
                                            // +'<div class="dapi-col-5">'
                                            // +'<p class="dapi_sub_ttl_1">Weekday</p>'
                                            // +'</div>'
                                            // +'<div class="dapi-col-7">'
                                            // +'<p class="dapi-p">PENDING</p>'
                                            // +'</div>'
                                            // +'</div>'
                                            // +'</div>'

                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Paksha</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/pakshas/'+tithi_paksha+'.svg"/>'+tithi_paksha+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            // +'<p class="dapi_sub_ttl_1">Weekday</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7">'
                                            // +'<p class="dapi-p">PENDING</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>';

                        $('#dapiac2').html(panchang_html);
                        handle_acordian('dapiac2');

                    } else {
                        $('#dapiac4').html('<p class="text-danger">Something went wrong while fetching Rashi and Nakshatra details!</p>');
                        $('#dapiac2').html('<p class="text-danger">Something went wrong while fetching panchang details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get sunrise and moonrise: ' + e);
            
        }

    }

    function get_lunar_month_and_samvat(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac3').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr3"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-2.divineapi.com/indian-api/v1/find-samvat',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);

                        let lunar_and_samvat_data = response.data;

                        let shaka_name = lunar_and_samvat_data.shaka_name.charAt(0).toUpperCase() + lunar_and_samvat_data.shaka_name.slice(1);
                        let shaka_year = lunar_and_samvat_data.shaka_year;
                        let vikram_name = lunar_and_samvat_data.vikram_name.charAt(0).toUpperCase() + lunar_and_samvat_data.vikram_name.slice(1);
                        let vikram_year = lunar_and_samvat_data.vikram_year;

                        let lunar_and_samvat_html_new = `<div class="divine-row dapi-row">
                                <div class="dapi-col-6 dapi-custom">
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Shaka Samvat</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p">`+shaka_year+` `+shaka_name+`</p>
                                    
                                        </div>
                                    </div>
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Vikram Samvat</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p">`+vikram_year+` `+vikram_name+`</p>
                                
                                        </div>
                                    </div>
                                </div>
                                <div class="dapi-col-6 dapi-custom">
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Chandramasa</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p">PENDING</p>
                                    
                                        </div>
                                    </div>
                                    <div class="divine-row dapi-row sec-panchang">
                                        <div class="dapi-col-5 dapi-col">
                                            <p class="dapi_sub_ttl_1">Moonset</p>
                                    
                                        </div>
                                        <div class="dapi-col-7 dapi-col">
                                            <p class="dapi-p" id="amant_chandramasa"></p>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        
                        let lunar_and_samvat_html = '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Shaka Samvat</p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p">'+shaka_year+' '+shaka_name+'</p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Chandramasa</p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                // +'<p class="dapi-p">PENDING</p>'
                                                +'<p class="dapi-p amant_chandramasa" id="amant_chandramasa"></p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Vikram Samvat</p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p">'+vikram_year+' '+vikram_name+'</p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                // +'<p class="dapi-p amant_chandramasa" id="amant_chandramasa"></p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'                                     
                                                +'</div>'
                                                
                                                +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Shaka Samvat</p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p">'+shaka_year+' '+shaka_name+'</p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Vikram Samvat</p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                +'<p class="dapi-p">'+vikram_year+' '+vikram_name+'</p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Chandramasa</p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7">'
                                                // +'<p class="dapi-p">PENDING</p>'
                                                +'<p class="dapi-p amant_chandramasa" id="amant_chandramasa"></p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'

                                                // +'<div class="dapi-col-6 dapi-col">'
                                                // +'<div class="divine-row dapi-row-lpdd">'
                                                // +'<div class="dapi-col-5">'
                                                // +'<p class="dapi_sub_ttl_1"></p>'
                                                // +'</div>'
                                                // +'<div class="dapi-col-7">'
                                                // +'<p class="dapi-p amant_chandramasa" id="amant_chandramasa"></p>'
                                                // +'</div>'
                                                // +'</div>'
                                                // +'</div>'  

                                                +'</div>';

                        $('#dapiac3').html(lunar_and_samvat_html);
                        handle_acordian('dapiac3');
                        get_chandramasa(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);

                    } else {
                        $('#dapiac3').html('<p class="text-danger">Something went wrong while fetching lunar month and samvat details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get lunar month and samvat: ' + e);
            
        }

    }

    function get_rashi_and_nakshatra(response, widget_day, widget_month, widget_year) {

        try {

            $('#dapiac4').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr4"></div></div></div>');

            if (response.success == 1) {
                
                let selected_date = widget_day+'/'+widget_month+'/'+widget_year;

                let panchang_res_data = response.data;

                let moon_zodiac = panchang_res_data.nakshatras.zodiac_point;
                let nakshatra_padas = panchang_res_data.nakshatras.nakshatra_pada;
                let are_two_moon_signs = (moon_zodiac.length == 2) ? true : false;

                let sun_zodiac = panchang_res_data.sun_nakshatras.zodiac_point[0].sign.charAt(0).toUpperCase() + panchang_res_data.sun_nakshatras.zodiac_point[0].sign.slice(1);
                let sun_nakshatra = panchang_res_data.sun_nakshatras.nakshatra_list[0].nak_name;
                let sun_pada = panchang_res_data.sun_nakshatras.nakshatra_pada[0].nak_pada;
                let sun_pada_name = panchang_res_data.sun_nakshatras.nakshatra_pada[0].nak_name;

                let moon_sign_one = (typeof(moon_zodiac[0]) != "undefined" && moon_zodiac[0] != null) ? moon_zodiac[0].sign.charAt(0).toUpperCase() + moon_zodiac[0].sign.slice(1) : '';
                let moon_sign_one_ends_at = (typeof(moon_zodiac[0].end_time) != "undefined" && moon_zodiac[0].end_time.length > 0) ? convert_date_to_hours_mins_ampm(moon_zodiac[0].end_time) : ''; 
                moon_sign_one_ends_at = (typeof(moon_zodiac[0].end_time) != "undefined" && moon_zodiac[0].end_time.length > 0) ? moon_sign_one_ends_at.split(" ") : new Array();
                let moon_sign_one_end = (typeof(moon_zodiac[0].end_time) != "undefined" && moon_zodiac[0].end_time.length > 0) ? convert_date_in_d_m_y_format(moon_zodiac[0].end_time) : '';
                let moon_sign_one_end_content = (typeof(moon_zodiac[0].end_time) != "undefined" && moon_zodiac[0].end_time.length > 0) ? convert_date_in_d_M_format(moon_zodiac[0].end_time) : '';
                let moon_sign_one_end_date = (selected_date != moon_sign_one_end && moon_sign_one_end.length > 0) ? ', ' + moon_sign_one_end_content : '';

                let padas = new Array();
                let i = 0;
                $.each(nakshatra_padas, function(key, val) {
                    padas[i] = new Array();

                    padas[i]['name'] = (typeof(val.nak_name) != "undefined") ? val.nak_name : '';
                    padas[i]['pada'] = (typeof(val.nak_pada) != "undefined") ? val.nak_pada : '';
                    let pada_one_ends_at = (typeof(val.end_time) != "undefined" && val.end_time.length > 0) ? convert_date_to_hours_mins_ampm(val.end_time) : '';
                    pada_one_ends_at = (pada_one_ends_at != null && pada_one_ends_at.length > 0) ? pada_one_ends_at.split(" ") : new Array();
                    let pada_end = (typeof(val.end_time) != "undefined" && val.end_time.length > 0) ? convert_date_in_d_m_y_format(val.end_time) : '';
                    let pada_end_content = (typeof(val.end_time) != "undefined" && val.end_time.length > 0) ? convert_date_in_d_M_format(val.end_time) : '';
                    padas[i]['end_time'] = (typeof(pada_one_ends_at[0]) != "undefined" && pada_one_ends_at[0] != null) ? pada_one_ends_at[0] : null;
                    padas[i]['ampm'] = (typeof(pada_one_ends_at[1]) != "undefined" && pada_one_ends_at[1] != null) ? pada_one_ends_at[1] : null;
                    padas[i]['end_date'] = (selected_date != pada_end && pada_end.length > 0) ? ', ' + pada_end_content : '';

                    i++;

                });

                let rashi_nakshatra_html = '';

                if (are_two_moon_signs) {
                    rashi_nakshatra_html = '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Moonsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">';
                                            if (typeof(moon_sign_one_ends_at[0]) != "undefined" && moon_sign_one_ends_at[0] != null) {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+' upto '+moon_sign_one_ends_at[0]+' <span class="dapi-bold">'+moon_sign_one_ends_at[1]+'</span>'+moon_sign_one_end_date+'</p>';
                                            } else {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+'</p>';
                                            }
                rashi_nakshatra_html +=     '</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Nakshatra Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[0]['pada']+'.svg"/>'+padas[0]['name']+' upto '+padas[0]['end_time']+' <span class="dapi-bold">'+padas[0]['ampm']+'</span>'+padas[0]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>';

                    rashi_nakshatra_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_zodiac[1].sign+'.svg"/>'+moon_zodiac[1].sign+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[1]['pada']+'.svg"/>'+padas[1]['name']+' upto '+padas[1]['end_time']+' <span class="dapi-bold">'+padas[1]['ampm']+'</span>'+padas[1]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Sunsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+sun_zodiac.toLowerCase()+'.svg"/>'+sun_zodiac+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[2]['pada']+'.svg"/>'+padas[2]['name']+' upto '+padas[2]['end_time']+' <span class="dapi-bold">'+padas[2]['ampm']+'</span>'+padas[2]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Nakshatra</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+sun_nakshatra.toLowerCase()+'.svg"/>'+sun_nakshatra+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[3]['pada']+'.svg"/>'+padas[3]['name']+' upto '+padas[3]['end_time']+' <span class="dapi-bold">'+padas[3]['ampm']+'</span>'+padas[3]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'     
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+sun_pada+'.svg"/>'+sun_pada_name+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>';

                    if (typeof(padas[4]) != "undefined" && padas[4] != null) {

                        rashi_nakshatra_html += '<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[4]['pada']+'.svg"/>'+padas[4]['name'];
                                                if (typeof(padas[4]['end_time']) != "undefined" && padas[4]['end_time'] != null && padas[4]['end_time'].length > 0) {
                                                    rashi_nakshatra_html += ' upto '+padas[4]['end_time']+' <span class="dapi-bold">'+padas[4]['ampm']+'</span>'+padas[4]['end_date']+'</p>';
                                                } else {
                                                    rashi_nakshatra_html += '</p>';
                                                }
                        rashi_nakshatra_html += '</div>'
                                                +'</div>'
                                                +'</div>';

                    } else {

                        rashi_nakshatra_html += '<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"></p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>';

                    }

                    rashi_nakshatra_html += '</div>'   
                                            +'</div>';

                    // *********************
                    rashi_nakshatra_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Moonsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">';
                                            if (typeof(moon_sign_one_ends_at[0]) != "undefined" && moon_sign_one_ends_at[0] != null) {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+' upto '+moon_sign_one_ends_at[0]+'<span class="dapi-bold">'+moon_sign_one_ends_at[1]+'</span>'+moon_sign_one_end_date+'</p>';
                                            } else {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+'</p>';
                                            }
                rashi_nakshatra_html +=     '</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_zodiac[1].sign+'.svg"/>'+moon_zodiac[1].sign+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Sunsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+sun_zodiac.toLowerCase()+'.svg"/>'+sun_zodiac+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Nakshatra</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+sun_nakshatra.toLowerCase()+'.svg"/>'+sun_nakshatra+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+sun_pada+'.svg"/>'+sun_pada_name+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Nakshatra Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[0]['pada']+'.svg"/>'+padas[0]['name']+' upto '+padas[0]['end_time']+' <span class="dapi-bold">'+padas[0]['ampm']+'</span>'+padas[0]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>';

                    rashi_nakshatra_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                            

                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[1]['pada']+'.svg"/>'+padas[1]['name']+' upto '+padas[1]['end_time']+' <span class="dapi-bold">'+padas[1]['ampm']+'</span>'+padas[1]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>'
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                            

                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[2]['pada']+'.svg"/>'+padas[2]['name']+' upto '+padas[2]['end_time']+' <span class="dapi-bold">'+padas[2]['ampm']+'</span>'+padas[2]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                            
                                            
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[3]['pada']+'.svg"/>'+padas[3]['name']+' upto '+padas[3]['end_time']+' <span class="dapi-bold">'+padas[3]['ampm']+'</span>'+padas[3]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>'     
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                           ;

                    if (typeof(padas[4]) != "undefined" && padas[4] != null) {

                        rashi_nakshatra_html += '<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[4]['pada']+'.svg"/>'+padas[4]['name'];
                                                if (typeof(padas[4]['end_time']) != "undefined" && padas[4]['end_time'] != null && padas[4]['end_time'].length > 0) {
                                                    rashi_nakshatra_html += ' upto '+padas[4]['end_time']+' <span class="dapi-bold">'+padas[4]['ampm']+'</span>'+padas[4]['end_date']+'</p>';
                                                } else {
                                                    rashi_nakshatra_html += '</p>';
                                                }
                        rashi_nakshatra_html += '</div>'
                                                +'</div>'
                                                +'</div>';

                    } else {

                        rashi_nakshatra_html += '<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"></p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>';

                    }

                    rashi_nakshatra_html += '</div>'   
                                            +'</div>';

                    $('#dapiac4').html(rashi_nakshatra_html);
                    handle_acordian('dapiac4');

                } else {

                    rashi_nakshatra_html = '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Moonsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">';
                                            if (typeof(moon_sign_one_ends_at[0]) != "undefined" && moon_sign_one_ends_at[0] != null) {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+' upto '+moon_sign_one_ends_at[0]+'<span class="dapi-bold">'+moon_sign_one_ends_at[1]+'</span>'+moon_sign_one_end_date+'</p>';
                                            } else {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+'</p>';
                                            }
                rashi_nakshatra_html +=     '</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Nakshatra Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[0]['pada']+'.svg"/>'+padas[0]['name']+' upto '+padas[0]['end_time']+' <span class="dapi-bold">'+padas[0]['ampm']+'</span>'+padas[0]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>';

                    rashi_nakshatra_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Sunsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+sun_zodiac.toLowerCase()+'.svg"/>'+sun_zodiac+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[1]['pada']+'.svg"/>'+padas[1]['name']+' upto '+padas[1]['end_time']+' <span class="dapi-bold">'+padas[1]['ampm']+'</span>'+padas[1]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Nakshatra</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+sun_nakshatra.toLowerCase()+'.svg"/>'+sun_nakshatra+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[2]['pada']+'.svg"/>'+padas[2]['name']+' upto '+padas[2]['end_time']+' <span class="dapi-bold">'+padas[2]['ampm']+'</span>'+padas[2]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+sun_pada+'.svg"/>'+sun_pada_name+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[3]['pada']+'.svg"/>'+padas[3]['name']+' upto '+padas[3]['end_time']+' <span class="dapi-bold">'+padas[3]['ampm']+'</span>'+padas[3]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>';

                    if (typeof(padas[4]) != "undefined" && padas[4] != null) {

                        rashi_nakshatra_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"></p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[4]['pada']+'.svg"/>'+padas[4]['name'];
                                                if (typeof(padas[4]['end_time']) != "undefined" && padas[4]['end_time'] != null) {
                                                    rashi_nakshatra_html += ' upto '+padas[4]['end_time']+' <span class="dapi-bold">'+padas[4]['ampm']+'</span>'+padas[4]['end_date']+'</p>';
                                                } else {
                                                    rashi_nakshatra_html += '</p>';
                                                }
                        rashi_nakshatra_html += '</div>'
                                                +'</div>'
                                                +'</div>';
        
                    }
        
                    rashi_nakshatra_html += '</div>';


                    // *********************
                    rashi_nakshatra_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Moonsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">';
                                            if (typeof(moon_sign_one_ends_at[0]) != "undefined" && moon_sign_one_ends_at[0] != null) {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+' upto '+moon_sign_one_ends_at[0]+'<span class="dapi-bold">'+moon_sign_one_ends_at[1]+'</span>'+moon_sign_one_end_date+'</p>';
                                            } else {
                                                rashi_nakshatra_html += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_sign_one.toLowerCase()+'.svg"/>'+moon_sign_one+'</p>';
                                            }
                rashi_nakshatra_html +=     '</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            // +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            // +'<div class="dapi-col-6 dapi-col">'
                                            // +'<div class="divine-row">'
                                            // +'<div class="dapi-col-5">'
                                            // +'<p class="dapi_sub_ttl_1"></p>'
                                            // +'</div>'
                                            // +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            // +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+moon_zodiac[1].sign+'.svg"/>'+moon_zodiac[1].sign+'</p>'
                                            // +'</div>'
                                            // +'</div>'
                                            // +'</div>'
                                            // +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Sunsign</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+sun_zodiac.toLowerCase()+'.svg"/>'+sun_zodiac+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Nakshatra</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+sun_nakshatra.toLowerCase()+'.svg"/>'+sun_nakshatra+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Surya Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+sun_pada+'.svg"/>'+sun_pada_name+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1">Nakshatra Pada</p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[0]['pada']+'.svg"/>'+padas[0]['name']+' upto '+padas[0]['end_time']+' <span class="dapi-bold">'+padas[0]['ampm']+'</span>'+padas[0]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>';

                    rashi_nakshatra_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                            

                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[1]['pada']+'.svg"/>'+padas[1]['name']+' upto '+padas[1]['end_time']+' <span class="dapi-bold">'+padas[1]['ampm']+'</span>'+padas[1]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>'
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                            

                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[2]['pada']+'.svg"/>'+padas[2]['name']+' upto '+padas[2]['end_time']+' <span class="dapi-bold">'+padas[2]['ampm']+'</span>'+padas[2]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>'

                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                            
                                            
                                            +'<div class="dapi-col-6 dapi-col">'
                                            +'<div class="divine-row dapi-row-lpdd">'
                                            +'<div class="dapi-col-5">'
                                            +'<p class="dapi_sub_ttl_1"></p>'
                                            +'</div>'
                                            +'<div class="dapi-col-7 dapi-col-sm-7">'
                                            +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[3]['pada']+'.svg"/>'+padas[3]['name']+' upto '+padas[3]['end_time']+' <span class="dapi-bold">'+padas[3]['ampm']+'</span>'+padas[3]['end_date']+'</p>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'

                                            +'</div>'     
                                            +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                           ;

                    if (typeof(padas[4]) != "undefined" && padas[4] != null) {

                        rashi_nakshatra_html += '<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/padas/'+padas[4]['pada']+'.svg"/>'+padas[4]['name'];
                                                if (typeof(padas[4]['end_time']) != "undefined" && padas[4]['end_time'] != null && padas[4]['end_time'].length > 0) {
                                                    rashi_nakshatra_html += ' upto '+padas[4]['end_time']+' <span class="dapi-bold">'+padas[4]['ampm']+'</span>'+padas[4]['end_date']+'</p>';
                                                } else {
                                                    rashi_nakshatra_html += '</p>';
                                                }
                        rashi_nakshatra_html += '</div>'
                                                +'</div>'
                                                +'</div>';

                    } else {

                        rashi_nakshatra_html += '<div class="dapi-col-6 dapi-col">'
                                                +'<div class="divine-row dapi-row-lpdd">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1"></p>'
                                                +'</div>'
                                                +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                +'<p class="dapi-p"></p>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>';

                    }

                    rashi_nakshatra_html += '</div>'   
                                            +'</div>';
                    

                    // let rashi_nakshatra_html_mb = '<div class="divine-row dapi-row  divine-row-pdd">'
                    //                                 +'<div class="dapi-col-6 dapi-col">'
                    //                                 +'</div>';

                    // rashi_nakshatra_html_mb = '</div>';

                    $('#dapiac4').html(rashi_nakshatra_html);
                    handle_acordian('dapiac4');

                }

            } else {
                $('#dapiac4').html('<p class="text-danger">Something went wrong while fetching rashi and nakshatra details!</p>');
            }

        } catch (e) {

            console.log('Error in get rashi and nakshtra: ' + e);

        }

    }

    function get_ritu_and_ayana(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac5').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr5"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-2.divineapi.com/indian-api/v1/find-ritu-and-anaya',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);
                        let ritu_ayana_data = response.data;

                        let drik_ritu = ritu_ayana_data.ritus.drik[0].name;
                        let drik_ayana = ritu_ayana_data.ritus.drik[0].ayana;
                        let vedic_ritu = ritu_ayana_data.ritus.vedic[0].name;
                        let vedic_ayana = ritu_ayana_data.ritus.vedic[0].ayana;

                        let dinman = ritu_ayana_data.dinmana.hours + ' Hours ' + ritu_ayana_data.dinmana.minutes + ' Mins ' + ritu_ayana_data.dinmana.seconds + ' Secs';
                        let madhyana = ritu_ayana_data.madhyahna;
                        let ratriman = ritu_ayana_data.raatrimana.hours + ' Hours ' + ritu_ayana_data.raatrimana.minutes + ' Mins ' + ritu_ayana_data.raatrimana.seconds + ' Secs';

                        let ritu_anaya_html =  '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Drik Ritu</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/ritus/'+drik_ritu.toLowerCase()+'.svg"/>'+drik_ritu.charAt(0).toUpperCase() + drik_ritu.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Dinamana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+dinman+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Vedic Ritu</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/ritus/'+vedic_ritu.toLowerCase()+'.svg"/>'+vedic_ritu.charAt(0).toUpperCase() + vedic_ritu.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Ratrimana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+ratriman+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Drik Ayana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+drik_ayana.charAt(0).toUpperCase() + drik_ayana.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Madhyahna</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+madhyana+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Vedic Ayana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+vedic_ayana.charAt(0).toUpperCase() + vedic_ayana.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'


                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Drik Ritu</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/ritus/'+drik_ritu.toLowerCase()+'.svg"/>'+drik_ritu.charAt(0).toUpperCase() + drik_ritu.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                   
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Vedic Ritu</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/ritus/'+vedic_ritu.toLowerCase()+'.svg"/>'+vedic_ritu.charAt(0).toUpperCase() + vedic_ritu.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Drik Ayana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+drik_ayana.charAt(0).toUpperCase() + drik_ayana.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Vedic Ayana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+vedic_ayana.charAt(0).toUpperCase() + vedic_ayana.slice(1)+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Dinamana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+dinman+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    

                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Ratrimana</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+ratriman+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Madhyahna</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+madhyana+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'</div>';

                        $('#dapiac5').html(ritu_anaya_html);
                        handle_acordian('dapiac5');

                    } else {
                        $('#dapiac5').html('<p class="text-danger">Something went wrong while fetching ritu and ayana details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get ritu and ayana: ' + e);
        
        }

    }

    function get_auspicious_timings(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac6').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr6"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/auspicious-timings',//4
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);

                        let selected_date = widget_day+'/'+widget_month+'/'+widget_year;

                        let auspicious_data = response.data;
        
                        let auspicious_html = '<div class="divine-row dapi-row">';

                            if (typeof(auspicious_data.brahma_muhurta) == 'object' && !$.isEmptyObject(auspicious_data.brahma_muhurta)) {
                            // if (typeof(auspicious_data.brahma_muhurta) == 'object' || auspicious_data.brahma_muhurta.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Brahma Muhurta</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.brahma_muhurta, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.pratah_sandhya) == 'object' && !$.isEmptyObject(auspicious_data.pratah_sandhya)) {
                            // if (typeof(auspicious_data.pratah_sandhya) == 'object' || auspicious_data.pratah_sandhya.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Pratah Sandhya</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.pratah_sandhya, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }
                                
                            if (typeof(auspicious_data.abhijit_muhurta) == 'object' && !$.isEmptyObject(auspicious_data.abhijit_muhurta)) {
                            // if (typeof(auspicious_data.abhijit_muhurta) == 'object' || auspicious_data.abhijit_muhurta.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Abhijit</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.abhijit_muhurta, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }        

                            if (typeof(auspicious_data.vijay_muhurta) == 'object' && !$.isEmptyObject(auspicious_data.vijay_muhurta)) {
                            // if (typeof(auspicious_data.vijay_muhurta) == 'object' || auspicious_data.vijay_muhurta.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Vijaya Muhurta</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.vijay_muhurta, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.godhuli_muhurta) == 'object' && !$.isEmptyObject(auspicious_data.godhuli_muhurta)) {
                            // if (typeof(auspicious_data.godhuli_muhurta) == 'object' || auspicious_data.godhuli_muhurta.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Godhuli Muhurta</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.godhuli_muhurta, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }        
                                
                            if (typeof(auspicious_data.sayahana_sandhya) == 'object' && !$.isEmptyObject(auspicious_data.sayahana_sandhya)) {
                            // if (typeof(auspicious_data.sayahana_sandhya) == 'object' || auspicious_data.sayahana_sandhya.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Sayahna Sandhya</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.sayahana_sandhya, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.amrit_kalam) == 'object' && !$.isEmptyObject(auspicious_data.amrit_kalam)) {
                            // if (typeof(auspicious_data.amrit_kalam) == 'object' || auspicious_data.amrit_kalam.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Amrit Kalam</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.amrit_kalam, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }
                                
                            if (typeof(auspicious_data.nishita_muhurta) == 'object' && !$.isEmptyObject(auspicious_data.nishita_muhurta)) {
                            // if (typeof(auspicious_data.nishita_muhurta) == 'object' || auspicious_data.nishita_muhurta.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Nishita Muhurta</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.nishita_muhurta, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.ravi_yoga) == 'object' && !$.isEmptyObject(auspicious_data.ravi_yoga)) {
                            // if (typeof(auspicious_data.ravi_yoga) == 'object' || auspicious_data.ravi_yoga.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Ravi Yoga</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.ravi_yoga, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.sarvartha_siddhi_yoga) == 'object' && !$.isEmptyObject(auspicious_data.sarvartha_siddhi_yoga)) {
                            // if (typeof(auspicious_data.sarvartha_siddhi_yoga) == 'object' || auspicious_data.sarvartha_siddhi_yoga.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Sarvartha Siddhi Yoga</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.sarvartha_siddhi_yoga, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.amrit_siddhi_yoga) == 'object' && !$.isEmptyObject(auspicious_data.amrit_siddhi_yoga)) {
                            // if (typeof(auspicious_data.amrit_siddhi_yoga) == 'object' || auspicious_data.amrit_siddhi_yoga.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Amrit Siddhi Yoga</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.amrit_siddhi_yoga, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.siddha_yoga) == 'object' && !$.isEmptyObject(auspicious_data.siddha_yoga)) {
                            // if (typeof(auspicious_data.siddha_yoga) == 'object' || auspicious_data.siddha_yoga.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Siddha Yoga</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.siddha_yoga, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }

                            if (typeof(auspicious_data.tri_pushkara_yoga) == 'object' && !$.isEmptyObject(auspicious_data.tri_pushkara_yoga)) {
                            // if (typeof(auspicious_data.tri_pushkara_yoga) == 'object' || auspicious_data.tri_pushkara_yoga.length > 0) {
                                auspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Tri Pushkara Yoga</p>'
                                                    +'</div>'
                                                    + get_filtered_array_of_auspicious_inauspicious_timings_html(auspicious_data.tri_pushkara_yoga, selected_date)
                                                    +'</div>'
                                                    +'</div>';
                            }
                                    
                                auspicious_html += '</div>';

                        $('#dapiac6').html(auspicious_html);
                        handle_acordian('dapiac6');

                    } else {
                        $('#dapiac6').html('<p class="text-danger">Something went wrong while fetching auspicious timings!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get auspicious timings: ' + e);
        
        }

    }

    function get_filtered_array_of_auspicious_inauspicious_timings_html(muhurta, selected_date, display_icon=false) {

        let timings = '<div class="dapi-col-7 dapi-col-sm-7">';
        let start = '';
        let end = '';

        if (typeof(muhurta.start_time) != 'undefined') {
            let start_date = (selected_date != convert_date_in_d_m_y_format(muhurta.start_time)) ? ', ' + convert_date_in_d_M_format(muhurta.start_time) : '';
            let end_date = (selected_date != convert_date_in_d_m_y_format(muhurta.end_time)) ? ', ' + convert_date_in_d_M_format(muhurta.end_time) : '';

            start = convert_date_to_hours_mins_ampm(muhurta.start_time);
            end = convert_date_to_hours_mins_ampm(muhurta.end_time);
            let dicon = '';
            if (display_icon) {
                dicon = '<img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/baana.svg""/>';
            }
            timings += '<p class="dapi-p">'+dicon+' '+start + start_date +' to '+end + end_date +'</p>';

        } else if (typeof(muhurta[0]) != 'undefined') {
            let idx=0;
            $.each(muhurta, function(key, val) {

                let start_date = (selected_date != convert_date_in_d_m_y_format(val.start_time)) ? ', ' + convert_date_in_d_M_format(val.start_time) : '';
                let end_date = (selected_date != convert_date_in_d_m_y_format(val.end_time)) ? ', ' + convert_date_in_d_M_format(val.end_time) : '';

                start = convert_date_to_hours_mins_ampm(val.start_time);
                end = convert_date_to_hours_mins_ampm(val.end_time);
                let dicon = '';
                
                if (display_icon && idx==0) {
                    dicon = '<img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/baana.svg"/>';
                }
                timings += '<p class="dapi-p">'+dicon+' '+start + start_date +' to '+end + end_date +'</p>';

                idx++;
            });
        }

        timings += '</div>';

        // if (typeof(muhurta.start_time) != 'undefined') {
        //     muhurta_start[0] = convert_date_to_hours_mins_ampm(muhurta.start_time);
        //     muhurta_end[0] = convert_date_to_hours_mins_ampm(muhurta.end_time);
        // } else if (typeof(muhurta[0]) != 'undefined') {
        //     $.each(muhurta, function(key, val) {

        //         muhurta_start[key] = convert_date_to_hours_mins_ampm(val.start_time);
        //         muhurta_end[key] = convert_date_to_hours_mins_ampm(val.end_time);

        //     });
        // }

        return timings;

    }

    function get_inauspicious_timings(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac7').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr7"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/inauspicious-timings',//4
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);

                        let selected_date = widget_day+'/'+widget_month+'/'+widget_year;

                        let inauspicious_data = response.data;

                        // let rahu_kalam_start = convert_date_to_hours_mins_ampm(inauspicious_data.rahu_kaal.start_time);
                        // let rahu_kalam_end = convert_date_to_hours_mins_ampm(inauspicious_data.rahu_kaal.end_time);
                        // let yamaganda_start = convert_date_to_hours_mins_ampm(inauspicious_data.yamaganda.start_time);
                        // let yamaganda_end = convert_date_to_hours_mins_ampm(inauspicious_data.yamaganda.end_time);
                        // let aadal_yoga_start = (typeof(inauspicious_data.aadal_yoga.start_time) != 'undefined') ? convert_date_to_hours_mins_ampm(inauspicious_data.aadal_yoga.start_time) : '';
                        // let aadal_yoga_end = (typeof(inauspicious_data.aadal_yoga.end_time) != 'undefined') ? ' to ' + convert_date_to_hours_mins_ampm(inauspicious_data.aadal_yoga.end_time) : ''; 
                        // let dur_muhurtam_one_start = inauspicious_data.dur_muhurtam[0].start_time; //convert_date_to_hours_mins_ampm(auspicious_data.vijay_muhurta.start_time);
                        // let dur_muhurtam_one_end = inauspicious_data.dur_muhurtam[0].end_time; //convert_date_to_hours_mins_ampm(auspicious_data.vijay_muhurta.end_time);
                        // let dur_muhurtam_two_start = (typeof(inauspicious_data.dur_muhurtam[1]) != 'undefined') ? inauspicious_data.dur_muhurtam[1].start_time : ''; //convert_date_to_hours_mins_ampm(auspicious_data.godhuli_muhurta.start_time);
                        // let dur_muhurtam_two_end = (typeof(inauspicious_data.dur_muhurtam[1]) != 'undefined') ? ' to ' + inauspicious_data.dur_muhurtam[1].end_time : ''; //convert_date_to_hours_mins_ampm(auspicious_data.godhuli_muhurta.end_time);
                        // let gulkai_kaal_start = convert_date_to_hours_mins_ampm(inauspicious_data.gulkai_kaal.start_time);
                        // let gulkai_kaal_end = convert_date_to_hours_mins_ampm(inauspicious_data.gulkai_kaal.end_time);
                        // let varjyam_start = convert_date_to_hours_mins_ampm(inauspicious_data.varjyam.start_time);
                        // let varjyam_end = convert_date_to_hours_mins_ampm(inauspicious_data.varjyam.end_time);
                        // let baana_sign = inauspicious_data.baana[0].sign; 
                        // let baana_end_time = (inauspicious_data.baana[0].end_time != 'Full Night') ? ' upto ' + convert_date_to_hours_mins_ampm(inauspicious_data.baana[0].end_time) : inauspicious_data[0].baana.end_time;
                        // let panchaka_start = convert_date_to_hours_mins_ampm(inauspicious_data.panchaka.start_time); 
                        // let panchaka_end = convert_date_to_hours_mins_ampm(inauspicious_data.panchaka.end_time);
                        // let panchaka_end_date = convert_date_in_d_M_format(inauspicious_data.panchaka.end_time);
                        
                        let inauspicious_html = '<div class="divine-row dapi-row">';

                        if (typeof(inauspicious_data.rahu_kaal) == 'object' && !$.isEmptyObject(inauspicious_data.rahu_kaal)) {
                        // if ((typeof(inauspicious_data.rahu_kaal) == 'object' || inauspicious_data.rahu_kaal.start_time != 'undefined') || inauspicious_data.rahu_kaal.length > 0 || !$.isEmptyObject(inauspicious_data.rahu_kaal)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Rahu Kaal</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.rahu_kaal, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.yamaganda) == 'object' && !$.isEmptyObject(inauspicious_data.yamaganda)) {
                        // if ((typeof(inauspicious_data.yamaganda) == 'object' || inauspicious_data.yamaganda.start_time != 'undefined') || inauspicious_data.yamaganda.length > 0 || !$.isEmptyObject(inauspicious_data.yamaganda)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Yamaganda</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.yamaganda, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.gulkai_kaal) == 'object' && !$.isEmptyObject(inauspicious_data.gulkai_kaal)) {
                        // if ((typeof(inauspicious_data.gulkai_kaal) == 'object' || inauspicious_data.gulkai_kaal.start_time != 'undefined') || inauspicious_data.gulkai_kaal.length > 0 || !$.isEmptyObject(inauspicious_data.gulkai_kaal)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Gulkai Kaal</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.gulkai_kaal, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.baana) == 'object' && !$.isEmptyObject(inauspicious_data.baana)) {
                        // if ((typeof(inauspicious_data.baana) == 'object' || inauspicious_data.baana.start_time != 'undefined') || inauspicious_data.baana.length > 0 || !$.isEmptyObject(inauspicious_data.baana)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Baana</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.baana, selected_date, true)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.panchaka) == 'object' && !$.isEmptyObject(inauspicious_data.panchaka)) {
                        // if ((typeof(inauspicious_data.panchaka) == 'object' || inauspicious_data.panchaka.start_time != 'undefined') || inauspicious_data.panchaka.length > 0 || !$.isEmptyObject(inauspicious_data.panchaka)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Panchaka</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.panchaka, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.varjyam) == 'object' && !$.isEmptyObject(inauspicious_data.varjyam)) {
                        // if ((typeof(inauspicious_data.varjyam) == 'object' || inauspicious_data.varjyam.start_time != 'undefined') || inauspicious_data.varjyam.length > 0 || !$.isEmptyObject(inauspicious_data.varjyam)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Varjyam</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.varjyam, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.dur_muhurtam) == 'object' && !$.isEmptyObject(inauspicious_data.dur_muhurtam)) {
                        // if ((typeof(inauspicious_data.dur_muhurtam) == 'object' || inauspicious_data.dur_muhurtam.start_time != 'undefined') || inauspicious_data.dur_muhurtam.length > 0 || !$.isEmptyObject(inauspicious_data.dur_muhurtam)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Dur Muhurtam</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.dur_muhurtam, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.hutashana_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.hutashana_yoga)) {
                        // if ((typeof(inauspicious_data.hutashana_yoga) == 'object' || inauspicious_data.hutashana_yoga.start_time != 'undefined') || inauspicious_data.hutashana_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.hutashana_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Hutashana Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.hutashana_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.visha_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.visha_yoga)) {
                        // if ((typeof(inauspicious_data.visha_yoga) == 'object' || inauspicious_data.visha_yoga.start_time != 'undefined') || inauspicious_data.visha_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.visha_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Visha Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.visha_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.yamaghata_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.yamaghata_yoga)) {
                        // if ((typeof(inauspicious_data.yamaghata_yoga) == 'object' || inauspicious_data.yamaghata_yoga.start_time != 'undefined') || inauspicious_data.yamaghata_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.yamaghata_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Yamaghata Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.yamaghata_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.dagdha_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.dagdha_yoga)) {
                        // if ((typeof(inauspicious_data.dagdha_yoga) == 'object' || inauspicious_data.dagdha_yoga.start_time != 'undefined') || inauspicious_data.dagdha_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.dagdha_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Dagdha Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.dagdha_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.samvartaka_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.samvartaka_yoga)) {
                        // if ((typeof(inauspicious_data.samvartaka_yoga) == 'object' || inauspicious_data.samvartaka_yoga.start_time != 'undefined') || inauspicious_data.samvartaka_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.samvartaka_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Samvartaka Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.samvartaka_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.kakracha_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.kakracha_yoga)) {
                        // if ((typeof(inauspicious_data.kakracha_yoga) == 'object' || inauspicious_data.kakracha_yoga.start_time != 'undefined') || inauspicious_data.kakracha_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.kakracha_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Kakracha Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.kakracha_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.mrityu_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.mrityu_yoga)) {
                        // if ((typeof(inauspicious_data.mrityu_yoga) == 'object' || inauspicious_data.mrityu_yoga.start_time != 'undefined') || inauspicious_data.mrityu_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.mrityu_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Mrityu Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.mrityu_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.vidaal_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.vidaal_yoga)) {
                        // if ((typeof(inauspicious_data.vidaal_yoga) == 'object' || inauspicious_data.vidaal_yoga.start_time != 'undefined') || inauspicious_data.vidaal_yoga.length > 0 || !$.isEmptyObject(inauspicious_data.vidaal_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Vidaal Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.vidaal_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        if (typeof(inauspicious_data.aadal_yoga) == 'object' && !$.isEmptyObject(inauspicious_data.aadal_yoga)) {
                            inauspicious_html += '<div class="dapi-col-6 dapi-col dapi-cst-6 divine-row-pdd">'
                                                +'<div class="divine-row">'
                                                +'<div class="dapi-col-5">'
                                                +'<p class="dapi_sub_ttl_1">Aadal Yoga</p>'
                                                +'</div>'
                                                + get_filtered_array_of_auspicious_inauspicious_timings_html(inauspicious_data.aadal_yoga, selected_date)
                                                +'</div>'
                                                +'</div>';
                        }

                        inauspicious_html += '</div>';

                        $('#dapiac7').html(inauspicious_html);
                        handle_acordian('dapiac7');

                    } else {
                        $('#dapiac7').html('<p class="text-danger">Something went wrong while fetching inauspicious timings!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get inauspicious timings: ' + e);
        
        }

    }

    function get_nivas_and_shool(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac8').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr8"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-2.divineapi.com/indian-api/v1/find-nivas-and-shool',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);

                        let nivas_shool_data = response.data;

                        let homahuti = nivas_shool_data.homahuti;
                        let homahuti_one = homahuti[0];
                        let homahuti_one_name = homahuti_one.split(' ');
                        let homahuti_two = (typeof(homahuti[1]) != 'undefined') ? homahuti[1] : '';
                        let disha = nivas_shool_data.disha_shool;
                        let disha_one = disha;
                        // let disha_two = (typeof(disha[1]) != 'undefined') ? disha[1] : '';
                        let agnivas = nivas_shool_data.agni_vaas;
                        let agnivas_one = agnivas[0];
                        let agnivas_two = (typeof(agnivas[1]) != 'undefined') ? agnivas[1] : '';
                        let agnivas_two_img = (agnivas_two.length > 0) ? agnivas_two.split(' ') : new Array();
                        let agnivas_two_img_src = '';
                        if (typeof(agnivas_two_img[0]) != 'undefined') {
                            agnivas_two_img_src = plgn_base_url+'public/images/panchang/'+agnivas_two_img[0].toLowerCase()+'.svg';
                        }
                        let nakshatra_shool = 'PENDING';
                        let chandra_vaas = nivas_shool_data.chandra_vaas;
                        let chandra_vaas_one = chandra_vaas[0];
                        let chandra_vaas_two = (typeof(chandra_vaas[1]) != undefined) ? chandra_vaas[1] : '';
                        let shiv_vaas = nivas_shool_data.shiva_vaas;
                        let shiv_vaas_one = shiv_vaas[0];
                        let shiv_vaas_two = (typeof(shiv_vaas[1]) != 'undefined') ? shiv_vaas[1] : '';
                        let rahu_vaas = nivas_shool_data.rahu_vaas;
                        let rahu_vaas_one = rahu_vaas;
                        // let rahu_vaas_two = (typeof(rahu_vaas[1]) != 'undefined') ? rahu_vaas[1] : '';
                        let kumbha_chakra = nivas_shool_data.kumbha_chakra;
                        let kumbha_chakra_one = kumbha_chakra[0];
                        let kumbha_chakra_two = (typeof(kumbha_chakra[1]) != 'undefined') ? kumbha_chakra[1] : '';
                        let yogini_vaas = nivas_shool_data.yogini_vaas;
                        let yogini_vaas_one = yogini_vaas[0];
                        let yogini_vaas_one_img = yogini_vaas_one.split(' ');
                        let yogini_vaas_two = (typeof(yogini_vaas[1]) != 'undefined') ? yogini_vaas[1] : '';
                        
                        let nivas_shool_html_mb = '<div class="divine-row dapi-row divine-row-pdd">'
                                                    +'<div class="dapi-col-6 dapi-col">';

                                                    let disha_one_img = (disha_one.indexOf(' upto') != -1) ? disha_one.split(' upto') : disha_one;
                                                    disha_one_img = ($.isArray(disha_one_img)) ? disha_one_img[0] : disha_one_img;
                                                    let homahuti_two_name = (homahuti_two.length > 0) ? homahuti_two.split(' ') : new Array();

                                                    nivas_shool_html_mb +='<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Homahuti</p>'
                                                    +'</div>'
                                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_one_name[0].toLowerCase()+'.svg"/>'+homahuti_one+'</p>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'<div class="divine-row">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1"></p>'
                                                    +'</div>'
                                                    +'<div class="dapi-col-7 dapi-col-sm-7">';
                                                    if (typeof(homahuti_two_name[0]) != 'undefined') {
                                                        nivas_shool_html_mb += '<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_two_name[0].toLowerCase()+'.svg"/>'+homahuti_two+'</p>'
                                                    }
                                                    nivas_shool_html_mb += '</div>'
                                                    +'</div>'
                                                    +'</div>'
                                                    
                                                    +'<div class="dapi-col-6 dapi-col">'
                                                    +'<div class="divine-row dapi-row-lpdd">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1">Disha Shool</p>'
                                                    +'</div>'
                                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+disha_one_img+'.svg"/>'+disha_one+'</p>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'<div class="divine-row dapi-row-lpdd">'
                                                    +'<div class="dapi-col-5">'
                                                    +'<p class="dapi_sub_ttl_1"></p>'
                                                    +'</div>'
                                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                                    +'<p class="dapi-p"></p>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'</div>'
                                                    +'</div>';

                        let nivas_shool_html = '';

                        if (homahuti_two.length > 0) {
                            let disha_one_img = (disha_one.indexOf(' upto') != -1) ? disha_one.split(' upto') : disha_one;
                            disha_one_img = ($.isArray(disha_one_img)) ? disha_one_img[0] : disha_one_img;
                            let homahuti_two_name = homahuti_two.split(' ');

                            nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Homahuti</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_one_name[0].toLowerCase()+'.svg"/>'+homahuti_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Disha Shool</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+disha_one_img+'.svg"/>'+disha_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_two_name[0].toLowerCase()+'.svg"/>'+homahuti_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>';

                        } else {

                            let disha_one_img =  (disha_one.indexOf(' upto') != -1) ? disha_one.split(' upto') : disha_one;
                            disha_one_img = ($.isArray(disha_one_img)) ? disha_one_img[0] : disha_one_img;
                            
                            nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Homahuti</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_one_name[0].toLowerCase()+'.svg"/>'+homahuti_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Disha Shool</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+disha_one_img+'.svg"/>'+disha_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>';

                        }

                        let chandra_vaas_one_img =  (chandra_vaas_one.indexOf(' upto') != -1) ? chandra_vaas_one.split(' upto') : chandra_vaas_one;
                        chandra_vaas_one_img = ($.isArray(chandra_vaas_one_img)) ? chandra_vaas_one_img[0] : chandra_vaas_one_img;
                        let agnivas_one_img = agnivas_one.split(' ');

                        nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Agnivasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/'+agnivas_one_img[0].toLowerCase()+'.svg"/>'+agnivas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    // +'<p class="dapi_sub_ttl_1">Nakshatra Shool</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    // +'<p class="dapi-p">'+nakshatra_shool+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+agnivas_two_img_src+'"/>'+agnivas_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Chandra Vasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+chandra_vaas_one_img+'.svg"/>'+chandra_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Shivavasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/shivasa.svg"/>'+shiv_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Rahu Vasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+rahu_vaas_one+'.svg""/>'+rahu_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/shivasa.svg"/>'+shiv_vaas_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Kumbha Chakra</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+kumbha_chakra_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Yogini Vasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+yogini_vaas_one_img[0]+'.svg"/>'+yogini_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+kumbha_chakra_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>';

                        if (yogini_vaas_two.length > 0) {
                            let yogini_vaas_two_img = yogini_vaas_two.split(' ');

                            yogini_vaas_two += '<div class="divine-row dapi-row divine-row-pdd dapi-extra-desktop">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+yogini_vaas_two_img[0]+'.svg"/>'+yogini_vaas_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"></p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>';

                        }
                                    

                        nivas_shool_html += '</div>';


                        // *******************************

                        if (homahuti_two.length > 0) {
                            let disha_one_img = (disha_one.indexOf(' upto') != -1) ? disha_one.split(' upto') : disha_one;
                            disha_one_img = ($.isArray(disha_one_img)) ? disha_one_img[0] : disha_one_img;
                            let homahuti_two_name = homahuti_two.split(' ');

                            nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Homahuti</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_one_name[0].toLowerCase()+'.svg"/>'+homahuti_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_two_name[0].toLowerCase()+'.svg"/>'+homahuti_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    // +'<div class="dapi-col-6 dapi-col">'
                                    // +'<div class="divine-row dapi-row-lpdd">'
                                    // +'<div class="dapi-col-5">'
                                    // +'<p class="dapi_sub_ttl_1">Disha Shool</p>'
                                    // +'</div>'
                                    // +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    // +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+disha_one_img+'.svg"/>'+disha_one+'</p>'
                                    // +'</div>'
                                    // +'</div>'
                                    // +'</div>'

                                    +'</div>'

                        } else {

                            let disha_one_img =  (disha_one.indexOf(' upto') != -1) ? disha_one.split(' upto') : disha_one;
                            disha_one_img = ($.isArray(disha_one_img)) ? disha_one_img[0] : disha_one_img;
                            
                            nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Homahuti</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/homahutis/'+homahuti_one_name[0].toLowerCase()+'.svg"/>'+homahuti_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    

                                    +'</div>';

                        }

                         chandra_vaas_one_img =  (chandra_vaas_one.indexOf(' upto') != -1) ? chandra_vaas_one.split(' upto') : chandra_vaas_one;
                        chandra_vaas_one_img = ($.isArray(chandra_vaas_one_img)) ? chandra_vaas_one_img[0] : chandra_vaas_one_img;
                         agnivas_one_img = agnivas_one.split(' ');

                        nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'

                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Shivavasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/shivasa.svg"/>'+shiv_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/shivasa.svg"/>'+shiv_vaas_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Agnivasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/'+agnivas_one_img[0].toLowerCase()+'.svg"/>'+agnivas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+agnivas_two_img_src+'"/>'+agnivas_two+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    // +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    // +'<div class="dapi-col-6 dapi-col">'
                                    // +'<div class="divine-row dapi-row-lpdd">'
                                    // +'<div class="dapi-col-5">'
                                    // +'<p class="dapi_sub_ttl_1">Nakshatra Shool</p>'
                                    // +'</div>'
                                    // +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    // +'<p class="dapi-p">'+nakshatra_shool+'</p>'
                                    // +'</div>'
                                    // +'</div>'
                                    // +'</div>'
                                    // +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Disha Shool</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+disha_one_img+'.svg"/>'+disha_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Chandra Vasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+chandra_vaas_one_img+'.svg"/>'+chandra_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Rahu Vasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+rahu_vaas_one+'.svg""/>'+rahu_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    
                                    +'<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row dapi-row-lpdd">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Kumbha Chakra</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p">'+kumbha_chakra_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>';
                                    
                                    if(kumbha_chakra_two){
                    nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row dapi-row-lpdd">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1"></p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+kumbha_chakra_two+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                    }

                    nivas_shool_html += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'
                                    +'<div class="divine-row">'
                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1">Yogini Vasa</p>'
                                    +'</div>'
                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+yogini_vaas_one_img[0]+'.svg"/>'+yogini_vaas_one+'</p>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'

                                    // +'</div>'



                                    
                                    
                                    ;

                        if (yogini_vaas_two.length > 0) {
                            let yogini_vaas_two_img = yogini_vaas_two.split(' ');

                            yogini_vaas_two += '<div class="divine-row dapi-row divine-row-pdd dapi-display-mobile">'
                                    +'<div class="dapi-col-6 dapi-col">'

                                    +'<div class="divine-row">'

                                    +'<div class="dapi-col-5">'
                                    +'<p class="dapi_sub_ttl_1"></p>'
                                    +'</div>'

                                    +'<div class="dapi-col-7 dapi-col-sm-7">'
                                    +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/directions/'+yogini_vaas_two_img[0]+'.svg"/>'+yogini_vaas_two+'</p>'
                                    +'</div>'

                                    +'</div>'
                                    +'</div>';

                                    nivas_shool_html += '</div>';
                        }
                                    


                        $('#dapiac8').html(nivas_shool_html);
                        // $('#dapiac8-mb').html(nivas_shool_html_mb);
                        handle_acordian('dapiac8');

                    } else {
                        $('#dapiac8').html('<p class="text-danger">Something went wrong while fetching nivas and shool details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get nivas and shool: ' + e);

        }

    }

    function get_chandrabalam_tarabalam(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac9').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr9"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-2.divineapi.com/indian-api/v1/find-chandrabalam-and-tarabalam',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);

                        let chandra_tara_data = response.data;

                        let current_chandrabalams = chandra_tara_data.chandrabalams.current;
                        let next_chandrabalams = chandra_tara_data.chandrabalams.next;
                        let current_chandrabalams_upto = chandra_tara_data.chandrabalams.upto;

                        let current_tarabalams = chandra_tara_data.tarabalams.current;
                        let next_tarabalams = chandra_tara_data.tarabalams.next;
                        let current_tarabalams_upto = chandra_tara_data.tarabalams.upto;
                        
                        let chandra_tara_html = '<div class="divine-row dapi-row">'
                                    +'<div class="dapi-col-6 dapi-col dapi-no-p">'
                                    +'<p class="dapi-p-2">Good Chandrabalam till '+current_chandrabalams_upto+' for</p>'
                                    +'<div class="divine-row dapi-row">';
                                    $.each(current_chandrabalams, function(key, val) {

                                        let chandra_signs = val.split(' ');
                                        chandra_tara_html += '<div class="dapi-col-sm-6 dapi-smrows">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+chandra_signs[0].toLowerCase()+'.svg"/>'+val+'</p>'
                                                +'</div>';
            
                                    });
                                    chandra_tara_html += '</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col dapi-no-p">'
                                    +'<p class="dapi-p-2">Good Tarabalam till '+current_tarabalams_upto+' for</p>'
                                    +'<div class="divine-row dapi-row">';
                                    $.each(current_tarabalams, function(key, val) {

                                        chandra_tara_html += '<div class="dapi-col-sm-6 dapi-smrows">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+val.toLowerCase()+'.svg"/>'+val+'</p>'
                                                +'</div>';
            
                                    }); 
                                    let dnone = (next_chandrabalams.length > 0) ? '' : 'dapi-mb-dnone';
                                    chandra_tara_html += '</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col dapi-no-p '+dnone+'">';

                                    if (next_chandrabalams.length > 0) {
                                        chandra_tara_html += '<p class="dapi-p-2">Good Chandrabalam till next day sunrise for</p>'
                                    } else {
                                        chandra_tara_html += '<p class="dapi-p-2"></p>'
                                    }

                                    chandra_tara_html += '<div class="divine-row dapi-row">';
                                    $.each(next_chandrabalams, function(key, val) {

                                        let next_chandra_signs = val.split(' ');
                                        chandra_tara_html += '<div class="dapi-col-sm-6 dapi-smrows">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/signs/'+next_chandra_signs[0].toLowerCase()+'.svg"/>'+val+'</p>'
                                                +'</div>';
            
                                    });
                                    chandra_tara_html += '</div>'
                                    +'</div>'
                                    +'<div class="dapi-col-6 dapi-col dapi-column-2 dapi-no-p">'
                                    +'<p class="dapi-p-2">Good Tarabalam till next day sunrise for</p>'
                                    +'<div class="divine-row dapi-row">';
                                    $.each(next_tarabalams, function(key, val) {

                                        chandra_tara_html += '<div class="dapi-col-sm-6 dapi-smrows">'
                                                +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/nakshatras/'+val.toLowerCase()+'.svg"/>'+val+'</p>'
                                                +'</div>';
            
                                    });
                                    chandra_tara_html += '</div>'
                                    +'</div>'
                                    +'</div>';

                        $('#dapiac9').html(chandra_tara_html);
                        handle_acordian('dapiac9');

                    } else {
                        $('#dapiac9').html('<p class="text-danger">Something went wrong while fetching chandrabalam and tarabalam details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get chandrabalam and tarabalam: ' + e);

        }

    }

    function get_calendar_and_epoch(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#dapiac10').html('<div class="row"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr10"></div></div></div>');

            $.ajax({
                url: 'https://astroapi-2.divineapi.com/indian-api/v1/find-other-calendars-and-epoch',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);

                        let calendar_epoch_data = response.data;

                        let kaliyuga = calendar_epoch_data.kaliyuga;
                        let lahiri_ayanamsha = calendar_epoch_data.lahiri_ayanamsha;
                        let julian_day = calendar_epoch_data.julian_day;
                        let modified_julian_day = calendar_epoch_data.modified_julian_day;
                        let julian_date = calendar_epoch_data.julian_date;
                        let national_nirayana_date = calendar_epoch_data.national_nirayana_date;
                        let rata_die = calendar_epoch_data.rata_die;
                        let national_civil_date = calendar_epoch_data.national_civil_date;
                        let kali_ahargana = calendar_epoch_data.kali_ahargana;
                        
                        let chandra_tara_html = '<div class="divine-row dapi-row divine-row-pdd">'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">Kaliyuga</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+kaliyuga+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row dapi-row-lpdd">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">Lahiri Ayanamsha</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+lahiri_ayanamsha+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'

                                        +'<div class="divine-row dapi-row divine-row-pdd">'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">Kali Ahargana</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+kali_ahargana+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row dapi-row-lpdd">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">Rata Die</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+rata_die+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'

                                        +'<div class="divine-row dapi-row divine-row-pdd">'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">Julian Date</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+julian_date+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row dapi-row-lpdd">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">Julian Day</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+julian_day+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'

                                        +'<div class="divine-row dapi-row divine-row-pdd">'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">National Civil Date</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/indflag.svg"/>'+national_civil_date+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row dapi-row-lpdd">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">Modified Julian Day</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p">'+modified_julian_day+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'

                                        +'<div class="divine-row dapi-row divine-row-pdd">'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1">National Nirayana Date</p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p"><img class="dapi_img" src="'+plgn_base_url+'public/images/panchang/indflag.svg"/>'+national_nirayana_date+'</p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'<div class="dapi-col-6 dapi-col">'
                                        +'<div class="divine-row dapi-row-lpdd">'
                                        +'<div class="dapi-col-5">'
                                        +'<p class="dapi_sub_ttl_1"></p>'
                                        +'</div>'
                                        +'<div class="dapi-col-7 dapi-col-sm-7">'
                                        +'<p class="dapi-p"></p>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>';

                        $('#dapiac10').html(chandra_tara_html);
                        handle_acordian('dapiac10');

                    } else {
                        $('#dapiac10').html('<p class="text-danger">Something went wrong while fetching calendar and epoch details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get calendar and epoch: ' + e);

        }

    }


    function get_chandramasa(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $.ajax({
                url: 'https://astroapi-3.divineapi.com/indian-api/v1/chandramasa',
                method: 'post',
                headers: {
                    authorization: "Bearer " + access_token
                },
                data: {api_key: api_key, day: widget_day, month: widget_month, year: widget_year, lat: lat, lon: lon, tzone: timezone},
                success: function (data){
                    // var response = $.parseJSON(data);
                    var response = data;
                    
                    if (response.success == 1) {
                        
                        // console.log(response);
                        $('.amant_chandramasa').html(response.data.chandramasa + ' - Amanta');


                    } else {
                        $('#dapiac3').html('<p class="text-danger">Something went wrong while fetching chandramasa details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get udaya lagana: ' + e);

        }

    }

    function convert_date_to_hours_mins_ampm(string_to_convert) {

        let date_string = new Date(string_to_convert);
        let converted_date = date_string.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        // let converted_date = $.datepicker.formatTime('h:mm tt', {
        //     hour: date_string.getHours(),
        //     minute: date_string.getMinutes()
        // });

        return converted_date;

    }

    function convert_date_in_d_m_y_format(string_to_convert) {

        let date_string = new Date(string_to_convert);
        let converted_date = date_string.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        return converted_date;

    }

    function convert_date_in_d_M_format(string_to_convert) {

        let date_string = new Date(string_to_convert);

        let day = date_string.getDate();
        let monthIndex = date_string.getMonth();

        let monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        let converted_date = day + ' ' + monthNames[monthIndex];

        return converted_date;

    }


    function handle_acordian(id='dapiac11') {

        $("."+id).on("click", function() {

            // let id = $(this).attr('dapiac');
            // alert(id);
            // $(".dapi-panel").css("display", "none");
            $('#'+id).toggleClass("dapi-active");
            $('.'+id).toggleClass("collapsed");
            // $('#'+id).css("display", "block");
            
        });

    }

    function get_current_date() {

        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        return d.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;

    }

    function getPreviousDay(date = new Date()) {

        const previous = new Date(date.getTime());
        previous.setDate(date.getDate() - 1);
    
        var month = previous.getMonth()+1;
        var day = previous.getDate();

        return previous.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;

    }

    function getNextDay(date = new Date()) {

        const previous = new Date(date.getTime());
        previous.setDate(date.getDate() + 1);
    
        var month = previous.getMonth()+1;
        var day = previous.getDate();

        return previous.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;

    }

    function get_all_data(lat, lon, timezone) {

        // var timezone = '5.5';
        // var widget_day = '14';
        // var widget_month = '06';
        // var widget_year = '2023';

        let widget_date = $('#wdate-epoch').val();
        widget_date = (widget_date.length > 0) ? widget_date : get_current_date();

        // if (day_type != 'current') {
        //     if(day_type == 'prev') {
        //         widget_date = getPreviousDay(new Date(widget_date));
        //     } else {
        //         widget_date = getNextDay(new Date(widget_date));
        //     }
        // }

        var widget_date_details = widget_date.split('-');

        let widget_year = (typeof(widget_date_details[0] != 'undefined')) ? widget_date_details[0] : '2023';
        let widget_month = (typeof(widget_date_details[1] != 'undefined')) ? widget_date_details[1] : '06';
        let widget_day = (typeof(widget_date_details[2] != 'undefined')) ? widget_date_details[2] : '15';
        if(widget_year < 1422 || widget_year > 2823){
            $('#dapi-wdate-epoch-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-epoch-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-epoch-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-epoch-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-epoch-error').show();
            //     return false;
            // }
            $('#wdate-epoch').val(temp_date);
            $('#dapi-wdate-epoch-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac10').html('');

        get_calendar_and_epoch(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);


        handle_acordian();

    }

    // function isGoogleMapsLoaded() {
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);