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

    var nivas_and_shool_section_color = dp_options.nivas_and_shool_section_color;
    var nivas_and_shool_label_color = dp_options.nivas_and_shool_label_color;

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


    if (nivas_and_shool_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--nivas_and_shool_section_color', nivas_and_shool_section_color);
    }

    if (nivas_and_shool_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--nivas_and_shool_label_color', nivas_and_shool_label_color);
    }

    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapShool', function() {
            //     // alert('Load was performed.');
                
            // });
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMapShool();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapShool();
            //     });
            // }
            selected_location = $('#dapi-location-shool').val();
            $('#dapi-location-shool').on('focusout', function(){
                if($('#dapi-location-shool').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-nivas').val(get_current_date());


            $('.dapi-dbtns-nivas').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-nivas').val();
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
                $('#wdate-nivas').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-nivas').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-nivas').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location-shool').on('click', function(){
                selected_location = $('#dapi-location-shool').val();

                $('#dapi-location-shool').val('');

            });

            $('#dapi-location-shool').on('focusout', function() {

                $('#dapi-location-shool').val(selected_location);

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

        let widget_date = $('#wdate-nivas').val();
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
            $('#dapi-wdate-nivas-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-nivas-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-nivas-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-nivas-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-nivas-error').show();
            //     return false;
            // }
            $('#wdate-nivas').val(temp_date);
            $('#dapi-wdate-nivas-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac8').html('');
        
        get_nivas_and_shool(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);


        handle_acordian();

    }

    // function isGoogleMapsLoaded() {
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);