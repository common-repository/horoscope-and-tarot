<?php

function dhat_career_daily_reading_settings_init() {
        add_settings_section(
            'career_daily_reading_settings_section',
            '',// Heading
            '',
            'career-daily-reading-settings'
        );

        register_setting(
            'career-daily-reading-settings',
            'career_daily_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'career_daily_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_cdr_settings_card_field_callback',
            'career-daily-reading-settings',
            'career_daily_reading_settings_section'
        );

        register_setting(
            'career-daily-reading-settings',
            'career_daily_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'career_daily_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_cdr_settings_text_color_field_callback',
            'career-daily-reading-settings',
            'career_daily_reading_settings_section'
        );

        register_setting(
            'career-daily-reading-settings',
            'career_daily_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'career_daily_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_cdr_settings_font_size_field_callback',
            'career-daily-reading-settings',
            'career_daily_reading_settings_section'
        );

        register_setting(
            'career-daily-reading-settings',
            'career_daily_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'career_daily_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_cdr_settings_theme_color_field_callback',
            'career-daily-reading-settings',
            'career_daily_reading_settings_section'
        );

        register_setting(
            'career-daily-reading-settings',
            'career_daily_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'career_daily_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_cdr_settings_category_color_field_callback',
            'career-daily-reading-settings',
            'career_daily_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_career_daily_reading_settings_init' );


function dhat_cdr_settings_card_field_callback() {
    $career_daily_reading_settings_card_field = get_option('career_daily_reading_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-cdr-card-input">
        <label>
            <input type="radio" name="career_daily_reading_settings_card_field" value="1" <?= ($career_daily_reading_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="career_daily_reading_settings_card_field" value="2" <?= ($career_daily_reading_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>
        <label>
            <input type="radio" name="career_daily_reading_settings_card_field" value="3" <?= ($career_daily_reading_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_cdr_settings_text_color_field_callback() {
    $career_daily_reading_text_color_field = get_option('career_daily_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-cdr-1" name="career_daily_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($career_daily_reading_text_color_field) ? esc_attr( $career_daily_reading_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_cdr_settings_theme_color_field_callback() {
    $career_daily_reading_theme_color_field = get_option('career_daily_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-cdr-2" name="career_daily_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($career_daily_reading_theme_color_field) ? esc_attr( $career_daily_reading_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_cdr_settings_category_color_field_callback() {
    $career_daily_reading_category_color_field = get_option('career_daily_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-cdr-3" name="career_daily_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($career_daily_reading_category_color_field) ? esc_attr( $career_daily_reading_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_cdr_settings_font_size_field_callback() {
    $career_daily_reading_font_size_field = get_option('career_daily_reading_settings_font_size_field');
    update_option('career_daily_reading_settings_font_size_field', $career_daily_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-cdr-1" name="career_daily_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($career_daily_reading_font_size_field) ? esc_attr( $career_daily_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-cdr-1_err">Please enter valid font size</p>
    <?php 
}
?>