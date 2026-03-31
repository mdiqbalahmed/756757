<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

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

<body>

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
                        <div class="search_form">
                            <?= $this->Regions->blocks('header'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.querySelector('.search_form > span > button').innerHTML = '<i class="fa fa-search"></i>';
        </script>

        <!-- Nav AREA Starts -->
        <?= $this->element('menu_2'); ?>


        <div id="news">
            <div class="news_head">খবর:</div>
            <div class="breaking-news-slider">
                <div class=" news_title breaking-news-item">
                    <!-- < ?= $this->element('news'); ?> -->
                    <?= $this->element('xnews'); ?>
                </div>
            </div>
        </div>


        <?php
        echo $this->Blocks->get('scriptBottom');
        echo $this->Js->writeBuffer();
        ?>
</body>