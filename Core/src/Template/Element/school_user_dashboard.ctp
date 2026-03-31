<?php

use Cake\Core\Configure;

$bannerBg = Configure::read('Site.BodyColor');
$siteTemplate = Configure::read('Site.template');
$siteTitle = Configure::read('Site.title');
$HeaderBanner = Configure::read('Site.banner');
$HeaderGovt = Configure::read('Site.GovtSign');
$institute = Configure::read('Site.institute');
$siteTagline = Configure::read('Site.tagline');
$address = Configure::read('Site.Address'); //Case Sensitive
$footerLogo = Configure::read('Footer.logo');
$mapLink = Configure::read('Widget.map_link');
$mapImage = Configure::read('Widget.map_image');
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);


$css = [
    'style', 'gallery', 'responsive', 'font-awesome-4.7.0/css/font-awesome', 'user_style' // an external CSS file
];
echo $this->Html->css($css); // Assigning CSS in the webroot>css folder.
$js = [
    'script' // an external JS file
];
echo $this->Html->script($js); // Assigning JS in the webroot>js folder.

$rightRegionBlocks = $this->Regions->blocks('right');
echo $this->Meta->meta();
echo $this->Layout->feed();
echo $this->Layout->js();
$this->element('stylesheets');
$this->element('javascripts');
echo $this->Blocks->get('css');
echo $this->Blocks->get('script');
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
                        <div class="input-group">
                            <input id="search-input" type="search" id="form1" class="form-control" placeholder="অনুসন্ধান" />
                            <button id="search-button" type="submit" class="btn btn-light">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Nav AREA Starts -->
        <?= $this->element('menu_2'); ?>
        <!-- < ? = $this->element('xnews'); ?> -->



        <div id="news">
            <div class="news_head">খবর:</div>
            <div class="breaking-news-slider">
                <div class=" news_title breaking-news-item">
                    <?= $this->element('news'); ?>
                </div>
            </div>
        </div>
        <!-- Nav AREA Ends -->
        <div class="mb-5">
            <?php
            echo $this->Layout->sessionFlash();
            echo $this->fetch('content');
            ?>
        </div>
    </div>

    <?php
    echo $this->Blocks->get('scriptBottom');
    echo $this->Js->writeBuffer();
    ?>
    <script>
        $("title").html("Student Dashboard");
    </script>
</body>
