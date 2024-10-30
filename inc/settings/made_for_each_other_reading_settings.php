<?php

function dhat_made_for_each_other_reading_settings_init() {
        add_settings_section(
            'made_for_each_other_reading_settings_section',
            '',// Heading
            '',
            'made-for-each-other-reading-settings'
        );

        register_setting(
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'made_for_each_other_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_meo_settings_card_field_callback',
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_section'
        );

        register_setting(
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'made_for_each_other_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_meo_settings_text_color_field_callback',
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_section'
        );

        register_setting(
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'made_for_each_other_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_meo_settings_font_size_field_callback',
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_section'
        );

        register_setting(
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'made_for_each_other_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_meo_settings_theme_color_field_callback',
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_section'
        );

        register_setting(
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'made_for_each_other_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_meo_settings_category_color_field_callback',
            'made-for-each-other-reading-settings',
            'made_for_each_other_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_made_for_each_other_reading_settings_init' );


function dhat_meo_settings_card_field_callback() {
    $made_for_each_other_reading_settings_card_field = get_option('made_for_each_other_reading_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-meo-card-input">
        <label>
            <input type="radio" name="made_for_each_other_reading_settings_card_field" value="1" <?= ($made_for_each_other_reading_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/el-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="made_for_each_other_reading_settings_card_field" value="2" <?= ($made_for_each_other_reading_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="made_for_each_other_reading_settings_card_field" value="3" <?= ($made_for_each_other_reading_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_meo_settings_text_color_field_callback() {
    $made_for_each_other_text_color_field = get_option('made_for_each_other_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-meo-1" name="made_for_each_other_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($made_for_each_other_text_color_field) ? esc_attr( $made_for_each_other_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_meo_settings_theme_color_field_callback() {
    $made_for_each_other_theme_color_field = get_option('made_for_each_other_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-meo-2" name="made_for_each_other_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($made_for_each_other_theme_color_field) ? esc_attr( $made_for_each_other_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_meo_settings_category_color_field_callback() {
    $made_for_each_other_category_color_field = get_option('made_for_each_other_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-meo-3" name="made_for_each_other_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($made_for_each_other_category_color_field) ? esc_attr( $made_for_each_other_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_meo_settings_font_size_field_callback() {
    $made_for_each_other_reading_font_size_field = get_option('made_for_each_other_reading_settings_font_size_field');
    update_option('made_for_each_other_reading_settings_font_size_field', $made_for_each_other_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-meo-1" name="made_for_each_other_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($made_for_each_other_reading_font_size_field) ? esc_attr( $made_for_each_other_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-meo-1_err">Please enter valid font size</p>
    <?php 
}
?>