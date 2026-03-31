<?php

use Cake\ORM\TableRegistry;

$get_photos = TableRegistry::getTableLocator()->get('cms_photos'); //Execute First
$photos = $get_photos->find()
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->order('cms_photos.photo_id ASC')
    ->join([
        'ap' => [
            'table' => 'cms_album',
            'type' => 'LEFT',
            'conditions' => ['ap.album_id = cms_photos.album_id'],
        ]
    ])
    ->where(['album_location' => 'slider'])
    ->toArray();
?>

<div class="custom_slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php foreach ($photos as $key => $photo) { ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $key ?>"></li>
            <?php } ?>
        </ol>
        <div class="carousel-inner">
            <?php foreach ($photos as $key => $photo) {
                if ($key == 0) { ?>
                    <div class="carousel-item active">
                        <?= $this->Html->image('/webroot/uploads/gallery/regularSize/' . $photo['regular_size'], ['alt' => $photo['photos_title'], 'class' => 'home_image d-block w-100', 'style' => 'height:242px']); ?>
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $photo['photos_title'] ?></h5>
                            <p><?= $photo['description'] ?></p>
                        </div>
                    </div>
                <?php  } else { ?>
                    <div class="carousel-item">
                        <?= $this->Html->image('/webroot/uploads/gallery/regularSize/' . $photo['regular_size'], ['alt' => $photo['photos_title'], 'class' => 'home_image d-block w-100', 'style' => 'height:242px']); ?>
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $photo['photos_title'] ?></h5>
                            <p><?= $photo['description'] ?></p>
                        </div>
                    </div>
            <?php }
            } ?>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
