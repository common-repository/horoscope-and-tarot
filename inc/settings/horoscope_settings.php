<?php
function dhat_horoscope_settings_init() {

        add_settings_section(
            'horoscope_settings_section',
            '',// Heading
            '',
            'horoscope-settings'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_settings_sign_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '2'
            )
        );
        add_settings_field(
            'horoscope_settings_sign_field',
            __( '<hr class="dapi-horoscope-common-hr"><hr class="dapi-horoscope-common-hr dapi-horoscope-common-hr-bottom">Zodiac Sign Style', 'horoscope-and-tarot' ),
            'dhat_dh_settings_sign_field_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'horoscope_settings_font_size_field',
            __( 'Font Size <br>(Default 13px)', 'horoscope-and-tarot' ),
            'dhat_dh_settings_font_size_field_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#D652BD'
            )
        );
        add_settings_field(
            'horoscope_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_dh_settings_theme_color_field_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#FFF'
            )
        );
        add_settings_field(
            'horoscope_settings_category_color_field',
            __( 'Tab Text Color (category)', 'horoscope-and-tarot' ),
            'dhat_dh_settings_category_color_field_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#000'
            )
        );
        add_settings_field(
            'horoscope_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_dh_settings_text_color_field_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_buttons_with_icon_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'horoscope_buttons_with_icon_field',
            __( '<label for="tabs_with_icons">Buttons with icon?</label>', 'horoscope-themes-settings' ),
            'horoscope_buttons_with_icon_field_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_settings_timezone_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '56'
            )
        );
        add_settings_field(
            'horoscope_settings_timezone_field',
            __( 'Select Timezone', 'horoscope-and-tarot' ),
            'dhat_dh_settings_timezone_field_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_theme_no_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '1'
            )
        );
        add_settings_field(
            'horoscope_theme_no_field',
            __( '<hr class="dapi-horoscope-common-hr dapi-horoscope-common-l-hr-2"><hr class="dapi-horoscope-common-hr dapi-horoscope-common-hr-bottom-2">Horoscope Theme', 'horoscope-themes-settings' ),
            'dhat_dh_settings_theme_callback',
            'horoscope-settings',
            'horoscope_settings_section'
        );

        //HOROSCOPE THEME SECTION START
        add_settings_section(
            'horoscope_themes_section',
            '',// Heading
            '',
            'horoscope-settings'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_settings_category_bg_default_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '#c290cb'
            )
        );
        add_settings_field(
            'horoscope_settings_category_bg_default_color_field',
            __( 'Tab Default Color (category)', 'horoscope-and-tarot' ),
            'dhat_dh_settings_category_dg_default_color_field_callback',
            'horoscope-settings',
            'horoscope_themes_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_tabs_position_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'top'
            )
        );
        add_settings_field(
            'horoscope_tabs_position_field',
            __( '<label class="theme_options_2">Tabs Position</label>', 'horoscope-themes-settings' ),
            'horoscope_tabs_position_field_callback',
            'horoscope-settings',
            'horoscope_themes_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_buttons_position_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'middle'
            )
        );
        add_settings_field(
            'horoscope_buttons_position_field',
            __( '<label class="theme_options_2">Buttons Position</label>', 'horoscope-themes-settings' ),
            'horoscope_buttons_position_field_callback',
            'horoscope-settings',
            'horoscope_themes_section'
        );

        register_setting(
            'horoscope-settings',
            'horoscope_buttons_type_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'rectangle'
            )
        );
        add_settings_field(
            'horoscope_buttons_type_field',
            __( '<label class="theme_options_2">Buttons type</label>', 'horoscope-themes-settings' ),
            'horoscope_buttons_type_field_callback',
            'horoscope-settings',
            'horoscope_themes_section'
        );
        
}

add_action( 'admin_init', 'dhat_horoscope_settings_init' );


function dhat_dh_settings_sign_field_callback() {
    $horoscope_settings_sign_field = get_option('horoscope_settings_sign_field');
    ?>
        <hr class="dapi-horoscope-common-hr dapi-horoscope-common-r-hr"><hr class="dapi-horoscope-common-hr dapi-horoscope-common-hr-bottom">
        <div class="divine__theme__card" id="divine-dh-sign-input">
            <!-- <h6>Select Zodiac Icons</h6> -->
            <label>
                <input type="radio" name="horoscope_settings_sign_field" value="1" <?= ($horoscope_settings_sign_field == 1 ? 'checked' : ''); ?>>
                <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/Aquarius-1.png'; ?>">
            </label>

            <label>
                <input type="radio" name="horoscope_settings_sign_field" value="2" <?= ($horoscope_settings_sign_field == 2 ? 'checked' : ''); ?>>
                <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/Aquarius.png'; ?>">
            </label>
            <label>
                <input type="radio" name="horoscope_settings_sign_field" value="3" <?= ($horoscope_settings_sign_field == 3 ? 'checked' : ''); ?>>
                <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/Aquarius-2.png'; ?>">
            </label>
        </div>  
    <?php 
}

function dhat_dh_settings_text_color_field_callback() {
    $horoscope_text_color_field = get_option('horoscope_settings_text_color_field');
    update_option('horoscope_settings_text_color_field', $horoscope_text_color_field, false);
    ?>
    <input type="text" id="colorpicker-dh-1" name="horoscope_settings_text_color_field" class="regular-text" value="<?php echo isset($horoscope_text_color_field) ? esc_attr( $horoscope_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dh_settings_theme_color_field_callback() {
    $horoscope_theme_color_field = get_option('horoscope_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-dh-2" name="horoscope_settings_theme_color_field" class="regular-text" value="<?php echo isset($horoscope_theme_color_field) ? esc_attr( $horoscope_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dh_settings_category_color_field_callback() {
    $horoscope_category_color_field = get_option('horoscope_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-dh-3" name="horoscope_settings_category_color_field" class="regular-text" value="<?php echo isset($horoscope_category_color_field) ? esc_attr( $horoscope_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_dh_settings_timezone_field_callback() {
    $horoscope_settings_timezone_field = get_option('horoscope_settings_timezone_field');
    if($horoscope_settings_timezone_field == "")
    {
       $horoscope_settings_timezone_field = '5.5'; 
    }
    ?>
    <select class="regular-text" name="horoscope_settings_timezone_field" id="divine-dh-timezone-input" required>
        <option value=""> -- Select --</option>
        <?php foreach(unserialize(TIMEZONES) as $zone): ?>
            <option value="<?= $zone['id']; ?>" gmt="<?= $zone['value']; ?>" <?= ($zone['id']==$horoscope_settings_timezone_field ? 'selected':''); ?>><?= $zone['label']; ?></option>
        <?php endforeach;?>
    </select>
    <?php 
}

function dhat_dh_settings_font_size_field_callback() {
    $horoscope_font_size_field = get_option('horoscope_settings_font_size_field');
    update_option('horoscope_settings_font_size_field', $horoscope_font_size_field, false);
    ?>
    <input type="number" id="font-size-dh-1" name="horoscope_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($horoscope_font_size_field) ? esc_attr( $horoscope_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-dh-1_err">Please enter valid font size</p>
    <?php 
}

function dhat_dh_settings_theme_callback() {
    $horoscope_theme_no_field = get_option('horoscope_theme_no_field');
    update_option('horoscope_theme_no_field', $horoscope_theme_no_field, false);
    ?>
    <hr class="dapi-horoscope-common-hr dapi-horoscope-common-r-hr-2"><hr class="dapi-horoscope-common-hr dapi-horoscope-common-hr-bottom-2">
    <div class="w3-bar divine__plugin__tab__row dapi-hrscp-them">
        <a class="w3-bar-item w3-button <?php echo ($horoscope_theme_no_field == 1) ? 'w3-blue' : 'w3-light-grey'; ?>" id="horoscope_theme_1">Theme 1</a>
        <a class="w3-bar-item w3-button <?php echo ($horoscope_theme_no_field == 2) ? 'w3-blue' : 'w3-light-grey'; ?>" id="horoscope_theme_2">Theme 2</a>
        <input type="hidden" id="horoscope_theme_no_field" name="horoscope_theme_no_field" value="<?php echo $horoscope_theme_no_field; ?>"/>
    </div>
    <?php
}

function horoscope_buttons_with_icon_field_callback() {
    $horoscope_buttons_with_icon_field = get_option('horoscope_buttons_with_icon_field');
    update_option('horoscope_buttons_with_icon_field', $horoscope_buttons_with_icon_field, false);
    ?>    
    <input type="checkbox" id="tabs_with_icons" class="" name="horoscope_buttons_with_icon_field" <?php echo (isset($horoscope_buttons_with_icon_field) && $horoscope_buttons_with_icon_field == 'on') ? 'checked' : ''; ?>/>
    <?php 
}

function horoscope_buttons_type_field_callback() {
    $horoscope_buttons_type_field = get_option('horoscope_buttons_type_field');
    update_option('horoscope_buttons_type_field', $horoscope_buttons_type_field, false);
    ?>
    <label for="button_rectangle" class="theme_options_2"><input type="radio" id="button_rectangle" name="horoscope_buttons_type_field" value="rectangle" <?php echo (isset($horoscope_buttons_type_field) && $horoscope_buttons_type_field == 'rectangle') ? 'checked' : ''; ?>/> Rectangle</label>
    &nbsp; &nbsp;<label for="button_square" class="theme_options_2"><input type="radio" id="button_square" name="horoscope_buttons_type_field" value="square" <?php echo (isset($horoscope_buttons_type_field) && $horoscope_buttons_type_field == 'square') ? 'checked' : ''; ?>/> Square</label>
    <?php 
}

function horoscope_tabs_position_field_callback() {
    $horoscope_tabs_position_field = get_option('horoscope_tabs_position_field');
    update_option('horoscope_tabs_position_field', $horoscope_tabs_position_field, false);
    ?>
    <label for="tab_top" class="theme_options_2"><input type="radio" id="tab_top" name="horoscope_tabs_position_field" value="top" <?php echo (isset($horoscope_tabs_position_field) && $horoscope_tabs_position_field == 'top') ? 'checked' : ''; ?>/> Top</label>
    &nbsp; &nbsp;<label for="tab_middle" class="theme_options_2"><input type="radio" id="tab_middle" name="horoscope_tabs_position_field" value="middle" <?php echo (isset($horoscope_tabs_position_field) && $horoscope_tabs_position_field == 'middle') ? 'checked' : ''; ?>/> Middle</label>
    &nbsp; &nbsp;<label for="tab_bottom" class="theme_options_2"><input type="radio" id="tab_bottom" name="horoscope_tabs_position_field" value="bottom" <?php echo (isset($horoscope_tabs_position_field) && $horoscope_tabs_position_field == 'bottom') ? 'checked' : ''; ?>/> Bottom</label>
    <?php 
}

function horoscope_buttons_position_field_callback() {
    $horoscope_buttons_position_field = get_option('horoscope_buttons_position_field');
    update_option('horoscope_buttons_position_field', $horoscope_buttons_position_field, false);
    ?>
    <label for="button_middle" class="theme_options_2"><input type="radio" id="button_middle" name="horoscope_buttons_position_field" value="middle" <?php echo (isset($horoscope_buttons_position_field) && $horoscope_buttons_position_field == 'middle') ? 'checked' : ''; ?>/> Middle</label>
    &nbsp; &nbsp;<label for="button_bottom" class="theme_options_2"><input type="radio" id="button_bottom" name="horoscope_buttons_position_field" value="bottom" <?php echo (isset($horoscope_buttons_position_field) && $horoscope_buttons_position_field == 'bottom') ? 'checked' : ''; ?>/> Bottom</label>
    <?php 
}

function dhat_dh_settings_category_dg_default_color_field_callback() {
    $horoscope_settings_category_bg_default_color_field = get_option('horoscope_settings_category_bg_default_color_field');
    ?>
    <input type="text" id="colorpicker-dh-bgdeflt" name="horoscope_settings_category_bg_default_color_field" class="regular-text theme_options_2" value="<?php echo isset($horoscope_settings_category_bg_default_color_field) ? esc_attr( $horoscope_settings_category_bg_default_color_field ) : ''; ?>" required/>
    <?php 
}

?>