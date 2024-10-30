<?php

function dhat_wisdom_reading_settings_init() {
        add_settings_section(
            'wisdom_reading_settings_section',
            '',// Heading
            '',
            'wisdom-reading-settings'
        );

        register_setting(
            'wisdom-reading-settings',
            'wisdom_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'wisdom_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_wr_settings_card_field_callback',
            'wisdom-reading-settings',
            'wisdom_reading_settings_section'
        );

        register_setting(
            'wisdom-reading-settings',
            'wisdom_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'wisdom_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_wr_settings_text_color_field_callback',
            'wisdom-reading-settings',
            'wisdom_reading_settings_section'
        );

        register_setting(
            'wisdom-reading-settings',
            'wisdom_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'wisdom_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_wr_settings_font_size_field_callback',
            'wisdom-reading-settings',
            'wisdom_reading_settings_section'
        );

        register_setting(
            'wisdom-reading-settings',
            'wisdom_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'wisdom_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_wr_settings_theme_color_field_callback',
            'wisdom-reading-settings',
            'wisdom_reading_settings_section'
        );

        register_setting(
            'wisdom-reading-settings',
            'wisdom_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'wisdom_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_wr_settings_category_color_field_callback',
            'wisdom-reading-settings',
            'wisdom_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_wisdom_reading_settings_init' );

function dhat_wr_settings_card_field_callback() {
    $wisdom_reading_settings_card_field = get_option('wisdom_reading_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-wr-card-input">
        <label>
            <input type="radio" name="wisdom_reading_settings_card_field" value="1" <?= ($wisdom_reading_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="wisdom_reading_settings_card_field" value="2" <?= ($wisdom_reading_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="wisdom_reading_settings_card_field" value="3" <?= ($wisdom_reading_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_wr_settings_text_color_field_callback() {
    $wisdom_text_color_field = get_option('wisdom_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-wr-1" name="wisdom_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($wisdom_text_color_field) ? esc_attr( $wisdom_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_wr_settings_theme_color_field_callback() {
    $wisdom_theme_color_field = get_option('wisdom_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-wr-2" name="wisdom_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($wisdom_theme_color_field) ? esc_attr( $wisdom_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_wr_settings_category_color_field_callback() {
    $wisdom_category_color_field = get_option('wisdom_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-wr-3" name="wisdom_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($wisdom_category_color_field) ? esc_attr( $wisdom_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_wr_settings_font_size_field_callback() {
    $wisdom_reading_font_size_field = get_option('wisdom_reading_settings_font_size_field');
    update_option('wisdom_reading_settings_font_size_field', $wisdom_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-wr-1" name="wisdom_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($wisdom_reading_font_size_field) ? esc_attr( $wisdom_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-wr-1_err">Please enter valid font size</p>
    <?php 
}
?>