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
    var in_auspi_timings_section_color = dp_options.in_auspi_timings_section_color;
    var in_auspi_timings_label_color = dp_options.in_auspi_timings_label_color;
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

    if (in_auspi_timings_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--in_auspi_timings_section_color', in_auspi_timings_section_color);
    }

    if (in_auspi_timings_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--in_auspi_timings_label_color', in_auspi_timings_label_color);
    }

    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapInaus', function() {
                // alert('Load was performed.');
               
            // });
            // if (isGoogleMapsLoadedInauspi()) {
            //     console.log('already loaded');
            //     initMapInaus();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapInaus();
            //     });
            // }
            // initMapInaus();
            selected_location = $('#dapi-location-inauspicious').val();
            $('#dapi-location-inauspicious').on('focusout', function(){
                if($('#dapi-location-inauspicious').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-in-auspicious').val(get_current_date());


            $('.dapi-dbtns-in-auspicious').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-in-auspicious').val();
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
                $('#wdate-in-auspicious').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-in-auspicious').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-in-auspicious').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location-inauspicious').on('click', function(){
                selected_location = $('#dapi-location-inauspicious').val();

                $('#dapi-location-inauspicious').val('');

            });

            $('#dapi-location-inauspicious').on('focusout', function() {

                $('#dapi-location-inauspicious').val(selected_location);

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

        let widget_date = $('#wdate-in-auspicious').val();
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
            $('#dapi-wdate-in-auspicious-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-in-auspicious-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-in-auspicious-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-in-auspicious-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-in-auspicious-error').show();
            //     return false;
            // }
            $('#wdate-in-auspicious').val(temp_date);
            $('#dapi-wdate-in-auspicious-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac7').html('');

        get_inauspicious_timings(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);

        handle_acordian();

    }

    // function isGoogleMapsLoadedInauspi() {
    //     console.log(typeof google !== 'undefined' && typeof google.maps !== 'undefined');
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);