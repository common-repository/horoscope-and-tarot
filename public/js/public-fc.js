;(function($) {
    "use strict";
    // console.log(fc_options);   

    var fc_api_url = 'https://divineapi.com/api/1.0/get_fortune_cookie.php'; 

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var api_key =            fc_options.token;
    let fc_color_text =      fc_options.color_text;
    let fc_font_size =      fc_options.font_size;
    let fc_color_theme =     fc_options.color_theme;
    let fc_color_category =  fc_options.color_category;

    api_key = atob(fc_options.token);

    if (fc_color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--fc-text-color', fc_color_text);
    }
    if (fc_font_size > 0) 
    {
        document.documentElement.style.setProperty('--fc-font-size', fc_font_size+'px');
    }
    if (fc_color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--fc-theme-color', fc_color_theme);
    }
    if (fc_color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--fc-category-color', fc_color_category);
    }  

    $(document).ready(function(){
    if(verified_domain(api_key) == 1) {
        $('#divine__fc__open').on('click', function(e){
            e.preventDefault();
            $('#divine__fc__overlay').show();
    
            $.ajax({
                url: fc_api_url,
                method: 'post',
                data: {api_key: api_key},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        $('.divine__fc__prev').hide();
                        $('.divine__fc__next').show();
                        let w_result = response.data;
                        let ans = w_result.prediction.result;

                        $('html, body').animate({
                            scrollTop: $("#divine-fortune-cookie").offset().top
                        }, 1000);
                        
                        $('.divine__fc__result').html("<p>"+ans+"</p>");
                        $('.divine__fc__desc').hide();
                        $('.divine__fc__subtitle').html('Here is the affirmative result as your answer for today.');
                        $('#divine__fc__overlay').hide();
                    }
                    else
                    {
                        $('#divine__fc__overlay').hide();
                        // alert(response.message);
                    }
                }
            });

        });

        $('#divine__fc__close').on('click', function(e){
            e.preventDefault();
            $('.divine__fc__desc').show();
            $('.divine__fc__subtitle').html('ASK THE FORTUNE COOKIE');
            $('html, body').animate({
                scrollTop: $("#divine-fortune-cookie").offset().top
            }, 1000);
            $('.divine__fc__next').hide();
            $('.divine__fc__prev').show();
            return;
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