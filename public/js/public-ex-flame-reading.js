;(function($) {
    "use strict";
    // console.log(ex_flame_reading_options);
     
    var tff_api_url = 'https://divineapi.com/api/1.0/get_ex_flame_reading.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var api_key =        ex_flame_reading_options.token;
    let card_style =     ex_flame_reading_options.card_style;
    let color_text =     ex_flame_reading_options.color_text;
    let font_size =     ex_flame_reading_options.font_size;
    let color_theme =    ex_flame_reading_options.color_theme;
    let color_category = ex_flame_reading_options.color_category;

    api_key = atob(ex_flame_reading_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--exf-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--exf-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--exf-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--exf-category-color', color_category);
    }  

    $(document).ready(function(){
        $("#ex-flame-reading").find("h3.divine__ta__heading").html('Tarot Ex-Flame Reading');
    if(verified_domain(api_key) == 1) {
        $(document).on('click','#ex-flame-reading .divine__ta__card', function(e){
            e.preventDefault();
            $("#ex-flame-reading").find('#divine__ta__overlay').show();
            $.ajax({
                url: tff_api_url,
                method: 'post',
                data: {api_key: api_key},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;
                        let card = result.card;
                        
                        if(card_style == 3)
                        {
                            var image = result.image3;
                        }
                        else if(card_style == 2)
                        {
                            var image = result.image2;
                        }
                        else
                        {
                            var image = result.image;
                        }
                        let card_result = result.result;
                        $("#ex-flame-reading").find('.ta__card__image').attr("src",image);
                        $("#ex-flame-reading").find('.divine__ta__cardname').html(card);
                       
                        $("#ex-flame-reading").find('#TA-tab-data-1 p').html(card_result);
                        $("#ex-flame-reading").find('.divine__ta__subheading').hide();
                        $("#ex-flame-reading").find('.divine__ta__deck').hide();
                        $("#ex-flame-reading").find('#widgetTA_result').show();
                        $('html, body').animate({
                            scrollTop: $("#ex-flame-reading.divine__ta__widget").offset().top
                        }, 1000);
                        $("#ex-flame-reading").find('#divine__ta__overlay').hide();
                    }
                    else
                    {
                        $("#ex-flame-reading").find('#divine__ta__overlay').hide();
                        // alert(response.message);
                    }
                }
            });
        });
        $(document).on('click','#ex-flame-reading .divine__ta__changecard__btn', function(e){
            e.preventDefault();
            $("#ex-flame-reading").find('.divine__ta__subheading').html('Pick a card');
            $('html, body').animate({
                scrollTop: $("#ex-flame-reading.divine__ta__widget").offset().top
            }, 1000);
            $("#ex-flame-reading").find('.divine__ta__subheading').show();
            $("#ex-flame-reading").find('.divine__ta__deck').show();
            $("#ex-flame-reading").find('.ta__card__image').attr("src","");
            $("#ex-flame-reading").find('.divine__ta__cardname').html("");
            
            $("#ex-flame-reading").find('#TA-tab-data-1 p').html("");
            $("#ex-flame-reading").find('#widgetTA_result').hide();
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