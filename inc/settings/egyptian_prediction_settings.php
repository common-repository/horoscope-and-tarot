<?php

function dhat_egyptian_prediction_settings_init() {
        add_settings_section(
            'egyptian_prediction_settings_section',
            '',// Heading
            '',
            'egyptian-prediction-settings'
        );

        register_setting(
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_card_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'egyptian_prediction_settings_card_field',
            __( 'Card Image Style', 'horoscope-and-tarot' ),
            'dhat_ep_settings_card_field_callback',
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_section'
        );

        register_setting(
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_text_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'egyptian_prediction_settings_text_color_field',
            __( 'Text Color', 'horoscope-and-tarot' ),
            'dhat_ep_settings_text_color_field_callback',
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_section'
        );

        register_setting(
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_font_size_field',
            array(
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '13'
            )
        );
        add_settings_field(
            'egyptian_prediction_settings_font_size_field',
            __( 'Font Size <br> (Default 13px)', 'horoscope-and-tarot' ),
            'dhat_ep_settings_font_size_field_callback',
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_section'
        );

        register_setting(
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_theme_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'egyptian_prediction_settings_theme_color_field',
            __( 'Theme Color', 'horoscope-and-tarot' ),
            'dhat_ep_settings_theme_color_field_callback',
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_section'
        );

        register_setting(
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_category_color_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
        add_settings_field(
            'egyptian_prediction_settings_category_color_field',
            __( 'Button Text Color', 'horoscope-and-tarot' ),
            'dhat_ep_settings_category_color_field_callback',
            'egyptian-prediction-settings',
            'egyptian_prediction_settings_section'
        );
}

add_action( 'admin_init', 'dhat_egyptian_prediction_settings_init' );


function dhat_ep_settings_card_field_callback() {
    $egyptian_prediction_settings_card_field = get_option('egyptian_prediction_settings_card_field');
    ?>
    <div class="divine__theme__card" id="divine-ep-card-input">
        <label>
            <input type="radio" name="egyptian_prediction_settings_card_field" value="1" <?= ($egyptian_prediction_settings_card_field == 1 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dct-1.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="egyptian_prediction_settings_card_field" value="2" <?= ($egyptian_prediction_settings_card_field == 2 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/cdr-2.jpg'; ?>">
        </label>

        <label>
            <input type="radio" name="egyptian_prediction_settings_card_field" value="3" <?= ($egyptian_prediction_settings_card_field == 3 ? 'checked' : ''); ?>>
            <img height="60" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>">
        </label>
    </div>  
    <?php 
}

function dhat_ep_settings_text_color_field_callback() {
    $egyptian_prediction_text_color_field = get_option('egyptian_prediction_settings_text_color_field');
    ?>
    <input type="text" id="colorpicker-ep-1" name="egyptian_prediction_settings_text_color_field" class="regular-text" value="<?php echo isset($egyptian_prediction_text_color_field) ? esc_attr( $egyptian_prediction_text_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ep_settings_theme_color_field_callback() {
    $egyptian_prediction_theme_color_field = get_option('egyptian_prediction_settings_theme_color_field');
    ?>
    <input type="text" id="colorpicker-ep-2" name="egyptian_prediction_settings_theme_color_field" class="regular-text" value="<?php echo isset($egyptian_prediction_theme_color_field) ? esc_attr( $egyptian_prediction_theme_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ep_settings_category_color_field_callback() {
    $egyptian_prediction_category_color_field = get_option('egyptian_prediction_settings_category_color_field');
    ?>
    <input type="text" id="colorpicker-ep-3" name="egyptian_prediction_settings_category_color_field" class="regular-text" value="<?php echo isset($egyptian_prediction_category_color_field) ? esc_attr( $egyptian_prediction_category_color_field ) : ''; ?>" required/>
    <?php 
}

function dhat_ep_settings_font_size_field_callback() {
    $egyptian_prediction_font_size_field = get_option('egyptian_prediction_settings_font_size_field');
    update_option('egyptian_prediction_settings_font_size_field', $egyptian_prediction_font_size_field, false);
    ?>
    <input type="number" id="font-size-ep-1" name="egyptian_prediction_settings_font_size_field" class="regular-text font_size_stt" value="<?php echo isset($egyptian_prediction_font_size_field) ? esc_attr( $egyptian_prediction_font_size_field ) : ''; ?>" required/>
    <p class="divine__text__danger" style="display:none;" id="font-size-ep-1_err">Please enter valid font size</p>
    <?php 
}
?>