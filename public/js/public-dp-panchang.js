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
    var panchang_section_color = dp_options.panchang_section_color;
    var panchang_label_color = dp_options.panchang_label_color;
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

    if (panchang_section_color.length > 0) 
    {
        document.documentElement.style.setProperty('--panchang_section_color', panchang_section_color);
    }

    if (panchang_label_color.length > 0) 
    {
        document.documentElement.style.setProperty('--panchang_label_color', panchang_label_color);
    }

    $(document).ready(function() {
        if(verified_domain(api_key) == 1) {
            // $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places&callback=initMapPanchang', function() {
            //     // alert('Load was performed.');
                
            // });
            // if (isGoogleMapsLoaded()) {
            //     console.log('already loaded');
            //     initMapPanchang();
            // } else {
            //     console.log('not loaded');
            //     $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpP-5WCGZu8_GxH6DdgqqUQFHtKprPHB0&libraries=places', function() {
            //         // alert('Load was performed.');
            //         initMapPanchang();
            //     });
            // }
            selected_location = $('#dapi-location').val();
            $('#dapi-location').on('focusout', function(){
                if($('#dapi-location').val() != ''){
                    setTimeout(function(){
                        lat = window.lat; 
                        lon = window.lon; 
                        timezone = window.timezone;
                        get_all_data(lat, lon, timezone);
                    }, 600);
                }
            });

            $('#wdate-panchang').val(get_current_date());
              

            $('.dapi-dbtns-panchang').on('click', function() {

                day_type = $(this).attr('dtyp');

                let widget_date = $('#wdate-panchang').val();
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
                $('#wdate-panchang').val(widget_date);
                widget_date_prev = widget_date;
                get_all_data(lat, lon, timezone);

            });

            $('#wdate-panchang').on('keyup change', function() {

                if(widget_date_prev != $('#wdate-panchang').val()){
                    get_all_data(lat, lon, timezone);
                }

            });

            $('#dapi-location').on('click', function(){
                selected_location = $('#dapi-location').val();

                $('#dapi-location').val('');

            });

            $('#dapi-location').on('focusout', function() {

                $('#dapi-location').val(selected_location);

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

        let widget_date = $('#wdate-panchang').val();
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
            $('#dapi-wdate-panchang-error').show();
            return false;
        }else if(widget_month < 1 || widget_month > 12){
            $('#dapi-wdate-panchang-error').show();
            return false;
        }else if(widget_day < 1 || widget_day > 31 || (widget_month == 2 && widget_day > 29)){
            $('#dapi-wdate-panchang-error').show();
            return false;
        }else{
            let temp_date = widget_year + '-' + widget_month + '-' + widget_day;
            if(widget_date != temp_date){
                $('#dapi-wdate-panchang-error').show();
                return false;
            }
            // if(typeof(widget_date_details[0] != 'undefined') || typeof(widget_date_details[1] != 'undefined') || typeof(widget_date_details[2] != 'undefined')){
            //     $('#dapi-wdate-panchang-error').show();
            //     return false;
            // }
            $('#wdate-panchang').val(temp_date);
            $('#dapi-wdate-panchang-error').hide();
            widget_date_prev = temp_date;
        }

        console.log(widget_year);

        $('#dapiac2').html('');


        get_panchang(api_key, widget_day, widget_month, widget_year, timezone, lat, lon, access_token);

        handle_acordian();

    }

    // function isGoogleMapsLoaded() {
    //     return typeof google !== 'undefined' && typeof google.maps !== 'undefined';
    // }

})(jQuery);