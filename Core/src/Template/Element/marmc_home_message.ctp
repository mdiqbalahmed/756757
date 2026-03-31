<?php

use Cake\ORM\TableRegistry;

$getProfile = TableRegistry::getTableLocator()->get('employee');
$profiles = $getProfile->find()
    ->enableAutoFields(true)
    ->enableHydration(false)
    ->where(['featured' => 1])
    ->where(['status' => 1])
    ->order(['employee_order' => 'ASC'])
    ->select([
        'designation_name' => "d.name",
        'department_name' => "dpt.department_name",
        'status' => "u.status",
        'role_slug' => "role.alias",
    ])
    ->join([
        'd' => [
            'table' => 'employees_designation',
            'type' => 'LEFT',
            'conditions' => [
                'd.id = employee.employees_designation_id '
            ]
        ],
        'dpt' => [
            'table' => 'scms_departments',
            'type' => 'LEFT',
            'conditions' => [
                'dpt.department_id  = employee.department_id'
            ]
        ],
        'u' => [
            'table' => 'users',
            'type' => 'LEFT',
            'conditions' => ['u.id = employee.user_id '],
        ],
        'role' => [
            'table' => 'roles',
            'type' => 'LEFT',
            'conditions' => ['role.id = u.role_id '],
        ],
    ])
    ->toArray();
?>

<?php if ($profiles != array()) { ?>
    <div id="carouselHomeMSG" class="carousel slide" data-ride="carousel">
        <?php
        $numberOfEmployees = count($profiles);
        echo '<ol class="carousel-indicators carousel_home">';
        // Use a loop to generate the <li> elements dynamically
        for ($i = 0; $i < $numberOfEmployees; $i++) {
            $activeClass = ($i === 0) ? 'class="active"' : ''; // Add 'active' class to the first indicator
            echo '<li data-target="#carouselHomeMSG" data-slide-to="' . $i . '" ' . $activeClass . '></li>';
        }
        echo '</ol>';
        ?>

        <div class="carousel-inner">
            <?php foreach ($profiles as $profile) { ?>
                <div class="carousel-item pad5rem">
                    <div class="container outerShadow">
                        <div class="row justify-content-between home_box">
                            <div class="col-lg-7 mb-5">
                                <h2 class="line-bottom mb-4 aos-init" data-aos="fade-up" data-aos-delay="0">Message from the <?= $profile['designation_name'] ?></h2>
                                <p data-aos="fade-up" data-aos-delay="100" class="aos-init">

                                    <?php
                                    $maxLength = 500; // Set your preferred character limit
                                    $note = $profile['note'];
                                    $displayMSG = (strlen($note) > $maxLength) ? substr($note, 0, strrpos(substr($note, 0, $maxLength), ' ')) . ' ...' : $note;
                                    ?>
                                    <?= $displayMSG ?>
                                    <br><br>
                                    <b><?= $profile['name'] ?></b><br>
                                    <?= $profile['degree'] ?><br>
                                    <?= $profile['designation_name'] ?>, <?= $profile['job_institute'] ?>
                                </p>
                                <p data-aos="fade-up" data-aos-delay="200" class="aos-init">
                                    <a href="administration/<?= $profile['role_slug'] ?>" class="btn btn-outline-primary">Learn More</a>
                                </p>
                            </div>
                            <div class="col-lg-4 aos-init" data-aos="fade-up" data-aos-delay="400">
                                <a href="<?= $profile['video_link'] ?>" data-fancybox="" class="video-wrap">
                                    <span class="play-wrap"><span class="icon-play"></span></span>
                                    <?php echo $this->Html->image("/webroot/uploads/employee_images/regularSize/" . $profile['image_name'], array("alt" => $profile['name'])); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
        <a class="carousel-control-prev" href="#carouselHomeMSG" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselHomeMSG" role="button" data-slide="next">
            <span class="carousel-control-next-icon " aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
<?php } ?>
<script>
    $(document).ready(function() {
        $(".carousel-inner .pad5rem:first-child").addClass("active");
    });
</script>


