<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
?>
<!doctype html>
<html lang="en">
    <body>
        <div class="container">
              <?php if(!isset($days)) { ?>
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                    <?= __d('students', 'Search Section') ?>
                </h3>
            </div>
            <?php echo  $this->Form->create('', ['type' => 'file']); ?>
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
                                                <option value="<?= $session['session_id']; ?>"><?= $session['session_name']; ?></option>
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
                            </div>

                        </div>
                    </fieldset>
                </section>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
            <?php echo $this->Form->end(); ?>
              <?php }else{ ?>
            <div><h5 class="mb-4"><?= $head; ?></h5></div>
            <?php
$this->Form->unlockField('course');
$this->Form->unlockField('teacher');
$this->Form->unlockField('save');
$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('timesheet_section_id');
?>
             <?php echo  $this->Form->create('', ['type' => 'file']); ?>
            <input name="session_id" type="hidden" value="<?= $set_data['session_id']; ?>">
            <input name="shift_id" type="hidden" value="<?= $set_data['shift_id']; ?>">
            <input name="level_id" type="hidden" value="<?= $set_data['level_id']; ?>">
            <input name="section_id" type="hidden" value="<?= $set_data['section_id']; ?>">
            <input name="save" type="hidden" value="save">
            <div class="container">
               <?php foreach($days as $key => $day) {?>
                <h5 class="mt-3 mb-3">Day: <?= ucfirst($key); ?></h5>  
                               <div class="row">
                  <?php foreach($day['timesheets'] as $key => $single) {?>
                    <div class="col-md-4 col-sm-6">
                        <div class="mt-3"><b>Time: <?= $single['in_time']; ?> TO <?= $single['out_time']; ?></b>  <input type="button" id="<?= $day['name'].'-'.$single['scms_timesheet_id']; ?>" onclick="add_more(this)" class="add_more" value="Add More"></div>
                        <div id="single" class="base_<?= $day['name'].'-'.$single['scms_timesheet_id']; ?>">
                             <?php if(count($single['previous_section_timesheet'])) { ?>
                             <?php foreach($single['previous_section_timesheet'] as $key => $previous_section_timesheet) {?>
                               <input name="timesheet_section_id[<?= $day['name']; ?>][<?= $single['scms_timesheet_id']; ?>][]" type="hidden" value="<?= $previous_section_timesheet['timesheet_section_id']; ?>">
                            <select class="form-control mt-2" name="course[<?= $day['name']; ?>][<?= $single['scms_timesheet_id']; ?>][]" id="course_id">
                                <option value=""><?= __d('students', 'Choose Course') ?></option>
                                                <?php foreach ($courses as $course) { ?>
                                <option value="<?= $course['course_id']; ?>"   <?php if($course['course_id']==$previous_section_timesheet['course_id']){echo 'selected';} ?>><?= $course['course_name']; ?></option>
                                                <?php } ?>
                            </select>
                            <select class="form-control mt-2" name="teacher[<?= $day['name']; ?>][<?= $single['scms_timesheet_id']; ?>][]" id="teacher_id">
                                <option value=""><?= __d('students', 'Choose Teacher') ?></option>
                                                <?php foreach ($users as $user) { ?>
                                <option value="<?= $user['employee_id']; ?>"  <?php if($user['employee_id']==$previous_section_timesheet['employee_id']){echo 'selected';} ?>><?= $user['name']; ?></option>
                                                <?php } ?>
                            </select>
                             <?php } ?>
                             <?php } else  { ?>
                            <select class="form-control mt-2" name="course[<?= $day['name']; ?>][<?= $single['scms_timesheet_id']; ?>][]" id="course_id">
                                <option value=""><?= __d('students', 'Choose Course') ?></option>
                                                <?php foreach ($courses as $course) { ?>
                                <option value="<?= $course['course_id']; ?>"><?= $course['course_name']; ?></option>
                                                <?php } ?>
                            </select>
                            <select class="form-control mt-2" name="teacher[<?= $day['name']; ?>][<?= $single['scms_timesheet_id']; ?>][]" id="teacher_id">
                                <option value=""><?= __d('students', 'Choose Teacher') ?></option>
                                                <?php foreach ($users as $user) { ?>
                                <option value="<?= $user['employee_id']; ?>"><?= $user['name']; ?></option>
                                                <?php } ?>
                            </select>
                             <?php } ?>

                        </div>
                    </div>

                  <?php } ?>
                </div>
                
               
               <?php } ?>
            </div>
            <div class="mt-3" style="">
                <button type="submit" class="btn btn-info pull_right"><?= __d('setup', 'Save') ?></button>
            </div>
            <?php echo $this->Form->end(); ?>
            <?php } ?>
        </div>

        <div class="hidden" id="block">
            <div id="single">
                <select class="form-control mt-2" name="course[d_name][timesheet][]" id="course_id">
                    <option value=""><?= __d('students', 'Choose Course') ?></option>
                                                <?php foreach ($courses as $course) { ?>
                    <option value="<?= $course['course_id']; ?>"><?= $course['course_name']; ?></option>
                                                <?php } ?>
                </select>
                <select class="form-control mt-2" name="teacher[d_name][timesheet][]" id="teacher_id">
                    <option value=""><?= __d('students', 'Choose Teacher') ?></option>
                                                <?php foreach ($users as $user) { ?>
                    <option value="<?= $user['employee_id']; ?>"><?= $user['name']; ?></option>
                                                <?php } ?>
                </select>
            </div>
        </div>
    </body>
</html>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
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
    var block = $("#block").html();
    function add_more(value) {
        var text=value.id;
        var fields = text.split('-');
        console.log(fields);
        block1 = block.replace("timesheet", fields[1]);
        block2 = block1.replace("timesheet", fields[1]);
         block3 = block2.replace("d_name", fields[0]);
        block4 = block3.replace("d_name", fields[0]);
        var id = '.base_' + value.id;
        $(id).append(block4);
    }
</script>
