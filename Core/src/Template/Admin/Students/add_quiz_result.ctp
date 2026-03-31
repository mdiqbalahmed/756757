<?php

//Academic Information table => "scms_qualification"
$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('courses_cycle_id');
$this->Form->unlockField('term_cycle_id');
$this->Form->unlockField('term_course_cycle_part_id');
$this->Form->unlockField('scms_quiz_id');



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
                <?= __d('students', 'Add Quiz Marks') ?>
            </h3>
        </div>
        <?= $this->Form->create('', ['type' => 'file']); ?>
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
                                                <option value="<?php echo $session['session_id']; ?>"<?php if ($active_session_id == $session['session_id']) {
                                                       echo 'Selected';
                                                   } ?>>
                                                    <?php echo $session['session_name']; ?></option>
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
                                        <select class="form-control" name="level_id" id="level_id" required>
                                         
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
                                              <option value="<?php echo $section['section_id']; ?>"><?php echo $section['section_name']; ?> </option>
                                          <?php } ?>
                                      </select>
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
                                        <select class="form-control" name="courses_cycle_id" id="courses_cycle_id"
                                            required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Part') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="term_course_cycle_part_id"
                                            id="term_course_cycle_part_id" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Quiz') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="scms_quiz_id" id="scms_quiz_id">
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
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>

        </div>
        <?= $this->Form->end(); ?>

        <?php if (isset($students) || isset($scms_term_course_cycle_parts)) { ?>

            <table class=" display_table table table-hover mt-5">
                <tbody>
                    <tr>
                        <th>Session:</th>
                        <td><?= $head['session_name'] ?></td>
                        <th>Shifts:</th>
                        <td><?= $head['shift_name'] ?></td>
                        <th>Class:</th>
                        <td><?= $head['level_name'] ?></td>
                        <th>Section:</th>
                        <td><?= $head['section_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Term:</th>
                        <td><?= $head['term_name'] ?></td>
                        <th>Course:</th>
                        <td colspan="3">
                            <?= $head['course_name']['course_name'] . '(' . $head['course_name']['course_code'] . ')' . ' : ' . $head['course_name']['course_type_name'] ?>
                        </td>
                        <th>Part:</th>
                        <td><?= $head['part'] ?></td>
                    </tr>
                </tbody>
            </table>
            <?php
            $this->Form->unlockField('student_term_course_cycle_id');
            $this->Form->unlockField('quiz');
            $this->Form->unlockField('max_quiz_marks');

            ?>

            <?= $this->Form->create('', ['type' => 'file']); ?>
            <div class="input_result_table mt-10">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th><?= __d('students', 'ID') ?></th>
                            <th><?= __d('students', 'Roll') ?></th>
                            <th><?= __d('students', 'Name') ?></th>
                            <?php foreach ($quizs as $part) { ?>
                                <th>
                                    <?= $part['quiz_name'] . ' (' . round($part['marks'], 2) . ') '; ?>
                                </th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($students as $student) { ?>
                            <tr class="single_row">
                                <input name="student_term_course_cycle_id[<?= $student['student_term_course_cycle_id'] ?>]"
                                    type="hidden" class="" value='<?= $student['student_term_course_cycle_id'] ?>'>
                                <td><?= $student['sid'] ?></td>
                                <td><?= $student['roll'] ?></td>
                                <td><?= $student['name'] ?></td>
                                <?php foreach ($student['quiz'] as $part) { ?>
                                    <td>
                                        <input
                                            name="<?= 'quiz' . '[' . $part['scms_quiz_id'] . ']' . '[' . $student['student_term_course_cycle_id'] . '][]'; ?>"
                                            type="hidden" class="<?= $part['scms_quiz_id']; ?>"
                                            value="<?= $part['quiz_mark_id']; ?>" required="true">
                                        <input
                                            name="<?= 'quiz' . '[' . $part['scms_quiz_id'] . ']' . '[' . $student['student_term_course_cycle_id'] . '][]'; ?>"
                                            type="text" class="<?= $part['scms_quiz_id']; ?>" value="<?= $part['obtail_marks']; ?>"
                                            onchange="single_row(this)">
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
            </div>
            </table>

            <?php foreach ($quizs as $part) { ?>
                <input name="max_quiz_marks[]" type="hidden" class="max_quiz_marks-<?= $part['scms_quiz_id'] ?>"
                    value='<?= $part['marks'] ?>'>
            <?php } ?>

            <div class="mt-5">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    <?php } ?>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
    getTermAjax();
});
    $("#level_id").change(function () {
        getSectionAjax();
        getTermAjax();
        getQuizSubjectAjax();
        getPartType();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
        getTermAjax();
    });
    $("#session_id").change(function () {
        getTermAjax();
        getQuizSubjectAjax();
        getPartType();
    });
    $("#term_cycle_id").change(function () {
        getQuizSubjectAjax();
        getPartType();
    });
    $("#courses_cycle_id").change(function () {
        getPartType();
    });
    $("#term_course_cycle_part_id").change(function () {
        getQuizAjax();
    });
    $("#section_id").change(function () {
        getQuizSubjectAjax();
       getTermAjax();
    });

    function getSectionAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        if (level_id && shift_id) {
            $.ajax({
                url: 'getSectionAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "level_id": level_id,
                    "shift_id": shift_id,
                    "session_id": session_id,
                    "type": 'marks'
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

    }
    function getQuizSubjectAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        var term_cycle_id = $("#term_cycle_id").val();
        var section_id = $("#section_id").val();
        if (session_id && level_id && term_cycle_id && section_id) {
            $.ajax({
                url: 'getResultSubjectAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "session_id": session_id,
                    "level_id": level_id,
                    "term_cycle_id": term_cycle_id,
                    "section_id": section_id,
                    "type": 'marks'
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

    function getPartType() {
        var term_cycle_id = $("#term_cycle_id").val();
        var courses_cycle_id = $("#courses_cycle_id").val();
        if (term_cycle_id && courses_cycle_id) {
            $.ajax({
                url: 'getPartType',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "term_cycle_id": term_cycle_id,
                    "courses_cycle_id": courses_cycle_id
                },
                success: function (data) {
                    data = JSON.parse(data);
                    var text1 = '<option value="">-- Choose --</option>';
                    for (let i = 0; i < data.length; i++) {
                        var name = data[i]["term_course_cycle_part_type_name"];
                        var id = data[i]["term_course_cycle_part_id"];
                        text1 += '<option value="' + id + '" >' + name + '</option>';
                    }
                    $('#term_course_cycle_part_id').html(text1);


                }
            });
        }

    }

    function getTermAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        if (session_id && level_id) {
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

    }

    function getQuizAjax() {
        var term_course_cycle_part_id = $("#term_course_cycle_part_id").val();
        if (term_course_cycle_part_id) {
            $.ajax({
                url: 'getQuizAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "term_course_cycle_part_id": term_course_cycle_part_id,
                },
                success: function (data) {
                    data = JSON.parse(data);
                    var text1 = '<option value="">-- Choose --</option>';
                    for (let i = 0; i < data.length; i++) {
                        var name = data[i]["quiz_name"];
                        var id = data[i]["scms_quiz_id"];
                        text1 += '<option value="' + id + '" >' + name + '</option>';
                    }
                    $('#scms_quiz_id').html(text1);

                }
            });
        }

    }

    function single_row(value) {
        var main_class_name = value.className;
        var max_mark_class = '.max_quiz_marks-' + main_class_name;
        var max_mark = Number($(max_mark_class).val());
        var marks = Number(value.value);

        if (marks > max_mark) {
            var message = 'Marks can not be more than ' + Number(max_mark).toFixed(2);
            alert(message);
            value.value = null;
        }


    }

</script>