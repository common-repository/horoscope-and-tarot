;(function($) {
    "use strict";
    // console.log(heartbreak_reading_options);
     
    var tb_api_url = 'https://divineapi.com/api/1.0/get_heartbreak_reading.php';
    var tb_file_url = 'https://divineapi.com/';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var widget_key =     heartbreak_reading_options.token;
    let card_style =     heartbreak_reading_options.card_style;
    let color_text =     heartbreak_reading_options.color_text;
    let font_size =     heartbreak_reading_options.font_size;
    let color_theme =    heartbreak_reading_options.color_theme;
    let color_category = heartbreak_reading_options.color_category;

    widget_key = atob(heartbreak_reading_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--hr-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--hr-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--hr-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--hr-category-color', color_category);
    }  

    $(document).ready(function(){
    if(verified_domain(widget_key) == 1) {
        $.ajax({
            url: tb_api_url,
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
                    let advice = result.advise;

                    $("#heartbreak-reading").find('#TBCardImage_1').attr("data-src",imageResult1);
                    $("#heartbreak-reading").find('#TBCardImage_2').attr("data-src",imageResult2);

                    $("#heartbreak-reading").find('#TBcardName1').html("Cause ("+card1+")");
                    $("#heartbreak-reading").find('#TB-tab-data-1 p').html(cause);

                    $("#heartbreak-reading").find('#TBcardName2').html("Advice ("+card2+")");
                    $("#heartbreak-reading").find('#TB-tab-data-2 p').html(advice);

                    
                    $("#heartbreak-reading").find('#widgetTB_result').hide();
                    $("#heartbreak-reading").find('.divine__ta__subheading').show();
                }
                else
                {
                   
                }
            }
        });
        $(document).on('click','#heartbreak-reading #TBCardImage_1', function(e){
            var imUrl = $("#heartbreak-reading").find('#TBCardImage_1').attr("data-src");
            if(imUrl !='') {
                $("#heartbreak-reading").find('#TBCardImage_1').attr("src","");
                $("#heartbreak-reading").find('#TBCardImage_1').attr("src",imUrl);
                $("#heartbreak-reading").find('#TBCardImage_1').attr("data-src","");
            }
        });
        $(document).on('click','#heartbreak-reading #TBCardImage_2', function(e){
            var imUrl2 = $("#heartbreak-reading").find('#TBCardImage_2').attr("data-src");
            if(imUrl2 !='') {
                $("#heartbreak-reading").find('#TBCardImage_2').attr("src","");
                $("#heartbreak-reading").find('#TBCardImage_2').attr("src",imUrl2);
                $("#heartbreak-reading").find('#TBCardImage_2').attr("data-src","");
            }
        });


        $(document).on('click','#heartbreak-reading #get_TB_reading', function(e){
            var imUrl = $("#heartbreak-reading").find('#TBCardImage_1').attr("data-src");
            var imUrl2 = $("#heartbreak-reading").find('#TBCardImage_2').attr("data-src");
            if(imUrl !='') {
                alert('Please pick your cards');
            }
            else if(imUrl2 !='') {
                alert('Please pick your cards');
            }
            if(imUrl =='' && imUrl2 ==''){
                $("#heartbreak-reading").find('.divine__ta__subheading').hide();
                $("#heartbreak-reading").find('#widgetTB_result').show();
                $("#heartbreak-reading").find('#get_TB_reading').hide();
            }
        });
        $(document).on('click','#heartbreak-reading #set_TB_reading', function(e){
            $.ajax({
                url: tb_api_url,
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
                        let advice = result.advise;
                        
                        $("#heartbreak-reading").find('#TBCardImage_1').attr("src","");
                        $("#heartbreak-reading").find('#TBCardImage_2').attr("src","");

                        $("#heartbreak-reading").find('#TBCardImage_1').attr("src",tb_file_url+'widget/heartbreak-reading/images/breakup-cause.png');
                        $("#heartbreak-reading").find('#TBCardImage_2').attr("src",tb_file_url+'widget/heartbreak-reading/images/breakup-advice.png');

                        $("#heartbreak-reading").find('#TBCardImage_1').attr("data-src",imageResult1);
                        $("#heartbreak-reading").find('#TBCardImage_2').attr("data-src",imageResult2);
                        
                        $("#heartbreak-reading").find('#TBcardName1').html("");
                        $("#heartbreak-reading").find('#TBcardName1').html("Cause ("+card1+")");

                        $("#heartbreak-reading").find('#TB-tab-data-1 p').html("");
                        $("#heartbreak-reading").find('#TB-tab-data-1 p').html(cause);

                        $("#heartbreak-reading").find('#TBcardName2').html("");
                        $("#heartbreak-reading").find('#TBcardName2').html("Advice ("+card2+")");

                        $("#heartbreak-reading").find('#TB-tab-data-2 p').html("");
                        $("#heartbreak-reading").find('#TB-tab-data-2 p').html(advice);

                        $("#heartbreak-reading").find('.divine__ta__subheading').show();
                        $("#heartbreak-reading").find('#widgetTB_result').hide();
                        $("#heartbreak-reading").find('#get_TB_reading').show();
                    }
                    else
                    {
                        $("#heartbreak-reading").find('.divine__ta__subheading').show();
                        $("#heartbreak-reading").find('#widgetTB_result').hide();
                        $("#heartbreak-reading").find('#get_TB_reading').hide();
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