<?php

function dhat_in_depth_love_settings_init() {
        add_settings_section(
            'in_depth_love_settings_section',
            '',// Heading
            '',
            'in-depth-love-settings'
        );

        register_setting(
            'in-depth-love-settings',
            'in_depth_love_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'in_depth_love_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_idl_settings_card_field_callback',
            'in-depth-love-settings',
            'in_depth_love_settings_section'
        );

        register_setting(
            'in-depth-love-settings',
            'in_depth_love_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'in_depth_love_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_idl_settings_text_color_field_callback',
            'in-depth-love-settings',
            'in_depth_love_settings_section'
        );

        register_setting(
            'in-depth-love-settings',
            'in_depth_love_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'in_depth_love_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_idl_settings_font_size_field_callback',
            'in-depth-love-settings',
            'in_depth_love_settings_section'
        );

        register_setting(
            'in-depth-love-settings',
            'in_depth_love_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'in_depth_love_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_idl_settings_theme_color_field_callback',
            'in-depth-love-settings',
            'in_depth_love_settings_section'
        );

        register_setting(
            'in-depth-love-settings',
            'in_depth_love_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'in_depth_love_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_idl_settings_category_color_field_callback',
            'in-depth-love-settings',
            'in_depth_love_settings_section'
        );
}

add_action( 'admin_init', 'dhat_in_depth_love_settings_init' );


function dhat_idl_settings_card_field_callback() {
    $in_depth_love_settings_card_field = get_option('in_depth_love_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-idl-card-input">
        <label>
            <input type="radio" name="in_depth_love_settings_card_field" value="1" <?= ($in_depth_love_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/idl-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="in_depth_love_settings_card_field" value="2" <?= ($in_depth_love_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="in_depth_love_settings_card_field" value="3" <?= ($in_depth_love_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_idl_settings_text_color_field_callback() {
    $in_depth_love_text_color_field = get_option('in_depth_love_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-idl-1" name="in_depth_love_settings_text_color_field" class="regular-text" value="<?php echo isset($in_depth_love_text_color_field) ? esc_attr( $in_depth_love_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_idl_settings_theme_color_field_callback() {
    $in_depth_love_theme_color_field = get_option('in_depth_love_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-idl-2" name="in_depth_love_settings_theme_color_field" class="regular-text" value="<?php echo isset($in_depth_love_theme_color_field) ? esc_attr( $in_depth_love_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_idl_settings_category_color_field_callback() {
    $in_depth_love_category_color_field = get_option('in_depth_love_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-idl-3" name="in_depth_love_settings_category_color_field" class="regular-text" value="<?php echo isset($in_depth_love_category_color_field) ? esc_attr( $in_depth_love_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_idl_settings_font_size_field_callback() {
    $in_depth_love_reading_font_size_field = get_option('in_depth_love_settings_font_size_field');
    update_option('in_depth_love_settings_font_size_field', $in_depth_love_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-idl-1" name="in_depth_love_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($in_depth_love_reading_font_size_field) ? esc_attr( $in_depth_love_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-idl-1_err">Please enter valid font size</p>
    <?php 
}
?>