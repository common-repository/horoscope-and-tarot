;(function($) {
    "use strict";
    // console.log(ppf_options);

    var ctt_api_url = 'https://divineapi.com/api/1.0/get_past_present_future_reading.php';
    var base_path_ctt = 'https://divineapi.com/widget/past-present-future-reading/';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var widget_key      = ppf_options.token; 
    let color_text      = ppf_options.color_text;
    let font_size      = ppf_options.font_size;
    let color_theme     = ppf_options.color_theme;
    let color_category  = ppf_options.color_category;
    let card_style =     ppf_options.card_style;

    widget_key = atob(ppf_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--ppf-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--ppf-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--ppf-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--ppf-category-color', color_category);
    }  
    

    $(document).ready(function(){
        if(verified_domain(widget_key) == 1 || 1) {
        $.ajax({
            url: ctt_api_url,
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
                    
                    let past = result.past;
                    let present = result.present;
                    let future = result.future;

                    $("#past-present-future-reading").find('#3CTCardImage_1').attr("data-src",imageResult1);
                    $("#past-present-future-reading").find('#3CTCardImage_2').attr("data-src",imageResult2);
                    $("#past-present-future-reading").find('#3CTCardImage_3').attr("data-src",imageResult3);

                    $("#past-present-future-reading").find('#3CTcardName1').html("Past : "+card1);
                    $("#past-present-future-reading").find('#3CT-tab-data-1 p').html(past);

                    $("#past-present-future-reading").find('#3CTcardName2').html("Present : "+card2);
                    $("#past-present-future-reading").find('#3CT-tab-data-2 p').html(present);

                    $("#past-present-future-reading").find('#3CTcardName3').html("Future : "+card3);
                    $("#past-present-future-reading").find('#3CT-tab-data-3 p').html(future);

                    
                    $("#past-present-future-reading").find('#widget3CT_result').hide();
                    $("#past-present-future-reading").find('.divine__ta__subheading').show();
                }
                else
                {
                   
                }
            }
        });
        $(document).on('click','#past-present-future-reading #3CTCardImage_1', function(e){
            var imUrl = $("#past-present-future-reading").find('#3CTCardImage_1').attr("data-src");
            if(imUrl !='') {
                $("#past-present-future-reading").find('#3CTCardImage_1').attr("src","");
                $("#past-present-future-reading").find('#3CTCardImage_1').attr("src",imUrl);
                $("#past-present-future-reading").find('#3CTCardImage_1').attr("data-src","");
            }
        });

        $(document).on('click','#past-present-future-reading #3CTCardImage_2', function(e){
            var imUrl2 = $("#past-present-future-reading").find('#3CTCardImage_2').attr("data-src");
            if(imUrl2 !='') {
                $("#past-present-future-reading").find('#3CTCardImage_2').attr("src","");
                $("#past-present-future-reading").find('#3CTCardImage_2').attr("src",imUrl2);
                $("#past-present-future-reading").find('#3CTCardImage_2').attr("data-src","");
            }
        });

        $(document).on('click','#past-present-future-reading #3CTCardImage_3', function(e){
            var imUrl3 = $("#past-present-future-reading").find('#3CTCardImage_3').attr("data-src");
            if(imUrl3 !='') {
                $("#past-present-future-reading").find('#3CTCardImage_3').attr("src","");
                $("#past-present-future-reading").find('#3CTCardImage_3').attr("src",imUrl3);
                $("#past-present-future-reading").find('#3CTCardImage_3').attr("data-src","");
            }
        });


        $(document).on('click','#past-present-future-reading #get_3CT_reading', function(e){
            var imUrl = $("#past-present-future-reading").find('#3CTCardImage_1').attr("data-src");
            var imUrl2 = $("#past-present-future-reading").find('#3CTCardImage_2').attr("data-src");
            var imUrl3 = $("#past-present-future-reading").find('#3CTCardImage_3').attr("data-src");
            if(imUrl !='') {
                alert('Please reveal your cards');
            }
            else if(imUrl2 !='') {
                alert('Please reveal your cards');
            }
            else if(imUrl3 !='') {
                alert('Please reveal your cards');
            }
            if(imUrl =='' && imUrl2 =='' && imUrl3 ==''){
                $("#past-present-future-reading").find('.divine__ta__subheading').hide();
                $("#past-present-future-reading").find('#widget3CT_result').show();
                $("#past-present-future-reading").find('#get_3CT_reading').hide();
            }
        });
        $(document).on('click','#past-present-future-reading #set_3CT_reading', function(e){
            $.ajax({
                url: ctt_api_url,
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
                        
                        let past = result.past;
                        let present = result.present;
                        let future = result.future;
                        
                        $("#past-present-future-reading").find('#3CTCardImage_1').attr("src","");
                        $("#past-present-future-reading").find('#3CTCardImage_2').attr("src","");
                        $("#past-present-future-reading").find('#3CTCardImage_3').attr("src","");

                        $("#past-present-future-reading").find('#3CTCardImage_1').attr("src",base_path_ctt+'images/past.png');
                        $("#past-present-future-reading").find('#3CTCardImage_2').attr("src",base_path_ctt+'images/present.png');
                        $("#past-present-future-reading").find('#3CTCardImage_3').attr("src",base_path_ctt+'images/future.png');

                        $("#past-present-future-reading").find('#3CTCardImage_1').attr("data-src",imageResult1);
                        $("#past-present-future-reading").find('#3CTCardImage_2').attr("data-src",imageResult2);
                        $("#past-present-future-reading").find('#3CTCardImage_3').attr("data-src",imageResult3);
                        

                        $("#past-present-future-reading").find('#3CTcardName1').html("");
                        $("#past-present-future-reading").find('#3CTcardName1').html("Past : "+card1);

                        $("#past-present-future-reading").find('#3CT-tab-data-1 p').html("");
                        $("#past-present-future-reading").find('#3CT-tab-data-1 p').html(past);

                        $("#past-present-future-reading").find('#3CTcardName2').html("");
                        $("#past-present-future-reading").find('#3CTcardName2').html("Present : "+card2);

                        $("#past-present-future-reading").find('#3CT-tab-data-2 p').html("");
                        $("#past-present-future-reading").find('#3CT-tab-data-2 p').html(present);

                        $("#past-present-future-reading").find('#3CTcardName3').html("");
                        $("#past-present-future-reading").find('#3CTcardName3').html("Future : "+card3);

                        $("#past-present-future-reading").find('#3CT-tab-data-3 p').html("");
                        $("#past-present-future-reading").find('#3CT-tab-data-3 p').html(future);

                        $("#past-present-future-reading").find('.divine__ta__subheading').show();
                        $("#past-present-future-reading").find('#widget3CT_result').hide();
                        $("#past-present-future-reading").find('#get_3CT_reading').show();
                    }
                    else
                    {
                        $("#past-present-future-reading").find('.divine__ta__subheading').show();
                        $("#past-present-future-reading").find('#widget3CT_result').hide();
                        $("#past-present-future-reading").find('#get_3CT_reading').hide();
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