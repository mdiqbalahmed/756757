<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;


$URL = $this->request->getPath();
$new_url = trim($URL, '/');
$parts = explode('/', $new_url);
$first_dir = isset($parts[0]) ? $parts[0] : null;
$get_node = TableRegistry::getTableLocator()->get('nodes');
$nodes = $get_node->find()->where(['nodes.type' => $first_dir])->first();

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

<?php
if ($siteTemplate == 1) {
    echo $this->element('gov_template');
} else if ($siteTemplate == 2) {
    $isWebroot = false;
    if ($this->request->getPath() === '/') {
        $isWebroot = true;
    }

    echo $this->element('marmc_header');
    if ($isWebroot) {
        echo $this->element('marmc_homepage');
    } else if ($nodes->type == 'page') { ?>
        <?= $this->fetch('content') ?>
    <?php } else { ?>
        <div class="untree_co-hero overlay" style="background-color:<?= $headerColor; ?>; height: 150px!important; min-height: 150px!important;">
        </div>
        <?= $this->fetch('content') ?>
    <?php } ?>
<?= $this->element('marmc_footer');
} else {
    echo $this->element('school_template');
}
?>

</html>
