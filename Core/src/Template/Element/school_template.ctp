<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

$bannerBg = Configure::read('Site.BodyColor');
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
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);

?>

<style>
     @media only screen and (max-width: 767px) {

     .logo100 {
    width: 155% !important;
      }
    .mx-1 {
    margin-bottom: -50px;
    margin-top: -50px;
        }
    }
</style>

<body style="background:<?= h($bannerBg); ?>;">

    <?= $this->element('topbar'); ?>

    <div class=" container custom_banner_bg mt-2">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="row">
                    <div class="col-md-8 col-8">
                        <a href="<?= $siteURL ?>"><?= $this->Html->image($HeaderBanner, array("alt" => $institute, "class" => "logo100")); ?></a>
                    </div>
                    <div class="col-md-4 col-4">
                        <?= $this->Html->image($HeaderGovt, array("alt" => "")); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6" id="social" align="right">
                        <?= $this->element('social'); ?>
                    </div>
                    <div class="col-md-6 col-sm-6" id="search">
                        <div class="search_input">
                            <?= $this->Regions->blocks('header'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.querySelector('.search_input button').innerHTML = '<i class="fa fa-search"></i>';
        </script>

        <!-- Nav AREA Starts -->
        <?= $this->element('menu_2'); ?>
        <!-- < ? = $this->element('xnews'); ?> -->
        <div class="mb-4">
        <?= $this->element('xnews'); ?>
        </div>


        <!-- Nav AREA Ends -->

        <div class="<?= $this->Theme->getCssClass('row') ?>">
            <div class="<?= $this->Theme->getCssClass('columnLeft') ?>">

                <?php
                // Check if current URL corresponds to the webroot directory
                $isWebroot = false;
                if ($this->request->getPath() === '/') {
                    $isWebroot = true;
                }
                // Render the slider_content element only in webroot directory
                if ($isWebroot) {
                    echo $this->element('slider_content');

                    // BOX DISPLAYING Before Content
                    $get_config = TableRegistry::getTableLocator()->get('cms_page_config');
                    $configs = $get_config->find()->enableAutoFields(true)->enableHydration(false)->toArray();
                    foreach ($configs as $config) {
                        if ($config['node_page_id'] == 0 && $config['box_position'] == 1) { //Box position TOP:: "1"
                            echo $this->element('boxes_node');
                        };
                    };
                }
                ?>
                <div class="my-4">
                    <?php
                    echo $this->Layout->sessionFlash();
                    echo $this->fetch('content');

                    if ($isWebroot) {
                        // BOX DISPLAYING After Content
                        foreach ($configs as $config) {
                            if ($config['node_page_id'] == 0 && $config['box_position'] == 0) { //Box position TOP:: "1"
                                echo $this->element('boxes');
                            };
                        };
                    }
                    ?>
                </div>
            </div>

            <div class="<?= $this->Theme->getCssClass('columnRight') ?> mb-3">
                <?= $this->Regions->blocks('right') ?>
                <div class="sidebarComn">
                    <?= $this->Regions->blocks('blogroll'); ?>
                    <div class="row mt-3 mb-5">
                        <div class="col-md-12 mb-3">
                            <a href="<?= $mapLink ?>"><?= $this->Html->image($mapImage, array("alt" => $institute, "class" => "map_img")); ?></a>
                        </div>
                        <div class="col-md-12 mb-3">
                            <?php echo $this->element('calendar'); ?>
                        </div>
                        <div class="col-md-12 col-12 clock_body">
                            <?php echo $this->element('clock'); ?>
                        </div>
                        <div class="col-md-12 col-12  visitor_body mb-3">
                            <?php echo $this->element('visitor'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Selection -->
    <?php
    if ($footerOption == 1) {
        echo $this->element('footer_1');
    } else {
        echo $this->element('footer_2');
    }
    ?>

    <?php
    echo $this->Blocks->get('scriptBottom');
    echo $this->Js->writeBuffer();
    ?>
</body>
