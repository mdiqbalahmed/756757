<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

</head>

<body>
    <?php if (!isset($students)) { ?>

        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                    <?= __d('students', 'Monthly Attendance Report') ?>
                </h3>
            </div>
            <?php echo $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <fieldset>
                        <div class=" form_area p-2">
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="session_id" id="session_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($sessions as $session) { ?>
                                                    <option value="<?= $session['session_id']; ?>" <?php if ($active_session_id == $session['session_id']) {
                                                          echo 'Selected';
                                                      } ?>><?= $session['session_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Shift') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="shift_id" id="shift_id">

                                                <?php foreach ($shifts as $shift) { ?>
                                                    <option value="<?= $shift['shift_id']; ?>"><?= $shift['shift_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Class') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="level_id" id="level_id">
                                                <?php foreach ($levels as $level) { ?>
                                                    <option value="<?= $level['level_id']; ?>"><?= $level['level_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Section') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="section_id" id="section_id" required>
                                                <?php foreach ($sections as $section) { ?>
                                                    <option value="<?php echo $section['section_id']; ?>">
                                                        <?php echo $section['section_name']; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Start Date') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="start_date" type="date" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'End Date') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="end_date" type="date" class="form-control" required>
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
    <?php } ?>



    <?php if (isset($allStudents)) {
        // pr($value);
        // die;
        ?>

        <div class="row" style="margin-right: 25px;">
            <h5 style="text-align: center;"> Monthly Attendance Report </h5>
            <div class="report_meta">
                <p><b>Report Time : </b><?php echo date("l jS F, Y"); ?></p>
                <p><b>Date Between: </b><?php echo $value['start_date']; ?> To <?php echo $value['end_date']; ?></p>

            </div>
            <div class="report_title">
                <?php
                $output = array();

                if (!empty($session_name)) {
                    $output[] = 'Session: ' . $session_name;
                }

                if (!empty($shift_name)) {
                    $output[] = 'Shift: ' . $shift_name;
                }

                if (!empty($level_name)) {
                    $output[] = 'Class: ' . $level_name;
                }

                if (!empty($section_name)) {
                    $output[] = 'Section: ' . $section_name;
                }

                echo implode(', ', $output);
                ?>
            </div>



        </div>
        <div class="col-12">
            <div class="horizontal_scroll table-responsive-sm">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th><?= __d('students', 'Roll') ?></th>
                            <th><?= __d('students', 'Name') ?></th>
                            <th><?= __d('students', 'Present') ?></th>
                            <th><?= __d('students', 'Total Working Day') ?></th>
                            <th><?= __d('students', 'Percentage') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $number = -1;
                        foreach ($allStudents as $student) {
                            // pr($student);die;
                            $sumAttendence = array_sum($student['student']['attendence']);
                            if (!empty($sumAttendence)) {
                                $newPercentage = ($sumAttendence * 100) / $sumWorkingday;
                                $newPercentage = number_format($newPercentage, 2, '.', '');
                            }      //($sumWorkingday / 100) * $sumAttendence;
                            $number++;
                            ?>
                            <tr>
                                <td><?php echo $student['roll']; ?></td>
                                <td class="wide_cell"><?php echo $student['name']; ?></td>
                                <td style="text-align: center;"><?php echo $sumAttendence; ?></td>
                                <td style="text-align: center;"><?php echo $sumWorkingday; ?></td>
                                <td style="text-align: right;"><?php if (!empty($sumAttendence)) {
                                    echo $newPercentage . ' %';
                                } else {
                                    echo '0' . ' %';
                                } ?></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
        </div>


    <?php } ?>





</body>

</html>
<style>
    .report_title {
        font-size: 15px;
        font-family: Verdana,
            Arial,
            Helvetica,
            sans-serif;
        width: 85%;
        margin: 14px auto;
        border: 1px dashed #727070;
        padding: 5px;
        height: 60px;
        text-align: center;
    }

    .report_meta {
        margin-bottom: 10px;
        text-align: right;
        font-size: 10px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
    }
</style>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
    });


    function getSectionAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "shift_id": shift_id,
                "session_id": session_id,
                "type": 'attendance'
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["section_name"];
                    var id = data[i]["section_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#section_id').html(text1);
            }
        });
    }

    function confirmDelete() {
        return confirm("Are you sure you want to delete this file?");
    }
</script>