;(function($) {
    "use strict";
    var dhw_api_url = 'https://divineapi.com/api/1.0/get_weekly_horoscope.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var ch_key = atob(cwh_options.token); 
    var ch_tz = "";

    var ch_week = "";
    var ch_sign = ""; 
    var ch_category = "";
    var block = "";
    var data = "";

    $( ".divine_custom_weekly_shortcode" ).each(function( index) {
        //ch_key = $(this).attr('key');
        ch_tz = $(this).attr('tz');

        ch_week = $(this).attr('week');
        ch_sign = $(this).attr('sign');
        ch_category = $(this).attr('category');
        block = $(this);
        $(block).children( 'p.divine__custom__result' ).html('');
        if(verified_domain(ch_key) == 1) {
        $.ajax({
            url: dhw_api_url,
            method: 'post',
            async: false,
            data: {api_key: ch_key, sign: ch_sign, week: ch_week, timezone: ch_tz},
            success: function (data){
                var response = $.parseJSON(data);
                if (response.success == 1) 
                {
                    let result = response.data;

                    let sign = result.sign;
                    let prediction = result.weekly_horoscope;

                    let personal = prediction.personal;
                    let health = prediction.health;
                    let profession = prediction.profession;
                    let emotions = prediction.emotions;
                    let travel = prediction.travel;
                    var luck = prediction.luck;

                    if (luck != null && luck.length > 1) 
                    {
                        var luck_data = "";
                        $.each(prediction.luck, function(i, val){
                        luck_data += val+'<br>';
                        }); 
                        luck = luck_data;
                    }
                    var content = '';
                    ch_category = ch_category.toLowerCase();
                    switch(ch_category) 
                    {
                        case "personal":
                           content = personal;
                        break;

                        case "health":
                           content = health;
                        break;
                        
                        case "profession":
                           content = profession;
                        break;
                        
                        case "emotions":
                           content = emotions;
                        break;
                        
                        case "travel":
                           content = travel;
                        break;
                        
                        case "luck":
                           content = luck;
                        break;

                        default:
                           content = '<code style="font-size:12px;color: crimson;background-color: #f1f1f1;">Invalid category ('+ch_category+')</code>';
                    }

                    $(block).children( 'p.divine__custom__result' ).html('<b>'+capitalize(sign)+' '+capitalize(ch_category)+' Weekly Horoscope '+result.week+'</b><br>'+content);

                    $('#divine__dh__overlay').hide();
                }
                else
                {
                    $(block).children( 'p.divine__custom__result' ).html('<code style="font-size:12px;color: crimson;background-color: #f1f1f1;">'+response.message+'</code>');
                    $('#divine__dh__overlay').hide();
                }
            }
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

function capitalize(str) {
  strVal = '';
  str = str.split(' ');
  for (var chr = 0; chr < str.length; chr++) {
    strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' '
  }
  return strVal
}