<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['composite_friendship_table'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <h5 class="table-sub-title"><?= $messages['permanent_friendship'] ?></h5>
    <div class="table-div mt-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['sun'] ?></th>
                <th><?= $messages['moon'] ?></th>
                <th><?= $messages['mars'] ?></th>
                <th><?= $messages['mercury'] ?></th>
                <th><?= $messages['jupiter'] ?></th>
                <th><?= $messages['venus'] ?></th>
                <th><?= $messages['saturn'] ?></th>
            </tr>
            
            <?php
            if(isset($composite_friendship['natural_friendship'])
            && !empty($composite_friendship['natural_friendship'])){
                foreach($composite_friendship['natural_friendship'] as $key => $natural_friendship){
                    
                    ?>
                    <tr>
                        <td><?= $messages[$key] ?></td>
                        <td><?= $natural_friendship['Sun'] ?></td>
                        <td><?= $natural_friendship['Moon'] ?></td>
                        <td><?= $natural_friendship['Mars'] ?></td>
                        <td><?= $natural_friendship['Mercury'] ?></td>
                        <td><?= $natural_friendship['Jupiter'] ?></td>
                        <td><?= $natural_friendship['Venus'] ?></td>
                        <td><?= $natural_friendship['Saturn'] ?></td>
                    </tr>
                    <?php
                    
                }
            }
            ?>
            
        </table>
    </div>
    <h5 class="table-sub-title"><?= $messages['temporal_friendship'] ?></h5>
    <div class="table-div mt-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['sun'] ?></th>
                <th><?= $messages['moon'] ?></th>
                <th><?= $messages['mars'] ?></th>
                <th><?= $messages['mercury'] ?></th>
                <th><?= $messages['jupiter'] ?></th>
                <th><?= $messages['venus'] ?></th>
                <th><?= $messages['saturn'] ?></th>
            </tr>
            
            <?php
            if(isset($composite_friendship['temporary_friendship'])
            && !empty($composite_friendship['temporary_friendship'])){
                foreach($composite_friendship['temporary_friendship'] as $key => $temporary_friendship){
                    
                    ?>
                    <tr>
                        <td><?= $messages[$key] ?></td>
                        <td><?= $temporary_friendship['Sun'] ?></td>
                        <td><?= $temporary_friendship['Moon'] ?></td>
                        <td><?= $temporary_friendship['Mars'] ?></td>
                        <td><?= $temporary_friendship['Mercury'] ?></td>
                        <td><?= $temporary_friendship['Jupiter'] ?></td>
                        <td><?= $temporary_friendship['Venus'] ?></td>
                        <td><?= $temporary_friendship['Saturn'] ?></td>
                    </tr>
                    <?php
                    
                }
            }
            ?>
            
        </table>
    </div>
    <h5 class="table-sub-title"><?= $messages['fivefold_friendship'] ?></h5>
    <div class="table-div mt-20">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['planets'] ?></th>
                <th><?= $messages['sun'] ?></th>
                <th><?= $messages['moon'] ?></th>
                <th><?= $messages['mars'] ?></th>
                <th><?= $messages['mercury'] ?></th>
                <th><?= $messages['jupiter'] ?></th>
                <th><?= $messages['venus'] ?></th>
                <th><?= $messages['saturn'] ?></th>
            </tr>
            
            <?php
            if(isset($composite_friendship['five_fold_friendship'])
            && !empty($composite_friendship['five_fold_friendship'])){
                foreach($composite_friendship['five_fold_friendship'] as $key => $five_fold_friendship){
                    
                    ?>
                    <tr>
                        <td><?= $messages[$key] ?></td>
                        <td><?= $five_fold_friendship['Sun'] ?></td>
                        <td><?= $five_fold_friendship['Moon'] ?></td>
                        <td><?= $five_fold_friendship['Mars'] ?></td>
                        <td><?= $five_fold_friendship['Mercury'] ?></td>
                        <td><?= $five_fold_friendship['Jupiter'] ?></td>
                        <td><?= $five_fold_friendship['Venus'] ?></td>
                        <td><?= $five_fold_friendship['Saturn'] ?></td>
                    </tr>
                    <?php
                    
                }
            }
            ?>
            
        </table>
    </div>
</div>