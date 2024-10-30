<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['planetary_positions'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="table-div mt-10">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['r'] ?></th>
                <th><?= $messages['sign'] ?></th>
                <th><?= $messages['degrees'] ?></th>
                <th><?= $messages['sign_lord'] ?></th>
                <th><?= $messages['nakshatra'] ?></th>
                <th><?= $messages['nakshatra_lord'] ?></th>
                <th><?= $messages['house'] ?></th>
            </tr>
            
            <?php
            if(isset($planetary_position['planets'])
            && !empty($planetary_position['planets'])){
                foreach($planetary_position['planets'] as $pl_position){
                    $remove = ["Uranus","Neptune","Pluto","Ascendant"];
                    if(in_array($pl_position['name'],$remove)){
                        continue;
                    }
                
                    $dtl = $pl_position['is_retro'] == "true" ? "R" : "--";
                    ?>

                    <tr>
                        <td><?= $messages[$pl_position['name']] ?></td>
                        <td><?= $dtl ?></td>
                        <td><?= $pl_position['sign'] ?></td>
                        <td><?= $pl_position['longitude'] ?></td>
                        <td><?= $pl_position['sub_lord'] ?></td>
                        <td><?= $pl_position['nakshatra'] ?></td>
                        <td><?= $pl_position['nakshatra_lord'] ?></td>
                        <td><?= $pl_position['house'] ?></td>
                    </tr>
                 
                    <?php
                }
            }
            ?>
            
        </table>
    </div>
    <div class="mt-20">
        <div class="planet-kalsarpa-divs">
            <div class="divine-row">

                <?php                
                if(isset($planetary_position['planets'])
                && !empty($planetary_position['planets'])){
                    foreach($planetary_position['planets'] as $pl_position){
                        $remove = ["Uranus","Neptune","Pluto","Ascendant"];
                        if(in_array($pl_position['name'],$remove)){
                            continue;
                        }
                        
                        ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
                            <div class="subclass" style="border-color:#ffab91">
                                <div class="divine-row border-bottom align-items-center">
                                    <div class="col-4 col-lg-4 col-md-4 col-sm-4 text-center">
                                        <img src="<?= $pl_position['image'] ?>" class="w-100 py-2" alt="">
                                    </div>
                                    <div class="col-8 col-lg-8 col-md-8 col-sm-8 text-left py-2">
                                        <p class="value"><?= $messages[$pl_position['name']] ?></p>
                                        <p class="key"><?= $pl_position['sub_lord'] ?></p>
                                        <p class="key mb-2"><?= $pl_position['nakshatra'] ?></p>
                                    </div>
                                </div>

                                <?php
                                if(isset($pl_position['type'])
                                && !empty($pl_position['type'])){
                                    if($pl_position['type'] == "benefic"){
                                        $color = "#0a623e";
                                    }else if($pl_position['type'] == "malefic"){
                                        $color = "#ee0a0a";
                                    }else{
                                        $color = "#ee6b0a";
                                    }
                                    ?>
                                    <p class="status" style="color:<?= $color . ' !important;' ?>"><?= ucfirst($messages[$pl_position['type']]) ?></p>
                                    <?php
                                }else{
                                    ?>
                                    <p class="status" style="color:#000 !important;">--</p>
                                    <?php
                                }

                        ?>
                        </div>
                        </div>
                        <?php
                        
                    }
                }
                ?>
                
            </div>
        </div>
    </div>
</div>