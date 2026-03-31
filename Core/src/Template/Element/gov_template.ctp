<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');
$siteTitle = Configure::read('Site.title');
$HeaderBanner = Configure::read('Site.banner');
$HeaderGovt = Configure::read('Site.GovtSign');
$institute = Configure::read('Site.institute');
$siteTagline = Configure::read('Site.tagline');
$address = Configure::read('Site.Address'); //Case Sensitive
$footerLogo = Configure::read('Footer.logo');
$footerOption = Configure::read('Footer.select');
$mapLink = Configure::read('Widget.map_link');
$mapImage = Configure::read('Widget.map_image');
$siteFeatured = Configure::read('Site.govFeatured');
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);

?>

<?= $this->element('boxes_node'); ?>

<body style="background: url('/uploads/bg_main.gif') repeat-y scroll center top rgba(0, 0, 0, 0);">
    <div class="container home-page">
        <div class="blocks">
            <div class="top-menu">
                <div class="row mb-2 mb-md-0 px-3">
                    <div class="col-12 col-md-8 bd-gov-site">
                        <?= $this->element('social'); ?>
                    </div>
                    <div class="col-12 col-md-4 text-right pr-3">
                        <div class="input-group">
                            <?= $this->Regions->blocks('header'); ?>
                        </div>
                    </div>
                </div>
                <script>
                    document.querySelector('.input-group > span > button').innerHTML = '<i class="fa fa-search"></i>';
                </script>
            </div>
            <div id="banner-slider">

                <?php
                // Check if current URL corresponds to the webroot directory
                $isWebroot = false;
                if ($this->request->getPath() === '/') {
                    $isWebroot = true;
                }
                echo $this->element('gov_slider');
                ?>

                <?= $this->element('gov_menu'); ?>
            </div>

            <div class="header-site-info" id="header-site-info">
                <div>
                    <a href="<?= $siteURL ?>"><?= $this->Html->image($HeaderBanner, array("alt" => $institute, "style" => "width: 50%;")); ?></a>
                </div>
            </div>



            <div class="row">
                <div class="col-md-9">
                    <div class="containerpadma mb-4 p-2" <?php if ($siteFeatured == null) { ?> style="display:none" <?php } ?>>
                        <?php if (isset($siteFeatured)) {
                            echo $this->Html->image($siteFeatured, array("alt" => 'padma_bridge_countdown', "style" => "width: 100%;"));
                        } ?>
                    </div>
                    <?php if ($isWebroot) { ?>
                        <div class="fixed_notice my-4">
                            <?= $this->element('gov_fixed_notice'); ?>
                        </div>
                        <div class="mb-4">
                            <?= $this->element('xnews'); ?>
                        </div>

                        <!-- <div id="news">
                            <div class="news_head">খবর:</div>
                            <div class="breaking-news-slider">
                                <div class=" news_title breaking-news-item">
                                    < ? = $this->element('news'); ?>
                                </div>
                            </div>
                        </div> -->

                        <?= $this->element('boxes_node'); ?>
                    <?php } ?>
                    <?= $this->fetch('content'); ?>


                </div>
                <div class=" col-md-3">
                    <?= $this->element('gov_employee'); ?>
                    <?= $this->Regions->blocks('right') ?>
                    <div class="sidebarComn pb-3">
                        <?= $this->Regions->blocks('blogroll'); ?>
                        <?= $this->element('calendar'); ?>

                        <div class="row mt-3 mb-2">
                            <div class="col-md-12 mb-3">
                                <a href="<?= $mapLink ?>">
                                    <?php if (isset($mapImage)) {
                                        echo $this->Html->image($mapImage, array("alt" => $institute, "class" => "map_img"));
                                    } ?>
                                </a>

                            </div>
                        </div>
                        <div style="background:#000;display:flex;justify-content:center">
                            <?= $this->element('clock'); ?>
                        </div>

                        <div style="background:teal;display:flex;justify-content:center">
                            <span class="text-light pr-2">Visitors: </span><?= $this->element('visitor'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <?php
            echo $this->element('gov_footer');
            ?>
        </div>
    </div>
</body>

<script>
    // Select all <nav> elements
    var navs = document.querySelectorAll('nav');

    // Loop through each <nav> element
    navs.forEach(function(nav) {
        // Select all <a> elements inside the current <nav>
        var links = nav.querySelectorAll('a');

        // Loop through each <a> element
        links.forEach(function(link) {
            // Create a new <li> element
            var listItem = document.createElement('li');

            // Append the <a> element to the <li> element
            listItem.appendChild(link.cloneNode(true));

            // Replace the <a> element with the new <li> element
            link.parentNode.replaceChild(listItem, link);
        });
    });
</script>
