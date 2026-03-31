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
    <title><?= $this->fetch('title') ?> - <?= $_siteTitle ?></title>
    <?php
    echo $this->Html->css([
        'Croogo/Core.core/croogo-admin',
    ]);
    echo $this->Layout->js();
    echo $this->Html->script([]);

    echo $this->fetch('script');
    echo $this->fetch('css');
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

            echo $this->element('gov_template');
        } else {
            echo $this->element('school_user_dashboard');
        }
        ?>
    </div>
    <?php
    if ($footerOption == 1) {
        echo $this->element('footer_1');
    } else {
        echo $this->element('footer_2');
    }
    ?>
</body>

</html>
