<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

$nodePerBox = Configure::read('Site.nodePerBox');
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);


$get_boxes = TableRegistry::getTableLocator()->get('cms_boxes');
$boxes = $get_boxes->find()
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->order(['CAST(box_order AS SIGNED)' => 'ASC']) //Numarical sort using order "Numarical" value
    ->toArray();

$get_blocks = TableRegistry::getTableLocator()->get('blocks');
$blocks = $get_blocks->find()
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->toArray();

$get_nodes = TableRegistry::getTableLocator()->get('nodes');
$nodes = $get_nodes->find()
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->where(['status' => 1])
    ->order(['publish_start' => 'DESC']) // Numerical sort using order "Numerical" value
    ->toArray();
?>

<div class="row px-2 box-node-row">
    <?php
    foreach ($blocks as $block) {
        $blockId = $block['id'];
        $blockAlias = $block['alias'];
        $blockTitle = ''; // Initialize block title variable

        // Find the corresponding block title from cms_boxes
        foreach ($boxes as $box) {
            $path = $this->Url->image('/webroot/uploads/cms/boxes/thumbnail/' . $box['box_image']);
            if ($box['block_id'] == $blockId) {
                $blockTitle = $box['box_title'];
                break; // Found the block title, no need to continue searching
            }
        }

        // If block title is found, display it
        if (!empty($blockTitle)) { ?>
            <div class="col-12 col-md-6 node_box mx-auto justify-content-start p-3 mb-3">
                <div class="row">
                    <h5 class="pl-3 mb-3" style="width:100%;"><?= $blockTitle ?></h5>
                    <div class="col-md-4 box_image_pos">
                        <?php
                        if ($box['box_image'] != null) { ?>
                            <img src="<?= $path ?>" alt="<?= $box['box_image'] ?>">
                        <?php } ?>
                    </div>
                    <div class="col-md-8 pl-0">
                        <ul class="box_node_list">
                            <?php
                            $nodeCount = 0;
                            foreach ($nodes as $node) {
                                if ($node['type'] == $blockAlias) {
                                    if ($nodeCount < $nodePerBox) { ?>
                                        <li> <a href="<?= $siteURL . $node['type'] . '/' . $node['slug'] ?>">
                                                <?= $node['title'] ?></a></li>
                            <?php $nodeCount++;
                                    } else {
                                        break;
                                    }
                                }
                            } ?>
                        </ul>

                    </div>
                    <div class="text-right w-100 pr-3 see_more_node">
                        <a href="<?= $siteURL . $block['alias'] ?>">সবগুলো জানতে <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i> </a>
                    </div>
                </div>
            </div>
    <?php    }
    }
    ?>
</div>
