<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['nadi_dosha'] ?></h3>
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
                            <h3 class="fix_title">नाडी क्या है?</h3>
                            <p class="fix_desc">"आयुर्वेद के अनुसार, मानव शरीर तीन तत्वों से मिलकर बना होता है, जिन्हें वात, पित्त, और कफ जाना जाता है। यदि किसी व्यक्ति में वात तत्व का अधिक होता है, तो उन्हें वात को बढ़ाने वाले आहार का सेवन नहीं करना चाहिए। इसकी अनदेखी करने से वात संबंधी स्वास्थ्य समस्याएं हो सकती हैं, जैसे कि उच्च यूरिक एसिड और गठिया। इसी तरह, ज्योतिष में भी तीन नाडी श्रेणियां होती हैं: आदि, मध्य, और अंत्य।</p>
                            <p class="fix_desc">जब विवाह मिलान की बात आती है, तो अपने साथी के साथ एक ही नाडी होना अशुभ माना जाता है। सलाह दी जाती है कि अगर दोनों व्यक्तियों की एक ही नाडी है तो विवाह न करें। नाडी दोष को नजरअंदाज करके एक ही नाडी वाले साथी से विवाह करने से स्वास्थ्य संबंधी समस्याएं और साथीयों के बीच आकर्षण की कमी हो सकती है। इस तरह के जोड़े में प्रेम और गहरा प्यार विकसित करना चुनौतीपूर्ण हो सकता है।</p>
                            <p class="fix_desc">सारांश में, ठीक व्यवस्था करने के लिए आयुर्वेद शरीर के तत्वों को संतुलित करने की सलाह देता है, उसी तरह ज्योतिष भी नाडी संगतता का ध्यान रखता है ताकि संगत और पूर्णता से भरा रिश्ता बना सके। भविष्य की संभावित स्वास्थ्य और भावनात्मक चुनौतियों से बचने के लिए एक अलग नाडी वाले साथी का चयन करना सलाह दी जाती है।</p>
                        <?php
                    }else{
                        ?>
                            <h3 class="fix_title">What is nadi?</h3>
                            <p class="fix_desc">According to Ayurveda, the human body comprises three elements known as Vaat, Pitta, and Kapha. If an individual has an excess of the Vaat element, they should avoid consuming foods that aggravate Vaat. Failure to do so may lead to health problems related to Vaat, such as High Uric Acid and Gout. Similarly, in astrology, there are three Nadi categories: Aadi, Madhya, and Antya.</p>
                            <p class="fix_desc">When it comes to matchmaking, having the same Nadi as your partner is considered unfavorable. It is advised not to marry if both individuals share the same Nadi. Ignoring the Nadi Dosha and marrying someone with the same Nadi may lead to health-related issues and a lack of attraction between partners. Affection and deep love may be challenging to develop in such a union.</p>
                            <p class="fix_desc">In summary, just as Ayurveda advises balancing the body's elements for overall well-being, astrology considers Nadi compatibility for harmonious and fulfilling relationships. Choosing a partner with a different Nadi is recommended to avoid potential health and emotional challenges in the future. </p>
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
                        <button class="cst-kndlirpt-btn w-100"><?= $ashtakoot_analysis['ashtakoot_milan']['nadi']['p1'] ?></button>
                    </div>
                    <div class="col-md-6 my-3 text-center cst-flt-lft">
                        <p class="dark-title"><?= $p2_name ?></p>
                        <button class="cst-kndlirpt-btn w-100"><?= $ashtakoot_analysis['ashtakoot_milan']['nadi']['p2'] ?></button>
                    </div>
                    <div class="col-md-12 my-3 text-center">
                        <h3 class="dark-title">
                            <?php 
                            if($ashtakoot_analysis['nadi_dosha'] == "true"){
                                echo $messages['nadi_dosha_pesent'];
                            }else{
                                echo $messages['nadi_dosha_not_pesent'];
                            }
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>