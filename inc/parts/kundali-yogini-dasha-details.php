<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['yogini_dasha'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="mt-20">
        <div class="divine-row">
            <?php 
            if(isset($yogini_dasha['maha_dasha'])
            && !empty($yogini_dasha['maha_dasha'])){
                foreach($yogini_dasha['maha_dasha'] as $key => $yog_dasha){
                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
                        <div class="mt-20">
                            <p class="dark-title"><?= $yog_dasha['dasha'] ?></p>
                            <div class="dates">
                                <p><?= $yog_dasha['start_date'] != "--" ? date_format(date_create($yog_dasha['start_date']),"d-m-Y") : "--" ?></p>
                                <p><?= $yog_dasha['end_date'] != "--" ? date_format(date_create($yog_dasha['end_date']),"d-m-Y") : "--" ?></p>
                            </div>
                            <?php 
                            if(isset($yog_dasha['antar_dasha'])
                            && !empty($yog_dasha['antar_dasha'])){
                                ?>
                                <div class="table-div">
                                    <table class="chile-table table table-striped">
                                        <?php 
                                        foreach($yog_dasha['antar_dasha'] as $ak => $antar_dasha){
                                            ?>
                                            <tr>
                                                <td><?= $ak ?></td>
                                                <td><?= $antar_dasha != "--" ? date_format(date_create($antar_dasha),"d-m-Y") : "--" ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="col-md-12 mt-20">
                <p class="dark-title my-3 text-left"><?= $messages['vim_note'] ?></p>
            </div>
        </div>
    </div>
</div>