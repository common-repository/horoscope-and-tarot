;(function($) {
    "use strict";
    // console.log(nh_options);

    const number_words = ["One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];

    var api_path_dnh = 'https://divineapi.com/api/1.0/get_numerology_horoscope.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
 
    var widget_date = $('.divine__dnh__date__btn.active').attr('date'); 
    var number = 1;


    var widget_key      = nh_options.token; 
    var timezone        = nh_options.timezone;
    let color_text      = nh_options.color_text;
    let font_size       = nh_options.font_size;
    let color_theme     = nh_options.color_theme;
    let color_category  = nh_options.color_category;

    widget_key = atob(nh_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--nh-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--nh-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--nh-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--nh-category-color', color_category);
    }  

    // DATES
    var now = new Date();

    var yesterday = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+(now.getDate()-1);
    var today = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate();
    var tomorrow = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+(now.getDate()+1);

    var day = now.getDate();

    $(document).ready(function(){
    if(verified_domain(widget_key) == 1) {
        $('#divine__dnh__overlay').show();
                $.ajax({
                    url: api_path_dnh,
                    method: 'post',
                    data: {api_key: widget_key, number: number, date: widget_date, timezone: timezone},
                    success: function (data){
                        var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;

                            let resNumber = result.number;
                            let prediction = result.prediction;

                            let description = prediction.result;

                            number = number_words[resNumber-1];

                            let subtitle = resNumber+' Numerology Horoscope';

                            const fdate = new Date(widget_date);
                            const formattedDate = fdate.toLocaleDateString('en-GB', {
                              day: '2-digit', month: 'short', year: 'numeric'
                            }).replace(/ /g, ' ');
                            
                            $('.divine__dnh__result__date').html(formattedDate);

                            $('.divine__dnh__date').html(subtitle);

                            $('#Divineresult p').html(description);

                            $('#divine__dnh__overlay').hide();
                        }
                        else
                        {
                            $('#divine__dnh__overlay').hide();
                            // alert(response.message);
                        }
                    }
                });

                $('.divine__dnh__date__btn').on('click', function(e){
                    $('#divine__dnh__overlay').show();
                    e.preventDefault();
                    let day = $(this).attr('day');
                    
                    let h_date = $(this).attr('date');
                    widget_date = h_date;
                    let number = $('.divine__dnh__number.active').attr('number');
                    
                    $('.divine__dnh__date').html(number+' Numerology Horoscope');
                    
                    const fdate = new Date(h_date);
                    const formattedDate = fdate.toLocaleDateString('en-GB', {
                      day: '2-digit', month: 'short', year: 'numeric'
                    }).replace(/ /g, ' ');
                    
                    $('.divine__dnh__result__date').html(formattedDate);

                    $('.divine__dnh__date__btn.active').removeClass('active');
                    $(this).addClass('active');

                    $.ajax({
                        url: api_path_dnh,
                        method: 'post',
                        data: {api_key: widget_key, number: number, date: h_date, timezone: timezone},
                        success: function (data){
                            var response = $.parseJSON(data);
                            if (response.success == 1) 
                            {
                                let result = response.data;

                                let resNumber = result.number;
                                let prediction = result.prediction;
    
                                let description = prediction.result;

                                $('#Divineresult p').html(description);

                                $('html, body').animate({
                                    scrollTop: $(".divine__dnh__title").offset().top
                                }, 1000);

                                $('#divine__dnh__overlay').hide();
                            }
                            else
                            {
                                $('#divine__dnh__overlay').hide();
                                // alert('Some error occured!!!');
                            }
                        }
                    });
                });

                $('.divine__dnh__numberbox').on('click', function(e){
                    $('#divine__dnh__overlay').show();
                    e.preventDefault();
                    let h_number = $(this).attr('number');
                    number = h_number;
                    $('.divine__dnh__number.active').removeClass('active');
                    $(this).children('.divine__dnh__number').addClass('active')
                    
                    
                    $('.divine__dnh__date__btn.active').removeClass('active');
                    $('.divine__dnh__date__btn:nth-child(2)').addClass('active');

                    $('.divine__dnh__date__nav').hide(); // Hide Tabs
                    $('#divine-dnh-set-daily').show(); // Show This Tabs
                    
                    widget_date = $('.divine__dnh__date__btn.active').attr('date');
                    const fdate = new Date(widget_date);
                    const formattedDate = fdate.toLocaleDateString('en-GB', {
                      day: '2-digit', month: 'short', year: 'numeric'
                    }).replace(/ /g, ' ');
                    
                    $('.divine__dnh__result__date').html(formattedDate);
                    $('.divine__dnh__date').html(h_number+' Numerology Horoscope');
         
                    $.ajax({
                        url: api_path_dnh,
                        method: 'post',
                        data: {api_key: widget_key, number: h_number, date: widget_date, timezone: timezone},
                        success: function (data){
                            var response = $.parseJSON(data);
                            if (response.success == 1) 
                            {
                                let result = response.data;

                                let resNumber = result.number;
                                let prediction = result.prediction;
    
                                let description = prediction.result;

                                $('#Divineresult p').html(description);

                                $('#divine__dnh__overlay').hide();
                            }
                            else
                            {
                                $('#divine__dnh__overlay').hide();
                                // alert(response.message);
                            }
                        }
                    });
                });
            }
            else {
                $('.divine_auth_domain_response p').html("** You can use this API key only for registerd website on divine **");
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
        }
    }
})(jQuery);