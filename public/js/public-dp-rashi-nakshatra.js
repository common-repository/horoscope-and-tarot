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
    var rashi_and_nakshatra_section_color = dp_options.rashi_and_nakshatra_section_color;
    var rashi_and_nakshatra_label_color = dp_options.rashi_and_nakshatra_label_color;
    
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

    if (rashi_and_nakshatra_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--rashi_and_nakshatra_section_color', rashi_and_nakshatra_section_color);
    }

    if (rashi_and_nakshatra_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--rashi_and_nakshatra_label_color', rashi_and_nakshatra_label_color);
    }

    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapNakshatra', function() {
            //     // alert('Load was performed.');
               
            // });
            // if (isGoogleMapsLoadedRashiNakshatra()) {
            //     console.log('already loaded');
            //     initMapNakshatra();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapNakshatra();
            //     });
            // }
            // initMapNakshatra();
            selected_location = $('#dapi-location-nakshatra').val();
            $('#dapi-location-nakshatra').on('focusout', function(){
                if($('#dapi-location-nakshatra').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-nakshatra').val(get_current_date());


            $('.dapi-dbtns-nakshatra').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-nakshatra').val();
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
                $('#wdate-nakshatra').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-nakshatra').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-nakshatra').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location-nakshatra').on('click', function(){
                selected_location = $('#dapi-location-nakshatra').val();

                $('#dapi-location-nakshatra').val('');

            });

            $('#dapi-location-nakshatra').on('focusout', function() {

                $('#dapi-location-nakshatra').val(selected_location);

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

                        get_rashi_and_nakshatra(response, widget_day, widget_month, widget_year);

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

        let widget_date = $('#wdate-nakshatra').val();
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
            $('#dapi-wdate-nakshatra-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-nakshatra-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-nakshatra-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-nakshatra-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-nakshatra-error').show();
            //     return false;
            // }
            $('#wdate-nakshatra').val(temp_date);
            $('#dapi-wdate-nakshatra-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac4').html('');



        get_panchang(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);


        handle_acordian();

    }

    // function isGoogleMapsLoadedRashiNakshatra() {
    //     console.log(typeof google !== 'undefined' && typeof google.maps !== 'undefined');
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);