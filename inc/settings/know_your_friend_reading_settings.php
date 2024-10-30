<?php

function dhat_know_your_friend_reading_settings_init() {
        add_settings_section(
            'know_your_friend_reading_settings_section',
            '',// Heading
            '',
            'know-your-friend-reading-settings'
        );

        register_setting(
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'know_your_friend_reading_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_kf_settings_card_field_callback',
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_section'
        );

        register_setting(
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'know_your_friend_reading_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_kf_settings_text_color_field_callback',
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_section'
        );

        register_setting(
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'know_your_friend_reading_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_kf_settings_font_size_field_callback',
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_section'
        );

        register_setting(
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'know_your_friend_reading_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_kf_settings_theme_color_field_callback',
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_section'
        );

        register_setting(
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'know_your_friend_reading_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_kf_settings_category_color_field_callback',
            'know-your-friend-reading-settings',
            'know_your_friend_reading_settings_section'
        );
}

add_action( 'admin_init', 'dhat_know_your_friend_reading_settings_init' );


function dhat_kf_settings_card_field_callback() {
    $know_your_friend_reading_settings_card_field = get_option('know_your_friend_reading_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-kf-card-input">
        <label>
            <input type="radio" name="know_your_friend_reading_settings_card_field" value="1" <?= ($know_your_friend_reading_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/ar-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="know_your_friend_reading_settings_card_field" value="2" <?= ($know_your_friend_reading_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="know_your_friend_reading_settings_card_field" value="3" <?= ($know_your_friend_reading_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_kf_settings_text_color_field_callback() {
    $know_your_friend_text_color_field = get_option('know_your_friend_reading_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-kf-1" name="know_your_friend_reading_settings_text_color_field" class="regular-text" value="<?php echo isset($know_your_friend_text_color_field) ? esc_attr( $know_your_friend_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_kf_settings_theme_color_field_callback() {
    $know_your_friend_theme_color_field = get_option('know_your_friend_reading_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-kf-2" name="know_your_friend_reading_settings_theme_color_field" class="regular-text" value="<?php echo isset($know_your_friend_theme_color_field) ? esc_attr( $know_your_friend_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_kf_settings_category_color_field_callback() {
    $know_your_friend_category_color_field = get_option('know_your_friend_reading_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-kf-3" name="know_your_friend_reading_settings_category_color_field" class="regular-text" value="<?php echo isset($know_your_friend_category_color_field) ? esc_attr( $know_your_friend_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_kf_settings_font_size_field_callback() {
    $know_your_friend_reading_font_size_field = get_option('know_your_friend_reading_settings_font_size_field');
    update_option('know_your_friend_reading_settings_font_size_field', $know_your_friend_reading_font_size_field, false);
    ?>
    <input type="number" id="font-size-kf-1" name="know_your_friend_reading_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($know_your_friend_reading_font_size_field) ? esc_attr( $know_your_friend_reading_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-kf-1_err">Please enter valid font size</p>
    <?php 
}
?>