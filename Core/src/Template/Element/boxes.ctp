<?php
use Cake\ORM\TableRegistry;

$get_boxes = TableRegistry::getTableLocator()->get('cms_boxes');
$boxes = $get_boxes->find()
    ->select([
        'box_per_row' => 'CF.box_per_row',
        'box_height' => 'CF.box_height',
    ])
    ->join([
        'CF' => [
            'table' => 'cms_page_config',
            'type' => 'LEFT',
            'conditions' => ['CF.node_page_id = cms_boxes.node_page_id'],
        ],
    ])
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->order(['CAST(box_order AS SIGNED)' => 'ASC']) //Numarical sort using order "Numarical" value
    ->toArray();
?>


<div class="row mb-5">
    <?php
    foreach ($boxes as $box) {
        if ($box['node_page_id'] == 0 && $box['status'] == 1) {
            $col = 12 / $box['box_per_row'];
            $path = $this->Url->image('/webroot/uploads/cms/boxes/thumbnail/' . $box['box_image']);
            $height = $box['box_height'] . "px";
            $URL = $box['url']; ?>
            <div class="col-md-<?= $col ?> col-6" style="height: <?= $height ?>; display: flex">

                <div class="box_area pb-3">
                    <a href="<?= $URL ?>" style="text-decoration: none; color: #222">
                        <?php
                        if ($box['box_image'] != null) { ?>
                            <div class="p-2 box_image">
                                <img src="<?= $path ?>" alt="<?= $box['box_image'] ?>">
                            </div>
                        <?php } ?>
                        <div class="title mt-2">
                            <h6 class="text-center gallery_link pt-2">
                                <span class="gallery_link_title"><?= $box['box_title']; ?>
                                </span>
                            </h6>
                            <p class="description">
                                <?= $box['box_description']; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
    <?php }
    }
    ?>
</div>