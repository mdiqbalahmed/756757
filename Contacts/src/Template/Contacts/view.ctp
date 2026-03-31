<?php

use Cake\Core\Configure;

$contactAddress = Configure::read('Widget.contactAddress'); //Case Sensitive
$mapIframe = Configure::read('Widget.mapIframe');
$contactInfoBg = Configure::read('Widget.contactInfoBg');
$siteTemplate = Configure::read('Site.template');
?>
<?php if ($siteTemplate == 2) { ?>
    <style>
        .contact_img {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div id="contact-<?= $contact['id'] ?>" class="">
                    <h2 class="mb-4"><?= $contact->title ?></h2>

                    <?php if ($contact->message_status) : ?>
                        <div class="contact-form ml-3">
                            <?php
                            echo $this->Form->create($message);

                            echo $this->Form->input('name', ['label' => __d('croogo', 'Your name')]);
                            echo $this->Form->input('email', ['label' => __d('croogo', 'Your email')]);
                            echo $this->Form->input('title', ['label' => __d('croogo', 'Subject')]);
                            echo $this->Form->input('body', ['label' => __d('croogo', 'Message')]);

                            echo $this->Recaptcha->display();
                            echo $this->Form->hidden('recaptcha', ['value' => 'notempty']);
                            echo $this->Form->submit();
                            echo $this->Form->end();
                            ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-6 contact_img">
                <?= $this->Html->image('/webroot/uploads/contact_us.png', ["width" => "70%"]); ?>
            </div>
        </div>

        <h2 class="mt-5 display-5 text-center">Find Us</h2>
        <div class="row mt-4 mb-5 p-4 contactDetails" style="background-color: <?= $contactInfoBg ?>;">
            <div class="col-md-5 contactAddress"><?= $contactAddress ?></div>
            <div class="col-md-7 contactMap">
                <?= $mapIframe ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="contact-<?= $contact['id'] ?>" class="">
        <h2><?= $contact->title ?></h2>
        <?php if ($contact->message_status) : ?>
            <div class="contact-form">
                <?php
                echo $this->Form->create($message);
                echo $this->Form->input('name', ['label' => __d('croogo', 'Your name')]);
                echo $this->Form->input('email', ['label' => __d('croogo', 'Your email')]);
                echo $this->Form->input('title', ['label' => __d('croogo', 'Subject')]);
                echo $this->Form->input('body', ['label' => __d('croogo', 'Message')]);
                echo $this->Recaptcha->display();
                echo $this->Form->hidden('recaptcha', ['value' => 'notempty']);
                echo $this->Form->submit();
                echo $this->Form->end();
                ?>
            </div>
        <?php endif ?>
    </div>

    <h2 class="mt-5 display-5 text-center">Find Us</h2>
    <div class="row mt-4 mb-5 contactDetails" style="background-color: <?= $contactInfoBg ?>;">
        <div class="col-md-5 contactAddress"><?= $contactAddress ?></div>
        <div class="col-md-7 contactMap">
            <?= $mapIframe ?>
        </div>
    </div>
<?php } ?>
