<?php

function yes_no_tarot_settings_init() {
        add_settings_section(
            'yes_no_tarot_settings_section',
            '',// Heading
            '',
            'yes-no-tarot-settings'
        );

        register_setting(
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'yes_no_tarot_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'yes_no_tarot_settings_card_field_callback',
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_section'
        );

        register_setting(
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'yes_no_tarot_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'yes_no_tarot_settings_text_color_field_callback',
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_section'
        );

        register_setting(
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'yes_no_tarot_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'yes_no_tarot_settings_font_size_field_callback',
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_section'
        );

        register_setting(
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'yes_no_tarot_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'yes_no_tarot_settings_theme_color_field_callback',
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_section'
        );       

        register_setting(
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'yes_no_tarot_settings_category_color_field',
            __( 'Link Text Color', 'horoscope-and-tarot' ),
            'yes_no_tarot_settings_category_color_field_callback',
            'yes-no-tarot-settings',
            'yes_no_tarot_settings_section'
        );
}

add_action( 'admin_init', 'yes_no_tarot_settings_init' );


function yes_no_tarot_settings_card_field_callback() {
    $yes_no_tarot_settings_card_field = get_option('yes_no_tarot_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-yn-card-input">
        <label>
            <input type="radio" name="yes_no_tarot_settings_card_field" value="1" <?= ($yes_no_tarot_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="yes_no_tarot_settings_card_field" value="2" <?= ($yes_no_tarot_settings_card_field != 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt-1.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function yes_no_tarot_settings_text_color_field_callback() {
    $yes_no_tarot_text_color_field = get_option('yes_no_tarot_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-yn-1" name="yes_no_tarot_settings_text_color_field" class="regular-text" value="<?php echo isset($yes_no_tarot_text_color_field) ? esc_attr( $yes_no_tarot_text_color_field ) : ''; ?>" required/>
    <?php 
}

function yes_no_tarot_settings_theme_color_field_callback() {
    $yes_no_tarot_theme_color_field = get_option('yes_no_tarot_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-yn-2" name="yes_no_tarot_settings_theme_color_field" class="regular-text" value="<?php echo isset($yes_no_tarot_theme_color_field) ? esc_attr( $yes_no_tarot_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function yes_no_tarot_settings_category_color_field_callback() {
    $yes_no_tarot_category_color_field = get_option('yes_no_tarot_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-yn-3" name="yes_no_tarot_settings_category_color_field" class="regular-text" value="<?php echo isset($yes_no_tarot_category_color_field) ? esc_attr( $yes_no_tarot_category_color_field ) : ''; ?>" required/>
    <?php 
}

function yes_no_tarot_settings_font_size_field_callback() {
    $yes_no_tarot_font_size_field = get_option('yes_no_tarot_settings_font_size_field');
    update_option('yes_no_tarot_settings_font_size_field', $yes_no_tarot_font_size_field, false);
    ?>
    <input type="number" id="font-size-ynt-1" name="yes_no_tarot_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($yes_no_tarot_font_size_field) ? esc_attr( $yes_no_tarot_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-ynt-1_err">Please enter valid font size</p>
    <?php 
}
?>