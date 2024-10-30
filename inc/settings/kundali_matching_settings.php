<?php

function dhat_kundali_matching_settings_init() {

    add_settings_section(
        'kundali_matching_settings_section',
        '',// Heading
        '',
        'kundali-matching-settings'
    );
   
    register_setting(
        'kundali-matching-settings',
        'kundali_matching_settings_theme_color_field',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '#7B1074'
        )
    );
    
    add_settings_field(
        'kundali_matching_settings_theme_color_field',
        __( 'Theme Color', 'horoscope-and-kundali' ),
        'dhat_kundali_matching_settings_theme_color_field_callback',
        'kundali-matching-settings',
        'kundali_matching_settings_section'
    );

}
add_action( 'admin_init', 'dhat_kundali_matching_settings_init' );

function dhat_kundali_matching_settings_theme_color_field_callback() {
 
    $kundali_matching_settings_theme_color_field = get_option('kundali_matching_settings_theme_color_field');

    ?>

    <input type="text" id="colorpicker-kundali-matching-0" name="kundali_matching_settings_theme_color_field" class="regular-text" value="<?php echo isset($kundali_matching_settings_theme_color_field) ? esc_attr( $kundali_matching_settings_theme_color_field ) : ''; ?>" required/>
    
    <?php

}
?>