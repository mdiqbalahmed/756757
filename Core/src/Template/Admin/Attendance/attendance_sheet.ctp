<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('month');


$session_id = isset($session_id) ? $session_id : '';
$shift_id = isset($shift_id) ? $shift_id : '';
$level_id = isset($level_id) ? $level_id : '';
$section_id = isset($section_id) ? $section_id : '';
$month = isset($month) ? $month : '';
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
                <?= __d('students', 'Attendance Sheet') ?>
            </h3>
        </div>
        <?php echo  $this->Form->create(); ?>
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
                                            <option value="">
                                                <?= __d('accounts', '-- Choose --') ?>
                                            </option>
                                            <?php foreach ($sessions as $session) { ?>
                                                <option value="<?php echo $session['session_id']; ?>" <?php if ($data['session_id'] == $session['session_id']) {
                                                                                                            echo 'Selected';
                                                                                                        } ?>><?php echo $session['session_name']; ?> </option>
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
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($shifts as $shift) { ?>
                                                <option value="<?php echo $shift['shift_id']; ?>" <?php if ($data['shift_id'] == $shift['shift_id']) {
                                                                                                        echo 'Selected';
                                                                                                    } ?>><?php echo $shift['shift_name']; ?> </option>
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
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                                                <option value="<?php echo $level['level_id']; ?>" <?php if ($data['level_id'] == $level['level_id']) {
                                                                                                        echo 'Selected';
                                                                                                    } ?>><?php echo $level['level_name']; ?>
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
                                        <select class="form-control" name="section_id" id="section_id">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($sections as $section) { ?>
                                                <option value="<?php echo $section['section_id']; ?>" <?php if ($data['section_id'] == $section['section_id']) {
                                                                                                            echo 'Selected';
                                                                                                        } ?>><?php echo $section['section_name']; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Month') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="month">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($months as $month) { ?>
                                                <option value="<?php echo $month['name']; ?>" <?php if ($data['month'] == $month['name']) {
                                                                                                    echo 'Selected';
                                                                                                } ?>><?php echo $month['name']; ?> </option>
                                            <?php } ?>
                                        </select>
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
        <h5 style="text-align: center;"> Attendance Sheet Of <?php echo $value['month']; ?> Month </h5>




        <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px; overflow-x:auto;">

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <?php foreach ($dates as $key => $date) { ?>
                            <th style="text-align: center;"> <?php echo $date; ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student) { ?>
                        <tr>
                            <td style="font-size: 13px;"><?php echo $student['name']; ?></td>
                            <?php foreach ($student['attandances'] as $key => $attandance) { ?>
                                <td style=" text-align: center; color: <?php if ($attandance == "A") {
                                                                            echo "red";
                                                                        } ?>;"> <?php echo $attandance; ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="font-size: 13px;">Total</td>
                        <?php foreach ($total_attendance as $key => $total) { ?>
                            <td>
                                <p style="color:green;">Present : <?php echo $total['present']; ?></p>
                                <p style="color:red;">Absent : <?php echo $total['absent']; ?></p>

                            </td>
                        <?php } ?>
                    </tr>


                </tbody>
            </table>

        </div>
    <?php } ?>





</body>

</html>
<style>
    .report_title {
        font-size: 11px;
        font-family: Verdana,
            Arial,
            Helvetica,
            sans-serif;
        width: 85%;
        margin: 14px auto;
        border: 1px dashed #727070;
        padding: 5px;
        height: 119px;
    }
</style>
<script>
    $("#level_id").change(function() {
        getSectionAjax();
    });

    $("#shift_id").change(function() {
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