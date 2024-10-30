<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['sadhesati_analysis'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="divine-row justify-content-center">
        <div class="col-xl-12">
            <div class="fixed_with_image">
                <figure class="fx-img">
                    <img src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/sadhesati.png' ?>">
                </figure>
                <div>
                    <?php 
                    if($lang_type == "hi"){
                        ?>
                        <p class="fx-h3">सढ़ेसाती दोष क्या है?</p>
                        <p class="fix_desc">सढ़ेसाती एक समय अवधि है जिसमें शनि तीन राशियों के माध्यम से चलता है: चंद्र राशि, उससे पहली राशि और उसके बाद वाली राशि। यह अवधि जब शुरू होती है, जब शनि जन्म राशि से बारहवीं राशि में आता है और खत्म होती है, जब शनि जन्म राशि से दूसरी राशि को छोड़ देता है। शनि लगभग दो और आधे वर्ष में एक राशि के गोचर करता है और इसीलिए तीन राशियों के गोचर के लिए सात और आधे वर्ष की अवधि लगती है, इसीलिए इसे सढ़ेसाती के रूप में जाना जाता है। इस दोष के आने पर व्यक्ति को तीन बार इसका प्रभाव महसूस होता है - पहली बार बचपन में, दूसरी बार युवावस्था में और तीसरी बार बुढ़ापे में। पहली सढ़ेसाती में शिक्षा और माता-पिता पर प्रभाव पड़ता है, दूसरी सढ़ेसाती में पेशेवर, वित्त और परिवार पर प्रभाव पड़ता है और आखिरी सढ़ेसाती में स्वास्थ्य पर सबसे ज्यादा प्रभाव पड़ता है।</p>
                        <?php
                    }else{
                        ?>
                        <p class="fx-h3">What is Sadhesati dosha?</p>
                        <p class="fix_desc">Sadhe Sati refers to the seven-and-a-half year period in which Saturn
                            moves through three signs, the moon sign, one before the moon and
                            the one after it. Sadhe Sati starts when Saturn (Shani) enters the 12th
                            sign from the birth Moon sign and ends when Saturn leaves 2nd sign
                            from the birth Moon sign. Since Saturn approximately takes around
                            two and half years to transit a sign which is called Shani's dhaiya it
                            takes around seven and half year to transit three signs and that is why
                            it is known as Sadhe Sati. Generally Sade-Sati comes thrice in a
                            horoscope in the life time - first in childhood, second in youth & third in old-age. First Sade-Sati has effect on
                            education & parents. Second Sade-Sati has effect on profession, finance & family. The last one affects health
                            more than anything else.</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-6 mx-auto">
            <p class="dark-title"><?= $messages['sade_table_title'] ?></p>
            <div class="table-div mb-20">
                <table class="table chile-table table-striped mb-0">
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['sadhesati'] ?></th>
                        <td style="vertical-align: top;"><?= $sadhesati_analysis['sadhesati']['result'] == "true" ? "YES" : "NO" ?></td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['consideration_date'] ?></th>
                        <td style="vertical-align: top;"><?= date_format(date_create($sadhesati_analysis['sadhesati']['consideration_date']),"d-m-Y") ?></td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['moon_sign'] ?></th>
                        <td style="vertical-align: top;"><?= $sadhesati_analysis['sadhesati']['saturn_sign'] ?></td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;"><?= $messages['saturn_retrograde'] ?></th>
                        <td style="vertical-align: top;"><?= $sadhesati_analysis['sadhesati']['saturn_retrograde'] == "true" ? "YES" : "NO" ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php 
        if(!empty($sadhesati_analysis['remedies'])){
            ?>
            <div class="col-xl-10">
                <div class="table-div mb-20">
                    <table class="chile-table child-header table table-striped">
                        <tr class="table-header">
                            <th colspan="2"><?= $messages['remedies_sadhesati'] ?></th>
                        </tr>
                        <?php 
                        foreach($sadhesati_analysis['remedies'] as $rkey => $remedies){
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