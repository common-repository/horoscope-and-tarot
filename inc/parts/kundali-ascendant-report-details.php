<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['ascendant_report'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="divine-row justify-content-center mt-20">
        <div class="col-xl-4 col-md-6 cst-flt-lft">
            <div class="ass_img">
                <?php 
                if($ascendant_report['symble'] == "Lion"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Leo.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Virgin Girl"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Virgo.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Weigh Balance"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Libra.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Scorpion"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Scorpio.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Archer"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Sagittarius.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Wild Goat"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Capricorn.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Male with a Pot"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Aquarius.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Fish"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Pisces.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Ram"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Aries.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Bull"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Taurus.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Male-Female"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Gemini.png' ?>" alt=""><?php
                }else if($ascendant_report['symble'] == "Crab"){
                    ?><img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali-zodiac/Cancer.png' ?>" alt=""><?php
                }
                ?>
                
            </div>
        </div>
        <div class="col-xl-7 col-md-6 cst-flt-lft">
            <div class="table-div mb-20">
                <table class="table chile-table table-striped mb-0">
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['lord'] ?></th>
                        <td style="vertical-align: top;"><?= $ascendant_report['planetary_lord'] ?></td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['symbol'] ?></th>
                        <td style="vertical-align: top;"><?= $ascendant_report['symble'] ?></td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['characteristics'] ?></th>
                        <td style="vertical-align: top;"><?= $ascendant_report['characteristics'] ?></td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['day_of_fast'] ?></th>
                        <td style="vertical-align: top;"><?= $ascendant_report['day_of_fast'] ?></td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['lucky_gems'] ?></th>
                        <td style="vertical-align: top;"><?= isset($ascendant_report['lucky_stone']) && !empty($ascendant_report['lucky_stone']) ? (implode(", ",$ascendant_report['lucky_stone'])) : "" ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-xl-11 col-md-12 mt-20">
            <div class="mt-20 mb-20">
                <p style="white-space: break-spaces;"><?= $ascendant_report['article'] ?></p>
            </div>
        </div>
    </div>
</div>