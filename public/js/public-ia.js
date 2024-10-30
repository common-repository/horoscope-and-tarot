;(function($) {
    "use strict";
    // console.log(ia_options);
     
    var tia_api_url = 'https://divineapi.com/api/1.0/get_which_animal_are_you_reading.php';
    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
    
    var widget_key =     ia_options.token;
    let color_text =     ia_options.color_text;
    let font_size =     ia_options.font_size;
    let color_theme =    ia_options.color_theme;
    let color_category = ia_options.color_category;

    widget_key = atob(ia_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--ia-text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--ia-font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--ia-theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--ia-category-color', color_category);
        document.documentElement.style.setProperty('--ia-background-color', hexToRgbA(color_category)); 
    }  
    function hexToRgbA(hex){
        var c;
        if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
            c= hex.substring(1).split('');
            if(c.length== 3){
                c= [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c= '0x'+c.join('');
            return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',0.5)';
        }
        
    }

    $(document).ready(function(){
        
        function isValidDate(year, month, day) {
            var d = new Date(year, month, day);
            if (d.getFullYear() == year && d.getMonth() == month && d.getDate() == day) {
                return true;
            }
            return false;
        }
    if(verified_domain(widget_key) == 1) {
        $(document).on('click','#which-animal-are-you #get_TIA_reading', function(e){

            let name = $("#name").val();
            
            let dt = $("#date").val();
            dt = dt < 10 ? "0" + dt : dt;
            let month = $("#month").val();
            month = month < 10 ? "0" + month : month;
            let year = $("#year").val();

            let dob = year + "-" + month + "-" + dt;

            let date_validation = isValidDate(year,parseInt(month)-1,dt);
            if(name == '') {
                alert('Please enter your name & date of birth');
            }
            else if(date_validation == false)
            {
                alert('Invalid date');
            } 

            if(date_validation == true && name !='') {
                $.ajax({
                    url: tia_api_url,
                    method: 'post',
                    data: {api_key: widget_key, name: name, dob: dob},
                    success: function (data){
                        var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;
                            let animal = result.animal;
                            let image = result.image;
                            let description = result.result;
                            
                            $("#which-animal-are-you").find('#TIACardImage').attr("src","");
                            $("#which-animal-are-you").find('#TIACardImage').attr("src",image);
                            
                            $("#which-animal-are-you").find('#TBanimalName').html("");
                            $("#which-animal-are-you").find('#TBanimalName').html(animal);

                            $("#which-animal-are-you").find('#TIA-tab-data-1 p').html("");
                            $("#which-animal-are-you").find('#TIA-tab-data-1 p').html(description);


                            $("#which-animal-are-you").find('.divine__tia__heading').hide();
                            $("#which-animal-are-you").find('.divine__tia__para').hide();
                            $("#which-animal-are-you").find('#inner-animal-form').hide();
                            $("#which-animal-are-you").find('#widgetTIA_result').show();
                            $("#which-animal-are-you").find('#get_TIA_reading').hide();
                        }
                        else
                        {
                            $("#which-animal-are-you").find('#inner-animal-form').show();
                            $("#which-animal-are-you").find('.divine__tia__heading').show();
                            $("#which-animal-are-you").find('.divine__tia__para').show();
                            $("#which-animal-are-you").find('#widgetTIA_result').hide();
                            $("#which-animal-are-you").find('#get_TIA_reading').show();
                        }
                    }
                });
            }
        }); 
          
        $(document).on('click','#which-animal-are-you #set_TIA_reading', function(e){ 
            
            $("#name").val('');
            $("#date").val('');
            $("#month").val('');
            $("#year").val('');

            $("#which-animal-are-you").find('#inner-animal-form').show();
            $("#which-animal-are-you").find('.divine__tia__heading').show();
            $("#which-animal-are-you").find('.divine__tia__para').show();
            $("#which-animal-are-you").find('#widgetTIA_result').hide();
            $("#which-animal-are-you").find('#get_TIA_reading').show();
            $("#which-animal-are-you").find('#TIACardImage').attr("src","");
            $("#which-animal-are-you").find('#TBanimalName').html("");
            $("#which-animal-are-you").find('#TIA-tab-data-1 p').html("");
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