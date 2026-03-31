<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Croogo\Core\Nav;
use Croogo\Core\Utility\StringConverter;

$dashboardUrl = (new StringConverter())->linkStringToArray(
    Configure::read('Site.dashboard_url')
);
function getSettingsKey($key)
{
    $settingsTable = TableRegistry::getTableLocator()->get('settings');
    $keyValue = $settingsTable
        ->find()
        ->where(['`key`' => $key])
        ->toArray();

    return !empty($keyValue) ? $keyValue[0]['value'] : null;
}

// Get the SMS count value
$key = 'SMS.SMS_Credit';
$smsCredit = getSettingsKey('SMS.SMS_Credit');

?>

<header class="navbar navbar-expand-md navbar-dark bg-black fixed-top">
    <?= $this->Html->link(
        Configure::read('Site.title'),
        $dashboardUrl,
        ['class' => 'navbar-brand']
    ); ?>

    <?= $this->Croogo->adminMenus(Nav::items('top-left'), [
        'type' => 'dropdown',
        'htmlAttributes' => [
            'id' => 'top-left-menu',
            'class' => 'navbar-nav d-none d-sm-block mr-auto',
        ],
    ]); ?>

    <?php if ($this->getRequest()->getSession()->read('Auth.User.id')) : ?>
        <div class="navbar-nav ml-auto" style="margin-right: 15px;">
            <p style="font-size: 12px; font-weight: 600; margin-top: 1.25em;margin-right: 1em;">SMS Credit: <?= $smsCredit ?></p>
            <?php
            echo $this->Croogo->adminMenus(Nav::items('top-right'), [
                'type' => 'dropdown',
                'htmlAttributes' => [
                    'id' => 'top-right-menu',
                    'class' => 'navbar-nav',
                ],
            ]);
            ?>
        </div>
    <?php endif; ?>
</header>
