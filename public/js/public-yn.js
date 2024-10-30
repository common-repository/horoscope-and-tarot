;(function($) {
    "use strict";
    // console.log(yn_options);      

    var yn_api_url = 'https://divineapi.com/api/1.0/get_yes_or_no_tarot.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var api_key =           yn_options.token;
    let card_style =        yn_options.card_style;
    let yn_color_text =     yn_options.color_text;
    let yn_font_size =     yn_options.font_size;
    let yn_color_theme =    yn_options.color_theme;
    let yn_color_category = yn_options.color_category;

    api_key = atob(yn_options.token);

    if (yn_color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--yn-text-color', yn_color_text);
    }
    if (yn_font_size > 0) 
    {
        document.documentElement.style.setProperty('--yn-font-size', yn_font_size+'px');
    }
    if (yn_color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--yn-theme-color', yn_color_theme);
    }
    if (yn_color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--yn-category-color', yn_color_category);
    }

    let width = $('.divine__yn__widget').width();
    if (width <= 500) 
    {
        $('.divine__yn__widget').addClass('divine__yn__widget__sm');
    }
    else
    {
        $('.divine__yn__widget').removeClass('divine__yn__widget__sm');
    }

    $(document).ready(function(){
        if(verified_domain(api_key) == 1) {
        $('.divine__yn__card').on('click', function(e){
            e.preventDefault();
            $('#divine__yn__overlay').show();
            $.ajax({
                url: yn_api_url,
                method: 'post',
                data: {api_key: api_key},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;
                        if(card_style == 1)
                        {
                            var image = result.image2;
                        }
                        else
                        {
                            var image = result.image;
                        }
                        let card = result.card;
                        let category = result.category;
                        let yn_result = result.result;
                        let yes_no = result.yes_no;
                        $('.yn__card__image').attr("src",image);
                        $('.divine__yn__cardname').html(card+' ('+category+')');
                        $('.divine__yn__cardresult').html(yes_no);
                        $('.divine__yn__result').html(yn_result);
                        $('.divine__yn__subheading').hide();
                        $('.divine__yn__deck').hide();
                        $('#divineYN_result').show();
                        $('#divine__yn__overlay').hide();
                        // $('html, body').animate({
                        //     scrollTop: $(".divine__yn__widget").offset().top
                        // }, 1000);
                    }
                    else
                    {
                        $('#divine__yn__overlay').hide();
                        // alert(response.message);
                    }
                }
            });
        
        });

        $('.divine__yn__changecard__btn').on('click', function(e){
            e.preventDefault();
            $('.divine__yn__subheading').html('Pick a card');
            // $('html, body').animate({
            //     scrollTop: $(".divine__yn__widget").offset().top
            // }, 1000);
            $('.divine__yn__deck').show();
            $('.divine__yn__subheading').show();
            $('#divineYN_result').hide();
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