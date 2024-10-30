<?php

function dhat_divine_magic_reading_settings_init() {
        add_settings_section(
            'divine_magic_reading_settings_section',
            '',// Heading
            '',
            'divine-magic-reading-settings'
        );

        register_setting(
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'divine_magic_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_dmr_settings_card_field_callback',
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_section'
        );

        register_setting(
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'divine_magic_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_dmr_settings_text_color_field_callback',
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_section'
        );

        register_setting(
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'divine_magic_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_dmr_settings_font_size_field_callback',
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_section'
        );

        register_setting(
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'divine_magic_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_dmr_settings_theme_color_field_callback',
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_section'
        );

        register_setting(
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'divine_magic_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_dmr_settings_category_color_field_callback',
            'divine-magic-reading-settings',
            'divine_magic_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_divine_magic_reading_settings_init' );

function dhat_dmr_settings_card_field_callback() {
    $divine_magic_reading_settings_card_field = get_option('divine_magic_reading_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-dmr-card-input">
        <label>
            <input type="radio" name="divine_magic_reading_settings_card_field" value="1" <?= ($divine_magic_reading_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dct-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="divine_magic_reading_settings_card_field" value="2" <?= ($divine_magic_reading_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="divine_magic_reading_settings_card_field" value="3" <?= ($divine_magic_reading_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_dmr_settings_text_color_field_callback() {
    $divine_magic_text_color_field = get_option('divine_magic_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-dmr-1" name="divine_magic_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($divine_magic_text_color_field) ? esc_attr( $divine_magic_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dmr_settings_theme_color_field_callback() {
    $divine_magic_theme_color_field = get_option('divine_magic_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-dmr-2" name="divine_magic_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($divine_magic_theme_color_field) ? esc_attr( $divine_magic_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dmr_settings_category_color_field_callback() {
    $divine_magic_category_color_field = get_option('divine_magic_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-dmr-3" name="divine_magic_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($divine_magic_category_color_field) ? esc_attr( $divine_magic_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dmr_settings_font_size_field_callback() {
    $magic_reading_font_size_field = get_option('divine_magic_reading_settings_font_size_field');
    update_option('divine_magic_reading_settings_font_size_field', $magic_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-dmr-1" name="divine_magic_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($magic_reading_font_size_field) ? esc_attr( $magic_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-dmr-1_err">Please enter valid font size</p>
    <?php 
}
?>