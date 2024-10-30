
<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['match_making_report'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 cst-flt-lft">
            <div class="ana_section">
                <div class="row align-items-center">
                    <?php 
                    $point = ($ashtakoot['ashtakoot_milan_result']['points_obtained'] / $ashtakoot['ashtakoot_milan_result']['max_ponits']) * 100;
                    ?>
                    <div class="col-4 text-center">
                        <div class="ana_image">
                            <?php 
                            if($point < 50){
                                ?>
                                <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsdown.png">
                                <?php
                            }else{
                                ?>
                                <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsup.png">
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="ana_text2"><?= $messages['ASHTAKOOT_cp'] ?></p>
                    </div>
                    <?php 
                    if($point < 50){
                        if($lang_type == "hi"){
                            ?>
                            <div class="col-md-12 ana_desc">पुरुष और स्त्री के बीच मिलने वाले संगतता स्कोर <?= $ashtakoot['ashtakoot_milan_result']['max_ponits'] ?> में से सिर्फ <?= $ashtakoot['ashtakoot_milan_result']['points_obtained'] ?> है, जो बहुत ज्यादा नहीं है। इसके अलावा, उनके राशि चिन्ह दोस्ताना नहीं हैं, जिससे मानसिक संबंध और प्रेम की कमी हो सकती है। इसलिए, यह एक अनुकूल अष्टकूट मिलान नहीं हो सकता।</div>
                            <?php
                        }else{
                            ?>
                            <div class="col-md-12 ana_desc">The compatibility score between the male and female is only <?= $ashtakoot['ashtakoot_milan_result']['points_obtained'] ?> out of <?= $ashtakoot['ashtakoot_milan_result']['max_ponits'] ?>, which is not very high. Moreover, their zodiac signs are not friendly, indicating possible lack of mental compatibility and affection. Hence, it may not be a favorable Ashtakoota match.</div>
                            <?php
                        }
                    }else{
                        if($lang_type == "hi"){
                            ?>
                            <div class="col-md-12 ana_desc">पुरुष और स्त्री के बीच मिलने वाले संगतता स्कोर <?= $ashtakoot['ashtakoot_milan_result']['max_ponits'] ?> में से <?= $ashtakoot['ashtakoot_milan_result']['points_obtained'] ?> है, जो काफी अच्छा माना जाता है। इसके अलावा, उनके राशि चिन्ह भी दोस्ताना हैं, जिससे मानसिक संबंध और प्रेम की भावना होती है। समग्र रूप से, यह एक अनुकूल मिलान है अष्टकूट के अनुसार।</div>
                            <?php
                        }else{
                            ?>
                            <div class="col-md-12 ana_desc">The compatibility score between the male and female is <?= $ashtakoot['ashtakoot_milan_result']['points_obtained'] ?> out of <?= $ashtakoot['ashtakoot_milan_result']['max_ponits'] ?>, which is considered reasonably good. Additionally, their zodiac signs are friendly, indicating mental compatibility and mutual affection. Overall, it's a favorable match according to Ashtakoota.</div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 cst-flt-lft">
            <div class="ana_section">
                <div class="row align-items-center">
                    <?php 
                    $point = ($dashakoot['dashakoot_milan_result']['points_obtained'] / $dashakoot['dashakoot_milan_result']['max_ponits']) * 100;
                    ?>
                    <div class="col-4 text-center">
                        <div class="ana_image">
                            <?php 
                            if($point < 50){
                                ?>
                                <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsdown.png">
                                <?php
                            }else{
                                ?>
                                <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsup.png">
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="ana_text2"><?= $messages['DASHAKOOT_cp'] ?></p>
                    </div>
                    <?php 
                    if($point < 50){
                        if($lang_type == "hi"){
                            ?>
                            <div class="col-md-12 ana_desc">पुरुष और स्त्री के बीच मिलने वाले संगतता स्कोर <?= $dashakoot['dashakoot_milan_result']['max_ponits'] ?> में से सिर्फ <?= $dashakoot['dashakoot_milan_result']['points_obtained'] ?> है, जो बहुत ज्यादा नहीं है। यह दोनों के बीच मानसिक संगतता और प्रेम की कमी की संभावना दर्शाता है। इसलिए, यह एक अनुकूल दशकूट मिलान नहीं हो सकता।</div>
                            <?php
                        }else{
                            ?>
                            <div class="col-md-12 ana_desc">The compatibility score between the male and female is only <?= $dashakoot['dashakoot_milan_result']['points_obtained'] ?> out of <?= $dashakoot['dashakoot_milan_result']['max_ponits'] ?>, which is not very high. It may suggest a lack of mental compatibility and mutual affection between the two. Hence, it might not be a favorable Dashakoota match.</div>
                            <?php
                        }
                    }else{
                        if($lang_type == "hi"){
                            ?>
                            <div class="col-md-12 ana_desc">पुरुष और स्त्री के बीच मिलने वाले संगतता स्कोर <?= $dashakoot['dashakoot_milan_result']['max_ponits'] ?> में से <?= $dashakoot['dashakoot_milan_result']['points_obtained'] ?> है, जो काफी अच्छा माना जाता है। यह दोनों के बीच मानसिक संगतता और प्रेम की प्रतीति को दर्शाता है। इसलिए, यह एक अनुकूल दशकूट मिलान है।</div>
                            <?php
                        }else{
                            ?>
                            <div class="col-md-12 ana_desc">The compatibility score between the male and female is <?= $dashakoot['dashakoot_milan_result']['points_obtained'] ?> out of <?= $dashakoot['dashakoot_milan_result']['max_ponits'] ?>, which is considered reasonably good. This indicates mental compatibility and mutual affection between the two. Hence, it's a favorable Dashakoota match.</div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 cst-flt-lft">
            <div class="ana_section">
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <div class="ana_image">
                            <?php 
                            if($ashtakoot['manglik_dosha']['p1'] == $ashtakoot['manglik_dosha']['p2']){
                                ?><img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsup.png"><?php
                            }else{
                                ?><img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsdown.png"><?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="ana_text2"><?= $messages['MANGLIK_cp'] ?></p>
                    </div>
                    <?php 
                    if($ashtakoot['manglik_dosha']['p1'] == "true"
                    && $ashtakoot['manglik_dosha']['p2'] == "true"){
                        ?><div class="col-md-12 ana_desc"><?= $messages['is_recommended_r1'] ?></div><?php
                    }else if($ashtakoot['manglik_dosha']['p1'] == "false"
                    && $ashtakoot['manglik_dosha']['p2'] == "false"){
                        ?><div class="col-md-12 ana_desc"><?= $messages['is_recommended_r2'] ?></div><?php
                    }else if($ashtakoot['manglik_dosha']['p1'] == "true"
                    && $ashtakoot['manglik_dosha']['p2'] == "false"){
                        ?><div class="col-md-12 ana_desc"><?= $messages['is_recommended_r3'] ?></div><?php
                    }else if($ashtakoot['manglik_dosha']['p1'] == "false"
                    && $ashtakoot['manglik_dosha']['p2'] == "true"){
                        ?><div class="col-md-12 ana_desc"><?= $messages['is_recommended_r4'] ?></div><?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>