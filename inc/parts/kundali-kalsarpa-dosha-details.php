<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['kalsarpa_dosha'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="divine-row justify-content-center">
        <div class="col-xl-12">
            <div class="fixed_with_image">
                <figure class="fx-img">
                    <img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/KaalSarpDosh.png' ?>">
                </figure>
                <div>
                <?php 
                    if($lang_type == "hi"){
                        ?>
                        <p class="fx-h3">कालसर्प दोष क्या है?</p>
                        <p class="fix_desc">राहु और केतु चंद्रमा के दो ग्रह बिंदु हैं और वेदिक ज्योतिष में इन्हें पूर्णतः ग्रह माना जाता है। इन्हें उनके भारी कर्मिक प्रभाव के कारण सबसे भयानक ग्रह माना जाता है। यदि सभी 7 ग्रह राहु और केतु के बीच स्थित होते हैं, तो कालसर्प योग बनता है। कालसर्प दोष के अधिकांश प्रभाव नकारात्मक होते हैं, हालांकि कुछ धन्यवादी भी हो सकते हैं। राहु या केतु अचानक सकारात्मक परिवर्तन देते हैं जो बड़े होते हैं और रातोंरात या कुछ दिनों के अंदर हो सकते हैं।</b>
                        </p>
                        <?php
                    }else{
                        ?>
                        <p class="fx-h3">What is Kalsarpa dosha?</p>
                        <p class="fix_desc">Rahu and Ketu are two nodes of Moon and they are regarded as fullfledged planets in Vedic Astrology. They are considered as most
                            dreaded planets due to their heavy karmic effects.If all the 7 planets
                            are situated between Rahu and Ketu then Kaal Sarp Yog is formed.
                            <b>Most of the the Kalasarpa dosha effects are negative, while few
                            can be positive too.Rahu or Ketu gives sudden positive changes
                            which are huge and can happen overnight or within a span of few
                            days.</b>
                        </p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-6 mx-auto">
            <div class="table-div mb-20 mt-20">
                <table class="table chile-table table-striped mb-0 mx-auto">
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['is_kalsarpa_present'] ?></th>
                        <td style="vertical-align: top;"><?= $kalsarpa_dosha['result'] == "true" ? "YES" : "NO" ?></td>
                    </tr>
                    <?php 
                    if($kalsarpa_dosha['result'] == "true"){
                        ?>
                        <tr>
                            <th style="vertical-align: top;"><?= $messages['intensity'] ?></th>
                            <td style="vertical-align: top;"><?= $kalsarpa_dosha['intensity'] ?></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;"><?= $messages['kalsarpa_name'] ?></th>
                            <td style="vertical-align: top;"><?= $kalsarpa_dosha['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;"><?= $messages['direction'] ?></th>
                            <td style="vertical-align: top;"><?= $kalsarpa_dosha['direction'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php 
        if(!empty($kalsarpa_dosha['remedies'])){
            ?>
            <div class="col-xl-12">
                <div class="table-div mb-20">
                    <table class="chile-table child-header table table-striped">
                        <tr class="table-header">
                            <th colspan="2"><?= $messages['remedies_kaal'] ?></th>
                        </tr>
                        <?php 
                        foreach($kalsarpa_dosha['remedies'] as $rkey => $remedies){
                            ?>
                            <tr>
                                <td style="vertical-align: top;"><?= ($rkey + 1)  ?></td>
                                <td style="vertical-align: top;"><?= $remedies ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>      
    </div>
</div>