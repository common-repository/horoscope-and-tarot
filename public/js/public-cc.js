;(function($) {
    "use strict";
    // console.log(cc_options);

    var cc_api_url = 'https://divineapi.com/api/1.0/get_coffee_cup_reading.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var api_key =            cc_options.token;
    let cc_color_text =      cc_options.color_text;
    let cc_font_size =      cc_options.font_size;
    let cc_color_theme =     cc_options.color_theme;
    let cc_color_category =  cc_options.color_category;

    api_key = atob(cc_options.token);

    if (cc_color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--cc-text-color', cc_color_text);
    }
    if (cc_font_size > 0) 
    {
        document.documentElement.style.setProperty('--cc-font-size', cc_font_size+'px');
    }
    if (cc_color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--cc-theme-color', cc_color_theme);
    }
    if (cc_color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--cc-category-color', cc_color_category);
    }  

    $(document).ready(function(){
        if(verified_domain(api_key) == 1) {
          $(".divine__cc__unselected").on('click', function(event){
              event.stopPropagation();
              event.stopImmediatePropagation();
              $(this).addClass('divine__cc__selected');
              $(this).removeClass('divine__cc__unselected');
              let count = $('.divine__cc__selected').length;
              if(count == 1)
              {
                $('#cc-cup-count').html('2nd');
                return;
              }
              else if(count == 2)
              {
                $('#cc-cup-count').html('3rd');
                return;
              }
              else if(count == 3)
              {
                $('.divine__cc__desc').html('Generating result...');
              }
              $('#divine__cc__overlay').show();
              $.ajax({
                url: cc_api_url,
                method: 'post',
                data: {api_key: api_key},
                success: function(data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let api_data = response.data.prediction;
                        let present_title = api_data.present_title;
                        let present_content = api_data.present_content;
                        let present_image = api_data.present_image;

                        $('.divine__cc__subtitle').hide();
                        $('.divine__cc__desc').html('The answer you meant to know through the Coffee lies here.');

                        $('#divine-cc-present-image').html('<img src="'+present_image+'" width="200">');
                        $('#divine-cc-present-result').html('<h3>'+present_title+'</h3><p>'+present_content+'</p>');

                        let nf_title = api_data.near_future_title;
                        let nf_content = api_data.near_future_content;
                        let nf_image = api_data.near_future_image;
                        $('#divine-cc-nf-image').html('<img src="'+nf_image+'" width="200">');
                        $('#divine-cc-nf-result').html('<h3>'+nf_title+'</h3><p>'+nf_content+'</p>');

                        let df_title = api_data.distant_future_title;
                        let df_content = api_data.distant_future_content;
                        let df_image = api_data.distant_future_image;
                        $('#divine-cc-df-image').html('<img src="'+df_image+'" width="200">');
                        $('#divine-cc-df-result').html('<h3>'+df_title+'</h3><p>'+df_content+'</p>');
                        
                        $('html, body').animate({
                            scrollTop: $("#divine-coffee-cup").offset().top
                        }, 1000);
                        
                        $('.divine__cc__prev').hide();
                        $('.divine__cc__next').show();
                        $('#divine__cc__overlay').hide();
                    }
                    else
                    {
                        $('#divine__cc__overlay').hide();
                        // alert(response.message);
                    }
                }
              });
          });

            $('.divine__cc__reset__btn').on('click', function(e){
                
                $('.divine__cc__subtitle').show();
                $('#cc-cup-count').html('1st');
                
                var boxes = $('.divine__cc__selected');
                var boxesLength = boxes.length;

                $.each(boxes, function(index, value) {
                    $(value).removeClass('divine__cc__selected');
                    $(value).addClass('divine__cc__unselected');
                });

                $('html, body').animate({
                    scrollTop: $("#divine-coffee-cup").offset().top
                }, 1000);

                $('.divine__cc__desc').html('The Coffee grinds will take care of the message you need to hear');
                $('.divine__cc__next').hide();
                $('.divine__cc__prev').show();
            });

            $('.divine__cc__tablink').on('click', function(e){
                e.preventDefault();
                let active_content = $(this).attr('tab');
                $('.divine__cc__tablink.active').removeClass('active');
                $(this).addClass('active');
                $('.divine__cc__contentdata').hide();
                $('#cc-tab-data-'+active_content).show();
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