<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');
$siteTitle = Configure::read('Site.title');
$headerColor = Configure::read('Menu.HeaderColor');

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title'); ?> - <?= $siteTitle; ?></title>
    <?php
    $rightRegionBlocks = $this->Regions->blocks('right');
    echo $this->Meta->meta();
    echo $this->Layout->feed();
    echo $this->Layout->js();
    $this->element('stylesheets');
    $this->element('javascripts');
    echo $this->Blocks->get('css');
    echo $this->Blocks->get('script');
    ?>
</head>

<?= $this->element('marmc_header'); ?>
<div class="untree_co-hero overlay" style="background-color:<?= $headerColor; ?>; height: 150px!important; min-height: 150px!important;"></div>
<?= $this->fetch('content') ?>
<?= $this->element('marmc_footer'); ?>

</html>
