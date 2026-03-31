<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission</title>
</head>

<body>
    <div class="rows">
        <h3 class="text-center"><?= __d('employees', 'Set Permission for ') ?> <?= $employee['name'] ?></h3>
    </div>
    <?php if (!isset($data)) { ?>
        <?php
        $this->Form->unlockField('department_id');
        $this->Form->unlockField('session_id');
        $this->Form->unlockField('level_id');
        ?>
        <section class="container">
            <?php echo $this->Form->create(); ?>

            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <label for="inputSId"
                                class="Xlabel-height form-label"><?= __d('employees', 'Department') ?></label>
                        </div>
                        <div class="col-md-8">
                            <select id="inputState" class="form-select option-class dropdown260" name="department_id"
                                required>
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?php echo $department['department_id']; ?>">
                                        <?php echo $department['department_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <label for="inputSId"
                                class="Xlabel-height form-label"><?= __d('employees', 'Session') ?></label>
                        </div>
                        <div class="col-md-8">
                            <select id="inputState" class="form-select option-class dropdown260" name="session_id" required>
                                <option value="">Choose Option</option>
                                <?php foreach ($sessions as $session) { ?>
                                    <option value="<?php echo $session['session_id']; ?>">
                                        <?php echo $session['session_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>



                <div class="col-md-6 mt-3">
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <label for="inputSId" class="Xlabel-height form-label"><?= __d('employees', 'Level') ?></label>
                        </div>
                        <div class="col-md-8">
                            <select id="inputState" class="form-select option-class dropdown260" name="level_id" required>
                                <option value="">Choose Option</option>
                                <?php foreach ($levels as $level) { ?>
                                    <option value="<?php echo $level['level_id']; ?>">
                                        <?php echo $level['level_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-right mt-2">
                <button type="submit" class="btn btn-info"><?= __d('gradings', 'Submit') ?></button>
            </div>
            <?php echo $this->Form->end(); ?>
        </section>
    <?php } else { ?>
        <?php
        $this->Form->unlockField('department_id');
        $this->Form->unlockField('session_id');
        $this->Form->unlockField('level_id');
        $this->Form->unlockField('slug');
        $this->Form->unlockField('type');
        $this->Form->unlockField('saved');
        $this->Form->unlockField('section');
        $this->Form->unlockField('course');
        ?>
        <?php echo $this->Form->create(); ?>
        <input type="hidden" name="saved" value="1">
        <?php foreach ($data as $id => $single_permission) { ?>
            <input type="hidden" name="department_id[<?= $id ?>]" value="<?= $request_data['department_id'] ?>">
            <input type="hidden" name="session_id[<?= $id ?>]" value="<?= $request_data['session_id'] ?>">
            <input type="hidden" name="level_id[<?= $id ?>]" value="<?= $request_data['level_id'] ?>">
            <input type="hidden" name="type[<?= $id ?>]" value="<?= $single_permission['permission']['type'] ?>">
            <input type="hidden" name="slug[<?= $id ?>]" value="<?= $single_permission['permission']['slug'] ?>">



            <h5 style="margin-top:50px;"><?= $single_permission['permission_title'] ?></h5>

            <?php if ($single_permission['permission']['type'] == 'section') { ?>
                <?php foreach ($single_permission['set_sections'] as $section) { ?>
                    <div class="container">
                        <?php $chacked = isset($section['checked']) ? "checked" : null; ?>
                        <div class="col-md-3 mt-4" style="font-size: 15px; ">
                            <input step="" class="form-check-input" type="checkbox" name="section[<?= $id ?>][<?= $section['section_id'] ?>]"
                                value="1" <?= $chacked ?>>
                            <?= $section['section_name'] ?>
                        </div>
                    </div>

                <?php } ?>

            <?php } else if ($single_permission['permission']['type'] == 'course') { ?>
                <?php foreach ($single_permission['set_sections'] as $section) { ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9">
                                    <p class="ml-2 mt-2"> Section Name: <?= $section['section_name'] ?></p>
                                </div>
                                <div class="col-md-3">
                                <?php $section_name = $section['section_name'].$id ?>
                                    <p class="pull-right"> Check All <input class="all_check_attendance_course" type="checkbox"
                                            id="<?= $section_name ?>" value="1"></p>
                                </div>
                            </div>

                            <div class="row">
                            <?php foreach ($section['courses'] as $course) { ?>
                                <?php $chacked = isset($course['checked']) ? "checked" : null; ?>
                                    <div class="col-md-3 mt-2" style="font-size: 12px; ">
                                        <input step="margin-top:-3px;" class="form-check-input <?= $section_name ?>" type="checkbox"
                                            name="course[<?= $id ?>][<?= $section['section_id'] ?>][<?= $course['course_id'] ?>]" value="1" <?= $chacked ?>>
                                    <?= $course['course_name'] ?>
                                    </div>
                            <?php } ?>
                            </div>
                        </div>
                <?php } ?>

            <?php } else { ?>
                <?php foreach ($single_permission['set_levels'] as $levels) { ?>
                        <div class="container">
                        <?php $chacked = isset($levels['checked']) ? "checked" : null; ?>
                            <div class="col-md-3 mt-4" style="font-size: 15px; ">
                                <input step="" class="form-check-input" type="checkbox" name="section[<?= $id ?>][<?= $levels['level_id'] ?>]" value="1"
                                <?= $chacked ?>>
                            <?= $levels['level_name'] ?>
                            </div>
                        </div>

                <?php } ?>
            <?php } ?>
        <?php } ?>
        <div class="text-right mt-2">
            <button type="submit" class="btn btn-info"><?= __d('gradings', 'Submit') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    <?php } ?>

</body>

</html>
<script type="text/javascript">
    $(document).ready(function () {
        var form = $(".form").html();
        $('.add_more').click(function () {
            $('.form').append(form);
        });
    });
    $('.allcheck').on('change', function () {
        var checked = this.checked;
        var id = this.id;
        var class_name = "." + id;
        var checkboxes = document.querySelectorAll(class_name);
        checkboxes.forEach(function (checkbox) {
            if (checked == true) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    });
    $('.all_check_attendance_section').on('change', function () {
        var checked = this.checked;
        var id = this.id;
        var class_name = "." + id;
        var checkboxes = document.querySelectorAll(class_name);
        checkboxes.forEach(function (checkbox) {
            if (checked == true) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    });
    $('.all_check_attendance_course').on('change', function () {
        var checked = this.checked;
        var id = this.id;
        var class_name = "." + id;
        var checkboxes = document.querySelectorAll(class_name);
        checkboxes.forEach(function (checkbox) {
            if (checked == true) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    });
</script>