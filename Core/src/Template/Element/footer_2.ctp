<?php

use Cake\Core\Configure;

$siteTitle = Configure::read('Site.title');
$HeaderBanner = Configure::read('Site.banner');
$HeaderGovt = Configure::read('Site.GovtSign');
$institute = Configure::read('Site.institute');
$siteTagline = Configure::read('Site.tagline');
$address = Configure::read('Site.Address'); //Case Sensitive
$footerLogo = Configure::read('Footer.logo');
$footerBg = Configure::read('Footer.background');
$siteURL = $this->Url->build(["plugin" => "Croogo/Nodes", "controller" => "Nodes", "action" => "promoted"]);
?>
<style>
    .footer_logo_position {
        display: flex;
        justify-content: center;
        border-right: 2px solid #353535;
        align-items: center;
        flex-direction: column;
    }

    .ftr_logo {
        max-width: 135px;
        height: auto;
    }

    .footer_bg {
        background-color: <?= $footerBg ?> !important;
    }

    .address_layout {
        padding-left: 35px;
        color: #fff;
        display: flex;
        align-items: center;
    }

    .footer_nav {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .footer_nav ul {
        display: flex;
        flex-wrap: wrap;
        float: left;
    }

    .footer_nav ul li {
        float: left;
        font-size: 0.85em;
        line-height: 1.262em;
        width: 47%;
        margin-top: 0.5em;
        margin-right: 0.75em;
        border-left: 6px solid #353535;
        border-bottom: 1px dashed #353535;
    }

    @media only screen and (max-width: 767px) {

        .clock_body,
        .visitor_body {
            padding: 0.5em;
        }

        .address_layout {
            display: flex;
            justify-content: center;
            text-align: center;
            padding-left: 0px;
        }

        .footer_nav ul {
            display: flex;
            flex-direction: row-reverse;
        }

        .footer_nav ul li {
            float: left;
            padding-left: 5px;
            font-size: 0.85em;
            line-height: 1.262em;
            width: 100%;
            margin-top: 0.5em;
            margin-right: 0.75em;
            border-left: 6px solid #353535;
            border-bottom: 1px dashed #353535;
        }
    }
</style>
<div class="footer_bg py-3">
    <div class="container">
        <div class="row flex-column-reverse flex-sm-row">
            <div class="col-md-3 col-12 footer_logo_position"><a href="<?= $siteURL ?>"><?= $this->Html->image($footerLogo, array("alt" => $institute, "class" => "ftr_logo")); ?>
                </a>
                <b style="color: #fff; font-size: 12px;">&copy; <?= (new DateTime)->format("Y"); ?> All Rights Reserved</b>
            </div>
            <div class="col-md-4 col-12 address_layout"><?= $address ?></div>
            <div class="col-md-5 col-12 footer_nav">
                <nav class="navbar navbar-expand-lg">
                    <?= $this->Menus->menu('footer', [
                        'dropdown' => true,
                        'subTagAttributes' => ['class' => 'nav-item text-left footer_2_menu',],
                        'linkAttributes' => ['class' => 'nav-link footer_2_link ',],
                    ]); ?>
                </nav>
            </div>

        </div>
        <div class="col-md-12 company_logo text-right">
            <a href="http://tech-plexus.com/" class="ftrLogo" target="_blank"><?php echo $this->Html->image("/uploads/Home/ftrlogo.png", array("alt" => "TechPlexus Ltd.")); ?></a>
        </div>
    </div>
</div>