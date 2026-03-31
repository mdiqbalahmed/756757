<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;

$this->assign('title', $node->title);
$this->Nodes->set($node);
$institute = Configure::read('Site.institute');
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);

$pageBanner = Configure::read('Site.pageBanner');
$defaultUrl = $siteURL . '/webroot' . $pageBanner;
$defaultImg = str_replace('\\', '/', $defaultUrl);
$siteTemplate = Configure::read('Site.template');
?>


<?php if ($siteTemplate == 2) { ?>
    <?php if ($this->Nodes->field('type') == 'page') {
        if (isset($node['linked_assets']['pageBanner'][0]->path)) {
            $pageAsset = $node['linked_assets']['pageBanner'][0]->path;
            $imageUrl = $siteURL . '/webroot' . $pageAsset;
            $imageLink = str_replace('\\', '/', $imageUrl);
        }
    ?>
        <div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">
            <?php
            if (isset($pageAsset)) { ?>
                <div class="untree_co-hero overlay" style="background-image: url('<?= $imageLink ?>'); height:450px;">
                <?php } else { ?>
                    <div class="untree_co-hero overlay" style="background-image: url('<?= $defaultImg ?>'); height:450px;">
                    <?php } ?>
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12">
                                <div class="row justify-content-left">
                                    <div class="col-lg-6 text-center text-lg-left">
                                        <h1 class="mb-4 heading text-white aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> <?= h($this->Nodes->field('title')) ?> </h1>
                                        <div class="mb-5 text-white desc mx- aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                            <p><?= $institute ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php
                    echo $this->Nodes->info();
                    echo $this->Nodes->body();
                    echo $this->Nodes->moreInfo();
                    ?>
            <?php } else { ?>
                <!-- <div class="untree_co-hero overlay" style="background-color:#184aad; height: 150px!important; min-height: 150px!important;"> -->
                </div>
                <div id="node-<?= $this->Nodes->field('id') ?>" class="container mt-5 node node-type-<?= $this->Nodes->field('type') ?>">
                    <h5><?= h($this->Nodes->field('title')) ?></h5>
                    <?php
                    echo $this->Nodes->info();
                    echo $this->Nodes->body();
                    echo $this->Nodes->moreInfo();
                    ?>
                </div>
            <?php } ?>

            <?php if (Plugin::isLoaded('Croogo/Comments')) : ?>
                <div id="comments" class="node-comments">
                    <?php
                    $type = $typesForLayout[$this->Nodes->field('type')];

                    if ($type->comment_status > 0 && $this->Nodes->field('comment_status') > 0) {
                        echo $this->cell('Croogo/Comments.Comments::node', [$node->id]);
                    }

                    if ($type->comment_status == 2 && $this->Nodes->field('comment_status') == 2) {
                        echo $this->cell('Croogo/Comments.Comments::commentFormNode', [
                            'entity' => $node,
                            'type' => $type
                        ]);
                    }
                    ?>
                </div>
            <?php endif ?>
        <?php } else { ?>
            <div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">
                <h5><?= h($this->Nodes->field('title')) ?></h5>
                <?php
                echo $this->Nodes->info();
                echo $this->Nodes->body();
                echo $this->Nodes->moreInfo();
                ?>
            </div>

            <?php if (Plugin::isLoaded('Croogo/Comments')) : ?>
                <div id="comments" class="node-comments">
                    <?php
                    $type = $typesForLayout[$this->Nodes->field('type')];

                    if ($type->comment_status > 0 && $this->Nodes->field('comment_status') > 0) {
                        echo $this->cell('Croogo/Comments.Comments::node', [$node->id]);
                    }

                    if ($type->comment_status == 2 && $this->Nodes->field('comment_status') == 2) {
                        echo $this->cell('Croogo/Comments.Comments::commentFormNode', [
                            'entity' => $node,
                            'type' => $type
                        ]);
                    }
                    ?>
                </div>
            <?php endif ?>
        <?php } ?>
