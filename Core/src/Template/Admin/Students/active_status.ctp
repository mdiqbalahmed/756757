<?php

$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');


$formattedStartDate = date('F j, Y', strtotime($data['start_date']));
$formattedEndDate = date('F j, Y', strtotime($data['end_date']));




?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Student</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Search Logs') ?>
            </h3>
        </div>
        <?php echo $this->Form->create(); ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto" action="#">
                <fieldset>
                    <div class=" form_area p-2" style="height: auto; width: 1000px;">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Start Date') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="start_date" type="date" class="form-control" value="<?php if (isset($data['start_date'])) {
                                                                                                                echo $data['start_date'];
                                                                                                            } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'End Date') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="end_date" type="date" class="form-control" value="<?php if (isset($data['end_date'])) {
                                                                                                            echo $data['end_date'];
                                                                                                        } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </section>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>


    <?php if (isset($students)) { ?>
        <div class="rows">
            <h3 class="text-center"><?= __d('Certificates', 'Logs') ?></h3>

            <p class="date-range">
                Date Range:
                <span><?php echo h($formattedStartDate); ?></span>
                to
                <span><?php echo h($formattedEndDate); ?></span>
            </p>
        </div>


        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('Certificates', 'SL') ?></th>
                        <th><?= __d('Certificates', 'Total Students') ?></th>
                        <th><?= __d('Certificates', 'Date') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl = 1;
                    foreach ($students as $value) {
                    ?>
                        <tr>
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo $value['total_students'] ?></td>
                            <td><?php echo $value['date'] ?></td>
                        </tr>
                <?php }
                } ?>

                </tbody>
            </table>
        </div>


</body>

</html>
<style>
    .date-range {
        margin-left: 300px;
        font-size: 16px;
        color: #333;
        font-weight: bold;
        text-align: center;
        border: 2px solid #0089ff4f;
        padding: 10px;
        border-radius: 5px;
        display: inline-block;
    }

    .date-range span {
        border-bottom: 1px solid #04010e;
        padding: 0 5px;
    }
</style>