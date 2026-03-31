<?php

use Cake\Core\Configure;

$HeaderBanner = Configure::read('Site.banner');
$institute = Configure::read('Site.institute');
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "view",
    "id" => "home",
]);

$this->assign('title', __d('croogo', 'Login'));

$formStart = $this->Form->create(false, ['type' => 'post'], ['url' => ['action' => 'login']]);
$body = $this->Form->input('username', [
    'placeholder' => __d('croogo', 'Username'),
    'label' => false,
    'prepend' => $this->Html->icon('user', ['class' => 'fa-fw']),
    'required' => true,
]);
$body .= $this->Form->input('password', [
    'placeholder' => __d('croogo', 'Password'),
    'label' => false,
    'prepend' => $this->Html->icon('key', ['class' => 'fa-fw']),
    'required' => true,
]);
if (Configure::read('Access Control.autoLoginDuration')) :
    $body .= $this->Form->input('remember', [
        'label' => __d('croogo', 'Remember me?'),
        'type' => 'checkbox',
        'default' => false,
    ]);
endif;

$footer = $this->Html->link(__d('croogo', 'Forgot password?'), [
    'prefix' => 'admin',
    'plugin' => 'Croogo/Users',
    'controller' => 'Users',
    'action' => 'forgot',
], [
    'class' => 'forgot',
]);
$footer .= $this->Form->button(__d('croogo', 'Log In'), ['class' => 'btn btn-primary']);
$formEnd = $this->Form->end();

?>

<div class="d-flex flex-column align-items-center py-4 ">
    <div class="mb-4">
        <a href="<?= $siteURL ?>">
            <?= $this->Html->image($HeaderBanner, [
                'alt' => $institute,
                'class' => 'img-fluid px-2',
                'style' => 'max-height:100px; filter: drop-shadow(0 0 3px rgba(255,255,255,0.6));'
            ]); ?>
        </a>
    </div>
    <div class="card rounded-plus bg-faded">
        <div class="card-header">
            <h5 class="card-title mb-0"><?= $this->fetch('title') ?></h5>
        </div>
        <?= $formStart ?>
        <div class="card-body">
            <?= $this->Layout->sessionFlash(); ?>
            <?= $body ?>
        </div>

        <div class="card-footer text-right">
            <?= $footer ?>
        </div>
        <?= $formEnd ?>
    </div>
</div>