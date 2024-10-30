<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['bhakut_dosha'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="fixed_with_image">
                <div>
                    <?php 
                        if($lang_type == "hi"){
                            ?>
                            <h3 class="fix_title">भकूट दोष क्या है?</h3>
                            <div class="px-3">
                                <p class="fix_desc my-3"><b>"जोड़ी की सहमति को सहयोगपूर्ण रूप से आपसी समन्वय करने और निर्माणात्मक रूप से साथ काम करने की क्षमता का मूल्यांकन करने के लिए उपयोग किया जाने वाला तकनीक 'भा कूट' के रूप में जाना जाता है। इस विधि में, ""भा"" राशि की चिह्नित करता है, और 'कूट' को जोड़ी की कुंडलियों के चंद्रमा राशियों के स्थानों पर आधारित किया जाता है। सकारात्मक भा कूट के लिए, निम्नलिखित शर्तें पूरी होनी चाहिए:</b></p>
                                <ul>
                                    <li>जोड़ी के चंद्रमा राशि एक जैसी होनी चाहिए।</li>
                                    <li>जोड़ी के चंद्रमा राशि आपस में 7वीं स्थान पर होनी चाहिए।</li>
                                    <li>जोड़ी के चंद्रमा राशि आपस में 3वीं और 11वीं स्थान पर होनी चाहिए।</li>
                                    <li>वैकल्पिक रूप से, जोड़ी के चंद्रमा राशि आपस में 4वीं और 10वीं स्थान पर होनी चाहिए।</li>
                                </ul>
                            </div>
                            <p class="fix_desc">यदि इनमें से किसी भी शर्त को पूरा किया जाता है, तो जोड़ी को भा कूट संगतता के लिए सात अंक प्राप्त होते हैं।</p>
                            <?php
                        }else{
                            ?>
                            <h3 class="fix_title">What is bhakut dosha?</h3>
                            <div class="px-3">
                                <p class="fix_desc my-3"><b>The technique used to assess a couple's ability to cooperate harmoniously and work constructively together is known as "Bha Kuta." In this method, "Bha" refers to the signs of the zodiac, and the Kuta is based on the positions of the Moon signs of the couple's horoscopes. For a positive Bha Kuta, the following conditions should be met:</b></p>
                                <ul>
                                    <li>1. The Moon signs of the couple should be the same.</li>
                                    <li>2. The Moon signs should be in the 7th position from each other.</li>
                                    <li>3. The Moon signs should be in the 3rd and 11th positions from each other.</li>
                                    <li>4. Alternatively, the Moon signs should be in the 4th and 10th positions from each other.</li>
                                </ul>
                            </div>
                            <p class="fix_desc">If any of these conditions are met, the couple earns seven points for their BhaKuta compatibility.</p>
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
                        <p class="dark-title"><?= $p1_name ?></p>
                        <button class="cst-kndlirpt-btn w-100"><?= $ashtakoot_analysis['ashtakoot_milan']['bhakoota']['p1'] ?></button>
                    </div>
                    <div class="col-md-6 my-3 text-center cst-flt-lft">
                        <p class="dark-title"><?= $p2_name ?></p>
                        <button class="cst-kndlirpt-btn w-100"><?= $ashtakoot_analysis['ashtakoot_milan']['bhakoota']['p2'] ?></button>
                    </div>
                    <div class="col-md-10 my-3 text-center mx-auto">
                        <h3 class="dark-title">
                            <?php 
                            if($ashtakoot_analysis['bhakoot_dosha'] == "true"){
                                echo $messages['bhakut_dosha_present'];
                            }else{
                                echo $messages['bhakut_dosha_not_present'];
                            }
                            ?>
                        </h3>
                        <h3 class="dark-title" style="font-weight: 200;font-size: 16px;line-height: 1.8;margin-top: 30px;">
                        <?php 
                        $point = ($ashtakoot_analysis['ashtakoot_milan']['bhakoota']['points_obtained'] / $ashtakoot_analysis['ashtakoot_milan']['bhakoota']['max_ponits']) * 100;
                        if($point < 50){
                            if($lang_type == "hi"){
                                echo "जोड़ी के बीच एक दृढ़ भावनात्मक जुड़ाव नहीं हो सकता है। भाकूट मिलान में सबसे महत्वपूर्ण माप होता है, इसलिए कम स्कोर प्राप्त करने से शादी के लिए मिलान की योग्यता के चांस बहुत कम हो जाते हैं। भाकूट स्कोर 0 का मतलब है कि भाकूट दोष है। इस तरह के जोड़ी व्यक्तिगत संबंधों में अधिक व्यक्तिवादी होते हैं। वे संघर्षों के बजाय व्यक्तिगत सफलता पर ध्यान केंद्रित करते हैं। वे अपने जीवन के तरीके को अपने साथी के लिए बलिदान करने में कठिनाई महसूस करते हैं, जिससे भावनात्मक समायोजन में दिक्कतें हो सकती हैं। इस दोष में असुरक्षा और विश्वास की कमी गहराई से दिखाई देती है।";
                            }else{
                                echo "The couple may lack emotional attachement with each other. Since bhakoot is one of the most countable scale in the match making intrument, getting a low score makes the chances of qualifying the match for the marriage becomes very slim. The bhakoot score 0 means there is a bhakoot dosha. Such couples are more individualised in the relationshiip. They are focused towards individual rather than collective achievements. They find it hard to sacrifice their way of life for their partner resulting in poor emotional adjustment. Insecurities and lack of trust seen profoundly in this dosha.";
                            }                         
                        }else{
                            if($lang_type == "hi"){
                                echo "जोड़ी के बीच एक महान भावनात्मक जुड़ाव होगा। यह स्कोर वैवाहिक मेल-मिलाप में बहुत महत्वपूर्ण है क्योंकि यह अकेले 7 अंक योगदान करता है। ".$p1_name." अपनी पत्नी के प्रति स्नेही और सहानुभूतिपूर्ण अनुभव करेगा, जबकि ".$p2_name." अपने पति के लिए सभी पोषण और देखभाल प्रदान करेगी। भाकूट बहुत महत्वपूर्ण होता है क्योंकि इससे संघर्ष समाधान के पैटर्न का परीक्षण किया जाता है। हालांकि हर संबंध में छोटी-मोटी तकलीफें होती हैं, लेकिन इतने अच्छे स्कोर के साथ एक बात निश्चित है कि जिन संघर्षों का सामना हो सकता है, वे बस एक मजेदार चुटकुले के साथ हल हो जाएंगे और चीजें कभी भी जटिल नहीं होंगी।";
                            }else{
                                echo "The couple will have a great emotinal connetivity between them. This score is extremely important for matchmaking as it contributes 7 points alone. ".$p1_name." will feel affectionate and empathetic towards his wife where as ".$p2_name." will provide all the nurturing and caring to her husband. Bhakoot becomes very important to examine the pattern of conflict resolution. Althought there are hiccups in every relationship, but with such a good score one thing can be certain that the conflics thay may arise will be resolved just with a light crack of a joke and things would never become complicated.";
                            }
                        }
                        ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>