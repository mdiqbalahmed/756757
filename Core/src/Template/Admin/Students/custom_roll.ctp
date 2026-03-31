<?php

use Cake\Core\Configure;

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');

$data['session_id'] = isset($data['session_id']) ? $data['session_id'] : $active_session_id;
$shift_id = isset($shift_id) ? $shift_id : '';
$level_id = isset($level_id) ? $level_id : '';
$section_id = isset($section_id) ? $section_id : '';

?>

<body>
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('attendance', 'Search') ?>
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
                                        <select class="form-control" name="shift_id" id="shift_id" <?php echo $required; ?>>
                                        <?php if (!$required) { ?>
        <option value=""><?= __d('students', '-- Choose --') ?></option>
    <?php } ?>
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
                                        <select class="form-control" name="level_id" id="level_id" <?php echo $required; ?>>
                                        <?php if (!$required) { ?>
        <option value=""><?= __d('students', '-- Choose --') ?></option>
    <?php } ?>
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
                                    <select class="form-control" name="section_id" id="section_id" <?php echo $required; ?>>
                                        <?php if (!$required) { ?>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        <?php } ?>
                                        <?php foreach ($sections as $section) { ?>
                                            <option value="<?php echo $section['section_id']; ?>" 
                                                <?php echo (isset($data['section_id']) && $data['section_id'] == $section['section_id']) ? 'selected' : ''; ?>>
                                                <?php echo $section['section_name']; ?>
                                            </option>
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
        <div class="mt-3 text-center">
            <button type="submit" class="btn btn-info px-5"><?= __d('setup', 'Search') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>


    <?php if (isset($students)) { //pr($students);die; 
    ?>
        <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">
            <h4 class="text-center mt-4 mb-3 fw-bold" style="color:#2c2c2c;">
                Update Student Roll
            </h4>

            <?php echo $this->Form->create(); ?>
            <?php

            $this->Form->unlockField('student_cycle_id');
            $this->Form->unlockField('session_id');
            $this->Form->unlockField('shift_id');
            $this->Form->unlockField('level_id');
            $this->Form->unlockField('section_id');
            $this->Form->unlockField('user_id');
            $this->Form->unlockField('roll');
            ?>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>SID</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Current Roll No.</th>
                        <th>New Roll</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $update = null;
                    foreach ($students as $student) { ?>
                        <tr class="single_row">
                            <td><?php echo $student['sid'];  ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['section_name']; ?></td>
                            <td><?php echo $student['roll'];  ?></td>
                            <td>
                                <input name="roll[<?php echo $student['student_cycle_id']; ?>]" type="text" class="form-control" value="<?php echo $student['roll']; ?>">
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <div class="text-right mt-4 mb-4">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    <?php } ?>


</body>

</html>
<script>
    $(document).ready(function() {
        $("#check_all").click(function() {
            var checkBoxes = $(".checkbox_attend");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        });
    })
    $("#level_id").change(function() {
        getSectionAjax();
    });
    $("#shift_id").change(function() {
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
            success: function(data) {
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

</script>