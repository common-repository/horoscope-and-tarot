<div class="divine-row dapi-krpt">
    <div class="divine_auth_domain_response" id="kundali-auth" style="display:none;">
        <p style="color: red !important;text-align:center !important;"></p>
    </div>
    <div class="table-div cst-tsm mb-20" id="kdlfrm" style="display:none;">
        <h2 class="table-title cstmb10">Get Your Kundali</h2>
        <table class="chile-table table cstbl">
            <tr>
                <th style="text-align: right !important;"><label>First Name <span class="dapi-tdanger">*</span></label></th>
                <td class="">
                    <input type="text" id="kfname" name="kfname" placeholder="First Name" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kclserr" style="display:none;" id="kfname_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Last Name <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="text" id="klname" name="klname" placeholder="Last Name" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kclserr" style="display:none;" id="klname_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Gender <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <label for="g_male"><input type="radio" name="kgender" value="male" id="g_male" checked> Male</label> &nbsp;
                    <label for="g_female"><input type="radio" name="kgender" value="female" id="g_female"> Female</label>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Date of Birth <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="date" id="kdob" name="kdob" class="dapi-ifld dapi-kdtfld">
                    <p class="dapi-tdanger kclserr" style="display:none;" id="kdob_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Birth Time <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <select class="dapi-ifld dapi-ksel selt" id="khour" name="khour">
                        <option value="">Hour</option>
                        <?php
                        for ($i=0; $i<=23; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select class="dapi-ifld dapi-ksel selt" id="kmin" name="kmin">
                        <option value="">Min</option>
                        <?php
                        for ($i=0; $i<=59; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select>
                    <select class="dapi-ifld dapi-ksel selt" id="ksec" name="ksec">
                        <option value="">Sec</option>
                        <?php
                        for ($i=0; $i<=59; $i++) {
                            $add_zero = (strlen($i) == 1) ? '0' : '';
                            echo '<option value="' . $i . '">' . $add_zero . $i . '</option>';
                        }
                        ?>
                    </select><br><br>
                    <p class="dapi-tdanger kclserr" style="display:none;" id="khms_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Birth Place <span class="dapi-tdanger">*</span></label></th>
                <td>
                    <input type="text" placeholder="Birth Place" id="kplace" name="kplace" class="dapi-ifld dapi-kdtfld txtOnly">
                    <p class="dapi-tdanger kclserr" style="display:none;" id="kplace_err"></p>
                </td>
            </tr>
            <tr>
                <th style="text-align: right !important;"><label>Report Language</label></th>
                <td>
                    <label for="lang_en"><input type="radio" name="klang" value="en" id="lang_en" checked> English</label> &nbsp;
                    <label for="lang_hi"><input type="radio" name="klang" value="hi" id="lang_hi"> Hindi</label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="divine-row cst-p-0">
                        <button class="cst-kndlirpt-btn" id="btn-get-krpt">Get Report</button>
                        <input type="hidden" id="ktzone" name="ktzone" val=""/>
                        <input type="hidden" id="klat" name="klat" val=""/>
                        <input type="hidden" id="klon" name="klon" val=""/>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt" style="display:none;">
        <button class="cstkbtn cstkbtn-active k-intrd" cls="k-intrd" mdl="20">Introduction</button>
        <button class="cstkbtn k-bsc-dtl" cls="k-bsc-dtl" mdl="1">Basic Astrological Details</button>
        <button class="cstkbtn k-plt-pos" cls="k-plt-pos" mdl="2">Planetary Positions</button>
        <button class="cstkbtn k-hor-chrt" cls="k-hor-chrt" mdl="3">Horoscope Charts</button>
        <button class="cstkbtn k-house-cusp" cls="k-house-cusp" mdl="4">House Cusps and Sandhi</button>
        <button class="cstkbtn k-div-chrt" cls="k-div-chrt" mdl="5">Divisional Charts</button>
        <button class="cstkbtn k-comp-frnd" cls="k-comp-frnd" mdl="6">Composite Friendship Table</button>
        <button class="cstkbtn k-plt-dtl" cls="k-plt-dtl" mdl="7">KP Planetary Details</button>
        <button class="cstkbtn k-house-cusp-chart" cls="k-house-cusp-chart" mdl="8">KP House Cusps and Chart</button>
        <button class="cstkbtn k-asc-rprt" cls="k-asc-rprt" mdl="11">Ascendant Report</button>
        <button class="cstkbtn k-bhava-kndli" cls="k-bhava-kndli" mdl="12">Bhava Kundali</button>
        <button class="cstkbtn k-vims-dsha9" cls="k-vims-dsha9" mdl="9">Vimshottari Dasha</button>
        <button class="cstkbtn k-vims-dsha19" cls="k-vims-dsha19" mdl="19">Vimshottari Dasha</button>
        <button class="cstkbtn k-yog-dsha" cls="k-yog-dsha" mdl="18">Yogini Dasha</button>
        <button class="cstkbtn k-sadh-anly" cls="k-sadh-anly" mdl="13">Sadhesati Analysis</button>
        <button class="cstkbtn k-sadh-lyf-anly" cls="k-sadh-lyf-anly" mdl="10">Sadhesati Life Analysis</button>
        <button class="cstkbtn k-klsrp-dsha" cls="k-klsrp-dsha" mdl="14">Kalsarpa Dosha</button>
        <button class="cstkbtn k-mnglk-anly" cls="k-mnglk-anly" mdl="15">Manglik Analysis</button>
        <button class="cstkbtn k-plt-prf" cls="k-plt-prf" mdl="16">Planet Profiles</button>
        <button class="cstkbtn k-gem-sugg" cls="k-gem-sugg" mdl="17">Gemstone Suggestions</button>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt-hi" style="display:none;">
        <button class="cstkbtn cstkbtn-active k-intrd" cls="k-intrd" mdl="20">परिचय</button>
        <button class="cstkbtn k-bsc-dtl" cls="k-bsc-dtl" mdl="1">बुनियादी ज्योतिषीय विवरण</button>
        <button class="cstkbtn k-plt-pos" cls="k-plt-pos" mdl="2">ग्रहों की स्थिति</button>
        <button class="cstkbtn k-hor-chrt" cls="k-hor-chrt" mdl="3">राशिफल चार्ट</button>
        <button class="cstkbtn k-house-cusp" cls="k-house-cusp" mdl="4">हाउस क्यूस्प्स और संधि</button>
        <button class="cstkbtn k-div-chrt" cls="k-div-chrt" mdl="5">संभागीय चार्ट</button>
        <button class="cstkbtn k-comp-frnd" cls="k-comp-frnd" mdl="6">समग्र मैत्री तालिका</button>
        <button class="cstkbtn k-plt-dtl" cls="k-plt-dtl" mdl="7">केपी ग्रहों का विवरण</button>
        <button class="cstkbtn k-house-cusp-chart" cls="k-house-cusp-chart" mdl="8">केपी हाउस क्यूस्प्स और चार्ट</button>
        <button class="cstkbtn k-asc-rprt" cls="k-asc-rprt" mdl="11">लग्न रिपोर्ट</button>
        <button class="cstkbtn k-bhava-kndli" cls="k-bhava-kndli" mdl="12">भाव कुंडली</button>
        <button class="cstkbtn k-vims-dsha9" cls="k-vims-dsha9" mdl="9">विंशोत्तरी दशा</button>
        <button class="cstkbtn k-vims-dsha19" cls="k-vims-dsha19" mdl="19">विंशोत्तरी दशा</button>
        <button class="cstkbtn k-yog-dsha" cls="k-yog-dsha" mdl="18">योगिनी दशा</button>
        <button class="cstkbtn k-sadh-anly" cls="k-sadh-anly" mdl="13">साढ़ेसाती विश्लेषण</button>
        <button class="cstkbtn k-sadh-lyf-anly" cls="k-sadh-lyf-anly" mdl="10">साढ़ेसाती जीवन विश्लेषण</button>
        <button class="cstkbtn k-klsrp-dsha" cls="k-klsrp-dsha" mdl="14">कालसर्प दोष</button>
        <button class="cstkbtn k-mnglk-anly" cls="k-mnglk-anly" mdl="15">मांगलिक विश्लेषण</button>
        <button class="cstkbtn k-plt-prf" cls="k-plt-prf" mdl="16">ग्रह प्रोफाइल</button>
        <button class="cstkbtn k-gem-sugg" cls="k-gem-sugg" mdl="17">रत्न सुझाव</button>
    </div>
    <div id="kndlirprt" style="display:none;"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt" style="display:none;">
        <button class="cstkbtn cstkbtn-active k-intrd" cls="k-intrd" mdl="20">Introduction</button>
        <button class="cstkbtn k-bsc-dtl" cls="k-bsc-dtl" mdl="1">Basic Astrological Details</button>
        <button class="cstkbtn k-plt-pos" cls="k-plt-pos" mdl="2">Planetary Positions</button>
        <button class="cstkbtn k-hor-chrt" cls="k-hor-chrt" mdl="3">Horoscope Charts</button>
        <button class="cstkbtn k-house-cusp" cls="k-house-cusp" mdl="4">House Cusps and Sandhi</button>
        <button class="cstkbtn k-div-chrt" cls="k-div-chrt" mdl="5">Divisional Charts</button>
        <button class="cstkbtn k-comp-frnd" cls="k-comp-frnd" mdl="6">Composite Friendship Table</button>
        <button class="cstkbtn k-plt-dtl" cls="k-plt-dtl" mdl="7">KP Planetary Details</button>
        <button class="cstkbtn k-house-cusp-chart" cls="k-house-cusp-chart" mdl="8">KP House Cusps and Chart</button>
        <button class="cstkbtn k-asc-rprt" cls="k-asc-rprt" mdl="11">Ascendant Report</button>
        <button class="cstkbtn k-bhava-kndli" cls="k-bhava-kndli" mdl="12">Bhava Kundali</button>
        <button class="cstkbtn k-vims-dsha9" cls="k-vims-dsha9" mdl="9">Vimshottari Dasha</button>
        <button class="cstkbtn k-vims-dsha19" cls="k-vims-dsha19" mdl="19">Vimshottari Dasha</button>
        <button class="cstkbtn k-yog-dsha" cls="k-yog-dsha" mdl="18">Yogini Dasha</button>
        <button class="cstkbtn k-sadh-anly" cls="k-sadh-anly" mdl="13">Sadhesati Analysis</button>
        <button class="cstkbtn k-sadh-lyf-anly" cls="k-sadh-lyf-anly" mdl="10">Sadhesati Life Analysis</button>
        <button class="cstkbtn k-klsrp-dsha" cls="k-klsrp-dsha" mdl="14">Kalsarpa Dosha</button>
        <button class="cstkbtn k-mnglk-anly" cls="k-mnglk-anly" mdl="15">Manglik Analysis</button>
        <button class="cstkbtn k-plt-prf" cls="k-plt-prf" mdl="16">Planet Profiles</button>
        <button class="cstkbtn k-gem-sugg" cls="k-gem-sugg" mdl="17">Gemstone Suggestions</button>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 kndlirprt-hi" style="display:none;">
        <button class="cstkbtn cstkbtn-active k-intrd" cls="k-intrd" mdl="20">परिचय</button>
        <button class="cstkbtn k-bsc-dtl" cls="k-bsc-dtl" mdl="1">बुनियादी ज्योतिषीय विवरण</button>
        <button class="cstkbtn k-plt-pos" cls="k-plt-pos" mdl="2">ग्रहों की स्थिति</button>
        <button class="cstkbtn k-hor-chrt" cls="k-hor-chrt" mdl="3">राशिफल चार्ट</button>
        <button class="cstkbtn k-house-cusp" cls="k-house-cusp" mdl="4">हाउस क्यूस्प्स और संधि</button>
        <button class="cstkbtn k-div-chrt" cls="k-div-chrt" mdl="5">संभागीय चार्ट</button>
        <button class="cstkbtn k-comp-frnd" cls="k-comp-frnd" mdl="6">समग्र मैत्री तालिका</button>
        <button class="cstkbtn k-plt-dtl" cls="k-plt-dtl" mdl="7">केपी ग्रहों का विवरण</button>
        <button class="cstkbtn k-house-cusp-chart" cls="k-house-cusp-chart" mdl="8">केपी हाउस क्यूस्प्स और चार्ट</button>
        <button class="cstkbtn k-asc-rprt" cls="k-asc-rprt" mdl="11">लग्न रिपोर्ट</button>
        <button class="cstkbtn k-bhava-kndli" cls="k-bhava-kndli" mdl="12">भाव कुंडली</button>
        <button class="cstkbtn k-vims-dsha9" cls="k-vims-dsha9" mdl="9">विंशोत्तरी दशा</button>
        <button class="cstkbtn k-vims-dsha19" cls="k-vims-dsha19" mdl="19">विंशोत्तरी दशा</button>
        <button class="cstkbtn k-yog-dsha" cls="k-yog-dsha" mdl="18">योगिनी दशा</button>
        <button class="cstkbtn k-sadh-anly" cls="k-sadh-anly" mdl="13">साढ़ेसाती विश्लेषण</button>
        <button class="cstkbtn k-sadh-lyf-anly" cls="k-sadh-lyf-anly" mdl="10">साढ़ेसाती जीवन विश्लेषण</button>
        <button class="cstkbtn k-klsrp-dsha" cls="k-klsrp-dsha" mdl="14">कालसर्प दोष</button>
        <button class="cstkbtn k-mnglk-anly" cls="k-mnglk-anly" mdl="15">मांगलिक विश्लेषण</button>
        <button class="cstkbtn k-plt-prf" cls="k-plt-prf" mdl="16">ग्रह प्रोफाइल</button>
        <button class="cstkbtn k-gem-sugg" cls="k-gem-sugg" mdl="17">रत्न सुझाव</button>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        kundaliMng.init();
    });
</script>