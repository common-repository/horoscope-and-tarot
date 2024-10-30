<?php

require DHAT_PLUGIN_PATH . '/vendor/autoload.php';

class Apicall
{

    public function __construct() {

    }

    public function verify_domain() {

        $domain = (isset($_POST['domain'])) ? trim($_POST['domain']) : '';

        $api_key = get_option('divine_settings_input_field');
        $form_data = array(
            'api_key' => $api_key,
            'domain' => $domain,
        );

        return self::exec_api_req('https://divineapi.com/divines/verifyDomain', $form_data);

    }

    public function get_kundali_frm() {

        $rdr = 'kundali-form';
        $compact = array();
        $data = self::rdr_temp($rdr, $compact);

        return $data;

    }

    public function get_kundali_matching_frm() {

        $rdr = 'kundali-matching-form';
        $compact = array();
        $data = self::rdr_temp($rdr, $compact);

        return $data;

    }

    public function get_report() {

        $fname = (isset($_POST['fname'])) ? trim($_POST['fname']) : '';
        $lname = (isset($_POST['lname'])) ? trim($_POST['lname']) : '';
        $gender = (isset($_POST['gender'])) ? trim($_POST['gender']) : 'male';
        $dob = (isset($_POST['dob'])) ? trim($_POST['dob']) : '';
        $hour = (isset($_POST['hour'])) ? trim($_POST['hour']) : '';
        $min = (isset($_POST['min'])) ? trim($_POST['min']) : '';
        $sec = (isset($_POST['sec'])) ? trim($_POST['sec']) : '';
        $place = (isset($_POST['place'])) ? trim($_POST['place']) : '';
        $tzone = (isset($_POST['tzone'])) ? trim($_POST['tzone']) : '';
        $lat = (isset($_POST['lat'])) ? trim($_POST['lat']) : '';
        $lon = (isset($_POST['lon'])) ? trim($_POST['lon']) : '';
        $lang = (isset($_POST['lang'])) ? trim($_POST['lang']) : 'en';
        $arr_tran = array();
        $msgs = array();
        $err_cnt = 0;
        $tran = 0;
        $data = '';

        if (empty($fname) || $fname == 'null') {
        
            $msgs['kfname'] = 'Please enter first name';
            $err_cnt++;
        
        }

        if (empty($lname) || $lname == 'null') {
        
            $msgs['klname'] = 'Please enter last name';
            $err_cnt++;
        
        }

        if (empty($dob) || $dob == 'null' || strtotime($dob) <= 0) {
        
            $msgs['kdob'] = 'Please enter date of birth';
            $err_cnt++;
        
        }

        if (strlen($hour) <= 0 || strlen($min) <= 0 || strlen($sec) <= 0) {
            $msgs['khms'] = 'Please select valid birth time (hour:min:sec)';
            $err_cnt++;
        }

        if (empty($place) || $place == 'null' || empty($tzone) || empty($lat) || empty($lon)) {
        
            $msgs['kplace'] = 'Please select birth place again';
            $err_cnt++;
        
        }

        if ($err_cnt > 0) {
        
            $arr_tran['tran'] = 0;
            $arr_tran['msgs'] = $msgs;
        
        } else {

            $api_key = get_option('divine_settings_input_field');
        
            $form_data = [
                'api_key' => $api_key,
                'full_name' => $fname . ' ' . $lname,
                'day' => date('d', strtotime($dob)),
                'month' => date('m', strtotime($dob)),
                'year' => date('Y', strtotime($dob)),
                'hour' => $hour,
                'min' => $min,
                'sec' => $sec,
                'gender'=> $gender,
                'place' => $place,
                'lat' => $lat,
                'lon' => $lon,
                'tzone' => $tzone,
                'lan' => $lang,
            ];
            $basic_astro_detail = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/basic-astro-details", $form_data, true);

            if ($basic_astro_detail['status'] == 1 && $basic_astro_detail['data']['success'] == 1) {

                $tran = 1;
                $rdr = 'kundali-first-page';
                $compact = array(
                    'lang_type' => $lang,
                    'full_name' => $fname . ' ' . $lname,
                    'day' => date('d', strtotime($dob)),
                    'month' => date('m', strtotime($dob)),
                    'year' => date('Y', strtotime($dob)),
                    'hour' => $hour,
                    'min' => $min,
                    'sec' => $sec,
                    'gender'=> $gender,
                    'place' => $place,
                );
                $data = self::rdr_temp($rdr, $compact);

            } else {
                $tran = 2;
                $data = '<div class="divine_auth_domain_response">
                            <p style="color: red !important;text-align:center !important;">** ' . $basic_astro_detail['data']['msg'] . '</p>
                        </div>';
            }

            $arr_tran['tran'] = $tran;
            $arr_tran['data'] = $data;

        }

        return $arr_tran;

    }

    public function get_kundali_report_data() {

        $module = (isset($_POST['module'])) ? intval($_POST['module']) : 1;
        $fname = (isset($_POST['fname'])) ? trim($_POST['fname']) : '';
        $lname = (isset($_POST['lname'])) ? trim($_POST['lname']) : '';
        $gender = (isset($_POST['gender'])) ? trim($_POST['gender']) : 'male';
        $dob = (isset($_POST['dob'])) ? trim($_POST['dob']) : '';
        $hour = (isset($_POST['hour'])) ? trim($_POST['hour']) : '';
        $min = (isset($_POST['min'])) ? trim($_POST['min']) : '';
        $sec = (isset($_POST['sec'])) ? trim($_POST['sec']) : '';
        $place = (isset($_POST['place'])) ? trim($_POST['place']) : '';
        $tzone = (isset($_POST['tzone'])) ? trim($_POST['tzone']) : '';
        $lat = (isset($_POST['lat'])) ? trim($_POST['lat']) : '';
        $lon = (isset($_POST['lon'])) ? trim($_POST['lon']) : '';
        $lang_type = (isset($_POST['lang'])) ? trim($_POST['lang']) : 'en';
        $api_key = get_option('divine_settings_input_field');
        
        $form_data = [
            'api_key' => $api_key,
            'full_name' => $fname . ' ' . $lname,
            'day' => date('d', strtotime($dob)),
            'month' => date('m', strtotime($dob)),
            'year' => date('Y', strtotime($dob)),
            'hour' => $hour,
            'min' => $min,
            'sec' => $sec,
            'gender'=> $gender,
            'place' => $place,
            'lat' => $lat,
            'lon' => $lon,
            'tzone' => $tzone,
            'lan' => $lang_type,
        ];

        $messages = ($lang_type == 'en') ? self::get_english_content() : self::get_hindi_content();

        $data = '';

        if ($module == 1) {

            $data = $this->get_basic_details($form_data, $messages);

        } elseif ($module == 2) {

            $data = $this->get_planetary_position_details($form_data, $messages);

        } elseif ($module == 3) {

            $data = $this->get_horoscope_chart_details($form_data, $messages);

        } elseif ($module == 4) {

            $data = $this->get_house_cusps_and_sandhi_details($form_data, $messages);

        } elseif ($module == 5) {

            $data = $this->get_divisional_chart_details($form_data, $messages);

        } elseif ($module == 6) {

            $data = $this->get_composite_friendship_details($form_data, $messages);

        } elseif ($module == 7) {

            $data = $this->get_kp_planetary_details($form_data, $messages);

        } elseif ($module == 8) {

            $data = $this->get_kp_house_cusps_and_chart_details($form_data, $messages);

        } elseif ($module == 9) {

            $form_data['dasha_type'] = 'antar-dasha';
            $data = $this->get_vimshottari_dasha_details($form_data, $messages);

        } elseif ($module == 10) {

            $data = $this->get_sadhe_sati_details($form_data, $messages);

        } elseif ($module == 11) {

            $data = $this->get_ascendant_report_details($form_data, $messages);

        } elseif ($module == 12) {

            $data = $this->get_bhava_charts_details($form_data, $messages);

        } elseif ($module == 13) {

            $data = $this->get_sadhesati_analysis_details($form_data, $messages, $lang_type);

        } elseif ($module == 14) {

            $data = $this->get_kalsarpa_dosha_details($form_data, $messages, $lang_type);

        } elseif ($module == 15) {

            $data = $this->get_manglik_analysis_details($form_data, $messages, $lang_type);

        } elseif ($module == 16) {

            $is_planet_profiles = true;
            $data = $this->get_planetary_position_details($form_data, $messages, $lang_type, $is_planet_profiles);

        } elseif ($module == 17) {

            $data = $this->get_gemstone_suggestion_details($form_data, $messages);

        } elseif ($module == 18) {
            
            $data = $this->get_yogini_dasha_details($form_data, $messages);

        } elseif ($module == 19) {

            $form_data['dasha_type'] = 'pratyantar-dasha';
            $data = $this->get_vimshottari_dasha_details($form_data, $messages);

        }

        return $data;

    }

    public function get_basic_details($form_data, $messages) {

        $basic_astro_detail = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/basic-astro-details",$form_data, true);
        $panchag = self::exec_api_req("https://astroapi-1.divineapi.com/indian-api/v1/find-panchang", $form_data, true);
        $ascendant = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ascendant-report",$form_data, true);
        $planetary_position = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/planetary-positions",$form_data, true);
        $rdr = 'kundali-basic-details';
        $content = '';

        if ($basic_astro_detail['status'] == 1 && $panchag['status'] == 1 && $ascendant['status'] == 1 && $planetary_position['status'] == 1
        && $basic_astro_detail['data']['success'] == 1 && $panchag['data']['success'] == 1 && $ascendant['data']['success'] == 1) {

            $planetary_position = $planetary_position['data']['data'];
            $basic_astro_detail = $basic_astro_detail['data']['data'];
            $birth_date = strtotime(date_format(date_create($basic_astro_detail['date']." ".$basic_astro_detail['hour'].":".$basic_astro_detail['minute']),"Y-m-d H:i:s"));
            $moon_data = [];
            if(isset($planetary_position['planets'])
            && !empty($planetary_position['planets'])){
                foreach($planetary_position['planets'] as $key => $planets){
                    if($planets['name'] == "Moon"){
                        $moon_data = $planets;
                    }
                }    
            }

            $compact = array(
                'basic_astro_detail' => $basic_astro_detail,
                'panchag' => $panchag['data']['data'],
                'ascendant' => $ascendant['data']['data'],
                'planetary_position' => $planetary_position,
                'moon_data' => $moon_data,
                'messages' => $messages,
                'birth_date' => $birth_date,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));
            
        } else {

            return array('tran' => 0, 'msg' => $basic_astro_detail['data']['msg']);

        }

    }

    public function get_planetary_position_details($form_data, $messages, $lang_type='', $is_planet_profiles=false) {

        $planetary_position = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/planetary-positions",$form_data, true);
        $content = '';

        if ($planetary_position['status'] == 1 && $planetary_position['data']['success'] == 1) {

            $planetary_position = $planetary_position['data']['data'];
            $compact = array(
                'planetary_position' => $planetary_position,
                'messages' => $messages,
            );
            if ($is_planet_profiles) {
                $compact['lang_type'] = $lang_type;
                return array('tran' => 1, 'data' => self::rdr_temp('kundali-planet-profiles-details', $compact));
            } else {
                return array('tran' => 1, 'data' => self::rdr_temp('kundali-planetary-position-details', $compact));
            }

        } else {

            return array('tran' => 0, 'msg' => $planetary_position['data']['msg']);

        }

    }

    public function get_horoscope_chart_details($form_data, $messages) {

        $birth_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D1",$form_data, true);
        $D9_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D9",$form_data, true);
        $moon_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/MOON",$form_data, true);
        $rdr = 'kundali-horoscope-chart-details';
        $content = '';
                
        if ($birth_chart['status'] == 1 && $D9_chart['status'] == 1 && $moon_chart['status'] == 1 && $birth_chart['data']['success'] == 1) {

            $birth_chart = $birth_chart['data']['data'];
            $D9_chart = $D9_chart['data']['data'];
            $moon_chart = $moon_chart['data']['data'];
            $compact = array(
                'birth_chart' => $birth_chart,
                'D9_chart' => $D9_chart,
                'moon_chart' => $moon_chart,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $birth_chart['data']['msg']);

        }

    }

    public function get_house_cusps_and_sandhi_details($form_data, $messages) {

        $chalit_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/chalit",$form_data, true);
        $rdr = 'kundali-house-cusps-and-sandhi-details';
        $content = '';

        if ($chalit_chart['status'] == 1 && $chalit_chart['data']['success'] == 1) {

            $chalit_chart = $chalit_chart['data']['data'];
            $compact = array(
                'chalit_chart' => $chalit_chart,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $chalit_chart['data']['msg']);

        }

    }

    public function get_divisional_chart_details($form_data, $messages) {

        $sun_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/SUN",$form_data, true);
        $D2_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D2",$form_data, true);
        $D3_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D3",$form_data, true);
        $D4_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D4",$form_data, true);
        $D7_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D7",$form_data, true);
        $D10_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D10",$form_data, true);
        $D12_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D12",$form_data, true);
        $D16_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D16",$form_data, true);
        $D20_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D20",$form_data, true);
        $D24_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D24",$form_data, true);
        $D27_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D27",$form_data, true);
        $D30_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D30",$form_data, true);
        $D40_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D40",$form_data, true);
        $D45_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D45",$form_data, true);
        $D60_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/horoscope-chart/D60",$form_data, true);
        $rdr = 'kundali-divisional-chart-details';
        $content = '';

        if ($sun_chart['status'] == 1 && $D60_chart['status'] == 1 && $sun_chart['data']['success'] == 1) {

            $sun_chart = $sun_chart['data']['data'];
            $D2_chart = $D2_chart['data']['data'];
            $D3_chart = $D3_chart['data']['data'];
            $D4_chart = $D4_chart['data']['data'];
            $D7_chart = $D7_chart['data']['data'];
            $D10_chart = $D10_chart['data']['data'];
            $D12_chart = $D12_chart['data']['data'];
            $D16_chart = $D16_chart['data']['data'];
            $D20_chart = $D20_chart['data']['data'];
            $D24_chart = $D24_chart['data']['data'];
            $D27_chart = $D27_chart['data']['data'];
            $D30_chart = $D30_chart['data']['data'];
            $D40_chart = $D40_chart['data']['data'];
            $D45_chart = $D45_chart['data']['data'];
            $D60_chart = $D60_chart['data']['data'];
            $compact = array(
                'sun_chart' => $sun_chart,
                'D2_chart' => $D2_chart,
                'D3_chart' => $D3_chart,
                'D4_chart' => $D4_chart,
                'D7_chart' => $D7_chart,
                'D10_chart' => $D10_chart,
                'D12_chart' => $D12_chart,
                'D16_chart' => $D16_chart,
                'D20_chart' => $D20_chart,
                'D24_chart' => $D24_chart,
                'D27_chart' => $D27_chart,
                'D30_chart' => $D30_chart,
                'D40_chart' => $D40_chart,
                'D45_chart' => $D45_chart,
                'D60_chart' => $D60_chart,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $sun_chart['data']['msg']);

        }

    }

    public function get_composite_friendship_details($form_data, $messages) {

        $composite_friendship = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/composite-friendship",$form_data, true);
        $rdr = 'kundali-composite-friendship-details';
        $content = '';

        if ($composite_friendship['status'] == 1 && $composite_friendship['data']['success'] == 1) {

            $composite_friendship = $composite_friendship['data']['data'];
            $compact = array(
                'composite_friendship' => $composite_friendship,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $composite_friendship['data']['msg']);

        }

    }

    public function get_kp_planetary_details($form_data, $messages) {

        $KP_planetary_details = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/kp/planetary-positions", $form_data, true);
        $rdr = 'kundali-kp-planetary-details';
        $content = '';

        if ($KP_planetary_details['status'] == 1 && $KP_planetary_details['data']['success'] == 1) {

            $KP_planetary_details = $KP_planetary_details['data']['data'];
            $compact = array(
                'KP_planetary_details' => $KP_planetary_details,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $KP_planetary_details['data']['msg']);

        }

    }

    public function get_kp_house_cusps_and_chart_details($form_data, $messages) {

        $KP_house_cusps_and_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/kp/cuspal", $form_data, true);
        $rdr = 'kundali-kp-house-cusps-and-chart-details';
        $content = '';

        if ($KP_house_cusps_and_chart['status'] == 1 && $KP_house_cusps_and_chart['data']['success'] == 1) {

            $compact = array(
                'KP_house_cusps_and_chart' => $KP_house_cusps_and_chart['data']['data'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $KP_house_cusps_and_chart['data']['msg']);

        }

    }

    public function get_ascendant_report_details($form_data, $messages) {

        $ascendant_report = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ascendant-report", $form_data, true);
        $rdr = 'kundali-ascendant-report-details';
        $content = '';

        if ($ascendant_report['status'] == 1 && $ascendant_report['data']['success'] == 1) {

            $compact = array(
                'ascendant_report' => $ascendant_report['data']['data'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $ascendant_report['data']['msg']);

        }

    }

    public function get_bhava_charts_details($form_data, $messages) {

        $bhava_1 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/1", $form_data, true);
        $bhava_2 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/2", $form_data, true);
        $bhava_3 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/3", $form_data, true);
        $bhava_4 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/4", $form_data, true);
        $bhava_5 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/5", $form_data, true);
        $bhava_6 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/6", $form_data, true);
        $bhava_7 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/7", $form_data, true);
        $bhava_8 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/8", $form_data, true);
        $bhava_9 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/9", $form_data, true);
        $bhava_10 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/10", $form_data, true);
        $bhava_11 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/11", $form_data, true);
        $bhava_12 = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/bhava-kundli/12", $form_data, true);
        $rdr = 'kundali-bhava-charts-details';
        $content = '';

        if($bhava_1['status'] = 1 && $bhava_12['status'] == 1 && $bhava_1['data']['success'] == 1) {

            $bhava_1 = $bhava_1['data']['data'];
            $bhava_2 = $bhava_2['data']['data'];
            $bhava_3 = $bhava_3['data']['data']; 
            $bhava_4 = $bhava_4['data']['data']; 
            $bhava_5 = $bhava_5['data']['data']; 
            $bhava_6 = $bhava_6['data']['data']; 
            $bhava_7 = $bhava_7['data']['data']; 
            $bhava_8 = $bhava_8['data']['data']; 
            $bhava_9 = $bhava_9['data']['data']; 
            $bhava_10 = $bhava_10['data']['data'];
            $bhava_11 = $bhava_11['data']['data'];
            $bhava_12 = $bhava_12['data']['data'];
            $compact = array(
                'bhava_1' => $bhava_1,
                'bhava_2' => $bhava_2,
                'bhava_3' => $bhava_3,
                'bhava_4' => $bhava_4,
                'bhava_5' => $bhava_5,
                'bhava_6' => $bhava_6,
                'bhava_7' => $bhava_7,
                'bhava_8' => $bhava_8,
                'bhava_9' => $bhava_9,
                'bhava_10' => $bhava_10,
                'bhava_11' => $bhava_11,
                'bhava_12' => $bhava_12,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $bhava_1['data']['msg']);

        }
        
    }

    public function get_vimshottari_dasha_details($form_data, $messages) {

        $vimshottari_dasha = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/vimshottari-dasha", $form_data, true);
        $content = '';

        if ($vimshottari_dasha['status'] == 1 && $vimshottari_dasha['data']['success'] == 1) {

            $vimshottari_dasha = $vimshottari_dasha['data']['data'];
            $compact = array(
                'vimshottari_dasha' => $vimshottari_dasha,
                'messages' => $messages,
            );
            if ($form_data['dasha_type'] == 'pratyantar-dasha') {
                return array('tran' => 1, 'data' => self::rdr_temp('kundali-vimshottari-dasha-ad-pd-details', $compact));
            } else {
                return array('tran' => 1, 'data' => self::rdr_temp('kundali-vimshottari-dasha-details', $compact));
            }
            
        } else {

            return array('tran' => 0, 'msg' => $vimshottari_dasha['data']['msg']);

        }

    }

    public function get_yogini_dasha_details($form_data, $messages) {

        $yogini_dasha = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/yogini-dasha", $form_data, true);
        $rdr = 'kundali-yogini-dasha-details';
        $content = '';

        if ($yogini_dasha['status'] == 1 && $yogini_dasha['data']['success'] == 1) {

            $yogini_dasha = $yogini_dasha['data']['data'];
            $compact = array(
                'yogini_dasha' => $yogini_dasha,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $yogini_dasha['data']['msg']);

        }
        
    }

    public function get_sadhesati_analysis_details($form_data, $messages, $lang_type) {

        $sadhesati_analysis = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/sadhe-sati", $form_data, true);
        $rdr = 'kundali-sadhesati-analysis-details';
        $content = '';

        if ($sadhesati_analysis['status'] == 1 && $sadhesati_analysis['data']['success'] == 1) {

            $sadhesati_analysis = $sadhesati_analysis['data']['data'];
            $compact = array(
                'sadhesati_analysis' => $sadhesati_analysis,
                'lang_type' => $lang_type,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $sadhesati_analysis['data']['msg']);

        }

    }

    public function get_sadhe_sati_details($form_data, $messages) {

        $sadhe_sati = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/sadhe-sati", $form_data, true);
        $rdr = 'kundali-sadhesati-life-analysis-details';
        $content = '';

        if ($sadhe_sati['status'] == 1 && $sadhe_sati['data']['success'] == 1) {

            $sadhe_sati = $sadhe_sati['data']['data'];
            $compact = array(
                'sadhe_sati' => $sadhe_sati,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $sadhe_sati['data']['msg']);

        }
        
    }

    public function get_kalsarpa_dosha_details($form_data, $messages, $lang_type) {

        $kalsarpa_dosha = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/kaal-sarpa-yoga", $form_data, true);
        $rdr = 'kundali-kalsarpa-dosha-details';
        $content = '';

        if ($kalsarpa_dosha['status'] == 1 && $kalsarpa_dosha['data']['success'] == 1) {

            $kalsarpa_dosha = $kalsarpa_dosha['data']['data'];
            $compact = array(
                'kalsarpa_dosha' => $kalsarpa_dosha,
                'lang_type' => $lang_type,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $kalsarpa_dosha['data']['msg']);

        }

    }

    public function get_manglik_analysis_details($form_data, $messages, $lang_type) {

        $manglik_analysis = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/manglik-dosha", $form_data, true);
        $rdr = 'kundali-manglik-analysis-details';
        $content = '';

        if ($manglik_analysis['status'] == 1 && $manglik_analysis['data']['success'] == 1) {

            $manglik_analysis = $manglik_analysis['data']['data'];
            $compact = array(
                'manglik_analysis' => $manglik_analysis,
                'lang_type' => $lang_type,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $manglik_analysis['data']['msg']);

        }

    }

    public function get_gemstone_suggestion_details($form_data, $messages) {

        $gemstone_suggestion = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/gemstone-suggestion", $form_data, true);
        $rdr = 'kundali-gemstone-suggestion-details';
        $content = '';

        if ($gemstone_suggestion['status'] == 1 && $gemstone_suggestion['data']['success'] == 1) {

            $gemstone_suggestion = $gemstone_suggestion['data']['data'];
            $compact = array(
                'gemstone_suggestion' => $gemstone_suggestion,
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $gemstone_suggestion['data']['msg']);

        }

    }

    public static function exec_api_req($req_url, $form_data, $pass_header=false) {

        try {
                
            $options = array(
                'debug' => false,
                'form_params' => $form_data,
            );
          
            if ($pass_header) {
 
                $access_token = get_option('divine_settings_access_token_field');
                $client = new GuzzleHttp\Client(['headers' => ['Authorization' => 'Bearer ' . $access_token]]);

            } else {

                $client = new GuzzleHttp\Client();

            }

            $response = $client->post($req_url, $options);

            $status_code = $response->getStatusCode();

            if ($status_code == 200) {
                
                $res_data = $response->getBody()->getContents();
               
                $rsdata = json_decode($res_data, true);
                
                return array('status'=>1, 'data'=>$rsdata);

            } else {

                return array('status'=>0, 'msg'=> 'API response error');

            }
        
        } catch (GuzzleHttp\Exception\TransferException $exception) {

            return array('status'=>0, 'msg'=> 'Something went wrong. Please try again!');

        }

    }

    public static function get_english_content() {

        return [
            'introduction' => 'Introduction',
            'basic_astro_detail' => 'Basic Astrological Details',
            'planet_position' => 'Planetary Positions',
            'horo_chart' => 'Horoscope Charts',
            'Vimshottari_Dasha_P1' => 'Vimshottari Dasha P1',
            'Vimshottari_Dasha_P2' => 'Vimshottari Dasha P2',
            'manglik_analysis' => 'Manglik Analysis',
            'ashtakoot' => 'Ashtakoot',
            'bhakut_dosha' => 'Bhakut Dosha',
            'nadi_dosha' => 'Nadi Dosha',
            'ashtakoot_analysis' => 'Ashtakoot Analysis',
            'dashakoot' => 'Dashakoot',
            'personality_report' => 'Personality Report',
            'match_making_report' => 'Match Making Report',
            'nav_pancham_yoga' => 'Nav Pancham Yoga',
            'thank_you' => 'Thank You',
            'previous' => 'Previous',
            'next' => 'Next',
            'produced_by' => 'Produced by',
            'basic_details' => 'Basic Details',
            'date_of_birth' => 'Date of birth',
            'time_of_birth' => 'Time of birth',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'timezone' => 'Timezone',
            'ayanamsa' => 'Ayanamsa',
            'sunrise' => 'Sunrise',
            'sunset' => 'Sunset',
            'astrological_details' => 'Astrological Details',
            'varna' => 'Varna',
            'vashya' => 'Vashya',
            'yoni' => 'Yoni',
            'gan' => 'Gan',
            'nadi' => 'Nadi',
            'sign_lord' => 'Sign Lord',
            'nakshatra' => 'Nakshatra',
            'nakshatra_lord' => 'Nakshatra Lord',
            'charan' => 'Charan',
            'yog' => 'Yog',
            'karan' => 'Karan',
            'tithi' => 'Tithi',
            'tatva' => 'Tatva',
            'name_alphabet' => 'Name Alphabet',
            'paya' => 'Paya',
            'planetary_positions' => 'Planetary Positions',
            'planets' => 'Planets',
            'r' => 'R',
            'sign' => 'Sign',
            'degrees' => 'Degrees',
            'sign_lord' => 'Sign Lord',
            'house' => 'House',
            'lagna_chart' => 'Lagna Chart(Birth Chart)',
            'chalit_chart' => 'Chalit Chart',
            'moon_chart' => 'Moon Chart',
            'navmansha_chart' => 'Navmansha Chart(D9)',
            'vimshottari_dasha' => 'Vimshottari Dasha',
            'vim_note' => '* NOTE : All the dates are indicating dasha end date.',
            'manglik_detail' => 'Manglik Detail',
            'is_recommended' => 'Is Recommended?',
            'is_recommended_r1' => 'In the analysis of both the horoscopes, partner 1 and Partner 2 both are Manglik, which means there will be no adverse effects on their marriage. Based on this assessment, their match is recommended.',
            'is_recommended_r2' => 'Neither the boy nor the girl has Mangal Dosha in their horoscopes, which means there will be no adverse effects on their marriage. Based on this assessment, their match is recommended.',
            'is_recommended_r3' => 'In the analysis of both the horoscopes, partner 1 is Manglik and Partner 2 is not Manglik, which means there could be adverse effects on their marriage. Based on this assessment, their match is not recommended.',
            'is_recommended_r4' => 'In the analysis of both the horoscopes, partner 1 is not Manglik and Partner 2 is Manglik, which means there could be adverse effects on their marriage. Based on this assessment, their match is not recommended.',
            'attributes' => 'Attributes',
            'description' => 'Description',
            'total' => 'Total',
            'received' => 'Received',
            'bhakut_dosha_present' => 'Bhakoot dosha is pesent',
            'bhakut_dosha_not_present' => 'Bhakoot dosha is not pesent',
            'nadi_dosha_pesent' => 'Nadi dosha is pesent',
            'nadi_dosha_not_pesent' => 'Nadi dosha is not pesent',
            'ashtakoot_na_r1' => 'Neither of you shall be experts in worldly matters. Dissimilarity of views and lack of mutual support shall prevail between the two of you. Impracticality shall be a part of your lives and work. An unhappy married life is indicated. You shall find difficulty in intellectual tasks.',
            'ashtakoot_na_r2' => 'They will struggle to maintain a good relationship due to misunderstandings, lack of love, and an inability to connect emotionally. Hurtful actions may occur, leading to a weak bond even at the mental level.',
            'ashtakoot_na_r3' => "You won't have much money, and wealth will be scarce in your lives. You won't be seen as affluent, and your reputation may not be favorable. Being together might not always feel comfortable, and your relationship may lack pleasantness. Beautiful thoughts may not prevail, and being perfect for each other might be doubtful.",
            'ashtakoot_na_r4' => "Differences in lifestyles will make it challenging to maintain a normal relationship. The mutual attraction might be lacking. Your temperaments and thoughts may seldom align, leading to an average association at best.",
            'ashtakoot_na_r5' => "You will behave like close allies with shared interests. You are highly compatible with each other. Embracing similar opinions will strengthen your relationship.",
            'ashtakoot_na_r6' => "Arrogance and resentment will harm your relationship. There won't be much attraction between you. Your temperaments will clash, and circumstances won't be harmonious between the two of you.",
            'ashtakoot_na_r7' => "NULL",
            'ashtakoot_na_r8' => "Life will lack energy; both of you will be inactive and passive by nature. The child resulting from your union may not achieve much success or fame. Health problems may arise, and happiness might be hard to come by.",
            'ashtakoot_po_r1' => "You both will be experts in worldly matters. You'll have similar views and support each other. Being practical will be important in your lives and work. Your marriage will be happy, and you'll find success in intellectual tasks.",
            'ashtakoot_po_r2' => "They will have a strong relationship built on understanding, love, and the ability to win each other over with affection. Emotionally, they will never hurt each other, and their bond will remain strong even at the mental level.",
            'ashtakoot_po_r3' => "You'll have a lot of money, with no shortage of wealth in your lives. People will see you as affluent, and you'll have a good reputation. Being together will feel comfortable, and your relationship will always be pleasant. Beautiful thoughts will be a part of your lives, and you are perfect for each other.",
            'ashtakoot_po_r4' => "Having similar lifestyles will make it easier to have a normal relationship. The mutual attraction might be moderate. Your temperaments and thoughts may not always align, but overall it will be an average association.",
            'ashtakoot_po_r5' => "You will act like enemies with varying interests. You are highly incompatible with each other. Differences in opinions will lead to the failure of the relationship.",
            'ashtakoot_po_r6' => "Humility and kindness will positively affect your relationship. You will be attracted to each other. Your temperaments will complement one another, and circumstances will be harmonious between you two.",
            'ashtakoot_po_r7' => "NULL",
            'ashtakoot_po_r8' => "Both of you will live energetic lives as active and dynamic individuals. Your child will be highly successful and earn fame. You'll enjoy good health, and happiness will fill your life.",
            'personality_report_same' => "Personality Report (SAME)",
            'personality_report' => "Personality Report",
            'ASHTAKOOT_cp' => "ASHTAKOOT",
            'DASHAKOOT_cp' => "DASHAKOOT",
            'MANGLIK_cp' => "MANGLIK",
            'p1_p2' => "P1\P2",
            'Sun' => "Sun",
            'Moon' => "Moon",
            'Mercury' => "Mercury",
            'Venus' => "Venus",
            'Mars' => "Mars",
            'Jupiter' => "Jupiter",
            'Saturn' => "Saturn",
            'Uranus' => "Uranus",
            'Neptune' => "Neptune",
            'Pluto' => "Pluto",
            'Rahu' => "Rahu",
            'Ketu' => "Ketu",
            'sun' => "Sun",
            'moon' => "Moon",
            'mercury' => "Mercury",
            'venus' => "Venus",
            'mars' => "Mars",
            'jupiter' => "Jupiter",
            'saturn' => "Saturn",
            'uranus' => "Uranus",
            'neptune' => "Neptune",
            'pluto' => "Pluto",
            'rahu' => "Rahu",
            'ketu' => "Ketu",
            'ascendant' => "Ascendant",
            'house_cusps_and_sandhi' => "House Cusps and Sandhi",
            'divisional_charts' => "Divisional Charts",
            'composite_friendship_table' => "Composite Friendship Table",
            'kp_planetary_details' => "KP Planetary Details",
            'kp_house_cusps_and_chart' => "KP House Cusps and Chart",
            'ascendant_report' => "Ascendant Report",
            'bhava_kundli' => "Bhava Kundli",
            'yogini_dasha' => "Yogini Dasha",
            'sadhesati_analysis' => "Sadhesati Analysis",
            'sadhesati_life_analysis' => "Sadhesati Life Analysis",
            'kalsarpa_dosha' => "Kalsarpa Dosha",
            'planet_profiles' => "Planet Profiles",
            'gemstone_suggestions' => "Gemstone Suggestions",
            'print_save' => "Print / Save",
            'place_of_birth' => "Place of birth",
            'ghat_chakra' => "Ghat Chakra",
            'month' => "Month",
            'day' => "Day",
            'prahar' => "Prahar",
            'panchang_details' => "Panchang Details",
            'ascendant_lord' => "Ascendant Lord",
            'benefic' => "benefic",
            'malefic' => "malefic",
            'neutral' => "neutral",
            'lagna_text' => "The Ascendant, also known as the Lagna, signifies the degree of the zodiac sign that is ascending above the eastern horizon during an individual's birth. This pivotal point holds immense significance within the natal or Lagna chart. Essentially, it establishes the initial house of the horoscope, subsequently shaping the arrangement of the remaining houses according to the sequence of the zodiac signs. As a result, the Lagna not only defines the rising sign but also serves as the foundation for delineating all the other houses present in the chart.",
            'moon_text' => "The Moon Chart serves as a crucial predictive instrument, with planetary combinations carrying greater significance when they manifest in both the Moon and Lagna Charts.",
            'navmasa_text' => 'Among the various divisional charts, the Navmansha Chart holds paramount importance. "Navmansha" denotes the division of a specific zodiac sign into nine parts, with each division, known as an "Amsa," spanning 3 degrees and 20 minutes.',
            'midheaven' => "Midheaven",
            'bhav_madhya' => "Bhav Madhya",
            'bhav_sandhi' => "Bhav Sandhi",
            'chalit_text' => "House cusps delineate the conceptual divisions between different Houses, much like how Sign cusps mark the divisions between Signs. These cusps hold a position of prominence, representing the pivotal and influential points within each house. Planetary placements situated at these cusps exert the most potent influence, embodying the quintessential essence and impact associated with that particular house.",
            'sun_chart' => "Sun Chart",
            'sun_chart_text' => "Health, Constitution, Body",
            'hora_chart' => "Hora Chart(D2)",
            'hora_chart_text' => "Finance, Wealth, Prosperity",
            'dreshkan_chart' => "Dreshkan Chart(D3)",
            'dreshkan_chart_text' => "Brothers, Sisters",
            'chathurthamasha_chart' => "Chathurthamasha Chart(D4)",
            'chathurthamasha_chart_text' => "Fortunes, Luck of native",
            'saptamansha_chart' => "Saptamansha Chart(D7)",
            'saptamansha_chart_text' => "Impregnation, Birth of the child",
            'dashamansha_chart' => "Dashamansha Chart(D10)",
            'dashamansha_chart_text' => "Livelihood, Profession",
            'dwadasha_chart' => "Dwadasha Chart(D12)",
            'dwadasha_chart_text' => "Parents, Paternal happiness",
            'shodashamsha_chart' => "Shodashamsha Chart(D16)",
            'shodashamsha_chart_text' => "Happiness,miseries,conveyance",
            'vishamansha_chart' => "Vishamansha Chart(D20)",
            'vishamansha_chart_text' => "Spritual progress,worship",
            'chaturvimshamsha_chart' => "Chaturvimshamsha(D24)",
            'chaturvimshamsha_chart_text' => "Academic achievement,education",
            'bhamsha_chart' => "Bhamsha Chart(D27)",
            'bhamsha_chart_text' => "Physical strength, stamina",
            'trishamansha_chart' => "Trishamansha Chart(30)",
            'trishamansha_chart_text' => "Evil, Adversaties of life",
            'khavedamsha_chart' => "Khavedamsha Chart(40)",
            'khavedamsha_chart_text' => "Auspicious & inauspicious effect",
            'akshvedansha_chart' => "Akshvedansha Chart(45)",
            'akshvedansha_chart_text' => "Character and conduct of the native",
            'shashtymsha_chart' => "Shashtymsha Chart(60)",
            'shashtymsha_chart_text' => "Shows general happiness",
            'permanent_friendship' => "Permanent Friendship",
            'temporal_friendship' => "Temporal Friendship",
            'fivefold_friendship' => "Five-fold Friendship",
            'sub_lord' => "Sub Lord",
            'ss_lord' => "S-S Lord",
            'lord' => "Lord",
            'symbol' => "Symbol",
            'characteristics' => "Characteristics",
            'lucky_gems' => "Lucky gems",
            'day_of_fast' => "Day of fast",
            'sade_table_title' => "Presence Of Sadhesati In Your Horoscope",
            'sadhesati' => "Sadhesati",
            'consideration_date' => "Consideration Date",
            'moon_sign' => "Moon Sign",
            'saturn_retrograde' => "Saturn retrograde?",
            'remedies_sadhesati' => "Remedies Of Sadhesati",
            'sadhesati_life_analysis' => "Sadhesati Life Analysis",
            'saturn_sign' => "Saturn Sign",
            'saturn_ratro' => "Is Saturn Retro?",
            'phase_type' => "Phase Type",
            'date' => "Date",
            'summary' => "Summary",
            'summary1' => "Sadhesati Rise Phase starting.",
            'summary2' => "Sadhesati Rise Phase ending and with this Sadhesati is also ending.",
            'summary3' => "Sadhesati Peak Phase starting with Rise Phase ending.",
            'summary4' => "Sadhesati Peak Phase ending.",
            'summary5' => "Sadhesati Setting Phase starting with Peak Phase ending.",
            'summary6' => "Sadhesati Setting Phase ending and with this Sadhesati is also ending.",
            'is_kalsarpa_present' => "Is Kalsarpa present?",
            'intensity' => "Intensity",
            'kalsarpa_name' => "Kalsarpa Name",
            'direction' => "Direction",
            'remedies_kaal' => "Remedies Of kaal Sarp Dosh",
            'mnglik' => "Manglik",
            'remedies_manglik' => "Remedies Of Manglik Dosha",
            'lucky_stone' => "Lucky Stone",
            'life_stone' => "Life Stone",
            'dasha_stone' => "Dasha Stone",
            'substitutes' => "Substitutes",
            'finger' => "Finger",
            'day' => "Day",
            'time_to_wear' => "Time to wear",
            'mantra' => "Mantra",
            'in_horo' => "in your horoscope",
            'zodiac_sign' => "Zodiac Sign",
            'planet_degree' => "Planet Degree",
            'lord_of' => "Lord Of",
            'is_in' => "Is in",
            'combust_awashtha' => "Combust/Awashtha",
            'lahiri' => "Lahiri",
            'Kalsarpa_In_Horoscope' => "Presence Of Kalsarpa Dosha In Your Horoscope",
            'pp_sun' => "Sun is said to be the significator (Karaka) of health, vitality, energy, strength, father, honour, prestige, pride, fame, courage and personal power. Sun is royal and aristocratic planet which represents the conscious ego and the soul and deals with self realisation.",
            'pp_moon' => "Moon has the capacity to influence the mind, will power and emotions. Moon is connected with water and natural forces, it’s a wavering planet which deals with changes.",
            'pp_mercury' => "Mercury is the planet of intelligence and education, it's associated with speech and logic and thus has its impact on communication skills of the individual.",
            'pp_venus' => "Venus is considered as the significator (karaka) of sexual desires (kama), libido, wife. It deals with passion, marriage, luxury articles, ornaments, vehicles, comforts and beauty.",
            'pp_mars' => "As per astrology Mars is the planet which deals with courage and dictatorship. Mars is considered as the planet of action and expansion.",
            'pp_jupiter' => "Jupiter is said to be the significator (karaka) of wealth, knowledge, guru, husband, son, moral values, education, grandparents and royal honors. It indicates religious perceptions, devotion and faith of the native.",
            'pp_saturn' => "Saturn is a slow moving planet. It is called as the planet of justice, logic and destructive forces. It deals with calamities and death. Saturn is also considered as a teacher.",
            'pp_rahu' => "Being strange and unconventional planet Rahu represents materialism and deals with harsh speech, dearth and wants. Rahu is said to be the planet of transcendentalism. It denotes foreign land and foreign travels.",
            'Ascendant' => "Ascendant",
            'ascendant' => "Ascendant",
            'tara' => "Tara",
            'graha_maitri' => "Graha Maitri",
            'gana' => "Gana",
            'bhakoota' => "Bhakoota",
            'dina' => "Dina",
            'rashi' => "Rashi",
            'rasyadhipati' => "Rasyadhipati",
            'vedha' => "Vedha",
            'mahendra' => "Mahendra",
            'streedargha' => "Streedargha",
            'rajju' => "Rajju",
            'dashamasa_chart' => "Dashamasa Dhart",
            'general_observation' => "General Observation",
            'specific_observation' => "Specific Observation",
            'dasha_observation' => "Dasha Observation",
            'job_observation' => "Jobs Observation",
            'surya_and_chandra' => "Surya And Chandra",
            'maha_dasha' => "Maha Dasha",
            'antar_dasha' => "Antar Dasha",
            'start_date' => "Start Date",
            'end_date' => "End Date",
            'probability' => "Probability",
            'total_points_Earned' => "Total Points Earned",
            'points' => "Points",
            'job_ias' => "IAS Officer",
            'job_ips' => "IPS Officer",
            'job_professor' => "Professor",
            'job_bankpo' => "Bank PO",
            'job_ndadefence' => "NDA Defence Officer",
            'job_scientificresearch' => "Scientific Research Officer",
            'job_railways' => "Railway Officer",
            'job_incometax' => "Income Tax Officer",
            'job_stateservices' => "State Services Officer",
            'job_electricity' => "Electricity Officer",
            'job_roads' => "Road Officer",
            'job_watersupply' => "Watersupply Officer",
            'job_pwd' => "PWD",
            'job_police' => "Police Officer",
            'job_fire' => "Fire Officer",
            'job_observation_red' => "The Astrological evaluation suggests that your chances of attaining a government job as <u>__JOBNAME__</u>, appear to be very limited or almost non-existent. The planetary positions indicate significant obstacles or limitations that could hinder your pursuit of this particular career path.",
            'job_observation_yellow' => "The Astrological assessment suggests that you possess a moderate potential for securing a government job as <u>__JOBNAME__</u>. While certain planetary aspects are supportive, you might need to overcome some challenges on your journey towards achieving this esteemed position.",
            'job_observation_green' => "Congratulations! Based on the Astrological analysis, the alignment of planetary influences indicates that you have a strong and favorable chance of becoming <u>__JOBNAME__</u>, highlighting a promising path towards your goal.",
            'placement_of_sun' => "Sun in Astrology and Government Careers",
            'placement_of_10_loard' => "Astrology's 10th House and Career",
            'placement_of_9_loard' => "Astrology's 9th House and Government Careers",
            'placement_of_saturn' => "Saturn's Role in Government Careers",
            'hight_message_1' => "High - In this period you have high chances of getting selected in the Government Job",
            'low_message_2' => "Low - In this period you have low chances of getting selected in the Government Job",
            'medium_message_3' => "Medium - In this period you have medium chances of getting selected in the Government Job",
            'remedies' => "Remedies",
            'remedies_gov_job' => "Remedies Of Government Job",
            'leisure' => "Leisure Travel",
            'leisure_heading_1' => "Travel Destinations: 3rd & 12th Lord Insights",
            'leisure_heading_2' => "Journey Opportunities: Evaluating 3rd Lord's Strength",
            'leisure_heading_3' => "5-Year Travel Forecast & Trends",
            'leisure_observation' => "Leisure Travel Final Observation",
            'comment' => "Comment",
            'points_Earned' => "Points Earned",
            'work_travel' => "Work Travel",
            'work_travel_heading_1' => "Work Destinations: Insights from 12th & 10th Lords",
            'work_travel_heading_2' => "Overseas Work Opportunities: Assessing the 12th Lord",
            'work_travel_heading_3' => "Rahu & 10th Lord: Unexpected Career Journeys",
            'work_travel_heading_4' => "Key Positioning: Analyzing Kendra Houses for Work Travel",
            'work_travel_heading_5' => "5-Year Work Travel Forecast & Trends",
            'work_travel_observation' => "Work Travel Final Observation",
            'education' => "Education Travel",
            'education_heading_1' => "Study Abroad & Higher Learning: Insights from 12th & 9th Lords",
            'education_heading_2' => "Overseas Learning: Power of the 12th Lord",
            'education_heading_3' => "Unexpected Academic Pursuits: Rahu & 9th Lord",
            'education_heading_4' => "Stability in Education: Analyzing Kendra Houses",
            'education_heading_5' => "Study Abroad: 5-Year Prospects & Trends",
            'education_observation' => "Education Travel Final Observation",
            'settlement' => "Foreign Settlement",
            'settlement_heading_1' => "Home Abroad: Insights from 12th & 4th Lords",
            'settlement_heading_2' => "Financial Stability Overseas: 12th & 2nd Lords",
            'settlement_heading_3' => "Rahu's Influence on Global Settlement",
            'settlement_heading_4' => "Permanent Residency: 5-Year Prospects & Trends",
            'settlement_observation' => "Foreign Settlement Final Observation",
            'general_remedies' => "General Remedies",
            'specific_remedies' => "Specific Remedies",
            'gemstone' => "Gemstone",
            'leisure_content' => "Leisure travel can encompass a wide variety of experiences and preferences. When you're tired of the same old monotonous regime of your life, an enchanting getaway becomes must. Leisure and fun are equally important for mental and emotional well being. For a leisure trip you can prefer beach vacation, adventure travel, cultural tourism, nature and wildlife expedition, wellness and spa retreats, cruise vacations, sports tourism, etc.",
            'work_desc' => "A foreign work trip, also known as a business trip or international business travel, refers to a journey taken by an individual or group of individuals for work-related purposes to a country other than their own. The foreign trips serve various purposes like, negotiations, conferences, training and workshops, project launch, client relations, research and market exploration, cultural exchange, collaborations, etc.",
            'eduction_desc' => "A foreign education trip, often referred to as a study abroad program or international educational travel, involves students or learners traveling to another country to pursue educational opportunities, gain cultural experiences, and enhance their academic and personal growth. Foreign education can provide number of experiences such as academic pursuits, cultural exchange, language learning, career opportunities, etc.",
            'leisure_danger' => 'The Astrological evaluation suggests that your chances of embarking on leisure travel abroad appear to be very limited or almost non-existent. The planetary positions indicate significant obstacles or limitations that could hinder your pursuit of international adventures and experiences.',
            'leisure_warning' => 'The Astrological assessment suggests that you possess a moderate potential for undertaking leisure travel abroad. While certain planetary aspects are supportive, you might need to overcome some challenges on your journey towards experiencing new destinations and cultures. Safe and adventurous travels!',
            'leisure_success' => 'Congratulations! Based on the Astrological analysis, the alignment of planetary influences suggests that you have a strong and favorable chance of embarking on leisure travel abroad. The stars seem to align, indicating a promising journey towards your dream destinations. Safe travels!',
            'work_travel_danger' => 'The Astrological evaluation suggests that your chances of embarking on work-related travel abroad appear to be very limited or almost non-existent. The planetary positions indicate significant obstacles or limitations that could hinder your pursuit of global professional opportunities.',
            'work_travel_warning' => 'The Astrological assessment suggests that you possess a moderate potential for undertaking work-related travel abroad. While certain planetary aspects are supportive, you might need to overcome some challenges on your journey towards expanding your professional horizons internationally. Safe and fruitful travels!',
            'work_travel_success' => 'Congratulations! Based on the Astrological analysis, the alignment of planetary influences suggests that you have a strong and favorable chance of embarking on work-related travel abroad. The stars seem to align, indicating a promising opportunity for your professional growth on an international scale. Safe and productive travels!',
            'settlement_danger' => 'The Astrological evaluation suggests that your chances of settling abroad permanently appear to be very limited or almost non-existent. The planetary positions indicate significant obstacles or limitations that could hinder your pursuit of a long-term life overseas. Consider every possibility and keep an open mind to other opportunities!',
            'settlement_warning' => 'The Astrological assessment suggests that you possess a moderate potential for settling abroad permanently. While certain planetary aspects are supportive, you might need to overcome some challenges on your journey towards establishing a new life in a different country. Stay optimistic and navigate your path with determination!',
            'settlement_success' => 'Congratulations! Based on the Astrological analysis, the alignment of planetary influences suggests that you have a strong and favorable chance of settling abroad permanently. The stars seem to align, offering a promising pathway towards making a home in your desired foreign land. Embark on this life-changing adventure with confidence!',
            'education_danger' => 'The Astrological evaluation suggests that your chances of embarking on education-related travel abroad appear to be very limited or almost non-existent. The planetary positions indicate significant obstacles or limitations that could hinder your pursuit of global educational opportunities. Stay resilient and explore alternative avenues!',
            'education_warning' => 'The Astrological assessment suggests that you possess a moderate potential for undertaking education-related travel abroad. While certain planetary aspects are supportive, you might need to overcome some challenges on your journey towards acquiring international academic experiences. Stay focused and embark on enlightening travels!',
            'education_success' => 'Congratulations! Based on the Astrological analysis, the alignment of planetary influences suggests that you have a strong and favorable chance of embarking on education-related travel abroad. The stars seem to align, indicating a promising pathway towards international academic pursuits. Pursue your educational dreams and safe travels!',
            'sun_analysis' => 'Sun Analysis:',
            '10_analysis' => '10th House Analysis:',
            '9_analysis' => '9th House Analysis:',
            'saturn_analysis' => 'Saturn Analysis:',
            'sun_kendra' => 'Sun in Kendra House',
            'mars_kendra' => 'Mars in Kendra House',
            'jupiter_kendra' => 'Jupiter in Kendra House',
            'gem_ruby' => 'Ruby',
            'gem_akoyapearl' => 'Akoya Pearl',
            'gem_redcoral' => 'Red Coral',
            'gem_emerald' => 'Emerald',
            'gem_yellowsapphire' => 'Yellow Sapphire',
            'gem_diamond' => 'Diamond',
            'gem_bluesapphire' => 'Blue Sapphire',
            'gem_gomedhesonite)' => 'Onyx (Hessonite)',
            'gem_catseye' => "cat's Eye",
            'remedies_con' => "In conclusion, as we delve into the insights provided by astrological analysis, it is important to remember that while the celestial influences can offer guidance and suggestions, personal effort, dedication, and proactive choices also play a significant role in shaping one's career journey. With these considerations in mind, here are some remedies that can complement your endeavors and potentially enhance your path in the realm of government and public service.",
        ];

    }

    public static function get_hindi_content() {

        return [
            "introduction" => "परिचय", 
            "basic_astro_detail" => "बुनियादी ज्योतिषीय विवरण", 
            "planet_position" => "ग्रहों की स्थिति", 
            "horo_chart" => "राशिफल चार्ट", 
            "Vimshottari_Dasha_P1" => "विंशोत्तरी दशा प1", 
            "Vimshottari_Dasha_P2" => "विंशोत्तरी दशा पृ2", 
            "manglik_analysis" => "मांगलिक विश्लेषण", 
            "ashtakoot" => "अष्टकूट", 
            "bhakut_dosha" => "भकूट दोष", 
            "nadi_dosha" => "नाड़ी दोष", 
            "ashtakoot_analysis" => "अष्टकूट विश्लेषण", 
            "dashakoot" => "दशकूट", 
            "personality_report" => "व्यक्तित्व रिपोर्ट", 
            "match_making_report" => "मैच मेकिंग रिपोर्ट", 
            "nav_pancham_yoga" => "नव पंचम योग", 
            "thank_you" => "धन्यवाद", 
            "previous" => "पहले का", 
            "next" => "अगला", 
            "produced_by" => "द्वारा निर्मित", 
            "basic_details" => "बुनियादी विवरण", 
            "date_of_birth" => "जन्म की तारीख", 
            "time_of_birth" => "जन्म का समय", 
            "latitude" => "अक्षांश", 
            "longitude" => "देशान्तर", 
            "timezone" => "समय क्षेत्र", 
            "ayanamsa" => "अयनांश गणना", 
            "sunrise" => "सूर्योदय", 
            "sunset" => "सूर्यास्त", 
            "astrological_details" => "ज्योतिषीय विवरण", 
            "varna" => "वार्ना", 
            "vashya" => "वास्या", 
            "yoni" => "योनि", 
            "gan" => "गण मन", 
            "nadi" => "नाड़ी", 
            "sign_lord" => "संकेत स्वामी", 
            "nakshatra" => "नक्षत्र", 
            "nakshatra_lord" => "नक्षत्र स्वामी", 
            "charan" => "चरण", 
            "yog" => "योग", 
            "karan" => "करण", 
            "tithi" => "तिथि", 
            "tatva" => "तत्त्व", 
            "name_alphabet" => "नाम वर्णमाला", 
            "paya" => "पाया", 
            "planetary_positions" => "ग्रहों की स्थिति", 
            "planets" => "ग्रहों", 
            "r" => "आर", 
            "sign" => "संकेत", 
            "degrees" => "डिग्री", 
            "house" => "घर", 
            "lagna_chart" => "लग्न कुंडली (जन्म कुंडली)", 
            "chalit_chart" => "चालिट चार्ट", 
            "moon_chart" => "चंद्र कुंडली", 
            "navmansha_chart" => "नवमांश चार्ट(D9)", 
            "vimshottari_dasha" => "विंशोत्तरी दशा", 
            "vim_note" => "* नोट: सभी तिथियां दशा समाप्ति तिथि का संकेत दे रही हैं।", 
            "manglik_detail" => "मांगलिक विवरण", 
            "is_recommended" => "इसकी सिफारिश की जाती है?", 
            "is_recommended_r1" => "दोनों कुंडलियों के विश्लेषण में, साथी 1 और साथी 2 दोनों ही मांगलिक हैं, जिससे इसका मतलब है कि उनके विवाह पर कोई भी नकारात्मक प्रभाव नहीं होगा। इस आकलन के आधार पर, उनके मिलान की सिफारिश की जाती है।", 
            "is_recommended_r2" => "न तो लड़के की कुंडली में हैं मंगल दोष और न ही लड़की की कुंडली में, जिससे इसका मतलब है कि उनके विवाह पर कोई भी नकारात्मक प्रभाव नहीं होगा। इस आकलन के आधार पर, उनके मिलान की सिफारिश की जाती है।", 
            "is_recommended_r3" => "दोनों कुंडलियों के विश्लेषण में, साथी 1 मांगलिक हैं और साथी 2 मांगलिक नहीं हैं, जिसका मतलब है कि उनके विवाह पर नकारात्मक प्रभाव हो सकता है। इस आकलन के आधार पर, उनका मिलान सिफारिश नहीं किया जाता।", 
            "is_recommended_r4" => "दोनों कुंडलियों के विश्लेषण में, साथी 1 मांगलिक नहीं हैं और साथी 2 मांगलिक हैं, जिसका मतलब है कि उनके विवाह पर नकारात्मक प्रभाव हो सकता है। इस आकलन के आधार पर, उनका मिलान सिफारिश नहीं किया जाता।", 
            "attributes" => "गुण", 
            "description" => "विवरण", 
            "total" => "कुल", 
            "received" => "प्राप्त", 
            "bhakut_dosha_present" => "भकूट दोष व्याप्त है", 
            "bhakut_dosha_not_present" => "भकूट दोष मौजूद नहीं है", 
            "nadi_dosha_pesent" => "नाड़ी दोष विद्यमान है", 
            "nadi_dosha_not_pesent" => "नाड़ी दोष मौजूद नहीं है", 
            "ashtakoot_na_r1" => "तुममें से कोई भी सांसारिक मामलों में विशेषज्ञ नहीं होगा। आप दोनों के बीच विचारों में असमानता और आपसी सहयोग की कमी रहेगी। अव्यवहारिकता आपके जीवन और कार्य का हिस्सा होगी। दुःखी वैवाहिक जीवन का संकेत मिलता है। बौद्धिक कार्यों में कठिनाई आएगी।", 
            "ashtakoot_na_r2" => "ग़लतफहमियों, प्यार की कमी और भावनात्मक रूप से जुड़ने में असमर्थता के कारण उन्हें एक अच्छा रिश्ता बनाए रखने के लिए संघर्ष करना पड़ेगा। आहत करने वाले कार्य हो सकते हैं, जिससे मानसिक स्तर पर भी बंधन कमजोर हो सकता है।", 
            "ashtakoot_na_r3" => "आपके पास ज़्यादा पैसा नहीं होगा, और आपके जीवन में धन की कमी होगी। आप संपन्न नहीं दिखेंगे और आपकी प्रतिष्ठा भी अनुकूल नहीं होगी। एक साथ रहना हमेशा सहज महसूस नहीं हो सकता है, और आपके रिश्ते में सुखदता की कमी हो सकती है। सुंदर विचार प्रबल नहीं हो सकते हैं, और एक-दूसरे के लिए परिपूर्ण होना संदिग्ध हो सकता है।", 
            "ashtakoot_na_r4" => "जीवनशैली में अंतर के कारण सामान्य संबंध बनाए रखना चुनौतीपूर्ण हो जाएगा। आपसी आकर्षण में कमी हो सकती है। आपके स्वभाव और विचार शायद ही कभी मेल खाते हों, जिससे एक औसत संगति बनेगी।", 
            "ashtakoot_na_r5" => "आप साझा हितों वाले करीबी सहयोगियों की तरह व्यवहार करेंगे। आप एक-दूसरे के प्रति अत्यधिक अनुकूल हैं। समान राय अपनाने से आपका रिश्ता मजबूत होगा।", 
            "ashtakoot_na_r6" => "अहंकार और नाराजगी आपके रिश्ते को नुकसान पहुंचाएगी। आपके बीच ज्यादा आकर्षण नहीं रहेगा. आपके स्वभाव में टकराव होगा और आप दोनों के बीच परिस्थितियाँ सामंजस्यपूर्ण नहीं रहेंगी।", 
            "ashtakoot_na_r7" => "व्यर्थ", 
            "ashtakoot_na_r8" => "जीवन में ऊर्जा की कमी होगी; आप दोनों स्वभाव से निष्क्रिय और निष्क्रिय रहेंगे। आपके मिलन से उत्पन्न संतान को अधिक सफलता या प्रसिद्धि नहीं मिल सकती है। स्वास्थ्य संबंधी समस्याएं उत्पन्न हो सकती हैं और ख़ुशी मिलना मुश्किल हो सकता है।", 
            "ashtakoot_po_r1" => "आप दोनों सांसारिक मामलों में विशेषज्ञ होंगे। आपके विचार समान होंगे और आप एक-दूसरे का समर्थन करेंगे। व्यावहारिक होना आपके जीवन और कार्य में महत्वपूर्ण रहेगा। आपका वैवाहिक जीवन सुखमय रहेगा और बौद्धिक कार्यों में सफलता मिलेगी।", 
            "ashtakoot_po_r2" => "उनके बीच एक मजबूत रिश्ता होगा जो समझ, प्यार और एक-दूसरे को स्नेह से जीतने की क्षमता पर आधारित होगा। भावनात्मक रूप से वे एक-दूसरे को कभी ठेस नहीं पहुंचाएंगे और मानसिक स्तर पर भी उनका बंधन मजबूत रहेगा।", 
            "ashtakoot_po_r3" => "आपके पास बहुत सारा पैसा होगा, आपके जीवन में धन की कोई कमी नहीं होगी। लोग आपको अमीर देखेंगे और आपकी अच्छी प्रतिष्ठा होगी। साथ रहने से आरामदायक महसूस होगा और आपका रिश्ता हमेशा सुखद रहेगा। सुंदर विचार आपके जीवन का हिस्सा होंगे, और आप एक-दूसरे के लिए परिपूर्ण होंगे।", 
            "ashtakoot_po_r4" => "समान जीवनशैली अपनाने से सामान्य संबंध बनाना आसान हो जाएगा। आपसी आकर्षण मध्यम हो सकता है। हो सकता है कि आपके स्वभाव और विचार हमेशा एक समान न हों, लेकिन कुल मिलाकर यह एक औसत जुड़ाव होगा।", 
            "ashtakoot_po_r5" => "आप अलग-अलग हितों वाले दुश्मनों की तरह व्यवहार करेंगे। आप एक दूसरे के साथ अत्यधिक असंगत हैं। विचारों में मतभेद रिश्ते की विफलता का कारण बनेगा।", 
            "ashtakoot_po_r6" => "विनम्रता और दयालुता आपके रिश्ते पर सकारात्मक प्रभाव डालेगी। आप एक-दूसरे के प्रति आकर्षित होंगे। आपके स्वभाव एक-दूसरे के पूरक होंगे और आप दोनों के बीच परिस्थितियाँ सामंजस्यपूर्ण होंगी।", 
            "ashtakoot_po_r7" => "व्यर्थ", 
            "ashtakoot_po_r8" => "आप दोनों सक्रिय और गतिशील व्यक्तियों के रूप में ऊर्जावान जीवन जिएंगे। आपकी संतान अत्यधिक सफल होगी और प्रसिद्धि अर्जित करेगी। आप अच्छे स्वास्थ्य का आनंद लेंगे और आपका जीवन खुशियों से भर जाएगा।", 
            "personality_report_same" => "व्यक्तित्व रिपोर्ट (समान)", 
            "ASHTAKOOT_cp" => "अष्टकूट", 
            "DASHAKOOT_cp" => "दशकूट", 
            "MANGLIK_cp" => "मांगलिक", 
            "p1_p2" => "पी1पी2", 
            "Sun" => "रवि", 
            "Moon" => "चंद्रमा", 
            "Mercury" => "बुध", 
            "Venus" => "शुक्र", 
            "Mars" => "मंगल", 
            "Jupiter" => "बृहस्पति", 
            "Saturn" => "शनि", 
            "Uranus" => "अरुण", 
            "Neptune" => "नेपच्यून", 
            "Pluto" => "प्लूटो", 
            "Rahu" => "राहु", 
            "Ketu" => "केतु", 
            "sun" => "रवि", 
            "moon" => "चंद्रमा", 
            "mercury" => "बुध", 
            "venus" => "शुक्र", 
            "mars" => "मंगल", 
            "jupiter" => "बृहस्पति", 
            "saturn" => "शनि", 
            "uranus" => "अरुण", 
            "neptune" => "नेपच्यून", 
            "pluto" => "प्लूटो", 
            "rahu" => "राहु", 
            "ketu" => "केतु", 
            "ascendant" => "प्रबल",
            "रवि" => "रवि", 
            "चंद्रमा" => "चंद्रमा", 
            "बुध" => "बुध", 
            "शुक्र" => "शुक्र", 
            "मंगल" => "मंगल", 
            "बृहस्पति" => "बृहस्पति", 
            "शनि" => "शनि", 
            "अरुण" => "अरुण", 
            "नेपच्यून" => "नेपच्यून", 
            "प्लूटो" => "प्लूटो", 
            "राहु" => "राहु", 
            "केतु" => "केतु", 
            "लग्न" => "लग्न", 
            "house_cusps_and_sandhi" => "हाउस क्यूस्प्स और संधि", 
            "divisional_charts" => "संभागीय चार्ट", 
            "composite_friendship_table" => "समग्र मैत्री तालिका", 
            "kp_planetary_details" => "केपी ग्रहों का विवरण", 
            "kp_house_cusps_and_chart" => "केपी हाउस क्यूस्प्स और चार्ट", 
            "ascendant_report" => "लग्न रिपोर्ट", 
            "bhava_kundli" => "भाव कुंडली", 
            "yogini_dasha" => "योगिनी दशा", 
            "sadhesati_analysis" => "साढ़ेसाती विश्लेषण", 
            "sadhesati_life_analysis" => "साढ़ेसाती जीवन विश्लेषण", 
            "kalsarpa_dosha" => "कालसर्प दोष", 
            "planet_profiles" => "ग्रह प्रोफाइल", 
            "gemstone_suggestions" => "रत्न सुझाव", 
            "print_save" => "प्रिंट/सहेजें", 
            "place_of_birth" => "जन्म स्थान", 
            "ghat_chakra" => "घट चक्र", 
            "month" => "महीना", 
            "day" => "दिन", 
            "prahar" => "प्राहा", 
            "panchang_details" => "पंचांग विवरण", 
            "ascendant_lord" => "लग्नेश", 
            "benefic" => "शुभ", 
            "malefic" => "हानिकारक", 
            "neutral" => "तटस्थ", 
            "lagna_text" => "लग्न, जिसे लग्न के नाम से भी जाना जाता है, राशि चक्र की उस डिग्री को दर्शाता है जो किसी व्यक्ति के जन्म के दौरान पूर्वी क्षितिज से ऊपर उठ रही है। यह निर्णायक बिंदु जन्म कुंडली या लग्न कुंडली में अत्यधिक महत्व रखता है। अनिवार्य रूप से, यह कुंडली के प्रारंभिक घर को स्थापित करता है, बाद में राशियों के क्रम के अनुसार शेष घरों की व्यवस्था को आकार देता है। परिणामस्वरूप, लग्न न केवल उभरते हुए चिन्ह को परिभाषित करता है बल्कि चार्ट में मौजूद अन्य सभी घरों को चित्रित करने की नींव के रूप में भी कार्य करता है।", 
            "moon_text" => "चंद्र चार्ट एक महत्वपूर्ण भविष्य कहनेवाला उपकरण के रूप में कार्य करता है, जब ग्रह संयोजन चंद्रमा और लग्न चार्ट दोनों में प्रकट होते हैं तो उनका अधिक महत्व होता है।", 
            "navmasa_text" => 'विभिन्न प्रभागीय चार्टों में से, नवमांश चार्ट सर्वोपरि महत्व रखता है। "नवमांश" एक विशिष्ट राशि चक्र को नौ भागों में विभाजित करने को दर्शाता है, प्रत्येक भाग को "अम्सा" के रूप में जाना जाता है, जो 3 डिग्री और 20 मिनट तक फैला होता है।', 
            "midheaven" => "मध्यआकाश", 
            "bhav_madhya" => "भाव मध्य", 
            "bhav_sandhi" => "भाव संधि", 
            "chalit_text" => "हाउस क्यूस्प्स विभिन्न सदनों के बीच वैचारिक विभाजन को चित्रित करते हैं, ठीक उसी तरह जैसे साइन क्यूप्स संकेतों के बीच विभाजन को चिह्नित करते हैं। ये क्यूस्प्स प्रमुखता की स्थिति रखते हैं, प्रत्येक घर के भीतर महत्वपूर्ण और प्रभावशाली बिंदुओं का प्रतिनिधित्व करते हैं। इन बिंदुओं पर स्थित ग्रहों की स्थिति सबसे शक्तिशाली प्रभाव डालती है, जो उस विशेष घर से जुड़े सर्वोत्कृष्ट सार और प्रभाव को दर्शाती है।", 
            "sun_chart" => "सन चार्ट", 
            "sun_chart_text" => "स्वास्थ्य, संविधान, शरीर", 
            "hora_chart" => "होरा चार्ट(D2)", 
            "hora_chart_text" => "वित्त, धन, समृद्धि", 
            "dreshkan_chart" => "द्रेष्काण चार्ट(D3)", 
            "dreshkan_chart_text" => "भाइयों बहनों", 
            "chathurthamasha_chart" => "चतुर्थमाशा चार्ट(D4)", 
            "chathurthamasha_chart_text" => "भाग्य, जातक का भाग्य", 
            "saptamansha_chart" => "सप्तमांश चार्ट(D7)", 
            "saptamansha_chart_text" => "गर्भाधान, बच्चे का जन्म", 
            "dashamansha_chart" => "दशमांश चार्ट(D10)", 
            "dashamansha_chart_text" => "आजीविका, पेशा", 
            "dwadasha_chart" => "द्वादश चार्ट(D12)", 
            "dwadasha_chart_text" => "माता-पिता, पितृ सुख", 
            "shodashamsha_chart" => "षोडशांश चार्ट(D16)", 
            "shodashamsha_chart_text" => "सुख, दुःख, संवहन", 
            "vishamansha_chart" => "विषमांश चार्ट(D20)", 
            "vishamansha_chart_text" => "आध्यात्मिक उन्नति, उपासना", 
            "chaturvimshamsha_chart" => "चतुर्विंशमशा(D24)", 
            "chaturvimshamsha_chart_text" => "शैक्षणिक उपलब्धि, शिक्षा", 
            "bhamsha_chart" => "भामशा चार्ट(D27)", 
            "bhamsha_chart_text" => "शारीरिक शक्ति, सहनशक्ति", 
            "trishamansha_chart" => "त्रिशमांश चार्ट(30)", 
            "trishamansha_chart_text" => "बुराई, जीवन की प्रतिकूलताएँ", 
            "khavedamsha_chart" => "खवेदमशा चार्ट(40)", 
            "khavedamsha_chart_text" => "शुभ एवं अशुभ प्रभाव", 
            "akshvedansha_chart" => "अक्षवेदांश चार्ट(45)", 
            "akshvedansha_chart_text" => "जातक का चरित्र एवं आचरण", 
            "shashtymsha_chart" => "षष्ठिमशा चार्ट(60)", 
            "shashtymsha_chart_text" => "सामान्य ख़ुशी दर्शाता है", 
            "permanent_friendship" => "स्थायी मित्रता", 
            "temporal_friendship" => "अस्थायी मित्रता", 
            "fivefold_friendship" => "पांच प्रकार की मित्रता", 
            "sub_lord" => "उप स्वामी", 
            "ss_lord" => "एसएस स्वामी", 
            "lord" => "स्वामी", 
            "symbol" => "प्रतीक", 
            "characteristics" => "विशेषताएँ", 
            "lucky_gems" => "भाग्यशाली रत्न", 
            "day_of_fast" => "उपवास का दिन", 
            "sade_table_title" => "आपकी कुंडली में साढ़ेसाती की उपस्थिति", 
            "sadhesati" => "साढ़ेसाती", 
            "consideration_date" => "विचार दिनांक", 
            "moon_sign" => "राशि", 
            "saturn_retrograde" => "शनि वक्री?", 
            "remedies_sadhesati" => "साढ़ेसाती के उपाय", 
            "saturn_sign" => "शनि राशि", 
            "saturn_ratro" => "क्या शनि ग्रह रेट्रो है?", 
            "phase_type" => "चरण प्रकार", 
            "date" => "तारीख", 
            "summary" => "सारांश", 
            "summary1" => "साढ़ेसाती उदय चरण प्रारम्भ।", 
            "summary2" => "साढ़ेसाती उदय चरण समाप्त हो रहा है और इसके साथ ही साढ़ेसाती भी समाप्त हो रही है।", 
            "summary3" => "साढ़ेसाती का चरम चरण प्रारंभ होकर उदय चरण की समाप्ति होती है।", 
            "summary4" => "साढ़ेसाती चरम चरण समाप्त।", 
            "summary5" => "साढ़ेसाती अस्त चरण की शुरुआत, चरम चरण की समाप्ति के साथ होती है।", 
            "summary6" => "साढ़ेसाती अस्त चरण समाप्त हो रहा है और इसके साथ ही साढ़ेसाती भी समाप्त हो रही है।", 
            "is_kalsarpa_present" => "क्या कालसर्प मौजूद है?", 
            "intensity" => "तीव्रता", 
            "kalsarpa_name" => "कालसर्प नाम", 
            "direction" => "दिशा", 
            "remedies_kaal" => "काल सर्प दोष के उपाय", 
            "mnglik" => "मांगलिक", 
            "remedies_manglik" => "मांगलिक दोष के उपाय", 
            "lucky_stone" => "भाग्यशाली पत्थर", 
            "life_stone" => "जीवन पत्थर", 
            "dasha_stone" => "दशा पत्थर", 
            "substitutes" => "स्थानापन्न खिलाड़ी", 
            "finger" => "उँगलिया", 
            "time_to_wear" => "पहनने का समय", 
            "mantra" => "मंत्र", 
            "in_horo" => "आपकी कुंडली में", 
            "zodiac_sign" => "राशि - चक्र चिन्ह", 
            "planet_degree" => "ग्रह डिग्री", 
            "lord_of" => "स्वामी के", 
            "is_in" => "में है", 
            "combust_awashtha" => "दहन/अवस्थ", 
            "lahiri" => "लाहिड़ी", 
            "Kalsarpa_In_Horoscope" => "आपकी कुंडली में कालसर्प दोष की उपस्थिति", 
            "pp_sun" => "सूर्य को स्वास्थ्य, जीवन शक्ति, ऊर्जा, शक्ति, पिता, सम्मान, प्रतिष्ठा, गौरव, प्रसिद्धि, साहस और व्यक्तिगत शक्ति का कारक कहा जाता है। सूर्य एक राजसी और कुलीन ग्रह है जो चेतन अहंकार और आत्मा का प्रतिनिधित्व करता है और आत्मबोध से संबंधित है।", 
            "pp_moon" => "चंद्रमा मन, इच्छा शक्ति और भावनाओं को प्रभावित करने की क्षमता रखता है। चंद्रमा पानी और प्राकृतिक शक्तियों से जुड़ा है, यह एक डगमगाता ग्रह है जो बदलावों से संबंध रखता है।", 
            "pp_mercury" => "बुध बुद्धि और शिक्षा का ग्रह है, यह वाणी और तर्क से जुड़ा है और इस प्रकार व्यक्ति के संचार कौशल पर इसका प्रभाव पड़ता है।", 
            "pp_venus" => "शुक्र को यौन इच्छाओं (काम), कामेच्छा, पत्नी का कारक माना जाता है। यह जुनून, विवाह, विलासिता की वस्तुएं, आभूषण, वाहन, आराम और सुंदरता से संबंधित है।", 
            "pp_mars" => "ज्योतिष शास्त्र के अनुसार मंगल साहस और तानाशाही से संबंधित ग्रह है। मंगल को क्रिया और विस्तार का ग्रह माना जाता है।", 
            "pp_jupiter" => "बृहस्पति को धन, ज्ञान, गुरु, पति, पुत्र, नैतिक मूल्यों, शिक्षा, दादा-दादी और शाही सम्मान का कारक कहा जाता है। यह जातक की धार्मिक धारणा, भक्ति और आस्था को दर्शाता है।", 
            "pp_saturn" => "शनि एक धीमी गति से चलने वाला ग्रह है। इसे न्याय, तर्क और विनाशकारी शक्तियों का ग्रह कहा जाता है। यह आपदाओं और मृत्यु से संबंधित है। शनि को गुरु भी माना जाता है।", 
            "pp_rahu" => "अजीब और अपरंपरागत ग्रह होने के कारण राहु भौतिकवाद का प्रतिनिधित्व करता है और कठोर वाणी, अभाव और आवश्यकताओं से संबंधित है। राहु को पारलौकिकता का ग्रह कहा जाता है। यह विदेशी भूमि और विदेश यात्रा को दर्शाता है।",
            'Ascendant' => "लग्न",
            'ascendant' => "लग्न",
            'tara' => "तारा",
            'graha_maitri' => "ग्रह मैत्री",
            'gana' => "गण",
            'bhakoota' => "भकूटा",
            'dina' => "दिना",
            'rashi' => "राशि",
            'rasyadhipati' => "रस्याधिपति",
            'vedha' => "वेधा",
            'mahendra' => "महेन्द्र",
            'streedargha' => "स्त्रीदरघा",
            'rajju' => "रज्जू",
            'dashamasa_chart' => "दशमांश कुंडली",
            'general_observation' => "सामान्य अवलोकन",
            'specific_observation' => "विशिष्ट अवलोकन",
            'dasha_observation' => "दशा अवलोकन",
            'job_observation' => "नौकरियाँ अवलोकन",
            'surya_and_chandra' => "सूर्य और चंद्र",
            'maha_dasha' => "महा दशा",
            'antar_dasha' => "अंतर दशा",
            'start_date' => "आरंभ तिथि",
            'end_date' => "अंतिम तिथि",
            'probability' => "संभावना",
            'total_points_Earned' => "अर्जित किये गये कुल अंक",
            'points' => "अंक",
            'job_ias' => "आईएएस अधिकारी",
            'job_ips' => "आईपीएस अधिकारी",
            'job_professor' => "प्रोफेसर",
            'job_bankpo' => "बैंक पीओ",
            'job_ndadefence' => "एनडीए रक्षा अधिकारी",
            'job_scientificresearch' => "वैज्ञानिक अनुसंधान अधिकारी",
            'job_railways' => "रेलवे अधिकारी",
            'job_incometax' => "आयकर अधिकारी",
            'job_stateservices' => "राज्य सेवा अधिकारी",
            'job_electricity' => "बिजली अधिकारी",
            'job_roads' => "सड़क अधिकारी",
            'job_watersupply' => "जल आपूर्ति अधिकारी",
            'job_pwd' => "पीडब्लूडी",
            'job_police' => "पुलिस अधिकारी",
            'job_fire' => "अग्निशमन अधिकारी",
            'job_observation_red' => "ज्योतिषीय मूल्यांकन से पता चलता है कि एक <u>__JOBNAME__</u> के रूप में सरकारी नौकरी पाने की आपकी संभावनाएँ बहुत सीमित या लगभग न के बराबर प्रतीत होती हैं। ग्रहों की स्थिति महत्वपूर्ण बाधाओं या सीमाओं का संकेत देती है जो इस विशेष की प्राप्ति में बाधा बन सकती हैं। जीविका पथ।",
            'job_observation_yellow' => "ज्योतिषीय मूल्यांकन से पता चलता है कि आपके पास एक <u>__JOBNAME__</u> के रूप में सरकारी नौकरी हासिल करने की मध्यम क्षमता है। हालांकि कुछ ग्रहीय पहलू सहायक हैं, आपको इस प्रतिष्ठित पद को प्राप्त करने की दिशा में अपनी यात्रा में कुछ चुनौतियों से पार पाने की आवश्यकता हो सकती है।" ,
            'job_observation_green' => "बधाई हो! ज्योतिषीय विश्लेषण के आधार पर, ग्रहों के प्रभाव का संरेखण इंगित करता है कि आपके पास <u>__JOBNAME__</u> बनने का एक मजबूत और अनुकूल मौका है, जो आपके लक्ष्य की ओर एक आशाजनक मार्ग को उजागर करता है।",
            'placement_of_sun' => "ज्योतिष और सरकारी करियर में सूर्य",
            'placement_of_10_loard' => "ज्योतिष का दसवां घर और करियर",
            'placement_of_9_loard' => "ज्योतिष का नवम भाव और सरकारी करियर",
            'placement_of_saturn' => "सरकारी करियर में शनि की भूमिका",
            'hight_message_1' => "High - इस अवधि में आपके सरकारी नौकरी में चयनित होने की उच्च संभावना है",
            'low_message_2' => "Low - इस अवधि में आपके सरकारी नौकरी में चयनित होने की संभावना कम है",
            'medium_message_3' => "Medium - इस अवधि में आपके सरकारी नौकरी में चयनित होने की मध्यम संभावना है",
            'remedies' => "उपाय",
            'remedies_gov_job' => "सरकारी नौकरी के उपाय",
            'leisure' => "अवकाश यात्रा",
            'leisure_heading_1' => "यात्रा स्थल: 3रा और 12वाँ लॉर्ड इनसाइट्स",
            'leisure_heading_2' => "यात्रा के अवसर: तीसरे भगवान की शक्ति का मूल्यांकन",
            'leisure_heading_3' => "5-वर्षीय यात्रा पूर्वानुमान और रुझान",
            'leisure_observation' => "अवकाश यात्रा अवलोकन",
            'comment' => "टिप्पणी",
            'points_Earned' => "अर्जित अंक",
            'work_travel' => "कार्य यात्रा",
            'work_travel_heading_1' => "कार्य गंतव्य: 12वें और 10वें लॉर्ड्स से अंतर्दृष्टि",
            'work_travel_heading_2' => "विदेशी कार्य अवसर: 12वें स्वामी का आकलन",
            'work_travel_heading_3' => "राहु और दशमेश: अप्रत्याशित करियर यात्राएँ",
            'work_travel_heading_4' => "मुख्य स्थिति: कार्य यात्रा के लिए केंद्र घरों का विश्लेषण",
            'work_travel_heading_5' => "5-वर्षीय कार्य यात्रा पूर्वानुमान और रुझान",
            'work_travel_observation' => "कार्य यात्रा अवलोकन",
            'education' => "शिक्षा यात्रा",
            'education_heading_1' => "विदेश में अध्ययन और उच्च शिक्षा: 12वें और 9वें लॉर्ड्स से अंतर्दृष्टि",
            'education_heading_2' => "विदेशी शिक्षा: 12वें भगवान की शक्ति",
            'education_heading_3' => "अप्रत्याशित शैक्षणिक खोज: राहु और नवमेश",
            'education_heading_4' => "शिक्षा में स्थिरता: केंद्र सदनों का विश्लेषण",
            'education_heading_5' => "विदेश में अध्ययन: 5-वर्षीय संभावनाएँ और रुझान",
            'education_observation' => "शिक्षा यात्रा अवलोकन",
            'settlement' => "निपटान",
            'settlement_heading_1' => "घर विदेश: 12वें और 4वें लॉर्ड्स से अंतर्दृष्टि",
            'settlement_heading_2' => "विदेश में वित्तीय स्थिरता: 12वीं और 2वीं लॉर्ड्स",
            'settlement_heading_3' => "वैश्विक बस्ती पर राहु का प्रभाव",
            'settlement_heading_4' => "स्थायी निवास: 5-वर्षीय संभावनाएँ और रुझान",
            'settlement_observation' => "सेटलमेंट अवलोकन",
            'general_remedies' => "सामान्य उपचार",
            'specific_remedies' => "विशिष्ट उपचार",
            'gemstone' => "रत्न",
            'leisure_content' => "अवकाश यात्रा में विभिन्न प्रकार के अनुभव और प्राथमिकताएं शामिल हो सकती हैं। जब आप अपने जीवन के उसी पुराने नीरस शासन से थक जाते हैं, तो एक आकर्षक छुट्टी जरूरी हो जाती है। अवकाश और मौज-मस्ती मानसिक और भावनात्मक रूप से स्वस्थ रहने के लिए समान रूप से महत्वपूर्ण हैं। किया जा रहा है। एक अवकाश यात्रा के लिए आप समुद्र तट की छुट्टी, साहसिक यात्रा, सांस्कृतिक पर्यटन, प्रकृति और वन्यजीव अभियान, कल्याण और स्पा रिट्रीट, क्रूज़ छुट्टियां, खेल पर्यटन आदि को प्राथमिकता दे सकते हैं।",
            'work_desc' => "एक विदेशी कार्य यात्रा, जिसे व्यापार यात्रा या अंतर्राष्ट्रीय व्यापार यात्रा के रूप में भी जाना जाता है, एक व्यक्ति या व्यक्तियों के समूह द्वारा अपने देश के अलावा किसी अन्य देश में काम से संबंधित उद्देश्यों के लिए की गई यात्रा को संदर्भित करता है। विदेशी यात्राएं बातचीत, सम्मेलन, प्रशिक्षण और कार्यशालाएं, परियोजना लॉन्च, ग्राहक संबंध, अनुसंधान और बाजार अन्वेषण, सांस्कृतिक आदान-प्रदान, सहयोग इत्यादि जैसे विभिन्न उद्देश्यों की पूर्ति।",
            'eduction_desc' => "एक विदेशी शिक्षा यात्रा, जिसे अक्सर विदेश में अध्ययन कार्यक्रम या अंतर्राष्ट्रीय शैक्षिक यात्रा के रूप में जाना जाता है, इसमें छात्र या शिक्षार्थी शैक्षिक अवसरों को आगे बढ़ाने, सांस्कृतिक अनुभव प्राप्त करने और अपने शैक्षणिक और व्यक्तिगत विकास को बढ़ाने के लिए दूसरे देश की यात्रा करते हैं। विदेशी शिक्षा शैक्षणिक गतिविधियों, सांस्कृतिक आदान-प्रदान, भाषा सीखने, करियर के अवसर आदि जैसे कई अनुभव प्रदान कर सकती है।",
            'leisure_danger' => 'ज्योतिषीय मूल्यांकन से पता चलता है कि विदेश में अवकाश यात्रा पर जाने की आपकी संभावना बहुत सीमित या लगभग न के बराबर प्रतीत होती है। ग्रहों की स्थिति महत्वपूर्ण बाधाओं या सीमाओं का संकेत देती है जो आपके अंतर्राष्ट्रीय रोमांच और अनुभवों की खोज में बाधा बन सकती हैं।',
            'leisure_warning' => 'ज्योतिषीय आकलन से पता चलता है कि आपके पास विदेश में अवकाश यात्रा करने की मध्यम क्षमता है। हालाँकि ग्रहों के कुछ पहलू सहायक हैं, लेकिन आपको नए गंतव्यों और संस्कृतियों का अनुभव करने की दिशा में अपनी यात्रा में कुछ चुनौतियों से पार पाने की आवश्यकता हो सकती है। सुरक्षित और साहसिक यात्रा!',
            'leisure_success' => 'बधाई हो! ज्योतिषीय विश्लेषण के आधार पर, ग्रहों के प्रभावों का संरेखण बताता है कि आपके पास विदेश में अवकाश यात्रा शुरू करने का एक मजबूत और अनुकूल मौका है। सितारे एक सीध में नज़र आ रहे हैं, जो आपके सपनों की मंजिल की ओर एक आशाजनक यात्रा का संकेत दे रहा है। आशा है आपकी यात्रा सुखद हो!',
            'work_travel_danger' => 'ज्योतिषीय मूल्यांकन से पता चलता है कि काम से संबंधित विदेश यात्रा पर जाने की आपकी संभावना बहुत सीमित या लगभग न के बराबर प्रतीत होती है। ग्रहों की स्थिति महत्वपूर्ण बाधाओं या सीमाओं का संकेत देती है जो वैश्विक पेशेवर अवसरों की आपकी खोज में बाधा बन सकती हैं।',
            'work_travel_warning' => 'ज्योतिषीय आकलन से पता चलता है कि आपके पास काम से संबंधित विदेश यात्रा करने की मध्यम क्षमता है। हालांकि ग्रहों के कुछ पहलू सहायक हैं, आपको अंतरराष्ट्रीय स्तर पर अपने पेशेवर क्षितिज का विस्तार करने की दिशा में अपनी यात्रा में कुछ चुनौतियों से पार पाने की आवश्यकता हो सकती है। सुरक्षित और लाभदायक यात्राएँ!',
            'work_travel_success' => 'बधाई हो! ज्योतिषीय विश्लेषण के आधार पर, ग्रहों के प्रभावों का संरेखण बताता है कि आपके पास काम से संबंधित विदेश यात्रा पर जाने का एक मजबूत और अनुकूल मौका है। सितारे एक साथ नज़र आ रहे हैं, जो अंतरराष्ट्रीय स्तर पर आपके पेशेवर विकास के लिए एक आशाजनक अवसर का संकेत दे रहा है। सुरक्षित और उत्पादक यात्राएँ!',
            'education_danger' => 'ज्योतिषीय मूल्यांकन से पता चलता है कि शिक्षा संबंधी विदेश यात्रा पर जाने की आपकी संभावनाएं बहुत सीमित या लगभग न के बराबर प्रतीत होती हैं। ग्रहों की स्थिति महत्वपूर्ण बाधाओं या सीमाओं का संकेत देती है जो वैश्विक शैक्षिक अवसरों की आपकी खोज में बाधा बन सकती हैं। लचीले रहें और वैकल्पिक रास्ते तलाशें!',
            'education_warning' => 'ज्योतिषीय आकलन से पता चलता है कि आपके पास शिक्षा से संबंधित विदेश यात्रा करने की मध्यम क्षमता है। हालाँकि ग्रहों के कुछ पहलू सहायक हैं, आपको अंतर्राष्ट्रीय शैक्षणिक अनुभव प्राप्त करने की दिशा में अपनी यात्रा में कुछ चुनौतियों से पार पाने की आवश्यकता हो सकती है। ध्यान केंद्रित रखें और ज्ञानवर्धक यात्राओं पर निकल पड़ें!',
            'education_success' => 'बधाई हो! ज्योतिषीय विश्लेषण के आधार पर, ग्रहों के प्रभाव का संरेखण बताता है कि आपके पास विदेश में शिक्षा से संबंधित यात्रा शुरू करने का एक मजबूत और अनुकूल मौका है। सितारे संरेखित होते दिख रहे हैं, जो अंतरराष्ट्रीय शैक्षणिक गतिविधियों की दिशा में एक आशाजनक मार्ग का संकेत दे रहा है। अपने शैक्षिक सपनों और सुरक्षित यात्रा को पूरा करें!',
            'settlement_danger' => 'ज्योतिषीय मूल्यांकन से पता चलता है कि विदेश में स्थायी रूप से बसने की आपकी संभावनाएँ बहुत सीमित या लगभग न के बराबर प्रतीत होती हैं। ग्रहों की स्थिति महत्वपूर्ण बाधाओं या सीमाओं का संकेत देती है जो विदेश में दीर्घकालिक जीवन की आपकी खोज में बाधा बन सकती हैं। हर संभावना पर विचार करें और अन्य अवसरों के प्रति खुला दिमाग रखें!',
            'settlement_warning' => 'ज्योतिषीय आकलन से पता चलता है कि आपके पास स्थायी रूप से विदेश में बसने की मध्यम क्षमता है। हालाँकि ग्रहों के कुछ पहलू सहायक हैं, आपको एक अलग देश में एक नया जीवन स्थापित करने की दिशा में अपनी यात्रा में कुछ चुनौतियों से पार पाने की आवश्यकता हो सकती है। आशावादी रहें और दृढ़ संकल्प के साथ अपना रास्ता तय करें!',
            'settlement_success' => 'बधाई हो! ज्योतिषीय विश्लेषण के आधार पर, ग्रहों के प्रभाव का संरेखण बताता है कि आपके पास स्थायी रूप से विदेश में बसने का एक मजबूत और अनुकूल मौका है। सितारे संरेखित होते दिख रहे हैं, जो आपकी वांछित विदेशी भूमि में घर बनाने की दिशा में एक आशाजनक मार्ग प्रदान करते हैं। जीवन बदलने वाले इस साहसिक कार्य को आत्मविश्वास के साथ शुरू करें!',
            'sun_analysis' => 'सूर्य विश्लेषण:',
            '10_analysis' => 'दसवें घर का विश्लेषण:',
            '9_analysis' => 'नौवें घर का विश्लेषण:',
            'saturn_analysis' => 'शनि विश्लेषण:',
            'sun_kendra' => 'सूर्य केंद्र भाव में', 
            'mars_kendra' => 'मंगल केंद्र भाव में', 
            'jupiter_kendra' => 'बृहस्पति केंद्र भाव में',
            'gem_ruby' => 'रूबी',
            'gem_akoyapearl' => 'अकोया मोती',
            'gem_redcoral' => 'लाल मूंगा',
            'gem_emerald' => 'पन्ना',
            'gem_yellowsapphire' => 'पीला नीलम',
            'gem_diamond' => 'हीरा',
            'gem_bluesapphire' => 'नीला नीलम',
            'gem_gomedhesonite)' => 'गोमेद (हेसोनाइट)',
            'gem_catseye' => "बिल्ली की आँख",
            'remedies_con' => "निष्कर्ष में, जैसा कि हम ज्योतिषीय विश्लेषण द्वारा प्रदान की गई अंतर्दृष्टि में उतरते हैं, यह याद रखना महत्वपूर्ण है कि हालांकि आकाशीय प्रभाव मार्गदर्शन और सुझाव दे सकते हैं, व्यक्तिगत प्रयास, समर्पण और सक्रिय विकल्प भी इसमें महत्वपूर्ण भूमिका निभाते हैं। किसी के करियर की यात्रा को आकार देना। इन विचारों को ध्यान में रखते हुए, यहां कुछ उपाय दिए गए हैं जो आपके प्रयासों को पूरक बना सकते हैं और संभावित रूप से सरकार और सार्वजनिक सेवा के क्षेत्र में आपके मार्ग को बढ़ा सकते हैं।",
        ];

    }

    public static function rdr_temp($rdr, $compact) {

        extract($compact);

        ob_start();
        include DHAT_PLUGIN_PATH . "/inc/parts/$rdr.php";
        $content = ob_get_clean();
        return $content;

    }

    public function get_km_report() {

        $fname = (isset($_POST['fname'])) ? trim($_POST['fname']) : '';
        $lname = (isset($_POST['lname'])) ? trim($_POST['lname']) : '';
        $gender = (isset($_POST['gender'])) ? trim($_POST['gender']) : 'male';
        $dob = (isset($_POST['dob'])) ? trim($_POST['dob']) : '';
        $hour = (isset($_POST['hour'])) ? trim($_POST['hour']) : '';
        $min = (isset($_POST['min'])) ? trim($_POST['min']) : '';
        $sec = (isset($_POST['sec'])) ? trim($_POST['sec']) : '';
        $place = (isset($_POST['place'])) ? trim($_POST['place']) : '';
        $tzone = (isset($_POST['tzone'])) ? trim($_POST['tzone']) : '';
        $lat = (isset($_POST['lat'])) ? trim($_POST['lat']) : '';
        $lon = (isset($_POST['lon'])) ? trim($_POST['lon']) : '';
        $fname2 = (isset($_POST['fname2'])) ? trim($_POST['fname2']) : '';
        $lname2 = (isset($_POST['lname2'])) ? trim($_POST['lname2']) : '';
        $gender2 = (isset($_POST['gender2'])) ? trim($_POST['gender2']) : 'female';
        $dob2 = (isset($_POST['dob2'])) ? trim($_POST['dob2']) : '';
        $hour2 = (isset($_POST['hour2'])) ? trim($_POST['hour2']) : '';
        $min2 = (isset($_POST['min2'])) ? trim($_POST['min2']) : '';
        $sec2 = (isset($_POST['sec2'])) ? trim($_POST['sec2']) : '';
        $place2 = (isset($_POST['place2'])) ? trim($_POST['place2']) : '';
        $tzone2 = (isset($_POST['tzone2'])) ? trim($_POST['tzone2']) : '';
        $lat2 = (isset($_POST['lat2'])) ? trim($_POST['lat2']) : '';
        $lon2 = (isset($_POST['lon2'])) ? trim($_POST['lon2']) : '';
        $lang = (isset($_POST['lang'])) ? trim($_POST['lang']) : 'en';
        $arr_tran = array();
        $msgs = array();
        $err_cnt = 0;
        $tran = 0;
        $data = '';

        if (empty($fname) || $fname == 'null') {
        
            $msgs['kmfname1'] = 'Please enter first name';
            $err_cnt++;
        
        }

        if (empty($lname) || $lname == 'null') {
        
            $msgs['kmlname1'] = 'Please enter last name';
            $err_cnt++;
        
        }

        if (empty($dob) || $dob == 'null' || strtotime($dob) <= 0) {
        
            $msgs['kmdob1'] = 'Please enter date of birth';
            $err_cnt++;
        
        }

        if (strlen($hour) <= 0 || strlen($min) <= 0 || strlen($sec) <= 0) {
            $msgs['kmhms1'] = 'Please select valid birth time (hour:min:sec)';
            $err_cnt++;
        }

        if (empty($place) || $place == 'null' || empty($tzone) || empty($lat) || empty($lon)) {
        
            $msgs['kmplace1'] = 'Please select birth place again';
            $err_cnt++;
        
        }

        if (empty($fname2) || $fname2 == 'null') {
        
            $msgs['kmfname2'] = 'Please enter first name';
            $err_cnt++;
        
        }

        if (empty($lname2) || $lname2 == 'null') {
        
            $msgs['kmlname2'] = 'Please enter last name';
            $err_cnt++;
        
        }

        if (empty($dob2) || $dob2 == 'null' || strtotime($dob2) <= 0) {
        
            $msgs['kmdob2'] = 'Please enter date of birth';
            $err_cnt++;
        
        }

        if (strlen($hour2) <= 0 || strlen($min2) <= 0 || strlen($sec2) <= 0) {
            $msgs['kmhms2'] = 'Please select valid birth time (hour:min:sec)';
            $err_cnt++;
        }

        if (empty($place2) || $place2 == 'null' || empty($tzone2) || empty($lat2) || empty($lon2)) {
        
            $msgs['kmplace2'] = 'Please select birth place again';
            $err_cnt++;
        
        }

        if ($err_cnt > 0) {
        
            $arr_tran['tran'] = 0;
            $arr_tran['msgs'] = $msgs;
        
        } else {

            $api_key = get_option('divine_settings_input_field');
        
            $form_data = [
                'api_key' => $api_key,
                'p1_full_name' => $fname . ' ' . $lname,
                'p1_day' => date('d', strtotime($dob)),
                'p1_month' => date('m', strtotime($dob)),
                'p1_year' => date('Y', strtotime($dob)),
                'p1_hour' => $hour,
                'p1_min' => $min,
                'p1_sec' => $sec,
                'p1_gender'=> $gender,
                'p1_place' => $place,
                'p1_lat' => $lat,
                'p1_lon' => $lon,
                'p1_tzone' => $tzone,
                'p2_full_name' => $fname2 . ' ' . $lname2,
                'p2_day' => date('d', strtotime($dob2)),
                'p2_month' => date('m', strtotime($dob2)),
                'p2_year' => date('Y', strtotime($dob2)),
                'p2_hour' => $hour2,
                'p2_min' => $min2,
                'p2_sec' => $sec2,
                'p2_gender'=> $gender2,
                'p2_place' => $place2,
                'p2_lat' => $lat2,
                'p2_lon' => $lon2,
                'p2_tzone' => $tzone2,
                'lan' => $lang,
            ];
            $basic_astro_detail = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/basic-astro-details", $form_data, true);

            if ($basic_astro_detail['status'] == 1 && $basic_astro_detail['data']['success'] == 1) {

                $tran = 1;
                $rdr = 'kundali-matching-first-page';
                $compact = array(
                    'lang_type' => $lang,
                    'full_name' => $fname . ' ' . $lname,
                    'day' => date('d', strtotime($dob)),
                    'month' => date('m', strtotime($dob)),
                    'year' => date('Y', strtotime($dob)),
                    'hour' => $hour,
                    'min' => $min,
                    'sec' => $sec,
                    'gender'=> $gender,
                    'place' => $place,
                    'full_name2' => $fname2 . ' ' . $lname2,
                    'day2' => date('d', strtotime($dob2)),
                    'month2' => date('m', strtotime($dob2)),
                    'year2' => date('Y', strtotime($dob2)),
                    'hour2' => $hour2,
                    'min2' => $min2,
                    'sec2' => $sec2,
                    'gender2'=> $gender2,
                    'place2' => $place2,
                );
                $data = self::rdr_temp($rdr, $compact);

            } else {
                $tran = 2;
                $data = '<div class="divine_auth_domain_response">
                            <p style="color: red !important;text-align:center !important;">** ' . $basic_astro_detail['data']['msg'] . '</p>
                        </div>';
            }

            $arr_tran['tran'] = $tran;
            $arr_tran['data'] = $data;

        }

        return $arr_tran;

    }

    public function get_kundali_matching_report_data() {

        $module = (isset($_POST['km_module'])) ? intval($_POST['km_module']) : 1;
        $fname = (isset($_POST['fname'])) ? trim($_POST['fname']) : '';
        $lname = (isset($_POST['lname'])) ? trim($_POST['lname']) : '';
        $gender = (isset($_POST['gender'])) ? trim($_POST['gender']) : 'male';
        $dob = (isset($_POST['dob'])) ? trim($_POST['dob']) : '';
        $hour = (isset($_POST['hour'])) ? trim($_POST['hour']) : '';
        $min = (isset($_POST['min'])) ? trim($_POST['min']) : '';
        $sec = (isset($_POST['sec'])) ? trim($_POST['sec']) : '';
        $place = (isset($_POST['place'])) ? trim($_POST['place']) : '';
        $tzone = (isset($_POST['tzone'])) ? trim($_POST['tzone']) : '';
        $lat = (isset($_POST['lat'])) ? trim($_POST['lat']) : '';
        $lon = (isset($_POST['lon'])) ? trim($_POST['lon']) : '';
        $fname2 = (isset($_POST['fname2'])) ? trim($_POST['fname2']) : '';
        $lname2 = (isset($_POST['lname2'])) ? trim($_POST['lname2']) : '';
        $gender2 = (isset($_POST['gender2'])) ? trim($_POST['gender2']) : 'male';
        $dob2 = (isset($_POST['dob2'])) ? trim($_POST['dob2']) : '';
        $hour2 = (isset($_POST['hour2'])) ? trim($_POST['hour2']) : '';
        $min2 = (isset($_POST['min2'])) ? trim($_POST['min2']) : '';
        $sec2 = (isset($_POST['sec2'])) ? trim($_POST['sec2']) : '';
        $place2 = (isset($_POST['place2'])) ? trim($_POST['place2']) : '';
        $tzone2 = (isset($_POST['tzone2'])) ? trim($_POST['tzone2']) : '';
        $lat2 = (isset($_POST['lat2'])) ? trim($_POST['lat2']) : '';
        $lon2 = (isset($_POST['lon2'])) ? trim($_POST['lon2']) : '';
        $lang_type = (isset($_POST['lang'])) ? trim($_POST['lang']) : 'en';
        $api_key = get_option('divine_settings_input_field');
        
        $form_data = [
            'api_key' => $api_key,
            'p1_full_name' => $fname . ' ' . $lname,
            'p1_day' => date('d', strtotime($dob)),
            'p1_month' => date('m', strtotime($dob)),
            'p1_year' => date('Y', strtotime($dob)),
            'p1_hour' => $hour,
            'p1_min' => $min,
            'p1_sec' => $sec,
            'p1_gender'=> $gender,
            'p1_place' => $place,
            'p1_lat' => $lat,
            'p1_lon' => $lon,
            'p1_tzone' => $tzone,
            'p2_full_name' => $fname2 . ' ' . $lname2,
            'p2_day' => date('d', strtotime($dob2)),
            'p2_month' => date('m', strtotime($dob2)),
            'p2_year' => date('Y', strtotime($dob2)),
            'p2_hour' => $hour2,
            'p2_min' => $min2,
            'p2_sec' => $sec2,
            'p2_gender'=> $gender2,
            'p2_place' => $place2,
            'p2_lat' => $lat2,
            'p2_lon' => $lon2,
            'p2_tzone' => $tzone2,
            'lan' => $lang_type,
        ];

        $messages = ($lang_type == 'en') ? self::get_english_content() : self::get_hindi_content();

        $data = '';

        if ($module == 1) {

            $data = $this->get_kundali_matching_basic_details($form_data, $messages);

        } elseif ($module == 2) {

            $data = $this->get_kundali_matching_planetary_position_details($form_data, $messages);

        } elseif ($module == 3) {

            $data = $this->get_kundali_matching_horoscope_chart_details($form_data, $messages);

        }  elseif ($module == 4) {

            $data = $this->get_kundali_matching_vimshottari_dasha_details($form_data, $messages);

        }  elseif ($module == 5) {

            $data = $this->get_kundali_matching_vimshottari_dasha_details($form_data, $messages, 2);

        } elseif ($module == 6) {

            $data = $this->get_kundali_matching_manglik_analysis_details($form_data, $messages);

        } elseif ($module == 7) {

            $data = $this->get_kundali_matching_ashtakoot_details($form_data, $messages);

        } elseif ($module == 8) {

            $data = $this->get_kundali_matching_bhakut_dosha_details($form_data, $messages);

        } elseif ($module == 9) {

            $data = $this->get_kundali_matching_nadi_dosha_details($form_data, $messages);

        } elseif ($module == 10) {

            $data = $this->get_kundali_matching_ashtakoot_analysis_details($form_data, $messages);

        } elseif ($module == 11) {

            $data = $this->get_kundali_matching_dashakoot_details($form_data, $messages);

        } elseif ($module == 12) {

            $data = $this->get_kundali_matching_personality_report_details($form_data, $messages);

        } elseif ($module == 13) {

            $data = $this->get_kundali_matching_match_making_report_details($form_data, $messages);

        } elseif ($module == 14) {

            $data = $this->get_kundali_matching_nav_pancham_yoga_details($form_data, $messages);

        }

        return $data;

    }

    public function get_kundali_matching_basic_details($form_data, $messages) {

        $basic_astro = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/basic-astro-details",$form_data, true);
        $planetary_position = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/planetary-positions",$form_data, true);
        // $anayas = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/find-other-calendars-and-epoch",$form_data, true);
        // $panchang = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/find-panchang",$form_data, true);
        $rdr = 'kundali-matching-basic-details';
        $content = '';

        if ($basic_astro['status'] == 1 && $planetary_position['status'] == 1 
        && $basic_astro['data']['success'] == 1 && $planetary_position['data']['success'] == 1) {

            $planetary_position = $planetary_position['data']['data'];
            $basic_astro = $basic_astro['data']['data'];
            // $panchang = $panchang['data']['data'];
            $moon_data = [];
            if(isset($planetary_position['p1']['planets'])
            && !empty($planetary_position['p1']['planets'])){
                foreach($planetary_position['p1']['planets'] as $key => $planets){
                    if($planets['name'] == "Moon"){
                        $moon_data = $planets;
                    }
                }    
            }
            $moon_data2 = [];
            if(isset($planetary_position['p2']['planets'])
            && !empty($planetary_position['p2']['planets'])){
                foreach($planetary_position['p2']['planets'] as $key => $planets){
                    if($planets['name'] == "Moon"){
                        $moon_data2 = $planets;
                    }
                }    
            }

            $compact = array(
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                // 'po_panchag' => isset($panchang['p1']) ? $panchang['p1'] : [],
                // 'pt_panchag' => isset($panchang['p2']) ? $panchang['p2'] : [],
                // 'po_anayas' => isset($anayas['p1']) ? $anayas['p1'] : [],
                // 'pt_anayas' => isset($anayas['p2']) ? $anayas['p2'] : [],
                'po_basic_astro' => isset($basic_astro['p1']) ? $basic_astro['p1'] : [],
                'pt_basic_astro' => isset($basic_astro['p2']) ? $basic_astro['p2'] : [],
                'po_moon_data' => $moon_data,
                'pt_moon_data' => $moon_data2,
                'messages' => $messages,
                'birth_date' => $birth_date,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));
            
        } else {

            return array('tran' => 0, 'msg' => $basic_astro['data']['msg']);

        }

    }

    public function get_kundali_matching_planetary_position_details($form_data, $messages) {

        $planetary_position = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/planetary-positions", $form_data, true);
        $rdr = 'kundali-matching-planet-profiles-details';
        $content = '';

        if ($planetary_position['status'] == 1 && $planetary_position['data']['success'] == 1) {

            $planetary_position = $planetary_position['data']['data'];
            $compact = array(
                'lang_type' => $form_data['lan'],
                'po_planetary_position' => isset($planetary_position['p1']) ? $planetary_position['p1'] : [],
                'pt_planetary_position' => isset($planetary_position['p2']) ? $planetary_position['p2'] : [],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $planetary_position['data']['msg']);

        }

    }

    public function get_kundali_matching_horoscope_chart_details($form_data, $messages) {

        $birth_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/horoscope-chart/D1",$form_data, true);
        $D9_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/horoscope-chart/D9",$form_data, true);
        $moon_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/horoscope-chart/MOON",$form_data, true);
        $chalit_chart = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/horoscope-chart/chalit",$form_data, true);
        $rdr = 'kundali-matching-horoscope-chart-details';
        $content = '';
                
        if ($birth_chart['status'] == 1 && $D9_chart['status'] == 1 && $moon_chart['status'] == 1 && $chalit_chart['status'] == 1 && $birth_chart['data']['success'] == 1) {

            $birth_chart = $birth_chart['data']['data'];
            $D9_chart = $D9_chart['data']['data'];
            $moon_chart = $moon_chart['data']['data'];
            $chalit_chart = $chalit_chart['data']['data'];
            $compact = array(
                'po_birth_chart' => isset($birth_chart['p1']) ? $birth_chart['p1'] : [],
                'po_D9_chart' => isset($D9_chart['p1']) ? $D9_chart['p1'] : [],
                'po_moon_chart' => isset($moon_chart['p1']) ? $moon_chart['p1'] : [],
                'po_chalit_chart' => isset($chalit_chart['p1']) ? $chalit_chart['p1'] : [],
                'pt_birth_chart' => isset($birth_chart['p2']) ? $birth_chart['p2'] : [],
                'pt_D9_chart' => isset($D9_chart['p2']) ? $D9_chart['p2'] : [],
                'pt_moon_chart' => isset($moon_chart['p2']) ? $moon_chart['p2'] : [],
                'pt_chalit_chart' => isset($chalit_chart['p2']) ? $chalit_chart['p2'] : [],
                'lang_type' => $form_data['lan'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $birth_chart['data']['msg']);

        }

    }

    public function get_kundali_matching_vimshottari_dasha_details($form_data, $messages, $person=1) {

        $vimshottari_dasha = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/vimshottari-dasha", $form_data, true);
        $rdr = 'kundali-matching-vimshottari-dasha-details';
        $content = '';

        if ($vimshottari_dasha['status'] == 1 && $vimshottari_dasha['data']['success'] == 1) {

            $vimshottari_dasha = $vimshottari_dasha['data']['data'];
            if ($person == 1) {
                $compact = array(
                    'vimshottari_dasha' => isset($vimshottari_dasha['p1']) ? $vimshottari_dasha['p1'] : [],
                    'lang_type' => $form_data['lan'],
                    'name' => $form_data['p1_full_name'],
                    'messages' => $messages,
                ); 
            } else {
                $compact = array(
                    'vimshottari_dasha' => isset($vimshottari_dasha['p2']) ? $vimshottari_dasha['p2'] : [],
                    'lang_type' => $form_data['lan'],
                    'name' => $form_data['p2_full_name'],
                    'messages' => $messages,
                ); 
            }
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));
            
        } else {

            return array('tran' => 0, 'msg' => $vimshottari_dasha['data']['msg']);

        }

    }

    public function get_kundali_matching_manglik_analysis_details($form_data, $messages) {

        $manglik_analysis = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ashtakoot-milan", $form_data, true);
        $rdr = 'kundali-matching-manglik-analysis-details';
        $content = '';

        if ($manglik_analysis['status'] == 1 && $manglik_analysis['data']['success'] == 1) {

            $manglik_analysis = $manglik_analysis['data']['data'];
            $compact = array(
                'manglik_analysis' => $manglik_analysis,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $manglik_analysis['data']['msg']);

        }

    }

    public function get_kundali_matching_ashtakoot_details($form_data, $messages) {

        $ashtakoot = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ashtakoot-milan", $form_data, true);
        $rdr = 'kundali-matching-ashtakoot-details';
        $content = '';

        if ($ashtakoot['status'] == 1 && $ashtakoot['data']['success'] == 1) {

            $ashtakoot = $ashtakoot['data']['data'];
            $compact = array(
                'ashtakoot' => $ashtakoot,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $ashtakoot['data']['msg']);

        }

    }

    public function get_kundali_matching_bhakut_dosha_details($form_data, $messages) {

        $ashtakoot_analysis = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ashtakoot-milan", $form_data, true);
        $rdr = 'kundali-matching-bhakut-dosha-details';
        $content = '';

        if ($ashtakoot_analysis['status'] == 1 && $ashtakoot_analysis['data']['success'] == 1) {

            $ashtakoot_analysis = $ashtakoot_analysis['data']['data'];
            $compact = array(
                'ashtakoot_analysis' => $ashtakoot_analysis,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $ashtakoot_analysis['data']['msg']);

        }

    }

    public function get_kundali_matching_nadi_dosha_details($form_data, $messages) {

        $ashtakoot_analysis = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ashtakoot-milan", $form_data, true);
        $rdr = 'kundali-matching-nadi-dosha-details';
        $content = '';

        if ($ashtakoot_analysis['status'] == 1 && $ashtakoot_analysis['data']['success'] == 1) {

            $ashtakoot_analysis = $ashtakoot_analysis['data']['data'];
            $compact = array(
                'ashtakoot_analysis' => $ashtakoot_analysis,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $ashtakoot_analysis['data']['msg']);

        }

    }

    public function get_kundali_matching_ashtakoot_analysis_details($form_data, $messages) {

        $ashtakoot_analysis = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ashtakoot-milan", $form_data, true);
        $rdr = 'kundali-matching-ashtakoot-analysis-details';
        $content = '';

        if ($ashtakoot_analysis['status'] == 1 && $ashtakoot_analysis['data']['success'] == 1) {

            $ashtakoot_analysis = $ashtakoot_analysis['data']['data'];
            $compact = array(
                'ashtakoot_analysis' => $ashtakoot_analysis,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $ashtakoot_analysis['data']['msg']);

        }

    }

    public function get_kundali_matching_dashakoot_details($form_data, $messages) {

        $dashakoot = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/dashakoot-milan", $form_data, true);
        $rdr = 'kundali-matching-dashakoot-details';
        $content = '';

        if ($dashakoot['status'] == 1 && $dashakoot['data']['success'] == 1) {

            $dashakoot = $dashakoot['data']['data'];
            $compact = array(
                'dashakoot' => $dashakoot,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $dashakoot['data']['msg']);

        }

    }

    public function get_kundali_matching_personality_report_details($form_data, $messages) {

        $acendant_report = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/matching/ascendant-report", $form_data, true);
        $rdr = 'kundali-matching-personality-report-details';
        $content = '';

        if ($acendant_report['status'] == 1 && $acendant_report['data']['success'] == 1) {

            $acendant_report = $acendant_report['data']['data'];
            $compact = array(
                'po_acendant_report' => isset($acendant_report['p1']) ? $acendant_report['p1'] : [],
                'pt_acendant_report' => isset($acendant_report['p2']) ? $acendant_report['p2'] : [],
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $acendant_report['data']['msg']);

        }

    }

    public function get_kundali_matching_match_making_report_details($form_data, $messages) {

        $ashtakoot = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/ashtakoot-milan", $form_data, true);
        $dashakoot = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/dashakoot-milan", $form_data, true);
        $rdr = 'kundali-matching-match-making-report-details';
        $content = '';

        if ($ashtakoot['status'] == 1 && $ashtakoot['data']['success'] == 1 && $dashakoot['status'] == 1 && $dashakoot['data']['success'] == 1) {

            $ashtakoot = $ashtakoot['data']['data'];
            $dashakoot = $dashakoot['data']['data'];
            $compact = array(
                'ashtakoot' => $ashtakoot,
                'dashakoot' => $dashakoot,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $ashtakoot['data']['msg']);

        }

    }

    public function get_kundali_matching_nav_pancham_yoga_details($form_data, $messages) {

        $pancham_yoga = self::exec_api_req("https://astroapi-3.divineapi.com/indian-api/v1/nav-pancham-yoga", $form_data, true);
        $rdr = 'kundali-matching-nav-pancham-yoga-details';
        $content = '';

        if ($pancham_yoga['status'] == 1 && $pancham_yoga['data']['success'] == 1) {

            $pancham_yoga = $pancham_yoga['data']['data'];
            $compact = array(
                'pancham_yoga' => $pancham_yoga,
                'lang_type' => $form_data['lan'],
                'p1_name' => $form_data['p1_full_name'],
                'p2_name' => $form_data['p2_full_name'],
                'messages' => $messages,
            );
            return array('tran' => 1, 'data' => self::rdr_temp($rdr, $compact));

        } else {

            return array('tran' => 0, 'msg' => $pancham_yoga['data']['msg']);

        }

    }

}