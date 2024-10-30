<?php

function dhat_heartbreak_reading_settings_init() {
        add_settings_section(
            'heartbreak_reading_settings_section',
            '',// Heading
            '',
            'heartbreak-reading-settings'
        );

        register_setting(
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'heartbreak_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_hr_settings_card_field_callback',
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_section'
        );
        

        register_setting(
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'heartbreak_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_hr_settings_text_color_field_callback',
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_section'
        );

        register_setting(
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'heartbreak_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_hr_settings_font_size_field_callback',
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_section'
        );

        register_setting(
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'heartbreak_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_hr_settings_theme_color_field_callback',
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_section'
        );

        register_setting(
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'heartbreak_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_hr_settings_category_color_field_callback',
            'heartbreak-reading-settings',
            'heartbreak_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_heartbreak_reading_settings_init' );
function dhat_hr_settings_card_field_callback() {
    $heartbreak_reading_settings_card_field = get_option('heartbreak_reading_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-hr-card-input">
        <label>
            <input type="radio" name="heartbreak_reading_settings_card_field" value="1" <?= ($heartbreak_reading_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="heartbreak_reading_settings_card_field" value="2" <?= ($heartbreak_reading_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="heartbreak_reading_settings_card_field" value="3" <?= ($heartbreak_reading_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}


function dhat_hr_settings_text_color_field_callback() {
    $heartbreak_text_color_field = get_option('heartbreak_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-hr-1" name="heartbreak_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($heartbreak_text_color_field) ? esc_attr( $heartbreak_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_hr_settings_theme_color_field_callback() {
    $heartbreak_theme_color_field = get_option('heartbreak_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-hr-2" name="heartbreak_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($heartbreak_theme_color_field) ? esc_attr( $heartbreak_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_hr_settings_category_color_field_callback() {
    $heartbreak_category_color_field = get_option('heartbreak_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-hr-3" name="heartbreak_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($heartbreak_category_color_field) ? esc_attr( $heartbreak_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_hr_settings_font_size_field_callback() {
    $heartbreak_reading_font_size_field = get_option('heartbreak_reading_settings_font_size_field');
    update_option('heartbreak_reading_settings_font_size_field', $heartbreak_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-hr-1" name="heartbreak_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($heartbreak_reading_font_size_field) ? esc_attr( $heartbreak_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-hr-1_err">Please enter valid font size</p>
    <?php 
}
?>