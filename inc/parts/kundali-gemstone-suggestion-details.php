<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['gemstone_suggestions'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <?php 
    if(isset($gemstone_suggestion)
    && !empty($gemstone_suggestion)){
        foreach($gemstone_suggestion as $key => $gemstone){
            if(empty($gemstone)){
                continue;
            }
            ?>
            <div class="table-div small mb-20">
                <h2 class="table-title">
                <?php
                    if($key == "lucky_stone"){
                        echo$messages['lucky_stone'];
                    }else if($key == "life_stone"){
                        echo$messages['life_stone'];
                    }else if($key == "dasha_stone"){
                        echo$messages['dasha_stone'];
                    }
                ?>
                </h2>
                <table class="chile-table table table-striped">
                    <tr class="d-none"><td colspan="2"></td></tr>
                    <tr>
                        <td colspan="2">
                            <div class="divine-row justify-content-center">
                                <?php 
                                    $primary_stone = explode(", ",$gemstone['gemstones']['Primary']);
                                    if(!empty($primary_stone)){
                                        foreach($primary_stone as $stone){
                                           ?>
                                            <div class="col-md-4 mx-auto">
                                                <div class="gem_data">
                                                    <?php 
                                                    $img = "";
                                                    if($stone == "Ruby"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Ruby.png';
                                                    }else if($stone == "Akoya Pearl"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Akoya Pearl.png';
                                                    }else if($stone == "Red Coral"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Red Coral.png';
                                                    }else if($stone == "Emerald"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Emerald.png';
                                                    }else if($stone == "Yellow Sapphire"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Yellow Sapphire.png';
                                                    }else if($stone == "Diamond"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Diamond.png';
                                                    }else if($stone == "Blue Sapphire"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Blue Sapphire.png';
                                                    }else if($stone == "Gomed (Hesonite)"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Gomed (Hesonite).png';
                                                    }else if($stone == "Cat's Eye"){
                                                        $img = DHAT_PLUGIN_URL . 'public/images/kundali-gemstone/Cat\'s Eye.png';
                                                    }
                                                    if(!empty($img)){
                                                        ?>
                                                        <div class="gen_image"><img src="<?= $img ?>"></div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="gen_name"><p class="dark-title"><?= $messages['gem_'.strtolower(preg_replace("/[^a-zA-Z]+/", "", $stone))] ?></p></div>
                                                </div>
                                                
                                            </div>
                                           <?php 
                                        }
                                    }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><?= $messages['substitutes'] ?></th>
                        <td><?= $gemstone['gemstones']['Secondary'] ?></td>
                    </tr>
                    <tr>
                        <th><?= $messages['finger'] ?></th>
                        <td><?= $gemstone['finger_to_wear'] ?></td>
                    </tr>
                    <tr>
                        <th><?= $messages['day'] ?></th>
                        <td><?= $gemstone['day_to_wear'] ?></td>
                    </tr>
                    <tr>
                        <th><?= $messages['time_to_wear'] ?></th>
                        <td><?= $gemstone['time_to_wear']?></td>
                    </tr>
                    <tr>
                        <th><?= $messages['mantra'] ?></th>
                        <td><?= $gemstone['mantra'] ?></td>
                    </tr>
                </table>
            </div>
            <?php
        }
    }
    ?>
</div>