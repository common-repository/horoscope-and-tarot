<?php

function dhat_fortune_cookie_settings_init() {
        add_settings_section(
            'fortune_cookie_settings_section',
            '', // Heading
            '',
            'fortune-cookie-settings'
        );

        register_setting(
            'fortune-cookie-settings',
            'fortune_cookie_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'fortune_cookie_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_fc_settings_text_color_field_callback',
            'fortune-cookie-settings',
            'fortune_cookie_settings_section'
        );

        register_setting(
            'fortune-cookie-settings',
            'fortune_cookie_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'fortune_cookie_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_fc_settings_font_size_field_callback',
            'fortune-cookie-settings',
            'fortune_cookie_settings_section'
        );

        register_setting(
            'fortune-cookie-settings',
            'fortune_cookie_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'fortune_cookie_settings_theme_color_field',
            __( 'Button Background', 'horoscope-and-tarot' ),
            'dhat_fc_settings_theme_color_field_callback',
            'fortune-cookie-settings',
            'fortune_cookie_settings_section'
        );

        register_setting(
            'fortune-cookie-settings',
            'fortune_cookie_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'fortune_cookie_settings_category_color_field',
            __( 'Button Color', 'horoscope-and-tarot' ),
            'dhat_fc_settings_category_color_field_callback',
            'fortune-cookie-settings',
            'fortune_cookie_settings_section'
        );
}

add_action( 'admin_init', 'dhat_fortune_cookie_settings_init' );


function dhat_fc_settings_text_color_field_callback() {
    $fortune_cookie_text_color_field = get_option('fortune_cookie_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-fc-1" name="fortune_cookie_settings_text_color_field" class="regular-text" value="<?php echo isset($fortune_cookie_text_color_field) ? esc_attr( $fortune_cookie_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_fc_settings_theme_color_field_callback() {
    $fortune_cookie_theme_color_field = get_option('fortune_cookie_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-fc-2" name="fortune_cookie_settings_theme_color_field" class="regular-text" value="<?php echo isset($fortune_cookie_theme_color_field) ? esc_attr( $fortune_cookie_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_fc_settings_category_color_field_callback() {
    $fortune_cookie_category_color_field = get_option('fortune_cookie_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-fc-3" name="fortune_cookie_settings_category_color_field" class="regular-text" value="<?php echo isset($fortune_cookie_category_color_field) ? esc_attr( $fortune_cookie_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_fc_settings_font_size_field_callback() {
    $fortune_cookie_font_size_field = get_option('fortune_cookie_settings_font_size_field');
    update_option('fortune_cookie_settings_font_size_field', $fortune_cookie_font_size_field, false);
    ?>
    <input type="number" id="font-size-fc-1" name="fortune_cookie_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($fortune_cookie_font_size_field) ? esc_attr( $fortune_cookie_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-fc-1_err">Please enter valid font size</p>
    <?php 
}
?>