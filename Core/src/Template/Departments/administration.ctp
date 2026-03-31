<?php

use Cake\Core\Configure;

$headerColor = Configure::read('Menu.HeaderColor');
?>
<div class="untree_co-hero overlay" style="background-color:<?= $headerColor; ?>; height: 150px!important; min-height: 150px!important;">
</div>
<?php if (isset($profile)) { ?>
<div class="container my-5 ">
    <div class="row justify-content-between home_box">
        <div class="col-lg-7 mb-5">
            <h2 class="line-bottom mb-4 aos-init" data-aos="fade-up" data-aos-delay="0">Message from the <?= $profile['designation_name'] ?></h2>
            <p data-aos="fade-up" data-aos-delay="100" class="aos-init">
                <?= $profile['note'] ?>
                <br><br>
                <b><?= $profile['name'] ?></b><br>
                <?= $profile['degree'] ?><br>
                <?= $profile['designation_name'] ?>, <?= $profile['job_institute'] ?>
            </p>
        </div>
        <div class="col-lg-4 aos-init" data-aos="fade-up" data-aos-delay="400">
            <a href="<?= $profile['video_link'] ?>" data-fancybox="" class="video-wrap">
                <span class="play-wrap"><span class="icon-play"></span></span>
                <?php echo $this->Html->image("/webroot/uploads/employee_images/regularSize/" . $profile['image_name'], array("alt" => $profile['name'])); ?>
            </a>
        </div>
    </div>
</div>
<?php } else {?>
    <div id="search-error" class="container text-center text-light text-xl bg-danger p-5 my-5">No Role Found for the URL! Please Check your Submitted URL.</div>
<?php }?>
