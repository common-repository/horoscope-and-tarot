;(function($) {
    "use strict";
    // console.log(ch_options);

    var api_path_dch = 'https://divineapi.com/api/1.0/get_chinese_horoscope.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var widget_date = $('.divine__dch__date__btn.active').attr('date');
    var sign = 'Dog'; 
   
    var widget_key      = ch_options.token; 
    var timezone        = ch_options.timezone;
    let color_text      = ch_options.color_text;
    let font_size       = ch_options.font_size;
    let color_theme     = ch_options.color_theme;
    let color_category  = ch_options.color_category;

    widget_key = atob(ch_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--category-color', color_category);
    }  
    // DATES
    var now = new Date();

    var yesterday = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+(now.getDate()-1);
    var today = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate();
    var tomorrow = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+(now.getDate()+1);

    var day = now.getDate();

    $(document).ready(function(){
        if(verified_domain(widget_key) == 1) {
        $('#divine__dh__overlay').show();
                
                $('#divine__dch__overlay').show();
                $.ajax({
                    url: api_path_dch,
                    method: 'post',
                    data: {api_key: widget_key, sign: sign, date: widget_date, timezone: timezone},
                    success: function (data){
                        var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let predResult = response.data;

                            
                            let prediction = predResult.prediction;

                            let description = prediction.result;

                            

                            let subtitle = sign+' Chinese Horoscope Today';

                            const fdate = new Date(widget_date);
                            const formattedDate = fdate.toLocaleDateString('en-GB', {
                              day: '2-digit', month: 'short', year: 'numeric'
                            }).replace(/ /g, ' ');
                            
                            $('.divine__dch__result__date').html("");
                            $('.divine__dch__result__date').html(formattedDate);

                            $('.divine__dch__date').html("");
                            $('.divine__dch__date').html(subtitle);

                            $('#Divineresult1 p').html("");
                            $('#Divineresult1 p').html(description);

                            $('#divine__dch__overlay').hide();
                        }
                        else
                        {
                            $('#divine__dch__overlay').hide();
                            // alert(response.message);
                        }
                    }
                });

                $('.divine__dch__date__btn').on('click', function(e){
                    $('#divine__dch__overlay').show();
                    e.preventDefault();
                    let day = $(this).attr('day');
                    
                    let h_date = $(this).attr('date');
                    widget_date = h_date;
                    let c_sign = $('.divine__dch__sign.active').attr('c_sign');
                    
                    $('.divine__dch__date').html(c_sign+' Chinese Horoscope '+day);
                    
                    const fdate = new Date(h_date);
                    const formattedDate = fdate.toLocaleDateString('en-GB', {
                      day: '2-digit', month: 'short', year: 'numeric'
                    }).replace(/ /g, ' ');
                    
                    $('.divine__dch__result__date').html("");
                    $('.divine__dch__result__date').html(formattedDate);

                    $('.divine__dch__date__btn.active').removeClass('active');
                    $(this).addClass('active');

                    $.ajax({
                        url: api_path_dch,
                        method: 'post',
                        data: {api_key: widget_key, sign: c_sign, date: h_date, timezone: timezone},
                        success: function (data){
                            var response = $.parseJSON(data);
                            if (response.success == 1) 
                            {
                                let predResult = response.data;

                                
                                let prediction = predResult.prediction;
    
                                let description = prediction.result;

                                $('#Divineresult1 p').html("");
                                $('#Divineresult1 p').html(description);

                                $('html, body').animate({
                                    scrollTop: $(".divine__dch__title").offset().top
                                }, 1000);

                                $('#divine__dch__overlay').hide();
                            }
                            else
                            {
                                $('#divine__dch__overlay').hide();
                                // alert('Some error occured!!!');
                            }
                        }
                    });
                });

                $('.divine__dch__signbox').on('click', function(e){
                    $('#divine__dch__overlay').show();
                    e.preventDefault();
                    let h_sign = $(this).attr('c_sign');
                    sign = h_sign;
                    $('.divine__dch__sign.active').removeClass('active');
                    $(this).children('.divine__dch__sign').addClass('active')
                    
                    
                    $('.divine__dch__date__btn.active').removeClass('active');
                    $('.divine__dch__date__btn:nth-child(2)').addClass('active');

                    $('.divine__dch__date__nav').hide(); // Hide Tabs
                    $('#divine-dch-set-daily').show(); // Show This Tabs
                    
                    widget_date = $('.divine__dch__date__btn.active').attr('date');
                    const fdate = new Date(widget_date);
                    const formattedDate = fdate.toLocaleDateString('en-GB', {
                      day: '2-digit', month: 'short', year: 'numeric'
                    }).replace(/ /g, ' ');
                    
                    $('.divine__dch__result__date').html(formattedDate);
                    $('.divine__dch__date').html(h_sign+' Chinese Horoscope Today');
         
                    $.ajax({
                        url: api_path_dch,
                        method: 'post',
                        data: {api_key: widget_key, sign: h_sign, date: widget_date, timezone: timezone},
                        success: function (data){
                            var response = $.parseJSON(data);
                            if (response.success == 1) 
                            {
                                let result = response.data;

                                let sign = result.sign;
                                let prediction = result.prediction;
    
                                let description = prediction.result;

                                $('#Divineresult1 p').html("");

                                $('#Divineresult1 p').html(description);

                                $('#divine__dch__overlay').hide();
                            }
                            else
                            {
                                $('#divine__dch__overlay').hide();
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
        }else{
            return true;
        }
    }
})(jQuery);