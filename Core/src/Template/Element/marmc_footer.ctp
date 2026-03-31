<?php

use Cake\Core\Configure;

$siteTitle = Configure::read('Site.title');
$siteTagline = Configure::read('Site.tagline');
$address = Configure::read('Site.Address');
?>

<div class="site-footer" style="background-color:#2C3F33;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mr-auto">
                <div class="widget">
                    <h3>About <?= $siteTitle ?><span class="text-primary">.</span> </h3>
                    <p><?= $siteTagline ?></p>
                </div>
                <div class="widget">
                    <h3>Connect</h3>
                    <?= $this->element('social'); ?>
                </div>
            </div>
            <div class="col-lg-3" style="text-align: right;">
                <div class="widget">
                    <h3>Contact</h3>
                    <?= $address ?>
                </div>

            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-center">
                <p>
                    Designed and Developed by <a href="http://tech-plexus.com/" target="_blank" style="color: white;"><strong>TechPlexus Ltd<span style="color:yellow">.</span></strong></a> | Copyright © <?= date('Y') ?>
                    All rights reserved
                </p>
            </div>
        </div>
    </div>
</div>
