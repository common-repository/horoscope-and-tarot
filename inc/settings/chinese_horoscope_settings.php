<?php
function dhat_chinese_horoscope_settings_init() {
        add_settings_section(
            'chinese_horoscope_settings_section',
            '',// Heading
            '',
            'chinese-horoscope-settings'
        );


        register_setting(
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'chinese_horoscope_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_ch_settings_text_color_field_callback',
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_section'
        );

        register_setting(
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'chinese_horoscope_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_ch_settings_font_size_field_callback',
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_section'
        );

        register_setting(
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'chinese_horoscope_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_ch_settings_theme_color_field_callback',
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_section'
        );

        register_setting(
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'chinese_horoscope_settings_category_color_field',
            __( 'Tab Text Color (category)', 'horoscope-and-tarot' ),
            'dhat_ch_settings_category_color_field_callback',
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_section'
        );

        register_setting(
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_timezone_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'chinese_horoscope_settings_timezone_field',
            __( 'Select Timezone', 'horoscope-and-tarot' ),
            'dhat_ch_settings_timezone_field_callback',
            'chinese-horoscope-settings',
            'chinese_horoscope_settings_section'
        );
}

add_action( 'admin_init', 'dhat_chinese_horoscope_settings_init' );



function dhat_ch_settings_text_color_field_callback() {
    $horoscope_text_color_field = get_option('chinese_horoscope_settings_text_color_field');
    update_option('chinese_horoscope_settings_text_color_field', $horoscope_text_color_field, false);
    ?>
    <input type="text" id="colorpicker-ch-1" name="chinese_horoscope_settings_text_color_field" class="regular-text" value="<?php echo isset($horoscope_text_color_field) ? esc_attr( $horoscope_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ch_settings_theme_color_field_callback() {
    $horoscope_theme_color_field = get_option('chinese_horoscope_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-ch-2" name="chinese_horoscope_settings_theme_color_field" class="regular-text" value="<?php echo isset($horoscope_theme_color_field) ? esc_attr( $horoscope_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ch_settings_category_color_field_callback() {
    $horoscope_category_color_field = get_option('chinese_horoscope_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-ch-3" name="chinese_horoscope_settings_category_color_field" class="regular-text" value="<?php echo isset($horoscope_category_color_field) ? esc_attr( $horoscope_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ch_settings_timezone_field_callback() {
    $chinese_horoscope_settings_timezone_field = get_option('chinese_horoscope_settings_timezone_field');
    if($chinese_horoscope_settings_timezone_field == "")
    {
       $chinese_horoscope_settings_timezone_field = '5.5'; 
    }
    ?>
    <select class="regular-text" name="chinese_horoscope_settings_timezone_field" id="divine-ch-timezone-input" required>
        <option value=""> -- Select --</option>
        <?php foreach(unserialize(TIMEZONES) as $zone): ?>
            <option value="<?= $zone['id']; ?>" gmt="<?= $zone['value']; ?>" <?= ($zone['id']==$chinese_horoscope_settings_timezone_field ? 'selected':''); ?>><?= $zone['label']; ?></option>
        <?php endforeach;?>
    </select>
    <?php 
}

function dhat_ch_settings_font_size_field_callback() {
    $chinese_horoscope_font_size_field = get_option('chinese_horoscope_settings_font_size_field');
    update_option('chinese_horoscope_settings_font_size_field', $chinese_horoscope_font_size_field, false);
    ?>
    <input type="number" id="font-size-ch-1" name="chinese_horoscope_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($chinese_horoscope_font_size_field) ? esc_attr( $chinese_horoscope_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-ch-1_err">Please enter valid font size</p>
    <?php 
}
?>