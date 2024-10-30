<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['kp_house_cusps_and_chart'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="table-div mt-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['house'] ?></th>
                <th><?= $messages['sign'] ?></th>
                <th><?= $messages['degrees'] ?></th>
                <th><?= $messages['sign_lord'] ?></th>
                <th><?= $messages['nakshatra'] ?></th>
                <th><?= $messages['nakshatra_lord'] ?></th>
                <th><?= $messages['sub_lord'] ?></th>
                <th><?= $messages['ss_lord'] ?></th>
            </tr>
            <?php 
            if(isset($KP_house_cusps_and_chart['table_data'])
            && !empty($KP_house_cusps_and_chart['table_data'])){
                foreach($KP_house_cusps_and_chart['table_data'] as $key => $table_data){
                    ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $table_data['house_cusp']['sign'] ?></td>
                        <td><?= $table_data['house_cusp']['degree'] ?></td>
                        <td><?= $table_data['rashi_lord'] ?></td>
                        <td><?= $table_data['nakshatra'] ?></td>
                        <td><?= $table_data['nakshatra_lord'] ?></td>
                        <td><?= $table_data['sub_lord'] ?></td>
                        <td><?= $table_data['sub_sub_lord'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <div class="text-center mt-20">
        <div class="divine-row justify-content-center">
            <div class="col-md-6 mx-auto">
                <div class="chart" style="display:inline-block;">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($KP_house_cusps_and_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
    </div>
</div>