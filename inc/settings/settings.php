<?php 

/**
 * Create Settings Menu
 */
function dhat_divine_settings_menu() {

    $hook = add_menu_page(
        __( 'Horoscope and Tarot', 'horoscope-and-tarot' ),
        __( 'Horoscope & Tarot', 'horoscope-and-tarot' ),
        'manage_options',
        'divine-settings-page',
        'dhat_divine_settings_template_callback',
        DHAT_PLUGIN_URL.'admin/img/plugin.svg',
        null
    );
}
add_action('admin_menu', 'dhat_divine_settings_menu');


/**
 * Settings Template Page
 */
function dhat_divine_settings_template_callback() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <div class="w3-card w3-padding-large w3-margin-top w3-white">

        <div class="w3-bar divine__plugin__tab__row">
            <!--button class="w3-bar-item w3-button w3-blue" id="divine-setting-btn-1" onclick="openSection('1')">General</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-2" onclick="openSection('2')">Horoscope</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-3" onclick="openSection('3')">Daily Tarot</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-4" onclick="openSection('4')">Yes/No Tarot</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-5" onclick="openSection('5')">Fortune Cookie</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-6" onclick="openSection('6')">Coffee Cup</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-7" onclick="openSection('7')">Love Compatibility</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-8" onclick="openSection('8')">Career Daily Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-9" onclick="openSection('9')">Divine Angel Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-10" onclick="openSection('10')">Dream Come True Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-11" onclick="openSection('11')">Egyptian Prediction</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-12" onclick="openSection('12')">Erotic Love Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-13" onclick="openSection('13')">Ex-Flame Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-14" onclick="openSection('14')">Flirt Love Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-15" onclick="openSection('15')">In-Depth Love Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-16" onclick="openSection('16')">Know Your Friend Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-17" onclick="openSection('17')">Made For Each Other Or Not Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-18" onclick="openSection('18')">Past Lives Connection Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-19" onclick="openSection('19')">Power Life Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-20" onclick="openSection('20')">Divine Magic Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-21" onclick="openSection('21')">Heartbreak Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-22" onclick="openSection('22')">Wisdom Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-23" onclick="openSection('23')">Past-Present-Future Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-24" onclick="openSection('24')">Love Triangle Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-25" onclick="openSection('25')">Chinese Horoscope</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-26" onclick="openSection('26')">Numerology Horoscope</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-27" onclick="openSection('27')">Which Animal Are You Reading</button--->
            <!-- <button class="w3-bar-item w3-button w3-blue" id="divine-setting-btn-1" onclick="openSection('1')">General</button> -->
            <button class="w3-bar-item w3-button w3-blue" id="divine-setting-btn-1" onclick="openSection('1')">Authenticate</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-2-1" onclick="openSection('2-1')">Horoscope</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-3-1" onclick="openSection('3-1')">Tarot 1 Card</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-4-1" onclick="openSection('4-1')">Tarot 2 Card</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-5-1" onclick="openSection('5-1')">Tarot 3 Card</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-5" onclick="openSection('5')">Fortune Cookie</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-6" onclick="openSection('6')">Coffee Cup</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-7" onclick="openSection('7')">Love Compatibility</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-29" onclick="openSection('29')">Daily Panchang</button>
            <!-- <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-30" onclick="openSection('30')">Event Calendar</button> -->
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-31" onclick="openSection('31')">Choghadiya</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-32" onclick="openSection('32')">Kundali</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-33" onclick="openSection('33')">Kundali Matching</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-34" onclick="openSection('34')">Natal</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-35" onclick="openSection('35')">Transit</button>
            <button class="w3-bar-item w3-button w3-light-grey" id="divine-setting-btn-36" onclick="openSection('36')">Synastry</button>
        </div>
        <div id="divine-setting-tab-2-1" class="w3-bar divine__plugin__tab__row city" style="display:none">
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-2" onclick="openSection('2')">Daily Horoscope</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-25" onclick="openSection('25')">Chinese Horoscope</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-26" onclick="openSection('26')">Numerology Horoscope</button>
        </div>

        <div id="divine-setting-tab-3-1" class="w3-bar divine__plugin__tab__row city" style="display:none">
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-8" onclick="openSection('8')">Career Daily Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-3" onclick="openSection('3')">Daily Tarot</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-4" onclick="openSection('4')">Yes/No Tarot</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-9" onclick="openSection('9')">Divine Angel Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-10" onclick="openSection('10')">Dream Come True Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-11" onclick="openSection('11')">Egyptian Prediction</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-12" onclick="openSection('12')">Erotic Love Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-13" onclick="openSection('13')">Ex-Flame Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-14" onclick="openSection('14')">Flirt Love Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-15" onclick="openSection('15')">In-Depth Love Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-16" onclick="openSection('16')">Know Your Friend Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-17" onclick="openSection('17')">Made For Each Other Or Not Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-18" onclick="openSection('18')">Past Lives Connection Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-19" onclick="openSection('19')">Power Life Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-27" onclick="openSection('27')">Which Animal Are You Reading</button>
        </div>
        <div id="divine-setting-tab-4-1" class="w3-bar divine__plugin__tab__row city" style="display:none">
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-20" onclick="openSection('20')">Divine Magic Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-21" onclick="openSection('21')">Heartbreak Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-22" onclick="openSection('22')">Wisdom Reading</button>
        </div>
        <div id="divine-setting-tab-5-1" class="w3-bar divine__plugin__tab__row city" style="display:none">
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-24" onclick="openSection('24')">Love Triangle Reading</button>
            <button class="w3-bar-item w3-button w3-light-grey sub_tab" id="divine-setting-btn-23" onclick="openSection('23')">Past-Present-Future Reading</button>
        </div>
        <span style="margin-left: 10px; ">
            <a href="https://divineapi.com/support" target="_blank">
                <img src="<?= DHAT_PLUGIN_URL.'public/images/contact-us.png'; ?>" alt="" style="margin-top: 5px;">
            </a>
        </span>

        <div id="divine-setting-tab-1" class="w3-container city">
            <div class="w3-row">
                <div class="w3-col m6 l6">
                    <div id="alert-box"></div>
                    <form action="options.php" method="post">
                        <?php 
                            $other_attributes = array( 'id' => 'submit-one' );
                            // security field
                            settings_fields( 'divine-settings-page' );

                            // output settings section here
                            do_settings_sections('divine-settings-page');

                            // save settings button
                            ?>
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 175px !important;">Authorized Site</th>
                                        <td id="divine-site-status" style="padding: 15px 0 !important;">    
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                            submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                        ?>
                    </form>
                    
                    
                </div>
                <div class="w3-col m6 l6 w3-center">
                    <iframe class="divine__video__box" allow="fullscreen;" width="100%" height="315"
                    src="https://www.youtube.com/embed/Ad-381LVA-s?controls=1">
                    </iframe>
                </div>
            </div>
        </div>

        <div id="divine-setting-tab-2" class="w3-container city" style="display:none">
            <div id="divine-dh-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_horoscope default_sign="aries"]</code><button class="divine__copy" code='[divine_horoscope default_sign="aries"]'>Copy</button><button class="divine__custom__shortcode__btn" onclick="document.getElementById('id01').style.display='block'">View Custom Shortcodes</button></p>
            <div id="divine-dh-status"></div>
            <div class="w3-row">
                <div class="w3-col m6 l6">
                    <form id="frm_dh" action="options.php" method="post">              
                        <?php 
                            $other_attributes = array( 'id' => 'submit-two', 'type' => 'button' );
                            // security field
                            settings_fields( 'horoscope-settings' );

                            // output settings section here
                            do_settings_sections('horoscope-settings');

                            // save settings button
                            submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                        ?>
                    </form>
                </div>
                <div class="w3-col m6 l6 w3-center theme_options_1 theme_options_1_sec">
                    <img id="divine-dh-sign-set-1" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/Set-1.PNG'; ?>" style="display: none;">
                    <img id="divine-dh-sign-set-2" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/Set-2.PNG'; ?>" style="display: none;">
                    <img id="divine-dh-sign-set-3" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/Set-3.png'; ?>" style="display: none;">
                </div>
                <?php
                $tabs_position = get_option('horoscope_tabs_position_field');
                $buttons_position = get_option('horoscope_buttons_position_field');
                $buttons_with_icons = get_option('horoscope_buttons_with_icon_field');
                $button_type = get_option('horoscope_buttons_type_field');
                ?>
                <div class="w3-col m6 l6 w3-center theme_options_2 theme_options_2_sec">
                    <img id="theme-2-tabs-top" class="theme_2_tabs" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-tabs.png'; ?>" <?php echo ($tabs_position == 'top') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-title" class="theme_2_title" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-title.png'; ?>">
                    <img id="theme-2-tabs-middle" class="theme_2_tabs" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-tabs.png'; ?>" <?php echo ($tabs_position == 'middle') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-buttons-middle" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-buttons-middle.png'; ?>" <?php echo ($buttons_position == 'middle' && $button_type == 'rectangle' && $buttons_with_icons != 'on') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-buttons-with-icons-middle" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-buttons-with-icons-middle.png'; ?>" <?php echo ($buttons_position == 'middle' && $button_type == 'rectangle' && $buttons_with_icons == 'on') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-square-buttons-with-icons-middle" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-square-buttons-with-icons-middle.png'; ?>" <?php echo ($buttons_position == 'middle' && $button_type == 'square' && $buttons_with_icons != 'on') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-square-buttons-middle" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-square-buttons-middle.png'; ?>" <?php echo ($buttons_position == 'middle' && $button_type == 'square' && $buttons_with_icons == 'on') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-content" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-content.png'; ?>">
                    <img id="theme-2-tabs-bottom" class="theme_2_tabs" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-tabs.png'; ?>" <?php echo ($tabs_position == 'bottom') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-buttons-bottom" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-buttons-bottom.png'; ?>" <?php echo ($buttons_position == 'bottom' && $button_type == 'rectangle' && $buttons_with_icons != 'on') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-square-buttons-with-icons-bottom" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-square-buttons-with-icons-bottom.png'; ?>" <?php echo ($buttons_position == 'bottom' && $button_type == 'square' && $buttons_with_icons == 'on') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-buttons-with-icons-bottom" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-buttons-with-icons-bottom.png'; ?>" <?php echo ($buttons_position == 'bottom' && $button_type == 'rectangle' && $buttons_with_icons == 'on') ? '' : 'style="display:none;"'; ?>>
                    <img id="theme-2-square-buttons-bottom" class="theme_2_buttons" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/theme-2-square-buttons-bottom.png'; ?>" <?php echo ($buttons_position == 'bottom' && $button_type == 'square' && $buttons_with_icons != 'on') ? '' : 'style="display:none;"'; ?>>
                </div>
            </div>

  <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom" style="border-radius: 10px;">
      <header class="w3-container"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2 class="w3-center" style="border-bottom: 1px solid #ccc;">Horoscope & Tarot Custom Shortcodes</h2>
      </header>
      <div class="w3-container divine__custom__horoscope__shortcode__box">
        <h4 class="w3-center">General Parameters</h4>
        <table class="w3-table w3-bordere">
            <tr>
                <th>Sign</th>
                <td class="divine__shortcode__sm">
                    Aries| Taurus | Pisces | Aquarius | Virgo | Libra | Gemini | Cancer | Capricorn | Leo | Scorpio | Sagittarius
                </td>
            </tr>
            <tr>
                <th>Category</th>
                <td class="divine__shortcode__sm">
                    Personal | Health | Profession | Emotions | Travel | Luck
                </td>
            </tr>
        </table>
        <hr class="divine__hr">
        <h4 class="w3-center">Daily Custom Horoscope</h4>
        <table class="w3-table w3-bordere">
            <tr>
                <th>Today</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_daily_horoscope sign="aries" category="profession" date="today"]</code>
                </td>
            </tr>
            <tr>
                <th>Yesterday</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_daily_horoscope sign="aries" category="profession" date="yesterday"]</code>
                </td>
            </tr>
            <tr>
                <th>Tomorrow</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_daily_horoscope sign="aries" category="profession" date="tomorrow"]</code>
                </td>
            </tr>
        </table>
        <hr class="divine__hr">
        <h4 class="w3-center">Weekly Custom Horoscope</h4>
        <table class="w3-table w3-bordere">
            <tr>
                <th>Current Week</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_weekly_horoscope sign="aries" category="profession" week="current"]</code>
                </td>
            </tr>
            <tr>
                <th>Previous Week</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_weekly_horoscope sign="aries" category="profession" week="prev"]</code>
                </td>
            </tr>
            <tr>
                <th>Next Week</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_weekly_horoscope sign="aries" category="profession" week="next"]</code>
                </td>
            </tr>
        </table>
        <hr class="divine__hr">
        <h4 class="w3-center">Monthly Custom Horoscope</h4>
        <table class="w3-table w3-bordere">
            <tr>
                <th>Current Month</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_monthly_horoscope sign="aries" category="profession" month="current"]</code>
                </td>
            </tr>
            <tr>
                <th>Previous Month</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_monthly_horoscope sign="aries" category="profession" month="prev"]</code>
                </td>
            </tr>
            <tr>
                <th>Next Month</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_monthly_horoscope sign="aries" category="profession" month="next"]</code>
                </td>
            </tr>
        </table>
        <hr class="divine__hr">
        <h4 class="w3-center">Yearly Custom Horoscope</h4>
        <table class="w3-table w3-bordere">
            <tr>
                <th>Current Year</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_yearly_horoscope sign="aries" category="profession" year="current"]</code>
                </td>
            </tr>
            <tr>
                <th>Previous Year</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_yearly_horoscope sign="aries" category="profession" year="prev"]</code>
                </td>
            </tr>
            <tr>
                <th>Next Year</th>
                <td>
                    <code class="divine__shortcode__sm">[divine_custom_yearly_horoscope sign="aries" category="profession" year="next"]</code>
                </td>
            </tr>
        </table><br>
      </div>
    </div>
  </div>            
        </div>

        <div id="divine-setting-tab-3" class="w3-container city" style="display:none">
            <div id="divine-dt-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_daily_tarot]</code><button class="divine__copy" code="[divine_daily_tarot]">Copy</button></p>
            <div id="divine-dt-status"></div>
            <div class="w3-row">
                <div class="w3-col m6 l6">
                    <form id="frm_dt" action="options.php" method="post">
                        <?php 
                            $other_attributes = array( 'id' => 'submit-three', 'type' => 'button' );
                            // security field
                            settings_fields( 'daily-tarot-settings' );

                            // output settings section here
                            do_settings_sections('daily-tarot-settings');

                            // save settings button
                            submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                        ?>
                    </form>
                </div>
                <div class="w3-col m6 l6 w3-center">
                    <img id="divine-dt-card-set-1" height="300" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>" style="display: none;">
                    <img id="divine-dt-card-set-2" height="300" src="<?= DHAT_PLUGIN_URL.'admin/img/dt-1.jpg'; ?>" style="display: none;">
                </div>
            </div>
        </div>

        <div id="divine-setting-tab-4" class="w3-container city" style="display:none">
            <div id="divine-yn-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_yes_no_tarot]</code><button class="divine__copy" code="[divine_yes_no_tarot]">Copy</button></p>
            <div id="divine-yn-status"></div>
            <div class="w3-row">
                <div class="w3-col m6 l6">
                    <form id="frm_ynt" action="options.php" method="post">
                        <?php 
                            $other_attributes = array( 'id' => 'submit-four', 'type' => 'button' );
                            // security field
                            settings_fields( 'yes-no-tarot-settings' );

                            // output settings section here
                            do_settings_sections('yes-no-tarot-settings');

                            // save settings button
                            submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                        ?>
                    </form>
                </div>
                <div class="w3-col m6 l6 w3-center">
                    <img id="divine-yn-card-set-1" height="300" src="<?= DHAT_PLUGIN_URL.'admin/img/dt.jpg'; ?>" style="display: none;">
                    <img id="divine-yn-card-set-2" height="300" src="<?= DHAT_PLUGIN_URL.'admin/img/dt-1.jpg'; ?>" style="display: none;">
                </div>
            </div>
        </div> 

        <div id="divine-setting-tab-5" class="w3-container city" style="display:none">
            <div id="divine-fc-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_fortune_cookie]</code><button class="divine__copy" code="[divine_fortune_cookie]">Copy</button></p>
            <div id="divine-fc-status"></div>
            <form id="frm_fc" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-five', 'type' => 'button' );
                    // security field
                    settings_fields( 'fortune-cookie-settings' );

                    // output settings section here
                    do_settings_sections('fortune-cookie-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 

        <div id="divine-setting-tab-6" class="w3-container city" style="display:none">
            <div id="divine-cc-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_coffee_cup]</code><button class="divine__copy" code="[divine_coffee_cup]">Copy</button></p>
            <div id="divine-cc-status"></div>
            <form id="frm_cc" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-six', 'type' => 'button' );
                    // security field
                    settings_fields( 'coffee-cup-settings' );

                    // output settings section here
                    do_settings_sections('coffee-cup-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 
        <div id="divine-setting-tab-7" class="w3-container city" style="display:none">
            <div id="divine-lc-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_love_compatibility]</code><button class="divine__copy" code="[divine_love_compatibility]">Copy</button></p>
            <div id="divine-lc-status"></div>
            <div class="w3-row">
                <div class="w3-col m6 l6">
                    <form id="frm_lc" action="options.php" method="post">
                        <?php 
                            $other_attributes = array( 'id' => 'submit-seven', 'type' => 'button' );
                            // security field
                            settings_fields( 'love-compatibility-settings' );

                            // output settings section here
                            do_settings_sections('love-compatibility-settings');

                            // save settings button
                            submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                        ?>
                    </form>
                </div>
                <div class="w3-col m6 l6 w3-center">
                    <img id="divine-lc-sign-set-1" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/Set-1.PNG'; ?>" style="display: none;">
                    <img id="divine-lc-sign-set-2" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/Set-2.PNG'; ?>" style="display: none;">
                    <img id="divine-lc-sign-set-3" width="100%" src="<?= DHAT_PLUGIN_URL.'admin/img/Set-3.png'; ?>" style="display: none;">
                </div>
            </div>
        </div> 
        
        <!-----Single Tarot Cards--------------->
        <?php 
            $divIdArr = array('career-daily-reading', 'divine-angel-reading', 'dream-come-true-reading', 'egyptian-prediction', 'erotic-love-reading', 'ex-flame-reading', 'flirt-love-reading', 'in-depth-love', 'know-your-friend-reading', 'made-for-each-other-reading', 'past-lives-connection', 'power-life-reading', 'divine-magic-reading', 'heartbreak-reading', 'wisdom-reading', 'past-present-future-reading', 'love-triangle-reading');
            
            $shortcodeArr = array('divine_career_daily_reading', 'divine_angel_reading', 'divine_dream_come_true_reading', 'divine_egyptian_prediction', 'divine_erotic_love_reading', 'divine_ex_flame_reading', 'divine_flirt_love_reading', 'divine_in_depth_love_reading', 'divine_know_your_friend_reading', 'divine_made_for_each_other_or_not', 'divine_past_lives_connection_reading', 'divine_power_life_reading', 'divine_magic_reading', 'divine_heartbreak_reading', 'divine_wisdom_reading', 'divine_past_present_future_reading', 'divine_love_triangle_reading');
        
            $numberWordArr = array('eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen', 'twenty', 'twenty-one', 'twenty-two', 'twenty-three', 'twenty-four');
            $apiShortWordArr = array('cdr', 'ar', 'dct', 'ep', 'el', 'exf', 'fl', 'idl', 'kf', 'meo', 'plc', 'pl', 'dmr', 'hr', 'wr', 'ppf', 'ltr');

            for($i=0; $i< count($divIdArr);$i++) {
            $num = $i+8;
        ?>
        <div id="divine-setting-tab-<?php echo $num; ?>" class="w3-container city" style="display:none">
            <div id="divine-<?php echo $apiShortWordArr[$i]; ?>-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[<?php echo $shortcodeArr[$i]; ?> att='<?php echo $divIdArr[$i]; ?>']</code><button class="divine__copy" code="[<?php echo $shortcodeArr[$i]; ?> att='<?php echo $divIdArr[$i]; ?>']">Copy</button></p>
            <div id="divine-<?php echo $apiShortWordArr[$i]; ?>-status"></div>
            <form id="frm_<?php echo $apiShortWordArr[$i]; ?>" action="options.php" method="post">
                <?php 
                    $btnId = "submit".$numberWordArr[$i];
                    $other_attributes = array( 'id' => $btnId, 'class' => 'd_single_tarot', 'frmid' => $apiShortWordArr[$i], 'type' => 'button' );
                    // security field
                    settings_fields( $divIdArr[$i].'-settings' );

                    // output settings section here
                    do_settings_sections($divIdArr[$i].'-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div>      
        <?php } ?>

        <div id="divine-setting-tab-25" class="w3-container city" style="display:none">
            <div id="divine-ch-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_chinese_horoscope_v2]</code><button class="divine__copy" code="[divine_chinese_horoscope_v2]">Copy</button></p>
            <div id="divine-ch-status"></div>
            <form id="frm_ch" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-twenty-five', 'type' => 'button');
                    // security field
                    settings_fields( 'chinese-horoscope-settings' );

                    // output settings section here
                    do_settings_sections('chinese-horoscope-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 
        <div id="divine-setting-tab-26" class="w3-container city" style="display:none">
            <div id="divine-nh-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_numerology_horoscope]</code><button class="divine__copy" code="[divine_numerology_horoscope]">Copy</button></p>
            <div id="divine-nh-status"></div>
            <form id="frm_nh" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-twenty-six', 'type' => 'button' );
                    // security field
                    settings_fields( 'numerology-horoscope-settings' );

                    // output settings section here
                    do_settings_sections('numerology-horoscope-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div>
        <div id="divine-setting-tab-27" class="w3-container city" style="display:none">
            <div id="divine-ia-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_which_animal_are_you_reading]</code><button class="divine__copy" code="[divine_which_animal_are_you_reading]">Copy</button></p>
            <div id="divine-ia-status"></div>
            <form id="frm_way" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-twenty-seven', 'type' => 'button' );
                    // security field
                    settings_fields( 'which-animal-are-you-reading-settings' );

                    // output settings section here
                    do_settings_sections('which-animal-are-you-reading-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 

        
        <div id="divine-setting-tab-29" class="w3-container city" style="display:none">
            <div id="divine-dp-alert-box"></div>
            <p><b>Panchang Shortcode:</b> <code class="divine__shortcode">[divine_daily_panchang]</code><button class="divine__copy" code="[divine_daily_panchang]">Copy</button></p>
            <p><b>Festivals Shortcode:</b> <code class="divine__shortcode">[divine_festivals]</code><button class="divine__copy" code="[divine_festivals]">Copy</button></p>
            <p><b>Shortcode:</b><button class="divine__custom__shortcode__btn" onclick="document.getElementById('dpid01').style.display='block'">View Custom Shortcodes</button></p>
           
            
            <div id="divine-dp-status"></div>
            <form id="frm_dp" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-eight', 'type' => 'button' );
                    // security field
                    settings_fields( 'daily-panchang-settings' );

                    // output settings section here
                    do_settings_sections('daily-panchang-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 
        <div id="dpid01" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom" style="border-radius: 10px;">
      <header class="w3-container"> 
        <span onclick="document.getElementById('dpid01').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2 class="w3-center" style="border-bottom: 1px solid #ccc;">Panchang Section Shortcodes</h2>
      </header>
      <div class="w3-container divine__custom__horoscope__shortcode__box">
          <!-- <h4 class="w3-center">General Parameters</h4> -->
        <p><b>Sunrise & Moonrise Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_sunrise_moonrise]</code><button class="divine__copy" code="[divine_daily_panchang_sunrise_moonrise]">Copy</button></p>
        <p><b>Panchang Only Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_only]</code><button class="divine__copy" code="[divine_daily_panchang_only]">Copy</button></p>
        <p><b>Lunar Month and Samvat Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_month_samvat]</code><button class="divine__copy" code="[divine_daily_panchang_month_samvat]">Copy</button></p>
        <p><b>Rashi and Nakshatra Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_rashi_nakshatra]</code><button class="divine__copy" code="[divine_daily_panchang_rashi_nakshatra]">Copy</button></p>
        <p><b>Ritu and Ayana Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_ritu_ayana]</code><button class="divine__copy" code="[divine_daily_panchang_ritu_ayana]">Copy</button></p>
        <p><b>Auspicious Timings Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_auspicious_panchang]</code><button class="divine__copy" code="[divine_daily_auspicious_panchang]">Copy</button></p>
        <p><b>Inauspicious Timings Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_inauspicious]</code><button class="divine__copy" code="[divine_daily_panchang_inauspicious]">Copy</button></p>
        <p><b>Nivas and Shool Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_nivas_shool]</code><button class="divine__copy" code="[divine_daily_panchang_nivas_shool]">Copy</button></p>
        <p><b>Other Calendars and Epoch Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_other_calendars_epoch]</code><button class="divine__copy" code="[divine_daily_panchang_other_calendars_epoch]">Copy</button></p>
        <p><b>Chandrabalam & Tarabalam Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_chandrabalam_tarabalam]</code><button class="divine__copy" code="[divine_daily_panchang_chandrabalam_tarabalam]">Copy</button></p>
        <p><b>Panchaka Rahita Muhurta and Udaya Lagna Shortcode:</b> <br> <code class="divine__shortcode">[divine_daily_panchang_panchaka_rahita_muhurta_udaya_lagna]</code><button class="divine__copy" code="[divine_daily_panchang_panchaka_rahita_muhurta_udaya_lagna]">Copy</button></p>

        <br>
      </div>
    </div>
  </div>  
        <!-- <div id="divine-setting-tab-30" class="w3-container city" style="display:none">
            <div id="divine-dp-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_festivals]</code><button class="divine__copy" code="[divine_festivals]">Copy</button></p>
            <div id="divine-dp-status"></div>
        </div>  -->
        <div id="divine-setting-tab-31" class="w3-container city" style="display:none">
            <div id="divine-cho-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_choghadiya]</code><button class="divine__copy" code="[divine_choghadiya]">Copy</button></p>
            <div id="divine-cho-status"></div>
            <form id="frm_choghadiya" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-eight', 'type' => 'button' );
                    // security field
                    settings_fields( 'choghadiya-settings' );

                    // output settings section here
                    do_settings_sections('choghadiya-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 
        <div id="divine-setting-tab-32" class="w3-container city" style="display:none">
            <div id="divine-ku-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_kundali]</code><button class="divine__copy" code="[divine_kundali]">Copy</button></p>
            <div id="divine-ku-status"></div>
            <form id="frm_kundali" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-thirty-two', 'type' => 'button' );
                    // security field
                    settings_fields( 'kundali-settings' );

                    // output settings section here
                    do_settings_sections('kundali-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 
        <div id="divine-setting-tab-33" class="w3-container city" style="display:none">
            <div id="divine-kum-alert-box"></div>
            <p><b>Shortcode:</b> <code class="divine__shortcode">[divine_kundali_matching]</code><button class="divine__copy" code="[divine_kundali_matching]">Copy</button></p>
            <div id="divine-kum-status"></div>
            <form id="frm_kundali_matching" action="options.php" method="post">
                <?php 
                    $other_attributes = array( 'id' => 'submit-thirty-three', 'type' => 'button' );
                    // security field
                    settings_fields( 'kundali-matching-settings' );

                    // output settings section here
                    do_settings_sections('kundali-matching-settings');

                    // save settings button
                    submit_button( 'Save Settings', 'primary', 'save-settings', true, $other_attributes);
                ?>
            </form>
        </div> 
        <div id="divine-setting-tab-34" class="w3-container city" style="display:none">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <div id="divine-natal-alert-box"></div>
            <div id="divine-natal-status"></div>
            <style>
                .divine__add-btn {
                    background-color: white !important;
                    color: green !important;
                    border: 2px solid green !important;
                    border-radius: 5px !important;
                    padding: 3px 15px !important;
                    cursor: pointer;
                }
                .divine__add-btn:hover {
                    background-color: green !important;
                    color: white !important;
                    border: 2px solid green !important;
                }
            </style>


            <p><b>Shortcode default:</b> <code class="divine__shortcode">[divine_natal]</code><button class="divine__copy" code="[divine_natal]">Copy</button> <button class="divine__add-btn divine_add_btn" data-id="" data-widget="dapi-widget-natal-basic">Add New</button></p>
            <div id="dapi-widget-natal-basic-shortcode">
                <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
            </div>



        </div> 
        <div id="divine-setting-tab-35" class="w3-container city" style="display:none">
            <div id="divine-transit-alert-box"></div>
            <div id="divine-transit-status"></div>

            <p><b>Shortcode default:</b> <code class="divine__shortcode">[divine_natal_transit]</code><button class="divine__copy" code="[divine_natal_transit]">Copy</button> <button class="divine__add-btn divine_add_btn" data-id="" data-widget="dapi-widget-natal-basic-transit">Add New</button></p>
            <div id="dapi-widget-natal-basic-transit-shortcode">
                <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
            </div>



        </div> 
        <div id="divine-setting-tab-36" class="w3-container city" style="display:none">
            <div id="divine-synastry-alert-box"></div>
            <div id="divine-synastry-status"></div>

            <p><b>Shortcode default:</b> <code class="divine__shortcode">[divine_natal_synastry]</code><button class="divine__copy" code="[divine_natal_synastry]">Copy</button> <button class="divine__add-btn divine_add_btn" data-id="" data-widget="dapi-widget-natal-synastry">Add New</button></p>
            <div id="dapi-widget-natal-synastry-shortcode">
                <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
            </div>



        </div> 

        <style>
            #divine-setting-dynamic{
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1;
                height: 100vh;
                width: 100vw;
                margin: unset;
                background: #1e1e1e63;
            }
            #divine-setting-dynamic-inner{
                margin: 48px auto;
                max-width: 1000px;
                background: #fff;
                padding: 15px;
                border-radius: 9px;
                position: relative;
            }
            #divine-setting-dynamic-inner .close{
                float: inline-end;
                cursor: pointer;
                font-weight: 800;
                margin-top: -9px;
                margin-right: -5px;
            }
            #divine-setting-dynamic.hide {
                display: none;
            }
        </style>
        <div id="divine-setting-dynamic" class="hide">
            <div id="divine-setting-dynamic-inner">
                <div class="close">X</div>
                
            </div>
        </div>

        </div>
    </div>
    <?php 
}

/**
 * Settings Template
 */
function dhat_divine_settings_init() {
    // -- General Settings --
        // Setup settings section
        add_settings_section(
            'divine_settings_section',
            '', // Heading
            '',
            'divine-settings-page'
        );

        // Registe input field
        register_setting(
            'divine-settings-page',
            'divine_settings_input_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );

        // Add text fields
        add_settings_field(
            'divine_settings_input_field',
            __( 'API Key', 'horoscope-and-tarot' ),
            'dhat_settings_api_key_callback',
            'divine-settings-page',
            'divine_settings_section'
        );

        // Registe input field
        register_setting(
            'divine-settings-page',
            'divine_settings_access_token_field',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );

        // Add text fields
        add_settings_field(
            'divine_settings_access_token_field',
            __( 'Access Token', 'horoscope-and-tarot' ),
            'dhat_settings_access_token_callback',
            'divine-settings-page',
            'divine_settings_section'
        );
    //  -- End General Settings --

}
add_action( 'admin_init', 'dhat_divine_settings_init' );

// -- Horoscope Settings --
 include_once('horoscope_settings.php');
//  -- End Horoscope Settings --

// -- Daily Tarot Settings --
 include_once('daily_tarot_settings.php');
//  -- End Daily Tarot Settings --

// -- Yes No Tarot Settings --
 include_once('yes_no_tarot_settings.php');
//  -- End Yes No Tarot Settings --

// -- Fortune Cookie Settings --
 include_once('fortune_cookie_settings.php');
//  -- End Fortune Cookie Settings --

// -- Coffee Cup Settings --
 include_once('coffee_cup_settings.php');
//  -- End Coffee Cup Settings --

// -- Love Compatibility Settings --
include_once('love_compatibility_settings.php');
//  -- End Love Compatibility Settings --

// -- Power Life Reading Settings --
include_once('power_life_reading_settings.php');
//  -- Power Life Reading Settings --

// -- Career Daily Reading Settings --
include_once('career_daily_reading_settings.php');
//  -- End Career Daily Reading Settings --

// -- Divine Angel Reading Settings --
include_once('divine_angel_reading_settings.php');
//  -- End Divine Angel Reading Settings --

// -- Dream Come True Reading Settings --
include_once('dream_come_true_reading_settings.php');
//  -- End Dream Come True Reading Settings --

// -- Egyptian Prediction Settings --
include_once('egyptian_prediction_settings.php');
//  -- End Egyptian Prediction Settings --

// -- Erotic Love Reading Settings --
include_once('erotic_love_reading_settings.php');
//  -- End Erotic Love Reading Settings --

// -- Ex-Flame Reading Settings --
include_once('ex_flame_reading_settings.php');
//  -- End Ex-Flame Reading Settings --

// -- Flirt Love Reading Settings --
include_once('flirt_love_reading_settings.php');
//  -- End Flirt Love Reading Settings --

// -- IN-Depth Love Reading Settings --
include_once('in_depth_love_reading_settings.php');
//  -- End IN-Depth Love Reading Settings --

// -- Know Your Friend Reading Settings --
include_once('know_your_friend_reading_settings.php');
//  -- End Know Your Friend Reading Settings --

// -- Made for each other or not Reading Settings --
include_once('made_for_each_other_reading_settings.php');
//  -- End Made for each other or not Reading Settings --

// -- Past Lives Connection Settings --
include_once('past_lives_connection_settings.php');
//  -- End Past Lives Connection Settings --

// -- Power Life Reading Settings --
include_once('power_life_reading_settings.php');
//  -- End Power Life Reading Settings --

// -- Wisdom Reading Settings --
include_once('wisdom_reading_settings.php');
//  -- End Wisdom Reading Settings --

// -- Heartbreak Reading Settings --
include_once('heartbreak_reading_settings.php');
//  -- End Heartbreak Reading Settings --

// -- Divine Magic Reading Settings --
include_once('divine_magic_reading_settings.php');
//  -- End Divine Magic Reading Settings --

// -- Numerology Horoscope Settings --
include_once('numerology_horoscope_settings.php');
//  -- End Numerology Horoscope Settings --

// -- Chinese Horoscope Settings --
include_once('chinese_horoscope_settings.php');
//  -- End Chinese Horoscope Settings --

// -- Love Triangle Reading Settings --
include_once('love_triangle_reading_settings.php');
//  -- End Love Triangle Reading Settings --

// -- Past-Present-Future Reading Settings --
include_once('past_present_future_reading_settings.php');
//  -- End Past-Present-Future Reading Settings --

// -- Which Animal Are You Reading Settings --
include_once('which_animal_are_you_reading_settings.php');
//  -- End Which Animal Are You Reading Settings --

// -- Daily Panchang Settings --
include_once('daily_panchang_settings.php');
//  -- End Daily Panchang Settings --

// -- Choghadiya Settings --
include_once('choghadiya_settings.php');
//  -- End Choghadiya Settings --

// -- Kundali Settings --
include_once('kundali_settings.php');
//  -- End Kundali Settings --

// -- Kundali Matching Settings --
include_once('kundali_matching_settings.php');
//  -- End Kundali Matching Settings --

/**
 * txt tempalte
 */
function dhat_settings_api_key_callback() {
    $divine_input_field = get_option('divine_settings_input_field');
    ?>
    <input type="text" id="api_key" name="divine_settings_input_field" class="regular-text" value="<?php echo isset($divine_input_field) ? esc_attr( $divine_input_field ) : ''; ?>" required/>
    <?php 
}

function dhat_settings_access_token_callback() {
    $divine_access_token_field = get_option('divine_settings_access_token_field');
    ?>
    <textarea id="access_token" name="divine_settings_access_token_field" class="regular-text" rows="4" required><?php echo isset($divine_access_token_field) ? esc_attr( $divine_access_token_field ) : ''; ?></textarea>
    <!-- <p><span class="divine__text__danger divine__mb-2"><strong>NOTE</strong>: Access Token is required for daily panchang api. <br>You can generate your access token from</span> <a class="divine__a" href="https://dev.divineapi.com/profile" target="_blank">here</a></p> -->
    <p><span class="divine__text__danger divine__mb-2"><strong>NOTE</strong>: <br>You can generate your access token from</span> <a class="divine__a" href="https://dev.divineapi.com/profile" target="_blank">here</a></p>
    <?php 
}
?>