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
    $css = [
        'style', 'user_style' // an external CSS file
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

<?= $this->element('marmc_header'); ?>
<div class="untree_co-hero overlay" style="background-color:<?= $headerColor; ?>; height: 150px!important; min-height: 150px!important;"></div>
<?php
echo $this->Layout->sessionFlash();
echo $this->fetch('content');
?>


<?php
echo $this->Blocks->get('scriptBottom');
echo $this->Js->writeBuffer();
?>

<?= $this->element('marmc_footer'); ?>

</html>
<script>
    $("title").html("Student Dashboard");
</script>
