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

<div class="footer-artwork">
    <?php echo $this->Html->image("/uploads/footer_top_bg.png", array("alt" => "Footer top bg", 'class' => "w-100")); ?>
</div>
<div class="footer_bg_gov py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-12 footer_logo_position text-center" style="display:flex; flex-direction: column;"><a href="<?= $siteURL ?>"><?= $this->Html->image($footerLogo, array("alt" => $institute, "class" => "ftr_logo_gov")); ?>
                </a>
                <b style="color: #000; font-size: 12px; margin-top:1em">&copy; <?= (new DateTime)->format("Y"); ?> All Rights Reserved</b>
            </div>
            <div class="col-md-4 col-12 address_layout_gov text-dark"><?= $address ?></div>
            <div class="col-md-5 col-12 footer_nav_gov">
                <nav class="navbar navbar-expand-lg">
                    <?= $this->Menus->menu('footer', [
                        'dropdown' => true,
                        'subTagAttributes' => ['class' => 'nav-item text-left footer_2_menu',],
                        'linkAttributes' => ['class' => 'nav-link footer_2_link ',],
                    ]); ?>
                </nav>
            </div>
            <div class="col-md-12 pr-5 company_logo_gov text-right">
                <a href="http://tech-plexus.com/" class="ftrLogo" target="_blank"><?php echo $this->Html->image("/uploads/Home/ftrlogo.png", array("alt" => "TechPlexus Ltd.")); ?></a>
            </div>
        </div>
    </div>
</div>
