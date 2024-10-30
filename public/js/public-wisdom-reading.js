;(function($) {
    "use strict";
    // console.log(wisdom_reading_options);
     
    var tz_api_url = 'https://divineapi.com/api/1.0/get_wisdom_reading.php';

    var tz_file_url = 'https://divineapi.com/';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var widget_key =        wisdom_reading_options.token;
    let card_style =     wisdom_reading_options.card_style;
    let color_text =     wisdom_reading_options.color_text;
    let font_size =     wisdom_reading_options.font_size;
    let color_theme =    wisdom_reading_options.color_theme;
    let color_category = wisdom_reading_options.color_category;

    widget_key = atob(wisdom_reading_options.token);


    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--wr-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--wr-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--wr-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--wr-category-color', color_category);
    }  

    $(document).ready(function(){
        if(verified_domain(widget_key) == 1) {
        $.ajax({
            url: tz_api_url,
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
                    
                    let ying = result.ying;
                    let yang = result.yang;

                    $("#wisdom-reading").find('#CardImage_1').attr("data-src",imageResult1);
                    $("#wisdom-reading").find('#CardImage_2').attr("data-src",imageResult2);

                    $("#wisdom-reading").find('#cardName1').html("Ying ("+card1+")");
                    $("#wisdom-reading").find('#TZ-tab-data-1 p').html(ying);

                    $("#wisdom-reading").find('#cardName2').html("Yang ("+card2+")");
                    $("#wisdom-reading").find('#TZ-tab-data-2 p').html(yang);

                    
                    $("#wisdom-reading").find('#widgetTZ_result').hide();
                 }
                else
                {
                }
            }
        });
        $(document).on('click','#wisdom-reading #CardImage_1', function(e){
            
            var imUrl = $("#wisdom-reading").find('#CardImage_1').attr("data-src");
            if(imUrl !='') {
                $("#wisdom-reading").find('#CardImage_1').attr("src","");
                $("#wisdom-reading").find('#CardImage_1').attr("src",imUrl);
                $("#wisdom-reading").find('#CardImage_1').attr("data-src","");
            }
        });
        $(document).on('click','#wisdom-reading #CardImage_2', function(e){
            
            var imUrl2 = $("#wisdom-reading").find('#CardImage_2').attr("data-src");
            if(imUrl2 !='') {
                $("#wisdom-reading").find('#CardImage_2').attr("src","");
                $("#wisdom-reading").find('#CardImage_2').attr("src",imUrl2);
                $("#wisdom-reading").find('#CardImage_2').attr("data-src","");
            }
        });


        $(document).on('click','#wisdom-reading #get__reading', function(e){
            var imUrl = $("#wisdom-reading").find('#CardImage_1').attr("data-src");
            var imUrl2 = $("#wisdom-reading").find('#CardImage_2').attr("data-src");
            if(imUrl !='') {
                alert('Please pick your cards');
            }
            else if(imUrl2 !='') {
                alert('Please pick your cards');
            }
            if(imUrl =='' && imUrl2 ==''){
                $("#wisdom-reading").find('.divine__ta__subheading').hide();
                $("#wisdom-reading").find('#widgetTZ_result').show();
                $("#wisdom-reading").find('#get__reading').hide();
            }
        });
        $(document).on('click','#wisdom-reading #set__reading', function(e){
            $.ajax({
                url: tz_api_url,
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
                        
                        let ying = result.ying;
                        let yang = result.yang;
                        
                        $("#wisdom-reading").find('#CardImage_1').attr("src","");
                        $("#wisdom-reading").find('#CardImage_2').attr("src","");

                        $("#wisdom-reading").find('#CardImage_1').attr("src",tz_file_url+'widget/wisdom-reading/images/yin.png');
                        $("#wisdom-reading").find('#CardImage_2').attr("src",tz_file_url+'widget/wisdom-reading/images/yang.png');

                        $("#wisdom-reading").find('#CardImage_1').attr("data-src",imageResult1);
                        $("#wisdom-reading").find('#CardImage_2').attr("data-src",imageResult2);
                        
                        $("#wisdom-reading").find('#cardName1').html("");
                        $("#wisdom-reading").find('#cardName1').html("Ying ("+card1+")");

                        $("#wisdom-reading").find('#TZ-tab-data-1 p').html("");
                        $("#wisdom-reading").find('#TZ-tab-data-1 p').html(ying);

                        $("#wisdom-reading").find('#cardName2').html("");
                        $("#wisdom-reading").find('#cardName2').html("Yang ("+card2+")");

                        $("#wisdom-reading").find('#TZ-tab-data-2 p').html("");
                        $("#wisdom-reading").find('#TZ-tab-data-2 p').html(yang);

                        $("#wisdom-reading").find('.divine__ta__subheading').show();
                        $("#wisdom-reading").find('#widgetTZ_result').hide();
                        $("#wisdom-reading").find('#get__reading').show();
                    }
                    else
                    {
                        $("#wisdom-reading").find('.divine__ta__subheading').show();
                        $("#wisdom-reading").find('#widgetTZ_result').hide();
                        $("#wisdom-reading").find('#get__reading').hide();
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