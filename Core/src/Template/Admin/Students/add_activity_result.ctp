<?php

//Academic Information table => "scms_qualification"
$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('term_cycle_id');
$this->Form->unlockField('term_activity_cycle_id');



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
                            <?= __d('students', 'Add Activity') ?>
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
                                                <option value="<?=  $session['session_id']; ?>"><?=  $session['session_name']; ?></option>
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
                                                <option value="<?= $shift['shift_id']; ?>"><?= $shift['shift_name']; ?></option>
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
                                                <option value="<?= $level['level_id']; ?>"><?= $level['level_name']; ?></option>
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
                                            <p class="label-font13"><?= __d('students', 'Activity') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="term_activity_cycle_id" id="term_activity_cycle_id" required>
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

                     <?php if(isset($students) )  { ?>

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
                        <th>Activity Name:</th>
                        <td><?= $head['activity_name'] ?></td>
                    </tr>
                </tbody>
            </table>
 <?php 
$this->Form->unlockField('student_term_cycle_id');
$this->Form->unlockField('comment');
$this->Form->unlockField('remark_id');
$this->Form->unlockField('term_activity_cycle_id');
$this->Form->unlockField('update');
?>

        <?= $this->Form->create('', ['type' => 'file']); ?>
            <input name="term_activity_cycle_id" type="hidden" class="" value='<?= $term_activity_cycle['term_activity_cycle_id'] ?>'>
            <input name="update" type="hidden" class="" value='<?= $update ?>'> 

            <div class="input_result_table mt-10">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th><?= __d('students', 'ID') ?></th>
                            <th><?= __d('students', 'Roll') ?></th>
                            <th><?= __d('students', 'Name') ?></th>
                             <?php if($activity_remark)  { ?>
                            <th><?= __d('students', 'Remark') ?></th>
                             <?php } ?>
                            <th><?= __d('students', 'Comment') ?></th>

                        </tr>
                    </thead>

                    <tbody>
		       <?php foreach ($students as $student) { ?>
                        <tr class="single_row">
                    <input name="student_term_cycle_id[<?= $student['student_term_cycle_id'] ?>]" type="hidden" class="" value='<?= $student['student_term_cycle_id'] ?>'>
                    <td><?= $student['sid'] ?></td>
                    <td><?= $student['roll'] ?></td>
                    <td><?= $student['name'] ?></td>
                             <?php if($activity_remark)  { ?>
                    <td>
                        <select id=""  class="form-select option-class"name="<?=  'remark_id'.'['.$student['student_term_cycle_id'].'][]'; ?>" <?php if($multiple){echo 'multiple="multiple"';} ?>  style="width: 350px;">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($student['activity_remark'] as $remark) { ?>
                            <option value="<?php echo $remark['activity_remark_id']; ?>" <?php if ($remark['is_default']) { echo 'Selected'; } ?>><?php echo $remark['remark_name']; ?></option>
					<?php } ?>
                        </select>
                             <?php } ?>
                    </td>
                    <td>
                        <textarea name="<?=  'comment'.'['.$student['student_term_cycle_id'].']'; ?>" class="form-control" rows="2"><?php echo$student['comment']; ?></textarea>
                    </td>

                    </tr>
	               <?php } ?>
                    </tbody>
            </div>
        </table>

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
    $("#level_id").change(function () {
        getSectionAjax();
        getTermAjax();
        getActivityAjax();

    });
    $("#shift_id").change(function () {
        getSectionAjax();
    });
    $("#session_id").change(function () {
        getTermAjax();
        getActivityAjax();

    });
    $("#term_cycle_id").change(function () {
        getActivityAjax();
    });



    function getSectionAjax() {
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

    }

    function getActivityAjax() {
        var level_id = $("#level_id").val();
        var session_id = $("#session_id").val();
        var term_cycle_id = $("#term_cycle_id").val();
        if (level_id && session_id && term_cycle_id) {
            $.ajax({
                url: 'getActivityAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "level_id": level_id,
                    "session_id": session_id,
                    "term_cycle_id": term_cycle_id
                },
                success: function (data) {
                    data = JSON.parse(data);
                    var text1 = '<option value="">-- Choose --</option>';
                    for (let i = 0; i < data.length; i++) {
                        var name = data[i]["activity_name"];
                        var id = data[i]["term_activity_cycle_id"];
                        text1 += '<option value="' + id + '" >' + name + '</option>';
                    }
                    $('#term_activity_cycle_id').html(text1);

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


</script>


