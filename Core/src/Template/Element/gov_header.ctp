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
