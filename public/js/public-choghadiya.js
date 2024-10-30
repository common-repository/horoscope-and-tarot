(function($) {
    "use strict";
    
    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var api_key =            choghadiya_options.api_key;
    var access_token =       choghadiya_options.access_token;
    var timezone =           choghadiya_options.timezone;
    var lat =                choghadiya_options.lat;
    var lon =                choghadiya_options.lon;
    var widget_date_prev =   '';
    let background_color = choghadiya_options.background_color;
    let good_color = choghadiya_options.good_color;
    let bad_color = choghadiya_options.bad_color;
    let neutral_color = choghadiya_options.neutral_color;
    let title_color = choghadiya_options.title_color;
    let timings_color = choghadiya_options.timings_color;
    let button_color = choghadiya_options.button_color;
    let button_text_color = choghadiya_options.button_text_color;
    let day_choghadiya_bg_color = choghadiya_options.day_choghadiya_bg_color;
    let day_choghadiya_text_color = choghadiya_options.day_choghadiya_text_color;
    let night_choghadiya_bg_color = choghadiya_options.night_choghadiya_bg_color;
    let night_choghadiya_text_color = choghadiya_options.night_choghadiya_text_color;
    var plgn_base_url = choghadiya_options.plgn_base_url;
    let day_type = 'current';
    var selected_location = '';

    api_key = atob(choghadiya_options.api_key);
    access_token = atob(choghadiya_options.access_token);

    access_token = "Bearer " + access_token;

    if (background_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_background_color', background_color);
    }

    if (good_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_good_color', good_color);
    }

    if (bad_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_bad_color', bad_color);
    }

    if (neutral_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_neutral_color', neutral_color);
    }

    if (title_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_title_color', title_color);
    }

    if (timings_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_timings_color', timings_color);
    }

    if (button_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_button_color', button_color);
    }

    if (button_text_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_button_text_color', button_text_color);
    }

    if (day_choghadiya_bg_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_day_choghadiya_bg_color', day_choghadiya_bg_color);
    }

    if (day_choghadiya_text_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_day_choghadiya_text_color', day_choghadiya_text_color);
    }

    if (night_choghadiya_bg_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_night_choghadiya_bg_color', night_choghadiya_bg_color);
    }

    if (night_choghadiya_text_color.length > 0) 
    {
        document.documentElement.style.setProperty('--chg_night_choghadiya_text_color', night_choghadiya_text_color);
    }
    
    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapChoghadiya', function() {
            
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMapChoghadiya();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapChoghadiya();
            //     });
            // }
            // initMapChoghadiya();

            selected_location = $('#dapi-lcn').val();
            $('#dapi-lcn').on('focusout', function(){
                if($('#dapi-lcn').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        console.log('dapi-lcn', lat,lon, timezone);
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-choghadiya').val(get_current_date());
            
            $('.dapi-dbtns-choghadiya').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-choghadiya').val();
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
                $('#wdate-choghadiya').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-choghadiya').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-choghadiya').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-lcn').on('click', function(){
                selected_location = $('#dapi-lcn').val();

                $('#dapi-lcn').val('');

            });

            $('#dapi-lcn').on('focusout', function() {

                $('#dapi-lcn').val(selected_location);

            });

            get_all_data(lat, lon, timezone);

        }
        else {
            $('#choghadiya-auth p').html("** You can use this API key only for registerd website on divine **");
            $('.dapi-sec-choghadiya').hide();
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

        let widget_date = $('#wdate-choghadiya').val();
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
            $('#dapi-wdate-choghadiya-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-choghadiya-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-choghadiya-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-choghadiya-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-choghadiya-error').show();
            //     return false;
            // }
            $('#wdate-choghadiya').val(temp_date);
            $('#dapi-wdate-choghadiya-error').hide();
            widget_date_prev = temp_date;
        }

        // console.log(widget_year);

        // $('.clrd').html('');

        get_choghadiya(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);

    }

    function get_choghadiya(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token) {

        try {

            $('#choghadiya_dtls').html('<div class="col-lg-4 mx-auto dapi-text-center"><div class="dapi-sp sp-ldr1"></div></div>');

            $.ajax({
                url: 'https://astroapi-2.divineapi.com/indian-api/v1/find-choghadiya',//4
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

                        let day_choghadiyas = response.data.day_choghadiyas;

                        let night_choghadiyas = response.data.night_choghadiyas;

                        let choghadiyas_html_one = `<table class="dapi-tbl">
                                                    <tr>
                                                        <th colspan="2">
                                                            <div class="dapi-tbl-th dapi-daychg">
                                                                Day Choghadiya <span style="float:right;"></span>
                                                            </div>
                                                        </th>
                                                    </tr>`;

                        $.each(day_choghadiyas, function(key, val) {

                            let cls = '';
                            let nm = '';
                            if (key == 'Shubh' || key == 'Labh' || key == 'Amrit' || key == 'Next Shubh' || key == 'Next Labh' || key == 'Next Amrit') {
                                cls = 'dapi-td-good';
                                nm = 'Good';
                            } else if (key == 'Kaal' || key == 'Rog' || key == 'Udveg' || key == 'Next Kaal' || key == 'Next Rog' || key == 'Next Udveg') {
                                cls = 'dapi-td-ngood';
                                nm = 'Bad';
                            } else {
                                cls = 'dapi-td-normal';
                                nm = 'Neutral';
                            }

                            choghadiyas_html_one += `<tr>
                                                        <td>
                                                            <div class="dapi-tbl-ibx `+cls+`">
                                                                `+key+` - `+nm+`
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="dapi-tbl-ibx dapi-timings">
                                                                `+val+`
                                                            </div>
                                                        </td>
                                                    </tr>`;

                        });

                        choghadiyas_html_one += '</table>';

                        let choghadiyas_html_two = `<table class="dapi-tbl">
                                                    <tr>
                                                        <th colspan="2">
                                                            <div class="dapi-tbl-th dapi-nightchg">
                                                                Night Choghadiya <span style="float:right;"></span>
                                                            </div>
                                                        </th>
                                                    </tr>`;

                        $.each(night_choghadiyas, function(key, val) {

                            let cls = 'dapi-td-normal';
                            let nm = 'Neutral';
                            if (key == 'Shubh' || key == 'Labh' || key == 'Amrit' || key == 'Next Shubh' || key == 'Next Labh' || key == 'Next Amrit') {
                                cls = 'dapi-td-good';
                                nm = 'Good';
                            } else if (key == 'Kaal' || key == 'Rog' || key == 'Udveg' || key == 'Next Kaal' || key == 'Next Rog' || key == 'Next Udveg') {
                                cls = 'dapi-td-ngood';
                                nm = 'Bad';
                            }

                            choghadiyas_html_two += `<tr>
                                                        <td>
                                                            <div class="dapi-tbl-ibx `+cls+`">
                                                                `+key+` - `+nm+`
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="dapi-tbl-ibx dapi-timings">
                                                                `+val+`
                                                            </div>
                                                        </td>
                                                    </tr>`;

                        });

                        choghadiyas_html_two += '</table>';

                        let choghadiyas = `<div class="dapi-w50">`+choghadiyas_html_one+`</div><div class="dapi-w50">`+choghadiyas_html_two+`</div>`;

                        $('#choghadiya_dtls').html(choghadiyas);
                        $('#choghadiya_dtls').show();

                    } else {
                        $('#choghadiya_dtls').html('<p class="text-danger">Something went wrong while fetching choghadiya details!</p>');
                    }
                    
                }
            });

        } catch (e) {

            console.log('Error in get choghadiya: ' + e);

        }

    }

    // function isGoogleMapsLoaded() {
    //     console.log(typeof google !== 'undefined' && typeof google.maps !== 'undefined');
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);