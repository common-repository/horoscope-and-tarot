<?php

function dhat_daily_panchang_settings_init() {

        add_settings_section(
            'daily_panchang_background_settings_section',
            'Background',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_background_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#EDEDED'
            )
        );
        add_settings_field(
            'daily_panchang_settings_background_color_field',
            __( 'Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_background_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_background_settings_section'
        );
        

        add_settings_section(
            'daily_panchang_sun_and_moon_settings_section',
            'Sunrise & Moonrise',// Heading
            '',
            'daily-panchang-settings'
        );

        // register_setting(
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_card_field',
        //     array(
        //         'type' => 'string',
        //         'sanitize_callback' => 'sanitize_text_field',
        //         'default' => ''
        //     )
        // );
        // add_settings_field(
        //     'daily_panchang_settings_card_field',
        //     __( 'Card Image Style', 'horoscope-and-panchang' ),
        //     'dhat_dp_settings_card_field_callback',
        //     'daily-panchang-settings',
        //     'daily_tarot_settings_section'
        // );

        // register_setting(
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_text_color_field',
        //     array(
        //         'type' => 'string',
        //         'sanitize_callback' => 'sanitize_text_field',
        //         'default' => ''
        //     )
        // );
        // add_settings_field(
        //     'daily_panchang_settings_text_color_field',
        //     __( 'Text Color', 'horoscope-and-panchang' ),
        //     'dhat_dp_settings_text_color_field_callback',
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_section'
        // );

        // register_setting(
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_font_size_field',
        //     array(
        //         'type' => 'integer',
        //         'sanitize_callback' => 'sanitize_text_field',
        //         'default' => '13'
        //     )
        // );
        // add_settings_field(
        //     'daily_panchang_settings_font_size_field',
        //     __( 'Font Size <br> (Default 13)', 'horoscope-and-panchang' ),
        //     'dhat_dp_settings_font_size_field_callback',
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_section'
        // );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_sun_moon_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_sun_moon_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_sun_moon_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_sun_and_moon_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_sun_moon_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#6052BE'
            )
        );
        add_settings_field(
            'daily_panchang_settings_sun_moon_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_sun_moon_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_sun_and_moon_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_sun_moon_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_sun_moon_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_sun_moon_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_sun_and_moon_settings_section'
        );
// ******************
        add_settings_section(
            'daily_panchang_settings_section',
            'Panchang',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_panchang_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_panchang_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_panchang_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_panchang_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#C1C008'
            )
        );
        add_settings_field(
            'daily_panchang_settings_panchang_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_panchang_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_panchang_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_panchang_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_panchang_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_settings_section'
        );

        add_settings_section(
            'daily_panchang_lunar_month_and_samvat_settings_section',
            'Lunar Month & Samvat',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_lunar_month_and_samvat_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_lunar_month_and_samvat_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_lunar_month_and_samvat_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_lunar_month_and_samvat_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_lunar_month_and_samvat_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#42C744'
            )
        );
        add_settings_field(
            'daily_panchang_settings_lunar_month_and_samvat_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_lunar_month_and_samvat_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_lunar_month_and_samvat_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_lunar_month_and_samvat_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_lunar_month_and_samvat_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_lunar_month_and_samvat_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_lunar_month_and_samvat_settings_section'
        );

        add_settings_section(
            'daily_panchang_rashi_and_nakshatra_settings_section',
            'Rashi & Nakshatra',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_rashi_and_nakshatra_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_rashi_and_nakshatra_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_rashi_and_nakshatra_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_rashi_and_nakshatra_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_rashi_and_nakshatra_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#B949C2'
            )
        );
        add_settings_field(
            'daily_panchang_settings_rashi_and_nakshatra_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_rashi_and_nakshatra_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_rashi_and_nakshatra_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_rashi_and_nakshatra_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_rashi_and_nakshatra_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_rashi_and_nakshatra_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_rashi_and_nakshatra_settings_section'
        );

        add_settings_section(
            'daily_panchang_ritu_and_ayana_settings_section',
            'Ritu & Ayana',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_ritu_and_ayana_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_ritu_and_ayana_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_ritu_and_ayana_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_ritu_and_ayana_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_ritu_and_ayana_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#C27149'
            )
        );
        add_settings_field(
            'daily_panchang_settings_ritu_and_ayana_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_ritu_and_ayana_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_ritu_and_ayana_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_ritu_and_ayana_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_ritu_and_ayana_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_ritu_and_ayana_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_ritu_and_ayana_settings_section'
        );

        add_settings_section(
            'daily_panchang_auspi_timings_settings_section',
            'Auspicious Timings',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_auspi_timings_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_auspi_timings_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_auspi_timings_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_auspi_timings_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_auspi_timings_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#F85718'
            )
        );
        add_settings_field(
            'daily_panchang_settings_auspi_timings_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_auspi_timings_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_auspi_timings_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_auspi_timings_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_auspi_timings_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_auspi_timings_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_auspi_timings_settings_section'
        );

        add_settings_section(
            'daily_panchang_in_auspi_timings_settings_section',
            'Inauspicious Timings',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_in_auspi_timings_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_in_auspi_timings_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_in_auspi_timings_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_in_auspi_timings_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_in_auspi_timings_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#39271F'
            )
        );
        add_settings_field(
            'daily_panchang_settings_in_auspi_timings_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_in_auspi_timings_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_in_auspi_timings_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_in_auspi_timings_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_in_auspi_timings_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_in_auspi_timings_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_in_auspi_timings_settings_section'
        );

        add_settings_section(
            'daily_panchang_nivas_and_shool_settings_section',
            'Nivas & Shool',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_nivas_and_shool_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_nivas_and_shool_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_nivas_and_shool_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_nivas_and_shool_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_nivas_and_shool_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#3E9D82'
            )
        );
        add_settings_field(
            'daily_panchang_settings_nivas_and_shool_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_nivas_and_shool_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_nivas_and_shool_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_nivas_and_shool_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_nivas_and_shool_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_nivas_and_shool_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_nivas_and_shool_settings_section'
        );

        add_settings_section(
            'daily_panchang_chandra_and_tara_settings_section',
            'Chandrabalam & Tarabalam',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_chandra_and_tara_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_chandra_and_tara_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_chandra_and_tara_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_chandra_and_tara_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_chandra_and_tara_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#D2992C'
            )
        );
        add_settings_field(
            'daily_panchang_settings_chandra_and_tara_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_chandra_and_tara_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_chandra_and_tara_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_chandra_and_tara_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_chandra_and_tara_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_chandra_and_tara_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_chandra_and_tara_settings_section'
        );

        add_settings_section(
            'daily_panchang_other_calendars_and_epoch_settings_section',
            'Other Calendars & Epoch',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_other_calendar_and_epoch_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_other_calendar_and_epoch_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_other_calendar_and_epoch_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_other_calendars_and_epoch_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_other_calendar_and_epoch_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#2CD2BB'
            )
        );
        add_settings_field(
            'daily_panchang_settings_other_calendar_and_epoch_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_other_calendar_and_epoch_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_other_calendars_and_epoch_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_other_calendar_and_epoch_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_other_calendar_and_epoch_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_other_calendar_and_epoch_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_other_calendars_and_epoch_settings_section'
        );

        add_settings_section(
            'daily_panchang_panchak_and_udaya_settings_section',
            'Panchaka Rahita Muhurta & Udaya Lagna',// Heading
            '',
            'daily-panchang-settings'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_panchak_and_udaya_show_hide_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => true
            )
        );
        add_settings_field(
            'daily_panchang_settings_panchak_and_udaya_show_hide_field',
            __( 'Show Section?', 'horoscope-and-panchang' ),
            'dhat_dp_settings_panchank_and_udaya_show_hide_field_callback',
            'daily-panchang-settings',
            'daily_panchang_panchak_and_udaya_settings_section'
        );
        
        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_panchak_and_udaya_btn_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#2CD28C'
            )
        );
        add_settings_field(
            'daily_panchang_settings_panchak_and_udaya_btn_color_field',
            __( 'Section Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_panchank_and_udaya_btn_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_panchak_and_udaya_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'daily_panchang_settings_panchak_and_udaya_label_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFFFFF'
            )
        );
        add_settings_field(
            'daily_panchang_settings_panchak_and_udaya_label_color_field',
            __( 'Label Color', 'horoscope-and-panchang' ),
            'dhat_dp_settings_panchak_and_udaya_label_color_field_callback',
            'daily-panchang-settings',
            'daily_panchang_panchak_and_udaya_settings_section'
        );

        // register_setting(
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_category_color_field',
        //     array(
        //         'type' => 'string',
        //         'sanitize_callback' => 'sanitize_text_field',
        //         'default' => ''
        //     )
        // );
        // add_settings_field(
        //     'daily_panchang_settings_category_color_field',
        //     __( 'Tab Text Color (category)', 'horoscope-and-panchang' ),
        //     'dhat_dp_settings_category_color_field_callback',
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_section'
        // );

        // register_setting(
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_timezone_field',
        //     array(
        //         'type' => 'string',
        //         'sanitize_callback' => 'sanitize_text_field',
        //         'default' => ''
        //     )
        // );
        // add_settings_field(
        //     'daily_panchang_settings_timezone_field',
        //     __( 'Select Timezone', 'horoscope-and-panchang' ),
        //     'dhat_dp_settings_timezone_field_callback',
        //     'daily-panchang-settings',
        //     'daily_panchang_settings_section'
        // );
        add_settings_section(
            'festivals_background_settings_section',
            'Festivals',// Heading
            '',
            'daily-panchang-settings'
        );

        // register_setting(
        //     'daily-panchang-settings',
        //     'festivals_settings_background_color_field',
        //     array(
        //         'type' => 'string',
        //         'sanitize_callback' => 'sanitize_text_field',
        //         'default' => '#EDEDED'
        //     )
        // );
        // add_settings_field(
        //     'festivals_settings_background_color_field',
        //     __( 'Color', 'horoscope-and-panchang' ),
        //     'dhat_festivals_settings_background_color_field_callback',
        //     'daily-panchang-settings',
        //     'festivals_background_settings_section'
        // );

        // add_settings_section(
        //     'festivals_background_settings_section',
        //     'Background',// Heading
        //     '',
        //     'daily-panchang-settings'
        // );

        register_setting(
            'daily-panchang-settings',
            'festivals_settings_background_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#BADAAB'
            )
        );
        add_settings_field(
            'festivals_settings_background_color_field',
            __( 'Background Color', 'horoscope-and-panchang' ),
            'dhat_festivals_settings_background_color_field_callback',
            'daily-panchang-settings',
            'festivals_background_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'festivals_settings_primary_badge_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#E09D40'
            )
        );
        add_settings_field(
            'festivals_settings_primary_badge_color_field',
            __( 'Primary Badge Color', 'horoscope-and-panchang' ),
            'dhat_festivals_settings_primary_badge_color_field_callback',
            'daily-panchang-settings',
            'festivals_background_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'festivals_settings_secondary_badge_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#CA90EE'
            )
        );
        add_settings_field(
            'festivals_settings_secondary_badge_color_field',
            __( 'Secondary Badge Color', 'horoscope-and-panchang' ),
            'dhat_festivals_settings_secondary_badge_color_field_callback',
            'daily-panchang-settings',
            'festivals_background_settings_section'
        );

        register_setting(
            'daily-panchang-settings',
            'festivals_settings_loader_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#6052BE'
            )
        );
        add_settings_field(
            'festivals_settings_loader_color_field',
            __( 'Loader Color', 'horoscope-and-panchang' ),
            'dhat_festivals_settings_loader_color_field_callback',
            'daily-panchang-settings',
            'festivals_background_settings_section'
        );
}

add_action( 'admin_init', 'dhat_daily_panchang_settings_init' );

function dhat_dp_settings_timezone_field_callback() {
    $daily_panchang_settings_timezone_field = get_option('daily_panchang_settings_timezone_field');
    if($daily_panchang_settings_timezone_field == "")
    {
       $daily_panchang_settings_timezone_field = '5.5'; 
    }
    ?>
    <select class="regular-text" name="daily_panchang_settings_timezone_field" id="divine-dp-timezone-input" required>
        <option value=""> -- Select --</option>
        <?php foreach(unserialize(TIMEZONES) as $zone): ?>
            <option value="<?= $zone['id']; ?>" gmt="<?= $zone['value']; ?>" <?= ($zone['id']==$daily_panchang_settings_timezone_field ? 'selected':''); ?>><?= $zone['label']; ?></option>
        <?php endforeach;?>
    </select>
    <?php 
}

function dhat_dp_settings_background_color_field_callback() {

    $daily_panchang_settings_background_color_field = get_option('daily_panchang_settings_background_color_field');

    ?>

    <input type="text" id="colorpicker-dp-0" name="daily_panchang_settings_background_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_background_color_field) ? esc_attr( $daily_panchang_settings_background_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_sun_moon_btn_color_field_callback() {

    $daily_panchang_settings_sun_moon_btn_color_field = get_option('daily_panchang_settings_sun_moon_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-1" name="daily_panchang_settings_sun_moon_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_sun_moon_btn_color_field) ? esc_attr( $daily_panchang_settings_sun_moon_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_panchang_btn_color_field_callback() {

    $daily_panchang_settings_panchang_btn_color_field = get_option('daily_panchang_settings_panchang_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-2" name="daily_panchang_settings_panchang_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_panchang_btn_color_field) ? esc_attr( $daily_panchang_settings_panchang_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_lunar_month_and_samvat_btn_color_field_callback() {

    $daily_panchang_settings_lunar_month_and_samvat_btn_color_field = get_option('daily_panchang_settings_lunar_month_and_samvat_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-3" name="daily_panchang_settings_lunar_month_and_samvat_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_lunar_month_and_samvat_btn_color_field) ? esc_attr( $daily_panchang_settings_lunar_month_and_samvat_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_rashi_and_nakshatra_btn_color_field_callback() {

    $daily_panchang_settings_rashi_and_nakshatra_btn_color_field = get_option('daily_panchang_settings_rashi_and_nakshatra_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-4" name="daily_panchang_settings_rashi_and_nakshatra_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_rashi_and_nakshatra_btn_color_field) ? esc_attr( $daily_panchang_settings_rashi_and_nakshatra_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_ritu_and_ayana_btn_color_field_callback() {

    $daily_panchang_settings_ritu_and_ayana_btn_color_field = get_option('daily_panchang_settings_ritu_and_ayana_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-5" name="daily_panchang_settings_ritu_and_ayana_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_ritu_and_ayana_btn_color_field) ? esc_attr( $daily_panchang_settings_ritu_and_ayana_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_auspi_timings_btn_color_field_callback() {

    $daily_panchang_settings_auspi_timings_btn_color_field = get_option('daily_panchang_settings_auspi_timings_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-6" name="daily_panchang_settings_auspi_timings_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_auspi_timings_btn_color_field) ? esc_attr( $daily_panchang_settings_auspi_timings_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_in_auspi_timings_btn_color_field_callback() {

    $daily_panchang_settings_in_auspi_timings_btn_color_field = get_option('daily_panchang_settings_in_auspi_timings_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-7" name="daily_panchang_settings_in_auspi_timings_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_in_auspi_timings_btn_color_field) ? esc_attr( $daily_panchang_settings_in_auspi_timings_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_nivas_and_shool_btn_color_field_callback() {

    $daily_panchang_settings_nivas_and_shool_btn_color_field = get_option('daily_panchang_settings_nivas_and_shool_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-8" name="daily_panchang_settings_nivas_and_shool_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_nivas_and_shool_btn_color_field) ? esc_attr( $daily_panchang_settings_nivas_and_shool_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_chandra_and_tara_btn_color_field_callback() {

    $daily_panchang_settings_chandra_and_tara_btn_color_field = get_option('daily_panchang_settings_chandra_and_tara_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-9" name="daily_panchang_settings_chandra_and_tara_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_chandra_and_tara_btn_color_field) ? esc_attr( $daily_panchang_settings_chandra_and_tara_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_other_calendar_and_epoch_btn_color_field_callback() {

    $daily_panchang_settings_other_calendar_and_epoch_btn_color_field = get_option('daily_panchang_settings_other_calendar_and_epoch_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-10" name="daily_panchang_settings_other_calendar_and_epoch_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_other_calendar_and_epoch_btn_color_field) ? esc_attr( $daily_panchang_settings_other_calendar_and_epoch_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_panchank_and_udaya_btn_color_field_callback() {

    $daily_panchang_settings_panchak_and_udaya_btn_color_field = get_option('daily_panchang_settings_panchak_and_udaya_btn_color_field');

    ?>

    <input type="text" id="colorpicker-dp-11" name="daily_panchang_settings_panchak_and_udaya_btn_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_panchak_and_udaya_btn_color_field) ? esc_attr( $daily_panchang_settings_panchak_and_udaya_btn_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_sun_moon_label_color_field_callback() {

    $daily_panchang_settings_sun_moon_label_color_field = get_option('daily_panchang_settings_sun_moon_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-12" name="daily_panchang_settings_sun_moon_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_sun_moon_label_color_field) ? esc_attr( $daily_panchang_settings_sun_moon_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_panchang_label_color_field_callback() {

    $daily_panchang_settings_panchang_label_color_field = get_option('daily_panchang_settings_panchang_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-13" name="daily_panchang_settings_panchang_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_panchang_label_color_field) ? esc_attr( $daily_panchang_settings_panchang_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_lunar_month_and_samvat_label_color_field_callback() {

    $daily_panchang_settings_lunar_month_and_samvat_label_color_field = get_option('daily_panchang_settings_lunar_month_and_samvat_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-14" name="daily_panchang_settings_lunar_month_and_samvat_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_lunar_month_and_samvat_label_color_field) ? esc_attr( $daily_panchang_settings_lunar_month_and_samvat_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_rashi_and_nakshatra_label_color_field_callback() {

    $daily_panchang_settings_rashi_and_nakshatra_label_color_field = get_option('daily_panchang_settings_rashi_and_nakshatra_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-15" name="daily_panchang_settings_rashi_and_nakshatra_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_rashi_and_nakshatra_label_color_field) ? esc_attr( $daily_panchang_settings_rashi_and_nakshatra_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_ritu_and_ayana_label_color_field_callback() {

    $daily_panchang_settings_ritu_and_ayana_label_color_field = get_option('daily_panchang_settings_ritu_and_ayana_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-16" name="daily_panchang_settings_ritu_and_ayana_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_ritu_and_ayana_label_color_field) ? esc_attr( $daily_panchang_settings_ritu_and_ayana_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_auspi_timings_label_color_field_callback() {

    $daily_panchang_settings_auspi_timings_label_color_field = get_option('daily_panchang_settings_auspi_timings_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-17" name="daily_panchang_settings_auspi_timings_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_auspi_timings_label_color_field) ? esc_attr( $daily_panchang_settings_auspi_timings_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_in_auspi_timings_label_color_field_callback() {

    $daily_panchang_settings_in_auspi_timings_label_color_field = get_option('daily_panchang_settings_in_auspi_timings_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-18" name="daily_panchang_settings_in_auspi_timings_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_in_auspi_timings_label_color_field) ? esc_attr( $daily_panchang_settings_in_auspi_timings_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_nivas_and_shool_label_color_field_callback() {

    $daily_panchang_settings_nivas_and_shool_label_color_field = get_option('daily_panchang_settings_nivas_and_shool_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-19" name="daily_panchang_settings_nivas_and_shool_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_nivas_and_shool_label_color_field) ? esc_attr( $daily_panchang_settings_nivas_and_shool_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_chandra_and_tara_label_color_field_callback () {

    $daily_panchang_settings_chandra_and_tara_label_color_field = get_option('daily_panchang_settings_chandra_and_tara_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-20" name="daily_panchang_settings_chandra_and_tara_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_chandra_and_tara_label_color_field) ? esc_attr( $daily_panchang_settings_chandra_and_tara_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_other_calendar_and_epoch_label_color_field_callback() {

    $daily_panchang_settings_other_calendar_and_epoch_label_color_field = get_option('daily_panchang_settings_other_calendar_and_epoch_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-21" name="daily_panchang_settings_other_calendar_and_epoch_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_other_calendar_and_epoch_label_color_field) ? esc_attr( $daily_panchang_settings_other_calendar_and_epoch_label_color_field ) : ''; ?>" required/>
    <hr class="dapi-p-hr">
    <?php

}

function dhat_dp_settings_panchak_and_udaya_label_color_field_callback() {

    $daily_panchang_settings_panchak_and_udaya_label_color_field = get_option('daily_panchang_settings_panchak_and_udaya_label_color_field');

    ?>

    <input type="text" id="colorpicker-dp-22" name="daily_panchang_settings_panchak_and_udaya_label_color_field" class="regular-text" value="<?php echo isset($daily_panchang_settings_panchak_and_udaya_label_color_field) ? esc_attr( $daily_panchang_settings_panchak_and_udaya_label_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_dp_settings_sun_moon_show_hide_field_callback() {

    $daily_panchang_settings_sun_moon_show_hide_field = get_option('daily_panchang_settings_sun_moon_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-1" name="daily_panchang_settings_sun_moon_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_sun_moon_show_hide_field) && esc_attr( $daily_panchang_settings_sun_moon_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_panchang_show_hide_field_callback() {

    $daily_panchang_settings_panchang_show_hide_field = get_option('daily_panchang_settings_panchang_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-2" name="daily_panchang_settings_panchang_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_panchang_show_hide_field) && esc_attr( $daily_panchang_settings_panchang_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_lunar_month_and_samvat_show_hide_field_callback() {

    $daily_panchang_settings_lunar_month_and_samvat_show_hide_field = get_option('daily_panchang_settings_lunar_month_and_samvat_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-3" name="daily_panchang_settings_lunar_month_and_samvat_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_lunar_month_and_samvat_show_hide_field) && esc_attr( $daily_panchang_settings_lunar_month_and_samvat_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_rashi_and_nakshatra_show_hide_field_callback() {

    $daily_panchang_settings_rashi_and_nakshatra_show_hide_field = get_option('daily_panchang_settings_rashi_and_nakshatra_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-4" name="daily_panchang_settings_rashi_and_nakshatra_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_rashi_and_nakshatra_show_hide_field) && esc_attr( $daily_panchang_settings_rashi_and_nakshatra_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_ritu_and_ayana_show_hide_field_callback() {

    $daily_panchang_settings_ritu_and_ayana_show_hide_field = get_option('daily_panchang_settings_ritu_and_ayana_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-5" name="daily_panchang_settings_ritu_and_ayana_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_ritu_and_ayana_show_hide_field) && esc_attr( $daily_panchang_settings_ritu_and_ayana_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_auspi_timings_show_hide_field_callback() {

    $daily_panchang_settings_auspi_timings_show_hide_field = get_option('daily_panchang_settings_auspi_timings_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-6" name="daily_panchang_settings_auspi_timings_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_auspi_timings_show_hide_field) && esc_attr( $daily_panchang_settings_auspi_timings_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_in_auspi_timings_show_hide_field_callback() {

    $daily_panchang_settings_in_auspi_timings_show_hide_field = get_option('daily_panchang_settings_in_auspi_timings_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-7" name="daily_panchang_settings_in_auspi_timings_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_in_auspi_timings_show_hide_field) && esc_attr( $daily_panchang_settings_in_auspi_timings_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_nivas_and_shool_show_hide_field_callback() {

    $daily_panchang_settings_nivas_and_shool_show_hide_field = get_option('daily_panchang_settings_nivas_and_shool_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-8" name="daily_panchang_settings_nivas_and_shool_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_nivas_and_shool_show_hide_field) && esc_attr( $daily_panchang_settings_nivas_and_shool_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_chandra_and_tara_show_hide_field_callback() {

    $daily_panchang_settings_chandra_and_tara_show_hide_field = get_option('daily_panchang_settings_chandra_and_tara_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-9" name="daily_panchang_settings_chandra_and_tara_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_chandra_and_tara_show_hide_field) && esc_attr( $daily_panchang_settings_chandra_and_tara_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_other_calendar_and_epoch_show_hide_field_callback() {

    $daily_panchang_settings_other_calendar_and_epoch_show_hide_field = get_option('daily_panchang_settings_other_calendar_and_epoch_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-10" name="daily_panchang_settings_other_calendar_and_epoch_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_other_calendar_and_epoch_show_hide_field) && esc_attr( $daily_panchang_settings_other_calendar_and_epoch_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_dp_settings_panchank_and_udaya_show_hide_field_callback() {

    $daily_panchang_settings_panchak_and_udaya_show_hide_field = get_option('daily_panchang_settings_panchak_and_udaya_show_hide_field');
    
    ?>

    <input type="checkbox" id="showhide-11" name="daily_panchang_settings_panchak_and_udaya_show_hide_field" class="regular-text" <?php echo (isset($daily_panchang_settings_panchak_and_udaya_show_hide_field) && esc_attr( $daily_panchang_settings_panchak_and_udaya_show_hide_field ) == true) ? 'checked' : ''; ?>/>
    
    <?php

}

function dhat_festivals_settings_background_color_field_callback() {

    $festivals_settings_background_color_field = get_option('festivals_settings_background_color_field');

    ?>

    <input type="text" id="colorpicker-festival-0" name="festivals_settings_background_color_field" class="regular-text" value="<?php echo isset($festivals_settings_background_color_field) ? esc_attr( $festivals_settings_background_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_festivals_settings_primary_badge_color_field_callback() {

    $festivals_settings_primary_badge_color_field = get_option('festivals_settings_primary_badge_color_field');

    ?>

    <input type="text" id="colorpicker-festival-1" name="festivals_settings_primary_badge_color_field" class="regular-text" value="<?php echo isset($festivals_settings_primary_badge_color_field) ? esc_attr( $festivals_settings_primary_badge_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_festivals_settings_secondary_badge_color_field_callback() {

    $festivals_settings_secondary_badge_color_field = get_option('festivals_settings_secondary_badge_color_field');

    ?>

    <input type="text" id="colorpicker-festival-2" name="festivals_settings_secondary_badge_color_field" class="regular-text" value="<?php echo isset($festivals_settings_secondary_badge_color_field) ? esc_attr( $festivals_settings_secondary_badge_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_festivals_settings_loader_color_field_callback() {

    $festivals_settings_loader_color_field = get_option('festivals_settings_loader_color_field');

    ?>

    <input type="text" id="colorpicker-festival-3" name="festivals_settings_loader_color_field" class="regular-text" value="<?php echo isset($festivals_settings_loader_color_field) ? esc_attr( $festivals_settings_loader_color_field ) : ''; ?>" required/>
    
    <?php

}

?>
