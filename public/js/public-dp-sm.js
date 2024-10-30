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
    var sun_moon_section_color = dp_options.sun_moon_section_color;
    var sun_moon_label_color = dp_options.sun_moon_label_color;

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

    if (sun_moon_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--sun_moon_section_color', sun_moon_section_color);
    }

    if (sun_moon_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--sun_moon_label_color', sun_moon_label_color);
    }

    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapSM', function() {
            //     // alert('Load was performed.');

            // });
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMapSM();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapSM();
            //     });
            // }
            selected_location = $('#dapi-location-sm').val();
            $('#dapi-location-sm').on('focusout', function(){
                if($('#dapi-location-sm').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-sm').val(get_current_date());

            $('.dapi-dbtns-sm').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-sm').val();
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
                $('#wdate-sm').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-sm').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-sm').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location-sm').on('click', function(){
                selected_location = $('#dapi-location-sm').val();

                $('#dapi-location-sm').val('');

            });

            $('#dapi-location-sm').on('focusout', function() {

                $('#dapi-location-sm').val(selected_location);

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

        let widget_date = $('#wdate-sm').val();
        widget_date = (widget_date.length > 0) ? widget_date : get_current_date();

        var widget_date_details = widget_date.split('-');

        let widget_year = (typeof(widget_date_details[0] != 'undefined')) ? widget_date_details[0] : '2023';
        let widget_month = (typeof(widget_date_details[1] != 'undefined')) ? widget_date_details[1] : '06';
        let widget_day = (typeof(widget_date_details[2] != 'undefined')) ? widget_date_details[2] : '15';
        if(widget_year < 1422 || widget_year > 2823){
            $('#dapi-wdate-sm-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-sm-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-sm-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-sm-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-sm-error').show();
            //     return false;
            // }
            $('#wdate-sm').val(temp_date);
            $('#dapi-wdate-sm-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac1').html('');


        get_sunrise_and_moonrise(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);


        handle_acordian();

    }

    // function isGoogleMapsLoaded() {
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);