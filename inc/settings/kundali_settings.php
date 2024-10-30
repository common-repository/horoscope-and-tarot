<?php

function dhat_kundali_settings_init() {

    add_settings_section(
        'kundali_settings_section',
        '',// Heading
        '',
        'kundali-settings'
    );
   
    register_setting(
        'kundali-settings',
        'kundali_settings_theme_color_field',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '#7B1074'
        )
    );
    
    add_settings_field(
        'kundali_settings_theme_color_field',
        __( 'Theme Color', 'horoscope-and-kundali' ),
        'dhat_kundali_settings_theme_color_field_callback',
        'kundali-settings',
        'kundali_settings_section'
    );

}
add_action( 'admin_init', 'dhat_kundali_settings_init' );

function dhat_kundali_settings_theme_color_field_callback() {
 
    $kundali_settings_theme_color_field = get_option('kundali_settings_theme_color_field');

    ?>

    <input type="text" id="colorpicker-kundali-0" name="kundali_settings_theme_color_field" class="regular-text" value="<?php echo isset($kundali_settings_theme_color_field) ? esc_attr( $kundali_settings_theme_color_field ) : ''; ?>" required/>
    
    <?php

}
?>