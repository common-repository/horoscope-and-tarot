
<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['personality_report'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    <div class="row justify-content-center">
        <?php 
        if($po_acendant_report['ascendant'] == $pt_acendant_report['ascendant']){
            ?>
            <div class="col-xl-10">
                <div class="border rounded p-3">
                    <p class="dark-title"><?= $p1_name ?> & <?= $p2_name ?> <?= $messages['personality_report_same'] ?></p>
                    <p style="white-space: break-spaces;font-size:14px;"><?= $po_acendant_report['article'] ?></p>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div class="col-xl-6 col-lg-6 col-md-10 cst-flt-lft">
                <div class="border rounded p-3">
                    <p class="dark-title"><?= $p1_name ?> <?= $messages['personality_report'] ?></p>
                    <p style="white-space: break-spaces;font-size:14px;"><?= $po_acendant_report['article'] ?></p>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-10 cst-flt-lft">
                <div class="border rounded p-3">
                    <p class="dark-title"><?= $p2_name ?> <?= $messages['personality_report'] ?></p>
                    <p style="white-space: break-spaces;font-size:14px;"><?= $pt_acendant_report['article'] ?></p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>