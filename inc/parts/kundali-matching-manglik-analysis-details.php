<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['manglik_analysis'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="fixed_with_image">
                <figure class="fx-img">
                    <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/Manglikdosha.png">
                </figure>
                <div>
                    <?php 
                    if($lang_type == "hi"){
                        ?>
                        <p class="fx-h3">मांगलिक दोष क्या है?</p>
                        <p class="fix_desc">"एक लड़के या लड़की की कुंडली में, पहले, चौथे, सातवें, आठवें, या बारहवें भाव में मंगल, सूर्य, शनि, राहु या केतु की उपस्थिति को ""मांगलिक दोष"" नामक स्थिति को पैदा करने का माना जाता है।</p>
                        <p class="fix_desc">मांगलिक दोष की शक्ति को ज्योतिषशास्त्रों (प्राचीन पाठ्यक्रम) के अनुसार विचार किया जाता है जब मंगल लग्न में स्थित होता है, जिसे चंद्रमा के साथ संयुक्त किया जाता है। यदि शादीशुदा जीवन के लिए बोय और गर्ल दोनों के लिए मांगलिक दोष को शास्त्रों द्वारा समाप्त किया जाता है, तो उन्हें खुशहाल और सुखी विवाहित जीवन के लिए प्रार्थनीत माना जाता है।</p>
                        <p class="fix_desc">हालांकि, यदि मांगलिक दोष न रहे, तो इसे उनके जीवन में अनावश्यक समस्याएँ और बाधाएँ पैदा करने का कहा जाता है। इसलिए, विवाहित जीवन की शुरुआत से पहले व्यक्तियों को अपनी कुंडलियों को ध्यान से मिलाने की सलाह दी जाती है। मांगलिक दोष को ठीक से निरस्त करके, व्यक्ति शांति और समृद्धि से भरा जीवन की उम्मीद कर सकता है।</p>
                        <?php
                    }else{
                        ?>
                        <p class="fx-h3">What is manglik dosha?</p>
                        <p class="fix_desc">In the horoscope of a boy or a girl, the presence of Mars, Sun, Saturn, Rahu, or Ketu in the first, fourth, seventh, eighth, or twelfth house is believed to create a condition known as "Manglik dosh."</p>
                        <p class="fix_desc">The strength of Manglik dosh is considered more significant when Mars is positioned in the ascendant, compared to when it is conjoined with the Moon in the ascendant. If, according to the Shastras (ancient texts), the Manglik dosh is nullified for both the boy and the girl, they are believed to be destined for a happy and harmonious married life.</p>
                        <p class="fix_desc">However, if the Manglik dosh remains uncancelled, it is thought to lead to unnecessary problems and obstacles in their lives. Therefore, it is advisable for individuals to have their horoscopes thoroughly matched before embarking on married life. By properly nullifying the Manglik dosh, one can expect a life filled with peace and prosperity.</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>   
        <div class="col-xl-12">
            <div class="fixed_with_image">
                <div class="row justify-content-center">
                    <div class="col-md-6 my-3 text-center cst-flt-lft">
                        <p class="dark-title"><?= $p1_name ?> <?= $messages['manglik_detail'] ?></p>
                        <button class="cst-kndlirpt-btn w-100 mx-auto"><?= $manglik_analysis['manglik_dosha']['p1'] == "true" ? "Yes" : "No" ?></button>
                    </div>
                    <div class="col-md-6 my-3 text-center cst-flt-lft">
                        <p class="dark-title"><?= $p2_name ?> <?= $messages['manglik_detail'] ?></p>
                        <button class="cst-kndlirpt-btn w-100 mx-auto"><?= $manglik_analysis['manglik_dosha']['p2'] == "true" ? "Yes" : "No" ?></button>
                    </div>
                    <div class="col-md-6 my-3 text-center mx-auto">
                        <p class="dark-title"><?= $messages['is_recommended'] ?></p>
                        <?php 
                        if($manglik_analysis['manglik_dosha']['p1'] == "true"
                        && $manglik_analysis['manglik_dosha']['p2'] == "true"){
                            ?><p><?= $messages['is_recommended_r1'] ?></p><?php
                        }else if($manglik_analysis['manglik_dosha']['p1'] == "false"
                        && $manglik_analysis['manglik_dosha']['p2'] == "false"){
                            ?><p><?= $messages['is_recommended_r2'] ?></p><?php
                        }else if($manglik_analysis['manglik_dosha']['p1'] == "true"
                        && $manglik_analysis['manglik_dosha']['p2'] == "false"){
                            ?><p><?= $messages['is_recommended_r3'] ?></p><?php
                        }else if($manglik_analysis['manglik_dosha']['p1'] == "false"
                        && $manglik_analysis['manglik_dosha']['p2'] == "true"){
                            ?><p><?= $messages['is_recommended_r4'] ?></p><?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>