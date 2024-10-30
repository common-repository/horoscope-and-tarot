<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['kp_planetary_details'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="table-div mt-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['r'] ?></th>
                <th><?= $messages['sign'] ?></th>
                <th><?= $messages['degrees'] ?></th>
                <th><?= $messages['sign_lord'] ?></th>
                <th><?= $messages['house'] ?></th>
            </tr>
            <?php 
            if(isset($KP_planetary_details['planets'])
            && !empty($KP_planetary_details['planets'])){
                foreach($KP_planetary_details['planets'] as $key => $planets){
                    ?>
                    <tr>
                        <td><?= $planets['name'] ?></td>
                        <td><?= $planets['is_retro'] == "true" ? "R" : "-" ?></td>
                        <td><?= $planets['sign'] ?></td>
                        <td><?= $planets['full_degree'] ?></td>
                        <td><?= $planets['rashi_lord'] ?></td>
                        <td><?= $planets['house'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <div class="table-div mt-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['nakshatra'] ?></th>
                <th><?= $messages['nakshatra_lord'] ?></th>
                <th><?= $messages['charan'] ?></th>
                <th><?= $messages['sub_lord'] ?></th>
                <th><?= $messages['ss_lord'] ?></th>
            </tr>
            <?php 
            if(isset($KP_planetary_details['planets'])
            && !empty($KP_planetary_details['planets'])){
                foreach($KP_planetary_details['planets'] as $key => $planets){
                    ?>
                    <tr>
                        <td><?= $planets['name'] ?></td>
                        <td><?= $planets['nakshatra'] ?></td>
                        <td><?= $planets['nakshatra_lord'] ?></td>
                        <td><?= $planets['nakshatra_pada'] ?></td>
                        <td><?= $planets['sub_lord'] ?></td>
                        <td><?= $planets['sub_sub_lord'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>