<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['sadhesati_life_analysis'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="table-div mt-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['moon_sign'] ?></th>
                <th><?= $messages['saturn_sign'] ?></th>
                <th><?= $messages['saturn_ratro'] ?></th>
                <th><?= $messages['phase_type'] ?></th>
                <th><?= $messages['date'] ?></th>
                <th><?= $messages['summary'] ?></th>
            </tr>
            <?php 
            $moon_sign = isset($sadhe_sati['moon_sign']) ? $sadhe_sati['moon_sign'] : "";
            ?>
            <?php 
            if(isset($sadhe_sati['sadhesati_life_analysis'])
            && !empty($sadhe_sati['sadhesati_life_analysis'])){
                foreach($sadhe_sati['sadhesati_life_analysis'] as $key => $sadhesati_life_analysis){
                    ?>
                    <tr>
                        <td><?= $moon_sign ?></td>
                        <td><?= $sadhesati_life_analysis['sign_name'] ?></td>
                        <td><?= $sadhesati_life_analysis['is_retro'] ?></td>
                        <td><?= $sadhesati_life_analysis['phase'] ?></td>
                        <td><p style="white-space: pre;margin:0px;"><?= date_format(date_create($sadhesati_life_analysis['date']),"d/m/Y") ?></p></td>
                        <td>
                            <?php 
                            if($sadhesati_life_analysis['phase'] == "RISING_START"){
                                echo $messages['summary1'];
                            }else if($sadhesati_life_analysis['phase'] == "RISING_END"){
                                echo $messages['summary2'];
                            }else if($sadhesati_life_analysis['phase'] == "PEAK_START"){
                                echo $messages['summary3'];
                            }else if($sadhesati_life_analysis['phase'] == "PEAK_END"){
                                echo $messages['summary4'];
                            }else if($sadhesati_life_analysis['phase'] == "SETTING_START"){
                                echo $messages['summary5'];
                            }else if($sadhesati_life_analysis['phase'] == "SETTING_END"){
                                echo $messages['summary6'];
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>