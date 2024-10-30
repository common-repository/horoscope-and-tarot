<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['basic_astro_detail'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    <div class="table-div small mb-20">
        <h2 class="table-title"><?= $messages['basic_details'] ?></h2>
        <table class="chile-table chile-table-center table table-striped text-center">
            <tr>
                <td><?= date_format(date_create($po_basic_astro['date']),"d/m/Y") ?></td>
                <th><?= $messages['date_of_birth'] ?></th>
                <td><?= date_format(date_create($pt_basic_astro['date']),"d/m/Y") ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['hour'] ?>:<?= $po_basic_astro['minute'] ?></td>
                <th><?= $messages['time_of_birth'] ?></th>
                <td><?= $pt_basic_astro['hour'] ?>:<?= $pt_basic_astro['minute'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['latitude'] ?></td>
                <th><?= $messages['latitude'] ?></th>
                <td><?= $pt_basic_astro['latitude'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['longitude'] ?></td>
                <th><?= $messages['longitude'] ?></th>
                <td><?= $pt_basic_astro['longitude'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['timezone'] ?></td>
                <th><?= $messages['timezone'] ?></th>
                <td><?= $pt_basic_astro['timezone'] ?></td>
            </tr>
            <!-- <tr>
                <td><? //$po_anayas['lahiri_ayanamsha'] ?></td>
                <th><? //$messages['ayanamsa'] ?></th>
                <td><? //$pt_anayas['lahiri_ayanamsha'] ?></td>
            </tr> -->
            <tr>
                <td><?= date_format(date_create($po_basic_astro['sunrise']),"H:i:s") ?></td>
                <th><?= $messages['sunrise'] ?></th>
                <td><?= date_format(date_create($pt_basic_astro['sunrise']),"H:i:s") ?></td>
            </tr>
            <tr>
                <td><?= date_format(date_create($po_basic_astro['sunset']),"H:i:s") ?></td>
                <th><?= $messages['sunset'] ?></th>
                <td><?= date_format(date_create($pt_basic_astro['sunset']),"H:i:s") ?></td>
            </tr>
        </table>
    </div>
    <div class="table-div small mb-20">
        <h2 class="table-title"><?= $messages['astrological_details'] ?></h2>
        <table class="chile-table chile-table-center table table-striped">
            <tr>
                <td><?= $po_basic_astro['varna'] ?></td>
                <th><?= $messages['varna'] ?></th>
                <td><?= $pt_basic_astro['varna'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['vashya'] ?></td>
                <th><?= $messages['vashya'] ?></th>
                <td><?= $pt_basic_astro['vashya'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['yoni'] ?></td>
                <th><?= $messages['yoni'] ?></th>
                <td><?= $pt_basic_astro['yoni'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['gana'] ?></td>
                <th><?= $messages['gan'] ?></th>
                <td><?= $pt_basic_astro['gana'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['nadi'] ?></td>
                <th><?= $messages['nadi'] ?></th>
                <td><?= $pt_basic_astro['nadi'] ?></td>
            </tr>
            <tr>
                <td><?= $po_moon_data['rashi_lord'] ?></td>
                <th><?= $messages['sign_lord'] ?></th>
                <td><?= $pt_moon_data['rashi_lord'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['nakshatra'] ?></td>
                <th><?= $messages['nakshatra'] ?></th>
                <td><?= $pt_basic_astro['nakshatra'] ?></td>
            </tr>
            <tr>
                <td><?= $po_moon_data['nakshatra_lord'] ?></td>
                <th><?= $messages['nakshatra_lord'] ?></th>
                <td><?= $pt_moon_data['nakshatra_lord'] ?></td>
            </tr>
            <tr>
                <td><?= $po_moon_data['nakshatra_pada'] ?></td>
                <th><?= $messages['charan'] ?></th>
                <td><?= $pt_moon_data['nakshatra_pada'] ?></td>
            </tr>
            <!-- <tr>
                <td>
                    <?php
                    // if(isset($po_panchag['tithis'])
                    // && !empty($po_panchag['tithis'])){
                    //     foreach($po_panchag['tithis'] as $key => $tithis){
                    //         if($key != "0"){
                    //             echo ", ";
                    //         }
                    //         echo $tithis['number'];
                    //     }
                    // }
                    ?>
                </td>
                <th><? //$messages['tithi'] ?></th>
                <td>
                    <?php
                    // if(isset($pt_panchag['tithis'])
                    // && !empty($pt_panchag['tithis'])){
                    //     foreach($pt_panchag['tithis'] as $key => $tithis){
                    //         if($key != "0"){
                    //             echo ", ";
                    //         }
                    //         echo $tithis['number'];
                    //     }
                    // }
                    ?>
                </td>
            </tr> -->
            <tr>
                <td><?= $po_basic_astro['tatva'] ?></td>
                <th><?= $messages['tatva'] ?></th>
                <td><?= $pt_basic_astro['tatva'] ?></td>
            </tr>
            <tr>
                <td><?= $po_basic_astro['rashi_akshar'] ?></td>
                <th><?= $messages['name_alphabet'] ?></th>
                <td><?= $pt_basic_astro['rashi_akshar'] ?></td>
            </tr>
            <tr>
                <td><?= isset($po_basic_astro['paya']['type']) ? $po_basic_astro['paya']['type'] : "" ?></td>
                <th><?= $messages['paya'] ?></th>
                <td><?= isset($pt_basic_astro['paya']['type']) ? $pt_basic_astro['paya']['type'] : "" ?></td>
            </tr>
        </table>
    </div>
</div>