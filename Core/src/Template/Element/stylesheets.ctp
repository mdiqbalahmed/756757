<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');
if ($siteTemplate == 2) {
    $this->Html->css([
        'bootstrap.min',
        'font-awesome.min',
        'all.min',
        'font-awesome-4.7.0/css/font-awesome.min',
        'animate.min',
        'jquery.fancybox.min',
        'aos',
        'flaticon',
        'style-icon',
        'owl.carousel.min',
        'owl.theme.default.min',
        'marmc_style',
        'style',
        'gallery',
        'responsive',
        '//fonts.googleapis.com/css?family=Montserrat:400,700',
        '//fonts.googleapis.com/css?family=Delius',
        '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic',
        '//fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700',
        'font-face',
        'theme.min',
        'custom',
    ], [
        'block' => 'css',
    ]);
} else {
    $this->Html->css([
        'bootstrap.min',
        'font-awesome.min',
        'font-awesome-4.7.0/css/font-awesome',
        'style',
        'gallery',
        '//fonts.googleapis.com/css?family=Montserrat:400,700',
        '//fonts.googleapis.com/css?family=Delius',
        '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic',
        '//fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700',
        'theme.min',
        'custom',
    ], [
        'block' => 'css',
    ]);
}
