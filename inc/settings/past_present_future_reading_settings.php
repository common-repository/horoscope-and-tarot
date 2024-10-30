<?php

function dhat_past_present_future_reading_settings_init() {
        add_settings_section(
            'past_present_future_reading_settings_section',
            '',// Heading
            '',
            'past-present-future-reading-settings'
        );

        
        register_setting(
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'past_present_future_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_ppf_settings_card_field_callback',
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_section'
        );

        register_setting(
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'past_present_future_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_ppf_settings_text_color_field_callback',
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_section'
        );

        register_setting(
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'past_present_future_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_ppf_settings_font_size_field_callback',
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_section'
        );

        register_setting(
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'past_present_future_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_ppf_settings_theme_color_field_callback',
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_section'
        );

        register_setting(
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'past_present_future_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_ppf_settings_category_color_field_callback',
            'past-present-future-reading-settings',
            'past_present_future_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_past_present_future_reading_settings_init' );

function dhat_ppf_settings_card_field_callback() {
    $past_present_future_settings_card_field = get_option('past_present_future_reading_settings_card_field');
    if(empty($past_present_future_settings_card_field)){
        $past_present_future_settings_card_field = 1;
    }
    ?>
    <div class="divine__theme__card" id="divine-ltr-card-input">
        <label>
            <input type="radio" name="past_present_future_reading_settings_card_field" value="1" <?= ($past_present_future_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dct-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="past_present_future_reading_settings_card_field" value="2" <?= ($past_present_future_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="past_present_future_reading_settings_card_field" value="3" <?= ($past_present_future_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_ppf_settings_text_color_field_callback() {
    $past_present_future_reading_text_color_field = get_option('past_present_future_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-ppf-1" name="past_present_future_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($past_present_future_reading_text_color_field) ? esc_attr( $past_present_future_reading_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ppf_settings_theme_color_field_callback() {
    $past_present_future_reading_theme_color_field = get_option('past_present_future_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-ppf-2" name="past_present_future_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($past_present_future_reading_theme_color_field) ? esc_attr( $past_present_future_reading_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ppf_settings_category_color_field_callback() {
    $past_present_future_reading_category_color_field = get_option('past_present_future_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-ppf-3" name="past_present_future_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($past_present_future_reading_category_color_field) ? esc_attr( $past_present_future_reading_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ppf_settings_font_size_field_callback() {
    $past_present_future_font_size_field = get_option('past_present_future_reading_settings_font_size_field');
    update_option('past_present_future_reading_settings_font_size_field', $past_present_future_font_size_field, false);
    ?>
    <input type="number" id="font-size-ppf-1" name="past_present_future_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($past_present_future_font_size_field) ? esc_attr( $past_present_future_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-ppf-1_err">Please enter valid font size</p>
    <?php 
}
?>