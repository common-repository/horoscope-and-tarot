;(function($) {
    "use strict";
    // console.log(made_for_each_other_reading_options);
     
    var tlp_api_url = 'https://divineapi.com/api/1.0/get_made_for_each_other_or_not_reading.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var api_key =        made_for_each_other_reading_options.token;
    let card_style =     made_for_each_other_reading_options.card_style;
    let color_text =     made_for_each_other_reading_options.color_text;
    let font_size =     made_for_each_other_reading_options.font_size;
    let color_theme =    made_for_each_other_reading_options.color_theme;
    let color_category = made_for_each_other_reading_options.color_category;

    api_key = atob(made_for_each_other_reading_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--meo-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--meo-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--meo-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--meo-category-color', color_category);
    }  

    $(document).ready(function(){

        $("#made-for-each-other-reading").find("h3.divine__ta__heading").html('Made For Each Other Or Not Reading');
        if(verified_domain(api_key) == 1) {
        $(document).on('click','#made-for-each-other-reading .divine__ta__card', function(e){
            e.preventDefault();
            $("#made-for-each-other-reading").find('#divine__ta__overlay').show();
            $.ajax({
                url: tlp_api_url,
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
                        $("#made-for-each-other-reading").find('.ta__card__image').attr("src",image);
                        $("#made-for-each-other-reading").find('.divine__ta__cardname').html(card);
                       
                        $("#made-for-each-other-reading").find('#TA-tab-data-1 p').html(card_result);
                        $("#made-for-each-other-reading").find('.divine__ta__subheading').hide();
                        $("#made-for-each-other-reading").find('.divine__ta__deck').hide();
                        $("#made-for-each-other-reading").find('#widgetTA_result').show();
                        $('html, body').animate({
                            scrollTop: $("#made-for-each-other-reading.divine__ta__widget").offset().top
                        }, 1000);
                        $("#made-for-each-other-reading").find('#divine__ta__overlay').hide();
                    }
                    else
                    {
                        $("#made-for-each-other-reading").find('#divine__ta__overlay').hide();
                        // alert(response.message);
                    }
                }
            });
        });

        $(document).on('click','#made-for-each-other-reading .divine__ta__changecard__btn', function(e){
            e.preventDefault();
            $("#made-for-each-other-reading").find('.divine__ta__subheading').html('Pick a card');
            $('html, body').animate({
                scrollTop: $("#made-for-each-other-reading.divine__ta__widget").offset().top
            }, 1000);
            $("#made-for-each-other-reading").find('.divine__ta__subheading').show();
            $("#made-for-each-other-reading").find('.divine__ta__deck').show();
            $("#made-for-each-other-reading").find('.ta__card__image').attr("src","");
            $("#made-for-each-other-reading").find('.divine__ta__cardname').html("");
            
            $("#made-for-each-other-reading").find('#TA-tab-data-1 p').html("");
            $("#made-for-each-other-reading").find('#widgetTA_result').hide();
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