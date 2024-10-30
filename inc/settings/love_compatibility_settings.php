<?php

function dhat_love_compatibility_settings_init() {
        add_settings_section(
            'love_compatibility_settings_section',
            '', // Heading
            '',
            'love-compatibility-settings'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_sign_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'love_compatibility_settings_sign_field',
            __( 'Zodiac Sign Style', 'horoscope-and-tarot' ),
            'dhat_lc_settings_sign_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'love_compatibility_settings_theme_color_field',
            __( 'Test Another Match Button Background Color', 'horoscope-and-tarot' ),
            'dhat_lc_settings_theme_color_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'love_compatibility_settings_category_color_field',
            __( 'Test Another Match Button Text Color', 'horoscope-and-tarot' ),
            'dhat_lc_settings_category_color_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'love_compatibility_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_lc_settings_text_color_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'love_compatibility_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_lc_settings_font_size_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_general_heart_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'love_compatibility_settings_general_heart_color_field',
            __( 'General Heart Color', 'horoscope-and-tarot' ),
            'dhat_lc_settings_general_heart_color_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_communication_heart_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'love_compatibility_settings_communication_heart_color_field',
            __( 'Communication Heart Color', 'horoscope-and-tarot' ),
            'dhat_lc_settings_communication_heart_color_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );

        register_setting(
            'love-compatibility-settings',
            'love_compatibility_settings_sex_heart_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'love_compatibility_settings_sex_heart_color_field',
            __( 'Sex Heart Color', 'horoscope-and-tarot' ),
            'dhat_lc_settings_sex_heart_color_field_callback',
            'love-compatibility-settings',
            'love_compatibility_settings_section'
        );
}

add_action( 'admin_init', 'dhat_love_compatibility_settings_init' ); 

function dhat_lc_settings_sign_field_callback() {
    $love_compatibility_settings_sign_field = get_option('love_compatibility_settings_sign_field');
    ?>
        <div class="divine__theme__card" id="divine-lc-sign-input">
            <!-- <h6>Select Zodiac Icons</h6> -->
            

            <label>
                <input type="radio" name="love_compatibility_settings_sign_field" value="1" <?= ($love_compatibility_settings_sign_field == 1 ? 'checked' : ''); ?>>
                <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/Aquarius-1.png'; ?>">
            </label>

            <label>
                <input type="radio" name="love_compatibility_settings_sign_field" value="2" <?= ($love_compatibility_settings_sign_field == 2 ? 'checked' : ''); ?>>
                <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/Aquarius.png'; ?>">
            </label>

            <label>
                <input type="radio" name="love_compatibility_settings_sign_field" value="3" <?= ($love_compatibility_settings_sign_field == 3 ? 'checked' : ''); ?>>
                <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/Aquarius-2.png'; ?>">
            </label>
        </div>  
    <?php 
}


function dhat_lc_settings_theme_color_field_callback() {
    $love_compatibility_theme_color_field = get_option('love_compatibility_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-lc-2" name="love_compatibility_settings_theme_color_field" class="regular-text" value="<?php echo isset($love_compatibility_theme_color_field) ? esc_attr( $love_compatibility_theme_color_field ) : '#D652BD'; ?>"/>
    <?php 
}

function dhat_lc_settings_category_color_field_callback() {
    $love_compatibility_category_color_field = get_option('love_compatibility_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-lc-3" name="love_compatibility_settings_category_color_field" class="regular-text" value="<?php echo isset($love_compatibility_category_color_field) ? esc_attr( $love_compatibility_category_color_field ) : '#fff'; ?>"/>
    <?php 
}
function dhat_lc_settings_text_color_field_callback() {
    $love_compatibility_text_color_field = get_option('love_compatibility_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-lc-7" name="love_compatibility_settings_text_color_field" class="regular-text" value="<?php echo isset($love_compatibility_text_color_field) ? esc_attr( $love_compatibility_text_color_field ) : '#000'; ?>"/>
    <?php 
}
function dhat_lc_settings_general_heart_color_field_callback() {
    $love_compatibility_general_heart_color_field = get_option('love_compatibility_settings_general_heart_color_field');
    ?>
    <input type="text" id="colorpicker-lc-4" name="love_compatibility_settings_general_heart_color_field" class="regular-text" value="<?php echo isset($love_compatibility_general_heart_color_field) ? esc_attr( $love_compatibility_general_heart_color_field ) : '#ed681e'; ?>"/>
    <?php 
}
function dhat_lc_settings_communication_heart_color_field_callback() {
    $love_compatibility_communication_heart_color_field = get_option('love_compatibility_settings_communication_heart_color_field');
    ?>
    <input type="text" id="colorpicker-lc-5" name="love_compatibility_settings_communication_heart_color_field" class="regular-text" value="<?php echo isset($love_compatibility_communication_heart_color_field) ? esc_attr( $love_compatibility_communication_heart_color_field ) : '#97dedd'; ?>"/>
    <?php 
}
function dhat_lc_settings_sex_heart_color_field_callback() {
    $love_compatibility_sex_heart_color_field = get_option('love_compatibility_settings_sex_heart_color_field');
    ?>
    <input type="text" id="colorpicker-lc-6" name="love_compatibility_settings_sex_heart_color_field" class="regular-text" value="<?php echo isset($love_compatibility_sex_heart_color_field) ? esc_attr( $love_compatibility_sex_heart_color_field ) : '#cc1100'; ?>" />
    <?php 
}

function dhat_lc_settings_font_size_field_callback() {
    $love_compatibility_font_size_field = get_option('love_compatibility_settings_font_size_field');
    update_option('love_compatibility_settings_font_size_field', $love_compatibility_font_size_field, false);
    ?>
    <input type="number" id="font-size-lc-1" name="love_compatibility_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($love_compatibility_font_size_field) ? esc_attr( $love_compatibility_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-lc-1_err">Please enter valid font size</p>
    <?php 
}
?>