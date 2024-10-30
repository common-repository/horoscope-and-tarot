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
    
    var lunar_month_and_samvat_section_color = dp_options.lunar_month_and_samvat_section_color;
    var lunar_month_and_samvat_label_color = dp_options.lunar_month_and_samvat_label_color;
    
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

    if (lunar_month_and_samvat_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--lunar_month_and_samvat_section_color', lunar_month_and_samvat_section_color);
    }

    if (lunar_month_and_samvat_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--lunar_month_and_samvat_label_color', lunar_month_and_samvat_label_color);
    }


    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapSamvat', function() {
                
            // });
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMapSamvat();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapSamvat();
            //     });
            // }
            selected_location = $('#dapi-location-samvat').val();
            $('#dapi-location-samvat').on('focusout', function(){
                if($('#dapi-location-samvat').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-samvat').val(get_current_date());

            $('.dapi-dbtns-samvat').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-samvat').val();
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
                $('#wdate-samvat').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-samvat').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-samvat').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location-samvat').on('click', function(){
                selected_location = $('#dapi-location-samvat').val();

                $('#dapi-location-samvat').val('');

            });

            $('#dapi-location-samvat').on('focusout', function() {

                $('#dapi-location-samvat').val(selected_location);

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

        let widget_date = $('#wdate-samvat').val();
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
            $('#dapi-wdate-samvat-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-samvat-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-samvat-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-samvat-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-samvat-error').show();
            //     return false;
            // }
            $('#wdate-samvat').val(temp_date);
            $('#dapi-wdate-samvat-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac3').html('');

        get_lunar_month_and_samvat(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);

        handle_acordian();

    }

    // function isGoogleMapsLoaded() {
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);