<?php

function dhat_daily_tarot_settings_init() {
        add_settings_section(
            'daily_tarot_settings_section',
            '',// Heading
            '',
            'daily-tarot-settings'
        );

        register_setting(
            'daily-tarot-settings',
            'daily_tarot_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'daily_tarot_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_dt_settings_card_field_callback',
            'daily-tarot-settings',
            'daily_tarot_settings_section'
        );

        register_setting(
            'daily-tarot-settings',
            'daily_tarot_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'daily_tarot_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_dt_settings_text_color_field_callback',
            'daily-tarot-settings',
            'daily_tarot_settings_section'
        );

        register_setting(
            'daily-tarot-settings',
            'daily_tarot_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'daily_tarot_settings_font_size_field',
            __( 'Font Size <br> (Default 13)', 'horoscope-and-tarot' ),
            'dhat_dt_settings_font_size_field_callback',
            'daily-tarot-settings',
            'daily_tarot_settings_section'
        );

        register_setting(
            'daily-tarot-settings',
            'daily_tarot_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'daily_tarot_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_dt_settings_theme_color_field_callback',
            'daily-tarot-settings',
            'daily_tarot_settings_section'
        );

        register_setting(
            'daily-tarot-settings',
            'daily_tarot_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'daily_tarot_settings_category_color_field',
            __( 'Tab Text Color (category)', 'horoscope-and-tarot' ),
            'dhat_dt_settings_category_color_field_callback',
            'daily-tarot-settings',
            'daily_tarot_settings_section'
        );
}

add_action( 'admin_init', 'dhat_daily_tarot_settings_init' );


function dhat_dt_settings_card_field_callback() {
    $daily_tarot_settings_card_field = get_option('daily_tarot_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-dt-card-input">
        <label>
            <input type="radio" name="daily_tarot_settings_card_field" value="1" <?= ($daily_tarot_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="daily_tarot_settings_card_field" value="2" <?= ($daily_tarot_settings_card_field != 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt-1.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_dt_settings_text_color_field_callback() {
    $daily_tarot_text_color_field = get_option('daily_tarot_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-dt-1" name="daily_tarot_settings_text_color_field" class="regular-text" value="<?php echo isset($daily_tarot_text_color_field) ? esc_attr( $daily_tarot_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dt_settings_theme_color_field_callback() {
    $daily_tarot_theme_color_field = get_option('daily_tarot_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-dt-2" name="daily_tarot_settings_theme_color_field" class="regular-text" value="<?php echo isset($daily_tarot_theme_color_field) ? esc_attr( $daily_tarot_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dt_settings_category_color_field_callback() {
    $daily_tarot_category_color_field = get_option('daily_tarot_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-dt-3" name="daily_tarot_settings_category_color_field" class="regular-text" value="<?php echo isset($daily_tarot_category_color_field) ? esc_attr( $daily_tarot_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dt_settings_font_size_field_callback() {
    $daily_tarot_font_size_field = get_option('daily_tarot_settings_font_size_field');
    update_option('daily_tarot_settings_font_size_field', $daily_tarot_font_size_field, false);
    ?>
    <input type="number" id="font-size-dt-1" name="daily_tarot_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($daily_tarot_font_size_field) ? esc_attr( $daily_tarot_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-dt-1_err">Please enter valid font size</p>
    <?php 
}
?>