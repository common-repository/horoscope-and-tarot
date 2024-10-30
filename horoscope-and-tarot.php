<?php
/**
 * Plugin Name:       Horoscope And Tarot
 * Plugin URI:        https://divineapi.com/
 * Author:            Divine API
 * Author URI:        https://divineapi.com/
 * Version:           1.2.7
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       horoscope-and-tarot
 * Description:       Divine API Horoscope & Tarot Plugin.
 */

if( !defined('ABSPATH') ) : exit(); endif;

/*
* Timezones Array
*/
$timezones = array(
    array("id"=>1, "label"=>"(GMT-12:00) International Date Line West","value"=>"-12"),
    array("id"=>2, "label"=>"(GMT-11:00) Midway Island, Samoa","value"=>"-11"),
    array("id"=>3, "label"=>"(GMT-10:00) Hawaii","value"=>"-10"),
    array("id"=>4, "label"=>"(GMT-09:00) Alaska","value"=>"-9"),
    array("id"=>5, "label"=>"(GMT-08:00) Pacific Time (US & Canada)","value"=>"-8"),
    array("id"=>6, "label"=>"(GMT-08:00) Tijuana, Baja California","value"=>"-8"),
    array("id"=>7, "label"=>"(GMT-07:00) Arizona","value"=>"-7"),
    array("id"=>8, "label"=>"(GMT-07:00) Chihuahua, La Paz, Mazatlan","value"=>"-7"),
    array("id"=>9, "label"=>"(GMT-07:00) Mountain Time (US & Canada)","value"=>"-7"),
    array("id"=>10, "label"=>"(GMT-06:00) Central America","value"=>"-6"),
    array("id"=>11, "label"=>"(GMT-06:00) Central Time (US & Canada)","value"=>"-6"),
    array("id"=>12, "label"=>"(GMT-05:00) Bogota, Lima, Quito, Rio Branco","value"=>"-5"),
    array("id"=>13, "label"=>"(GMT-05:00) Eastern Time (US & Canada)","value"=>"-5"),
    array("id"=>14, "label"=>"(GMT-05:00) Indiana (East)","value"=>"-5"),
    array("id"=>15, "label"=>"(GMT-04:00) Atlantic Time (Canada)","value"=>"-4"),
    array("id"=>16, "label"=>"(GMT-04:00) Caracas, La Paz","value"=>"-4"),
    array("id"=>17, "label"=>"(GMT-04:00) Manaus","value"=>"-4"),
    array("id"=>18, "label"=>"(GMT-04:00) Manaus","value"=>"-4"),
    array("id"=>19, "label"=>"(GMT-04:00) Manaus","value"=>"-4"),
    array("id"=>20, "label"=>"(GMT-03:30) Newfoundland","value"=>"-3.5"),
    array("id"=>21, "label"=>"(GMT-03:00) Brasilia","value"=>"-3"),
    array("id"=>22, "label"=>"(GMT-03:00) Buenos Aires, Georgetown","value"=>"-3"),
    array("id"=>23, "label"=>"(GMT-03:00) Greenland","value"=>"-3"),
    array("id"=>24, "label"=>"(GMT-03:00) Montevideo","value"=>"-3"),
    array("id"=>25, "label"=>"(GMT-02:00) Mid-Atlantic","value"=>"-2"),
    array("id"=>26, "label"=>"(GMT-01:00) Cape Verde Is.","value"=>"-1"),
    array("id"=>27, "label"=>"(GMT-01:00) Azores","value"=>"-1"),
    array("id"=>28, "label"=>"(GMT+00:00) Casablanca, Monrovia, Reykjavik","value"=>"0"),
    array("id"=>29, "label"=>"(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London","value"=>"0"),
    array("id"=>30,"label"=>"(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna","value"=>"1"),
    array("id"=>31,"label"=>"(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague","value"=>"1"),
    array("id"=>32,"label"=>"(GMT+01:00) Brussels, Copenhagen, Madrid, Paris","value"=>"1"),
    array("id"=>33,"label"=>"(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb","value"=>"1"),
    array("id"=>34,"label"=>"(GMT+01:00) West Central Africa","value"=>"1"),
    array("id"=>35,"label"=>"(GMT+02:00) Amman","value"=>"2"),
    array("id"=>36,"label"=>"(GMT+02:00) Athens, Bucharest, Istanbul","value"=>"2"),
    array("id"=>37,"label"=>"(GMT+02:00) Beirut","value"=>"2"),
    array("id"=>38,"label"=>"(GMT+02:00) Cairo","value"=>"2"),
    array("id"=>39,"label"=>"(GMT+02:00) Harare, Pretoria","value"=>"2"),
    array("id"=>40,"label"=>"(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius","value"=>"2"),
    array("id"=>41,"label"=>"(GMT+02:00) Jerusalem","value"=>"2"),
    array("id"=>42, "label"=>"(GMT+02:00) Minsk","value"=>"2"),
    array("id"=>43, "label"=>"(GMT+02:00) Windhoek","value"=>"2"),
    array("id"=>44, "label"=>"(GMT+03:00) Kuwait, Riyadh, Baghdad","value"=>"3"),
    array("id"=>45, "label"=>"(GMT+03:00) Moscow, St. Petersburg, Volgograd","value"=>"3"),
    array("id"=>46, "label"=>"(GMT+03:00) Nairobi","value"=>"3"),
    array("id"=>47, "label"=>"(GMT+03:00) Tbilisi","value"=>"3"),
    array("id"=>48, "label"=>"(GMT+03:30) Tehran","value"=>"3.5"),
    array("id"=>49, "label"=>"(GMT+04:00) Abu Dhabi, Muscat","value"=>"4"),
    array("id"=>50, "label"=>"(GMT+04:00) Baku","value"=>"4"),
    array("id"=>51, "label"=>"(GMT+04:00) Yerevan","value"=>"4"),
    array("id"=>52, "label"=>"(GMT+04:30) Kabul","value"=>"4.5"),
    array("id"=>53, "label"=>"(GMT+05:00) Yekaterinburg","value"=>"5"),
    array("id"=>54, "label"=>"(GMT+05:00) Islamabad, Karachi, Tashkent","value"=>"5"),
    array("id"=>55, "label"=>"(GMT+05:30) Sri Jayawardenapura","value"=>"5.5"),
    array("id"=>56, "label"=>"(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi","value"=>"5.5"),
    array("id"=>57, "label"=>"(GMT+05:45) Kathmandu","value"=>"5.75"),
    array("id"=>58, "label"=>"(GMT+06:00) Almaty, Novosibirsk","value"=>"6"),
    array("id"=>59, "label"=>"(GMT+06:00) Astana, Dhaka","value"=>"6"),
    array("id"=>60, "label"=>"(GMT+06:30) Yangon (Rangoon)","value"=>"6.5"),
    array("id"=>61, "label"=>"(GMT+07:00) Bangkok, Hanoi, Jakarta","value"=>"7"),
    array("id"=>62, "label"=>"(GMT+07:00) Krasnoyarsk","value"=>"7"),
    array("id"=>63, "label"=>"(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi","value"=>"8"),
    array("id"=>64, "label"=>"(GMT+08:00) Kuala Lumpur, Singapore","value"=>"8"),
    array("id"=>65, "label"=>"(GMT+08:00) Irkutsk, Ulaan Bataar","value"=>"8"),
    array("id"=>66, "label"=>"(GMT+08:00) Perth","value"=>"8"),
    array("id"=>67, "label"=>"(GMT+08:00) Taipei","value"=>"8"),
    array("id"=>68, "label"=>"(GMT+09:00) Osaka, Sapporo, Tokyo","value"=>"9"),
    array("id"=>69, "label"=>"(GMT+09:00) Seoul","value"=>"9"),
    array("id"=>70, "label"=>"(GMT+09:00) Yakutsk","value"=>"9"),
    array("id"=>71, "label"=>"(GMT+09:30) Adelaide","value"=>"9.5"),
    array("id"=>72, "label"=>"(GMT+09:30) Darwin","value"=>"9.5"),
    array("id"=>73, "label"=>"(GMT+10:00) Brisbane","value"=>"10"),
    array("id"=>74, "label"=>"(GMT+10:00) Canberra, Melbourne, Sydney","value"=>"10"),
    array("id"=>75, "label"=>"(GMT+10:00) Hobart","value"=>"10"),
    array("id"=>76, "label"=>"(GMT+10:00) Guam, Port Moresby","value"=>"10"),
    array("id"=>77, "label"=>"(GMT+10:00) Vladivostok","value"=>"10"),
    array("id"=>78, "label"=>"(GMT+11:00) Magadan, Solomon Is., New Caledonia","value"=>"11"),
    array("id"=>79, "label"=>"(GMT+12:00) Auckland, Wellington","value"=>"12"),
    array("id"=>80, "label"=>"(GMT+12:00) Fiji, Kamchatka, Marshall Is.","value"=>"12"),
    array("id"=>81, "label"=>"(GMT+13:00) Nuku alofa","value"=>"13")
);
/**
 * Define plugin constants
 */
defined( 'DHAT_PLUGIN_PATH' ) or define( 'DHAT_PLUGIN_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
defined( 'DHAT_PLUGIN_URL' ) or define( 'DHAT_PLUGIN_URL', trailingslashit( plugins_url('/', __FILE__) ) );
define ("TIMEZONES", serialize ($timezones));

/**
 * Include admin.php
 */
if( is_admin() ) {
    require_once DHAT_PLUGIN_PATH . '/admin/dhat-admin.php';
}

/**
 * Include public.php 
 */
if( !is_admin() ) {
    require_once DHAT_PLUGIN_PATH . '/public/dhat-public.php';
}

/**
 * Include Settings Page
 */
require_once DHAT_PLUGIN_PATH . '/inc/settings/settings.php';

/**
 * Include Shortcodes
 */
require_once DHAT_PLUGIN_PATH . '/inc/shortcodes/shortcodes.php';

/**
 * Include API Calls
 */
require_once DHAT_PLUGIN_PATH .'/inc/shortcodes/class_apicall.php';

register_activation_hook( __FILE__, 'horoscope_and_tarot_plugin_activate' );

function horoscope_and_tarot_plugin_activate() {

    ob_flush();
    // Save data to wp_options table

    if (!get_option('daily_panchang_settings_sun_moon_show_hide_field')) {

        add_option( 'daily_panchang_settings_sun_moon_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_sun_moon_btn_color_field', '#6052BE' );
        add_option( 'daily_panchang_settings_sun_moon_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_panchang_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_panchang_btn_color_field', '#C1C008' );
        add_option( 'daily_panchang_settings_panchang_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_lunar_month_and_samvat_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_lunar_month_and_samvat_btn_color_field', '#42C744' );
        add_option( 'daily_panchang_settings_lunar_month_and_samvat_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_rashi_and_nakshatra_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_rashi_and_nakshatra_btn_color_field', '#B949C2' );
        add_option( 'daily_panchang_settings_rashi_and_nakshatra_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_ritu_and_ayana_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_ritu_and_ayana_btn_color_field', '#C27149' );
        add_option( 'daily_panchang_settings_ritu_and_ayana_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_auspi_timings_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_auspi_timings_btn_color_field', '#F85718' );
        add_option( 'daily_panchang_settings_auspi_timings_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_in_auspi_timings_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_in_auspi_timings_btn_color_field', '#39271F' );
        add_option( 'daily_panchang_settings_in_auspi_timings_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_nivas_and_shool_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_nivas_and_shool_btn_color_field', '#3E9D82' );
        add_option( 'daily_panchang_settings_nivas_and_shool_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_chandra_and_tara_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_chandra_and_tara_btn_color_field', '#D2992C' );
        add_option( 'daily_panchang_settings_chandra_and_tara_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_other_calendar_and_epoch_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_other_calendar_and_epoch_btn_color_field', '#2CD2BB' );
        add_option( 'daily_panchang_settings_other_calendar_and_epoch_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_panchak_and_udaya_show_hide_field', 'on' );
        add_option( 'daily_panchang_settings_panchak_and_udaya_btn_color_field', '#2CD28C' );
        add_option( 'daily_panchang_settings_panchak_and_udaya_label_color_field', '#FFFFFF' );

        add_option( 'daily_panchang_settings_background_color_field', '#EDEDED' );

    }

    if (!get_option('choghadiya_settings_background_color_field')) {

        add_option( 'choghadiya_settings_background_color_field', '#EED7C9' );
        add_option( 'choghadiya_settings_day_choghadiya_background_color_field', '#EED7C9' );
        add_option( 'choghadiya_settings_day_choghadiya_text_color_field', '#ffffff' );
        add_option( 'choghadiya_settings_night_choghadiya_background_color_field', '#EED7C9' );
        add_option( 'choghadiya_settings_night_choghadiya_text_color_field', '#ffffff' );
        add_option( 'choghadiya_settings_good_color_field', '#6bb581' );
        add_option( 'choghadiya_settings_bad_color_field', '#b56b6b' );
        add_option( 'choghadiya_settings_neutral_color_field', '#6c6c6c' );
        add_option( 'choghadiya_settings_title_color_field', '#ffffff' );
        add_option( 'choghadiya_settings_timings_color_field', '#ffffff' );
        add_option( 'choghadiya_settings_button_color_field', '#af4ca2' );
        add_option( 'choghadiya_settings_button_text_color_field', '#ffffff' );

    }

    if (!get_option('horoscope_theme_no_field')) {
        //divine horoscope theme settings

        add_option( 'horoscope_theme_no_field', '1');
        add_option( 'horoscope_tabs_position_field', 'top');
        add_option( 'horoscope_buttons_position_field', 'middle');
        add_option( 'horoscope_buttons_type_field', 'rectangle');
        add_option( 'horoscope_settings_category_bg_default_color_field', '#c290cb');

    }

    if (!get_option('horoscope_settings_sign_field')) {
        //divine horoscope general settings

        add_option( 'horoscope_settings_sign_field', '2');
        add_option( 'horoscope_settings_font_size_field', '13');
        add_option( 'horoscope_settings_theme_color_field', '#D652BD');
        add_option( 'horoscope_settings_category_color_field', '#FFF');
        add_option( 'horoscope_settings_text_color_field', '#000');
        add_option( 'horoscope_buttons_with_icon_field', '');
        add_option( 'horoscope_settings_timezone_field', '56');
        
    }

    if (!get_option('kundali_settings_theme_color_field')) {
        //divine kundali shortcode settings

        add_option( 'kundali_settings_theme_color_field', '#7B1074');

    }

    if (!get_option('kundali_matching_settings_theme_color_field')) {
        //divine kundali matching shortcode settings

        add_option( 'kundali_matching_settings_theme_color_field', '#7B1074');

    }
    
}

add_action( 'upgrader_process_complete', 'horoscope_and_tarot_plugin_update', 10, 2 );

function horoscope_and_tarot_plugin_update( $upgrader_object, $options ) {

    if ( isset( $options['action'] ) && ($options['action'] === 'update' || $options['action'] === 'install') && isset( $options['plugins'] ) ) {

        foreach ( $options['plugins'] as $plugin ) {
            if ( 'horoscope-and-tarot/horoscope-and-tarot.php' === $plugin ) {
                
                if (!get_option('horoscope_theme_no_field')) {
                    //divine horoscope theme settings
            
                    add_option( 'horoscope_theme_no_field', '1');
                    add_option( 'horoscope_tabs_position_field', 'top');
                    add_option( 'horoscope_buttons_position_field', 'middle');
                    add_option( 'horoscope_buttons_type_field', 'rectangle');
                    add_option( 'horoscope_settings_category_bg_default_color_field', '#c290cb');
                }

                if (!get_option('kundali_settings_theme_color_field')) {
                    //divine kundali shortcode settings
            
                    add_option( 'kundali_settings_theme_color_field', '#7B1074');
            
                }

                if (!get_option('kundali_matching_settings_theme_color_field')) {
                    //divine kundali matching shortcode settings
            
                    add_option( 'kundali_matching_settings_theme_color_field', '#7B1074');
            
                }

            }
        }
    }
}

add_action( 'wp_ajax_nopriv_dapi_admin_ajax_req', 'dapi_admin_ajax_req_callback' );
add_action( 'wp_ajax_dapi_admin_ajax_req', 'dapi_admin_ajax_req_callback' );