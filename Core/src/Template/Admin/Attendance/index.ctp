<?php

use Cake\Core\Configure;
$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('courses_cycle_id');
$this->Form->unlockField('term_cycle_id');
$this->Form->unlockField('date');
$attendance_type= Configure::read('Attendance.Type');

?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <title>Student Attendance Form</title>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                            <?= __d('attendance', 'Add Attendance') ?>
                </h3>
            </div>
                     <?php echo $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <fieldset>
                        <div class=" p-3">
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
                                                <option value="<?php echo $session['session_id']; ?>" <?php if ($active_session_id == $session['session_id']) {
                                                       echo 'Selected';
                                                   } ?>><?php echo $session['session_name']; ?></option>
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
                                            <select class="form-control" name="shift_id" id="shift_id" required>
                                             <?php foreach ($shifts as $shift) { ?>
                                                <option value="<?php echo $shift['shift_id']; ?>"><?php echo $shift['shift_name']; ?></option>
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
                                            <select class="form-control" name="level_id" id="level_id" required>
                                             <?php foreach ($levels as $level) { ?>
                                                <option value="<?php echo $level['level_id']; ?>"><?php echo $level['level_name']; ?></option>
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
                                              <option value="<?php echo $section['section_id']; ?>"><?php echo $section['section_name']; ?> </option>
                                          <?php } ?>
                                      </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Term') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="term_cycle_id" id="term_cycle_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                  <?php if($attendance_type != 'day') {?>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Course') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="courses_cycle_id" id="courses_cycle_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                  <?php } ?>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Date') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="date" type="date" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">

                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                        </div>
                                        <div class="col-lg-9 row2Field mt-5">
                                            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search Student') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </section>
            </div>
              <?php echo $this->Form->end(); ?>
        </div>


    <?php if (isset($students)) { ?>
        <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">
            
            <div class="row" style="margin-right: 25px;">
                <div class="report_meta">
                    <p><b>Report Time : </b><?php echo date("l jS F, Y"); ?></p>
                    <p><b>Date : </b><?php echo $value['start_date']; ?> <?php echo $request_data['date']; ?></p>

                </div>
                <div class="report_title">
                    <?php
                    $output = array();

                    if (!empty($head['session_name'])) {
                        $output[] = 'Session: ' . $head['session_name'];
                    }

                    if (!empty($head['shift_name'])) {
                        $output[] = 'Shift: ' . $head['shift_name'];
                    }

                    if (!empty($head['level_name'])) {
                        $output[] = 'Class: ' . $head['level_name'];
                    }

                    if (!empty($head['section_name'])) {
                        $output[] = 'Section: ' . $head['section_name'];
                    }

                    if (!empty($head['term_name'])) {
                        $output[] = 'Term: ' . $head['term_name'];
                    }

                    echo implode(', ', $output);
                    ?>
                </div>

            </div>


            <?php echo $this->Form->create(); ?>
            <?php

            $this->Form->unlockField('student_cycle_id');
            $this->Form->unlockField('session_id');
            $this->Form->unlockField('shift_id');
            $this->Form->unlockField('level_id');
            $this->Form->unlockField('section_id');
            $this->Form->unlockField('term_cycle_id');
            $this->Form->unlockField('user_id');
            $this->Form->unlockField('update');
            $this->Form->unlockField('sms');
            $this->Form->unlockField('date');
            $this->Form->unlockField('courses_cycle_id');
            ?>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Roll No.</th>
                        <th colspan="3"><input type="checkbox" class="check_all" id="check_all" name="" value="1">  All Present</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $update=null;
                    foreach ($students as $student) {
                        if($student['attendance']==1)$update=1 ?>
                    <tr style="padding: 10px;">
                        <td><?php echo $student['roll'];  ?></td>
                        <td colspan="3"> <input type="checkbox" class="checkbox_attend" id="checkbox" name="student_cycle_id[]" value="<?php echo $student['student_cycle_id'];  ?>"  <?php if($student['attendance']==1){echo 'checked';} ?>>
                        </td>
                        <td><?php echo $student['name']; ?></td>
                        
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
            <input type="hidden" class="hidden" id="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
            <input type="hidden" class="hidden" id="hidden" name="update" value="<?php echo $update; ?>">
            <input type="hidden" class="hidden" id="hidden" name="session_id" value="<?php echo $data['session_id'];  ?>">
            <input type="hidden" class="hidden" id="hidden" name="shift_id" value="<?php echo $data['shift_id'];  ?>">
            <input type="hidden" class="hidden" id="hidden" name="level_id" value="<?php echo $data['level_id'];  ?>">
            <input type="hidden" class="hidden" id="hidden" name="section_id" value="<?php echo $data['section_id'];  ?>">
            <input type="hidden" class="hidden" id="hidden" name="term_cycle_id" value="<?php echo $data['term_cycle_id'];  ?>">
            <input type="hidden" class="hidden" id="hidden" name="date" value="<?php echo $data['date'];  ?>">
            <input type="hidden" class="hidden" id="hidden" name="courses_cycle_id" value="<?php echo $data['courses_cycle_id'];  ?>">

            <div class="text-right mt-4 mb-4">
                <span style="margin-right:20px;"><input type="checkbox" class="sms" id="sms" name="sms" value="1">  Send SMS</span>
                <button type="submit" class="btn btn-info">Give Attendance</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    <?php } ?>


    </body>
</html>
<script>
    $(document).ready(function () {
        $("#check_all").click(function () {
            var checkBoxes = $(".checkbox_attend");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        });
        getTermAjax();
    })

    $("#level_id").change(function () {
        getSectionAjax();
        getTermAjax();
        getallSubjectAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
    });
    $("#session_id").change(function () {
        getTermAjax();
        getallSubjectAjax();
    });
    $("#term_cycle_id").change(function () {
        getallSubjectAjax();
    });
    $("#section_id").change(function () {
        getallSubjectAjax();
        getTermAjax();
    });

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        var session_id = $("#session_id").val();
        $.ajax({
            url: 'getAttendanceSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "shift_id": shift_id,
                "session_id": session_id
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

    
    function getallSubjectAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        var section_id = $("#section_id").val();
        var term_cycle_id = $("#term_cycle_id").val();
        if (session_id && level_id && section_id && term_cycle_id) {
            $.ajax({
                url: 'getAttandenceSubjectAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "session_id": session_id,
                    "level_id": level_id,
                    "term_cycle_id": term_cycle_id,
                    "section_id": section_id
                },
                success: function (data) {
                    data = JSON.parse(data);
                    var text1 = '<option value="">-- Choose --</option>';
                    for (let i = 0; i < data.length; i++) {
                        var name = data[i]["course_name"];
                        var id = data[i]["courses_cycle_id"];
                        text1 += '<option value="' + id + '" >' + name + '</option>';
                    }
                    $('#courses_cycle_id').html(text1);

                }
            });
        }

    }
    function getTermAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getTermAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "session_id": session_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["term_name"];
                    var id = data[i]["term_cycle_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#term_cycle_id').html(text1);

            }
        });
    }
</script>
<style>
    .report_title {
        font-size: 15px;
        font-family: Verdana,
            Arial,
            Helvetica,
            sans-serif;
        width: 85%;
        margin: 2px auto;
        border: 1px dashed #727070;
        padding: 15px;
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
