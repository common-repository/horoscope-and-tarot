<?php

function dhat_which_animal_are_you_reading_settings_init() {
        add_settings_section(
            'which_animal_are_you_reading_settings_section',
            '',// Heading
            '',
            'which-animal-are-you-reading-settings'
        );

        

        register_setting(
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'which_animal_are_you_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_ia_settings_text_color_field_callback',
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_section'
        );

        register_setting(
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'which_animal_are_you_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_ia_settings_font_size_field_callback',
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_section'
        );

        register_setting(
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'which_animal_are_you_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_ia_settings_theme_color_field_callback',
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_section'
        );

        register_setting(
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'which_animal_are_you_reading_settings_category_color_field',
            __( 'Button Text Color & Background Color', 'horoscope-and-tarot' ),
            'dhat_ia_settings_category_color_field_callback',
            'which-animal-are-you-reading-settings',
            'which_animal_are_you_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_which_animal_are_you_reading_settings_init' );



function dhat_ia_settings_text_color_field_callback() {
    $which_animal_are_you_text_color_field = get_option('which_animal_are_you_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-ia-1" name="which_animal_are_you_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($which_animal_are_you_text_color_field) ? esc_attr( $which_animal_are_you_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ia_settings_theme_color_field_callback() {
    $which_animal_are_you_theme_color_field = get_option('which_animal_are_you_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-ia-2" name="which_animal_are_you_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($which_animal_are_you_theme_color_field) ? esc_attr( $which_animal_are_you_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ia_settings_category_color_field_callback() {
    $which_animal_are_you_category_color_field = get_option('which_animal_are_you_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-ia-3" name="which_animal_are_you_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($which_animal_are_you_category_color_field) ? esc_attr( $which_animal_are_you_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ia_settings_font_size_field_callback() {
    $which_animal_are_you_reading_font_size_field = get_option('which_animal_are_you_reading_settings_font_size_field');
    update_option('which_animal_are_you_reading_settings_font_size_field', $which_animal_are_you_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-way-1" name="which_animal_are_you_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($which_animal_are_you_reading_font_size_field) ? esc_attr( $which_animal_are_you_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-way-1_err">Please enter valid font size</p>
    <?php 
}
?>