
<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['ashtakoot_analysis'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    <div class="row">
    <?php 
    if(isset($ashtakoot_analysis['ashtakoot_milan'])
    && !empty($ashtakoot_analysis['ashtakoot_milan'])){
        foreach($ashtakoot_analysis['ashtakoot_milan'] as $key => $asht){
            ?>
            <div class="col-md-6 cst-flt-lft">
                <div class="ana_section">
                    <div class="row align-items-center">
                        <?php 
                        $point = ($asht['points_obtained'] / $asht['max_ponits']) * 100;
                        ?>
                        <div class="col-4 text-center">
                            <div class="ana_image">
                                <?php 
                                if($asht['points_obtained'] == 0){
                                    ?>
                                        <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsdown.png">
                                    <?php
                                }else{
                                    if($point < 50){
                                        ?>
                                            <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsdown.png">
                                        <?php
                                    }else{
                                        ?>
                                            <img src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/thumbsup.png">
                                        <?php
                                    }
                                }
                                ?>
                                
                            </div>
                        </div>
                        <div class="col-8">
                            <p class="ana_text"><?= $asht['area_of_life'] ?></p>
                            <p class="ana_text"><?= $messages[$key] ?> - <?= $asht['points_obtained'] ?>/<?= $asht['max_ponits'] ?></p>
                        </div>
                        <?php 
                        if($point < 50){
                            if($key == "varna"){
                                ?>
                                    <div class="col-md-12 ana_desc">
                                        <?php 
                                        if($lang_type == "hi"){
                                            echo "जोड़ी के बीच खराब समायोजन होगा। जोड़ी के कार्यों में असंगत और अनियमित हो सकते हैं। वे अपने कर्मिक लक्ष्यों के पूर्ण होने के मार्ग में एक-दूसरे के खिलाफ खड़े हो सकते हैं।";
                                        }else{
                                            echo "There will be poor adjustment within the couple. The actions of the couple might be incongruent and erratic. They may stand against each other in the way of fulfilment of their karmic goals.";
                                        }
                                        ?>
                                    </div>
                                <?php
                            }else if($key == "tara"){
                                ?><div class="col-md-12 ana_desc">
                                    <?php 
                                    if($lang_type == "hi"){
                                        echo "इस श्रेणी में मिलान खराब है क्योंकि तारा एक-दूसरे का समर्थन नहीं कर रहे हैं। इस बात का महत्व है कि जोड़ी को भाग्य और सौभाग्य की कमी होगी। उन्हें आर्थिक, सामाजिक और शारीरिक संपन्नता में चुनौतियां होंगी जीवनसंगी संबंध में।";
                                    }else{
                                        echo " The match is poor in this category as the tara are not supporting each other. The relevance of this point is that the couple will be devoid of luck and fortune. They will have challenges in financial, social and physical well being in a conjugal relationship.";
                                    }
                                    ?>
                                </div><?php
                            }else if($key == "gana"){
                                ?><div class="col-md-12 ana_desc">
                                    <?php 
                                    if($lang_type == "hi"){
                                        echo $p1_name." ".$asht['p1']." गण से है और ".$p2_name." ".$asht['p2']." गण से है। यह एक वैरी जोड़ी है जो एक-दूसरे के साथ संगति का स्लिम चांस है। जोड़ी के बीच झगड़े और संघर्ष हो सकते हैं क्योंकि वे अपनी प्रतिभा के मामूले पूरे विपरीत हैं। यह शादी भविष्य में टूटने का एक अच्छा मौका है, जिससे दोनों के लिए दिल दुखाने वाले अनुभव हो सकते हैं।";
                                    }else{
                                        echo $p1_name." is ".$asht['p1']." and ".$p2_name." is ".$asht['p2']." gana. This is an inimical pairing which stands a slim chance of getting alog with each other. There may be fights and struggles between the couple as they are poles apart in terms of their personna. This marriage may have a fair chance of falling apart in future leading to heartbreaking experiences for both.";
                                    }
                                    ?>
                                </div><?php
                            }else if($key == "bhakoota"){
                                ?><div class="col-md-12 ana_desc">
                                    <?php 
                                    if($lang_type == "hi"){
                                        echo "जोड़ी के बीच एक दृढ़ भावनात्मक जुड़ाव नहीं हो सकता है। भाकूट मिलान में सबसे महत्वपूर्ण माप होता है, इसलिए कम स्कोर प्राप्त करने से शादी के लिए मिलान की योग्यता के चांस बहुत कम हो जाते हैं। भाकूट स्कोर 0 का मतलब है कि भाकूट दोष है। इस तरह के जोड़ी व्यक्तिगत संबंधों में अधिक व्यक्तिवादी होते हैं। वे संघर्षों के बजाय व्यक्तिगत सफलता पर ध्यान केंद्रित करते हैं। वे अपने जीवन के तरीके को अपने साथी के लिए बलिदान करने में कठिनाई महसूस करते हैं, जिससे भावनात्मक समायोजन में दिक्कतें हो सकती हैं। इस दोष में असुरक्षा और विश्वास की कमी गहराई से दिखाई देती है।";
                                    }else{
                                        echo "The couple may lack emotional attachement with each other. Since bhakoot is one of the most countable scale in the match making intrument, getting a low score makes the chances of qualifying the match for the marriage becomes very slim. The bhakoot score 0 means there is a bhakoot dosha. Such couples are more individualised in the relationshiip. They are focused towards individual rather than collective achievements. They find it hard to sacrifice their way of life for their partner resulting in poor emotional adjustment. Insecurities and lack of trust seen profoundly in this dosha.";
                                    }
                                    ?>
                                </div><?php
                            }else if($key == "nadi"){
                                ?><div class="col-md-12 ana_desc">
                                    <?php 
                                    if($lang_type == "hi"){
                                        echo "नाडी स्कोर ".$asht['points_obtained']." है। इसका मतलब है कि आपके पास समान नाडियां हैं। इसे नाडी दोष कहा जाता है और यह कुंडली मिलान में सबसे महत्वपूर्ण विचार है। नाडी दोष से बच्चों को पाने में समस्याएं या फिर कमजोर या अस्वस्थ बच्चे होने की समस्या हो सकती है। बच्चे भगवान की सबसे सुंदर उपहार हैं, जिन्हें आप अपने साथी के साथ मिलकर प्राप्त करते हैं। नाडी दोष वाले मिलान में इस उपहार से वंचित होने की संभावना हो सकती है।";
                                    }else{
                                        echo "The nadi score is ".$asht['points_obtained'].". This means you have same nadis. This is called as Nadi dosha and it is the most important consideration in matching horoscopes. Nadi dosha results in problems with having children or even having weak or unhealthy children. Children are the most beautiful gift of god which you achieve together with your partner. Having nadi dosha in the match may result in being deprived of this gift.";
                                    }
                                    ?>
                                </div><?php
                            }                            
                        }else{
                            if($key == "varna"){
                                ?>
                                    <div class="col-md-12 ana_desc">
                                        <?php 
                                        if($lang_type == "hi"){
                                            echo "जोड़ी के बीच एक अनुपम संबंध होगा। ".$p1_name." परिवार के लिए प्रदान करने के प्रति समर्पित रहेगा। ".$p2_name." भी परिवार को प्यार और देखभाल से पोषण करेगी।";
                                        }else{
                                            echo "There shall be a complimenting relationship between the couple. ".$p1_name." shall be dedicated towards providing for the family. ".$p2_name." will also nurture the family with love and care.";
                                        }
                                        ?>
                                    </div>
                                <?php
                            }else if($key == "tara"){
                                ?><div class="col-md-12 ana_desc">
                                <?php 
                                if($lang_type == "hi"){
                                    echo "तारा कूट में एक अच्छा मिलान प्राप्त होता है। इसका मतलब है कि शादी के बंधन में प्रेमी जोड़ी का समृद्धि और विकास होगा। वे एक-दूसरे का साथ सब परिस्थितियों में देंगे।";
                                }else{
                                    echo "There is a good match obtained in Tara Koota. This means that there shall be prosperity and growth of the couple after entering the bond of marriage. They will support each other through thik and thin.";
                                }
                                ?></div><?php
                            }else if($key == "gana"){
                                ?><div class="col-md-12 ana_desc">
                                    <?php 
                                    if($lang_type == "hi"){
                                        echo "".$p1_name." ".$asht['p1']." गण से है और ".$p2_name." ".$asht['p2']." गण से आती है। यह जोड़ी के बीच एक आदर्श मिलान है क्योंकि _____ और _____ एक-दूसरे को पूरकर्ता हैं। यह इसका संकेत है कि दोनों व्यक्तियों के पास शादी में मित्रभावपूर्ण व्यवहार होगा। वे आपसी रूप से आत्मिक लक्ष्यों को प्राप्त करने के लिए एक-दूसरे का साथ देंगे।";
                                    }else{
                                        echo "".$p1_name." is ".$asht['p1']." Gana and the ".$p2_name." comes from ".$asht['p2']." gana. This is an ideal match between the couple as ______ and ______ are complimenting to each other. This suggests that both the individuals will have a friendly disposition in marriage. They will uplift each other to achieve spiritual goals in life.";
                                    }
                                    ?>
                                </div><?php
                            }else if($key == "bhakoota"){
                                ?><div class="col-md-12 ana_desc">
                                    <?php 
                                    if($lang_type == "hi"){
                                        echo "जोड़ी के बीच एक महान भावनात्मक जुड़ाव होगा। यह स्कोर वैवाहिक मेल-मिलाप में बहुत महत्वपूर्ण है क्योंकि यह अकेले 7 अंक योगदान करता है। ".$p1_name." अपनी पत्नी के प्रति स्नेही और सहानुभूतिपूर्ण अनुभव करेगा, जबकि ".$p2_name." अपने पति के लिए सभी पोषण और देखभाल प्रदान करेगी। भाकूट बहुत महत्वपूर्ण होता है क्योंकि इससे संघर्ष समाधान के पैटर्न का परीक्षण किया जाता है। हालांकि हर संबंध में छोटी-मोटी तकलीफें होती हैं, लेकिन इतने अच्छे स्कोर के साथ एक बात निश्चित है कि जिन संघर्षों का सामना हो सकता है, वे बस एक मजेदार चुटकुले के साथ हल हो जाएंगे और चीजें कभी भी जटिल नहीं होंगी।";
                                    }else{
                                        echo "The couple will have a great emotinal connetivity between them. This score is extremely important for matchmaking as it contributes 7 points alone. ".$p1_name." will feel affectionate and empathetic towards his wife where as ".$p2_name." will provide all the nurturing and caring to her husband. Bhakoot becomes very important to examine the pattern of conflict resolution. Althought there are hiccups in every relationship, but with such a good score one thing can be certain that the conflics thay may arise will be resolved just with a light crack of a joke and things would never become complicated.";
                                    }
                                    ?>
                                </div><?php
                            }else if($key == "nadi"){
                                ?><div class="col-md-12 ana_desc">
                                    <?php 
                                    if($lang_type == "hi"){
                                        echo "नाडी एक पुरानी तकनीक है जो जोड़ी के बच्चों के उत्पन्न होने की संभावनाएं मूल्यांकन करने के लिए उपयोगी होती है। जब नाडी स्कोर पूरा होता है, तो इसका मतलब होता है कि व्यक्ति के पास विशिष्ट पारिवारिक वंशज हैं, जिससे साफ होता है कि उनके बायोलॉजिकली बच्चों के उत्पन्न होने के लिए वे संगत हैं। बच्चों को अपने पूर्वजों को श्रद्धांजलि देना माना जाता है; पितृ ऋण। बच्चे माता-पिता के जीवन में बहुत सकारात्मकता लाते हैं, इसलिए यह मिलान अत्यंत महत्वपूर्ण होता है। आपका स्कोर उच्च है, जिससे यह सुझाव देता है कि आपको विवाह के बाद स्वस्थ बच्चे होने की उच्च संभावना है।";
                                    }else{
                                        echo "Nadi is an old age technique for assessing the prospects of procreation in a couple. When nadi score is full it means that the individual have distinct familial lineage verifying the very fact that boilogically they are compatible to reproduce children. Giving birth to children is considered as paying tribute to one's ancestors; pitra rina. Children bring a lot of positivity in the life of parents, hence this match is extremely important. Your score is high which suggests that you have high possibility of having healthy children out of your marriage.";
                                    }
                                    ?>
                                </div><?php
                            }
                        }
                        if($key == "vashya"){
                            ?>
                            <div class="col-md-12 ana_desc">
                                <?php 
                                if($asht['points_obtained'] == 2){
                                    if($lang_type == "hi"){
                                        echo "".$p1_name." सम्मानीय वस्य है, जिसका मतलब है कि उसके रिश्ते में बराबरी के समान गुण हैं। ".$p2_name." भी लड़के के समान वस्य में शामिल है। शादी के बाद ".$p1_name." और ".$p2_name." आपसी समझदारी से संबंध बनाएंगे क्योंकि उनका एक ही शक्ति संतुलन है। इनमें से कोई भी दूसरे को वश में करने या नियंत्रित करने का प्रयास नहीं करेगा। यह संबंध का सर्वश्रेष्ठ रूप है।";
                                    }else{
                                        echo "".$p1_name." is vasya which means he has Evolutionary Character like character in a relationship. ".$p2_name." also belongs to the same vasya as ".$p1_name.". ".$p1_name." shall get along well with ".$p2_name." after marriage as they both have same power equation. None of them will try to dominate or control the other. This is the best form of relationship.";
                                    }
                                }else if($asht['points_obtained'] > 0 || $asht['points_obtained'] < 2){
                                    if($lang_type == "hi"){
                                        echo "जोड़ी के बीच कुछ कठिन पल होंगे क्योंकि ".$p1_name." और ".$p2_name." के पास अलग-अलग वंश की रेखा है। यद्यपि जोड़ी के बीच संतुलित शक्ति वितरण होगा, फिर भी कुछ समयों में समायोजन समस्याएं हो सकती हैं।";
                                    }else{
                                        echo "There shall be some stiif moments in the relationship as ".$p1_name." and ".$p2_name." have different line of heritage. Although there shall be a balanced power distribution between the couple, there could possibly be some adjustment issues at some times.";
                                    }
                                }else if($asht['points_obtained'] == 0){
                                    if($lang_type == "hi"){
                                        echo "यह एक खराब मिलान है क्योंकि जोड़ी के बीच अत्यंत शक्ति की लड़ाई होगी। एक हमेशा दूसरे को वश में करने की कोशिश करेगा, जिससे झगड़े, झड़प और अनुकूलन की समस्या होगी।";
                                    }else{
                                        echo "This is a poor match as there shall be extreme power struggles between the couple. One will always try to dominate the other leading to arguments, scuffle and misadjustment.";
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }else if($key == "yoni"){
                            ?><div class="col-md-12 ana_desc">
                                <?php 
                                if($asht['points_obtained'] == 4){
                                    if($lang_type == "hi"){
                                        echo "".$p1_name." ".$asht['p1']." योनि से है और ".$p2_name." ".$asht['p2']." योनि से है। यह श्रेणी हमारी प्राकृतिक सेक्सुअल ऊर्जा की परिभाषा करती है और इसे पशु जाति के साथ समानता के रूप में देखती है। क्योंकि ".$p1_name." ".$asht['p1']." है और ".$p2_name." ".$asht['p2']." है, इन प्राणियों के संबंधी एक-दूसरे के सेक्सुअल चरित्र को पूरकर्ता हैं। वे शादी के रिश्ते में एक-दूसरे की सेक्सुअल आवश्यकताओं को पूरा करने में सक्षम होंगे।";
                                    }else{
                                        echo "".$p1_name." belongs to ".$asht['p1']." yoni and ".$p2_name." is of ".$asht['p2']." yoni. This category defines our innate sexual enery and its resemblance with the animal species. Since ".$p1_name." is ".$asht['p1']." and ".$p2_name." is ".$asht['p2'].", these species are coomplimenting each other's sexual character. They will be able to fulfill each other's sexual needs in the marriage.";
                                    }
                                }else if($asht['points_obtained'] == 2 || $asht['points_obtained'] == 3){
                                    if($lang_type == "hi"){
                                        echo "जोड़ी के बीच सेक्सुअल संगतता मध्यम होगी। प्राप्त किए गए अंक ".$asht['points_obtained']." है जो काफी मध्यम स्कोर है। इसका मतलब है कि जोड़ी प्रारंभिक चरण में एक-दूसरे के प्रति आकर्षित रहेगी, हालांकि यह आकर्षण समय के साथ कम हो सकता है। दोनों के बीच गहरी आंतरिक संबंध नहीं हो सकता है।";
                                    }else{
                                        echo "The sexual compatibility between the couple shall remain average. The points obtained are ".$asht['points_obtained']." which is quite a medium score. This means that the couple will remain attracted to each other at the initial stage, however this attraction may get diminished with time. There may be not be a deep intimate connection between the two.";
                                    }
                                }else if($asht['points_obtained'] == 0 || $asht['points_obtained'] == 1){
                                    if($lang_type == "hi"){
                                        echo "इस स्केल पर स्कोर बहुत कम है। ".$p1_name." ".$asht['p1']." योनि से है जबकि ".$p2_name." ".$asht['p2']." योनि से संबंधित है। यह एक स्पष्ट मिलान नहीं है जो सुझाता है कि इन व्यक्तियों की अलग-अलग सेक्सुअल प्रवृत्तियां हो सकती हैं। वे एक-दूसरे के सेक्सुअल चरित्र के साथ प्रतिस्थापन करने में असमर्थ हो सकते हैं।";
                                    }else{
                                        echo "The score is very low on this scale. ".$p1_name." belongs to ".$asht['p1']." yoni while ".$p2_name." is attributed to ".$asht['p2']." yoni. This is a clear mismatch suggesting that the these individuals have different sexual tendencies. They may have a poor adjustment with each other's sexual character.";
                                    }
                                }
                                ?>
                            </div><?php
                        }else if($key == "graha_maitri"){
                            ?><div class="col-md-12 ana_desc">
                                <?php 
                                if($asht['points_obtained'] == 4 || $asht['points_obtained'] == 5){
                                    if($lang_type == "hi"){
                                        echo "यह जोड़ी एक अच्छा मिलान है और स्कोर ".$asht['points_obtained']." से है। जोड़ी के बीच गहरा प्यार और सम्मान होगा। वे वास्तव में आत्मीय हैं। प्रेम शादी का आधार है और इस स्कोर से आता है कि उनका प्यार उनके वैवाहिक बंधन में समाप्त होने तक तीव्र रहेगा। वे एक-दूसरे पर अविश्वसनीय विश्वास रखेंगे।";
                                    }else{
                                        echo "The match between the pair is good with the score ".$asht['points_obtained'].". The couple will have deep love and care for each other. They are truly the soulmates. Love is the foundation of marriage and what comes by this score is that their love will remain intense throughout their marital bond. They will have an unbeatable confidence in each other.";
                                    }
                                }else if($asht['points_obtained'] == 3){
                                    if($lang_type == "hi"){
                                        echo "इस स्केल पर जोड़ी ने ".$asht['points_obtained']." स्कोर प्राप्त किया है। हालांकि, यह एक खुशी के योग्य स्कोर नहीं है, लेकिन आशावाद इस मिलान में पाया जा सकता है। वे एक-दूसरे को समझने और भावनात्मक बंधन स्थापित करने के लिए कुछ समय ले सकते हैं। समय बताएगा कि वे दोनों के लिए चीजें कैसे बदलती हैं। उनके यात्रा में कोई टूटने का संदेह नहीं है।";
                                    }else{
                                        echo "The pair have scored ".$asht['points_obtained']." on this scale. However this is not a cherishable score but optimism is something that can be found in this match. They may take some time to understand each other and establish a emotional bonding. Time will suggest how things turn up for them. There are no breakdowns in their journey is for sure.";
                                    }
                                }else if($asht['points_obtained'] == 0 || $asht['points_obtained'] == 1 || $asht['points_obtained'] == 2){
                                    if($lang_type == "hi"){
                                        echo "ग्रह मैत्री के मामले में मिलान आशावादपूर्ण नहीं दिखता है। जैसे नाम से स्पष्ट है, जोड़ी के बीच विवाह के सुंदर सफर को आरंभ करने के लिए एक दूसरे के साथ मित्रता होनी चाहिए, लेकिन प्राप्त स्कोरों के अनुसार विवाद और टकराव के चांस दिखते हैं। इस स्केल पर विवाह के लिए यह मिलान पर्याप्त दिखता नहीं है।";
                                    }else{
                                        echo "The match doesn't look promising on the grounds of grah maitri. As the name suggests there has to be a frendship between the couple to embark the beautiful journey of marriage but by the scores obtained there seems to be chances of discordance and conflicts. This match doesn't look eligible enough for a marriage on this scale.";
                                    }
                                }
                                ?>
                            </div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
    </div>
</div>