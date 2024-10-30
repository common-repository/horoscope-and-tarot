
<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['ashtakoot'] ?></h3>
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
                        <h3 class="fix_title">अष्टकूट क्या है?</h3>
                        <p class="fix_desc">"उत्तर भारत में, कुंडली मिलान का एक पारंपरिक और सीधा तरीका है ""अष्टकूट मिलान,"" जो गुण मिलान का हिस्सा है। गुण मिलान में दो व्यक्तियों की कुंडलियों को विवाह के लिए उनके संगतता की मूल्यांकन के लिए मिलाया जाता है। इसमें आठ गुणों को मूल्यांकन किया जाता है, जिन्हें ""गुण"" कहा जाता है, और प्रत्येक गुण को उनके महत्व के आधार पर एक अंकीय मूल्य दिया जाता है, जो विभिन्न पहलुओं की विवाहिता के संबंध में उनकी संगतता को निर्धारित करने में मदद करता है।</p>
                        <div class="px-3">
                            <p class="fix_desc my-3"><b>अष्टकूट मिलान में निम्नलिखित आठ गुणों को विचार किया जाता है:</b></p>
                            <ul>
                                <li>वर्ण: जोड़े के बीच आध्यात्मिक संगतता और समझ का मूल्यांकन।</li>
                                <li>वश्य: रिश्ते में शास्त्रीय और नियंत्रण गतिविधियों का मूल्यांकन।</li>
                                <li>तारा: जोड़े की सेहत और संपूर्ण कल्याण का मूल्यांकन और उनके प्रभाव का विचार।</li>
                                <li>योनि: साथीयों के बीच शारीरिक और यौन संगतता का मूल्यांकन।</li>
                                <li>ग्रह मैत्री: व्यक्तियों के चंद्र राशि के बीच ग्रहों की मैत्री का मूल्यांकन।</li>
                                <li>गण: जोड़े की स्वभाव और व्यवहार संगतता का निर्धारण।</li>
                                <li>भकूट: दोनों के बीच भावुकता और मेल का मूल्यांकन।</li>
                                <li>नाडी: जन्मजात संगतता और स्वास्थ्य सम्बन्धी समस्याओं का मूल्यांकन।</li>
                            </ul>
                        </div>
                        <p class="fix_desc">प्रत्येक गुण जोड़े के संबंध में व्यापक संगतता निर्धारित करने में महत्वपूर्ण है। सभी आठ गुणों के योग्यता के अंकों का योग होता है, जिससे जोड़े की संगतता का स्तर और एक सफल और समृद्ध विवाह की संभावना का पता चलता है।"</p>
                        <?php
                    }else{
                        ?>
                        <h3 class="fix_title">What is ashtakoot?</h3>
                        <p class="fix_desc">In North India, there is a traditional and straightforward method of Kundli Milan called "Ashtakoota Milan," which is part of Guna Milan. Guna Milan involves matching the horoscopes of two individuals to assess their compatibility for marriage. It focuses on evaluating eight qualities or aspects, known as "Gunas," each assigned a numeric value based on their importance in determining various aspects of a couple's compatibility.</p>
                        <div class="px-3">
                            <p class="fix_desc my-3"><b>The eight Gunas considered in Ashtakoota Milan are as follows:</b></p>
                            <ul>
                                <li>1. Varna: Assessing the spiritual compatibility and understanding between the couple.</li>
                                <li>2. Vashya: Examining the dominance and control dynamics in the relationship.</li>
                                <li>3. Tara: Analyzing the health and well-being of the couple and their impact on each other.</li>
                                <li>4. Yoni: Evaluating the physical and sexual compatibility between the partners.</li>
                                <li>5. Graha Maitri: Assessing the planetary friendship between the Moon signs of the individuals.</li>
                                <li>6. Gana: Determining the temperament and behavior compatibility of the couple.</li>
                                <li>7. Bhakoota: Evaluating the emotional compatibility and harmony between the two.</li>
                                <li>8. Nadi: Assessing the genetic compatibility and the possibility of health issues.</li>
                            </ul>
                        </div>
                        <p class="fix_desc">Each Guna is crucial in determining the overall compatibility between the couple. The cumulative score of all eight Gunas indicates the level of compatibility and the potential for a successful and harmonious marriage.</p>
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
                <th><?= $messages['description'] ?></th>
                <th><?= $p1_name ?></th>
                <th><?= $p2_name ?></th>
                <th class="text-center"><?= $messages['total'] ?></th>
                <th class="text-center"><?= $messages['received'] ?></th>
            </tr>
            <?php 
            if(isset($ashtakoot['ashtakoot_milan'])
            && !empty($ashtakoot['ashtakoot_milan'])){
                foreach($ashtakoot['ashtakoot_milan'] as $key => $asht){
                    ?>
                    <tr>
                        <td><?= $messages[$key] ?></td>
                        <td><?= $asht['area_of_life'] ?></td>
                        <td><?= !empty($asht['p1']) ? ucfirst($asht['p1']) : "" ?></td>
                        <td><?= !empty($asht['p2']) ? ucfirst($asht['p2']) : "" ?></td>
                        <td class="text-center"><?= $asht['points_obtained'] ?></td>
                        <td class="text-center"><?= $asht['max_ponits'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td><b><?= $messages['total'] ?></b></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center"><b><?= $ashtakoot['ashtakoot_milan_result']['points_obtained'] ?></b></td>
                <td class="text-center"><b><?= $ashtakoot['ashtakoot_milan_result']['max_ponits'] ?></b></td>
            </tr>
        </table>
    </div>
</div>