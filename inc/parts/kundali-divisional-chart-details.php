<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['divisional_charts'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div class="divine-row">
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['sun_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($sun_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['sun_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['hora_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D2_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['hora_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['dreshkan_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D3_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['dreshkan_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['chathurthamasha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D4_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['chathurthamasha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['saptamansha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D7_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['saptamansha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['dashamansha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D10_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['dashamansha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['dwadasha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D12_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['dwadasha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['shodashamsha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D16_chart['svg'])  ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['shodashamsha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['vishamansha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D20_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['vishamansha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['chaturvimshamsha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D24_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['chaturvimshamsha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['bhamsha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D27_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['bhamsha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['trishamansha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D30_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['trishamansha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['khavedamsha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D40_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['khavedamsha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['akshvedansha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D45_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['akshvedansha_chart_text'] ?></p>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 cst-flt-lft">
            <div class="chart3" style="">
                <p class="dark-title"><?= $messages['shashtymsha_chart'] ?></p>
                <div class="smallchart chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D60_chart['svg']) ?>" alt="SVG Image">
                </div>
                <p class="chart-desc"><?= $messages['shashtymsha_chart_text'] ?></p>
            </div>
        </div>
    </div>
</div>