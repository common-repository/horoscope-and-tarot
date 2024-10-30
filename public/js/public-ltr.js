;(function($) {
    "use strict";
    // console.log(ch_options);

    var base_path_tlt = 'https://divineapi.com/widget/love-triangle-reading/';
    var tlt_api_url = 'https://divineapi.com/api/1.0/get_love_triangle_reading.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var widget_key      = ltr_options.token; 
    let color_text      = ltr_options.color_text;
    let font_size      = ltr_options.font_size;
    let color_theme     = ltr_options.color_theme;
    let color_category  = ltr_options.color_category;
    let card_style =     ltr_options.card_style;

    widget_key = atob(ltr_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--ltr-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--ltr-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--ltr-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--ltr-category-color', color_category);
    }  

    $(document).ready(function(){
        if(verified_domain(widget_key) == 1 || 1) {
        $.ajax({
            url: tlt_api_url,
            method: 'post',
            data: {api_key: widget_key, icon: card_style},
            success: function (data){
                var response = $.parseJSON(data);
                if (response.success == 1) 
                {
                    let result = response.data;
                    let card1 = result.card1;
                    let card2 = result.card2;
                    let card3 = result.card3;
                    
                    var imageResult1 = result.card1_image;
                    var imageResult2 = result.card2_image;
                    var imageResult3 = result.card3_image;
                    
                    let you = result.your;
                    let lover1 = result.lover1;
                    let lover2 = result.lover2;

                    $("#love-triangle-reading").find('#TLTCardImage_1').attr("data-src",imageResult1);
                    $("#love-triangle-reading").find('#TLTCardImage_2').attr("data-src",imageResult2);
                    $("#love-triangle-reading").find('#TLTCardImage_3').attr("data-src",imageResult3);

                    $("#love-triangle-reading").find('#TLTcardName1').html("You ("+card1+")");
                    $("#love-triangle-reading").find('#TLT-tab-data-1 p').html(you);

                    $("#love-triangle-reading").find('#TLTcardName2').html("Lover 1 ("+card2+")");
                    $("#love-triangle-reading").find('#TLT-tab-data-2 p').html(lover1);

                    $("#love-triangle-reading").find('#TLTcardName3').html("Lover 2 ("+card3+")");
                    $("#love-triangle-reading").find('#TLT-tab-data-3 p').html(lover2);

                    
                    $("#love-triangle-reading").find('#widgetTLT_result').hide();
                    $("#love-triangle-reading").find('.divine__ta__subheading').show();
                }
                else
                {
                   
                }
            }
        });
        $(document).on('click','#love-triangle-reading #TLTCardImage_1', function(e){
            var imUrl = $("#love-triangle-reading").find('#TLTCardImage_1').attr("data-src");
            if(imUrl !='') {
                $("#love-triangle-reading").find('#TLTCardImage_1').attr("src","");
                $("#love-triangle-reading").find('#TLTCardImage_1').attr("src",imUrl);
                $("#love-triangle-reading").find('#TLTCardImage_1').attr("data-src","");
            }
        });

        $(document).on('click','#love-triangle-reading #TLTCardImage_2', function(e){
            var imUrl2 = $("#love-triangle-reading").find('#TLTCardImage_2').attr("data-src");
            if(imUrl2 !='') {
                $("#love-triangle-reading").find('#TLTCardImage_2').attr("src","");
                $("#love-triangle-reading").find('#TLTCardImage_2').attr("src",imUrl2);
                $("#love-triangle-reading").find('#TLTCardImage_2').attr("data-src","");
            }
        });

        $(document).on('click','#love-triangle-reading #TLTCardImage_3', function(e){
            var imUrl3 = $("#love-triangle-reading").find('#TLTCardImage_3').attr("data-src");
            if(imUrl3 !='') {
                $("#love-triangle-reading").find('#TLTCardImage_3').attr("src","");
                $("#love-triangle-reading").find('#TLTCardImage_3').attr("src",imUrl3);
                $("#love-triangle-reading").find('#TLTCardImage_3').attr("data-src","");
            }
        });


        $(document).on('click','#love-triangle-reading #get_TLT_reading', function(e){
            var imUrl = $("#love-triangle-reading").find('#TLTCardImage_1').attr("data-src");
            var imUrl2 = $("#love-triangle-reading").find('#TLTCardImage_2').attr("data-src");
            var imUrl3 = $("#love-triangle-reading").find('#TLTCardImage_3').attr("data-src");
            if(imUrl !='') {
                alert('Please pick your cards');
            }
            else if(imUrl2 !='') {
                alert('Please pick your cards');
            }
            else if(imUrl3 !='') {
                alert('Please pick your cards');
            }
            if(imUrl =='' && imUrl2 =='' && imUrl3 ==''){
                $("#love-triangle-reading").find('.divine__ta__subheading').hide();
                $("#love-triangle-reading").find('#widgetTLT_result').show();
                $("#love-triangle-reading").find('#get_TLT_reading').hide();
            }
        });
        $(document).on('click','#love-triangle-reading #set_TLT_reading', function(e){
            $.ajax({
                url: tlt_api_url,
                method: 'post',
                data: {api_key: widget_key, icon: card_style},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;
                        let card1 = result.card1;
                        let card2 = result.card2;
                        let card3 = result.card3;
                        
                        var imageResult1 = result.card1_image;
                        var imageResult2 = result.card2_image;
                        var imageResult3 = result.card3_image;
                        
                        let you = result.your;
                        let lover1 = result.lover1;
                        let lover2 = result.lover2;
                        
                        $("#love-triangle-reading").find('#TLTCardImage_1').attr("src","");
                        $("#love-triangle-reading").find('#TLTCardImage_2').attr("src","");
                        $("#love-triangle-reading").find('#TLTCardImage_3').attr("src","");

                        $("#love-triangle-reading").find('#TLTCardImage_1').attr("src",base_path_tlt+'images/lovers-triangle-you.png');
                        $("#love-triangle-reading").find('#TLTCardImage_2').attr("src",base_path_tlt+'images/lovers-triangle-lover1.png');
                        $("#love-triangle-reading").find('#TLTCardImage_3').attr("src",base_path_tlt+'images/lovers-triangle-lover2.png');

                        $("#love-triangle-reading").find('#TLTCardImage_1').attr("data-src",imageResult1);
                        $("#love-triangle-reading").find('#TLTCardImage_2').attr("data-src",imageResult2);
                        $("#love-triangle-reading").find('#TLTCardImage_3').attr("data-src",imageResult3);
                        
                        $("#love-triangle-reading").find('#TLTcardName1').html("");
                        $("#love-triangle-reading").find('#TLTcardName1').html("You ("+card1+")");

                        $("#love-triangle-reading").find('#TLT-tab-data-1 p').html("");
                        $("#love-triangle-reading").find('#TLT-tab-data-1 p').html(you);

                        $("#love-triangle-reading").find('#TLTcardName2').html("");
                        $("#love-triangle-reading").find('#TLTcardName2').html("Lover 1 ("+card2+")");

                        $("#love-triangle-reading").find('#TLT-tab-data-2 p').html("");
                        $("#love-triangle-reading").find('#TLT-tab-data-2 p').html(lover1);

                        $("#love-triangle-reading").find('#TLTcardName3').html("");
                        $("#love-triangle-reading").find('#TLTcardName3').html("Lover 2 ("+card3+")");

                        $("#love-triangle-reading").find('#TLT-tab-data-3 p').html("");
                        $("#love-triangle-reading").find('#TLT-tab-data-3 p').html(lover2);

                        $("#love-triangle-reading").find('.divine__ta__subheading').show();
                        $("#love-triangle-reading").find('#widgetTLT_result').hide();
                        $("#love-triangle-reading").find('#get_TLT_reading').show();
                    }
                    else
                    {
                        $("#love-triangle-reading").find('.divine__ta__subheading').show();
                        $("#love-triangle-reading").find('#widgetTLT_result').hide();
                        $("#love-triangle-reading").find('#get_TLT_reading').hide();
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