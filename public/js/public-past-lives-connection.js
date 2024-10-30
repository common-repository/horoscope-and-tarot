;(function($) {
    "use strict";
    // console.log(past_lives_connection_options);
     
    var tpl_api_url = 'https://divineapi.com/api/1.0/get_past_lives_connection_reading.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var api_key =        past_lives_connection_options.token;
    let color_text =     past_lives_connection_options.color_text;
    let font_size =     past_lives_connection_options.font_size;
    let color_theme =    past_lives_connection_options.color_theme;
    let color_category = past_lives_connection_options.color_category;

    api_key = atob(past_lives_connection_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--plc-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--plc-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--plc-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--plc-category-color', color_category);
    }  

    $(document).ready(function(){
        $("#past-lives-connection").find("h3.divine__ta__heading").html('Past Lives Connection Reading');
        if(verified_domain(api_key) == 1) {
        $(document).on('click','#past-lives-connection .divine__ta__card', function(e){
            e.preventDefault();
            $("#past-lives-connection").find('#divine__ta__overlay').show();
            $.ajax({
                url: tpl_api_url,
                method: 'post',
                data: {api_key: api_key},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;
                        let card = result.card;
                        
                        var image = result.image;
                        
                        let card_result = result.result;
                        $("#past-lives-connection").find('.ta__card__image').attr("src",image);
                        $("#past-lives-connection").find('.divine__ta__cardname').html(card);
                       
                        $("#past-lives-connection").find('#TA-tab-data-1 p').html(card_result);
                        $("#past-lives-connection").find('.divine__ta__subheading').hide();
                        $("#past-lives-connection").find('.divine__ta__deck').hide();
                        $("#past-lives-connection").find('#widgetTA_result').show();
                        $('html, body').animate({
                            scrollTop: $("#past-lives-connection.divine__ta__widget").offset().top
                        }, 1000);
                        $("#past-lives-connection").find('#divine__ta__overlay').hide();
                    }
                    else
                    {
                        $("#past-lives-connection").find('#divine__ta__overlay').hide();
                        // alert(response.message);
                    }
                }
            });
        });

        $(document).on('click','#past-lives-connection .divine__ta__changecard__btn', function(e){
            e.preventDefault();
            $("#past-lives-connection").find('.divine__ta__subheading').html('Pick a card');
            $('html, body').animate({
                scrollTop: $("#past-lives-connection.divine__ta__widget").offset().top
            }, 1000);
            $("#past-lives-connection").find('.divine__ta__subheading').show();
            $("#past-lives-connection").find('.divine__ta__deck').show();
            $("#past-lives-connection").find('.ta__card__image').attr("src","");
            $("#past-lives-connection").find('.divine__ta__cardname').html("");
            
            $("#past-lives-connection").find('#TA-tab-data-1 p').html("");
            $("#past-lives-connection").find('#widgetTA_result').hide();
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