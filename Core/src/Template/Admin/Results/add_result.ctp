<?php

//Academic Information table => "scms_qualification"
$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('courses_cycle_id');
$this->Form->unlockField('term_cycle_id');

?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <title>Student Registration Form</title>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Add Result') ?>
                </h3>
            </div>
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-2"><?= __d('students', "Search Student") ?></legend>
                        <div class="form_area p-3">
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
                                                <option value="<?php echo $session['session_id']; ?>"><?php echo $session['session_name']; ?></option>
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
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
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
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
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
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
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
                            </div>
                        </div>
                    </fieldset>
                </section>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
            </div>
        </div>

    <?php if (isset($students) && isset($scms_term_course_cycle_parts)) {
        $this->Form->unlockField('student_term_course_cycle_id');
        $this->Form->unlockField('mark');
         $this->Form->unlockField('max_marks');
    ?>

        <?php echo $this->Form->create('', ['type' => 'file']); ?>
        <div class="input_result_table mt-10">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <?php if (count($students) > 0) { ?>
                        <th><?= __d('students', 'ID') ?></th>
                        <th><?= __d('students', 'Roll') ?></th>
                        <th><?= __d('students', 'Name') ?></th>
                        <?php } ?>
                        <?php foreach ($scms_term_course_cycle_parts as $part) { ?>
                        <th>
                                <?php echo  $part['term_course_cycle_part_type_name'] . ' (' . round($part['mark'], 2) . ') '; ?>
                                <?php if ($part['term_course_cycle_part_type_id'] != 9999) { ?>
                            <input type="text" id="<?php echo $part['term_course_cycle_part_type_name'] . '_persentage'; ?>">
                                <?php } ?>
                        </th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($students as $student) { ?>
                    <tr class="single_row">
                <input name="student_term_course_cycle_id[<?php echo $student['student_term_course_cycle_id'] ?>]" type="hidden" class="" value='<?php echo $student['student_term_course_cycle_id'] ?>'>
                <td><?php echo $student['sid'] ?></td>
                <td><?php echo $student['roll'] ?></td>
                <td><?php echo $student['name'] ?></td>
                            <?php foreach ($student['mark'] as $part) { ?>
                <td>
                    <input name="<?php echo  'mark' . '[' . $student['student_term_course_cycle_id'] . ']' . '[' . $part['term_course_cycle_part_id'] . '][' . $part['term_course_cycle_part_mark_id'] . ']'; ?>" type="text" class="<?php echo $part['term_course_cycle_part_type_name']; ?>" value="<?php echo $part['obtail_marks']; ?>" required="true" <?php if ($part['term_course_cycle_part_type_id'] == 9999) { ?> readonly="true" <?php } ?> onchange="single_row(this)">
                                    <?php if ($part['partable'] == "Yes") { ?><b><?php echo $part['quiz_marks'] ?><b> <?php } ?>
                            </td>
                            <?php } ?>
                            </tr>
                    <?php } ?>
                            </tbody>



                            </div>
                            </table>

                                    <?php foreach ($scms_term_course_cycle_parts as $part) { ?>
                            <input name="max_marks[<?php echo $part['term_course_cycle_part_type_name'] ?>]" type="text" class="max_marks-<?php echo $part['term_course_cycle_part_type_name']?>" value='<?php echo $part['mark'] ?>'>
                               <?php } ?>

                            <div class="mt-5">
                                <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>

                            </div>
                            </div>
                                        <?php echo $this->Form->end(); ?>
    <?php } ?>


                            </body>

                            </html>
                            <script>
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

                                function getSectionAjax() {
                                    var level_id = $("#level_id").val();
                                    var shift_id = $("#shift_id").val();
                                    $.ajax({
                                        url: 'getSectionAjax',
                                        cache: false,
                                        type: 'GET',
                                        dataType: 'HTML',
                                        data: {
                                            "level_id": level_id,
                                            "shift_id": shift_id
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
                                    var term_cycle_id = $("#term_cycle_id").val();
                                    $.ajax({
                                        url: 'getallSubjectAjax',
                                        cache: false,
                                        type: 'GET',
                                        dataType: 'HTML',
                                        data: {
                                            "session_id": session_id,
                                            "level_id": level_id,
                                            "term_cycle_id": term_cycle_id
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

                                function single_row(value) {
                                    var main_class_name = value.className;
                                    var max_mark_class = '.max_marks-' + main_class_name;
                                    var max_mark = $(max_mark_class).val();
                                    var marks = value.value;
                                    if (marks > max_mark) {
                                        var message=main_class_name+' marks can not be more than '+Number(max_mark).toFixed(2); 
                                        alert(message);
                                        value.value = null;
                                    }
                                    var total = 0;
                                    var single_row = value.closest('.single_row');

                                    var child_1 = single_row.childNodes;
                                    var count = child_1.length;
                                    for (var i = 1; i <= count; i++) {
                                        var child_2 = child_1[i].childNodes;
                                        var count_2 = child_2.length;
                                        if (count_2 >= 3) {
                                            var value1 = child_2[1].value;
                                            var class_name = child_2[1].className;
                                            var persentage = "#" + class_name + "_persentage";
                                            var persentage_value = $(persentage).val();
                                            if (persentage_value == undefined) {
                                                child_2[1].value = total;
                                            } else {
                                                if (persentage_value.length === 0) {
                                                    total = total * 1 + value1 * 1;
                                                } else {
                                                    if (class_name == main_class_name) {
                                                        child_2[1].value = (value1 * (persentage_value)) / 100;
                                                        total = total * 1 + (value1 * (persentage_value)) / 100;
                                                    } else {
                                                        total = total * 1 + value1 * 1;
                                                    }


                                                }
                                            }
                                        }
                                    }
                                }
                            </script>