<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['house_cusps_and_sandhi'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="mt-20 mb-10">
        <p class="dark-title text-left">&nbsp;&nbsp;&nbsp;<?= $messages['ascendant'] ?> - <?= $chalit_chart['ascendant']['lat'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $messages['midheaven'] ?> - <?= $chalit_chart['midheaven']['lat'] ?></p>
    </div>
    <div class="table-div mt-10 mb-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['house'] ?></th>
                <th><?= $messages['sign'] ?></th>
                <th><?= $messages['bhav_madhya'] ?></th>
                <th><?= $messages['sign'] ?></th>
                <th><?= $messages['bhav_sandhi'] ?></th>
            </tr>
            
            <?php
            if(isset($chalit_chart['chalit_table'])
            && !empty($chalit_chart['chalit_table'])){
                foreach($chalit_chart['chalit_table'] as $key => $chalit_table){
                    
                    echo '<tr>
                            <td>' . $key . '</td>
                            <td>' . $chalit_table['mid_point']['sign_name'] . '</td>
                            <td>' . $chalit_table['mid_point']['bhav_madhya'] . '</td>
                            <td>' . $chalit_table['start_point']['sign_name'] . '</td>
                            <td>' . $chalit_table['start_point']['bhav_madhya'] . '</td>
                        </tr>';
                    
                }
            }
            ?>
        
        </table>
    </div>
    <div class="divine-row">
        <div class="col-xl-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $messages['chalit_chart'] ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($chalit_chart['svg'])  ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title dark-title-blank">Blank</p>
                <div class="chart-blank-content">
                    <p><?= $messages['chalit_text'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>