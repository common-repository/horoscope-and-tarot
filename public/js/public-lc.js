;(function($) {
    "use strict";
    // console.log(yn_options);      

    var lc_api_url = 'https://divineapi.com/api/1.0/get_compatibility.php';
    var lc_base_url = 'https://divineapi.com/api/1.0/get_compatibility.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var api_key =           lc_options.token;
    var sign =           lc_options.sign;

    var signUrl = 'https://divineapi.com/widget/daily_horoscope/images/zodiac/';
    if(sign == 1) 
    {
        var img_type = '-1';
    } 
    else if(sign == 3)
    {
        var img_type = '-2';
    }
    else 
    {
        var img_type = '';
    }
    let lc_color_theme =    lc_options.color_theme;
    let lc_color_category = lc_options.color_category;
    let lc_color_text = lc_options.color_text;
    let lc_font_size = lc_options.font_size;
    let general_heart_color = lc_options.general_heart_color;
    let communication_heart_color = lc_options.communication_heart_color;
    let sex_heart_color = lc_options.sex_heart_color;

    api_key = atob(lc_options.token);

    
    if (lc_color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--lc-theme-color', lc_color_theme);
    }
    if (lc_color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--lc-category-color', lc_color_category);
    }
    if (lc_color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--lc-text-color', lc_color_text);
    }
    if (lc_font_size > 0) 
    {
        document.documentElement.style.setProperty('--lc-font-size', lc_font_size+'px');
    }
    if (general_heart_color.length > 0) 
    {
        document.documentElement.style.setProperty('--lc-general-heart-color', general_heart_color);
    }
    if (communication_heart_color.length > 0) 
    {
        document.documentElement.style.setProperty('--lc-communication-heart-color', communication_heart_color);
    }
    if (sex_heart_color.length > 0) 
    {
        document.documentElement.style.setProperty('--lc-sex-heart-color', sex_heart_color);
    }

    let width = $('.divine__lc__widget').width();
    if (width <= 500) 
    {
        $('.divine__lc__widget').addClass('divine__lc__widget__sm');
    }
    else
    {
        $('.divine__lc__widget').removeClass('divine__lc__widget__sm');
    }

    $(document).ready(function(){
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        var widget_sign1 = '';
        var widget_sign2 = '';

        


        widget_sign1 = $('#zodiacSign1>.active-sign').attr('id');
        
        widget_sign2 = $('#zodiacSign2>.active-sign').attr('id');

        if(verified_domain(api_key) == 1) {

        if((widget_sign1 != '' && typeof widget_sign1 !== "undefined") && (widget_sign2 !=''  && typeof widget_sign2 !== "undefined")) {
        
            getApiData(widget_sign1, widget_sign2);
        }


        function getApiData(widget_sign1, widget_sign2) 
        {
            $('.signhead').text('');
            $('#divine__dh__overlay').show();
            
            $.ajax({
                url: lc_api_url,
                method: 'post',
                data: {api_key: api_key, sign_1: widget_sign1, sign_2: widget_sign2},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        $('.divine__lc__changecard__btn').removeClass('hide');
                        $('.divine__lc__changecard__btn').addClass('show');
                        let result = response.data;

                        let sign1 = result.sign_1;
                        let sign2 = result.sign_2;
                        let overall_compatibility = result.overall_compatibility;

                        let positive_aspects = result.positive_aspects;
                        let negative_aspects = result.negative_aspects;
                        let elements = result.elements;
                        let ideal_date = result.ideal_date;
                        let score = result.score;
                        let communication = score.communication;
                        let general = score.general;
                        let sex = score.sex;

                        var generalFull = Math.floor(general);
                        var generalHalf = general-generalFull;
                        var generalBlank = 10-Math.floor(general);
                        var fullHeart = '';
                        var heart = '';
                        var halfHeart = '';

                        for(var i=0; i<generalFull;i++){
                            fullHeart += '<i class="fa fa-heart general_heart" aria-hidden="true"></i>';
                        }
                        if(generalHalf < 0 && generalHalf != 0) {
                            halfHeart = '<i class="fa fa-heart-o general_heart half" aria-hidden="true"></i>';
                        }
                        for(var i=0; i<generalBlank;i++){
                            heart += '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                        }
                        
                        const generalHtml = '<div class="general"><div class="scoreTitle"><h5>General</h5></div><div class="heartsWrap">'+fullHeart+''+halfHeart+''+heart+'</div></div>';

                        var communicationFull = Math.floor(communication);
                        var communicationHalf = communication-communicationFull;
                        var communicationBlank = 10-Math.floor(communication);
                        var commFullHeart = '';
                        var commHeart = '';
                        var commHalfHeart = '';

                        for(var i=0; i<communicationFull;i++){
                            commFullHeart += '<i class="fa fa-heart communication_heart" aria-hidden="true"></i>';
                        }
                        if(communicationHalf < 0 && communicationHalf != 0) {
                            commHalfHeart = '<i class="fa fa-heart-o communication_heart half" aria-hidden="true"></i>';
                        }
                        for(var i=0; i<communicationBlank;i++){
                            commHeart += '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                        }
                        
                        const communicationHtml = '<div class="communication"><div class="scoreTitle"><h5>Communication</h5></div><div class="heartsWrap">'+commFullHeart+''+commHalfHeart+''+commHeart+'</div></div>';


                        var sexFull = Math.floor(sex);
                        var sexHalf = sex-sexFull;
                        var sexBlank = 10-Math.floor(sex);
                        var sexfullHeart = '';
                        var sexheart = '';
                        var sexHalfheart = '';

                        for(var i=0; i<sexFull;i++){
                            sexfullHeart += '<i class="fa fa-heart sex_heart" aria-hidden="true"></i>';
                        }
                        if(sexHalf < 0 && sexHalf != 0) {
                            sexHalfheart = '<i class="fa fa-heart-o sex_heart half" aria-hidden="true"></i>';
                        }
                        for(var i=0; i<sexBlank;i++){
                            sexheart += '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                        }
                        
                        const sexHtml = '<div class="sex"><div class="scoreTitle"><h5>Sex</h5></div><div class="heartsWrap">'+sexfullHeart+''+sexHalfheart+''+sexheart+'</div></div>';



                        const formattedData = sign1+" & "+sign2;
                        
                        

                        const compatibility = '<h3>Are '+capitalizeFirstLetter(sign1)+' And '+capitalizeFirstLetter(sign2)+' Compatible</h3><p style="text-align:left;">'+overall_compatibility+'</p>';
                        const pAspects =      '<h3>'+capitalizeFirstLetter(sign1)+' And '+capitalizeFirstLetter(sign2)+' Strengths</h3><p style="text-align:left;">'+positive_aspects+'</p>';
                        const nAspects =      '<h3>'+capitalizeFirstLetter(sign1)+' And '+capitalizeFirstLetter(sign2)+' Weaknesses</h3><p style="text-align:left;">'+negative_aspects+'</p>';
                        const IdealDate = '<h3>'+capitalizeFirstLetter(sign1)+' And '+capitalizeFirstLetter(sign2)+' Ideal Dates</h3><p style="text-align:left;">'+ideal_date+'</p>';

                        const signScore = '<h3>'+capitalizeFirstLetter(sign1)+' And '+capitalizeFirstLetter(sign2)+' Compatibility Score</h3>'+generalHtml+''+communicationHtml+''+sexHtml;
                        

                        $('#DivineOverallCompatibility').html('');
                        $('#DivineOverallCompatibility').html(compatibility);
                        $('#DivinePositiveAspects').html('');
                        $('#DivinePositiveAspects').html(pAspects);
                        $('#DivineNegativeAspects').html('');
                        $('#DivineNegativeAspects').html(nAspects);
                        //$('#DivineElements').html(elements);
                        $('#DivineIdealDate').html('');
                        $('#DivineIdealDate').html(IdealDate);

                        $('#DivineScore').html('');
                        $('#DivineScore').html(signScore);
                        
                        $('#divine__dh__overlay').hide();
                    }
                    else
                    {
                        $('#divine__dh__overlay').hide();
                        // alert(response.message);
                    }
                }
            });
        }

        $(document).on('click','#zodiacSign1>.signWrap', function(e)
        {
                    
            $('#zodiacSign1').find('.signWrap.active-sign').removeClass('active-sign');
            $(this).addClass('active-sign');
            e.preventDefault();
            widget_sign1 = $('#zodiacSign1>.active-sign').attr('id');
            widget_sign2 = $('#zodiacSign2>.active-sign').attr('id');
            $('#circleSign1').removeClass('dashed-cir');
            $('#circleSign1').addClass('filled-cir');
            $('#circleSign1').find('.circle-filled1-midDivSpan span').text('');
            $('#circleSign1').find('.circle-filled1-midDivSpan span').text(capitalizeFirstLetter(widget_sign1));
            $('#circleSign1').find('.circle-filled1-midDivImg').html('')
            $('#circleSign1').find('.circle-filled1-midDivImg').html('<img src="'+signUrl+''+capitalizeFirstLetter(widget_sign1)+img_type+'.png" alt="">');
            $('#zodiacSign1').removeClass('show');
            $('#zodiacSign2').removeClass('hide');
            $('#zodiacSign1').addClass('hide');
            $('#zodiacSign2').addClass('show');
            $('#zodiacSign2').find('.signhead').text('');
            $('#zodiacSign2').find('.signhead').text('Please select Your Partner Sign');
                    
            if((widget_sign1 != '' && typeof widget_sign1 !== "undefined") && (widget_sign2 !=''  && typeof widget_sign2 !== "undefined")) {
                getApiData(widget_sign1, widget_sign2);
            }
        });

        $(document).on('click','#zodiacSign2>.signWrap', function(e){
            $('#zodiacSign2').find('.signWrap.active-sign').removeClass('active-sign');
            $(this).addClass('active-sign');
            
            e.preventDefault();
            widget_sign1 = $('#zodiacSign1>.active-sign').attr('id');
            widget_sign2 = $('#zodiacSign2>.active-sign').attr('id');

            $('#circleSign2').find('.circle-filled1-midDivSpan span').text('');
            $('#circleSign2').find('.circle-filled1-midDivSpan span').text(capitalizeFirstLetter(widget_sign2));
            $('#circleSign2').find('.circle-filled1-midDivImg').html('');
            $('#circleSign2').removeClass('dashed-cir');
            $('#circleSign2').addClass('filled-cir');
            $('#circleSign2').find('.circle-filled1-midDivImg').html('<img src="'+signUrl+''+capitalizeFirstLetter(widget_sign2)+img_type+'.png" alt="">');
            $('#zodiacSign1').removeClass('show');
            $('#zodiacSign2').removeClass('hide');
            $('#zodiacSign1').addClass('hide');
            $('#zodiacSign2').addClass('show');
            
            if((widget_sign1 != '' && typeof widget_sign1 !== "undefined") && (widget_sign2 !=''  && typeof widget_sign2 !== "undefined")) {
                getApiData(widget_sign1, widget_sign2);
            }
        });

        $(document).on('click','.divine__lc__changecard__btn', function(e)
        {
            $('#circleSign1').removeClass('filled-cir');
            $('#circleSign1').addClass('dashed-cir');
            
            $('#circleSign2').removeClass('filled-cir');
            $('#circleSign2').addClass('dashed-cir');
        
            $('#zodiacSign1').find('.signhead').text('');
            $('#zodiacSign1').find('.signhead').text('Please select Your Sign');
            $('#zodiacSign1').removeClass('hide');
            $('#zodiacSign2').removeClass('show');
            $('#zodiacSign1').addClass('show');
            $('#zodiacSign2').addClass('hide');
            $(this).removeClass('show');
            $(this).addClass('hide');
            $('#zodiacSign1').find('.signWrap.active-sign').removeClass('active-sign');
            $('#zodiacSign2').find('.signWrap.active-sign').removeClass('active-sign');
            
            $('#DivineOverallCompatibility').html('');
            $('#DivinePositiveAspects').html('');
            $('#DivineNegativeAspects').html('');
            $('#DivineIdealDate').html('');
            $('#DivineScore').html('');
            $('#circleSign1').find('.circle-filled1-midDivSpan span').text('');
            $('#circleSign1').find('.circle-filled1-midDivImg').html('');
            $('#circleSign2').find('.circle-filled1-midDivSpan span').text('');
            $('#circleSign2').find('.circle-filled1-midDivImg').html('');
         });
    }
    else {
        $('.divine_auth_domain_response p').html("** You can use this API key only for registerd website on divine **");
    }
},'html'); 
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