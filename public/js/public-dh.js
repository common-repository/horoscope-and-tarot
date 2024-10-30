;(function($) {
    "use strict";
    // console.log(dh_options);

    // var dh_api_url = 'https://divineapi.com/api/1.0/get_daily_horoscope.php';
    var dh_api_url = 'https://astroapi-5.divineapi.com/api/v1/daily-horoscope';

    var dhw_api_url = 'https://divineapi.com/api/1.0/get_weekly_horoscope.php';
    var dhm_api_url = 'https://divineapi.com/api/1.0/get_monthly_horoscope.php';
    var dhy_api_url = 'https://divineapi.com/api/1.0/get_yearly_horoscope.php';

    var ajaxUrl =  'https://divineapi.com/divines/verifyDomain';
    const set = new Set(['dev', 'localhost', 'staging', 'local', 'stage', 'test']);
 
    var widget_date = $('.divine__dh__date__btn.active').attr('date');
    // var widget_sign = 'aries'; 
    var widget_sign = $('.dapi_default_sign').attr('data-default_sign'); 

    var widget_key      = dh_options.token; 
    var timezone        = dh_options.timezone;
    let color_text      = dh_options.color_text;
    let font_size       = dh_options.font_size;
    let color_theme     = dh_options.color_theme;
    let color_category  = dh_options.color_category;
    let horoscope_theme = dh_options.horoscope_theme;
    let cat_default_color = dh_options.cat_default_color;

    widget_key = atob(dh_options.token);

    if (color_text.length > 0) 
    {
        document.documentElement.style.setProperty('--text-color', color_text);
    }
    if (font_size > 0) 
    {
        document.documentElement.style.setProperty('--font-size', font_size+'px');
    }
    if (color_theme.length > 0) 
    {
        document.documentElement.style.setProperty('--theme-color', color_theme);
    }
    if (color_category.length > 0) 
    {
        document.documentElement.style.setProperty('--category-color', color_category);
    }  
    if (cat_default_color.length > 0)
    {
        document.documentElement.style.setProperty('--cat_default_color', cat_default_color);
    }

    $(document).ready(function(){
        if(verified_domain(widget_key) == 1) {
        $('#divine__dh__overlay').show();
        $.ajax({
            url: dh_api_url,
            method: 'post',
            data: {api_key: widget_key, sign: widget_sign, date: widget_date, timezone: timezone},
            success: function (data){
                var response = data;
                // var response = $.parseJSON(data);
                if (response.success == 1) 
                {
                    let result = response.data;

                    let sign = result.sign;
                    let prediction = result.prediction;

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

                    sign = sign.substr(0,1).toUpperCase() + sign.substr(1);

                    let subtitle = sign+' Horoscope Today';

                    const fdate = new Date(widget_date);
                    const formattedDate = fdate.toLocaleDateString('en-GB', {
                      day: '2-digit', month: 'short', year: 'numeric'
                    }).replace(/ /g, ' ');
                    
                    // $('.divine__dh__result__date').html(formattedDate);
                    $('.divine__dh__result__date').html(response.data.date);

                    $('.divine__dh__date').html(subtitle);

                    $('#Divinepersonal p').html(personal);
                    $('#Divinehealth p').html(health);
                    $('#Divineprofession p').html(profession);
                    $('#Divineemotions p').html(emotions);
                    $('#Divinetravel p').html(travel);
                    $('#Divineluck p').html(luck);
                    $('.divine__dh__result__date').html(response.data.date);

                    $('#divine__dh__overlay').hide();
                }
                else
                {
                    $('#divine__dh__overlay').hide();
                    // alert(response.message);
                }
            }
        });

        $('.divine__dh__date__btn').on('click', function(e){
            $('#divine__dh__overlay').show();
            e.preventDefault();
            let day = $(this).attr('day');
            
            let h_date = $(this).attr('date');
            widget_date = h_date;
            
            let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
            if (horoscope_theme != 2) {
                $('.divine__dh__date').html(sign+' Horoscope '+day);
            }
            
            const fdate = new Date(h_date);
            const formattedDate = fdate.toLocaleDateString('en-GB', {
              day: '2-digit', month: 'short', year: 'numeric'
            }).replace(/ /g, ' ');
            
            $('.divine__dh__result__date').html(formattedDate);

            $('.divine__dh__date__btn.active').removeClass('active');
            $(this).addClass('active');

            $.ajax({
                url: dh_api_url,
                method: 'post',
                data: {api_key: widget_key, sign: sign, date: h_date, timezone: timezone},
                success: function (data){
                    var response = data;
                    // var response = $.parseJSON(data);
                    //console.log(data);//return;
                    if (response.success == 1) 
                    {
                        let result = response.data;

                        let sign = result.sign;
                        let prediction = result.prediction;

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

                        $('#Divinepersonal p').html(personal);
                        $('#Divinehealth p').html(health);
                        $('#Divineprofession p').html(profession);
                        $('#Divineemotions p').html(emotions);
                        $('#Divinetravel p').html(travel);
                        $('#Divineluck p').html(luck);

                        $('html, body').animate({
                            scrollTop: $(".divine__dh__title").offset().top
                        }, 1000);
                        $('.divine__dh__result__date').html(response.data.date);

                        $('#divine__dh__overlay').hide();
                    }
                    else
                    {
                        $('#divine__dh__overlay').hide();
                        //alert('Some error occured!!!');
                    }
                }
            });
        });

        if (horoscope_theme == 2) {

            //Theme 2
            $('#dapi_theme_2_sign_select').on('change', function(e){
                $('#divine__dh__overlay').show();
                e.preventDefault();
                let h_sign = $(this).val();
                $('#dapi_theme_2_sign_select').val('');
                widget_sign = h_sign;
                $('.dapi-thm2_icls_selector').removeClass('active');
                $('.divine__dh__sign__'+widget_sign).addClass('active');
                
                $('.divine__dh__api__btn.active').removeClass('active'); // De-highlight Tab
                $('.divine__dh__api__btn:nth-child(1)').addClass('active'); // Highlight Tab
    
                $('.divine__dh__date__btn.active').removeClass('active');
                $('.divine__dh__date__btn:nth-child(2)').addClass('active');
    
                $('.divine__dh__date__nav').hide(); // Hide Tabs
                $('#divine-dh-set-daily').show(); // Show This Tabs
                
                widget_date = $('.divine__dh__date__btn.active').attr('date');
                const fdate = new Date(widget_date);
                const formattedDate = fdate.toLocaleDateString('en-GB', {
                  day: '2-digit', month: 'short', year: 'numeric'
                }).replace(/ /g, ' ');
                
                $('.divine__dh__result__date').html(formattedDate);
                let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
                $('.dapi_dh_sel_sign').html(sign);
     
                $.ajax({
                    url: dh_api_url,
                    method: 'post',
                    data: {api_key: widget_key, sign: widget_sign, date: widget_date, timezone: timezone},
                    success: function (data){
                        var response = data;
                        // var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;
    
                            let sign = result.sign;
                            let prediction = result.prediction;
    
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
    
                            $('#Divinepersonal p').html(personal);
                            $('#Divinehealth p').html(health);
                            $('#Divineprofession p').html(profession);
                            $('#Divineemotions p').html(emotions);
                            $('#Divinetravel p').html(travel);
                            $('#Divineluck p').html(luck);
                            $('.divine__dh__result__date').html(response.data.date);
    
                            $('#divine__dh__overlay').hide();
                        }
                        else
                        {
                            $('#divine__dh__overlay').hide();
                            // alert(response.message);
                        }
                    }
                });
            });
            
        } else {

            //Theme 1
            $('.divine__dh__signbox').on('click', function(e){
                $('#divine__dh__overlay').show();
                e.preventDefault();
                let h_sign = $(this).attr('sign');
                widget_sign = h_sign;
                $('.divine__dh__sign.active').removeClass('active');
                $(this).children('.divine__dh__sign').addClass('active');
                
                $('.divine__dh__api__btn.active').removeClass('active'); // De-highlight Tab
                $('.divine__dh__api__btn:nth-child(1)').addClass('active'); // Highlight Tab
    
                $('.divine__dh__date__btn.active').removeClass('active');
                $('.divine__dh__date__btn:nth-child(2)').addClass('active');
    
                $('.divine__dh__date__nav').hide(); // Hide Tabs
                $('#divine-dh-set-daily').show(); // Show This Tabs
                
                widget_date = $('.divine__dh__date__btn.active').attr('date');
                const fdate = new Date(widget_date);
                const formattedDate = fdate.toLocaleDateString('en-GB', {
                  day: '2-digit', month: 'short', year: 'numeric'
                }).replace(/ /g, ' ');
                
                $('.divine__dh__result__date').html(formattedDate);
                let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
                if (horoscope_theme != 2) {
                    $('.divine__dh__date').html(sign+' Horoscope Today');
                }
     
                $.ajax({
                    url: dh_api_url,
                    method: 'post',
                    data: {api_key: widget_key, sign: widget_sign, date: widget_date, timezone: timezone},
                    success: function (data){
                        var response = data;
                        // var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;
    
                            let sign = result.sign;
                            let prediction = result.prediction;
    
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
    
                            $('#Divinepersonal p').html(personal);
                            $('#Divinehealth p').html(health);
                            $('#Divineprofession p').html(profession);
                            $('#Divineemotions p').html(emotions);
                            $('#Divinetravel p').html(travel);
                            $('#Divineluck p').html(luck);
                            $('.divine__dh__result__date').html(response.data.date);
    
                            $('#divine__dh__overlay').hide();
                        }
                        else
                        {
                            $('#divine__dh__overlay').hide();
                            // alert(response.message);
                        }
                    }
                });
            });

        }

        $('.divine__dh__api__btn').on('click', function(e){
            $('#divine__dh__overlay').show();
            e.preventDefault();
            let api_type = $(this).attr('type');

            $('.divine__dh__api__btn.active').removeClass('active'); // De-highlight Tab
            $(this).addClass('active'); // Highlight Tab

            $('.divine__dh__date__nav').hide(); // Hide Tabs
            $('#divine-dh-set-'+api_type).show(); // Show This Tabs

            // IF Daily TAB IS SELECTED
            if(api_type == 'daily')
            {
                $('.divine__dh__date__btn.active').removeClass('active');
                $('.divine__dh__date__btn:nth-child(2)').addClass('active');

                widget_date = $('.divine__dh__date__btn.active').attr('date');
                let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);

                const fdate = new Date(widget_date);
                const formattedDate = fdate.toLocaleDateString('en-GB', {
                  day: '2-digit', month: 'short', year: 'numeric'
                }).replace(/ /g, ' ');
                
                $('.divine__dh__result__date').html(formattedDate);
                if (horoscope_theme != 2) {
                    $('.divine__dh__date').html(sign+' Horoscope Today');
                }

                $.ajax({
                    url: dh_api_url,
                    method: 'post',
                    data: {api_key: widget_key, sign: widget_sign, date: widget_date, timezone: timezone},
                    success: function (data){
                        var response = data;
                        // var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;

                            let sign = result.sign;
                            let prediction = result.prediction;

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

                            $('#Divinepersonal p').html(personal);
                            $('#Divinehealth p').html(health);
                            $('#Divineprofession p').html(profession);
                            $('#Divineemotions p').html(emotions);
                            $('#Divinetravel p').html(travel);
                            $('#Divineluck p').html(luck);
                            $('.divine__dh__result__date').html(response.data.date);

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
            else if(api_type == 'weekly')
            {
                $('.divine__dh__week__btn.active').removeClass('active');
                $('.divine__dh__week__btn:nth-child(2)').addClass('active');
                let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
                if (horoscope_theme != 2) {
                    $('.divine__dh__date').html('');
                }
                $.ajax({
                    url: dhw_api_url,
                    method: 'post',
                    data: {api_key: widget_key, sign: widget_sign, week: 'current'},
                    success: function (data){
                        var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;

                            // let sign = result.sign;
                            let week = result.week;
                            let prediction = result.weekly_horoscope;

                            let personal = prediction.personal;
                            let health = prediction.health;
                            let profession = prediction.profession;
                            let emotions = prediction.emotions;
                            let travel = prediction.travel;
                            var luck = prediction.luck;

                            $('.divine__dh__result__date').html(week);
                            if (luck != null && luck.length > 1) 
                            {
                                var luck_data = "";
                                $.each(prediction.luck, function(i, val){
                                luck_data += val+'<br>';
                                }); 
                                luck = luck_data;
                            }

                            if (horoscope_theme != 2) {
                                $('.divine__dh__date').html(sign+' Horoscope '+week);
                            }
                            $('#Divinepersonal p').html(personal);
                            $('#Divinehealth p').html(health);
                            $('#Divineprofession p').html(profession);
                            $('#Divineemotions p').html(emotions);
                            $('#Divinetravel p').html(travel);
                            $('#Divineluck p').html(luck);

                            $('html, body').animate({
                                scrollTop: $(".divine__dh__title").offset().top
                            }, 1000);

                            $('#divine__dh__overlay').hide();
                        }
                        else
                        {
                            $('#divine__dh__overlay').hide();
                            // alert('Some error occured!!!');
                        }
                    }
                });
            }
            else if(api_type == 'monthly') // Monthly
            {
                $('.divine__dh__month__btn.active').removeClass('active');
                $('.divine__dh__month__btn:nth-child(2)').addClass('active');
                let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
                if (horoscope_theme != 2) {
                    $('.divine__dh__date').html('');
                }
                $.ajax({
                    url: dhm_api_url,
                    method: 'post',
                    data: {api_key: widget_key, sign: widget_sign, month: 'current'},
                    success: function (data){
                        var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;

                            //let sign = result.sign;
                            let month = result.month;

                            let prediction = result.monthly_horoscope;

                            let personal = prediction.personal;
                            let health = prediction.health;
                            let profession = prediction.profession;
                            let emotions = prediction.emotions;
                            let travel = prediction.travel;
                            var luck = prediction.luck;

                            $('.divine__dh__result__date').html(month);
                            if (luck != null && luck.length > 1) 
                            {
                                var luck_data = "";
                                $.each(prediction.luck, function(i, val){
                                luck_data += val+'<br>';
                                }); 
                                luck = luck_data;
                            }

                            if (horoscope_theme != 2) {
                                $('.divine__dh__date').html(sign+' Horoscope '+month);
                            }
                            $('#Divinepersonal p').html(personal);
                            $('#Divinehealth p').html(health);
                            $('#Divineprofession p').html(profession);
                            $('#Divineemotions p').html(emotions);
                            $('#Divinetravel p').html(travel);
                            $('#Divineluck p').html(luck);

                            $('html, body').animate({
                                scrollTop: $(".divine__dh__title").offset().top
                            }, 1000);

                            $('#divine__dh__overlay').hide();
                        }
                        else
                        {
                            $('#divine__dh__overlay').hide();
                            // alert('Some error occured!!!');
                        }
                    }
                });                
            }
            else // Yearly
            {
                $('.divine__dh__year__btn.active').removeClass('active');
                $('.divine__dh__year__btn:nth-child(2)').addClass('active');
                let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
                if (horoscope_theme != 2) {
                    $('.divine__dh__date').html('');
                }
                $.ajax({
                    url: dhy_api_url,
                    method: 'post',
                    data: {api_key: widget_key, sign: widget_sign, year: 'current'},
                    success: function (data){
                        var response = $.parseJSON(data);
                        if (response.success == 1) 
                        {
                            let result = response.data;

                            //let sign = result.sign;
                            let year = result.year;

                            let prediction = result.yearly_horoscope;

                            let personal = prediction.personal;
                            let health = prediction.health;
                            let profession = prediction.profession;
                            let emotions = prediction.emotions;
                            let travel = prediction.travel;
                            var luck = prediction.luck;

                            $('.divine__dh__result__date').html('Year '+year);
                            if (luck != null && luck.length > 1) 
                            {
                                var luck_data = "";
                                $.each(prediction.luck, function(i, val){
                                luck_data += val+'<br>';
                                }); 
                                luck = luck_data;
                            }

                            if (horoscope_theme != 2) {
                                $('.divine__dh__date').html(sign+' Horoscope Year '+year);
                            }
                            $('#Divinepersonal p').html(personal);
                            $('#Divinehealth p').html(health);
                            $('#Divineprofession p').html(profession);
                            $('#Divineemotions p').html(emotions);
                            $('#Divinetravel p').html(travel);
                            $('#Divineluck p').html(luck);

                            $('html, body').animate({
                                scrollTop: $(".divine__dh__title").offset().top
                            }, 1000);

                            $('#divine__dh__overlay').hide();
                        }
                        else
                        {
                            $('#divine__dh__overlay').hide();
                            // alert('Some error occured!!!');
                        }
                    }
                });                
            }
        });

        $('.divine__dh__week__btn').on('click', function(e){
            $('#divine__dh__overlay').show();
            e.preventDefault();
            let week = $(this).attr('week');
            let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
            if (horoscope_theme != 2) {
                $('.divine__dh__date').html('');
            }

            $('.divine__dh__week__btn.active').removeClass('active');
            $(this).addClass('active');
            $('.divine__dh__result__date').html('');
            $.ajax({
                url: dhw_api_url,
                method: 'post',
                data: {api_key: widget_key, sign: sign, week: week},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;

                        // let sign = result.sign;
                        let week = result.week;
                        let prediction = result.weekly_horoscope;

                        let personal = prediction.personal;
                        let health = prediction.health;
                        let profession = prediction.profession;
                        let emotions = prediction.emotions;
                        let travel = prediction.travel;
                        var luck = prediction.luck;

                        $('.divine__dh__result__date').html(week);
                        if (luck != null && luck.length > 1) 
                        {
                            var luck_data = "";
                            $.each(prediction.luck, function(i, val){
                            luck_data += val+'<br>';
                            }); 
                            luck = luck_data;
                        }

                        if (horoscope_theme != 2) {
                            $('.divine__dh__date').html(sign+' Horoscope '+week);
                        }
                        $('#Divinepersonal p').html(personal);
                        $('#Divinehealth p').html(health);
                        $('#Divineprofession p').html(profession);
                        $('#Divineemotions p').html(emotions);
                        $('#Divinetravel p').html(travel);
                        $('#Divineluck p').html(luck);

                        $('html, body').animate({
                            scrollTop: $(".divine__dh__title").offset().top
                        }, 1000);

                        $('#divine__dh__overlay').hide();
                    }
                    else
                    {
                        $('#divine__dh__overlay').hide();
                        // alert('Some error occured!!!');
                    }
                }
            });
        });

        $('.divine__dh__month__btn').on('click', function(e){
            $('#divine__dh__overlay').show();
            e.preventDefault();
            let month = $(this).attr('month');

            let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
            if (horoscope_theme != 2) {
                $('.divine__dh__date').html('');
            }

            $('.divine__dh__month__btn.active').removeClass('active');
            $(this).addClass('active');
            $('.divine__dh__result__date').html('');
            $.ajax({
                url: dhm_api_url,
                method: 'post',
                data: {api_key: widget_key, sign: sign, month: month},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;

                        // let sign = result.sign;
                        let month = result.month;

                        let prediction = result.monthly_horoscope;

                        let personal = prediction.personal;
                        let health = prediction.health;
                        let profession = prediction.profession;
                        let emotions = prediction.emotions;
                        let travel = prediction.travel;
                        var luck = prediction.luck;

                        if (horoscope_theme != 2) {
                            $('.divine__dh__date').html(sign+' Horoscope '+month);
                        }
                        $('.divine__dh__result__date').html(month);
                        if (luck != null && luck.length > 1) 
                        {
                            var luck_data = "";
                            $.each(prediction.luck, function(i, val){
                            luck_data += val+'<br>';
                            }); 
                            luck = luck_data;
                        }

                        $('#Divinepersonal p').html(personal);
                        $('#Divinehealth p').html(health);
                        $('#Divineprofession p').html(profession);
                        $('#Divineemotions p').html(emotions);
                        $('#Divinetravel p').html(travel);
                        $('#Divineluck p').html(luck);

                        $('html, body').animate({
                            scrollTop: $(".divine__dh__title").offset().top
                        }, 1000);

                        $('#divine__dh__overlay').hide();
                    }
                    else
                    {
                        $('#divine__dh__overlay').hide();
                        // alert('Some error occured!!!');
                    }
                }
            });
        });

        $('.divine__dh__year__btn').on('click', function(e){
            $('#divine__dh__overlay').show();
            e.preventDefault();
            let year = $(this).attr('year');

            let sign = widget_sign.substr(0,1).toUpperCase() + widget_sign.substr(1);
            if (horoscope_theme != 2) {
                $('.divine__dh__date').html('');
            }

            $('.divine__dh__year__btn.active').removeClass('active');
            $(this).addClass('active');
            $('.divine__dh__result__date').html('');
            $.ajax({
                url: dhy_api_url,
                method: 'post',
                data: {api_key: widget_key, sign: sign, year: year},
                success: function (data){
                    var response = $.parseJSON(data);
                    if (response.success == 1) 
                    {
                        let result = response.data;

                        // let sign = result.sign;
                        let year = result.year;

                        let prediction = result.yearly_horoscope;

                        let personal = prediction.personal;
                        let health = prediction.health;
                        let profession = prediction.profession;
                        let emotions = prediction.emotions;
                        let travel = prediction.travel;
                        var luck = prediction.luck;

                        if (horoscope_theme != 2) {
                            $('.divine__dh__date').html(sign+' Horoscope Year '+year);
                        }
                        $('.divine__dh__result__date').html('Year '+year);
                        if (luck != null && luck.length > 1) 
                        {
                            var luck_data = "";
                            $.each(prediction.luck, function(i, val){
                            luck_data += val+'<br>';
                            }); 
                            luck = luck_data;
                        }

                        $('#Divinepersonal p').html(personal);
                        $('#Divinehealth p').html(health);
                        $('#Divineprofession p').html(profession);
                        $('#Divineemotions p').html(emotions);
                        $('#Divinetravel p').html(travel);
                        $('#Divineluck p').html(luck);

                        $('html, body').animate({
                            scrollTop: $(".divine__dh__title").offset().top
                        }, 1000);

                        $('#divine__dh__overlay').hide();
                    }
                    else
                    {
                        $('#divine__dh__overlay').hide();
                        // alert('Some error occured!!!');
                    }
                }
            });
        });

        $('.divine__dh__category__links').on('click', function(e){
            e.preventDefault();
            // console.log(e);
            let active_content = $(this).attr('tab');
            $('.divine__dh__category__links.active').removeClass('active');
            $(this).addClass('active');
            $('.divine__dh__content__data').hide();
            $('#'+active_content).show();
        });
    }
    else {
        $('.divine_auth_domain_response p').html("** You can use this API key only for registerd website on divine **");
        $('.divine_auth_domain_response').show();
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
        }else{
            return true;
        }
    }
})(jQuery);