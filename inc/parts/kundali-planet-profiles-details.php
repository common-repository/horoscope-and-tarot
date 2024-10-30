<div class="topic_page">
    <?php 
    function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
    if(isset($planetary_position['planets'])
    && !empty($planetary_position['planets'])){
        foreach($planetary_position['planets'] as $planets){
            $remove = ["Uranus","Neptune","Pluto","Ascendant"];
            if(in_array($planets['name'],$remove)){
                continue;
            }
            ?>
            <div class="page-title d-flex align-items-center justify-content-center">
                <div class="planet-profile-image">
                    <img src="<?= $planets['image'] ?>" class="w-100 py-2"alt="">
                </div>
                <h3 class="pagewise-title m-0"><?= $messages[$planets['name']] ?></h3>
            </div>
            <div class="divine-row planet_profile">
                <div class="col-md-12">
                    <div class="palent-one">
                        <div class="divine-row align-items-center">
                            <div class="col-md-12">
                                <p class="my-3">
                                    <?php 
                                    if($planets['name'] == "Sun"){
                                        echo $messages['pp_sun'];
                                    }else if($planets['name'] == "Moon"){
                                        echo $messages['pp_moon'];
                                    }else if($planets['name'] == "Mercury"){
                                        echo $messages['pp_mercury'];
                                    }else if($planets['name'] == "Venus"){
                                        echo $messages['pp_venus'];
                                    }else if($planets['name'] == "Mars"){
                                        echo $messages['pp_mars'];
                                    }else if($planets['name'] == "Jupiter"){
                                        echo $messages['pp_jupiter'];
                                    }else if($planets['name'] == "Saturn"){
                                        echo $messages['pp_saturn'];
                                    }else if($planets['name'] == "Uranus"){
                                        echo "NULL";
                                    }else if($planets['name'] == "Neptune"){
                                        echo "NULL";
                                    }else if($planets['name'] == "Pluto"){
                                        echo "NULL";
                                    }else if($planets['name'] == "Ascendant"){
                                        echo "NULL";
                                    }else if($planets['name'] == "Rahu"){
                                        echo $messages['pp_rahu'];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-20">
                        <div class="table-div small mb-20">
                            <h2 class="table-title"><?= $messages[$planets['name']] ?> <?= $messages['in_horo'] ?></h2>
                            <table class="chile-table table table-striped">
                                <tr>
                                    <th><?= $messages['zodiac_sign'] ?></th>
                                    <td><?= $planets['sign'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= $messages['planet_degree'] ?></th>
                                    <td><?= $planets['longitude'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= $messages['nakshatra'] ?></th>
                                    <td><?= $planets['nakshatra'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= $messages['lord_of'] ?></th>
                                    <td><?= $planets['lord_of'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= $messages['is_in'] ?></th>
                                    <td><?= ordinal($planets['house']) ?> house</td>
                                </tr>
                                <tr>
                                    <th><?= $messages['combust_awashtha'] ?></th>
                                    <td><?= $planets['is_combusted'] == "true" ? "Yes":"No" ?>/<?= $planets['awastha'] ?></td>
                                </tr>
                                <tr>
                                    <?php 
                                    if($planets['type'] == "malefic"){
                                        ?><th colspan="2" class="text-center" style="font-size:20px;color:#ee0a0a;"><?= $messages[$planets['name']] ?> is <?= $messages[$planets['type']] ?> in your horoscope</th><?php
                                    }else if($planets['type'] == "benefic"){
                                        ?><th colspan="2" class="text-center" style="font-size:20px;color:#0a623e;"><?= $messages[$planets['name']] ?> is <?= $messages[$planets['type']] ?> in your horoscope</th><?php
                                    }else if($planets['type'] == "neutral"){
                                        ?><th colspan="2" class="text-center" style="font-size:20px;color:#ee6b0a;"><?= $messages[$planets['name']] ?> is <?= $messages[$planets['type']] ?> in your horoscope</th><?php
                                    }
                                    ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php 
                    if(isset($planets['planets_in_house'])){
                        ?>
                        <div class="mt-20 mb-20">
                            <?php 
                            if($lang_type == "hi"){
                                ?><p class="palent-title">आपकी कुंडली में <?= $messages[$planets['name']] ?> <?= ordinal($planets['house']) ?> भाव में है</p><?php
                                
                            }else{
                                ?><p class="palent-title"><?= $messages[$planets['name']] ?> is in <?= ordinal($planets['house']) ?> house in your horoscope</p><?php
                            }
                            ?>
                            <p style="white-space: break-spaces;"><?= $planets['planets_in_house'] ?></p>
                        </div>
                        <?php
                    }
                    ?>
                    <?php 
                    if(isset($planets['planets_in_sign'])){
                        ?>
                        <div class="mt-20 mb-20">
                            <?php 
                            if($lang_type == "hi"){
                                ?><p class="palent-title"><?= $messages[$planets['name']] ?> आपकी कुंडली में <?= $planets['sign'] ?> राशि में है</p><?php
                            }else{
                                ?><p class="palent-title"><?= $messages[$planets['name']] ?> is in <?= $planets['sign'] ?> sign in your horoscope</p><?php
                            }
                            ?>
                            <p style="white-space: break-spaces;"><?= $planets['planets_in_sign'] ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <hr/>
            <?php
        }
    }
    ?>
</div>