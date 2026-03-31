<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('timesheet_section_id');
$this->Form->unlockField('user_id');
?>
<!doctype html>
<html lang="en">
    <body>
        <div class="container">

            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                    <?= __d('Employee', 'Search Class Periode') ?>
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
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Periode') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="timesheet_section_id" id="timesheet_section_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Teacher') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="user_id" id="user_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($users as $user) { ?>
                                                <option value="<?= $user['user_id']; ?>"><?= $user['name']; ?></option>
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
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Start Class') ?></button>
            </div>
            <?php echo $this->Form->end(); ?>



        </div>


    </body>
</html>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
        getTimesheetSectionAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
        getTimesheetSectionAjax();
    });
    $("#section_id").change(function () {
        getTimesheetSectionAjax();
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

    function getTimesheetSectionAjax() {
        var session_id = $("#session_id").val();
        var section_id = $("#section_id").val();
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        $.ajax({
            url: 'getTimesheetSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "session_id": session_id,
                "section_id": section_id,
                "level_id": level_id,
                "shift_id": shift_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["course_name"] + '(' + data[i]["name"] + ')';
                    var id = data[i]["timesheet_section_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#timesheet_section_id').html(text1);
            }
        });
    }
</script>
