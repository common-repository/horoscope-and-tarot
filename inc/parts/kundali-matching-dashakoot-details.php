
<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['dashakoot'] ?></h3>
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
                            <h3 class="fix_title">दशकूट क्या है?</h3>
                            <p class="fix_desc">"प्राचीन भारत में, महर्षि और संतों ने एक तकनीक 'विवाह मिलान' या 'मैच-मेकिंग' को विकसित किया था ताकि एक लंबे और सुखी शादीशुदा जीवन की सुनिश्चित कर सकें। इस प्रक्रिया में, दोनों पक्षों के जन्म नक्षत्रों के आधार पर जोड़ी की वैवाहिक अनुकूलता या संगतता का मूल्यांकन किया गया। शुरुआत में, उन्होंने 20 कूट की सिफारिश की थी, लेकिन समय के साथ, ध्यान केवल 10 महत्वपूर्ण कूटों पर समेटा गया। भारत के कुछ क्षेत्रों में केवल 8 कूट ध्यान में रखे जाते हैं, और इसलिए हिंदी में 'दस पोरिथम' और तमिल में '10 पोरुथम' के रूप में भी विख्यात है।</p>
                            <div class="px-3">
                                <p class="fix_desc my-3"><b>कुंडली मिलान के लिए ध्यान में रखे जाने वाले 10 पोरुथम हैं:</b></p>
                                <ul>
                                    <li>दिनम: जोड़े की सेहत और संपूर्ण कल्याण का मूल्यांकन।</li>
                                    <li>गणम: साथीयों के बीच स्वभाव और चरित्र संगतता का निर्धारण।</li>
                                    <li>महेंद्रम: जोड़े की दीर्घायु और जीवनकाल की समंवय का मूल्यांकन।</li>
                                    <li>स्त्री दीर्घम: कन्या के सामान्य कल्याण और समृद्धि का मूल्यांकन।</li>
                                    <li>योनि: व्यक्तियों के बीच शारीरिक और यौन संगतता का मूल्यांकन।</li>
                                    <li>राशि: चंद्रमा राशि के आधार पर भावुक और मानसिक संगतता का मूल्यांकन।</li>
                                    <li>राशियाधिपति: जोड़ी के चंद्र राशि के बीच ग्रहों की मित्रता का मूल्यांकन।</li>
                                    <li>वश्य: रिश्ते में शास्त्रीय और नियंत्रण गतिविधियों का मूल्यांकन।</li>
                                    <li>रज्जु: जोड़े की शारीरिक और मानसिक संपूर्ण कल्याण का मूल्यांकन।</li>
                                    <li>वेध: विवाह पर प्रभाव डालने वाले प्राकृतिक दोषों की जांच।</li>
                                </ul>
                            </div>
                            <p class="fix_desc">इन 10 पोरुथम का संगतता के लिए दोनों पक्षों के बीच व्यापक संगतता का मूल्यांकन करने में महत्वपूर्ण योगदान होता है।"</p>
                            <?php
                        }else{
                            ?>
                            <h3 class="fix_title">What is Dashakoot?</h3>
                            <p class="fix_desc">In ancient India, sages and saints devised a method called 'Marriage Matching' or 'Match-making' to ensure a long and happy married life. This process involved assessing the matrimonial adaptability or compatibility between a couple based on the Birth Stars of the boy and the girl. Originally, they recommended 20 kootas for matching, but over time, the focus narrowed down to 10 essential kootas. In some regions of India, only 8 kootas are considered, and hence it is also popularly known as 'Das Poritham' in Hindi or '10 Porutham' in Tamil.</p>
                            <div class="px-3">
                                <p class="fix_desc my-3"><b>The 10 Porutham considered for horoscope matching are as follows:</b></p>
                                <ul>
                                    <li>1. Dinam: Assessing the health and well-being compatibility of the couple.</li>
                                    <li>2. Ganam: Determining the temperament and character compatibility between the partners.</li>
                                    <li>3. Mahendhram: Evaluating the longevity and life span harmony of the couple.</li>
                                    <li>4. Sthree Deergam: Assessing the general well-being and prosperity of the bride.</li>
                                    <li>5. Yoni: Evaluating the physical and sexual compatibility between the individuals.</li>
                                    <li>6. Rasi: Examining the emotional and mental compatibility based on Moon signs.</li>
                                    <li>7. Rasyadhipathi: Assessing the friendship between the Moon signs of the couple.</li>
                                    <li>8. Vasya: Determining the dominance and control dynamics in the relationship.</li>
                                    <li>9. Rajju: Evaluating the physical and mental well-being of the couple.</li>
                                    <li>10. Vedha: Checking for potential afflictions or doshas that may affect the marriage.</li>
                                </ul>
                            </div>
                            <p class="fix_desc">These 10 Porutham play a significant role in determining the overall compatibility between the boy and the girl.</p>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>   
    </div>
    <div class="table-div mt-10">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['attributes'] ?></th>
                <th><?= $p1_name ?></th>
                <th><?= $p2_name ?></th>
                <th class="text-center"><?= $messages['total'] ?></th>
                <th class="text-center"><?= $messages['received'] ?></th>
            </tr>
            <?php 
            if(isset($dashakoot['dashakoot_milan'])
            && !empty($dashakoot['dashakoot_milan'])){
                foreach($dashakoot['dashakoot_milan'] as $key => $dasot){
                    ?>
                    <tr>
                        <td><?= $messages[$key] ?></td>
                        <td><?= !empty($dasot['p1']) ? ucfirst($dasot['p1']) : "" ?></td>
                        <td><?= !empty($dasot['p2']) ? ucfirst($dasot['p2']) : "" ?></td>
                        <td class="text-center"><?= $dasot['points_obtained'] ?></td>
                        <td class="text-center"><?= $dasot['max_ponits'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td><b><?= $messages['total'] ?></b></td>
                <td></td>
                <td></td>
                <td class="text-center"><b><?= $dashakoot['dashakoot_milan_result']['points_obtained'] ?></b></td>
                <td class="text-center"><b><?= $dashakoot['dashakoot_milan_result']['max_ponits'] ?></b></td>
            </tr>
        </table>
    </div>
</div>