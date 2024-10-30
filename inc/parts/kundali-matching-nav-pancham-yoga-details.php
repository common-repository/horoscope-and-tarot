<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['nav_pancham_yoga'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    <div class="table-div mt-10">
        <table class="chile-table child-header table table-striped">
            <tr class="table-header">
                <th><?= $messages['p1_p2'] ?></th>
                <th><?= $messages['sun'] ?></th>
                <th><?= $messages['moon'] ?></th>
                <th><?= $messages['mercury'] ?></th>
                <th><?= $messages['venus'] ?></th>
                <th><?= $messages['mars'] ?></th>
                <th><?= $messages['jupiter'] ?></th>
                <th><?= $messages['saturn'] ?></th>
                <th><?= $messages['uranus'] ?></th>
                <th><?= $messages['neptune'] ?></th>
                <th><?= $messages['pluto'] ?></th>
                <th><?= $messages['rahu'] ?></th>
                <th><?= $messages['ketu'] ?></th>
                <th><?= $messages['ascendant'] ?></th>
            </tr>
            <?php 
            if(isset($pancham_yoga['nav_pancham_yoga'])
            && !empty($pancham_yoga['nav_pancham_yoga'])){
                foreach($pancham_yoga['nav_pancham_yoga'] as $key => $panchamga){
                    if ($lang_type == 'en') {
                    ?>
                    <tr>
                        <td><?= $messages[$key] ?></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Sun']) ?>"><?= $panchamga['Sun'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Moon']) ?>"><?= $panchamga['Moon'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Mercury']) ?>"><?= $panchamga['Mercury'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Venus']) ?>"><?= $panchamga['Venus'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Mars']) ?>"><?= $panchamga['Mars'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Jupiter']) ?>"><?= $panchamga['Jupiter'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Saturn']) ?>"><?= $panchamga['Saturn'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Uranus']) ?>"><?= $panchamga['Uranus'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Neptune']) ?>"><?= $panchamga['Neptune'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Pluto']) ?>"><?= $panchamga['Pluto'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Rahu']) ?>"><?= $panchamga['Rahu'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Ketu']) ?>"><?= $panchamga['Ketu'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['Ascendant']) ?>"><?= $panchamga['Ascendant'] ?></span></td>
                    </tr>
                    <?php
                    } else {
                    ?>
                    <tr>
                        <td><?= $messages[$key] ?></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['रवि']) ?>"><?= $panchamga['रवि'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['चंद्रमा']) ?>"><?= $panchamga['चंद्रमा'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['बुध']) ?>"><?= $panchamga['बुध'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['शुक्र']) ?>"><?= $panchamga['शुक्र'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['मंगल']) ?>"><?= $panchamga['मंगल'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['बृहस्पति']) ?>"><?= $panchamga['बृहस्पति'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['शनि']) ?>"><?= $panchamga['शनि'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['अरुण']) ?>"><?= $panchamga['अरुण'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['नेपच्यून']) ?>"><?= $panchamga['नेपच्यून'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['प्लूटो']) ?>"><?= $panchamga['प्लूटो'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['राहु']) ?>"><?= $panchamga['राहु'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['केतु']) ?>"><?= $panchamga['केतु'] ?></span></td>
                        <td><span class="color_<?= str_replace('/','_',$panchamga['लग्न']) ?>"><?= $panchamga['लग्न'] ?></span></td>
                    </tr>
                    <?php
                    }
                }
            }
            ?>
        </table>
    </div>
</div>