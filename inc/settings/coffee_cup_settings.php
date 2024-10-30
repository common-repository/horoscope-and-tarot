<?php

function dhat_coffee_cup_settings_init() {
        add_settings_section(
            'coffee_cup_settings_section',
            '', // Heading
            '',
            'coffee-cup-settings'
        );

        register_setting(
            'coffee-cup-settings',
            'coffee_cup_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'coffee_cup_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_cc_settings_text_color_field_callback',
            'coffee-cup-settings',
            'coffee_cup_settings_section'
        );

        register_setting(
            'coffee-cup-settings',
            'coffee_cup_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'coffee_cup_settings_font_size_field',
            __( 'Font Size <br> (Default 13)', 'horoscope-and-tarot' ),
            'dhat_cc_settings_font_size_field_callback',
            'coffee-cup-settings',
            'coffee_cup_settings_section'
        );

        register_setting(
            'coffee-cup-settings',
            'coffee_cup_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'coffee_cup_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_cc_settings_theme_color_field_callback',
            'coffee-cup-settings',
            'coffee_cup_settings_section'
        );

        register_setting(
            'coffee-cup-settings',
            'coffee_cup_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'coffee_cup_settings_category_color_field',
            __( 'Tab Color (category)', 'horoscope-and-tarot' ),
            'dhat_cc_settings_category_color_field_callback',
            'coffee-cup-settings',
            'coffee_cup_settings_section'
        );
}

add_action( 'admin_init', 'dhat_coffee_cup_settings_init' );


function dhat_cc_settings_text_color_field_callback() {
    $coffee_cup_text_color_field = get_option('coffee_cup_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-cc-1" name="coffee_cup_settings_text_color_field" class="regular-text" value="<?php echo isset($coffee_cup_text_color_field) ? esc_attr( $coffee_cup_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_cc_settings_theme_color_field_callback() {
    $coffee_cup_theme_color_field = get_option('coffee_cup_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-cc-2" name="coffee_cup_settings_theme_color_field" class="regular-text" value="<?php echo isset($coffee_cup_theme_color_field) ? esc_attr( $coffee_cup_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_cc_settings_category_color_field_callback() {
    $coffee_cup_category_color_field = get_option('coffee_cup_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-cc-3" name="coffee_cup_settings_category_color_field" class="regular-text" value="<?php echo isset($coffee_cup_category_color_field) ? esc_attr( $coffee_cup_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_cc_settings_font_size_field_callback() {
    $coffee_cup_font_size_field = get_option('coffee_cup_settings_font_size_field');
    update_option('coffee_cup_settings_font_size_field', $coffee_cup_font_size_field, false);
    ?>
    <input type="number" id="font-size-cc-1" name="coffee_cup_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($coffee_cup_font_size_field) ? esc_attr( $coffee_cup_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-cc-1_err">Please enter valid font size</p>
    <?php 
}
?>