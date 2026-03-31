<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

$nodePerBox = Configure::read('Site.nodePerBox');
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);

$get_nodes = TableRegistry::getTableLocator()->get('nodes');
$nodes = $get_nodes->find()
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->where(['type' => 'notice'])
    ->where(['status' => 1])
    ->order(['publish_start' => 'DESC']) // Numerical sort using order "Numerical" value
    ->toArray();
?>
<?php if (!empty($nodes)) { ?>
    <h3 class="fxd_notice_gov"><a href="<?= $siteURL . $nodes[0]['type'] ?>">Notice Board</a></h3>
    <hr>
    <ul class="box_node_list">
        <?php
        $nodeCount = 0;
        foreach ($nodes as $node) {
            if ($node['type'] == 'notice') {
                if ($nodeCount < 5) { ?>
                    <li> <a href="<?= $siteURL . $node['type'] . '/' . $node['slug'] ?>"><?= $node['title'] ?></a></li>
        <?php $nodeCount++;
                } else {
                    break;
                }
            }
        } ?>
        <div class="text-right w-100 pr-3 fixed_notice_all">
            <a href="<?= $siteURL . $nodes[0]['type'] ?>">সবগুলো জানতে <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i> </a>
        </div>
    </ul>
<?php } else { ?>
    <h3 class="fxd_notice_gov">Notice Board</a></h3>
    <p style="color:red;">No Notice Found!</p>
<?php } ?>
