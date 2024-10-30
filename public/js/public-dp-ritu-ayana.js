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

    var ritu_and_ayana_section_color = dp_options.ritu_and_ayana_section_color;
    var ritu_and_ayana_label_color = dp_options.ritu_and_ayana_label_color;
    
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


    if (ritu_and_ayana_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--ritu_and_ayana_section_color', ritu_and_ayana_section_color);
    }

    if (ritu_and_ayana_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--ritu_and_ayana_label_color', ritu_and_ayana_label_color);
    }
 

    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapAyana', function() {
            //     // alert('Load was performed.');
                
            // });
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMapAyana();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapAyana();
            //     });
            // }
            selected_location = $('#dapi-location-ayana').val();
            $('#dapi-location-ayana').on('focusout', function(){
                if($('#dapi-location-ayana').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-ritu-ayana').val(get_current_date());

            $('.dapi-dbtns-ritu-ayana').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-ritu-ayana').val();
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
                $('#wdate-ritu-ayana').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-ritu-ayana').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-ritu-ayana').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location-ayana').on('click', function(){
                selected_location = $('#dapi-location-ayana').val();

                $('#dapi-location-ayana').val('');

            });

            $('#dapi-location-ayana').on('focusout', function() {

                $('#dapi-location-ayana').val(selected_location);

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

        let widget_date = $('#wdate-ritu-ayana').val();
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
            $('#dapi-wdate-ritu-ayana-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-ritu-ayana-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-ritu-ayana-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-ritu-ayana-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-ritu-ayana-error').show();
            //     return false;
            // }
            $('#wdate-ritu-ayana').val(temp_date);
            $('#dapi-wdate-ritu-ayana-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac5').html('');

        get_ritu_and_ayana(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);


        handle_acordian();

    }

    // function isGoogleMapsLoaded() {
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);