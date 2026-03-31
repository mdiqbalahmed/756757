    <?php

    use Cake\Core\Configure;

    $siteTitle = Configure::read('Site.title');
    $siteTagline = Configure::read('Site.tagline');
    $siteTemplate = Configure::read('Site.template');
    $footerOption = Configure::read('Footer.select');

    $this->loadHelper('Croogo/Core.Layout');
    $this->loadHelper('Croogo/Core.Js');
    $this->loadHelper('Croogo/Core.Theme');
    $this->loadHelper('Croogo/Menus.Menus');
    $this->loadHelper('Croogo/Meta.Meta');

    ?>
    <!DOCTYPE html>
    <html style='background: #0e0e0e;'>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?= $this->fetch('title'); ?> - <?= $siteTitle; ?></title>
        <?php
        $css = [
            'style', 'gallery', 'responsive', 'font-awesome-4.7.0/css/font-awesome' // an external CSS file
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
    </head>

    <?php if ($siteTemplate == 1) { ?>

        <body style="background: url('./uploads/bg_main.gif') repeat-y scroll center top rgba(0, 0, 0, 0);">
            <?= $this->element('gov_header') ?>
            <div class="row my-5">
                <div class="col-md-6 col-12 pl-5">
                    <?php
                    echo $this->Layout->sessionFlash();
                    echo $this->fetch('content');
                    ?>
                </div>
                <div class="col-md-6 col-12">
                    <?= $this->Html->image('/webroot/uploads/error_slide.png'); ?>
                </div>
            </div>
            </div>
            <?= $this->element('gov_footer'); ?>
            <?php
            echo $this->Blocks->get('scriptBottom');
            echo $this->Js->writeBuffer();
            ?>
            </div>
        </body>

    <?php } else { ?>
            <?= $this->element('school_header') ?>
            <div class="row my-5">
                <div class="col-md-6 col-12 pl-5">
                    <?php
                    echo $this->Layout->sessionFlash();
                    echo $this->fetch('content');
                    ?>
                </div>
                <div class="col-md-6 col-12">
                    <?= $this->Html->image('/webroot/uploads/error_slide.png'); ?>
                </div>
            </div>
            </div>
            <?php
            echo $this->Blocks->get('scriptBottom');
            echo $this->Js->writeBuffer();
            ?>
            </div>
        </body>

        <?php if ($footerOption == 1) {
            echo $this->element('footer_1');
        } else {
            echo $this->element('footer_2');
        } ?>
    <?php } ?>

    </html>
