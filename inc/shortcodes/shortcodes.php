<?php

/**
 * Divine Horoscope Shortcode
 */

function dhat_horoscope_shortcode($atts)
{
    wp_enqueue_script('myplugin-dh-script', DHAT_PLUGIN_URL . 'public/js/public-dh.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dh-style', DHAT_PLUGIN_URL . 'public/css/public-dh.css', '', rand());

    $timezones = unserialize(TIMEZONES);
    
    $atts = array_change_key_case((array) $atts, CASE_LOWER); // User Inputs

    // $date = (isset($atts['date']) ? strtolower(trim($atts['date'])) : 'today'); // User Inputs
    $default_sign = (isset($atts['default_sign']) ? strtolower(trim($atts['default_sign'])) : 'aries'); // User Inputs


    $api_key = get_option('divine_settings_input_field');
    $timezone_id = intval(get_option('horoscope_settings_timezone_field'));
    $sign = get_option('horoscope_settings_sign_field');
    $color_text = get_option('horoscope_settings_text_color_field');
    $font_size = get_option('horoscope_settings_font_size_field');
    $color_theme = get_option('horoscope_settings_theme_color_field');
    $color_category = get_option('horoscope_settings_category_color_field');
    $horoscope_theme = get_option('horoscope_theme_no_field');
    $tabs_position = get_option('horoscope_tabs_position_field');
    $buttons_position = get_option('horoscope_buttons_position_field');
    $buttons_with_icons = get_option('horoscope_buttons_with_icon_field');
    $button_type = get_option('horoscope_buttons_type_field');
    $cat_default_color = get_option('horoscope_settings_category_bg_default_color_field');

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));
    $yesterday = date('Y-m-d', strtotime($reference_datetime . ' -1 day'));
    $tomorrow = date('Y-m-d', strtotime($reference_datetime . ' +1 day'));

    $scriptData = array(
        'token' => base64_encode($api_key),
        'timezone' => $gmt_sign . $timezone,
        'sign' => $sign,
        'default_sign' => $default_sign,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
        'horoscope_theme' => $horoscope_theme,
        'tabs_position' => $tabs_position,
        'buttons_position' => $buttons_position,
        'buttons_with_icons' => $buttons_with_icons,
        'button_type' => $button_type,
        'cat_default_color' => $cat_default_color
    );


    wp_localize_script('myplugin-dh-script', 'dh_options', $scriptData);

    if ($horoscope_theme == 2) {
        //get horoscope theme 2 html
        $html = get_horoscope_theme_2_html($today, $yesterday, $tomorrow, $sign, $default_sign);
    } else {
        //get horoscope theme 1 html
        $html = get_horoscope_theme_1_html($today, $yesterday, $tomorrow, $sign, $default_sign);
    }

    return $html . '<span class="dapi_default_sign" data-default_sign="'.$default_sign.'"><span>';

}
add_shortcode('divine_horoscope', 'dhat_horoscope_shortcode');

/**
 * Divine Daily Tarot Shortcode
 */

function dhat_daily_tarot_shortcode($atts)
{
    wp_enqueue_style('myplugin-dt-style', DHAT_PLUGIN_URL . 'public/css/public-dt.css', '', rand());
    wp_enqueue_script('myplugin-dt-script', DHAT_PLUGIN_URL . 'public/js/public-dt.js', array('jquery'), rand(), true);
    $api_key = get_option('divine_settings_input_field');
    $card_style = get_option('daily_tarot_settings_card_field');
    $color_text = get_option('daily_tarot_settings_text_color_field');
    $font_size = get_option('daily_tarot_settings_font_size_field');
    $color_theme = get_option('daily_tarot_settings_theme_color_field');
    $color_category = get_option('daily_tarot_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'card_style' => $card_style,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );
    wp_localize_script('myplugin-dt-script', 'dt_options', $scriptData, true);

    $html = '<div id="daily-tarot" class="divine__dt__widget">
                <div class="w3-card-1 w3-padding w3-round-large w3-margin-bottom">   
                    <h3 class="divine__dt__heading w3-center">Daily Tarot</h3>
                    <h4 class="divine__dt__subheading">Pick a Card</h4>
                    <div class="divine__dt__deck">
                        <div class="divine__dt__innnerdeck">
                            <a href="javascript:void(0)" class="divine__dt__card card-1"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-2"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-3"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-4"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-5"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-6"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-7"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-8"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-9"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-10"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-11"></a>
                            <a href="javascript:void(0)" class="divine__dt__card card-12"></a>
                        </div>
                    </div>
                    <div id="divine__dt__overlay" class="divine__plugin__overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="divine_auth_domain_response">
                        <p style="color: red !important;text-align:center !important;"></p>
                    </div>
                    <div id="widgetDT_result" style="display: none;">
                        <div style="text-align: center;">
                            <img class="dt__card__image" src="" alt="Card image" style="height: 250px;" />
                            <h3 class="divine__dt__cardname">TEN OF SWORDS</h3>
                            <span class="divine__dt__cardtype">Reverse</span>
                            <div style="margin-top: 20px;">
                                <div class="divine__dt__tabwrap">
                                    <ul class="divine__dt__tab">
                                        <li>
                                            <a href="javascript:void(0);" class="divine__dt__tablink active" onclick="change_dt_tab(1);" id="dt-tab-1"><i class="divine__dt__icon__comment"></i> &nbsp; LOVE</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="divine__dt__tablink" onclick="change_dt_tab(2);" id="dt-tab-2"><i class="divine__dt__icon__comment"></i> &nbsp; FINANCE</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="divine__dt__tablink" onclick="change_dt_tab(3);" id="dt-tab-3"><i class="divine__dt__icon__comment"></i> &nbsp; CAREER</a>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="divine__dt__contentwrap">
                                    <div id="DT-tab-data-1" class="divine__dt__contentdata" style="display: block;">
                                        <span class="widgetDT_content_title">Love</span>
                                        <p>
                                        </p>
                                    </div>
                                    <div id="DT-tab-data-2" class="divine__dt__contentdata">
                                        <span class="widgetDT_content_title">Finance</span>
                                        <p>
                                        </p>
                                    </div>
                                    <div id="DT-tab-data-3" class="divine__dt__contentdata">
                                        <span class="widgetDT_content_title">Career</span>
                                        <p>
                                        </p>
                                    </div>
                                    <div class="divine__dt__background">
                                        <button class="divine__dt__changecard__btn">Pick another card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    return $html;
}
add_shortcode('divine_daily_tarot', 'dhat_daily_tarot_shortcode');


/**
 * Divine Yes No Tarot Shortcode
 */

function dhat_yes_no_tarot_shortcode($atts)
{
    wp_enqueue_style('myplugin-yes-no-style', DHAT_PLUGIN_URL . 'public/css/public-yn.css', '', rand());
    wp_enqueue_script('myplugin-yes-no-script', DHAT_PLUGIN_URL . 'public/js/public-yn.js', array('jquery'), rand(), true);

    $api_key = get_option('divine_settings_input_field');
    $card_style = get_option('yes_no_tarot_settings_card_field');
    $color_text = get_option('yes_no_tarot_settings_text_color_field');
    $font_size = get_option('yes_no_tarot_settings_font_size_field');
    $color_theme = get_option('yes_no_tarot_settings_theme_color_field');
    $color_category = get_option('yes_no_tarot_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'card_style' => $card_style,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );
    wp_localize_script('myplugin-yes-no-script', 'yn_options', $scriptData);

    $html = '
            <div id="yes-no-tarot" class="divine__yn__widget divine__yn__widget__sm">
                <div class="w3-card-1 w3-padding w3-round-large w3-margin-bottom">  
                    <h3 class="divine__yn__heading">Yes or No Tarot</h3>
                    <h4 class="divine__yn__subheading">Pick a Card</h4>
                    <div class="divine__yn__deck">
                        <div class="divine__yn__innnerdeck">
                            <a href="javascript:void(0)" class="divine__yn__card card-1"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-2"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-3"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-4"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-5"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-6"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-7"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-8"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-9"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-10"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-11"></a>
                            <a href="javascript:void(0)" class="divine__yn__card card-12"></a>
                        </div>
                    </div>
                    <div id="divine__yn__overlay" class="divine__plugin__overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="divine_auth_domain_response">
                        <p style="color: red !important;text-align:center !important;"></p>
                    </div>
                    <div id="divineYN_result" style="display: none;">
                        <div class="divine-row">
                            <div class="col-12 w3-center col-sm-5 col-md-4 col-lg-3 divine__yn__imagebox">
                                <img class="yn__card__image w3-margin-bottom" src="" alt="Yes No Tarot Card" style="height: 250px;" />
                            </div>
                            <div class="col-12 col-sm-7 col-md-8 col-lg-9 divine__yn__contentbox">
                                <h3 class="divine__yn__cardname">SIX OF WANDS (Reverse)</h3>  
                                <h4 class="divine__yn__cardresult">No</h4>
                                <p class="w3-section divine__yn__result">This part will occupy 12 columns on a small screen, 8 on a medium screen, and 9 on a large screen.This part will occupy 12 columns on a small screen, 8 on a medium screen, and 9 on a large screen.</p>
                                <button class="divine__yn__changecard__btn">Pick another card</button>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
            ';

    return $html;
}
add_shortcode('divine_yes_no_tarot', 'dhat_yes_no_tarot_shortcode');


/**
 * Divine Fortune Cookie Shortcode
 */

function dhat_fortune_cookie_shortcode($atts)
{

    wp_enqueue_style('myplugin-fc-style', DHAT_PLUGIN_URL . 'public/css/public-fc.css', '', rand());
    wp_enqueue_script('myplugin-fc-script', DHAT_PLUGIN_URL . 'public/js/public-fc.js', array('jquery'), rand(), true);

    $api_key = get_option('divine_settings_input_field');
    $color_text = get_option('fortune_cookie_settings_text_color_field');
    $font_size = get_option('fortune_cookie_settings_font_size_field');
    $color_theme = get_option('fortune_cookie_settings_theme_color_field');
    $color_category = get_option('fortune_cookie_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );
    wp_localize_script('myplugin-fc-script', 'fc_options', $scriptData);

    $html = '<div id="divine-fortune-cookie" class="divine__fc__widget divine__fc__widget__sm">
                <div class="w3-card-1 divine__fc__widget__box">   
                    <h3 class="divine__fc__title w3-center">Fortune Cookie</h3>     
                    <p class="divine__fc__desc w3-center">What is the Fortune Cookie talking about today?</p> 
                    <h5 class="divine__fc__subtitle w3-center">ASK THE FORTUNE COOKIE</h5>

                    <div id="divine__fc__overlay" class="divine__plugin__overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>

                    <div class="divine__fc__prev" style="display: block;">
                        <div class="divine-row">
                            <div class="col-12 w3-center">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/fc.svg"><br>
                                <button id="divine__fc__open" class="divine__fc__btn">Crack Open Your Fortune Cookie</button>
                            </div>
                        </div>                       
                    </div>
                    <div class="divine_auth_domain_response">
                        <p style="color: red !important;text-align:center !important;"></p>
                    </div>
                    <div class="divine__fc__next" style="display: none;">
                        <div class="divine-row">
                            <div class="col-12 w3-center">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/fc-result.svg">
                                <div class="divine__fc__result">
                                    <p></p>
                                </div>
                                <button id="divine__fc__close" class="divine__fc__btn">Crack Another One Open</button>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>';

    return $html;
}
add_shortcode('divine_fortune_cookie', 'dhat_fortune_cookie_shortcode');


/**
 * Divine Coffee Cup Shortcode
 */

function dhat_coffee_cup_shortcode($atts)
{

    wp_enqueue_style('myplugin-cc-style', DHAT_PLUGIN_URL . 'public/css/public-cc.css', '', rand());
    wp_enqueue_script('myplugin-cc-script', DHAT_PLUGIN_URL . 'public/js/public-cc.js', array('jquery'), rand(), true);

    $api_key = get_option('divine_settings_input_field');
    $color_text = get_option('coffee_cup_settings_text_color_field');
    $font_size = get_option('coffee_cup_settings_font_size_field');
    $color_theme = get_option('coffee_cup_settings_theme_color_field');
    $color_category = get_option('coffee_cup_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );
    wp_localize_script('myplugin-cc-script', 'cc_options', $scriptData);

    $html = '
            <div id="divine-coffee-cup" class="divine__cc__widget divine__cc__widget__sm"> 
                <h3 class="divine__cc__title w3-center">Coffee Cup Reading</h3>     
                <p class="divine__cc__desc w3-center">The Coffee grinds will take care of the message you need to hear</p> 
                <h5 class="divine__cc__subtitle w3-center">Choose your <span id="cc-cup-count">1st</span> coffee cup.</h5>

                <div id="divine__cc__overlay" class="divine__plugin__overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>

                <div class="divine__cc__prev" style="display: block;">
                  <div class="divine-row divine__cc__select__row">
                       <div class="col-lg-2 col-md-4 col-6 divine__cc__box divine__cc__unselected">
                          <div class="divine__cc__image__box" num="1">
                             <img class="img-fluid" src="' . DHAT_PLUGIN_URL . 'public/images/CoffeeCupReading.svg">
                          </div>
                       </div>
                       <div class="col-lg-2 col-md-4 col-6 card1 divine__cc__box divine__cc__unselected">
                          <div class="divine__cc__image__box" num="2">
                             <img class="img-fluid" src="' . DHAT_PLUGIN_URL . 'public/images/CoffeeCupReading.svg">
                          </div>
                       </div>
                       <div class="col-lg-2 col-md-4 col-6 card1 divine__cc__box divine__cc__unselected">
                          <div class="divine__cc__image__box" num="3">
                             <img class="img-fluid" src="' . DHAT_PLUGIN_URL . 'public/images/CoffeeCupReading.svg">
                          </div>
                       </div>
                       <div class="col-lg-2 col-md-4 col-6 card1 divine__cc__box divine__cc__unselected">
                          <div class="divine__cc__image__box" num="4">
                             <img class="img-fluid" src="' . DHAT_PLUGIN_URL . 'public/images/CoffeeCupReading.svg">
                          </div>
                       </div>
                       <div class="col-lg-2 col-md-4 col-6 card1 divine__cc__box divine__cc__unselected">
                          <div class="divine__cc__image__box" num="5">
                             <img class="img-fluid" src="' . DHAT_PLUGIN_URL . 'public/images/CoffeeCupReading.svg">
                          </div>
                       </div>
                       <div class="col-lg-2 col-md-4 col-6 card1 divine__cc__box divine__cc__unselected">
                          <div class="divine__cc__image__box" num="6">
                             <img class="img-fluid" src="' . DHAT_PLUGIN_URL . 'public/images/CoffeeCupReading.svg">
                          </div>
                       </div>
                  </div>                       
                </div>
                <div class="divine_auth_domain_response">
                                <p style="color: red !important;text-align:center !important;"></p>
                            </div>
                <div class="divine__cc__next" style="display: none;">
                    <div style="margin-top: 20px;">
                        <div class="divine__cc__tabwrap">
                            <ul class="divine__cc__tab">
                                <li>
                                    <a href="javascript:void(0);" class="divine__cc__tablink active" tab="1"> Present</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="divine__cc__tablink" tab="2"> Near Future</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="divine__cc__tablink" tab="3"> Distant Future</a>
                                </li>
                            </ul>
                        </div>
                        <div class="divine__cc__contentwrap">
                            <div id="cc-tab-data-1" class="divine__cc__contentdata">
                                <div class="divine__cc__result__image__box" id="divine-cc-present-image">
                                  <img src="" width="200">
                                </div>
                                <div class="divine__cc__result__data__box">
                                    <div id="divine-cc-present-result">
                                        <h3>Anchor</h3>
                                        <p>You were looking for security in your life which is entering your life very soon. There will be security in every aspect of life. Everything will be like the way you have visualized it in your mind. Nature is working for you and you will be able to achieve the security in your life that you desire.</p>
                                    </div>
                                    <div class="bg-dark" style="width: fit-content;">
                                      <button class="divine__cc__reset__btn">Select Again</button>
                                    </div>
                              </div>
                            </div>
                            
                            <div id="cc-tab-data-2" class="divine__cc__contentdata" style="display:none;">
                                <div class="divine__cc__result__image__box" id="divine-cc-nf-image">
                                    
                                </div>
                                <div class="divine__cc__result__data__box">
                                    <div id="divine-cc-nf-result">
                                    </div>
                                    <div class="bg-dark" style="width: fit-content;">
                                      <button class="divine__cc__reset__btn">Select Again</button>
                                    </div>
                                </div>
                            </div>
                            <div id="cc-tab-data-3" class="divine__cc__contentdata" style="display:none;">
                                <div class="divine__cc__result__image__box" id="divine-cc-df-image">
                                    
                                </div>
                                <div class="divine__cc__result__data__box">
                                    <div id="divine-cc-df-result">
                                    </div>
                                    <div class="bg-dark" style="width: fit-content;">
                                      <button class="divine__cc__reset__btn">Select Again</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                          
                </div>
            </div>
            ';

    return $html;
}
add_shortcode('divine_coffee_cup', 'dhat_coffee_cup_shortcode');


/**
 * Divine Custom Daily Horoscope Shortcode
 */

function dhat_custom_daily_horoscope_shortcode($atts)
{

    if (!wp_script_is('myplugin-cdh-script', 'enqueued')) {
        wp_enqueue_script('myplugin-cdh-script', DHAT_PLUGIN_URL . 'public/js/public-cdh.js', array('jquery'), rand(), true);
    }

    $timezones = unserialize(TIMEZONES);

    $atts = array_change_key_case((array) $atts, CASE_LOWER); // User Inputs

    $date = (isset($atts['date']) ? strtolower(trim($atts['date'])) : 'today'); // User Inputs
    $sign = (isset($atts['sign']) ? strtolower(trim($atts['sign'])) : 'aries'); // User Inputs
    $category = (isset($atts['category']) ? strtolower(trim($atts['category'])) : 'personal'); // User Inputs

    $api_key = get_option('divine_settings_input_field'); // API KEY
    $timezone_id = intval(get_option('horoscope_settings_timezone_field')); // User Timezone

    $scriptData = array(
        'token' => base64_encode($api_key)
    );

    wp_localize_script('myplugin-cdh-script', 'cdh_options', $scriptData);

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));

    if ($date == "yesterday") {
        $date_str = date('Y-m-d', strtotime($reference_datetime . ' -1 day'));
    } else if ($date == "tomorrow") {
        $date_str = date('Y-m-d', strtotime($reference_datetime . ' +1 day'));
    } else if ($date == "today") {
        $date_str = gmdate('Y-m-d', strtotime($timezone_string));
    } else {
        $date_str = "";
    }

    if ($date_str == "" || $sign == "" || $category == "") {
        $html = '<div><span style="font-size:12px;color: crimson;background-color: #f1f1f1;">Invalid Shortcode: Shortcode should be in the format <br><b>[divine_custom_daily_horoscope date="today" sign="aries" category="personal"]</b></span></div>';
    } else {
        $class_name = strtolower($date . "__" . $sign . "__" . $category);

        $html = '<div class="divine_custom_shortcode ' . $class_name . '" tz="' . $gmt_sign . $timezone . '"  date="' . $date_str . '" dt="' . $date . '" sign="' . $sign . '" category="' . $category . '">  
                  <p class="divine__custom__result"></p>
                </div>';
    }

    return $html;
}
add_shortcode('divine_custom_daily_horoscope', 'dhat_custom_daily_horoscope_shortcode');


/**
 * Divine Custom Weekly Horoscope Shortcode
 */

function dhat_custom_weekly_horoscope_shortcode($atts)
{

    if (!wp_script_is('myplugin-cwh-script', 'enqueued')) {
        wp_enqueue_script('myplugin-cwh-script', DHAT_PLUGIN_URL . 'public/js/public-cwh.js', array('jquery'), rand(), true);
    }

    $timezones = unserialize(TIMEZONES);

    $atts = array_change_key_case((array) $atts, CASE_LOWER); // User Inputs

    $week = (isset($atts['week']) ? strtolower(trim($atts['week'])) : 'current'); // User Inputs
    $sign = (isset($atts['sign']) ? strtolower(trim($atts['sign'])) : 'aries'); // User Inputs
    $category = (isset($atts['category']) ? strtolower(trim($atts['category'])) : 'personal'); // User Inputs

    $api_key = get_option('divine_settings_input_field'); // API KEY
    $timezone_id = intval(get_option('horoscope_settings_timezone_field')); // User Timezone

    $scriptData = array(
        'token' => base64_encode($api_key)
    );
    wp_localize_script('myplugin-cwh-script', 'cwh_options', $scriptData);

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);

    if ($week == "" || $sign == "" || $category == "") {
        $html = '<div><span style="font-size:12px;color: crimson;background-color: #f1f1f1;">Invalid Shortcode: Shortcode should be in the format <br><b>[divine_custom_weekly_horoscope week="current" sign="aries" category="personal"]</b></span></div>';
    } else {
        $class_name = strtolower($week . "__" . $sign . "__" . $category);

        $html = '<div class="divine_custom_weekly_shortcode ' . $class_name . '" tz="' . $gmt_sign . $timezone . '"  week="' . $week . '" sign="' . $sign . '" category="' . $category . '">  
                  <p class="divine__custom__result"></p>
                </div>';
    }

    return $html;
}
add_shortcode('divine_custom_weekly_horoscope', 'dhat_custom_weekly_horoscope_shortcode');


/**
 * Divine Custom Monthly Horoscope Shortcode
 */

function dhat_custom_monthly_horoscope_shortcode($atts)
{

    if (!wp_script_is('myplugin-cmh-script', 'enqueued')) {
        wp_enqueue_script('myplugin-cmh-script', DHAT_PLUGIN_URL . 'public/js/public-cmh.js', array('jquery'), rand(), true);
    }

    $timezones = unserialize(TIMEZONES);

    $atts = array_change_key_case((array) $atts, CASE_LOWER); // User Inputs

    $month = (isset($atts['month']) ? strtolower(trim($atts['month'])) : 'current'); // User Inputs
    $sign = (isset($atts['sign']) ? strtolower(trim($atts['sign'])) : 'aries'); // User Inputs
    $category = (isset($atts['category']) ? strtolower(trim($atts['category'])) : 'personal'); // User Inputs

    $api_key = get_option('divine_settings_input_field'); // API KEY
    $timezone_id = intval(get_option('horoscope_settings_timezone_field')); // User Timezone

    $scriptData = array(
        'token' => base64_encode($api_key)
    );
    wp_localize_script('myplugin-cmh-script', 'cmh_options', $scriptData);

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);

    if ($month == "" || $sign == "" || $category == "") {
        $html = '<div><span style="font-size:12px;color: crimson;background-color: #f1f1f1;">Invalid Shortcode: Shortcode should be in the format <br><b>[divine_custom_monthly_horoscope month="current" sign="aries" category="personal"]</b></span></div>';
    } else {
        $class_name = strtolower($month . "__" . $sign . "__" . $category);

        $html = '<div class="divine_custom_monthly_shortcode ' . $class_name . '" tz="' . $gmt_sign . $timezone . '"  month="' . $month . '" sign="' . $sign . '" category="' . $category . '">  
                  <p class="divine__custom__result"></p>
                </div>';
    }

    return $html;
}
add_shortcode('divine_custom_monthly_horoscope', 'dhat_custom_monthly_horoscope_shortcode');

/**
 * Divine Custom Yearly Horoscope Shortcode
 */

function dhat_custom_yearly_horoscope_shortcode($atts)
{

    if (!wp_script_is('myplugin-cyh-script', 'enqueued')) {
        wp_enqueue_script('myplugin-cyh-script', DHAT_PLUGIN_URL . 'public/js/public-cyh.js', array('jquery'), rand(), true);
    }

    $timezones = unserialize(TIMEZONES);

    $atts = array_change_key_case((array) $atts, CASE_LOWER); // User Inputs

    $year = (isset($atts['year']) ? strtolower(trim($atts['year'])) : 'current'); // User Inputs
    $sign = (isset($atts['sign']) ? strtolower(trim($atts['sign'])) : 'aries'); // User Inputs
    $category = (isset($atts['category']) ? strtolower(trim($atts['category'])) : 'personal'); // User Inputs

    $api_key = get_option('divine_settings_input_field'); // API KEY
    $timezone_id = intval(get_option('horoscope_settings_timezone_field')); // User Timezone

    $scriptData = array(
        'token' => base64_encode($api_key)
    );
    wp_localize_script('myplugin-cyh-script', 'cyh_options', $scriptData);

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);

    if ($year == "" || $sign == "" || $category == "") {
        $html = '<div><span style="font-size:12px;color: crimson;background-color: #f1f1f1;">Invalid Shortcode: Shortcode should be in the format <br><b>[divine_custom_yearly_horoscope year="current" sign="aries" category="personal"]</b></span></div>';
    } else {
        $class_name = strtolower($year . "__" . $sign . "__" . $category);

        $html = '<div class="divine_custom_yearly_shortcode ' . $class_name . '" tz="' . $gmt_sign . $timezone . '"  year="' . $year . '" sign="' . $sign . '" category="' . $category . '">  
                  <p class="divine__custom__result"></p>
                </div>';
    }

    return $html;
}
add_shortcode('divine_custom_yearly_horoscope', 'dhat_custom_yearly_horoscope_shortcode');


function dhat_love_compatibility_shortcode($atts)
{
    wp_enqueue_style('myplugin-lc-style', DHAT_PLUGIN_URL . 'public/css/public-lc.css', '', rand());
    wp_enqueue_script('myplugin-lc-script', DHAT_PLUGIN_URL . 'public/js/public-lc.js', array('jquery'), rand(), true);

    $sign = get_option('love_compatibility_settings_sign_field');
    $api_key = get_option('divine_settings_input_field');
    $color_theme = get_option('love_compatibility_settings_theme_color_field');
    $color_category = get_option('love_compatibility_settings_category_color_field');
    $color_text = get_option('love_compatibility_settings_text_color_field');
    $font_size = get_option('love_compatibility_settings_font_size_field');
    $general_heart_color = get_option('love_compatibility_settings_general_heart_color_field');
    $sex_heart_color = get_option('love_compatibility_settings_sex_heart_color_field');
    $communication_heart_color = get_option('love_compatibility_settings_communication_heart_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'sign' => $sign,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'general_heart_color' => $general_heart_color,
        'communication_heart_color' => $communication_heart_color,
        'sex_heart_color' => $sex_heart_color,
    );
    wp_localize_script('myplugin-lc-script', 'lc_options', $scriptData);

    $html = '<div id="astro-widget" class="w3-card-4 divine__lc__widget">               
                <div class="w3-card-0 w3-padding w3-round-large w3-margin-bottom padding-top-0">
                <div class="zodiacLoveCompatibility">
                            <div class="divine-row">';
    if ($sign == 1) {
        $html .= '<div class="loveWidget">
                                        <div class="divine__dh__title">
                                            <div class="divine__dh__name"><h4 class="divine__ta__heading w3-center">Love Compatibility</h4></div>
                                        </div>
                                        <div class="contentDiv">
                                            <div class="circlesWrap">
                                                <div class="circle-filled1-midPage black dashed-cir" id="circleSign1">
                                                    
                                                    <div class="circle-filled1-midDivSpan">
                                                        <span></span>
                                                    </div>
                                                    <div class="circle-filled1-midDivImg">
                                                    </div>
                                                </div>
                                    
                                                <div class="circle-filled1-midPage black dashed-cir" id="circleSign2">
                                                    
                                                    <div class="circle-filled1-midDivSpan">
                                                        <span></span>
                                                    </div>
                                                    <div class="circle-filled1-midDivImg">
                                                    </div>
                                                </div>
                                            </div>
                                
                                            <div class="zodiacWrapper show row" id="zodiacSign1">
                                                <br/>
                                                <div class="col-md-12 selecthead" style="width:100%;">
                                                <h3 class="signhead">Please select Your Sign</h3>
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aries">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries-1.png"/>
                                                    <div class="signName">
                                                        Aries
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="taurus">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus-1.png"/>
                                                    <div class="signName">
                                                        Taurus
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="gemini">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini-1.png"/>
                                                    <div class="signName">
                                                        Gemini                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="cancer">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer-1.png"/>
                                                    <div class="signName">
                                                        Cancer                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="leo">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo-1.png"/>
                                                    <div class="signName">
                                                        Leo                            
                                                    </div>
                                                
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="virgo">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo-1.png"/>
                                                    <div class="signName">
                                                        Virgo                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="libra">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra-1.png"/>
                                                    <div class="signName">
                                                        Libra                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="scorpio">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio-1.png"/>
                                                    <div class="signName">
                                                        Scorpio                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="sagittarius">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius-1.png"/>
                                                    <div class="signName">
                                                        Sagittarius                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="capricorn">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn-1.png"/>
                                                    <div class="signName">
                                                        Capricorn                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aquarius">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius-1.png"/>
                                                    <div class="signName">
                                                        Aquarius                            
                                                    </div>
                                                
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="pisces">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces-1.png"/>
                                                    <div class="signName">
                                                        Pisces                            
                                                    </div>
                                                    
                                                </div>
                                            
                                                </div>
                                                <div class="zodiacWrapper hide" id="zodiacSign2">
                                                    <br/>
                                                    <div class="col-md-12 selecthead"  style="width:100%;">
                                                        <h3 class="signhead">Please select Your Partner Sign</h3>
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aries">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries-1.png"/>
                                                        <div class="signName">
                                                            Aries
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="taurus">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus-1.png"/>
                                                        <div class="signName">
                                                            Taurus
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="gemini">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini-1.png"/>
                                                        <div class="signName">
                                                            Gemini                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="cancer">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer-1.png"/>
                                                        <div class="signName">
                                                            Cancer                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="leo">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo-1.png"/>
                                                        <div class="signName">
                                                            Leo                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="virgo">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo-1.png"/>
                                                        <div class="signName">
                                                            Virgo                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="libra">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra-1.png"/>
                                                        <div class="signName">
                                                            Libra                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="scorpio">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio-1.png"/>
                                                        <div class="signName">
                                                            Scorpio                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="sagittarius">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius-1.png"/>
                                                        <div class="signName">
                                                            Sagittarius                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="capricorn">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn-1.png"/>
                                                        <div class="signName">
                                                            Capricorn                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aquarius">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius-1.png"/>
                                                        <div class="signName">
                                                            Aquarius                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="pisces">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces-1.png"/>
                                                        <div class="signName">
                                                            Pisces                            
                                                        </div>
                                                        
                                                    </div>
                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>';
    } else if ($sign == 3) {
        $html .= '<div class="loveWidget">
                                        <div class="divine__dh__title">
                                            <div class="divine__dh__name"><h4 class="divine__ta__heading w3-center">Love Compatibility</h4></div>
                                        </div>
                                        <div class="contentDiv">
                                            <div class="circlesWrap">
                                                <div class="circle-filled1-midPage black dashed-cir" id="circleSign1">
                                                    
                                                    <div class="circle-filled1-midDivSpan">
                                                        <span></span>
                                                    </div>
                                                    <div class="circle-filled1-midDivImg">
                                                    </div>
                                                </div>
                                    
                                                <div class="circle-filled1-midPage black dashed-cir" id="circleSign2">
                                                    
                                                    <div class="circle-filled1-midDivSpan">
                                                        <span></span>
                                                    </div>
                                                    <div class="circle-filled1-midDivImg">
                                                    </div>
                                                </div>
                                            </div>
                                
                                            <div class="zodiacWrapper show row" id="zodiacSign1">
                                                <br/>
                                                <div class="col-md-12 selecthead" style="width:100%;">
                                                <h3 class="signhead">Please select Your Sign</h3>
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aries">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries-2.png"/>
                                                    <div class="signName">
                                                        Aries
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="taurus">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus-2.png"/>
                                                    <div class="signName">
                                                        Taurus
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="gemini">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini-2.png"/>
                                                    <div class="signName">
                                                        Gemini                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="cancer">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer-2.png"/>
                                                    <div class="signName">
                                                        Cancer                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="leo">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo-2.png"/>
                                                    <div class="signName">
                                                        Leo                            
                                                    </div>
                                                
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="virgo">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo-2.png"/>
                                                    <div class="signName">
                                                        Virgo                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="libra">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra-2.png"/>
                                                    <div class="signName">
                                                        Libra                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="scorpio">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio-2.png"/>
                                                    <div class="signName">
                                                        Scorpio                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="sagittarius">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius-2.png"/>
                                                    <div class="signName">
                                                        Sagittarius                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="capricorn">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn-2.png"/>
                                                    <div class="signName">
                                                        Capricorn                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aquarius">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius-2.png"/>
                                                    <div class="signName">
                                                        Aquarius                            
                                                    </div>
                                                
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="pisces">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces-2.png"/>
                                                    <div class="signName">
                                                        Pisces                            
                                                    </div>
                                                    
                                                </div>
                                            
                                                </div>
                                                <div class="zodiacWrapper hide" id="zodiacSign2">
                                                    <br/>
                                                    <div class="col-md-12 selecthead"  style="width:100%;">
                                                        <h3 class="signhead">Please select Your Partner Sign</h3>
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aries">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries-2.png"/>
                                                        <div class="signName">
                                                            Aries
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="taurus">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus-2.png"/>
                                                        <div class="signName">
                                                            Taurus
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="gemini">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini-2.png"/>
                                                        <div class="signName">
                                                            Gemini                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="cancer">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer-2.png"/>
                                                        <div class="signName">
                                                            Cancer                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="leo">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo-2.png"/>
                                                        <div class="signName">
                                                            Leo                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="virgo">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo-2.png"/>
                                                        <div class="signName">
                                                            Virgo                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="libra">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra-2.png"/>
                                                        <div class="signName">
                                                            Libra                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="scorpio">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio-2.png"/>
                                                        <div class="signName">
                                                            Scorpio                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="sagittarius">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius-2.png"/>
                                                        <div class="signName">
                                                            Sagittarius                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="capricorn">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn-2.png"/>
                                                        <div class="signName">
                                                            Capricorn                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aquarius">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius-2.png"/>
                                                        <div class="signName">
                                                            Aquarius                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="pisces">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces-2.png"/>
                                                        <div class="signName">
                                                            Pisces                            
                                                        </div>
                                                        
                                                    </div>
                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>';
    } else {
        $html .= '<div class="loveWidget">
                                        <div class="divine__dh__title">
                                            <div class="divine__dh__name"><h4 class="divine__ta__heading w3-center">Love Compatibility</h4></div>
                                        </div>
                                        <div class="contentDiv">
                                            <div class="circlesWrap">
                                                <div class="circle-filled1-midPage black dashed-cir" id="circleSign1">
                                                    
                                                    <div class="circle-filled1-midDivSpan">
                                                        <span></span>
                                                    </div>
                                                    <div class="circle-filled1-midDivImg">
                                                    </div>
                                                </div>
                                    
                                                <div class="circle-filled1-midPage black dashed-cir" id="circleSign2">
                                                    
                                                    <div class="circle-filled1-midDivSpan">
                                                        <span></span>
                                                    </div>
                                                    <div class="circle-filled1-midDivImg">
                                                    </div>
                                                </div>
                                            </div>
                                
                                            <div class="zodiacWrapper show row" id="zodiacSign1">
                                                <br/>
                                                <div class="col-md-12 selecthead" style="width:100%;">
                                                <h3 class="signhead">Please select Your Sign</h3>
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aries">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries.png"/>
                                                    <div class="signName">
                                                        Aries
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="taurus">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus.png"/>
                                                    <div class="signName">
                                                        Taurus
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="gemini">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini.png"/>
                                                    <div class="signName">
                                                        Gemini                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="cancer">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer.png"/>
                                                    <div class="signName">
                                                        Cancer                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="leo">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo.png"/>
                                                    <div class="signName">
                                                        Leo                            
                                                    </div>
                                                
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="virgo">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo.png"/>
                                                    <div class="signName">
                                                        Virgo                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="libra">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra.png"/>
                                                    <div class="signName">
                                                        Libra                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="scorpio">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio.png"/>
                                                    <div class="signName">
                                                        Scorpio                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="sagittarius">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius.png"/>
                                                    <div class="signName">
                                                        Sagittarius                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="capricorn">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn.png"/>
                                                    <div class="signName">
                                                        Capricorn                            
                                                    </div>
                                                    
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aquarius">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius.png"/>
                                                    <div class="signName">
                                                        Aquarius                            
                                                    </div>
                                                
                                                </div>
                                                <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="pisces">
                                                    <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces.png"/>
                                                    <div class="signName">
                                                        Pisces                            
                                                    </div>
                                                    
                                                </div>
                                            
                                                </div>
                                                <div class="zodiacWrapper hide" id="zodiacSign2">
                                                    <br/>
                                                    <div class="col-md-12 selecthead"  style="width:100%;">
                                                        <h3 class="signhead">Please select Your Partner Sign</h3>
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aries">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries.png"/>
                                                        <div class="signName">
                                                            Aries
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="taurus">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus.png"/>
                                                        <div class="signName">
                                                            Taurus
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="gemini">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini.png"/>
                                                        <div class="signName">
                                                            Gemini                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="cancer">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer.png"/>
                                                        <div class="signName">
                                                            Cancer                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="leo">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo.png"/>
                                                        <div class="signName">
                                                            Leo                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="virgo">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo.png"/>
                                                        <div class="signName">
                                                            Virgo                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="libra">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra.png"/>
                                                        <div class="signName">
                                                            Libra                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="scorpio">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio.png"/>
                                                        <div class="signName">
                                                            Scorpio                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="sagittarius">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius.png"/>
                                                        <div class="signName">
                                                            Sagittarius                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="capricorn">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn.png"/>
                                                        <div class="signName">
                                                            Capricorn                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="aquarius">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius.png"/>
                                                        <div class="signName">
                                                            Aquarius                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="signWrap col-md-2 col-sm-4 col-xs-4"  id="pisces">
                                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces.png"/>
                                                        <div class="signName">
                                                            Pisces                            
                                                        </div>
                                                        
                                                    </div>
                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>';
    }

    $html .= '</div>
                    <div id="divine__dh__overlay" class="divine__plugin__overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="divine_auth_domain_response">
                    <p style="color: red !important;text-align:center !important;"></p>
                </div>
               
                <div class="divine__dh__content_wrap" style="padding-top:7px !important;">
                    
                    <div id="DivineOverallCompatibility" class="divine__dh__content__data" style="display: block;">
                    
                    </div>
                    <div id="DivinePositiveAspects" class="divine__dh__content__data" style="display: block;">
                    
                    </div>
                    <div id="DivineNegativeAspects" class="divine__dh__content__data" style="display: block;">
                    
                    </div>
                    <div id="DivineElements" class="divine__dh__content__data" style="display: block;">
                    
                    </div>
                    <div id="DivineIdealDate" class="divine__dh__content__data" style="display: block;">
                    
                    </div>
                    <div id="DivineScore" class="divine__dh__content__data" style="display: block;">
                    
                    </div>
                    <button class="divine__lc__changecard__btn hide">Test Another Match</button>
                </div>
                
            </div>';
    return $html;
}
add_shortcode('divine_love_compatibility', 'dhat_love_compatibility_shortcode');


function dhat_tarot_one_card_shortcode($atts)
{
    $divId = (isset($atts['att']) ? strtolower(trim($atts['att'])) : 'divine-angel-reading');
    wp_enqueue_style('myplugin-' . $divId . '-style', DHAT_PLUGIN_URL . 'public/css/public-' . $divId . '.css', '', rand());
    wp_enqueue_script('myplugin-' . $divId . '-script', DHAT_PLUGIN_URL . 'public/js/public-' . $divId . '.js', array('jquery'), rand(), true);
    $divIdOption = str_replace('-', '_', $divId);
    $api_key = get_option('divine_settings_input_field');
    $card_style = get_option($divIdOption . '_settings_card_field');
    $color_text = get_option($divIdOption . '_settings_text_color_field');
    $font_size = get_option($divIdOption . '_settings_font_size_field');
    $color_theme = get_option($divIdOption . '_settings_theme_color_field');
    $color_category = get_option($divIdOption . '_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'card_style' => $card_style,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );
    wp_localize_script('myplugin-' . $divId . '-script', '' . $divIdOption . '_options', $scriptData);

    $html = '<div id="' . $divId . '" class="w3-card-4 divine__ta__widget">               
                <div class="w3-card-1 w3-padding w3-round-large w3-margin-bottom">   
                    <h3 class="divine__ta__heading w3-center"></h3>
                    <h4 class="divine__ta__subheading">Pick a Card</h4>
                    <div class="divine__ta__deck">
                        <div class="divine__ta__innnerdeck">
                            <a href="javascript:void(0)" class="divine__ta__card card-1"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-2" ></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-3"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-4"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-5"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-6"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-7"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-8"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-9"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-10"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-11"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-12"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-13"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-14"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-15"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-16"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-17"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-18"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-19"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-20"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-21"></a>
                            <a href="javascript:void(0)" class="divine__ta__card card-22"></a>
                        </div>
                    </div>
                    <div id="divine__ta__overlay" class="divine__plugin__overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="divine_auth_domain_response">
                        <p style="color: red !important;text-align:center !important;"></p>
                    </div>
                    <div id="widgetTA_result" style="display: none;">
                        <div style="text-align: center;">
                            <img class="ta__card__image" src="" alt="Card image" style="height: 250px;" />
                            <h3 class="divine__ta__cardname">THE FOOL</h3>
                            <div>
                                
                                <div id="TA-tab-data-1" class="divine__ta__contentdata" style="display: block;">
                                    <p>
                                    </p>
                                </div>
                                
                                <div class="divine__ta__background">
                                    <button class="divine__ta__changecard__btn">Pick another card</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    return $html;
}
add_shortcode('divine_angel_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_career_daily_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_dream_come_true_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_egyptian_prediction', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_erotic_love_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_ex_flame_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_flirt_love_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_know_your_friend_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_in_depth_love_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_made_for_each_other_or_not', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_past_lives_connection_reading', 'dhat_tarot_one_card_shortcode');
add_shortcode('divine_power_life_reading', 'dhat_tarot_one_card_shortcode');

function dhat_tarot_two_card_shortcode($atts)
{
    $apiId = (isset($atts['att']) ? strtolower(trim($atts['att'])) : '');

    if ($apiId == 'wisdom-reading') {
        $heading = 'Wisdom Reading';
        $html_element_data = array('CardImage_1', 'CardImage_2', 'widgetTZ_result', 'TZ-tab-data-1', 'TZ-tab-data-2', 'cardName1', 'cardName2', 'yin.png', 'yang.png', 'get__reading', 'set__reading');
    } else if ($apiId == 'heartbreak-reading') {
        $heading = 'Heartbreak Reading';
        $html_element_data = array('TBCardImage_1', 'TBCardImage_2', 'widgetTB_result', 'TB-tab-data-1', 'TB-tab-data-2', 'TBcardName1', 'TBcardName2', 'breakup-cause.png', 'breakup-advice.png', 'get_TB_reading', 'set_TB_reading');
    } else if ($apiId == 'divine-magic-reading') {
        $heading = 'Divine Magic Reading';
        $html_element_data = array('WMCardImage_1', 'WMCardImage_2', 'widgetTWM_result', 'TWM-tab-data-1', 'TWM-tab-data-2', 'WMcardName1', 'WMcardName2', 'white-magic-cause.png', 'white-magic-remedy.png', 'get_WM_reading', 'set_WM_reading');
    }
    wp_enqueue_style('myplugin-' . $apiId . '-style', DHAT_PLUGIN_URL . 'public/css/public-' . $apiId . '.css', '', rand());
    wp_enqueue_script('myplugin-' . $apiId . '-script', DHAT_PLUGIN_URL . 'public/js/public-' . $apiId . '.js', array('jquery'), rand(), true);

    $divIdOption = str_replace('-', '_', $apiId);
    $api_key = get_option('divine_settings_input_field');
    $card_style = get_option($divIdOption . '_settings_card_field');
    $color_text = get_option($divIdOption . '_settings_text_color_field');
    $font_size = get_option($divIdOption . '_settings_font_size_field');
    $color_theme = get_option($divIdOption . '_settings_theme_color_field');
    $color_category = get_option($divIdOption . '_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'card_style' => $card_style,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );
    wp_localize_script('myplugin-' . $apiId . '-script', '' . $divIdOption . '_options', $scriptData);

    $html = '<div id="' . $apiId . '" class="w3-card-4 divine__ta__widget">               
                <div class="w3-card-1 w3-padding w3-round-large w3-margin-bottom">   
                    <h3 class="divine__ta__heading w3-center">' . $heading . '</h3>
                    <h4 class="divine__ta__subheading">PICK A CARD</h4> 
                    <div class="flex-center-inline center-cards">
                        <img id="' . $html_element_data[0] . '" src="' . DHAT_PLUGIN_URL . 'public/images/' . $html_element_data[7] . '" width="160" height="160" alt="Reveal card 1" class="img-responsive" data-src="">
                        <img id="' . $html_element_data[1] . '" src="' . DHAT_PLUGIN_URL . 'public/images/' . $html_element_data[8] . '" width="160" height="160" alt="Reveal card 2" class="img-responsive" data-src="">
                    </div>
                    <div class="divine__ta__background">
                        <button class="divine__ta__changecard__btn" id="' . $html_element_data[9] . '">Get Your ' . $heading . '</button>
                    </div>
                    <div class="divine_auth_domain_response">
                        <p style="color: red !important;text-align:center !important;"></p>
                    </div>
                    <div id="' . $html_element_data[2] . '" style="display: none;">
                        <div style="text-align: center;">
                
                            <div style="margin-top: 20px;">
                    
                                <div id="' . $html_element_data[3] . '" class="divine__ta__contentdata" style="display: block;">
                                    <h3 class="divine__ta__cardname" id="' . $html_element_data[5] . '"></h3>
                                    <p>
                                    </p>
                                </div>
                                <div id="' . $html_element_data[4] . '" class="divine__ta__contentdata" style="display: block;">
                                    <h3 class="divine__ta__cardname" id="' . $html_element_data[6] . '"></h3>
                                    <p>
                                    </p>
                                </div>
                    
                                <div class="divine__ta__background">
                                    <button class="divine__ta__changecard__btn" id="' . $html_element_data[10] . '">Get Another ' . $heading . '</button>
                                </div>
                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    return $html;
}
add_shortcode('divine_heartbreak_reading', 'dhat_tarot_two_card_shortcode');
add_shortcode('divine_magic_reading', 'dhat_tarot_two_card_shortcode');
add_shortcode('divine_wisdom_reading', 'dhat_tarot_two_card_shortcode');


function dhat_chinese_horoscope_shortcode($atts)
{
    wp_enqueue_style('myplugin-ch-style', DHAT_PLUGIN_URL . 'public/css/public-ch.css', '', rand());
    wp_enqueue_script('myplugin-ch-script', DHAT_PLUGIN_URL . 'public/js/public-ch.js', array('jquery'), rand(), true);

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $timezone_id = intval(get_option('chinese_horoscope_settings_timezone_field'));
    $sign = get_option('chinese_horoscope_settings_sign_field');
    $color_text = get_option('chinese_horoscope_settings_text_color_field');
    $font_size = get_option('chinese_horoscope_settings_font_size_field');
    $color_theme = get_option('chinese_horoscope_settings_theme_color_field');
    $color_category = get_option('chinese_horoscope_settings_category_color_field');

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));
    $yesterday = date('Y-m-d', strtotime($reference_datetime . ' -1 day'));
    $tomorrow = date('Y-m-d', strtotime($reference_datetime . ' +1 day'));

    $scriptData = array(
        'token' => base64_encode($api_key),
        'timezone' => $gmt_sign . $timezone,
        'sign' => $sign,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );

    wp_localize_script('myplugin-ch-script', 'ch_options', $scriptData);

    $html = '<div id="chinese-horoscope" class="w3-card-4 divine__dh__widget">               
                <div class="w3-card-0 w3-padding w3-round-large w3-margin-bottom">
                    <h3 class="divine__dch__heading">Chinese Horoscopes</h3>
                    <div class="divine-row">
                        <div class="divine-col divine__dch__signbox" c_sign="Dog">
                            <div class="divine__dch__sign active" c_sign="Dog">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/DOG.jpg"/>
                                Dog
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Dragon">
                            <div class="divine__dch__sign" c_sign="Dragon">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/DRAGON.jpg"/>
                                Dragon
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Goat">
                            <div class="divine__dch__sign" c_sign="Goat">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/GOAT.jpg"/>
                                Goat
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Horse">
                            <div class="divine__dch__sign" c_sign="Horse">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/HORSE.jpg"/>
                                Horse
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Monkey">
                            <div class="divine__dch__sign" c_sign="Monkey">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/MONKEY.jpg"/>
                                Monkey
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Ox">
                            <div class="divine__dch__sign" c_sign="Ox">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/OX.jpg"/>
                                Ox
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Pig">
                            <div class="divine__dch__sign" c_sign="Pig">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/PIG.jpg"/>
                                Pig
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Rabbit">
                            <div class="divine__dch__sign" c_sign="Rabbit">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/RABBIT.jpg"/>
                                Rabbit
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Rat">
                            <div class="divine__dch__sign" c_sign="Rat">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/RAT.jpg"/>
                                Rat
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Rooster">
                            <div class="divine__dch__sign" c_sign="Rooster">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/ROOSTER.jpg"/>
                                Rooster
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Snake">
                            <div class="divine__dch__sign" c_sign="Snake">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/SNAKE.jpg"/>
                                Snake
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Tiger">
                            <div class="divine__dch__sign" c_sign="Tiger">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/TIGER.jpg"/>
                                Tiger
                            </div>
                        </div>
                    </div>

                    <div class="divine__dch__title">
                        <div class="divine__dch__name">
                            <h4 class="divine__dch__date">Dog Chinese Horoscopes Today</h4>
                        </div>
                    </div>
        
                    <nav class="divine__dch__date__nav" id="divine-dch-set-daily">
                        <a class="btn-outline divine__dch__date__btn" day="Yesterday" date="' . date('Y-m-d', strtotime('-1 day')) . '" href="javascript:void(0);">Yesterday</a>
                        <a class="btn-outline divine__dch__date__btn active" day="Today" date="' . date('Y-m-d') . '" href="javascript:void(0);">Today</a>
                        <a class="btn-outline divine__dch__date__btn" day="Tomorrow" date="' . date('Y-m-d', strtotime('+1 day')) . '" href="javascript:void(0);">Tomorrow</a>
                    </nav>
                </div>

                <div id="divine__dch__overlay" class="divine__plugin__overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="divine_auth_domain_response">
                    <p style="color: red !important;text-align:center !important;"></p>
                </div>
                <div class="divine__dch__content_wrap">
                    <span class="divine__dch__result__date">07 July 2021</span>
                    <div id="Divineresult1" class="divine__dch__content__data" style="display: block;">
                        <p>
                        </p>
                    </div>
                </div>
            </div>';
    return $html;
}
add_shortcode('divine_chinese_horoscope', 'dhat_chinese_horoscope_shortcode');

function dhat_chinese_horoscope_shortcode_v2($atts)
{
    wp_enqueue_style('myplugin-ch-style', DHAT_PLUGIN_URL . 'public/css/public-ch-v2.css', '', rand());
    wp_enqueue_script('myplugin-ch-script', DHAT_PLUGIN_URL . 'public/js/public-ch-v2.js', array('jquery'), rand(), true);

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('chinese_horoscope_settings_timezone_field'));
    $sign = get_option('chinese_horoscope_settings_sign_field');
    $color_text = get_option('chinese_horoscope_settings_text_color_field');
    $font_size = get_option('chinese_horoscope_settings_font_size_field');
    $color_theme = get_option('chinese_horoscope_settings_theme_color_field');
    $color_category = get_option('chinese_horoscope_settings_category_color_field');

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));
    $yesterday = date('Y-m-d', strtotime($reference_datetime . ' -1 day'));
    $tomorrow = date('Y-m-d', strtotime($reference_datetime . ' +1 day'));

    $scriptData = array(
        'token' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'sign' => $sign,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );

    wp_localize_script('myplugin-ch-script', 'ch_options', $scriptData);

    $html = '<div id="chinese-horoscope" class="w3-card-4 divine__dh__widget">               
                <div class="w3-card-0 w3-padding w3-round-large w3-margin-bottom">
                    <h3 class="divine__dch__heading">Chinese Horoscopes</h3>
                    <div class="divine-row">
                        <div class="divine-col divine__dch__signbox" c_sign="Dog">
                            <div class="divine__dch__sign active" c_sign="Dog">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/DOG.jpg"/>
                                Dog
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Dragon">
                            <div class="divine__dch__sign" c_sign="Dragon">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/DRAGON.jpg"/>
                                Dragon
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Goat">
                            <div class="divine__dch__sign" c_sign="Goat">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/GOAT.jpg"/>
                                Goat
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Horse">
                            <div class="divine__dch__sign" c_sign="Horse">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/HORSE.jpg"/>
                                Horse
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Monkey">
                            <div class="divine__dch__sign" c_sign="Monkey">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/MONKEY.jpg"/>
                                Monkey
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Ox">
                            <div class="divine__dch__sign" c_sign="Ox">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/OX.jpg"/>
                                Ox
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Pig">
                            <div class="divine__dch__sign" c_sign="Pig">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/PIG.jpg"/>
                                Pig
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Rabbit">
                            <div class="divine__dch__sign" c_sign="Rabbit">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/RABBIT.jpg"/>
                                Rabbit
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Rat">
                            <div class="divine__dch__sign" c_sign="Rat">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/RAT.jpg"/>
                                Rat
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Rooster">
                            <div class="divine__dch__sign" c_sign="Rooster">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/ROOSTER.jpg"/>
                                Rooster
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Snake">
                            <div class="divine__dch__sign" c_sign="Snake">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/SNAKE.jpg"/>
                                Snake
                            </div>
                        </div>
                        <div class="divine-col divine__dch__signbox" c_sign="Tiger">
                            <div class="divine__dch__sign" c_sign="Tiger">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/chinese/TIGER.jpg"/>
                                Tiger
                            </div>
                        </div>
                    </div>

                    <div class="divine__dch__title">
                        <div class="divine__dch__name">
                            <h4 class="divine__dch__date">Dog Chinese Horoscopes Today</h4>
                        </div>
                    </div>
        
                    <nav class="divine__dch__date__nav" id="divine-dch-set-daily">
                        <a class="btn-outline divine__dch__date__btn" day="Yesterday" date="' . date('Y-m-d', strtotime('-1 day')) . '" href="javascript:void(0);">Yesterday</a>
                        <a class="btn-outline divine__dch__date__btn active" day="Today" date="' . date('Y-m-d') . '" href="javascript:void(0);">Today</a>
                        <a class="btn-outline divine__dch__date__btn" day="Tomorrow" date="' . date('Y-m-d', strtotime('+1 day')) . '" href="javascript:void(0);">Tomorrow</a>
                    </nav>
                </div>

                <div id="divine__dch__overlay" class="divine__plugin__overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="divine_auth_domain_response">
                    <p style="color: red !important;text-align:center !important;"></p>
                </div>
               <div class="divine__dh__category_tabs w3-card-4 w3-padding w3-round-large">
                    <ul>
                        <li>
                            <a href="javascript:void(0);" class="divine__dh__category__links active" style="text-transform: uppercase;" tab="Divinegrowth"><i class="divine__dh__icon__comment"></i> &nbsp; Growth</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="divine__dh__category__links" style="text-transform: uppercase;" tab="Divinehealth"><i class="divine__dh__icon__comment"></i> &nbsp; HEALTH</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="divine__dh__category__links" style="text-transform: uppercase;" tab="Divinewealth"><i class="divine__dh__icon__comment"></i> &nbsp; wealth</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="divine__dh__category__links" style="text-transform: uppercase;" tab="Divinecareer"><i class="divine__dh__icon__comment"></i> &nbsp; career</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="divine__dh__category__links" style="text-transform: uppercase;" tab="Divinelove"><i class="divine__dh__icon__comment"></i> &nbsp; love</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="divine__dh__category__links" style="text-transform: uppercase;" tab="Divinefamily"><i class="divine__dh__icon__comment"></i> &nbsp; family</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="divine__dh__category__links" style="text-transform: uppercase;" tab="Divinefortune"><i class="divine__dh__icon__comment"></i> &nbsp; fortune</a>
                        </li>
                    </ul>
                </div>
                <div class="divine__dch__content_wrap">
                    <span class="divine__dch__result__date">07 July 2021</span>
                    <div id="Divinegrowth" class="divine__dh__content__data" style="display: block;">
                        <span class="divine__dch__content__data">Growth</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinehealth" class="divine__dh__content__data">
                        <span class="divine__dch__content__data">Health</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinewealth" class="divine__dh__content__data">
                        <span class="divine__dch__content__data">Wealth</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinecareer" class="divine__dh__content__data">
                        <span class="divine__dch__content__data">Career</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinelove" class="divine__dh__content__data">
                        <span class="divine__dch__content__data">Love</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinefamily" class="divine__dh__content__data">
                        <span class="divine__dch__content__data">Family</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinefortune" class="divine__dh__content__data">
                        <span class="divine__dch__content__data">Fortune</span>
                        <p>
                        </p>
                    </div>
                </div>

            </div>';
    return $html;
}
add_shortcode('divine_chinese_horoscope_v2', 'dhat_chinese_horoscope_shortcode_v2');


function dhat_numerology_horoscope_shortcode($atts)
{
    wp_enqueue_style('myplugin-nh-style', DHAT_PLUGIN_URL . 'public/css/public-nh.css', '', rand());
    wp_enqueue_script('myplugin-nh-script', DHAT_PLUGIN_URL . 'public/js/public-nh.js', array('jquery'), rand(), true);

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $timezone_id = intval(get_option('numerology_horoscope_settings_timezone_field'));
    $sign = get_option('numerology_horoscope_settings_sign_field');
    $color_text = get_option('numerology_horoscope_settings_text_color_field');
    $font_size = get_option('numerology_horoscope_settings_font_size_field');
    $color_theme = get_option('numerology_horoscope_settings_theme_color_field');
    $color_category = get_option('numerology_horoscope_settings_category_color_field');

    if ($timezone_id > 0) {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value'];
    } else {
        $timezone = '5.5';
    }

    $timesign = '-';
    if($timezone > 0){
        $timesign = '-';
    }else{
        $timesign = '+';
    }
    $temptimezone = abs($timezone);
    date_default_timezone_set('Etc/GMT' . $timesign . $temptimezone);

    $gmt_sign = (($timezone < 0) ? '-' : '+');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));
    $yesterday = date('Y-m-d', strtotime($reference_datetime . ' -1 day'));
    $tomorrow = date('Y-m-d', strtotime($reference_datetime . ' +1 day'));

    $scriptData = array(
        'token' => base64_encode($api_key),
        'timezone' => $gmt_sign . $timezone,
        'sign' => $sign,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );

    wp_localize_script('myplugin-nh-script', 'nh_options', $scriptData);

    $html = '<div id="numerology-horoscope" class="w3-card-4 divine__dh__widget">               
                <div class="w3-card-0 w3-padding w3-round-large w3-margin-bottom">
                    <h3 class="divine__dnh__heading">DAILY NUMEROSCOPE</h3>
                    <div class="divine-row">
                        <div class="divine-col divine__dnh__numberbox" number="1">
                            <div class="divine__dnh__number active" number="1">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/1.jpg"/>
                                One
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="2">
                            <div class="divine__dnh__number" number="2">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/2.jpg"/>
                                Two
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="3">
                            <div class="divine__dnh__number" number="3">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/3.jpg"/>
                                Three
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="4">
                            <div class="divine__dnh__number" number="4">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/4.jpg"/>
                                Four
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="5">
                            <div class="divine__dnh__number" number="5">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/5.jpg"/>
                                Five
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="6">
                            <div class="divine__dnh__number" number="6">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/6.jpg"/>
                                Six
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="7">
                            <div class="divine__dnh__number" number="7">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/7.jpg"/>
                                Seven
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="8">
                            <div class="divine__dnh__number" number="8">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/8.jpg"/>
                                Eight
                            </div>
                        </div>
                        <div class="divine-col divine__dnh__numberbox" number="9">
                            <div class="divine__dnh__number" number="9">
                                <img src="' . DHAT_PLUGIN_URL . 'public/images/number/9.jpg"/>
                                Nine
                            </div>
                        </div>
                    </div>

                    <div class="divine__dnh__title">
                        <div class="divine__dnh__name"><h4 class="divine__dnh__date">Numerology Horoscope Today</h4></div>
                    </div>
                    
                    <nav class="divine__dnh__date__nav" id="divine-dnh-set-daily">
                        <a class="btn-outline divine__dnh__date__btn" day="Yesterday" date="' . date('Y-m-d', strtotime('-1 day')) . '" href="javascript:void(0);">Yesterday</a>
                        <a class="btn-outline divine__dnh__date__btn active" day="Today" date="' . date('Y-m-d') . '" href="javascript:void(0);">Today</a>
                        <a class="btn-outline divine__dnh__date__btn" day="Tomorrow" date="' . date('Y-m-d', strtotime('+1 day')) . '" href="javascript:void(0);">Tomorrow</a>
                    </nav>
                </div>
                <div id="divine__dnh__overlay" class="divine__plugin__overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="divine_auth_domain_response">
                    <p style="color: red !important;text-align:center !important;"></p>
                </div>
                <div class="divine__dnh__content_wrap">
                    <span class="divine__dnh__result__date">07 July 2021</span>
                    <div id="Divineresult" class="divine__dnh__content__data" style="display: block;">
                        <p>
                        </p>
                    </div>
                </div>
            </div>';
    return $html;
}
add_shortcode('divine_numerology_horoscope', 'dhat_numerology_horoscope_shortcode');


function dhat_tarot_three_card_shortcode($atts)
{
    $apiId = (isset($atts['att']) ? strtolower(trim($atts['att'])) : '');

    if ($apiId == 'past-present-future-reading') {
        $shortId = 'ppf';
        $heading = 'Past Present Future Reading';
        $html_element_data = array('3CTCardImage_1', '3CTCardImage_2', '3CTCardImage_3', 'past.png', 'present.png', 'future.png', 'get_3CT_reading', 'widget3CT_result', '3CT-tab-data-1', '3CTcardName1', '3CT-tab-data-2', '3CTcardName2', '3CT-tab-data-3', '3CTcardName3', 'set_3CT_reading');
    } else if ($apiId == 'love-triangle-reading') {
        $shortId = 'ltr';
        $heading = 'Love Triangle Reading';
        $html_element_data = array('TLTCardImage_1', 'TLTCardImage_2', 'TLTCardImage_3', 'lovers-triangle-you.png', 'lovers-triangle-lover1.png', 'lovers-triangle-lover2.png', 'get_TLT_reading', 'widgetTLT_result', 'TLT-tab-data-1', 'TLTcardName1', 'TLT-tab-data-2', 'TLTcardName2', 'TLT-tab-data-3', 'TLTcardName3', 'set_TLT_reading');
    }
    wp_enqueue_style('myplugin-' . $shortId . '-style', DHAT_PLUGIN_URL . 'public/css/public-' . $shortId . '.css', '', rand());
    wp_enqueue_script('myplugin-' . $shortId . '-script', DHAT_PLUGIN_URL . 'public/js/public-' . $shortId . '.js', array('jquery'), rand(), true);

    $divIdOption = str_replace('-', '_', $apiId);
    $api_key = get_option('divine_settings_input_field');
    $card_style = get_option($divIdOption . '_settings_card_field');
    $color_text = get_option($divIdOption . '_settings_text_color_field');
    $font_size = get_option($divIdOption . '_settings_font_size_field');
    $color_theme = get_option($divIdOption . '_settings_theme_color_field');
    $color_category = get_option($divIdOption . '_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'card_style' => $card_style,
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
        'divIdOption' => $divIdOption,
    );
    
    wp_localize_script('myplugin-' . $shortId . '-script', '' . $shortId . '_options', $scriptData);

    $html = '<div id="' . $apiId . '" class="w3-card-4 divine__ta__widget">               
                <div class="w3-card-1 w3-padding w3-round-large w3-margin-bottom">   
                    <h3 class="divine__ta__heading w3-center">' . $heading . '</h3>
                    <h4 class="divine__ta__subheading">PICK A CARD</h4> 
                    <div class="flex-center-inline center-cards">
                        <img id="' . $html_element_data[0] . '" src="' . DHAT_PLUGIN_URL . 'public/images/' . $html_element_data[3] . '" width="160" height="160" alt="Reveal card 1" class="img-responsive" data-src="">
                        <img id="' . $html_element_data[1] . '" src="' . DHAT_PLUGIN_URL . 'public/images/' . $html_element_data[4] . '" width="160" height="160" alt="Reveal card 2" class="img-responsive" data-src="">
                        <img id="' . $html_element_data[2] . '" src="' . DHAT_PLUGIN_URL . 'public/images/' . $html_element_data[5] . '" width="160" height="160" alt="Reveal card 2" class="img-responsive" data-src="">
                    </div>
                    <div class="divine__ta__background">
                        <button class="divine__ta__changecard__btn" id="' . $html_element_data[6] . '">Submit</button>
                    </div>
                    <div class="divine_auth_domain_response">
                        <p style="color: red !important;text-align:center !important;"></p>
                    </div>
                    <div id="' . $html_element_data[7] . '" style="display: none;">
                        <div style="text-align: center;">
                            
                            <div style="margin-top: 20px;">
                                
                                <div id="' . $html_element_data[8] . '" class="divine__ta__contentdata" style="display: block;">
                                    <h3 class="divine__ta__cardname" id="' . $html_element_data[9] . '"></h3>
                                    <p>
                                    </p>
                                </div>
                                <div id="' . $html_element_data[10] . '" class="divine__ta__contentdata" style="display: block;">
                                    <h3 class="divine__ta__cardname" id="' . $html_element_data[11] . '"></h3>
                                    <p>
                                    </p>
                                </div>
                                <div id="' . $html_element_data[12] . '" class="divine__ta__contentdata" style="display: block;">
                                    <h3 class="divine__ta__cardname" id="' . $html_element_data[13] . '"></h3>
                                    <p>
                                    </p>
                                </div>
                                
                                <div class="divine__ta__background">
                                    <button class="divine__ta__changecard__btn" id="' . $html_element_data[14] . '">Get Your Reading Again</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    return $html;
}
add_shortcode('divine_past_present_future_reading', 'dhat_tarot_three_card_shortcode');
add_shortcode('divine_love_triangle_reading', 'dhat_tarot_three_card_shortcode');


function dhat_which_animal_are_you_reading_shortcode($atts)
{
    wp_enqueue_style('myplugin-ia-style', DHAT_PLUGIN_URL . 'public/css/public-ia.css', '', rand());
    wp_enqueue_script('myplugin-ia-script', DHAT_PLUGIN_URL . 'public/js/public-ia.js', array('jquery'), rand(), true);

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $color_text = get_option('which_animal_are_you_reading_settings_text_color_field');
    $font_size = get_option('which_animal_are_you_reading_settings_font_size_field');
    $color_theme = get_option('which_animal_are_you_reading_settings_theme_color_field');
    $color_category = get_option('which_animal_are_you_reading_settings_category_color_field');

    $scriptData = array(
        'token' => base64_encode($api_key),
        'color_text' => $color_text,
        'font_size' => $font_size,
        'color_theme' => $color_theme,
        'color_category' => $color_category,
    );

    wp_localize_script('myplugin-ia-script', 'ia_options', $scriptData);

    $html = '<div id="which-animal-are-you" class="w3-card-4 divine__dh__widget">               
                <div class="w3-card-1 w3-padding w3-round-large w3-margin-bottom">
                    <h3 class="divine__tia__heading">Which Animal Are You Reading</h3>
                        
                    <div class="tarot-deck yellow-bg" id="inner-animal-form">
                    
                        <h3 class="frm-label">Enter your First Name:</h3>
                        <input name="FirstName" type="text" class="input-large" size="30" id="name">
                        
                        <h3 class="frm-label">Enter your Date of Birth:</h3>
                        <div class="grid grid-3">
                            <label class="caret-gray">
                                <select name="MonthSelector" id="month">
                                    <option disabled="" selected=""  value="">Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </label>
                            <label class="caret-gray">
                                <select name="DaySelector" id="date">
                                    <option disabled="" selected="" value="">Day</option>';
    for ($i = 1; $i <= 31; $i++) {
        $html .= '<option value="' . $i . '">' . $i . '</option>';
    }


    $html .= '               </select>
                            </label>
                            <label class="caret-gray">
                                <select name="YearSelector" id="year">
                                    <option disabled="" selected="" value="">Year</option>';
    $year = 1920;
    foreach (range(date('Y'), $year) as $x) {
        $html .= '<option value="' . $x . '">' . $x . '</option>';
    }

    $html .=                '</select>
                            </label>
                        </div> 
                        <div class="divine__ta__background">
                            <button class="divine__ta__changecard__btn" id="get_TIA_reading">Know Your Inner Animal</button>
                        </div>
                    </div>
                    <div class="divine_auth_domain_response">
                        <p style="color: red !important;text-align:center !important;"></p>
                    </div>
                    <div id="widgetTIA_result" style="display:none;">
                        <div style="text-align: center;">
                            
                            <div style="margin-top: 20px;">
                                
                                <div id="TIA-tab-data-1" class="divine__tia__contentdata" style="display: block;">
                                    <h2 class="divine__ta__resheading">Your Inner Animal is:</h2>
                                    
                                    <img class="img-responsive" alt="Inner animal card" src="" id="TIACardImage">
                                    <h3 class="divine__ta__cardname" id="TBanimalName">Lion (The Emperor)</h3>
                                    <p>
                                    </p>
                                </div>
                                <div class="divine__ta__background">
                                    <button class="divine__ta__changecard__btn" id="set_TIA_reading">Get Your Reading Again</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>';
    return $html;
}
add_shortcode('divine_which_animal_are_you_reading', 'dhat_which_animal_are_you_reading_shortcode');

function dhat_daily_panchang_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-script', DHAT_PLUGIN_URL . 'public/js/public-dp.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    $sun_moon_section_color = get_option('daily_panchang_settings_sun_moon_btn_color_field');
    $sun_moon_label_color = get_option('daily_panchang_settings_sun_moon_label_color_field');
    $panchang_section_color = get_option('daily_panchang_settings_panchang_btn_color_field');
    $panchang_label_color = get_option('daily_panchang_settings_panchang_label_color_field');
    $lunar_month_and_samvat_section_color = get_option('daily_panchang_settings_lunar_month_and_samvat_btn_color_field');
    $lunar_month_and_samvat_label_color = get_option('daily_panchang_settings_lunar_month_and_samvat_label_color_field');
    $rashi_and_nakshatra_section_color = get_option('daily_panchang_settings_rashi_and_nakshatra_btn_color_field');
    $rashi_and_nakshatra_label_color = get_option('daily_panchang_settings_rashi_and_nakshatra_label_color_field');
    $ritu_and_ayana_section_color = get_option('daily_panchang_settings_ritu_and_ayana_btn_color_field');
    $ritu_and_ayana_label_color = get_option('daily_panchang_settings_ritu_and_ayana_label_color_field');
    $auspi_timings_section_color = get_option('daily_panchang_settings_auspi_timings_btn_color_field');
    $auspi_timings_label_color = get_option('daily_panchang_settings_auspi_timings_label_color_field');
    $in_auspi_timings_section_color = get_option('daily_panchang_settings_in_auspi_timings_btn_color_field');
    $in_auspi_timings_label_color = get_option('daily_panchang_settings_in_auspi_timings_label_color_field');
    $nivas_and_shool_section_color = get_option('daily_panchang_settings_nivas_and_shool_btn_color_field');
    $nivas_and_shool_label_color = get_option('daily_panchang_settings_nivas_and_shool_label_color_field');
    $chandra_and_tara_section_color = get_option('daily_panchang_settings_chandra_and_tara_btn_color_field');
    $chandra_and_tara_label_color = get_option('daily_panchang_settings_chandra_and_tara_label_color_field');
    $other_calendar_and_epoch_section_color = get_option('daily_panchang_settings_other_calendar_and_epoch_btn_color_field');
    $other_calendar_and_epoch_label_color = get_option('daily_panchang_settings_other_calendar_and_epoch_label_color_field');
    $panchak_and_udaya_section_color = get_option('daily_panchang_settings_panchak_and_udaya_btn_color_field');
    $panchak_and_udaya_label_color = get_option('daily_panchang_settings_panchak_and_udaya_label_color_field');
    $show_sun_moon_section = get_option('daily_panchang_settings_sun_moon_show_hide_field');
    $show_panchang_section = get_option('daily_panchang_settings_panchang_show_hide_field');
    $show_lunar_and_samvat_section = get_option('daily_panchang_settings_lunar_month_and_samvat_show_hide_field');
    $show_rashi_and_nakshatra_section = get_option('daily_panchang_settings_rashi_and_nakshatra_show_hide_field');
    $show_ritu_and_ayana_section = get_option('daily_panchang_settings_ritu_and_ayana_show_hide_field');
    $show_auspi_timings_section = get_option('daily_panchang_settings_auspi_timings_show_hide_field');
    $show_in_auspi_timings_section = get_option('daily_panchang_settings_in_auspi_timings_show_hide_field');
    $show_nivas_and_shool_section = get_option('daily_panchang_settings_nivas_and_shool_show_hide_field');
    $show_chandra_and_tara_section = get_option('daily_panchang_settings_chandra_and_tara_show_hide_field');
    $show_other_calendar_and_epoch_section = get_option('daily_panchang_settings_other_calendar_and_epoch_show_hide_field');
    $show_panchak_and_udaya_section = get_option('daily_panchang_settings_panchak_and_udaya_show_hide_field');
    // $color_text = get_option('daily_panchang_settings_text_color_field');
    // $font_size = get_option('daily_panchang_settings_font_size_field');
    // $color_theme = get_option('daily_panchang_settings_theme_color_field');

    // if($timezone_id > 0)
    // {
    //     $id = array_search($timezone_id, array_column($timezones, 'id'));
    //     $timezone = $timezones[$id]['value']; 
    // }
    // else
    // {
    $timezone = '5.5';
    // }

    $show_sun_moon_section_style = ($show_sun_moon_section == 'on') ? '' : 'style="display:none;"';
    $show_panchang_section_style = ($show_panchang_section == 'on') ? '' : 'style="display:none;"';
    $show_lunar_and_samvat_section_style = ($show_lunar_and_samvat_section == 'on') ? '' : 'style="display:none;"';
    $show_rashi_and_nakshatra_section_style = ($show_rashi_and_nakshatra_section == 'on') ? '' : 'style="display:none;"';
    $show_ritu_and_ayana_section_style = ($show_ritu_and_ayana_section == 'on') ? '' : 'style="display:none;"';
    $show_auspi_timings_section_style = ($show_auspi_timings_section == 'on') ? '' : 'style="display:none;"';
    $show_in_auspi_timings_section_style = ($show_in_auspi_timings_section == 'on') ? '' : 'style="display:none;"';
    $show_nivas_and_shool_section_style = ($show_nivas_and_shool_section == 'on') ? '' : 'style="display:none;"';
    $show_chandra_and_tara_section_style = ($show_chandra_and_tara_section == 'on') ? '' : 'style="display:none;"';
    $show_other_calendar_and_epoch_section_style = ($show_other_calendar_and_epoch_section == 'on') ? '' : 'style="display:none;"';
    $show_panchak_and_udaya_section_style = ($show_panchak_and_udaya_section == 'on') ? '' : 'style="display:none;"';

    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'sun_moon_section_color' => $sun_moon_section_color,
        'sun_moon_label_color' => $sun_moon_label_color,
        'panchang_section_color' => $panchang_section_color,
        'panchang_label_color' => $panchang_label_color,
        'lunar_month_and_samvat_section_color' => $lunar_month_and_samvat_section_color,
        'lunar_month_and_samvat_label_color' => $lunar_month_and_samvat_label_color,
        'rashi_and_nakshatra_section_color' => $rashi_and_nakshatra_section_color,
        'rashi_and_nakshatra_label_color' => $rashi_and_nakshatra_label_color,
        'ritu_and_ayana_section_color' => $ritu_and_ayana_section_color,
        'ritu_and_ayana_label_color' => $ritu_and_ayana_label_color,
        'auspi_timings_section_color' => $auspi_timings_section_color,
        'auspi_timings_label_color' => $auspi_timings_label_color,
        'in_auspi_timings_section_color' => $in_auspi_timings_section_color,
        'in_auspi_timings_label_color' => $in_auspi_timings_label_color,
        'nivas_and_shool_section_color' => $nivas_and_shool_section_color,
        'nivas_and_shool_label_color' => $nivas_and_shool_label_color,
        'chandra_and_tara_section_color' => $chandra_and_tara_section_color,
        'chandra_and_tara_label_color' => $chandra_and_tara_label_color,
        'other_calendar_and_epoch_section_color' => $other_calendar_and_epoch_section_color,
        'other_calendar_and_epoch_label_color' => $other_calendar_and_epoch_label_color,
        'panchak_and_udaya_section_color' => $panchak_and_udaya_section_color,
        'panchak_and_udaya_label_color' => $panchak_and_udaya_label_color,
        'show_sun_moon_section' => $show_sun_moon_section,
        'show_panchang_section' => $show_panchang_section,
        'show_lunar_and_samvat_section' => $show_lunar_and_samvat_section,
        'show_rashi_and_nakshatra_section' => $show_rashi_and_nakshatra_section,
        'show_ritu_and_ayana_section' => $show_ritu_and_ayana_section,
        'show_auspi_timings_section' => $show_auspi_timings_section,
        'show_in_auspi_timings_section' => $show_in_auspi_timings_section,
        'show_nivas_and_shool_section' => $show_nivas_and_shool_section,
        'show_chandra_and_tara_section' => $show_chandra_and_tara_section,
        'show_other_calendar_and_epoch_section' => $show_other_calendar_and_epoch_section,
        'show_panchak_and_udaya_section' => $show_panchak_and_udaya_section,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate" value="">
                                                        <span id="dapi-wdate-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                        <div class="dapi-ac-bg mx-auto" id="dapisunmoon" ' . $show_sun_moon_section_style . '>
                                            <button class="dapi-accordion dapiac1" dapiac="dapiac1">Sunrise and Moonrise</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac1">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapipanchang" ' . $show_panchang_section_style . '>
                                            <button class="dapi-accordion dapiac2" dapiac="dapiac2">Panchang</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac2">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapilunarsamvat" ' . $show_lunar_and_samvat_section_style . '>
                                            <button class="dapi-accordion dapiac3" dapiac="dapiac3">Lunar Month and Samvat</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac3">
                                            
                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapirashinakshatra" ' . $show_rashi_and_nakshatra_section_style . '>
                                            <button class="dapi-accordion dapiac4" dapiac="dapiac4">Rashi and Nakshatra</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac4">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapirituanaya" ' . $show_ritu_and_ayana_section_style . '>
                                            <button class="dapi-accordion dapiac5" dapiac="dapiac5">Ritu and Ayana</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac5">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapiauspitimings" ' . $show_auspi_timings_section_style . '>
                                            <button class="dapi-accordion dapiac6" dapiac="dapiac6">Auspicious Timings</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac6">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapiinauspitimings" ' . $show_in_auspi_timings_section_style . '>
                                            <button class="dapi-accordion dapiac7" dapiac="dapiac7">Inauspicious Timings</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac7">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapinivasshool" ' . $show_nivas_and_shool_section_style . '>
                                            <button class="dapi-accordion dapiac8" dapiac="dapiac8">Nivas and Shool</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac8">

                                            </div>
                                            
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapicalendarepoch" ' . $show_other_calendar_and_epoch_section_style . '>
                                            <button class="dapi-accordion dapiac10" dapiac="dapiac10">Other Calendars and Epoch</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac10">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="dapichandratara" ' . $show_chandra_and_tara_section_style . '>
                                            <button class="dapi-accordion dapiac9" dapiac="dapiac9">Chandrabalam & Tarabalam</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac9">

                                            </div>
                                        </div>

                                        <div class="dapi-ac-bg mx-auto" id="panchakaudaya" style="display:none;">
                                            <button class="dapi-accordion dapiac11" dapiac="dapiac11">Panchaka Rahita Muhurta and Udaya Lagna</button>
                                            <div class="dapi-panel dapi-active" id="dapiac11">
                                                <div class="divine-row dapi-row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 dapi-col clrd" id="dapipanchrahita">

                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 dapi-col clrd" id="dapiudayalgn">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMap() {
                const dp_elevator = new google.maps.ElevationService();
                let input = document.getElementById("dapi-location");
                let autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    let place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location").value = place.formatted_address;
                    displayLocationElevation(place.geometry.location, dp_elevator);
                });
            }
            function displayLocationElevation(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang', 'dhat_daily_panchang_shortcode');

function dapi_daily_panchang_custom_stylesheets()
{
    // wp_enqueue_style('myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
}
add_action('wp_enqueue_scripts', 'dapi_daily_panchang_custom_stylesheets', 99);

function dhat_festivals_shortcode()
{
    $currentMonth = date('m');
    $currentYear = date('Y');
    $dateTime = new DateTime('2000-' . $currentMonth . '-01');
    $monthName = $dateTime->format('F');

    wp_enqueue_script('myplugin-festive-script', DHAT_PLUGIN_URL . 'public/js/public-festive.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-festive-style', DHAT_PLUGIN_URL . 'public/css/public-festive.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('festivals_settings_background_color_field');
    $primary_badge = get_option('festivals_settings_primary_badge_color_field');
    $secondary_badge = get_option('festivals_settings_secondary_badge_color_field');
    $loader_color = get_option('festivals_settings_loader_color_field');
    
    if($timezone_id > 0)
    {
        $id = array_search($timezone_id, array_column($timezones, 'id'));
        $timezone = $timezones[$id]['value']; 
    }
    else
    {
    $timezone = '5.5';
    }

    
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => $api_key,
        'access_token' => $access_token,
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'c_year' => date('Y'),
        'c_month' => date('m'),
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'primary_festival_badge' => $primary_badge,
        'secondary_festival_badge' => $secondary_badge,
        'festival_loader' => $loader_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
    );

    wp_localize_script('myplugin-festive-script', 'fapi_options', $scriptData);

    $html = '
    <div id="fapi-maindiv">
    <div class="divine_auth_domain_response" id="festive-auth">
                <p style="color: red !important;text-align:center !important;"></p>
            </div>
    <div id="fapi-subdiv"><!-- Image loader -->
  
    <div class="fapicol-lg-12 fapicol-md-12 fapicol-sm-12 mx-auto d-flex">
   
    <form method="post" action="javascript:void(0);" id="getapidataform">
    <div class="fapidivine-row">
            <div class="fapicol-lg-6 fapicol-md-6 fapicol-sm-12 fapipad5">
                <input type="text" class="dapi-form-control" id="fapi-location" placeholder="Location" value="New Delhi, India">
            </div>
            <div class="fapicol-lg-6 fapicol-md-6 fapicol-sm-12">
            <div class="fapidivine-row">
            <div class="fapicol-lg-6 fapicol-md-6 fapicol-sm-6 fapipad5">
            <select name="month" id="month" class="dapi-form-control fapiminimal">';
            // <option value="' . $currentMonth . '" selected>' . $monthName . '</option>
    $html .=    '<option value="">Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10" selected>October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
            </div>
            <div class="fapicol-lg-6 fapicol-md-6 fapicol-sm-6 fapipad5">
            <select name="year" id="year" class="dapi-form-control fapiminimal">';
    $html .= '<option value="">Year</option>';
    for ($i = 1800; $i <= 2823; $i++) {
        $html .= '<option value="' . $i . '">' . $i . '</option>';
    }
    $html .= '</select>
            </div>
                
            </div>      
                </div>
            </div>
        </div>
        
    </form>
    <div id="fapiloader-box">
        <div class="row" id="fapiloader"><div class="col-lg-4 mx-auto text-center"><div class="dapi-sp sp-ldr-fes"></div></div></div>
    </div>
                <div id="calender-container" class="fapi-calender">
                    
                </div>

                <div class="fapi-message">
                    <p>click on date to view details</p> 
                </div>
                <div class="fapi-data" id="data">
                    
                </div>
                </div>
             </div>
             </div>

             <script>
             function initMapFestivals() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("fapi-location");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("fapi-location").value = place.formatted_address;
                    displayLocationElevation(place.geometry.location, elevator);
                });
            }
            function displayLocationElevation(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>
             ';



    return $html;
}

add_shortcode('divine_festivals', 'dhat_festivals_shortcode');

function dhat_daily_panchang_sunrise_moonrise_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-sm-script', DHAT_PLUGIN_URL . 'public/js/public-dp-sm.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-sm-style', DHAT_PLUGIN_URL . 'public/css/public-dp-sm.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    $sun_moon_section_color = get_option('daily_panchang_settings_sun_moon_btn_color_field');
    $sun_moon_label_color = get_option('daily_panchang_settings_sun_moon_label_color_field');
    
    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'sun_moon_section_color' => $sun_moon_section_color,
        'sun_moon_label_color' => $sun_moon_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,

        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-sm-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-sm" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-sm" value="">
                                                        <span id="dapi-wdate-sm-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-sm" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-sm" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-sm" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                        <div class="dapi-ac-bg mx-auto" id="dapisunmoon">
                                            <button class="dapi-accordion dapiac1" dapiac="dapiac1">Sunrise and Moonrise</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac1">

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapSM() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-sm");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-sm").value = place.formatted_address;
                    displayLocationElevationSM(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationSM(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_sunrise_moonrise', 'dhat_daily_panchang_sunrise_moonrise_shortcode');

function dhat_daily_panchang_only_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-panchang-script', DHAT_PLUGIN_URL . 'public/js/public-dp-panchang.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-panchang-style', DHAT_PLUGIN_URL . 'public/css/public-dp-panchang.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    $panchang_section_color = get_option('daily_panchang_settings_panchang_btn_color_field');
    $panchang_label_color = get_option('daily_panchang_settings_panchang_label_color_field');

    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'panchang_section_color' => $panchang_section_color,
        'panchang_label_color' => $panchang_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,        
    );

    wp_localize_script('myplugin-dp-panchang-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-panchang" value="">
                                                        <span id="dapi-wdate-panchang-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-panchang" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-panchang" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-panchang" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">



                                        <div class="dapi-ac-bg mx-auto" id="dapipanchang">
                                            <button class="dapi-accordion dapiac2" dapiac="dapiac2">Panchang</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac2">

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapPanchang() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location").value = place.formatted_address;
                    displayLocationElevationPanchang(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationPanchang(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_only', 'dhat_daily_panchang_only_shortcode');

function dhat_daily_panchang_shortcode_month_samvat($atts)
{

    wp_enqueue_style( 'myplugin-dp-samvat-style', DHAT_PLUGIN_URL . 'public/css/public-dp-samvat.css', '', rand());
    wp_enqueue_style('myplugin-dp-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-samvat-script', DHAT_PLUGIN_URL . 'public/js/public-dp-samvat.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    
    $lunar_month_and_samvat_section_color = get_option('daily_panchang_settings_lunar_month_and_samvat_btn_color_field');
    $lunar_month_and_samvat_label_color = get_option('daily_panchang_settings_lunar_month_and_samvat_label_color_field');
    
    
    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'lunar_month_and_samvat_section_color' => $lunar_month_and_samvat_section_color,
        'lunar_month_and_samvat_label_color' => $lunar_month_and_samvat_label_color,
        
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-samvat-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-samvat" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-samvat" value="">
                                                        <span id="dapi-wdate-samvat-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-samvat" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-samvat" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-samvat" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">


                                        <div class="dapi-ac-bg mx-auto" id="dapilunarsamvat">
                                            <button class="dapi-accordion dapiac3" dapiac="dapiac3">Lunar Month and Samvat</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac3">
                                            
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapSamvat() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-samvat");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-samvat").value = place.formatted_address;
                    displayLocationElevationSamvat(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationSamvat(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_month_samvat', 'dhat_daily_panchang_shortcode_month_samvat');

function dhat_daily_panchang_rashi_nakshatra_shortcode($atts)
{

    wp_enqueue_style('myplugin-dp-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-rashi-nakshatra-script', DHAT_PLUGIN_URL . 'public/js/public-dp-rashi-nakshatra.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-rashi-nakshatra-style', DHAT_PLUGIN_URL . 'public/css/public-dp-rashi-nakshatra.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    
    $rashi_and_nakshatra_section_color = get_option('daily_panchang_settings_rashi_and_nakshatra_btn_color_field');
    $rashi_and_nakshatra_label_color = get_option('daily_panchang_settings_rashi_and_nakshatra_label_color_field');
    
    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        
        'rashi_and_nakshatra_section_color' => $rashi_and_nakshatra_section_color,
        'rashi_and_nakshatra_label_color' => $rashi_and_nakshatra_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        
    );

    wp_localize_script('myplugin-dp-rashi-nakshatra-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-nakshatra" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-nakshatra" value="">
                                                        <span id="dapi-wdate-nakshatra-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-nakshatra" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-nakshatra" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-nakshatra" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">


                                        <div class="dapi-ac-bg mx-auto" id="dapirashinakshatra">
                                            <button class="dapi-accordion dapiac4" dapiac="dapiac4">Rashi and Nakshatra</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac4">

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapNakshatra() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-nakshatra");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-nakshatra").value = place.formatted_address;
                    displayLocationElevationNakshatra(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationNakshatra(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_rashi_nakshatra', 'dhat_daily_panchang_rashi_nakshatra_shortcode');

function dhat_daily_panchang_ritu_ayana_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-ritu-ayana-script', DHAT_PLUGIN_URL . 'public/js/public-dp-ritu-ayana.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-ritu-ayana-style', DHAT_PLUGIN_URL . 'public/css/public-dp-ritu-ayana.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');

    $ritu_and_ayana_section_color = get_option('daily_panchang_settings_ritu_and_ayana_btn_color_field');
    $ritu_and_ayana_label_color = get_option('daily_panchang_settings_ritu_and_ayana_label_color_field');
    
    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        
        'ritu_and_ayana_section_color' => $ritu_and_ayana_section_color,
        'ritu_and_ayana_label_color' => $ritu_and_ayana_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-ritu-ayana-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-ayana" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-ritu-ayana" value="">
                                                        <span id="dapi-wdate-ritu-ayana-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-ritu-ayana" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-ritu-ayana" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-ritu-ayana" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">


                                        <div class="dapi-ac-bg mx-auto" id="dapirituanaya">
                                            <button class="dapi-accordion dapiac5" dapiac="dapiac5">Ritu and Ayana</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac5">

                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapAyana() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-ayana");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-ayana").value = place.formatted_address;
                    displayLocationElevationAyana(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationAyana(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_ritu_ayana', 'dhat_daily_panchang_ritu_ayana_shortcode');

function dhat_daily_panchang_auspicious_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-auspicious-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-auspicious-script', DHAT_PLUGIN_URL . 'public/js/public-dp-auspicious.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-auspicious-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-auspicious-style', DHAT_PLUGIN_URL . 'public/css/public-dp-auspicious.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    
    $auspi_timings_section_color = get_option('daily_panchang_settings_auspi_timings_btn_color_field');
    $auspi_timings_label_color = get_option('daily_panchang_settings_auspi_timings_label_color_field');
    
    
    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'auspi_timings_section_color' => $auspi_timings_section_color,
        'auspi_timings_label_color' => $auspi_timings_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-auspicious-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-auspi" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-auspicious" value="">
                                                        <span id="dapi-wdate-auspicious-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-auspicious" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-auspicious" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-auspicious" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                        <div class="dapi-ac-bg mx-auto" id="dapiauspitimings">
                                            <button class="dapi-accordion dapiac6" dapiac="dapiac6">Auspicious Timings</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac6">

                                            </div>
                                        </div>

                                        
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapAuspi() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-auspi");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-auspi").value = place.formatted_address;
                    displayLocationElevationAuspi(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationAuspi(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_auspicious_panchang', 'dhat_daily_panchang_auspicious_shortcode');

function dhat_daily_panchang_inauspicious_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-inauspicious-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-inauspicious-script', DHAT_PLUGIN_URL . 'public/js/public-dp-inauspicious.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-inauspicious-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-inauspicious-style', DHAT_PLUGIN_URL . 'public/css/public-dp-inauspicious.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    
    $in_auspi_timings_section_color = get_option('daily_panchang_settings_in_auspi_timings_btn_color_field');
    $in_auspi_timings_label_color = get_option('daily_panchang_settings_in_auspi_timings_label_color_field');

    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'in_auspi_timings_section_color' => $in_auspi_timings_section_color,
        'in_auspi_timings_label_color' => $in_auspi_timings_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-inauspicious-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-inauspicious" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-in-auspicious" value="">
                                                        <span id="dapi-wdate-in-auspicious-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-in-auspicious" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-in-auspicious" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-in-auspicious" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                        
                                        <div class="dapi-ac-bg mx-auto" id="dapiinauspitimings">
                                            <button class="dapi-accordion dapiac7" dapiac="dapiac7">Inauspicious Timings</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac7">

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapInaus() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-inauspicious");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-inauspicious").value = place.formatted_address;
                    displayLocationElevationInaus(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationInaus(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_inauspicious', 'dhat_daily_panchang_inauspicious_shortcode');

function dhat_daily_panchang_nivas_shool_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-nivas-shool-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-nivas-shool-script', DHAT_PLUGIN_URL . 'public/js/public-dp-nivas-shool.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-nivas-shool-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-nivas-shool-style', DHAT_PLUGIN_URL . 'public/css/public-dp-nivas-shool.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    
    $nivas_and_shool_section_color = get_option('daily_panchang_settings_nivas_and_shool_btn_color_field');
    $nivas_and_shool_label_color = get_option('daily_panchang_settings_nivas_and_shool_label_color_field');

    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'nivas_and_shool_section_color' => $nivas_and_shool_section_color,
        'nivas_and_shool_label_color' => $nivas_and_shool_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-nivas-shool-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-shool" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-nivas" value="">
                                                        <span id="dapi-wdate-nivas-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-nivas" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-nivas" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-nivas" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                        <div class="dapi-ac-bg mx-auto" id="dapinivasshool">
                                            <button class="dapi-accordion dapiac8" dapiac="dapiac8">Nivas and Shool</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac8">

                                            </div>
                                            
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapShool() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-shool");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-shool").value = place.formatted_address;
                    displayLocationElevationShool(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationShool(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_nivas_shool', 'dhat_daily_panchang_nivas_shool_shortcode');

function dhat_daily_panchang_calendars_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-calendar-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-calendar-script', DHAT_PLUGIN_URL . 'public/js/public-dp-calendar.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-calendar-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-calendar-style', DHAT_PLUGIN_URL . 'public/css/public-dp-calendar.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    
    $other_calendar_and_epoch_section_color = get_option('daily_panchang_settings_other_calendar_and_epoch_btn_color_field');
    $other_calendar_and_epoch_label_color = get_option('daily_panchang_settings_other_calendar_and_epoch_label_color_field');

    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'other_calendar_and_epoch_section_color' => $other_calendar_and_epoch_section_color,
        'other_calendar_and_epoch_label_color' => $other_calendar_and_epoch_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-calendar-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-epoch" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-epoch" value="">
                                                        <span id="dapi-wdate-epoch-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-epoch" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-epoch" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-epoch" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                        <div class="dapi-ac-bg mx-auto" id="dapicalendarepoch">
                                            <button class="dapi-accordion dapiac10" dapiac="dapiac10">Other Calendars and Epoch</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac10">

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapEpoch() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-epoch");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-epoch").value = place.formatted_address;
                    displayLocationElevationEpoch(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationEpoch(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_other_calendars_epoch', 'dhat_daily_panchang_calendars_shortcode');

function dhat_daily_panchang_chandrabalam_tarabalam_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-chandrabalam-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-chandrabalam-script', DHAT_PLUGIN_URL . 'public/js/public-dp-chandrabalam.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-chandrabalam-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-chandrabalam-style', DHAT_PLUGIN_URL . 'public/css/public-dp-chandrabalam.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    
    $chandra_and_tara_section_color = get_option('daily_panchang_settings_chandra_and_tara_btn_color_field');
    $chandra_and_tara_label_color = get_option('daily_panchang_settings_chandra_and_tara_label_color_field');
    
    $timezone = '5.5';

    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        
        'chandra_and_tara_section_color' => $chandra_and_tara_section_color,
        'chandra_and_tara_label_color' => $chandra_and_tara_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-chandrabalam-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-chandra" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-chandra" value="">
                                                        <span id="dapi-wdate-chandra-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-chandra" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-chandra" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-chandra" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                       
                                        <div class="dapi-ac-bg mx-auto" id="dapichandratara">
                                            <button class="dapi-accordion dapiac9" dapiac="dapiac9">Chandrabalam & Tarabalam</button>
                                            <div class="dapi-panel dapi-active clrd" id="dapiac9">

                                            </div>
                                        </div>

                                        
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapChandra() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-chandra");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-chandra").value = place.formatted_address;
                    displayLocationElevationChandra(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationChandra(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_chandrabalam_tarabalam', 'dhat_daily_panchang_chandrabalam_tarabalam_shortcode');

function dhat_daily_panchang_panchaka_rahita_muhurta_udaya_lagna_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-dp-udaya-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-dp-udaya-script', DHAT_PLUGIN_URL . 'public/js/public-dp-udaya.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-dp-udaya-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-dp-udaya-style', DHAT_PLUGIN_URL . 'public/css/public-dp-udaya.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('daily_panchang_settings_timezone_field'));
    $background_color = get_option('daily_panchang_settings_background_color_field');
    $panchak_and_udaya_section_color = get_option('daily_panchang_settings_panchak_and_udaya_btn_color_field');
    $panchak_and_udaya_label_color = get_option('daily_panchang_settings_panchak_and_udaya_label_color_field');

    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'panchak_and_udaya_section_color' => $panchak_and_udaya_section_color,
        'panchak_and_udaya_label_color' => $panchak_and_udaya_label_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-dp-udaya-script', 'dp_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="">

                <div class="divine-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="panchang-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-panchang">

                            <div class="divine-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row">
                                        <div class="dapi-ac-bg mx-auto">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="divine-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-location-udaya" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-udaya" value="">
                                                        <span id="dapi-wdate-udaya-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-udaya" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-udaya" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-udaya" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="divine-row" id="dapi">

                                       
                                        <div class="dapi-ac-bg mx-auto" id="panchakaudaya">
                                            <button class="dapi-accordion dapiac11" dapiac="dapiac11">Panchaka Rahita Muhurta and Udaya Lagna</button>
                                            <div class="dapi-panel dapi-active" id="dapiac11">
                                                <div class="divine-row dapi-row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 dapi-col clrd" id="dapipanchrahita">

                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 dapi-col clrd" id="dapiudayalgn">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
            </div>
            <script>
            function initMapUdaya() {
                const elevator = new google.maps.ElevationService();
                var input = document.getElementById("dapi-location-udaya");
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    var place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-location-udaya").value = place.formatted_address;
                    displayLocationElevationUdaya(place.geometry.location, elevator);
                });
            }
            function displayLocationElevationUdaya(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_daily_panchang_panchaka_rahita_muhurta_udaya_lagna', 'dhat_daily_panchang_panchaka_rahita_muhurta_udaya_lagna_shortcode');

function dhat_choghadiya_shortcode($atts)
{

    // wp_enqueue_style( 'myplugin-dp-style', DHAT_PLUGIN_URL . 'public/css/public-dp.css', '', rand());
    wp_enqueue_style('myplugin-choghadiya-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-choghadiya-script', DHAT_PLUGIN_URL . 'public/js/public-choghadiya.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-choghadiya-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-choghadiya-style', DHAT_PLUGIN_URL . 'public/css/public-choghadiya.css', '', rand());

    $timezones = unserialize(TIMEZONES);

    $api_key = get_option('divine_settings_input_field');
    $access_token = get_option('divine_settings_access_token_field');
    $timezone_id = intval(get_option('choghadiya_settings_timezone_field'));
    $background_color = get_option('choghadiya_settings_background_color_field');
    $good_color = get_option('choghadiya_settings_good_color_field');
    $bad_color = get_option('choghadiya_settings_bad_color_field');
    $neutral_color = get_option('choghadiya_settings_neutral_color_field');
    $title_color = get_option('choghadiya_settings_title_color_field');
    $timings_color = get_option('choghadiya_settings_timings_color_field');
    $button_color = get_option('choghadiya_settings_button_color_field');
    $button_text_color = get_option('choghadiya_settings_button_text_color_field');
    $day_choghadiya_bg_color = get_option('choghadiya_settings_day_choghadiya_background_color_field');
    $day_choghadiya_text_color = get_option('choghadiya_settings_day_choghadiya_text_color_field');
    $night_choghadiya_bg_color = get_option('choghadiya_settings_night_choghadiya_background_color_field');
    $night_choghadiya_text_color = get_option('choghadiya_settings_night_choghadiya_text_color_field');

    $timezone = '5.5';
    $lat = '28.6139';
    $lon = '77.2090';

    $gmt_sign = (($timezone < 0) ? '-' : '');
    $timezone = abs($timezone);
    $hour = floor($timezone);

    $fraction = ($timezone - $hour) * 10;
    if ($fraction == 0) {
        $minutes = 0;
    } else if ($fraction < 10) {
        $fraction = $fraction * 10;
        $minutes = intval(($fraction * 60) / 100);
    } else if ($fraction >= 100) {
        $fraction = substr($fraction, 0, 2);
        $minutes = intval((intval($fraction) * 60) / 100);
    }

    $timezone_string = $gmt_sign . ' ' . $hour . ' hours ' . $minutes . ' minutes';
    $reference_datetime = gmdate('Y-m-d H:i:s', strtotime($timezone_string));
    $today = gmdate('Y-m-d', strtotime($timezone_string));

    $scriptData = array(
        'api_key' => base64_encode($api_key),
        'access_token' => base64_encode($access_token),
        'timezone' => $gmt_sign . $timezone,
        'today' => $today,
        'lat' => $lat,
        'lon' => $lon,
        'background_color' => $background_color,
        'good_color' => $good_color,
        'bad_color' => $bad_color,
        'neutral_color' => $neutral_color,
        'title_color' => $title_color,
        'timings_color' => $timings_color,
        'button_color' => $button_color,
        'button_text_color' => $button_text_color,
        'day_choghadiya_bg_color' => $day_choghadiya_bg_color,
        'day_choghadiya_text_color' => $day_choghadiya_text_color,
        'night_choghadiya_bg_color' => $night_choghadiya_bg_color,
        'night_choghadiya_text_color' => $night_choghadiya_text_color,
        'plgn_base_url' => DHAT_PLUGIN_URL,
        // 'color_text' => $color_text,
        // 'font_size' => $font_size,
        // 'color_theme' => $color_theme,
    );

    wp_localize_script('myplugin-choghadiya-script', 'choghadiya_options', $scriptData);

    //w3-card-0 w3-padding w3-round-large w3-margin-bottom
    $html = '<div class="secchgg">

                <div class="dapi-row">

                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                        <div class="divine_auth_domain_response" id="choghadiya-auth">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="dapi-sec-choghadiya">
                            <div class="dapi-row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto m-5 p-0">

                                    <div class="dapi-row dapi-nm-row">
                                        <div class="dapi-ac-bg mx-auto mb-">
                                            <form method="post" action="javascript:void(0);">
                                                <div class="dapi-row dapi-mb">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-location">
                                                        <input type="text" class="dapi-form-control" id="dapi-lcn" placeholder="Location" value="New Delhi, India">
                                                        <span id="dapi-location-error" class="dapi-error">Please enter valid location</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <input type="date" class="dapi-form-control" id="wdate-choghadiya" value="">
                                                        <span id="dapi-wdate-choghadiya-error" class="dapi-error">Please enter valid date</span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 dapi-text-right">
                                                        <button class="dapi-btn dapi-dbtns-choghadiya" dtyp="prev">Prev</button>
                                                        <button class="dapi-btn dapi-dbtns-choghadiya" dtyp="current">Today</button>
                                                        <button class="dapi-btn dapi-dbtns-choghadiya" dtyp="next">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                                        
                            </div>
                            <div class="dapi-row dapi-nm-row">
    
                                <div class="dapi-w97">

                                    <div class="dapi-row dapi-nm-row">
    
                                        <div class="dapi-choghadiya-box">
        
                                            <div class="dapi-row dapi-nm-row" id="choghadiya_dtls">

                                                

                                            </div>

                                            <!-- <table>

                                            </table> -->
        
                                        </div>

                                    </div>
    
                                </div>
    
                            </div>
    
                        </div>
                        
                    </div>

                </div>
                
            </div>
            <script>
            function initMapChoghadiya() {
                const chg_elevator = new google.maps.ElevationService();
                let input = document.getElementById("dapi-lcn");
                let autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener("place_changed", function() {
                    let place = autocomplete.getPlace();
                    window.timezone = (place.utc_offset_minutes / 60);
                    document.getElementById("dapi-lcn").value = place.formatted_address;
                    displayLocationElevationChoghadiya(place.geometry.location, chg_elevator);
                });
            }
            function displayLocationElevationChoghadiya(location,elevator){
                elevator.getElevationForLocations({
                    locations: [location],
                }).then(({ results }) => {
                    window.lat = results[0].location.lat();
                    window.lon = results[0].location.lng();
                }).catch((e) =>
                    console.log("Elevation service failed due to: " + e)
                );
            }</script>';


    return $html;
}
add_shortcode('divine_choghadiya', 'dhat_choghadiya_shortcode');

function get_horoscope_theme_1_html($today, $yesterday, $tomorrow, $sign, $default_sign) {

    $buttons_with_icons = get_option('horoscope_buttons_with_icon_field');
    
    // $personal_icon = ($buttons_with_icons == 'on') ? '<object class="dapi-svg-icon" type="image/svg+xml" fill="#fff" data="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/personal.svg"></object>' : '';
    // $emotions_icon = ($buttons_with_icons == 'on') ? '<object class="dapi-svg-icon" type="image/svg+xml" data="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/emotions.svg"></object>' : '';
    // $health_icon = ($buttons_with_icons == 'on') ? '<object class="dapi-svg-icon" type="image/svg+xml" data="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/health.svg"></object>' : '';
    // $profession_icon = ($buttons_with_icons == 'on') ? '<object class="dapi-svg-icon" type="image/svg+xml" data="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/profession.svg"></object>' : '';
    // $travel_icon = ($buttons_with_icons == 'on') ? '<object class="dapi-svg-icon" type="image/svg+xml" data="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/travel.svg"></object>' : '';
    // $luck_icon = ($buttons_with_icons == 'on') ? '<object class="dapi-svg-icon" type="image/svg+xml" data="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/luck.svg"></object>' : '';

    // $personal_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/personal.svg"/>' : '';
    // $emotions_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/emotions.svg"/>' : '';
    // $health_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/health.svg"/>' : '';
    // $profession_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/profession.svg"/>' : '';
    // $travel_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/travel.svg"/>' : '';
    // $luck_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/luck.svg"/>' : '';

    // $personal_icon = ($buttons_with_icons == 'on') ? '<i class="divine__dh__icon__comment"></i>' : '';
    // $emotions_icon = ($buttons_with_icons == 'on') ? '<i class="divine__dh__icon__comment"></i>' : '';
    // $health_icon = ($buttons_with_icons == 'on') ? '<i class="divine__dh__icon__comment"></i>' : '';
    // $profession_icon = ($buttons_with_icons == 'on') ? '<i class="divine__dh__icon__comment"></i>' : '';
    // $travel_icon = ($buttons_with_icons == 'on') ? '<i class="divine__dh__icon__comment"></i>' : '';
    // $luck_icon = ($buttons_with_icons == 'on') ? '<i class="divine__dh__icon__comment"></i>' : '';
    
    $personal_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="e539dac21a"><path d="M 38 14 L 63.75 14 L 63.75 75 L 38 75 Z M 38 14 " clip-rule="nonzero"/></clipPath></defs><path fill="#040606" d="M 28.945312 15.511719 C 29.53125 15.28125 29.765625 14.578125 29.53125 13.992188 C 29.300781 13.410156 28.589844 13.179688 28.003906 13.410156 C 15.074219 19.011719 11.671875 29.867188 17.898438 45.734375 C 18.132812 46.199219 18.367188 46.785156 18.367188 46.902344 C 18.367188 47.023438 18.484375 47.136719 18.484375 47.253906 C 19.660156 49.355469 18.839844 58.335938 18.132812 63.59375 C 18.011719 64.175781 18.484375 64.871094 19.074219 64.871094 C 19.660156 64.992188 20.367188 64.519531 20.367188 63.9375 C 20.714844 61.605469 22.363281 49.9375 20.601562 46.320312 C 20.480469 45.96875 20.367188 45.617188 20.015625 44.800781 C 18.011719 39.433594 11.550781 23.09375 28.945312 15.511719 " fill-opacity="1" fill-rule="nonzero"/><g clip-path="url(#e539dac21a)"><path fill="#040606" d="M 59.503906 41.996094 C 58.917969 41.535156 58.796875 40.71875 59.152344 39.546875 C 60.09375 36.398438 57.742188 18.777344 50.21875 14.226562 C 49.632812 13.875 48.925781 14.105469 48.570312 14.578125 C 48.21875 15.160156 48.457031 15.863281 48.925781 16.207031 C 55.273438 19.945312 57.621094 36.164062 56.914062 38.847656 C 56.328125 40.832031 56.679688 42.46875 57.742188 43.636719 C 58.675781 45.152344 61.613281 47.949219 61.378906 49.234375 C 61.265625 49.707031 60.09375 50.171875 59.738281 50.285156 C 59.03125 50.171875 58.445312 50.753906 58.445312 51.457031 L 58.445312 54.484375 L 57.742188 55.1875 C 57.390625 55.539062 57.269531 56.121094 57.390625 56.59375 L 58.328125 58.457031 C 58.917969 59.621094 57.503906 61.492188 56.679688 62.539062 C 55.273438 64.175781 52.335938 64.058594 45.511719 62.074219 C 44.339844 61.722656 43.164062 62.308594 42.695312 63.355469 L 38.109375 73.390625 C 37.878906 73.972656 38.109375 74.675781 38.699219 74.90625 C 39.285156 75.144531 39.992188 74.90625 40.226562 74.332031 L 44.8125 64.058594 C 51.75 66.039062 55.972656 66.621094 58.445312 63.824219 C 60.679688 61.253906 61.378906 59.039062 60.445312 57.171875 L 59.972656 56.121094 L 60.445312 55.652344 C 60.679688 55.421875 60.914062 55.074219 60.914062 54.71875 L 60.914062 52.039062 C 62.320312 51.449219 63.503906 50.753906 63.738281 49.355469 C 64.085938 47.023438 59.617188 42.117188 59.503906 41.996094 " fill-opacity="1" fill-rule="nonzero"/></g><path fill="#040606" d="M 48.925781 26.59375 C 48.925781 29.628906 46.6875 32.203125 43.75 32.785156 C 43.871094 29.867188 45.988281 27.296875 48.925781 26.59375 Z M 25.535156 24.964844 C 27.882812 25.082031 30.941406 26.128906 31.648438 29.980469 C 27.769531 30.101562 26.121094 27.296875 25.535156 24.964844 Z M 24.359375 6.410156 C 27.769531 4.421875 30.472656 6.058594 32.238281 7.691406 C 30 8.742188 26.941406 9.328125 24.359375 6.410156 Z M 48.691406 2.792969 C 48.804688 6.644531 45.988281 8.273438 43.636719 8.855469 C 43.75 6.523438 44.8125 3.488281 48.691406 2.792969 Z M 39.050781 53.902344 L 42.464844 45.035156 C 43.402344 42.699219 43.050781 40.136719 41.753906 38.148438 C 42.695312 37.210938 43.285156 35.933594 43.636719 35.117188 C 52.214844 34.0625 51.152344 25.195312 51.273438 25.082031 C 51.152344 24.492188 50.6875 23.917969 49.980469 24.027344 C 49.390625 24.378906 42.578125 23.09375 41.636719 33.832031 C 41.289062 34.765625 40.695312 35.8125 40.226562 36.398438 C 39.992188 36.164062 39.757812 36.046875 39.519531 35.8125 C 34.230469 32.546875 39.640625 25.664062 41.523438 22.398438 C 43.636719 18.660156 41.753906 15.511719 41.523438 14.695312 C 42.578125 13.761719 43.164062 12.242188 43.519531 11.191406 C 52.09375 9.441406 51.039062 1.386719 51.039062 1.273438 C 51.039062 0.921875 50.808594 0.691406 50.574219 0.457031 C 50.21875 0.457031 49.980469 0.339844 49.632812 0.339844 C 49.511719 0.457031 40.933594 0.21875 41.289062 10.140625 C 41.167969 10.84375 40.933594 11.429688 40.695312 12.011719 L 37.878906 2.089844 C 37.644531 1.507812 36.9375 1.15625 36.347656 1.273438 C 35.761719 1.507812 35.40625 2.089844 35.527344 2.792969 L 37.054688 8.042969 C 36.347656 7.921875 35.527344 7.457031 34.820312 7.105469 C 28.945312 -0.0117188 22.128906 5.125 22.011719 5.125 C 21.421875 5.476562 21.300781 6.171875 21.777344 6.753906 C 22.242188 7.226562 26.121094 13.761719 34.117188 9.328125 C 34.941406 9.792969 36.46875 10.492188 37.757812 10.492188 C 39.757812 18.078125 40.8125 18.890625 39.40625 21.34375 C 37.996094 22.628906 34.941406 28 34.820312 31.851562 C 34.585938 31.5 34.351562 31.148438 34.117188 30.796875 C 34 30.683594 34 22.398438 24.125 22.75 C 23.773438 22.75 23.417969 22.863281 23.183594 23.214844 C 22.832031 23.566406 22.953125 23.917969 22.953125 24.261719 C 23.773438 29.515625 27.0625 32.785156 32.355469 32.433594 C 32.945312 33.367188 34.117188 35 35.648438 35.46875 C 37.054688 38.265625 42.230469 39.433594 40.347656 44.449219 L 36.9375 53.320312 C 36.703125 53.910156 37.054688 54.605469 37.644531 54.835938 C 38.109375 54.835938 38.816406 54.484375 39.050781 53.902344 " fill-opacity="1" fill-rule="nonzero"/></svg>' : '';
    $emotions_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="4b4713d0cc"><path d="M 0 4.265625 L 75 4.265625 L 75 71 L 0 71 Z M 0 4.265625 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#4b4713d0cc)"><path fill="#000000" d="M 37.5 71 L 36.703125 70.457031 C 36.613281 70.394531 27.480469 64.128906 18.480469 55.46875 C 13.171875 50.347656 8.925781 45.40625 5.863281 40.765625 C 1.980469 34.832031 0 29.332031 0 24.453125 C 0 13.335938 9.015625 4.28125 20.085938 4.28125 C 24.195312 4.28125 28.171875 5.546875 31.558594 7.957031 C 34.019531 9.707031 36.03125 11.933594 37.5 14.496094 C 38.96875 11.917969 40.980469 9.691406 43.441406 7.957031 C 46.828125 5.546875 50.804688 4.28125 54.914062 4.28125 C 65.984375 4.28125 75 13.335938 75 24.453125 L 75 24.46875 C 74.953125 29.316406 72.960938 34.769531 69.058594 40.691406 C 66 45.332031 61.769531 50.269531 56.460938 55.40625 C 47.476562 64.097656 38.386719 70.394531 38.296875 70.457031 Z M 20.085938 7.097656 C 10.558594 7.097656 2.804688 14.886719 2.804688 24.453125 C 2.804688 28.777344 4.621094 33.730469 8.203125 39.183594 C 11.128906 43.644531 15.238281 48.433594 20.398438 53.40625 C 27.703125 60.4375 35.113281 65.878906 37.5 67.5625 C 39.886719 65.863281 47.25 60.394531 54.539062 53.34375 C 59.683594 48.359375 63.78125 43.582031 66.71875 39.125 C 70.304688 33.671875 72.148438 28.746094 72.179688 24.453125 C 72.179688 14.886719 64.425781 7.113281 54.898438 7.113281 C 47.835938 7.113281 41.371094 11.601562 38.789062 18.292969 L 37.484375 21.695312 L 36.195312 18.292969 C 33.613281 11.601562 27.148438 7.097656 20.085938 7.097656 Z M 20.085938 7.097656 " fill-opacity="1" fill-rule="nonzero"/></g></svg>' : '';
    $health_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><path fill="#000000" d="M 75 37.5 C 75 58.296875 58.296875 75 37.5 75 C 16.703125 75 0 58.296875 0 37.5 C 0 16.703125 16.703125 0 37.5 0 C 58.296875 0 75 16.703125 75 37.5 Z M 61.363281 28.808594 L 46.191406 28.808594 L 46.191406 13.636719 L 28.636719 13.636719 L 28.636719 28.808594 L 13.464844 28.808594 L 13.464844 46.363281 L 28.636719 46.363281 L 28.636719 61.363281 L 46.191406 61.363281 L 46.191406 46.191406 L 61.363281 46.191406 Z M 61.363281 28.808594 " fill-opacity="1" fill-rule="nonzero"/></svg>' : '';
    $profession_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><path fill="#000000" d="M 72.65625 14.0625 L 58.59375 14.0625 L 58.59375 7.03125 C 58.59375 3.15625 55.4375 0 51.5625 0 L 23.4375 0 C 19.5625 0 16.40625 3.15625 16.40625 7.03125 L 16.40625 14.0625 L 2.34375 14.0625 C 1.050781 14.0625 0 15.109375 0 16.40625 L 0 72.65625 C 0 73.953125 1.050781 75 2.34375 75 L 72.65625 75 C 73.953125 75 75 73.953125 75 72.65625 L 75 16.40625 C 75 15.109375 73.953125 14.0625 72.65625 14.0625 Z M 21.09375 7.03125 C 21.09375 5.738281 22.144531 4.6875 23.4375 4.6875 L 51.5625 4.6875 C 52.855469 4.6875 53.90625 5.738281 53.90625 7.03125 L 53.90625 14.0625 L 21.09375 14.0625 Z M 4.6875 18.75 L 70.3125 18.75 L 70.3125 30.46875 C 70.3125 34.34375 67.15625 37.5 63.28125 37.5 L 44.53125 37.5 L 44.53125 35.15625 C 44.53125 31.28125 41.375 28.125 37.5 28.125 C 33.625 28.125 30.46875 31.28125 30.46875 35.15625 L 30.46875 37.5 L 11.71875 37.5 C 7.84375 37.5 4.6875 34.34375 4.6875 30.46875 Z M 39.84375 37.5 L 35.15625 37.5 L 35.15625 35.15625 C 35.15625 33.863281 36.207031 32.8125 37.5 32.8125 C 38.792969 32.8125 39.84375 33.863281 39.84375 35.15625 Z M 35.15625 42.1875 L 39.84375 42.1875 L 39.84375 44.53125 C 39.84375 45.824219 38.792969 46.875 37.5 46.875 C 36.207031 46.875 35.15625 45.824219 35.15625 44.53125 Z M 4.6875 70.3125 L 4.6875 39.78125 C 6.652344 41.269531 9.070312 42.1875 11.71875 42.1875 L 30.46875 42.1875 L 30.46875 44.53125 C 30.46875 48.40625 33.625 51.5625 37.5 51.5625 C 41.375 51.5625 44.53125 48.40625 44.53125 44.53125 L 44.53125 42.1875 L 63.28125 42.1875 C 65.929688 42.1875 68.347656 41.269531 70.3125 39.78125 L 70.3125 70.3125 Z M 4.6875 70.3125 " fill-opacity="1" fill-rule="nonzero"/></svg>' : '';
    $travel_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="2e1a38b997"><path d="M 0 0 L 75 0 L 75 74.25 L 0 74.25 Z M 0 0 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#2e1a38b997)"><path fill="#000000" d="M 74.453125 49.082031 L 69.289062 43.941406 L 69.285156 43.945312 C 69.066406 43.730469 68.773438 43.59375 68.445312 43.585938 L 55.851562 43.277344 C 55.851562 43.277344 55.851562 43.277344 55.847656 43.277344 C 55.246094 42.578125 54.609375 41.886719 53.917969 41.203125 L 47.070312 34.382812 L 72.597656 21.269531 C 72.710938 21.214844 72.816406 21.136719 72.910156 21.042969 C 73.386719 20.558594 73.382812 19.785156 72.894531 19.308594 L 66.09375 12.648438 C 65.84375 12.367188 65.46875 12.203125 65.0625 12.238281 L 59.695312 12.707031 L 55.832031 8.859375 C 55.019531 8.054688 53.949219 7.648438 52.882812 7.648438 C 51.8125 7.648438 50.742188 8.054688 49.933594 8.859375 C 49.121094 9.667969 48.714844 10.734375 48.714844 11.796875 C 48.714844 12.425781 48.875 13.046875 49.160156 13.625 L 45.3125 13.960938 L 41.445312 10.113281 C 40.632812 9.308594 39.5625 8.902344 38.496094 8.902344 C 37.429688 8.902344 36.363281 9.308594 35.550781 10.113281 L 35.472656 10.195312 C 34.710938 10.992188 34.328125 12.023438 34.328125 13.050781 C 34.328125 13.679688 34.492188 14.300781 34.777344 14.878906 L 28.136719 15.457031 C 28.117188 15.460938 28.101562 15.472656 28.078125 15.472656 L 20.972656 8.402344 C 18.207031 5.648438 15.59375 3.4375 12.554688 2.019531 C 9.46875 0.582031 6.023438 -0.00390625 1.660156 0.527344 C 1.078125 0.597656 0.640625 1.0625 0.582031 1.621094 C 0.0507812 5.953125 0.644531 9.378906 2.085938 12.441406 C 3.507812 15.464844 5.730469 18.070312 8.496094 20.820312 L 15.535156 27.828125 C 15.511719 27.90625 15.472656 27.980469 15.464844 28.066406 L 14.882812 34.671875 C 14.304688 34.390625 13.675781 34.230469 13.042969 34.230469 C 11.976562 34.230469 10.90625 34.632812 10.097656 35.441406 L 10.097656 35.449219 C 9.285156 36.257812 8.878906 37.320312 8.878906 38.378906 C 8.878906 39.410156 9.257812 40.4375 10.019531 41.238281 L 10.097656 41.316406 L 13.960938 45.164062 L 13.625 48.992188 C 13.042969 48.710938 12.417969 48.550781 11.785156 48.550781 C 10.71875 48.550781 9.648438 48.957031 8.835938 49.761719 C 8.023438 50.570312 7.617188 51.636719 7.617188 52.699219 C 7.617188 53.761719 8.023438 54.828125 8.835938 55.632812 L 12.699219 59.480469 L 12.230469 64.828125 C 12.195312 65.226562 12.359375 65.605469 12.644531 65.851562 L 19.332031 72.625 C 19.808594 73.105469 20.589844 73.113281 21.074219 72.640625 C 21.167969 72.546875 21.246094 72.441406 21.304688 72.328125 L 34.554688 46.765625 L 41.441406 53.621094 C 42.230469 54.40625 43.03125 55.117188 43.835938 55.785156 L 44.136719 67.777344 C 44.144531 68.105469 44.28125 68.402344 44.496094 68.613281 L 44.492188 68.617188 L 49.65625 73.757812 C 50.140625 74.238281 50.921875 74.238281 51.398438 73.757812 C 51.605469 73.550781 51.722656 73.292969 51.753906 73.027344 L 54.257812 60.636719 C 56 60.871094 57.863281 60.878906 59.886719 60.632812 C 60.46875 60.5625 60.90625 60.097656 60.964844 59.539062 C 61.21875 57.441406 61.195312 55.523438 60.929688 53.730469 L 73.710938 51.167969 C 73.980469 51.136719 74.242188 51.019531 74.445312 50.816406 C 74.933594 50.335938 74.933594 49.558594 74.453125 49.082031 Z M 52.050781 13.371094 L 51.675781 12.996094 C 51.347656 12.667969 51.179688 12.230469 51.179688 11.792969 C 51.179688 11.359375 51.347656 10.921875 51.675781 10.59375 C 52.003906 10.265625 52.445312 10.101562 52.882812 10.101562 C 53.320312 10.101562 53.753906 10.265625 54.085938 10.59375 L 56.488281 12.984375 L 52.335938 13.347656 Z M 37.664062 14.625 L 37.289062 14.25 C 36.960938 13.925781 36.792969 13.488281 36.792969 13.046875 C 36.792969 12.632812 36.945312 12.214844 37.242188 11.894531 L 37.289062 11.847656 C 37.617188 11.519531 38.054688 11.355469 38.496094 11.355469 C 38.933594 11.355469 39.371094 11.519531 39.699219 11.847656 L 42.101562 14.238281 L 38.027344 14.59375 Z M 37.308594 17.121094 L 44.949219 16.457031 C 44.949219 16.457031 44.949219 16.457031 44.953125 16.457031 L 51.695312 15.867188 L 59.335938 15.203125 L 64.714844 14.734375 L 69.964844 19.871094 L 45.246094 32.566406 L 30.34375 17.730469 Z M 11.792969 39.53125 C 11.496094 39.210938 11.347656 38.796875 11.347656 38.378906 C 11.347656 37.945312 11.511719 37.507812 11.839844 37.179688 C 12.171875 36.851562 12.609375 36.6875 13.046875 36.6875 C 13.484375 36.6875 13.921875 36.851562 14.253906 37.179688 L 14.632812 37.554688 L 14.480469 39.261719 L 14.242188 41.96875 Z M 10.582031 53.898438 C 10.253906 53.570312 10.089844 53.136719 10.089844 52.699219 C 10.089844 52.265625 10.253906 51.828125 10.582031 51.5 C 10.914062 51.171875 11.351562 51.007812 11.789062 51.007812 C 12.226562 51.007812 12.664062 51.171875 12.996094 51.5 L 13.375 51.875 L 13.175781 54.125 L 12.988281 56.289062 Z M 19.898438 69.703125 L 14.738281 64.480469 L 15.210938 59.125 L 15.457031 56.320312 L 16.46875 44.804688 L 16.492188 44.519531 L 17.765625 30.050781 L 32.730469 44.945312 Z M 49.78125 70.40625 L 46.585938 67.226562 L 46.34375 57.625 C 47.410156 58.3125 48.496094 58.929688 49.644531 59.40625 C 50.363281 59.703125 51.097656 59.949219 51.855469 60.15625 Z M 58.617188 58.292969 C 55.566406 58.539062 52.957031 58.117188 50.589844 57.140625 C 47.945312 56.050781 45.5625 54.246094 43.1875 51.882812 L 10.242188 19.085938 C 7.644531 16.503906 5.582031 14.097656 4.3125 11.402344 C 3.171875 8.980469 2.652344 6.257812 2.933594 2.863281 C 6.34375 2.582031 9.078125 3.101562 11.511719 4.234375 C 14.21875 5.496094 16.632812 7.554688 19.226562 10.136719 L 52.175781 42.933594 C 54.550781 45.296875 56.363281 47.671875 57.460938 50.304688 C 58.441406 52.660156 58.863281 55.257812 58.617188 58.292969 Z M 60.417969 51.335938 C 60.226562 50.664062 60 50.007812 59.734375 49.367188 C 59.210938 48.109375 58.523438 46.925781 57.742188 45.769531 L 67.886719 46.019531 L 71.085938 49.199219 Z M 60.417969 51.335938 " fill-opacity="1" fill-rule="nonzero"/></g></svg>' : '';
    $luck_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="46a84a3753"><path d="M 1 3.46875 L 70 3.46875 L 70 71.71875 L 1 71.71875 Z M 1 3.46875 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#46a84a3753)"><path fill="#000000" d="M 62.53125 29.578125 C 62.53125 29.578125 70.246094 17.066406 58.78125 13.390625 C 58.027344 13.148438 57.273438 13.035156 56.523438 13.035156 C 54.105469 13.035156 51.738281 14.210938 49.523438 16.027344 C 50.363281 12.363281 50.105469 8.949219 47.773438 6.535156 C 45.617188 4.300781 43.5 3.46875 41.546875 3.46875 C 35.921875 3.46875 31.644531 10.34375 31.644531 10.34375 C 31.644531 10.34375 27.535156 7.800781 23.339844 7.796875 C 20.226562 7.796875 17.0625 9.203125 15.503906 14.105469 C 14.480469 17.304688 15.757812 20.476562 18.128906 23.386719 C 16.914062 23.109375 15.722656 22.949219 14.589844 22.949219 C 12.320312 22.949219 10.273438 23.582031 8.667969 25.140625 C 0.015625 33.53125 12.464844 41.316406 12.464844 41.316406 C 12.464844 41.316406 4.75 53.828125 16.210938 57.503906 C 16.96875 57.746094 17.722656 57.859375 18.46875 57.859375 C 19.617188 57.859375 20.75 57.59375 21.863281 57.121094 C 20.898438 58.054688 19.902344 58.949219 18.875 59.800781 C 14.015625 63.816406 8.433594 66.894531 2.289062 68.949219 C 1.726562 69.136719 1.320312 69.667969 1.320312 70.296875 C 1.320312 71.082031 1.957031 71.71875 2.734375 71.71875 C 2.894531 71.71875 3.042969 71.695312 3.183594 71.644531 C 9.6875 69.472656 15.589844 66.210938 20.738281 61.945312 C 22.234375 60.699219 23.671875 59.371094 25.042969 57.960938 C 24.953125 60.417969 25.5625 62.640625 27.21875 64.359375 C 29.378906 66.59375 31.492188 67.425781 33.449219 67.425781 C 39.074219 67.425781 43.351562 60.546875 43.351562 60.546875 C 43.351562 60.546875 47.457031 63.097656 51.652344 63.097656 C 54.769531 63.097656 57.929688 61.691406 59.492188 56.792969 C 60.511719 53.589844 59.238281 50.417969 56.867188 47.503906 C 58.082031 47.785156 59.269531 47.945312 60.402344 47.945312 C 62.671875 47.945312 64.722656 47.308594 66.328125 45.753906 C 74.976562 37.363281 62.53125 29.578125 62.53125 29.578125 Z M 18.203125 14.96875 C 18.730469 13.308594 19.492188 12.125 20.460938 11.445312 C 21.234375 10.90625 22.175781 10.640625 23.339844 10.640625 C 26.605469 10.640625 30.035156 12.691406 30.15625 12.765625 L 32.546875 14.265625 L 34.050781 11.851562 C 34.058594 11.835938 34.976562 10.386719 36.457031 8.949219 C 37.699219 7.746094 39.585938 6.3125 41.546875 6.3125 C 42.9375 6.3125 44.308594 7.03125 45.738281 8.511719 C 46.996094 9.820312 47.394531 11.75 46.953125 14.410156 C 46.535156 16.949219 45.363281 19.992188 43.476562 23.453125 C 41.253906 27.519531 38.558594 31.191406 36.976562 33.222656 C 34.679688 32.113281 30.679688 30.042969 26.898438 27.394531 C 23.65625 25.128906 21.246094 22.917969 19.738281 20.824219 C 18.152344 18.621094 17.648438 16.707031 18.203125 14.96875 Z M 17.074219 54.796875 C 14.929688 54.105469 13.621094 53.0625 13.082031 51.605469 C 12.429688 49.847656 12.894531 47.648438 13.398438 46.109375 C 14.007812 44.269531 14.828125 42.890625 14.878906 42.808594 L 16.394531 40.40625 L 13.96875 38.90625 C 13.890625 38.855469 12.542969 37.984375 11.183594 36.601562 C 10.050781 35.449219 8.65625 33.683594 8.464844 31.820312 C 8.308594 30.273438 9.015625 28.757812 10.636719 27.1875 C 11.601562 26.25 12.898438 25.792969 14.589844 25.792969 C 16.941406 25.792969 19.921875 26.660156 23.371094 28.332031 C 26.882812 31.035156 30.824219 33.277344 33.699219 34.761719 C 34.296875 35.207031 34.828125 35.613281 35.277344 35.96875 C 35.03125 36.480469 34.734375 37.082031 34.398438 37.746094 C 32.476562 40.351562 29.9375 44.113281 27.984375 48.097656 C 24.503906 52.585938 21.1875 55.015625 18.46875 55.015625 C 17.996094 55.015625 17.539062 54.945312 17.074219 54.796875 Z M 55.257812 50.070312 C 56.84375 52.269531 57.34375 54.183594 56.789062 55.925781 C 56.261719 57.582031 55.503906 58.769531 54.53125 59.449219 C 53.761719 59.992188 52.820312 60.253906 51.652344 60.253906 C 48.390625 60.253906 44.96875 58.207031 44.839844 58.128906 L 42.445312 56.625 L 40.945312 59.042969 C 40.933594 59.058594 40.019531 60.507812 38.539062 61.941406 C 37.296875 63.144531 35.40625 64.582031 33.449219 64.582031 C 32.058594 64.582031 30.6875 63.859375 29.257812 62.382812 C 28 61.074219 27.597656 59.144531 28.039062 56.480469 C 28.460938 53.941406 29.632812 50.902344 31.519531 47.441406 C 33.742188 43.375 36.433594 39.703125 38.015625 37.671875 C 38.53125 37.917969 39.128906 38.214844 39.792969 38.554688 C 42.390625 40.480469 46.140625 43.03125 50.113281 44.984375 C 52.355469 46.734375 54.078125 48.4375 55.257812 50.070312 Z M 64.355469 43.707031 C 63.390625 44.644531 62.097656 45.101562 60.402344 45.101562 C 56.882812 45.101562 51.957031 43.160156 46.152344 39.484375 C 43.472656 37.785156 41.171875 36.066406 39.71875 34.925781 C 39.964844 34.410156 40.261719 33.808594 40.601562 33.144531 C 42.519531 30.535156 45.058594 26.777344 47.011719 22.796875 C 50.492188 18.308594 53.808594 15.878906 56.523438 15.878906 C 57 15.878906 57.457031 15.949219 57.917969 16.097656 C 60.066406 16.785156 61.375 17.828125 61.914062 19.289062 C 62.566406 21.042969 62.101562 23.246094 61.59375 24.785156 C 60.988281 26.625 60.164062 28.003906 60.117188 28.085938 L 58.617188 30.484375 L 61.03125 31.992188 C 61.042969 32 62.359375 32.835938 63.726562 34.203125 C 64.894531 35.375 66.328125 37.167969 66.527344 39.0625 C 66.691406 40.613281 65.980469 42.132812 64.355469 43.707031 Z M 64.355469 43.707031 " fill-opacity="1" fill-rule="nonzero"/></g></svg>' : '';
    
    $html = '<div id="astro-widget" class="w3-card-4 divine__dh__widget">               
                <div class="w3-card-0 w3-padding w3-round-large w3-margin-bottom padding-top-0">
                        <div>
                            <div class="divine-row">';
    if ($sign == 1) {
        $html .= '<div class="divine-col divine__dh__signbox" sign=
                               aries>
                                        <div class="divine__dh__sign divine__dh__sign__aries '.($default_sign == 'aries' ? 'active' : '' ).'">
                                            <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries-1.png"/>
                                            Aries
                                        </div>
                                      </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     taurus>
                                        <div class="divine__dh__sign divine__dh__sign__taurus '.($default_sign == 'taurus' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus-1.png"/>
                                        Taurus
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     gemini>
                                        <div class="divine__dh__sign divine__dh__sign__gemini '.($default_sign == 'gemini' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini-1.png"/>
                                        Gemini
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     cancer>
                                        <div class="divine__dh__sign divine__dh__sign__cancer '.($default_sign == 'cancer' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer-1.png"/>
                                        Cancer
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     leo>
                                        <div class="divine__dh__sign divine__dh__sign__leo '.($default_sign == 'leo' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo-1.png"/>
                                        Leo
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     virgo>
                                        <div class="divine__dh__sign divine__dh__sign__virgo '.($default_sign == 'virgo' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo-1.png"/>
                                        Virgo
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     libra>
                                        <div class="divine__dh__sign divine__dh__sign__libra '.($default_sign == 'libra' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra-1.png"/>
                                        Libra
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     scorpio>
                                        <div class="divine__dh__sign divine__dh__sign__scorpio '.($default_sign == 'scorpio' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio-1.png"/>
                                        Scorpio
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     sagittarius>
                                        <div class="divine__dh__sign divine__dh__sign__sagittarius '.($default_sign == 'sagittarius' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius-1.png"/>
                                        Sagittarius
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     capricorn>
                                        <div class="divine__dh__sign divine__dh__sign__capricorn '.($default_sign == 'capricorn' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn-1.png"/>
                                        Capricorn
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     aquarius>
                                        <div class="divine__dh__sign divine__dh__sign__aquarius '.($default_sign == 'aquarius' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius-1.png"/>
                                        Aquarius
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     pisces>
                                        <div class="divine__dh__sign divine__dh__sign__pisces '.($default_sign == 'pisces' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces-1.png"/>
                                        Pisces
                                        </div>
                                     </div>';
    } else if ($sign == 3) {
        $html .= '<div class="divine-col divine__dh__signbox" sign=
                               aries>
                                        <div class="divine__dh__sign divine__dh__sign__aries '.($default_sign == 'aries' ? 'active' : '' ).'">
                                            <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries-2.png"/>
                                            Aries
                                        </div>
                                      </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     taurus>
                                        <div class="divine__dh__sign divine__dh__sign__taurus '.($default_sign == 'taurus' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus-2.png"/>
                                        Taurus
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     gemini>
                                        <div class="divine__dh__sign divine__dh__sign__gemini '.($default_sign == 'gemini' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini-2.png"/>
                                        Gemini
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     cancer>
                                        <div class="divine__dh__sign divine__dh__sign__cancer '.($default_sign == 'cancer' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer-2.png"/>
                                        Cancer
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     leo>
                                        <div class="divine__dh__sign divine__dh__sign__leo '.($default_sign == 'leo' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo-2.png"/>
                                        Leo
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     virgo>
                                        <div class="divine__dh__sign divine__dh__sign__virgo '.($default_sign == 'virgo' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo-2.png"/>
                                        Virgo
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     libra>
                                        <div class="divine__dh__sign divine__dh__sign__libra '.($default_sign == 'libra' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra-2.png"/>
                                        Libra
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     scorpio>
                                        <div class="divine__dh__sign divine__dh__sign__scorpio '.($default_sign == 'scorpio' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio-2.png"/>
                                        Scorpio
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     sagittarius>
                                        <div class="divine__dh__sign divine__dh__sign__sagittarius '.($default_sign == 'sagittarius' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius-2.png"/>
                                        Sagittarius
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     capricorn>
                                        <div class="divine__dh__sign divine__dh__sign__capricorn '.($default_sign == 'capricorn' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn-2.png"/>
                                        Capricorn
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     aquarius>
                                        <div class="divine__dh__sign divine__dh__sign__aquarius '.($default_sign == 'aquarius' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius-2.png"/>
                                        Aquarius
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     pisces>
                                        <div class="divine__dh__sign divine__dh__sign__pisces '.($default_sign == 'pisces' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces-2.png"/>
                                        Pisces
                                        </div>
                                     </div>';
    } else {
        $html .= '<div class="divine-col divine__dh__signbox" sign=
                               aries>
                                        <div class="divine__dh__sign divine__dh__sign__aries '.($default_sign == 'aries' ? 'active' : '' ).'">
                                            <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aries.png"/>
                                            Aries
                                        </div>
                                      </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     taurus>
                                        <div class="divine__dh__sign divine__dh__sign__taurus '.($default_sign == 'taurus' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Taurus.png"/>
                                        Taurus
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     gemini>
                                        <div class="divine__dh__sign divine__dh__sign__gemini '.($default_sign == 'gemini' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Gemini.png"/>
                                        Gemini
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     cancer>
                                        <div class="divine__dh__sign divine__dh__sign__cancer '.($default_sign == 'cancer' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Cancer.png"/>
                                        Cancer
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     leo>
                                        <div class="divine__dh__sign divine__dh__sign__leo '.($default_sign == 'leo' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Leo.png"/>
                                        Leo
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     virgo>
                                        <div class="divine__dh__sign divine__dh__sign__virgo '.($default_sign == 'virgo' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Virgo.png"/>
                                        Virgo
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     libra>
                                        <div class="divine__dh__sign divine__dh__sign__libra '.($default_sign == 'libra' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Libra.png"/>
                                        Libra
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     scorpio>
                                        <div class="divine__dh__sign divine__dh__sign__scorpio '.($default_sign == 'scorpio' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Scorpio.png"/>
                                        Scorpio
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     sagittarius>
                                        <div class="divine__dh__sign divine__dh__sign__sagittarius '.($default_sign == 'sagittarius' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Sagittarius.png"/>
                                        Sagittarius
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     capricorn>
                                        <div class="divine__dh__sign divine__dh__sign__capricorn '.($default_sign == 'capricorn' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Capricorn.png"/>
                                        Capricorn
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     aquarius>
                                        <div class="divine__dh__sign divine__dh__sign__aquarius '.($default_sign == 'aquarius' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Aquarius.png"/>
                                        Aquarius
                                        </div>
                                     </div>
                                     <div class="divine-col divine__dh__signbox" sign=
                                     pisces>
                                        <div class="divine__dh__sign divine__dh__sign__pisces '.($default_sign == 'pisces' ? 'active' : '' ).'">
                                        <img src="' . DHAT_PLUGIN_URL . 'public/images/zodiac/Pisces.png"/>
                                        Pisces
                                        </div>
                                     </div>';
    }
    $html .= '</div>
                            <div class="divine__dh__title">
                                <div class="divine__dh__name"><h4 class="divine__dh__date">Aries Horoscope Today</h4></div>
                            </div>
                            <section class="divine__dh__horo__links">
                                <nav class="divine__dh__horo__link__effect">
                                    <a href="javascript:void(0);" type="daily" class="divine__dh__api__btn active">Daily</a>
                                    <a href="javascript:void(0);" type="weekly" class="divine__dh__api__btn">Weekly</a>
                                    <a href="javascript:void(0);" type="monthly" class="divine__dh__api__btn">Monthly</a>
                                    <a href="javascript:void(0);" type="yearly" class="divine__dh__api__btn">Yearly</a>
                                </nav>
                            </section>
                            <nav class="divine__dh__date__nav" id="divine-dh-set-daily">
                                <a class="btn-outline divine__dh__date__btn" day="Yesterday" date="' . $yesterday . '" href="javascript:void(0);">Yesterday</a>
                                <a class="btn-outline divine__dh__date__btn active" day="Today" date="' . $today . '" href="javascript:void(0);">Today</a>
                                <a class="btn-outline divine__dh__date__btn" day="Tomorrow" date="' . $tomorrow . '" href="javascript:void(0);">Tomorrow</a>
                            </nav>
                            <nav class="divine__dh__date__nav" id="divine-dh-set-weekly" style="display:none;">
                                <a class="btn-outline divine__dh__week__btn" week="prev" href="javascript:void(0);">Last Week</a>
                                <a class="btn-outline divine__dh__week__btn active" week="current" href="javascript:void(0);">This Week</a>
                                <a class="btn-outline divine__dh__week__btn" week="next" href="javascript:void(0);">Next Week</a>
                            </nav>
                            <nav class="divine__dh__date__nav" id="divine-dh-set-monthly" style="display:none;">
                                <a class="btn-outline divine__dh__month__btn" month="prev" href="javascript:void(0);">Last Month</a>
                                <a class="btn-outline divine__dh__month__btn active" month="current" href="javascript:void(0);">This Month</a>
                                <a class="btn-outline divine__dh__month__btn" month="next" href="javascript:void(0);">Next Month</a>
                            </nav>
                            <nav class="divine__dh__date__nav" id="divine-dh-set-yearly" style="display:none;">
                                <a class="btn-outline divine__dh__year__btn" year="prev" href="javascript:void(0);">Last Year</a>
                                <a class="btn-outline divine__dh__year__btn active" year="current" href="javascript:void(0);">This Year</a>
                                <a class="btn-outline divine__dh__year__btn" year="next" href="javascript:void(0);">Next Year</a>
                            </nav>
                        </div>
                </div>
                <div id="divine__dh__overlay" class="divine__plugin__overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="divine_auth_domain_response">
                    <p style="color: red !important;text-align:center !important;"></p>
                </div>
                <div class="divine__dh__category_tabs w3-card-4 w3-padding w3-round-large">
                    <ul>
                        <li>
                            <a href="javascript:void(0);" class="dapi-th1 divine__dh__category__links active" tab="Divinepersonal">' . $personal_icon . ' &nbsp; PERSONAL</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dapi-th1 divine__dh__category__links" tab="Divinehealth">' . $health_icon . ' &nbsp; HEALTH</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dapi-th1 divine__dh__category__links" tab="Divineprofession">' . $profession_icon . ' &nbsp; PROFESSION</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dapi-th1 divine__dh__category__links" tab="Divineemotions">' . $emotions_icon . ' &nbsp; EMOTIONS</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dapi-th1 divine__dh__category__links" tab="Divinetravel">' . $travel_icon . ' &nbsp; TRAVEL</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dapi-th1 divine__dh__category__links" tab="Divineluck">' . $luck_icon . ' &nbsp; LUCK</a>
                        </li>
                    </ul>
                </div>
                <div class="divine__dh__content_wrap">
                    <span class="divine__dh__result__date">13 January 2020</span>
                    <div id="Divinepersonal" class="divine__dh__content__data" style="display: block;">
                        <span class="divine__dh__content__title">Personal</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinehealth" class="divine__dh__content__data">
                        <span class="divine__dh__content__title">Health</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divineprofession" class="divine__dh__content__data">
                        <span class="divine__dh__content__title">Profession</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divineemotions" class="divine__dh__content__data">
                        <span class="divine__dh__content__title">Emotions</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divinetravel" class="divine__dh__content__data">
                        <span class="divine__dh__content__title">Travel</span>
                        <p>
                        </p>
                    </div>
                    <div id="Divineluck" class="divine__dh__content__data">
                        <span class="divine__dh__content__title">Luck</span>
                        <p>
                        </p>
                    </div>
                </div>
            </div>';
    return $html;

}

function get_horoscope_theme_2_html($today, $yesterday, $tomorrow, $sign, $default_sign) {

    $tabs_position = get_option('horoscope_tabs_position_field');
    $buttons_position = get_option('horoscope_buttons_position_field');
    $buttons_with_icons = get_option('horoscope_buttons_with_icon_field');
    $button_type = get_option('horoscope_buttons_type_field');

    $btn_class = ($button_type == 'square') ? 'h_theme_2_cat_btn_square' : 'h_theme_2_cat_btn';
    $cat_bottom_border = ($buttons_position == 'bottom') ? 'dapi_thm2-cat_btn_pb' : 'h_theme_2_cat_btn_cnt';
    $cat_head_top_border = ($tabs_position == 'bottom') ? 'dapi-thm2_cat_heading_mt' : 'dapi-thm2_cat_heading_border';

    // $personal_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/personal.svg"/>' : '';
    // $emotions_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/emotions.svg"/>' : '';
    // $health_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/health.svg"/>' : '';
    // $profession_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/profession.svg"/>' : '';
    // $travel_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/travel.svg"/>' : '';
    // $luck_icon = ($buttons_with_icons == 'on') ? '<img src="'. DHAT_PLUGIN_URL .'public/images/horoscope-categories/luck.svg"/>' : '';

    $personal_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="e539dac21a"><path d="M 38 14 L 63.75 14 L 63.75 75 L 38 75 Z M 38 14 " clip-rule="nonzero"/></clipPath></defs><path fill="#040606" d="M 28.945312 15.511719 C 29.53125 15.28125 29.765625 14.578125 29.53125 13.992188 C 29.300781 13.410156 28.589844 13.179688 28.003906 13.410156 C 15.074219 19.011719 11.671875 29.867188 17.898438 45.734375 C 18.132812 46.199219 18.367188 46.785156 18.367188 46.902344 C 18.367188 47.023438 18.484375 47.136719 18.484375 47.253906 C 19.660156 49.355469 18.839844 58.335938 18.132812 63.59375 C 18.011719 64.175781 18.484375 64.871094 19.074219 64.871094 C 19.660156 64.992188 20.367188 64.519531 20.367188 63.9375 C 20.714844 61.605469 22.363281 49.9375 20.601562 46.320312 C 20.480469 45.96875 20.367188 45.617188 20.015625 44.800781 C 18.011719 39.433594 11.550781 23.09375 28.945312 15.511719 " fill-opacity="1" fill-rule="nonzero"/><g clip-path="url(#e539dac21a)"><path fill="#040606" d="M 59.503906 41.996094 C 58.917969 41.535156 58.796875 40.71875 59.152344 39.546875 C 60.09375 36.398438 57.742188 18.777344 50.21875 14.226562 C 49.632812 13.875 48.925781 14.105469 48.570312 14.578125 C 48.21875 15.160156 48.457031 15.863281 48.925781 16.207031 C 55.273438 19.945312 57.621094 36.164062 56.914062 38.847656 C 56.328125 40.832031 56.679688 42.46875 57.742188 43.636719 C 58.675781 45.152344 61.613281 47.949219 61.378906 49.234375 C 61.265625 49.707031 60.09375 50.171875 59.738281 50.285156 C 59.03125 50.171875 58.445312 50.753906 58.445312 51.457031 L 58.445312 54.484375 L 57.742188 55.1875 C 57.390625 55.539062 57.269531 56.121094 57.390625 56.59375 L 58.328125 58.457031 C 58.917969 59.621094 57.503906 61.492188 56.679688 62.539062 C 55.273438 64.175781 52.335938 64.058594 45.511719 62.074219 C 44.339844 61.722656 43.164062 62.308594 42.695312 63.355469 L 38.109375 73.390625 C 37.878906 73.972656 38.109375 74.675781 38.699219 74.90625 C 39.285156 75.144531 39.992188 74.90625 40.226562 74.332031 L 44.8125 64.058594 C 51.75 66.039062 55.972656 66.621094 58.445312 63.824219 C 60.679688 61.253906 61.378906 59.039062 60.445312 57.171875 L 59.972656 56.121094 L 60.445312 55.652344 C 60.679688 55.421875 60.914062 55.074219 60.914062 54.71875 L 60.914062 52.039062 C 62.320312 51.449219 63.503906 50.753906 63.738281 49.355469 C 64.085938 47.023438 59.617188 42.117188 59.503906 41.996094 " fill-opacity="1" fill-rule="nonzero"/></g><path fill="#040606" d="M 48.925781 26.59375 C 48.925781 29.628906 46.6875 32.203125 43.75 32.785156 C 43.871094 29.867188 45.988281 27.296875 48.925781 26.59375 Z M 25.535156 24.964844 C 27.882812 25.082031 30.941406 26.128906 31.648438 29.980469 C 27.769531 30.101562 26.121094 27.296875 25.535156 24.964844 Z M 24.359375 6.410156 C 27.769531 4.421875 30.472656 6.058594 32.238281 7.691406 C 30 8.742188 26.941406 9.328125 24.359375 6.410156 Z M 48.691406 2.792969 C 48.804688 6.644531 45.988281 8.273438 43.636719 8.855469 C 43.75 6.523438 44.8125 3.488281 48.691406 2.792969 Z M 39.050781 53.902344 L 42.464844 45.035156 C 43.402344 42.699219 43.050781 40.136719 41.753906 38.148438 C 42.695312 37.210938 43.285156 35.933594 43.636719 35.117188 C 52.214844 34.0625 51.152344 25.195312 51.273438 25.082031 C 51.152344 24.492188 50.6875 23.917969 49.980469 24.027344 C 49.390625 24.378906 42.578125 23.09375 41.636719 33.832031 C 41.289062 34.765625 40.695312 35.8125 40.226562 36.398438 C 39.992188 36.164062 39.757812 36.046875 39.519531 35.8125 C 34.230469 32.546875 39.640625 25.664062 41.523438 22.398438 C 43.636719 18.660156 41.753906 15.511719 41.523438 14.695312 C 42.578125 13.761719 43.164062 12.242188 43.519531 11.191406 C 52.09375 9.441406 51.039062 1.386719 51.039062 1.273438 C 51.039062 0.921875 50.808594 0.691406 50.574219 0.457031 C 50.21875 0.457031 49.980469 0.339844 49.632812 0.339844 C 49.511719 0.457031 40.933594 0.21875 41.289062 10.140625 C 41.167969 10.84375 40.933594 11.429688 40.695312 12.011719 L 37.878906 2.089844 C 37.644531 1.507812 36.9375 1.15625 36.347656 1.273438 C 35.761719 1.507812 35.40625 2.089844 35.527344 2.792969 L 37.054688 8.042969 C 36.347656 7.921875 35.527344 7.457031 34.820312 7.105469 C 28.945312 -0.0117188 22.128906 5.125 22.011719 5.125 C 21.421875 5.476562 21.300781 6.171875 21.777344 6.753906 C 22.242188 7.226562 26.121094 13.761719 34.117188 9.328125 C 34.941406 9.792969 36.46875 10.492188 37.757812 10.492188 C 39.757812 18.078125 40.8125 18.890625 39.40625 21.34375 C 37.996094 22.628906 34.941406 28 34.820312 31.851562 C 34.585938 31.5 34.351562 31.148438 34.117188 30.796875 C 34 30.683594 34 22.398438 24.125 22.75 C 23.773438 22.75 23.417969 22.863281 23.183594 23.214844 C 22.832031 23.566406 22.953125 23.917969 22.953125 24.261719 C 23.773438 29.515625 27.0625 32.785156 32.355469 32.433594 C 32.945312 33.367188 34.117188 35 35.648438 35.46875 C 37.054688 38.265625 42.230469 39.433594 40.347656 44.449219 L 36.9375 53.320312 C 36.703125 53.910156 37.054688 54.605469 37.644531 54.835938 C 38.109375 54.835938 38.816406 54.484375 39.050781 53.902344 " fill-opacity="1" fill-rule="nonzero"/></svg>' : '';
    $emotions_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="4b4713d0cc"><path d="M 0 4.265625 L 75 4.265625 L 75 71 L 0 71 Z M 0 4.265625 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#4b4713d0cc)"><path fill="#000000" d="M 37.5 71 L 36.703125 70.457031 C 36.613281 70.394531 27.480469 64.128906 18.480469 55.46875 C 13.171875 50.347656 8.925781 45.40625 5.863281 40.765625 C 1.980469 34.832031 0 29.332031 0 24.453125 C 0 13.335938 9.015625 4.28125 20.085938 4.28125 C 24.195312 4.28125 28.171875 5.546875 31.558594 7.957031 C 34.019531 9.707031 36.03125 11.933594 37.5 14.496094 C 38.96875 11.917969 40.980469 9.691406 43.441406 7.957031 C 46.828125 5.546875 50.804688 4.28125 54.914062 4.28125 C 65.984375 4.28125 75 13.335938 75 24.453125 L 75 24.46875 C 74.953125 29.316406 72.960938 34.769531 69.058594 40.691406 C 66 45.332031 61.769531 50.269531 56.460938 55.40625 C 47.476562 64.097656 38.386719 70.394531 38.296875 70.457031 Z M 20.085938 7.097656 C 10.558594 7.097656 2.804688 14.886719 2.804688 24.453125 C 2.804688 28.777344 4.621094 33.730469 8.203125 39.183594 C 11.128906 43.644531 15.238281 48.433594 20.398438 53.40625 C 27.703125 60.4375 35.113281 65.878906 37.5 67.5625 C 39.886719 65.863281 47.25 60.394531 54.539062 53.34375 C 59.683594 48.359375 63.78125 43.582031 66.71875 39.125 C 70.304688 33.671875 72.148438 28.746094 72.179688 24.453125 C 72.179688 14.886719 64.425781 7.113281 54.898438 7.113281 C 47.835938 7.113281 41.371094 11.601562 38.789062 18.292969 L 37.484375 21.695312 L 36.195312 18.292969 C 33.613281 11.601562 27.148438 7.097656 20.085938 7.097656 Z M 20.085938 7.097656 " fill-opacity="1" fill-rule="nonzero"/></g></svg>' : '';
    $health_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><path fill="#000000" d="M 75 37.5 C 75 58.296875 58.296875 75 37.5 75 C 16.703125 75 0 58.296875 0 37.5 C 0 16.703125 16.703125 0 37.5 0 C 58.296875 0 75 16.703125 75 37.5 Z M 61.363281 28.808594 L 46.191406 28.808594 L 46.191406 13.636719 L 28.636719 13.636719 L 28.636719 28.808594 L 13.464844 28.808594 L 13.464844 46.363281 L 28.636719 46.363281 L 28.636719 61.363281 L 46.191406 61.363281 L 46.191406 46.191406 L 61.363281 46.191406 Z M 61.363281 28.808594 " fill-opacity="1" fill-rule="nonzero"/></svg>' : '';
    $profession_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><path fill="#000000" d="M 72.65625 14.0625 L 58.59375 14.0625 L 58.59375 7.03125 C 58.59375 3.15625 55.4375 0 51.5625 0 L 23.4375 0 C 19.5625 0 16.40625 3.15625 16.40625 7.03125 L 16.40625 14.0625 L 2.34375 14.0625 C 1.050781 14.0625 0 15.109375 0 16.40625 L 0 72.65625 C 0 73.953125 1.050781 75 2.34375 75 L 72.65625 75 C 73.953125 75 75 73.953125 75 72.65625 L 75 16.40625 C 75 15.109375 73.953125 14.0625 72.65625 14.0625 Z M 21.09375 7.03125 C 21.09375 5.738281 22.144531 4.6875 23.4375 4.6875 L 51.5625 4.6875 C 52.855469 4.6875 53.90625 5.738281 53.90625 7.03125 L 53.90625 14.0625 L 21.09375 14.0625 Z M 4.6875 18.75 L 70.3125 18.75 L 70.3125 30.46875 C 70.3125 34.34375 67.15625 37.5 63.28125 37.5 L 44.53125 37.5 L 44.53125 35.15625 C 44.53125 31.28125 41.375 28.125 37.5 28.125 C 33.625 28.125 30.46875 31.28125 30.46875 35.15625 L 30.46875 37.5 L 11.71875 37.5 C 7.84375 37.5 4.6875 34.34375 4.6875 30.46875 Z M 39.84375 37.5 L 35.15625 37.5 L 35.15625 35.15625 C 35.15625 33.863281 36.207031 32.8125 37.5 32.8125 C 38.792969 32.8125 39.84375 33.863281 39.84375 35.15625 Z M 35.15625 42.1875 L 39.84375 42.1875 L 39.84375 44.53125 C 39.84375 45.824219 38.792969 46.875 37.5 46.875 C 36.207031 46.875 35.15625 45.824219 35.15625 44.53125 Z M 4.6875 70.3125 L 4.6875 39.78125 C 6.652344 41.269531 9.070312 42.1875 11.71875 42.1875 L 30.46875 42.1875 L 30.46875 44.53125 C 30.46875 48.40625 33.625 51.5625 37.5 51.5625 C 41.375 51.5625 44.53125 48.40625 44.53125 44.53125 L 44.53125 42.1875 L 63.28125 42.1875 C 65.929688 42.1875 68.347656 41.269531 70.3125 39.78125 L 70.3125 70.3125 Z M 4.6875 70.3125 " fill-opacity="1" fill-rule="nonzero"/></svg>' : '';
    $travel_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="2e1a38b997"><path d="M 0 0 L 75 0 L 75 74.25 L 0 74.25 Z M 0 0 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#2e1a38b997)"><path fill="#000000" d="M 74.453125 49.082031 L 69.289062 43.941406 L 69.285156 43.945312 C 69.066406 43.730469 68.773438 43.59375 68.445312 43.585938 L 55.851562 43.277344 C 55.851562 43.277344 55.851562 43.277344 55.847656 43.277344 C 55.246094 42.578125 54.609375 41.886719 53.917969 41.203125 L 47.070312 34.382812 L 72.597656 21.269531 C 72.710938 21.214844 72.816406 21.136719 72.910156 21.042969 C 73.386719 20.558594 73.382812 19.785156 72.894531 19.308594 L 66.09375 12.648438 C 65.84375 12.367188 65.46875 12.203125 65.0625 12.238281 L 59.695312 12.707031 L 55.832031 8.859375 C 55.019531 8.054688 53.949219 7.648438 52.882812 7.648438 C 51.8125 7.648438 50.742188 8.054688 49.933594 8.859375 C 49.121094 9.667969 48.714844 10.734375 48.714844 11.796875 C 48.714844 12.425781 48.875 13.046875 49.160156 13.625 L 45.3125 13.960938 L 41.445312 10.113281 C 40.632812 9.308594 39.5625 8.902344 38.496094 8.902344 C 37.429688 8.902344 36.363281 9.308594 35.550781 10.113281 L 35.472656 10.195312 C 34.710938 10.992188 34.328125 12.023438 34.328125 13.050781 C 34.328125 13.679688 34.492188 14.300781 34.777344 14.878906 L 28.136719 15.457031 C 28.117188 15.460938 28.101562 15.472656 28.078125 15.472656 L 20.972656 8.402344 C 18.207031 5.648438 15.59375 3.4375 12.554688 2.019531 C 9.46875 0.582031 6.023438 -0.00390625 1.660156 0.527344 C 1.078125 0.597656 0.640625 1.0625 0.582031 1.621094 C 0.0507812 5.953125 0.644531 9.378906 2.085938 12.441406 C 3.507812 15.464844 5.730469 18.070312 8.496094 20.820312 L 15.535156 27.828125 C 15.511719 27.90625 15.472656 27.980469 15.464844 28.066406 L 14.882812 34.671875 C 14.304688 34.390625 13.675781 34.230469 13.042969 34.230469 C 11.976562 34.230469 10.90625 34.632812 10.097656 35.441406 L 10.097656 35.449219 C 9.285156 36.257812 8.878906 37.320312 8.878906 38.378906 C 8.878906 39.410156 9.257812 40.4375 10.019531 41.238281 L 10.097656 41.316406 L 13.960938 45.164062 L 13.625 48.992188 C 13.042969 48.710938 12.417969 48.550781 11.785156 48.550781 C 10.71875 48.550781 9.648438 48.957031 8.835938 49.761719 C 8.023438 50.570312 7.617188 51.636719 7.617188 52.699219 C 7.617188 53.761719 8.023438 54.828125 8.835938 55.632812 L 12.699219 59.480469 L 12.230469 64.828125 C 12.195312 65.226562 12.359375 65.605469 12.644531 65.851562 L 19.332031 72.625 C 19.808594 73.105469 20.589844 73.113281 21.074219 72.640625 C 21.167969 72.546875 21.246094 72.441406 21.304688 72.328125 L 34.554688 46.765625 L 41.441406 53.621094 C 42.230469 54.40625 43.03125 55.117188 43.835938 55.785156 L 44.136719 67.777344 C 44.144531 68.105469 44.28125 68.402344 44.496094 68.613281 L 44.492188 68.617188 L 49.65625 73.757812 C 50.140625 74.238281 50.921875 74.238281 51.398438 73.757812 C 51.605469 73.550781 51.722656 73.292969 51.753906 73.027344 L 54.257812 60.636719 C 56 60.871094 57.863281 60.878906 59.886719 60.632812 C 60.46875 60.5625 60.90625 60.097656 60.964844 59.539062 C 61.21875 57.441406 61.195312 55.523438 60.929688 53.730469 L 73.710938 51.167969 C 73.980469 51.136719 74.242188 51.019531 74.445312 50.816406 C 74.933594 50.335938 74.933594 49.558594 74.453125 49.082031 Z M 52.050781 13.371094 L 51.675781 12.996094 C 51.347656 12.667969 51.179688 12.230469 51.179688 11.792969 C 51.179688 11.359375 51.347656 10.921875 51.675781 10.59375 C 52.003906 10.265625 52.445312 10.101562 52.882812 10.101562 C 53.320312 10.101562 53.753906 10.265625 54.085938 10.59375 L 56.488281 12.984375 L 52.335938 13.347656 Z M 37.664062 14.625 L 37.289062 14.25 C 36.960938 13.925781 36.792969 13.488281 36.792969 13.046875 C 36.792969 12.632812 36.945312 12.214844 37.242188 11.894531 L 37.289062 11.847656 C 37.617188 11.519531 38.054688 11.355469 38.496094 11.355469 C 38.933594 11.355469 39.371094 11.519531 39.699219 11.847656 L 42.101562 14.238281 L 38.027344 14.59375 Z M 37.308594 17.121094 L 44.949219 16.457031 C 44.949219 16.457031 44.949219 16.457031 44.953125 16.457031 L 51.695312 15.867188 L 59.335938 15.203125 L 64.714844 14.734375 L 69.964844 19.871094 L 45.246094 32.566406 L 30.34375 17.730469 Z M 11.792969 39.53125 C 11.496094 39.210938 11.347656 38.796875 11.347656 38.378906 C 11.347656 37.945312 11.511719 37.507812 11.839844 37.179688 C 12.171875 36.851562 12.609375 36.6875 13.046875 36.6875 C 13.484375 36.6875 13.921875 36.851562 14.253906 37.179688 L 14.632812 37.554688 L 14.480469 39.261719 L 14.242188 41.96875 Z M 10.582031 53.898438 C 10.253906 53.570312 10.089844 53.136719 10.089844 52.699219 C 10.089844 52.265625 10.253906 51.828125 10.582031 51.5 C 10.914062 51.171875 11.351562 51.007812 11.789062 51.007812 C 12.226562 51.007812 12.664062 51.171875 12.996094 51.5 L 13.375 51.875 L 13.175781 54.125 L 12.988281 56.289062 Z M 19.898438 69.703125 L 14.738281 64.480469 L 15.210938 59.125 L 15.457031 56.320312 L 16.46875 44.804688 L 16.492188 44.519531 L 17.765625 30.050781 L 32.730469 44.945312 Z M 49.78125 70.40625 L 46.585938 67.226562 L 46.34375 57.625 C 47.410156 58.3125 48.496094 58.929688 49.644531 59.40625 C 50.363281 59.703125 51.097656 59.949219 51.855469 60.15625 Z M 58.617188 58.292969 C 55.566406 58.539062 52.957031 58.117188 50.589844 57.140625 C 47.945312 56.050781 45.5625 54.246094 43.1875 51.882812 L 10.242188 19.085938 C 7.644531 16.503906 5.582031 14.097656 4.3125 11.402344 C 3.171875 8.980469 2.652344 6.257812 2.933594 2.863281 C 6.34375 2.582031 9.078125 3.101562 11.511719 4.234375 C 14.21875 5.496094 16.632812 7.554688 19.226562 10.136719 L 52.175781 42.933594 C 54.550781 45.296875 56.363281 47.671875 57.460938 50.304688 C 58.441406 52.660156 58.863281 55.257812 58.617188 58.292969 Z M 60.417969 51.335938 C 60.226562 50.664062 60 50.007812 59.734375 49.367188 C 59.210938 48.109375 58.523438 46.925781 57.742188 45.769531 L 67.886719 46.019531 L 71.085938 49.199219 Z M 60.417969 51.335938 " fill-opacity="1" fill-rule="nonzero"/></g></svg>' : '';
    $luck_icon = ($buttons_with_icons == 'on') ? '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" zoomAndPan="magnify" viewBox="0 0 75 74.999997" height="100" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="46a84a3753"><path d="M 1 3.46875 L 70 3.46875 L 70 71.71875 L 1 71.71875 Z M 1 3.46875 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#46a84a3753)"><path fill="#000000" d="M 62.53125 29.578125 C 62.53125 29.578125 70.246094 17.066406 58.78125 13.390625 C 58.027344 13.148438 57.273438 13.035156 56.523438 13.035156 C 54.105469 13.035156 51.738281 14.210938 49.523438 16.027344 C 50.363281 12.363281 50.105469 8.949219 47.773438 6.535156 C 45.617188 4.300781 43.5 3.46875 41.546875 3.46875 C 35.921875 3.46875 31.644531 10.34375 31.644531 10.34375 C 31.644531 10.34375 27.535156 7.800781 23.339844 7.796875 C 20.226562 7.796875 17.0625 9.203125 15.503906 14.105469 C 14.480469 17.304688 15.757812 20.476562 18.128906 23.386719 C 16.914062 23.109375 15.722656 22.949219 14.589844 22.949219 C 12.320312 22.949219 10.273438 23.582031 8.667969 25.140625 C 0.015625 33.53125 12.464844 41.316406 12.464844 41.316406 C 12.464844 41.316406 4.75 53.828125 16.210938 57.503906 C 16.96875 57.746094 17.722656 57.859375 18.46875 57.859375 C 19.617188 57.859375 20.75 57.59375 21.863281 57.121094 C 20.898438 58.054688 19.902344 58.949219 18.875 59.800781 C 14.015625 63.816406 8.433594 66.894531 2.289062 68.949219 C 1.726562 69.136719 1.320312 69.667969 1.320312 70.296875 C 1.320312 71.082031 1.957031 71.71875 2.734375 71.71875 C 2.894531 71.71875 3.042969 71.695312 3.183594 71.644531 C 9.6875 69.472656 15.589844 66.210938 20.738281 61.945312 C 22.234375 60.699219 23.671875 59.371094 25.042969 57.960938 C 24.953125 60.417969 25.5625 62.640625 27.21875 64.359375 C 29.378906 66.59375 31.492188 67.425781 33.449219 67.425781 C 39.074219 67.425781 43.351562 60.546875 43.351562 60.546875 C 43.351562 60.546875 47.457031 63.097656 51.652344 63.097656 C 54.769531 63.097656 57.929688 61.691406 59.492188 56.792969 C 60.511719 53.589844 59.238281 50.417969 56.867188 47.503906 C 58.082031 47.785156 59.269531 47.945312 60.402344 47.945312 C 62.671875 47.945312 64.722656 47.308594 66.328125 45.753906 C 74.976562 37.363281 62.53125 29.578125 62.53125 29.578125 Z M 18.203125 14.96875 C 18.730469 13.308594 19.492188 12.125 20.460938 11.445312 C 21.234375 10.90625 22.175781 10.640625 23.339844 10.640625 C 26.605469 10.640625 30.035156 12.691406 30.15625 12.765625 L 32.546875 14.265625 L 34.050781 11.851562 C 34.058594 11.835938 34.976562 10.386719 36.457031 8.949219 C 37.699219 7.746094 39.585938 6.3125 41.546875 6.3125 C 42.9375 6.3125 44.308594 7.03125 45.738281 8.511719 C 46.996094 9.820312 47.394531 11.75 46.953125 14.410156 C 46.535156 16.949219 45.363281 19.992188 43.476562 23.453125 C 41.253906 27.519531 38.558594 31.191406 36.976562 33.222656 C 34.679688 32.113281 30.679688 30.042969 26.898438 27.394531 C 23.65625 25.128906 21.246094 22.917969 19.738281 20.824219 C 18.152344 18.621094 17.648438 16.707031 18.203125 14.96875 Z M 17.074219 54.796875 C 14.929688 54.105469 13.621094 53.0625 13.082031 51.605469 C 12.429688 49.847656 12.894531 47.648438 13.398438 46.109375 C 14.007812 44.269531 14.828125 42.890625 14.878906 42.808594 L 16.394531 40.40625 L 13.96875 38.90625 C 13.890625 38.855469 12.542969 37.984375 11.183594 36.601562 C 10.050781 35.449219 8.65625 33.683594 8.464844 31.820312 C 8.308594 30.273438 9.015625 28.757812 10.636719 27.1875 C 11.601562 26.25 12.898438 25.792969 14.589844 25.792969 C 16.941406 25.792969 19.921875 26.660156 23.371094 28.332031 C 26.882812 31.035156 30.824219 33.277344 33.699219 34.761719 C 34.296875 35.207031 34.828125 35.613281 35.277344 35.96875 C 35.03125 36.480469 34.734375 37.082031 34.398438 37.746094 C 32.476562 40.351562 29.9375 44.113281 27.984375 48.097656 C 24.503906 52.585938 21.1875 55.015625 18.46875 55.015625 C 17.996094 55.015625 17.539062 54.945312 17.074219 54.796875 Z M 55.257812 50.070312 C 56.84375 52.269531 57.34375 54.183594 56.789062 55.925781 C 56.261719 57.582031 55.503906 58.769531 54.53125 59.449219 C 53.761719 59.992188 52.820312 60.253906 51.652344 60.253906 C 48.390625 60.253906 44.96875 58.207031 44.839844 58.128906 L 42.445312 56.625 L 40.945312 59.042969 C 40.933594 59.058594 40.019531 60.507812 38.539062 61.941406 C 37.296875 63.144531 35.40625 64.582031 33.449219 64.582031 C 32.058594 64.582031 30.6875 63.859375 29.257812 62.382812 C 28 61.074219 27.597656 59.144531 28.039062 56.480469 C 28.460938 53.941406 29.632812 50.902344 31.519531 47.441406 C 33.742188 43.375 36.433594 39.703125 38.015625 37.671875 C 38.53125 37.917969 39.128906 38.214844 39.792969 38.554688 C 42.390625 40.480469 46.140625 43.03125 50.113281 44.984375 C 52.355469 46.734375 54.078125 48.4375 55.257812 50.070312 Z M 64.355469 43.707031 C 63.390625 44.644531 62.097656 45.101562 60.402344 45.101562 C 56.882812 45.101562 51.957031 43.160156 46.152344 39.484375 C 43.472656 37.785156 41.171875 36.066406 39.71875 34.925781 C 39.964844 34.410156 40.261719 33.808594 40.601562 33.144531 C 42.519531 30.535156 45.058594 26.777344 47.011719 22.796875 C 50.492188 18.308594 53.808594 15.878906 56.523438 15.878906 C 57 15.878906 57.457031 15.949219 57.917969 16.097656 C 60.066406 16.785156 61.375 17.828125 61.914062 19.289062 C 62.566406 21.042969 62.101562 23.246094 61.59375 24.785156 C 60.988281 26.625 60.164062 28.003906 60.117188 28.085938 L 58.617188 30.484375 L 61.03125 31.992188 C 61.042969 32 62.359375 32.835938 63.726562 34.203125 C 64.894531 35.375 66.328125 37.167969 66.527344 39.0625 C 66.691406 40.613281 65.980469 42.132812 64.355469 43.707031 Z M 64.355469 43.707031 " fill-opacity="1" fill-rule="nonzero"/></g></svg>' : '';
    
    $html = '';

    $zodiac = array(
        'aries' => array('Aries.png', 'Aries-1.png', 'Aries-2.png'),
        'taurus' => array('Taurus.png', 'Taurus-1.png', 'Taurus-2.png'),
        'gemini' => array('Gemini.png', 'Gemini-1.png', 'Gemini-2.png'),
        'cancer' => array('Cancer.png', 'Cancer-1.png', 'Cancer-2.png'),
        'leo' => array('Leo.png', 'Leo-1.png', 'Leo-2.png'),
        'virgo' => array('Virgo.png', 'Virgo-1.png', 'Virgo-2.png'),
        'libra' => array('Libra.png', 'Libra-1.png', 'Libra-2.png'),
        'scorpio' => array('Scorpio.png', 'Scorpio-1.png', 'Scorpio-2.png'),
        'sagittarius' => array('Sagittarius.png', 'Sagittarius-1.png', 'Sagittarius-2.png'),
        'capricorn' => array('Capricorn.png', 'Capricorn-1.png', 'Capricorn-2.png'),
        'aquarius' => array('Aquarius.png', 'Aquarius-1.png', 'Aquarius-2.png'),
        'pisces' => array('Pisces.png', 'Pisces-1.png', 'Pisces-2.png')
    );

    $tabs = '<div class="divine-row">
                <div class="col-lg-12 col-md-12 col-sm-12 dapi_h_tabs" style="padding: 0px !important;">
                    <button type="daily" class="divine__dh__api__btn active">Daily</button>
                    <button type="weekly" class="divine__dh__api__btn">Weekly</button>
                    <button type="monthly" class="divine__dh__api__btn">Monthly</button>
                    <button type="yearly" class="divine__dh__api__btn">Yearly</button>
                </div>
            </div>';

    $cat_heading = '<div class="divine-row">
                        <div class="col-lg-12 col-md-12 col-sm-12 dapi-thm2_cat_heading_section '. $cat_head_top_border .'" style="padding:0px !important; padding-top:15px !important;">
                            <h3 class="dapi_thm2_cat_heading">More Horoscopes for <span class="dapi_dh_sel_sign">'.$default_sign.'</span> &gt;</h3>
                        </div>
                    </div>';

    $buttons = '<div class="divine-row">
                <div class="col-lg-12 col-md-12 col-sm-12 '. $cat_bottom_border .'" style="">
                    <button class="dapi-th2 ' . $btn_class . ' divine__dh__category__links active" tab="Divinepersonal">'. $personal_icon .' Personal</button>
                    <button class="dapi-th2 ' . $btn_class . ' divine__dh__category__links" tab="Divineemotions">'. $emotions_icon .' Emotions</button>
                    <button class="dapi-th2 ' . $btn_class . ' divine__dh__category__links" tab="Divinehealth">'. $health_icon .' Health</button>
                    <button class="dapi-th2 ' . $btn_class . ' divine__dh__category__links" tab="Divineprofession">'. $profession_icon .' Profession</button>
                    <button class="dapi-th2 ' . $btn_class . ' divine__dh__category__links" tab="Divinetravel">'. $travel_icon .' Travel</button>
                    <button class="dapi-th2 ' . $btn_class . ' divine__dh__category__links" tab="Divineluck">'. $luck_icon .' Luck</button>
                </div>
            </div>';


    $html .= '<div id="astro-widget" class="w3-card-4 divine__dh__widget dapi-no-brdr">               
        <div class="w3-card-0 w3-padding w3-round-large w3-margin-bottom padding-top-0">
            <div>
                <div class="divine__dh__title"></div>';
                
                //if no tabs_position is not set into database then by default display tabs to top
                if ($tabs_position == 'top' || empty($tabs_position) || $tabs_position == 'null') { 
                    $html .= $tabs; 
                }

        $html .= '<div class="divine-row dapi-cst-mrgn">
                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0px !important;">';
                        
                        if ($sign == 1) {
                            
                $html .= '<div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__aries dapi-thm2_icls_selector '.($default_sign == 'aries' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Aries-1.png"/>
                                </div>
                                </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__taurus dapi-thm2_icls_selector '.($default_sign == 'taurus' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Taurus-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__gemini dapi-thm2_icls_selector '.($default_sign == 'gemini' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Gemini-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__cancer dapi-thm2_icls_selector '.($default_sign == 'cancer' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Cancer-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__leo dapi-thm2_icls_selector '.($default_sign == 'leo' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Leo-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__virgo dapi-thm2_icls_selector '.($default_sign == 'virgo' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Virgo-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__libra dapi-thm2_icls_selector '.($default_sign == 'libra' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Libra-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__scorpio dapi-thm2_icls_selector '.($default_sign == 'scorpio' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Scorpio-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__sagittarius dapi-thm2_icls_selector '.($default_sign == 'sagittarius' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Sagittarius-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__capricorn dapi-thm2_icls_selector '.($default_sign == 'capricorn' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Capricorn-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__aquarius dapi-thm2_icls_selector '.($default_sign == 'aquarius' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Aquarius-1.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__pisces dapi-thm2_icls_selector '.($default_sign == 'pisces' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Pisces-1.png"/>
                                </div>
                            </div>';
                        
                        } else if ($sign == 3) {

                    $html .= '<div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__aries dapi-thm2_icls_selector '.($default_sign == 'aries' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Aries-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__taurus dapi-thm2_icls_selector '.($default_sign == 'taurus' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Taurus-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__gemini dapi-thm2_icls_selector '.($default_sign == 'gemini' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Gemini-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__cancer dapi-thm2_icls_selector '.($default_sign == 'cancer' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Cancer-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__leo dapi-thm2_icls_selector '.($default_sign == 'leo' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Leo-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__virgo dapi-thm2_icls_selector '.($default_sign == 'virgo' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Virgo-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__libra dapi-thm2_icls_selector '.($default_sign == 'libra' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Libra-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__scorpio dapi-thm2_icls_selector '.($default_sign == 'scorpio' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Scorpio-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__sagittarius dapi-thm2_icls_selector '.($default_sign == 'sagittarius' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Sagittarius-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__capricorn dapi-thm2_icls_selector '.($default_sign == 'capricorn' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Capricorn-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__aquarius dapi-thm2_icls_selector '.($default_sign == 'aquarius' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Aquarius-2.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__pisces dapi-thm2_icls_selector '.($default_sign == 'pisces' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Pisces-2.png"/>
                                </div>
                            </div>';

                        } else {
                        
                        $html .= '<div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__aries dapi-thm2_icls_selector '.($default_sign == 'aries' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Aries.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__taurus dapi-thm2_icls_selector '.($default_sign == 'taurus' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Taurus.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__gemini dapi-thm2_icls_selector '.($default_sign == 'gemini' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Gemini.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__cancer dapi-thm2_icls_selector '.($default_sign == 'cancer' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Cancer.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__leo dapi-thm2_icls_selector '.($default_sign == 'leo' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Leo.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__virgo dapi-thm2_icls_selector '.($default_sign == 'virgo' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Virgo.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__libra dapi-thm2_icls_selector '.($default_sign == 'libra' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Libra.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__scorpio dapi-thm2_icls_selector '.($default_sign == 'scorpio' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Scorpio.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__sagittarius dapi-thm2_icls_selector '.($default_sign == 'sagittarius' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Sagittarius.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__capricorn dapi-thm2_icls_selector '.($default_sign == 'capricorn' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Capricorn.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__aquarius dapi-thm2_icls_selector '.($default_sign == 'aquarius' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Aquarius.png"/>
                                </div>
                            </div>
                            <div class="divine-col divine__dh__signbox dapi-h_thm2_imgs">
                                <div class="divine__dh__sign dapi_sign_img divine__dh__sign__pisces dapi-thm2_icls_selector '.($default_sign == 'pisces' ? 'active' : '' ).'">
                                    <img src="'. DHAT_PLUGIN_URL .'public/images/zodiac/Pisces.png"/>
                                </div>
                            </div>';
                            
                            }

            $html .= '<div class="dapi-h_thm2_ltsec dapi-thm2_secright">
                            <h2 class="h_theme_2_h2"><span class="dapi_dh_sel_sign">'.$default_sign.'</span> Horoscope</h2>
                            <p class="h_theme_2_muted_ttl divine__dh__result__date dapi-pleft0">July 20th, 2023</p>
                            <div class="divine__dh__date__nav dapi-no-m" id="divine-dh-set-daily">
                                <button class="h_theme_day_week_year divine__dh__date__btn" day="Yesterday" date="'.$yesterday.'">Yesterday</button>
                                <button class="h_theme_day_week_year divine__dh__date__btn active" day="Today" date="'.$today.'">Today</button>
                                <button class="h_theme_day_week_year divine__dh__date__btn" day="Tomorrow" date="'.$tomorrow.'">Tomorrow</button>
                            </div>
                            <div class="divine__dh__date__nav dapi-no-m" id="divine-dh-set-weekly" style="display:none;">
                                <button class="h_theme_day_week_year divine__dh__week__btn" week="prev">Last Week</button>
                                <button class="h_theme_day_week_year divine__dh__week__btn active" week="current">This Week</button>
                                <button class="h_theme_day_week_year divine__dh__week__btn" week="next">Next Week</button>
                            </div>
                            <div class="divine__dh__date__nav dapi-no-m" id="divine-dh-set-monthly" style="display:none;">
                                <button class="h_theme_day_week_year divine__dh__month__btn" month="prev">Last Month</button>
                                <button class="h_theme_day_week_year divine__dh__month__btn active" month="current">This Month</button>
                                <button class="h_theme_day_week_year divine__dh__month__btn" month="next">Next Month</button>
                            </div>
                            <div class="divine__dh__date__nav dapi-no-m" id="divine-dh-set-yearly" style="display:none;">
                                <button class="h_theme_day_week_year divine__dh__year__btn" year="prev">Last Year</button>
                                <button class="h_theme_day_week_year divine__dh__year__btn active" year="current">This Year</button>
                                <button class="h_theme_day_week_year divine__dh__year__btn" year="next">Next Year</button>
                            </div>
                        </div>
                        <div class="dapi-h_thm2_rtsec">
                            <select class="h_theme_2_select" id="dapi_theme_2_sign_select">
                                <option value="">Pick another sign</option>
                                <option value="aries">Aries</option>
                                <option value="taurus">Taurus</option>
                                <option value="gemini">Gemini</option>
                                <option value="cancer">Cancer</option>
                                <option value="leo">Leo</option>
                                <option value="virgo">Virgo</option>
                                <option value="libra">Libra</option>
                                <option value="scorpio">Scorpio</option>
                                <option value="sagittarius">Sagittarius</option>
                                <option value="capricorn">Capricorn</option>
                                <option value="aquarius">Aquarius</option>
                                <option value="pisces">Pisces</option>
                            </select>
                        </div>
                    </div>
                </div>';

                if ($tabs_position == 'middle') {
                    $html .= $tabs; 
                }

                //if no buttons_postion is not set into database then by default display buttons in middle
                if ($buttons_position == 'middle' || empty($buttons_position) || $buttons_position == 'null') {
                    $html .= $buttons; 
                }
                
            $html .= '<div class="divine-row">
                    <div class="col-lg-12 col-md-12 col-sm-12 h_theme_2_content" style="padding: 0px !important;">
                        <div id="divine__dh__overlay" class="divine__plugin__overlay" style="display: none;">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div class="divine_auth_domain_response" style="display:none;">
                            <p style="color: red !important;text-align:center !important;"></p>
                        </div>
                        <div class="divine__dh__content_wrap dapi-mtb-10 dapi-thm2_content_wrap">
                            <div id="Divinepersonal" class="divine__dh__content__data dapi-pleft0" style="display: block;">
                                <p>
                                </p>
                            </div>
                            <div id="Divinehealth" class="divine__dh__content__data dapi-pleft0">
                                <p>
                                </p>
                            </div>
                            <div id="Divineprofession" class="divine__dh__content__data dapi-pleft0">
                                <p>
                                </p>
                            </div>
                            <div id="Divineemotions" class="divine__dh__content__data dapi-pleft0">
                                <p>
                                </p>
                            </div>
                            <div id="Divinetravel" class="divine__dh__content__data dapi-pleft0">
                                <p>
                                </p>
                            </div>
                            <div id="Divineluck" class="divine__dh__content__data dapi-pleft0">
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>';
                
                if ($tabs_position == 'bottom') {
                    $html .=  $tabs; 
                }
                
                if ($buttons_position == 'bottom') {
                    $html .=  $cat_heading;
                    $html .=  $buttons; 
                }
                
            $html .= '</div>
        </div>
    </div>';
    return $html;
}

function dhat_kundali_shortcode($atts) {

    wp_enqueue_style('myplugin-kundali-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-kundali-script', DHAT_PLUGIN_URL . 'public/js/public-kundali.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-kundali-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-kundali-style', DHAT_PLUGIN_URL . 'public/css/public-kundali.css', '', rand());

    $kundali_theme_color = get_option('kundali_settings_theme_color_field');
    $dapi_ajax_script_url = array('ajaxurl' => admin_url('admin-ajax.php'), 'kundali_theme_color' => $kundali_theme_color);
    wp_localize_script('myplugin-kundali-script', 'dapi_admin_req', $dapi_ajax_script_url);

    $objApicall = new Apicall();
    $html = $objApicall->get_kundali_frm();
    unset($objApicall);

    return $html;

}
add_shortcode('divine_kundali', 'dhat_kundali_shortcode');

function dhat_kundali_matching_shortcode($atts) {

    wp_enqueue_style('myplugin-kundali-matching-jui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', '', rand());
    wp_enqueue_script('myplugin-kundali-matching-script', DHAT_PLUGIN_URL . 'public/js/public-kundali-matching.js', array('jquery'), rand(), true);
    wp_enqueue_script('myplugin-kundali-matching-jui-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), rand(), true);
    wp_enqueue_style('myplugin-kundali-matching-style', DHAT_PLUGIN_URL . 'public/css/public-kundali-matching.css', '', rand());

    $kundali_matching_theme_color = get_option('kundali_matching_settings_theme_color_field');
    $dapi_ajax_script_url = array('ajaxurl' => admin_url('admin-ajax.php'), 'kundali_matching_theme_color' => $kundali_matching_theme_color);
    wp_localize_script('myplugin-kundali-matching-script', 'dapi_admin_req', $dapi_ajax_script_url);

    $objApicall = new Apicall();
    $html = $objApicall->get_kundali_matching_frm();
    unset($objApicall);

    return $html;

}
add_shortcode('divine_kundali_matching', 'dhat_kundali_matching_shortcode');

function dhat_natal_shortcode($atts, $content = null) {
    
    $base_url = "https://divineapi.com/get_widget_code/dapi-widget-natal-basic/" . ($atts['setting'] ?? '');
    $api_key = get_option('divine_settings_input_field');
  
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $base_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('api_key' => $api_key),
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);
    $html = '';
    
    curl_close($curl);
    $setting = '';

    if(isset($response['setting']) && !empty($response['setting'])){
        $setting = '&setting=' . $response['setting'];
    }
    
    $html .= '<div id="'.$response['widget_tag'].'"></div>';
    $html .= '<script src="'.$response['widget_script'].'?widget_token='.$response['widget_token'] . $setting .'"></script>';
    $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
    return $html;
}
add_shortcode('divine_natal', 'dhat_natal_shortcode');

function dhat_natal_transit_shortcode($atts, $content = null) {
    
    $base_url = "https://divineapi.com/get_widget_code/dapi-widget-natal-basic-transit/" . ($atts['setting'] ?? '');
    $api_key = get_option('divine_settings_input_field');
  
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $base_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('api_key' => $api_key),
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);
    $html = '';
    
    curl_close($curl);
    $setting = '';

    if(isset($response['setting']) && !empty($response['setting'])){
        $setting = '&setting=' . $response['setting'];
    }
    
    $html .= '<div id="'.$response['widget_tag'].'"></div>';
    $html .= '<script src="'.$response['widget_script'].'?widget_token='.$response['widget_token'] . $setting .'"></script>';
    $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
    return $html;
}
add_shortcode('divine_natal_transit', 'dhat_natal_transit_shortcode');

function dhat_natal_synastry_shortcode($atts, $content = null) {
    
    $base_url = "https://divineapi.com/get_widget_code/dapi-widget-natal-synastry/" . ($atts['setting'] ?? '');
    $api_key = get_option('divine_settings_input_field');
  
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $base_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('api_key' => $api_key),
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);
    $html = '';
    
    curl_close($curl);
    $setting = '';

    if(isset($response['setting']) && !empty($response['setting'])){
        $setting = '&setting=' . $response['setting'];
    }
    
    $html .= '<div id="'.$response['widget_tag'].'"></div>';
    $html .= '<script src="'.$response['widget_script'].'?widget_token='.$response['widget_token'] . $setting .'"></script>';
    $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
    return $html;
}
add_shortcode('divine_natal_synastry', 'dhat_natal_synastry_shortcode');

function dapi_admin_ajax_req_callback() {

    header("Pragma: no-cache");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
    header("Content-type: text/html");

    $action = isset($_GET['acttask']) ? $_GET['acttask'] : '';

    if($action == 'verify_domain' || $action == 'get_report' || $action== 'get_first_page_data' || $action == 'get_kundali_data'
    || $action == 'get_km_report' || $action == 'get_kundali_matching_data') {

        include(DHAT_PLUGIN_PATH . '/inc/shortcodes/async-dapi-backend.php');

    } else {

        echo "Invalid async request to Horoscope and Tarot plugin";

    }

    wp_die();

}