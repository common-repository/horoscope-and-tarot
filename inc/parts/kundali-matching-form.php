<div class="divine-row dapi-kmrpt">
    <div class="divine_auth_domain_response" id="kundali-matching-auth" style="display:none;">
        <p style="color: red !important;text-align:center !important;"></p>
    </div>
    <div class="table-div cst-tsm mb-20" id="kdlmfrm" style="display:none;">
        <h2 class="table-title cstmb10">Get Your Kundali Matching Report</h2>
        <table class="chile-table table cstbl">
            <tr>
                <th style="text-align: center !important;" colspan="2"><label class="cstthmlbl"> ------- &nbsp; Your Details &nbsp; ------- </label></th>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>First Name <span class="dapi-tdanger">*</span></label></th>
                <td class="">
                    <input type="text" id="kmfname1" name="kmfname1" placeholder="First Name" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmfname1_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Last Name <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="text" id="kmlname1" name="kmlname1" placeholder="Last Name" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmlname1_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Gender <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <label for="g_male"><input type="radio" name="kmgender1" value="male" id="g_male" checked> Male</label> &nbsp;
                    <label for="g_female"><input type="radio" name="kmgender1" value="female" id="g_female"> Female</label>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Date of Birth <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="date" id="kmdob1" name="kmdob1" class="dapi-ifld dapi-kdtfld">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmdob1_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Birth Time <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <select class="dapi-ifld dapi-ksel selt" id="kmhour1" name="kmhour1">
                        <option value="">Hour</option>
                        <?php
                        for ($i=0; $i<=23; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select class="dapi-ifld dapi-ksel selt" id="kmmin1" name="kmmin1">
                        <option value="">Min</option>
                        <?php
                        for ($i=0; $i<=59; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select class="dapi-ifld dapi-ksel selt" id="kmsec1" name="kmsec1">
                        <option value="">Sec</option>
                        <?php
                        for ($i=0; $i<=59; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select><br><br>
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmhms1_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Birth Place <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="text" placeholder="Birth Place" id="kmplace1" name="kmplace1" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmplace1_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: center !important;" colspan="2"><label class="cstthmlbl"> ------- &nbsp; Partner Details &nbsp; ------- </label></th>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>First Name <span class="dapi-tdanger">*</span></label></th>
                <td class="">
                    <input type="text" id="kmfname2" name="kmfname2" placeholder="First Name" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmfname2_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Last Name <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="text" id="kmlname2" name="kmlname2" placeholder="Last Name" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmlname2_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Gender <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <label for="g_male2"><input type="radio" name="kmgender2" value="male" id="g_male2" checked> Male</label> &nbsp;
                    <label for="g_female2"><input type="radio" name="kmgender2" value="female" id="g_female2"> Female</label>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Date of Birth <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="date" id="kmdob2" name="kmdob2" class="dapi-ifld dapi-kdtfld">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmdob2_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Birth Time <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <select class="dapi-ifld dapi-ksel selt" id="kmhour2" name="kmhour2">
                        <option value="">Hour</option>
                        <?php
                        for ($i=0; $i<=23; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select class="dapi-ifld dapi-ksel selt" id="kmmin2" name="kmmin2">
                        <option value="">Min</option>
                        <?php
                        for ($i=0; $i<=59; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select class="dapi-ifld dapi-ksel selt" id="kmsec2" name="kmsec2">
                        <option value="">Sec</option>
                        <?php
                        for ($i=0; $i<=59; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select><br><br>
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmhms2_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Birth Place <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="text" placeholder="Birth Place" id="kmplace2" name="kmplace2" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kmclserr" style="display:none;" id="kmplace2_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Report Language</label></th>
                <td>
                    <label for="lang_en"><input type="radio" name="kmlang" value="en" id="lang_en" checked> English</label> &nbsp;
                    <label for="lang_hi"><input type="radio" name="kmlang" value="hi" id="lang_hi"> Hindi</label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="divine-row cst-p-0">
                        <button class="cst-kndlirpt-btn" id="btn-get-kmrpt">Get Report</button>
                        <input type="hidden" id="kmtzone1" name="kmtzone1" val=""/>
                        <input type="hidden" id="kmlat1" name="kmlat1" val=""/>
                        <input type="hidden" id="kmlon1" name="kmlon1" val=""/>
                        <input type="hidden" id="kmtzone2" name="kmtzone2" val=""/>
                        <input type="hidden" id="kmlat2" name="kmlat2" val=""/>
                        <input type="hidden" id="kmlon2" name="kmlon2" val=""/>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt" style="display:none;">
        <button class="cstkmbtn cstkmbtn-active km-intrd" cls="km-intrd" mdl="20">Introduction</button>
        <button class="cstkmbtn km-bsc-dtl" cls="km-bsc-dtl" mdl="1">Basic Astrological Details</button>
        <button class="cstkmbtn km-plt-pos" cls="km-plt-pos" mdl="2">Planetary Positions</button>
        <button class="cstkmbtn km-hor-chart" cls="km-hor-chart" mdl="3">Horoscope Charts</button>
        <button class="cstkmbtn km-vims-dsha1" cls="km-vims-dsha1" mdl="4">Vimshottari Dasha P1</button>
        <button class="cstkmbtn km-vims-dsha2" cls="km-vims-dsha2" mdl="5">Vimshottari Dasha P2</button>
        <button class="cstkmbtn km-mnglk-anly" cls="km-mnglk-anly" mdl="6">Manglik Analysis</button>
        <button class="cstkmbtn km-ashtakt" cls="km-ashtakt" mdl="7">Ashtakoot</button>
        <button class="cstkmbtn km-bhkt-dsha" cls="km-bhkt-dsha" mdl="8">Bhakut Dosha</button>
        <button class="cstkmbtn km-nadi-dsha" cls="km-nadi-dsha" mdl="9">Nadi Dosha</button>
        <button class="cstkmbtn km-ashtakt-anly" cls="km-ashtakt-anly" mdl="10">Ashtakoot Analysis</button>
        <button class="cstkmbtn km-dshkt" cls="km-dshkt" mdl="11">Dashakoot</button>
        <button class="cstkmbtn km-prsnrpt" cls="km-prsnrpt" mdl="12">Personality Report</button>
        <button class="cstkmbtn km-mmrprt" cls="km-mmrprt" mdl="13">Match Making Report</button>
        <button class="cstkmbtn km-pnchy" cls="km-pnchy" mdl="14">Nav Pancham Yoga</button>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt-hi" style="display:none;">
        <button class="cstkmbtn cstkmbtn-active km-intrd" cls="km-intrd" mdl="20">परिचय</button>
        <button class="cstkmbtn km-bsc-dtl" cls="km-bsc-dtl" mdl="1">बुनियादी ज्योतिषीय विवरण</button>
        <button class="cstkmbtn km-plt-pos" cls="km-plt-pos" mdl="2">ग्रहों की स्थिति</button>
        <button class="cstkmbtn km-hor-chart" cls="km-hor-chart" mdl="3">राशिफल चार्ट</button>
        <button class="cstkmbtn km-vims-dsha1" cls="km-vims-dsha1" mdl="4">विंशोत्तरी दशा पृ1</button>
        <button class="cstkmbtn km-vims-dsha2" cls="km-vims-dsha2" mdl="5">विंशोत्तरी दशा पृ2</button>
        <button class="cstkmbtn km-mnglk-anly" cls="km-mnglk-anly" mdl="6">मांगलिक विश्लेषण</button>
        <button class="cstkmbtn km-ashtakt" cls="km-ashtakt" mdl="7">अष्टकूट</button>
        <button class="cstkmbtn km-bhkt-dsha" cls="km-bhkt-dsha" mdl="8">भकूट दोष</button>
        <button class="cstkmbtn km-nadi-dsha" cls="km-nadi-dsha" mdl="9">नाड़ी दोष</button>
        <button class="cstkmbtn km-ashtakt-anly" cls="km-ashtakt-anly" mdl="10">अष्टकूट विश्लेषण</button>
        <button class="cstkmbtn km-dshkt" cls="km-dshkt" mdl="11">दशकूट</button>
        <button class="cstkmbtn km-prsnrpt" cls="km-prsnrpt" mdl="12">व्यक्तित्व रिपोर्ट</button>
        <button class="cstkmbtn km-mmrprt" cls="km-mmrprt" mdl="13">मैच मेकिंग रिपोर्ट</button>
        <button class="cstkmbtn km-pnchy" cls="km-pnchy" mdl="14">नव पंचम योग</button>
    </div>
    <div id="kndlirprt" style="display:none;"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt" style="display:none;">
        <button class="cstkmbtn cstkmbtn-active km-intrd" cls="km-intrd" mdl="20">Introduction</button>
        <button class="cstkmbtn km-bsc-dtl" cls="km-bsc-dtl" mdl="1">Basic Astrological Details</button>
        <button class="cstkmbtn km-plt-pos" cls="km-plt-pos" mdl="2">Planetary Positions</button>
        <button class="cstkmbtn km-hor-chart" cls="km-hor-chart" mdl="3">Horoscope Charts</button>
        <button class="cstkmbtn km-vims-dsha1" cls="km-vims-dsha1" mdl="4">Vimshottari Dasha P1</button>
        <button class="cstkmbtn km-vims-dsha2" cls="km-vims-dsha2" mdl="5">Vimshottari Dasha P2</button>
        <button class="cstkmbtn km-mnglk-anly" cls="km-mnglk-anly" mdl="6">Manglik Analysis</button>
        <button class="cstkmbtn km-ashtakt" cls="km-ashtakt" mdl="7">Ashtakoot</button>
        <button class="cstkmbtn km-bhkt-dsha" cls="km-bhkt-dsha" mdl="8">Bhakut Dosha</button>
        <button class="cstkmbtn km-nadi-dsha" cls="km-nadi-dsha" mdl="9">Nadi Dosha</button>
        <button class="cstkmbtn km-ashtakt-anly" cls="km-ashtakt-anly" mdl="10">Ashtakoot Analysis</button>
        <button class="cstkmbtn km-dshkt" cls="km-dshkt" mdl="11">Dashakoot</button>
        <button class="cstkmbtn km-prsnrpt" cls="km-prsnrpt" mdl="11">Personality Report</button>
        <button class="cstkmbtn km-mmrprt" cls="km-mmrprt" mdl="13">Match Making Report</button>
        <button class="cstkmbtn km-pnchy" cls="km-pnchy" mdl="14">Nav Pancham Yoga</button>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt-hi" style="display:none;">
        <button class="cstkmbtn cstkmbtn-active km-intrd" cls="km-intrd" mdl="20">परिचय</button>
        <button class="cstkmbtn km-bsc-dtl" cls="km-bsc-dtl" mdl="1">बुनियादी ज्योतिषीय विवरण</button>
        <button class="cstkmbtn km-plt-pos" cls="km-plt-pos" mdl="2">ग्रहों की स्थिति</button>
        <button class="cstkmbtn km-hor-chart" cls="km-hor-chart" mdl="3">राशिफल चार्ट</button>
        <button class="cstkmbtn km-vims-dsha1" cls="km-vims-dsha1" mdl="4">विंशोत्तरी दशा पृ1</button>
        <button class="cstkmbtn km-vims-dsha2" cls="km-vims-dsha2" mdl="5">विंशोत्तरी दशा पृ2</button>
        <button class="cstkmbtn km-mnglk-anly" cls="km-mnglk-anly" mdl="6">मांगलिक विश्लेषण</button>
        <button class="cstkmbtn km-ashtakt" cls="km-ashtakt" mdl="7">अष्टकूट</button>
        <button class="cstkmbtn km-bhkt-dsha" cls="km-bhkt-dsha" mdl="8">भकूट दोष</button>
        <button class="cstkmbtn km-nadi-dsha" cls="km-nadi-dsha" mdl="9">नाड़ी दोष</button>
        <button class="cstkmbtn km-ashtakt-anly" cls="km-ashtakt-anly" mdl="10">अष्टकूट विश्लेषण</button>
        <button class="cstkmbtn km-dshkt" cls="km-dshkt" mdl="11">दशकूट</button>
        <button class="cstkmbtn km-prsnrpt" cls="km-prsnrpt" mdl="12">व्यक्तित्व रिपोर्ट</button>
        <button class="cstkmbtn km-mmrprt" cls="km-mmrprt" mdl="13">मैच मेकिंग रिपोर्ट</button>
        <button class="cstkmbtn km-pnchy" cls="km-pnchy" mdl="14">नव पंचम योग</button>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        kundaliMatchingMng.init();
    });
</script>