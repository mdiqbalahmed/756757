<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');
$siteTitle = Configure::read('Site.title');
$footerOption = Configure::read('Footer.select');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?= $this->fetch('title') ?> - <?= $siteTitle ?></title>
    <?php
    $css = [
        'style', 'gallery', 'responsive', 'font-awesome-4.7.0/css/font-awesome', 'Croogo/Core.core/croogo-admin', // an external CSS file
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
    // $this->element('stylesheets');
    // $this->element('javascripts');
    echo $this->Blocks->get('css');
    echo $this->Blocks->get('script');
    ?>
</head>

<style>
    #fullHeight {
        display: flex;
        flex: 1;
        overflow: hidden;
    }
</style>

<body>
    <div id="fullHeight">
        <?php if ($siteTemplate == 1) {

            echo $this->element('gov_no_sidebar_element');
        } else {
            echo $this->element('no_sidebar_element');
        }
        ?>
    </div>

</body>

</html>
