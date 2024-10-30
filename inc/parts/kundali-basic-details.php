<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['basic_astro_detail'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="table-div small mb-20">
        <h2 class="table-title"><?= $messages['basic_details'] ?></h2>
        <table class="chile-table table table-striped">
            <tr>
                <th><?= $messages['date_of_birth'] ?></th>
                <td><?= date('d M Y', strtotime($basic_astro_detail['date'])) ?></td>
            </tr>
            <tr>
                <th><?= $messages['time_of_birth'] ?></th>
                <td><?= $basic_astro_detail['hour'] ?>:<?= $basic_astro_detail['minute'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['place_of_birth'] ?></th>
                <td><?= $basic_astro_detail['place'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['latitude'] ?></th>
                <td><?= $basic_astro_detail['latitude'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['longitude'] ?></th>
                <td><?= $basic_astro_detail['longitude'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['timezone'] ?></th>
                <td><?= $basic_astro_detail['timezone'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['ayanamsa'] ?></th>
                <td><?= $messages['lahiri'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['sunrise'] ?></th>
                <td><?= date('H:i:s', strtotime($basic_astro_detail['sunrise'])) ?></td>
            </tr>
            <tr>
                <th><?= $messages['sunset'] ?></th>
                <td><?= date('H:i:s', strtotime($basic_astro_detail['sunset'])) ?></td>
            </tr>
        </table>
    </div>
    <div class="table-div small mb-20">
        <h2 class="table-title"><?= $messages['ghat_chakra'] ?></h2>
        <table class="chile-table table table-striped">
            <tr>
                <th><?= $messages['month'] ?></th>
                <td><?= $basic_astro_detail['chandramasa'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['tithi'] ?></th>
                <td>
                    
                <?php
                if(isset($panchag['tithis'])
                && !empty($panchag['tithis'])){
                    foreach($panchag['tithis'] as $key => $tithis){
                        if($key != "0"){
                            echo ', ';
                        }
                        echo $tithis['number'];
                    }
                }
                ?>
                                    
                </td>
            </tr>
            <tr>
                <th><?= $messages['day'] ?></th>
                <td><?= $basic_astro_detail['vaar'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['nakshatra'] ?></th>
                <td><?= $basic_astro_detail['nakshatra'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['prahar'] ?></th>
                <td><?= $basic_astro_detail['prahar'] ?></td>
            </tr>
        </table>
    </div>
    <div class="table-div small mb-20">
        <h2 class="table-title"><?= $messages['panchang_details'] ?></h2>
        <table class="chile-table table table-striped">
            <tr>
                <th><?= $messages['tithi'] ?></th>
                <td><?= $basic_astro_detail['paksha'] ?> <?= $basic_astro_detail['tithi'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['yog'] ?></th>
                <td>
                        
                    <?php
                    if(isset($panchag['yogas'])
                    && !empty($panchag['yogas'])){
                        foreach($panchag['yogas'] as $key => $yogas){
                            if(strtotime($yogas['start_time']) <= $birth_date
                            && strtotime($yogas['end_time']) > $birth_date){
                                echo $yogas['yoga_name'];
                            }
                        }
                    }
                    ?>
                    
                </td>
            </tr>
            <tr>
                <th><?= $messages['nakshatra'] ?></th>
                <td><?= $basic_astro_detail['nakshatra'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['karan'] ?></th>
                <td>
                    
                    <?php
                    if(isset($panchag['karnas'])
                    && !empty($panchag['karnas'])){
                        foreach($panchag['karnas'] as $key => $karnas){
                            if(strtotime($karnas['start_time']) <= $birth_date
                            && strtotime($karnas['end_time']) > $birth_date){
                                echo $karnas['karana_name'];
                            }
                        }
                    }
                    ?>
                    
                </td>
            </tr>
        </table>
    </div>
    <?php
    $paya = $basic_astro_detail['paya']['type'] ?? "";
    ?>
    <div class="table-div small mb-20">
        <h2 class="table-title"><?= $messages['astrological_details'] ?></h2>
        <table class="chile-table table table-striped">
            <tr>
                <th><?= $messages['varna'] ?></th>
                <td><?= $basic_astro_detail['varna'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['vashya'] ?></th>
                <td><?= $basic_astro_detail['vashya'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['yoni'] ?></th>
                <td><?= $basic_astro_detail['yoni'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['gan'] ?></th>
                <td><?= $basic_astro_detail['gana'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['nadi'] ?></th>
                <td><?= $basic_astro_detail['nadi'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['sign'] ?></th>
                <td><?= $moon_data['sign'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['sign_lord'] ?></th>
                <td><?= $moon_data['rashi_lord'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['nakshatra'] ?></th>
                <td><?= $moon_data['nakshatra'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['nakshatra_lord'] ?></th>
                <td><?= $moon_data['nakshatra_lord'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['charan'] ?></th>
                <td><?= $moon_data['nakshatra_pada'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['tatva'] ?></th>
                <td><?= $basic_astro_detail['tatva'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['name_alphabet'] ?></th>
                <td><?= $basic_astro_detail['rashi_akshar'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['paya'] ?></th>
                <td><?= $paya ?></td>
            </tr>
            <tr>
                <th><?= $messages['ascendant'] ?></th>
                <td><?= $ascendant['ascendant'] ?></td>
            </tr>
            <tr>
                <th><?= $messages['ascendant_lord'] ?></th>
                <td><?= $ascendant['planetary_lord'] ?></td>
            </tr>
        </table>
    </div>
</div>