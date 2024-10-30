;(function($) {
    "use strict";
    // console.log(dt_options);
     
    var dt_api_url = 'https://divineapi.com/api/1.0/get_daily_tarot.php';  

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);

    var api_key =        dt_options.token;
    let card_style =     dt_options.card_style;
    let color_text =     dt_options.color_text;
    let font_size =     dt_options.font_size;
    let color_theme =    dt_options.color_theme;
    let color_category = dt_options.color_category;

    api_key = atob(dt_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--dt-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--dt-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--dt-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--dt-category-color', color_category);
    }  

    $(document).ready(function(){
    if(verified_domain(api_key) == 1) {
        $('.divine__dt__card').on('click', function(e){
            e.preventDefault();
            $('#divine__dt__overlay').show();
            $.ajax({
                url: dt_api_url,
                method: 'post',
                data: {api_key: api_key},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;
                        let card = result.card;
                        let category = result.category;
                        let career = result.career;
                        let love = result.love;
                        let finance = result.finance;
                        if(card_style == 1)
                        {
                            var image = result.image2;
                        }
                        else
                        {
                            var image = result.image;
                        }
                        $('.dt__card__image').attr("src",image);
                        $('.divine__dt__cardname').html(card);
                        $('.divine__dt__cardtype').html(category);
                        $('#DT-tab-data-1 p').html(love);
                        $('#DT-tab-data-2 p').html(finance);
                        $('#DT-tab-data-3 p').html(career);
                        $('.divine__dt__subheading').hide();
                        $('.divine__dt__deck').hide();
                        $('#widgetDT_result').show();
                        $('html, body').animate({
                            scrollTop: $(".divine__dt__widget").offset().top
                        }, 1000);
                        $('#divine__dt__overlay').hide();
                    }
                    else
                    {
                        $('#divine__dt__overlay').hide();
                        // alert(response.message);
                    }
                }
            });
        });

        $('.divine__dt__changecard__btn').on('click', function(e){
            e.preventDefault();
            $('.divine__dt__subheading').html('Pick a card');
            $('html, body').animate({
                scrollTop: $(".divine__dt__widget").offset().top
            }, 1000);
            $('.divine__dt__subheading').show();
            $('.divine__dt__deck').show();
            $('#widgetDT_result').hide();
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


function change_dt_tab(tab) 
{
   let active_tab = document.querySelector('.divine__dt__tablink.active');
   active_tab.classList.remove('active');
   let active = document.getElementById('dt-tab-'+tab);    
   active.classList.add('active');

   let elements = document.getElementsByClassName('divine__dt__contentdata');
   
    for (var i = 0; i < elements.length; i ++) {
        elements[i].style.display = 'none';
    }
   let active_data = document.getElementById('DT-tab-data-'+tab); 
   active_data.style.display = 'block';
}