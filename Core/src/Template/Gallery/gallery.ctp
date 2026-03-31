<?php

use Cake\Core\Configure;
$siteTemplate = Configure::read('Site.template');
?>


<?php if($siteTemplate== 2){ ?>
<div class="container my-3">
<?php } else { ?>
<div >
<?php } ?>
<h4 class="content_title">গ্যালারি</h4>

<?php if (count($albums) == 0) : ?>
    <?php echo __('No album found.'); ?>
<?php else : ?>
    <div class="row">
        <?php foreach ($albums as $album) {
            if ($album['album_location'] != 'slider') {
                $path = $this->Url->image('/webroot/uploads/gallery/album/thumbnail/' . $album['thumbnail'] . '?album_id=' . $album['album_id']); ?>
                <style>
                    /* Basically for Showing the dynamic image change with the album thumbnail */
                    .img_area[data-album-id="<?php echo $album['album_id']; ?>"]::before {
                        background-image: url('<?= $path ?>');
                    }

                    .img_area[data-album-id="<?php echo $album['album_id']; ?>"]::after {
                        background-image: url('<?= $path ?>');
                    }
                </style>
                <div class="col-md-4 col-6">
                    <div class="gallery_area">
                        <div class="wrapper">
                            <a href="<?php echo $this->Url->build(['controller' => 'Gallery', 'action' => 'viewPhotos', $album['album_id']]); ?>">
                                <div class="img_area" data-album-id="<?php echo $album['album_id'] ?>" style="background-image: url('<?= $path ?>')"></div>
                            </a>
                        </div>
                        <div class="description mt-5">
                            <p class="text-center gallery_link">
                                <span class="gallery_link_title"><?= $album['album_title']; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
    </div>
<?php endif; ?>
<script>
    $("title").html("Gallery");
</script>
