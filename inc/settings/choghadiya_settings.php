<?php

function dhat_choghadiya_settings_init() {

        // add_settings_section(
        //     'choghadiya_background_settings_section',
        //     'Background',// Heading
        //     '',
        //     'choghadiya-settings'
        // );

        add_settings_section(
            'choghadiya_settings_section',
            '',// Heading
            '',
            'choghadiya-settings'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_background_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#EED7C9'
            )
        );
        add_settings_field(
            'choghadiya_settings_background_color_field',
            __( 'Background Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_background_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_day_choghadiya_background_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#EED7C9'
            )
        );
        add_settings_field(
            'choghadiya_settings_day_choghadiya_background_color_field',
            __( 'Day Choghadiya Background Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_day_choghadiya_background_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_day_choghadiya_text_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#ffffff'
            )
        );
        add_settings_field(
            'choghadiya_settings_day_choghadiya_text_color_field',
            __( 'Day Choghadiya Text Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_day_choghadiya_text_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_night_choghadiya_background_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#EED7C9'
            )
        );
        add_settings_field(
            'choghadiya_settings_night_choghadiya_background_color_field',
            __( 'Night Choghadiya Background Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_night_choghadiya_background_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_night_choghadiya_text_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#ffffff'
            )
        );
        add_settings_field(
            'choghadiya_settings_night_choghadiya_text_color_field',
            __( 'Night Choghadiya Text Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_night_choghadiya_text_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );
        
        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_good_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#6bb581'
            )
        );
        add_settings_field(
            'choghadiya_settings_good_color_field',
            __( 'Good Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_good_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_bad_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#b56b6b'
            )
        );
        add_settings_field(
            'choghadiya_settings_bad_color_field',
            __( 'Bad Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_bad_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_neutral_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#6c6c6c'
            )
        );
        add_settings_field(
            'choghadiya_settings_neutral_color_field',
            __( 'Neutral Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_neutral_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_title_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#ffffff'
            )
        );
        add_settings_field(
            'choghadiya_settings_title_color_field',
            __( 'Title Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_title_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_timings_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#ffffff'
            )
        );
        add_settings_field(
            'choghadiya_settings_timings_color_field',
            __( 'Timigs Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_timings_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_button_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#af4ca2'
            )
        );
        add_settings_field(
            'choghadiya_settings_button_color_field',
            __( 'Button Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_button_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

        register_setting(
            'choghadiya-settings',
            'choghadiya_settings_button_text_color_field',
            array(
                'type' => 'boolean',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#ffffff'
            )
        );
        add_settings_field(
            'choghadiya_settings_button_text_color_field',
            __( 'Button Text Color', 'horoscope-and-choghadiya' ),
            'dhat_choghadiya_settings_button_text_color_field_callback',
            'choghadiya-settings',
            'choghadiya_settings_section'
        );

}

add_action( 'admin_init', 'dhat_choghadiya_settings_init' );


function dhat_choghadiya_settings_background_color_field_callback() {

    $choghadiya_settings_background_color_field = get_option('choghadiya_settings_background_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-0" name="choghadiya_settings_background_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_background_color_field) ? esc_attr( $choghadiya_settings_background_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_good_color_field_callback() {

    $choghadiya_settings_good_color_field = get_option('choghadiya_settings_good_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-1" name="choghadiya_settings_good_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_good_color_field) ? esc_attr( $choghadiya_settings_good_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_bad_color_field_callback() {

    $choghadiya_settings_bad_color_field = get_option('choghadiya_settings_bad_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-2" name="choghadiya_settings_bad_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_bad_color_field) ? esc_attr( $choghadiya_settings_bad_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_neutral_color_field_callback() {

    $choghadiya_settings_neutral_color_field = get_option('choghadiya_settings_neutral_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-3" name="choghadiya_settings_neutral_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_neutral_color_field) ? esc_attr( $choghadiya_settings_neutral_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_title_color_field_callback() {

    $choghadiya_settings_title_color_field = get_option('choghadiya_settings_title_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-4" name="choghadiya_settings_title_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_title_color_field) ? esc_attr( $choghadiya_settings_title_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_timings_color_field_callback() {

    $choghadiya_settings_timings_color_field = get_option('choghadiya_settings_timings_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-5" name="choghadiya_settings_timings_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_timings_color_field) ? esc_attr( $choghadiya_settings_timings_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_button_color_field_callback() {

    $choghadiya_settings_button_color_field = get_option('choghadiya_settings_button_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-6" name="choghadiya_settings_button_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_button_color_field) ? esc_attr( $choghadiya_settings_button_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_button_text_color_field_callback() {

    $choghadiya_settings_button_text_color_field = get_option('choghadiya_settings_button_text_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-7" name="choghadiya_settings_button_text_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_button_text_color_field) ? esc_attr( $choghadiya_settings_button_text_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_day_choghadiya_background_color_field_callback() {

    $choghadiya_settings_day_choghadiya_background_color_field = get_option('choghadiya_settings_day_choghadiya_background_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-8" name="choghadiya_settings_day_choghadiya_background_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_day_choghadiya_background_color_field) ? esc_attr( $choghadiya_settings_day_choghadiya_background_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_day_choghadiya_text_color_field_callback() {

    $choghadiya_settings_day_choghadiya_text_color_field = get_option('choghadiya_settings_day_choghadiya_text_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-9" name="choghadiya_settings_day_choghadiya_text_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_day_choghadiya_text_color_field) ? esc_attr( $choghadiya_settings_day_choghadiya_text_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_night_choghadiya_background_color_field_callback() {

    $choghadiya_settings_night_choghadiya_background_color_field = get_option('choghadiya_settings_night_choghadiya_background_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-10" name="choghadiya_settings_night_choghadiya_background_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_night_choghadiya_background_color_field) ? esc_attr( $choghadiya_settings_night_choghadiya_background_color_field ) : ''; ?>" required/>
    
    <?php

}

function dhat_choghadiya_settings_night_choghadiya_text_color_field_callback() {

    $choghadiya_settings_night_choghadiya_text_color_field = get_option('choghadiya_settings_night_choghadiya_text_color_field');

    ?>

    <input type="text" id="colorpicker-choghadiya-11" name="choghadiya_settings_night_choghadiya_text_color_field" class="regular-text" value="<?php echo isset($choghadiya_settings_night_choghadiya_text_color_field) ? esc_attr( $choghadiya_settings_night_choghadiya_text_color_field ) : ''; ?>" required/>
    
    <?php

}

?>
