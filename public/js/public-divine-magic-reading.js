;(function($) {
    "use strict";
    // console.log(divine_magic_reading_options);
     
    var twm_api_url = 'https://divineapi.com/api/1.0/get_divine_magic_reading.php';
    var twm_file_url = 'https://divineapi.com/';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var widget_key =     divine_magic_reading_options.token;
    let card_style =     divine_magic_reading_options.card_style;
    let color_text =     divine_magic_reading_options.color_text;
    let font_size =     divine_magic_reading_options.font_size;
    let color_theme =    divine_magic_reading_options.color_theme;
    let color_category = divine_magic_reading_options.color_category;

    widget_key = atob(divine_magic_reading_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--dmr-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--dmr-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--dmr-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--dmr-category-color', color_category);
    }  


    $(document).ready(function(){
    if(verified_domain(widget_key) == 1) {
        $.ajax({
            url: twm_api_url,
            method: 'post',
            data: {api_key: widget_key, icon: card_style},
            success: function (data){
                var response = $.parseJSON(data);
                if (response.success == 1) 
                {
                    let result = response.data;
                    let card1 = result.card1;
                    let card2 = result.card2;
                    
                    var imageResult1 = result.card1_image;
                    var imageResult2 = result.card2_image;
                    
                    let cause = result.cause;
                    let remedy = result.remedy;

                    $("#divine-magic-reading").find('#WMCardImage_1').attr("data-src",imageResult1);
                    $("#divine-magic-reading").find('#WMCardImage_2').attr("data-src",imageResult2);

                    $("#divine-magic-reading").find('#WMcardName1').html("Cause ("+card1+")");
                    $("#divine-magic-reading").find('#TWM-tab-data-1 p').html(cause);

                    $("#divine-magic-reading").find('#WMcardName2').html("Remedy ("+card2+")");
                    $("#divine-magic-reading").find('#TWM-tab-data-2 p').html(remedy);

                    
                    $("#divine-magic-reading").find('#widgetTWM_result').hide();
                    $("#divine-magic-reading").find('.divine__ta__subheading').show();
                }
                else
                {
                }
            }
        });
        $(document).on('click','#divine-magic-reading #WMCardImage_1', function(e){
            var imUrl = $("#divine-magic-reading").find('#WMCardImage_1').attr("data-src");
            if(imUrl !='') {
                $("#divine-magic-reading").find('#WMCardImage_1').attr("src","");
                $("#divine-magic-reading").find('#WMCardImage_1').attr("src",imUrl);
                $("#divine-magic-reading").find('#WMCardImage_1').attr("data-src","");
            }
            
        });
        $(document).on('click','#divine-magic-reading #WMCardImage_2', function(e){
            var imUrl2 = $("#divine-magic-reading").find('#WMCardImage_2').attr("data-src");
            if(imUrl2 !='') {
                $("#divine-magic-reading").find('#WMCardImage_2').attr("src","");
                $("#divine-magic-reading").find('#WMCardImage_2').attr("src",imUrl2);
                $("#divine-magic-reading").find('#WMCardImage_2').attr("data-src","");
            }
        });


        $(document).on('click','#divine-magic-reading #get_WM_reading', function(e){
            var imUrl = $("#divine-magic-reading").find('#WMCardImage_1').attr("data-src");
            var imUrl2 = $("#divine-magic-reading").find('#WMCardImage_2').attr("data-src");
            if(imUrl !='') {
                alert('Please pick your cards');
            }
            else if(imUrl2 !='') {
                alert('Please pick your cards');
            }
            if(imUrl =='' && imUrl2 ==''){
                $("#divine-magic-reading").find('.divine__ta__subheading').hide();
                $("#divine-magic-reading").find('#widgetTWM_result').show();
                $("#divine-magic-reading").find('#get_WM_reading').hide();
            }
        });
        $(document).on('click','#divine-magic-reading #set_WM_reading', function(e){
            $.ajax({
                url: twm_api_url,
                method: 'post',
                data: {api_key: widget_key, icon: card_style},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;
                        let card1 = result.card1;
                        let card2 = result.card2;
                        
                        var imageResult1 = result.card1_image;
                        var imageResult2 = result.card2_image;
                        
                        let cause = result.cause;
                        let remedy = result.remedy;
                        
                        $("#divine-magic-reading").find('#WMCardImage_1').attr("src","");
                        $("#divine-magic-reading").find('#WMCardImage_2').attr("src","");

                        $("#divine-magic-reading").find('#WMCardImage_1').attr("src",twm_file_url+'widget/divine-magic-reading/images/white-magic-cause.png');
                        $("#divine-magic-reading").find('#WMCardImage_2').attr("src",twm_file_url+'widget/divine-magic-reading/images/white-magic-remedy.png');

                        $("#divine-magic-reading").find('#WMCardImage_1').attr("data-src",imageResult1);
                        $("#divine-magic-reading").find('#WMCardImage_2').attr("data-src",imageResult2);
                        
                        $("#divine-magic-reading").find('#WMcardName1').html("");
                        $("#divine-magic-reading").find('#WMcardName1').html("Cause ("+card1+")");

                        $("#divine-magic-reading").find('#TWM-tab-data-1 p').html("");
                        $("#divine-magic-reading").find('#TWM-tab-data-1 p').html(cause);

                        $("#divine-magic-reading").find('#WMcardName2').html("");
                        $("#divine-magic-reading").find('#WMcardName2').html("Remedy ("+card2+")");

                        $("#divine-magic-reading").find('#TWM-tab-data-2 p').html("");
                        $("#divine-magic-reading").find('#TWM-tab-data-2 p').html(remedy);

                        $("#divine-magic-reading").find('.divine__ta__subheading').show();
                        $("#divine-magic-reading").find('#widgetTWM_result').hide();
                        $("#divine-magic-reading").find('#get_WM_reading').show();
                    }
                    else
                    {
                        $("#divine-magic-reading").find('.divine__ta__subheading').show();
                        $("#divine-magic-reading").find('#widgetTWM_result').hide();
                        $("#divine-magic-reading").find('#get_WM_reading').hide();
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