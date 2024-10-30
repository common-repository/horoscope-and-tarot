
<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['planetary_positions'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png"">
        </div>
    </div>
    <div class="table-div mt-10">
        <p class="dark-title"><?= $p1_name ?> <?= $messages['planetary_positions'] ?></p>
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['r'] ?></th>
                <th><?= $messages['sign'] ?></th>
                <th><?= $messages['degrees'] ?></th>
                <th><?= $messages['sign_lord'] ?></th>
                <th><?= $messages['nakshatra'] ?></th>
                <th><?= $messages['nakshatra_lord'] ?></th>
                <th><?= $messages['house'] ?></th>
            </tr>
            <?php 
            if(isset($po_planetary_position['planets'])
            && !empty($po_planetary_position['planets'])){
                foreach($po_planetary_position['planets'] as $po_pla_pos){
                    ?>
                    <tr>
                        <td><?= $messages[$po_pla_pos['name']] ?></td>
                        <td><?= $po_pla_pos['is_retro'] == "true" ? "R" : "--" ?></td>
                        <td><?= $po_pla_pos['sign'] ?></td>
                        <td><?= $po_pla_pos['longitude'] ?></td>
                        <td><?= $po_pla_pos['sub_lord'] ?></td>
                        <td><?= $po_pla_pos['nakshatra'] ?></td>
                        <td><?= $po_pla_pos['nakshatra_lord'] ?></td>
                        <td><?= $po_pla_pos['house'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <div class="table-div mt-10">
        <p class="dark-title"><?= $p2_name ?> <?= $messages['planetary_positions'] ?></p>
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['r'] ?></th>
                <th><?= $messages['sign'] ?></th>
                <th><?= $messages['degrees'] ?></th>
                <th><?= $messages['sign_lord'] ?></th>
                <th><?= $messages['nakshatra'] ?></th>
                <th><?= $messages['nakshatra_lord'] ?></th>
                <th><?= $messages['house'] ?></th>
            </tr>
            <?php 
            if(isset($pt_planetary_position['planets'])
            && !empty($pt_planetary_position['planets'])){
                foreach($pt_planetary_position['planets'] as $pt_pla_pos){
                    ?>
                    <tr>
                        <td><?= $messages[$pt_pla_pos['name']] ?></td>
                        <td><?= $pt_pla_pos['is_retro'] == "true" ? "R" : "--" ?></td>
                        <td><?= $pt_pla_pos['sign'] ?></td>
                        <td><?= $pt_pla_pos['longitude'] ?></td>
                        <td><?= $pt_pla_pos['sub_lord'] ?></td>
                        <td><?= $pt_pla_pos['nakshatra'] ?></td>
                        <td><?= $pt_pla_pos['nakshatra_lord'] ?></td>
                        <td><?= $pt_pla_pos['house'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>