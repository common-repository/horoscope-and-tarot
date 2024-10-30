<div class="topic_page">
    <div class="page-title">
        <div class="border_div">
            <h3 class="pagewise-title"><?= $messages['horo_chart'] ?></h3>
            <img class="border-image" src="<?= DHAT_PLUGIN_URL . 'public/images/kundali/header_title.png' ?>">
        </div>
    </div>
    <div>
        <div class="divine-row">
            <div class="col-xl-6 col-md-6 cst-flt-lft">
                <div class="grid">
                    <p class="dark-title"><?= $messages['lagna_chart'] ?></p>
                    <div class="chart">
                        <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($birth_chart['svg']) ?>" alt="SVG Image">
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 cst-flt-lft">
                <div class="grid">
                    <p class="dark-title dark-title-blank">Blank</p>
                    <div class="chart-blank-content">
                        <p><?= $messages['lagna_text'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="divine-row mt-20">
            <div class="col-xl-6 col-md-6 cst-flt-lft">
                <div class="grid">
                    <p class="dark-title"><?= $messages['moon_chart'] ?></p>
                    <div class="chart">
                        <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($moon_chart['svg']) ?>" alt="SVG Image">
                    </div>
                    <div class="chart-blank-content small">
                        <p><?= $messages['moon_text'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 cst-flt-lft">
                <div class="grid">
                    <p class="dark-title"><?= $messages['navmansha_chart'] ?></p>
                    <div class="chart">
                        <img class="chart-image" src="data:image/svg+xml;base64,<?= base64_encode($D9_chart['svg']) ?>" alt="SVG Image">
                    </div>
                    <div class="chart-blank-content small">
                        <p><?= $messages['navmasa_text'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>