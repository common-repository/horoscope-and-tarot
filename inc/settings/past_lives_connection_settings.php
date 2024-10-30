<?php

function dhat_past_lives_connection_settings_init() {
        add_settings_section(
            'past_lives_connection_settings_section',
            '',// Heading
            '',
            'past-lives-connection-settings'
        );

        register_setting(
            'past-lives-connection-settings',
            'past_lives_connection_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        

        register_setting(
            'past-lives-connection-settings',
            'past_lives_connection_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'past_lives_connection_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_plc_settings_text_color_field_callback',
            'past-lives-connection-settings',
            'past_lives_connection_settings_section'
        );

        register_setting(
            'past-lives-connection-settings',
            'past_lives_connection_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'past_lives_connection_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_plc_settings_font_size_field_callback',
            'past-lives-connection-settings',
            'past_lives_connection_settings_section'
        );

        register_setting(
            'past-lives-connection-settings',
            'past_lives_connection_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'past_lives_connection_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_plc_settings_theme_color_field_callback',
            'past-lives-connection-settings',
            'past_lives_connection_settings_section'
        );

        register_setting(
            'past-lives-connection-settings',
            'past_lives_connection_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'past_lives_connection_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_plc_settings_category_color_field_callback',
            'past-lives-connection-settings',
            'past_lives_connection_settings_section'
        );
}

add_action( 'admin_init', 'dhat_past_lives_connection_settings_init' );



function dhat_plc_settings_text_color_field_callback() {
    $past_lives_connection_text_color_field = get_option('past_lives_connection_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-plc-1" name="past_lives_connection_settings_text_color_field" class="regular-text" value="<?php echo isset($past_lives_connection_text_color_field) ? esc_attr( $past_lives_connection_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_plc_settings_theme_color_field_callback() {
    $past_lives_connection_theme_color_field = get_option('past_lives_connection_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-plc-2" name="past_lives_connection_settings_theme_color_field" class="regular-text" value="<?php echo isset($past_lives_connection_theme_color_field) ? esc_attr( $past_lives_connection_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_plc_settings_category_color_field_callback() {
    $past_lives_connection_category_color_field = get_option('past_lives_connection_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-plc-3" name="past_lives_connection_settings_category_color_field" class="regular-text" value="<?php echo isset($past_lives_connection_category_color_field) ? esc_attr( $past_lives_connection_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_plc_settings_font_size_field_callback() {
    $past_lives_connection_font_size_field = get_option('past_lives_connection_settings_font_size_field');
    update_option('past_lives_connection_settings_font_size_field', $past_lives_connection_font_size_field, false);
    ?>
    <input type="number" id="font-size-plc-1" name="past_lives_connection_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($past_lives_connection_font_size_field) ? esc_attr( $past_lives_connection_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-plc-1_err">Please enter valid font size</p>
    <?php 
}
?>