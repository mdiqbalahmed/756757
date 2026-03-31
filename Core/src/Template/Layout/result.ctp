<?php
use Cake\Core\Configure;
$siteTitle = Configure::read('Site.title');
$showActions = isset($showActions) ? $showActions : true;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title><?= $this->fetch('title') ?> - <?= $siteTitle ?></title>
        <?php

        echo $this->element('admin/stylesheets');
        echo $this->element('admin/javascripts');

        echo $this->fetch('script');
        echo $this->fetch('css');

        ?>
    </head>
    <body  >

                <?= $this->Layout->sessionFlash() ?>
                 <?= $this->fetch('content') ?>
    </body>
</html>
