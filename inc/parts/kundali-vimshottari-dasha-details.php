<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['vimshottari_dasha'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="mt-20">
        <div class="divine-row">
            <?php 
            if(isset($vimshottari_dasha['maha_dasha'])
            && !empty($vimshottari_dasha['maha_dasha'])){
                foreach($vimshottari_dasha['maha_dasha'] as $key => $vimsh_dash){
                    ?>
                    <div class="col-xl-4 col-md-4 col-md-6 cst-flt-lft">
                        <div class="mt-20">
                            <p class="dark-title"><?= $key ?></p>
                            <div class="dates">
                                <p><?= $vimsh_dash['start_date'] != "--" ? date_format(date_create($vimsh_dash['start_date']),"d-m-Y") : "--" ?></p>
                                <p><?= $vimsh_dash['end_date'] != "--" ? date_format(date_create($vimsh_dash['end_date']),"d-m-Y") : "--" ?></p>
                            </div>
                            <?php 
                            if(isset($vimsh_dash['antar_dasha'])
                            && !empty($vimsh_dash['antar_dasha'])){
                                ?>
                                <div class="table-div">
                                    <table class="chile-table table table-striped">
                                        <?php 
                                        foreach($vimsh_dash['antar_dasha'] as $ak => $antar_dasha){
                                            ?>
                                            <tr>
                                                <td><?= $ak ?></td>
                                                <td><?= $antar_dasha['end_time'] != "--" ? date_format(date_create($antar_dasha['end_time']),"d-m-Y") : "--" ?></td>
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
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-12">
                <p class="dark-title my-3 text-left"><?= $messages['vim_note'] ?></p>
            </div>

        </div>
    </div>
</div>