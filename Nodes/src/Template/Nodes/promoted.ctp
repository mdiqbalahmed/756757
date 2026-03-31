<?php

use Cake\Core\Configure;

$this->assign('title', 'Home');
$nodeTitle = Configure::read('Site.promoted_title_color');
$nodeBorder = Configure::read('Site.promoted_boder_color');
$siteTemplate = Configure::read('Site.template');
?>

<?php if ($siteTemplate == 2) { ?>

    <style>
        body {
            background: #fffcf5;
        }

        .node-excerpt {
            margin: unset;
            padding: unset;
            background-color: unset;
            box-shadow: unset;
            border-top: unset;
        }

        a {
            color: #0fb78d;
        }

        a:hover {
            color: #00a178;
        }

        .node_border {
            border-bottom: 1px solid #0fb78d;
        }

        .node_border:last-child {
            border-bottom: 0px solid #0fb78d;
        }
    </style>
    <?php foreach ($nodes as $node) :
        $this->Nodes->set($node);
    ?>
        <!-- <div class="untree_co-section py-3 pt-0 bg-img overlay" style="background-image: url('./webroot/uploads/classroom.png');"> -->
        <div class="node_border untree_co-section pt-5 overlay" style="background-color: #fffcf5 ;">
            <div class="container">
                <div class="align-items-center justify-content-center text-center">
                    <h2 class="text-white mb-3 aos-init" data-aos="fade-up" data-aos-delay="0"><?= $this->Html->link($this->Nodes->field('title'), $this->Nodes->field('url')->getUrl()) ?></h2>
                    <p class="text-white h5 aos-init" data-aos="fade-up" data-aos-delay="0">
                        <?php
                        echo $this->Nodes->info();
                        echo $this->Nodes->excerpt(['body' => true]);
                        echo $this->Nodes->moreInfo();
                        ?>
                    </p>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    ?>

<?php } else {  ?>

    <style>
        .nodes.promoted h5>a {
            color: <?= $nodeTitle ?>
        }

        .nodes.promoted .node-excerpt {
            border-top: 4px solid <?= $nodeBorder ?>;
        }
    </style>
    <div class="nodes promoted">
        <?php
        if (count($nodes) == 0) {
            echo __d('croogo', 'No items found.');
        }
        ?>

        <?php
        foreach ($nodes as $node) :
            $this->Nodes->set($node);
        ?>
            <div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">
                <h5><?= $this->Html->link($this->Nodes->field('title'), $this->Nodes->field('url')->getUrl()) ?></h5>
                <?php
                echo $this->Nodes->info();
                echo $this->Nodes->excerpt(['body' => true]);
                echo $this->Nodes->moreInfo();
                ?>
            </div>
        <?php
        endforeach;
        ?>
    </div>
<?php } ?>
