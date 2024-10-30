;(function($) {
    "use strict";
    // console.log(dream_come_true_reading_options);
     
    var tmw_api_url = 'https://divineapi.com/api/1.0/get_dream_come_true_reading.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var api_key =        dream_come_true_reading_options.token;
    let card_style =     dream_come_true_reading_options.card_style;
    let color_text =     dream_come_true_reading_options.color_text;
    let font_size =     dream_come_true_reading_options.font_size;
    let color_theme =    dream_come_true_reading_options.color_theme;
    let color_category = dream_come_true_reading_options.color_category;

    api_key = atob(dream_come_true_reading_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--dct-text-color', color_text);
    }
    if (font_size.length > 0) 
    {
        document.documentElement.style.setProperty('--dct-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--dct-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--dct-category-color', color_category);
    }  

    $(document).ready(function(){
        $("#dream-come-true-reading").find("h3.divine__ta__heading").html('Dream Come True Reading');
    if(verified_domain(api_key) == 1) {
        $(document).on('click','#dream-come-true-reading .divine__ta__card', function(e){
            e.preventDefault();
            $("#dream-come-true-reading").find('#divine__ta__overlay').show();
            $.ajax({
                url: tmw_api_url,
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
                        $("#dream-come-true-reading").find('.ta__card__image').attr("src",image);
                        $("#dream-come-true-reading").find('.divine__ta__cardname').html(card);
                       
                        $("#dream-come-true-reading").find('#TA-tab-data-1 p').html(card_result);
                        $("#dream-come-true-reading").find('.divine__ta__subheading').hide();
                        $("#dream-come-true-reading").find('.divine__ta__deck').hide();
                        $("#dream-come-true-reading").find('#widgetTA_result').show();
                        $('html, body').animate({
                            scrollTop: $("#dream-come-true-reading.divine__ta__widget").offset().top
                        }, 1000);
                        $("#dream-come-true-reading").find('#divine__ta__overlay').hide();
                    }
                    else
                    {
                        $("#dream-come-true-reading").find('#divine__ta__overlay').hide();
                        // alert(response.message);
                    }
                }
            });
        });

        $(document).on('click','#dream-come-true-reading .divine__ta__changecard__btn', function(e){
            e.preventDefault();
            $("#dream-come-true-reading").find('.divine__ta__subheading').html('Pick a card');
            $('html, body').animate({
                scrollTop: $("#dream-come-true-reading.divine__ta__widget").offset().top
            }, 1000);
            $("#dream-come-true-reading").find('.divine__ta__subheading').show();
            $("#dream-come-true-reading").find('.divine__ta__deck').show();
            $("#dream-come-true-reading").find('.ta__card__image').attr("src","");
            $("#dream-come-true-reading").find('.divine__ta__cardname').html("");
            
            $("#dream-come-true-reading").find('#TA-tab-data-1 p').html("");
            $("#dream-come-true-reading").find('#widgetTA_result').hide();
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