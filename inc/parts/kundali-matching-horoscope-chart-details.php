<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['horo_chart'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL ?>public/images/kundali-matching/header_title_matching.png">
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <p class="dark-title mt-30"><u><?= $messages['lagna_chart'] ?></u></p>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p1_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($po_birth_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p2_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($pt_birth_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <hr/>
            <p class="dark-title mt-30"><u><?= $messages['chalit_chart'] ?></u></p>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p1_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($po_chalit_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p2_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($pt_chalit_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <hr/>
            <p class="dark-title mt-30"><u><?= $messages['moon_chart'] ?></u></p>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p1_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($po_moon_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p2_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($pt_moon_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <hr/>
            <p class="dark-title mt-30"><u><?= $messages['navmansha_chart'] ?></u></p>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p1_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($po_D9_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 cst-flt-lft">
            <div class="grid">
                <p class="dark-title"><?= $p2_name ?></p>
                <div class="chart">
                    <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($pt_D9_chart['svg']) ?>" alt="SVG Image">
                </div>
            </div>
        </div>
    </div>
</div>