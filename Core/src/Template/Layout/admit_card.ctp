<?php

$showActions = isset($showActions) ? $showActions : true;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title><?= $this->fetch('title') ?> - <?= $_siteTitle ?></title>
        <?php

        echo $this->element('admin/stylesheets');
        echo $this->element('admin/javascripts');

        echo $this->fetch('script');
        echo $this->fetch('css');

        ?>
    </head>
    <body>

        <div id="content" class="content">

            <div id="inner-content" class="p-0 mt-2 <?= $this->Theme->getCssClass('columnFull') ?>">
                <?= $this->Layout->sessionFlash() ?>
                 <?= $this->fetch('content') ?>
            </div>
        </div>

    </body>
</html>
