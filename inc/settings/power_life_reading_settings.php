<?php

function dhat_power_life_reading_settings_init() {
        add_settings_section(
            'power_life_reading_settings_section',
            '',// Heading
            '',
            'power-life-reading-settings'
        );

        register_setting(
            'power-life-reading-settings',
            'power_life_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'power_life_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_pl_settings_card_field_callback',
            'power-life-reading-settings',
            'power_life_reading_settings_section'
        );

        register_setting(
            'power-life-reading-settings',
            'power_life_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'power_life_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_pl_settings_text_color_field_callback',
            'power-life-reading-settings',
            'power_life_reading_settings_section'
        );

        register_setting(
            'power-life-reading-settings',
            'power_life_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'power_life_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_pl_settings_font_size_field_callback',
            'power-life-reading-settings',
            'power_life_reading_settings_section'
        );

        register_setting(
            'power-life-reading-settings',
            'power_life_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'power_life_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_pl_settings_theme_color_field_callback',
            'power-life-reading-settings',
            'power_life_reading_settings_section'
        );

        register_setting(
            'power-life-reading-settings',
            'power_life_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'power_life_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_pl_settings_category_color_field_callback',
            'power-life-reading-settings',
            'power_life_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_power_life_reading_settings_init' );


function dhat_pl_settings_card_field_callback() {
    $power_life_reading_settings_card_field = get_option('power_life_reading_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-pl-card-input">
        <label>
            <input type="radio" name="power_life_reading_settings_card_field" value="1" <?= ($power_life_reading_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/ar-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="power_life_reading_settings_card_field" value="2" <?= ($power_life_reading_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="power_life_reading_settings_card_field" value="3" <?= ($power_life_reading_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_pl_settings_text_color_field_callback() {
    $power_life_text_color_field = get_option('power_life_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-pl-1" name="power_life_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($power_life_text_color_field) ? esc_attr( $power_life_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_pl_settings_theme_color_field_callback() {
    $power_life_theme_color_field = get_option('power_life_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-pl-2" name="power_life_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($power_life_theme_color_field) ? esc_attr( $power_life_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_pl_settings_category_color_field_callback() {
    $power_life_category_color_field = get_option('power_life_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-pl-3" name="power_life_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($power_life_category_color_field) ? esc_attr( $power_life_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_pl_settings_font_size_field_callback() {
    $power_life_reading_font_size_field = get_option('power_life_reading_settings_font_size_field');
    update_option('power_life_reading_settings_font_size_field', $power_life_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-pl-1" name="power_life_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($power_life_reading_font_size_field) ? esc_attr( $power_life_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-pl-1_err">Please enter valid font size</p>
    <?php 
}
?>