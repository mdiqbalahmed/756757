<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');
if ($siteTemplate == 2) {

    $this->Html->script([
        'jquery/jquery.min',
        'jquery-ui',
        'core/popper.min',
        'core/bootstrap.min',
        'jquery.validate.min',
    ], [
        'block' => true,
    ]);

    $this->Html->script([
        'jquery-easing/jquery.easing.min',
        'owl.carousel.min',
        'jquery.animateNumber.min',
        'jquery.waypoints.min',
        'jquery.fancybox.min',
        'jquery.sticky',
        'aos',
        'dropbox',
        'marmc_custom',
    ], [
        'block' => true,
        'async' => true,
    ]);

    $this->Html->script([
        'theme',
        'marmc_custom_script',
        'script',

    ], [
        'block' => true,
        'defer' => true,
    ]);
} else {
    $this->Html->script([
        'jquery/jquery.min',
        'core/bootstrap.min',
    ], [
        'block' => true,
    ]);

    $this->Html->script([
        'core/popper.min',
        'jquery-easing/jquery.easing.min',
    ], [
        'block' => true,
        'async' => true,
    ]);

    $this->Html->script([
        'theme',
    ], [
        'block' => true,
        'defer' => true,
    ]);
}
