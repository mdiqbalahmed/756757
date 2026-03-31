<?php
// echo "<pre>";
// print_r($students);
// die;
?>

<style>
    .align_img {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: lightseagreen;
    }

    .card-title {
        font-size: 13px;
        text-transform: capitalize;
        font-weight: bold;
    }

    .card-text {
        font-size: 12px;
        line-height: 1.3;
        margin-bottom: 4px;
    }

    .card-body {
        padding: 0.75rem;
    }

    .student-photo {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }
</style>

<p class="mb-3">
    Hello <strong><?= h($students['name']) ?></strong>! Welcome to your Student Dashboard.
</p>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-3 shadow-sm border-0">
            <div class="row no-gutters">
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title">SID: <?= h($students['sid']) ?></h5>
                        <!--<p class="card-text">-->
                        <!--    Class: <?= h($students['level_id']) ?>-->
                        <!--</p>-->
                        <p class="card-text"> Mobile: <?= h($students['mobile']) ?></p>
                        <p class="card-text">
                            Present Address: <?= h($students['present_address']) ?>
                        </p>
                    </div>
                </div>
                <div class="col-4 align_img">
                    <?= $this->Html->image('/webroot/uploads/students/thumbnail/' . $students['thumbnail']) ?>
                </div>
            </div>
        </div>
    </div>
</div>