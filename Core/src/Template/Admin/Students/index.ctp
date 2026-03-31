<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('sid');
$this->Form->unlockField('name');
$this->Form->unlockField('roll');
$this->Form->unlockField('religion');
$this->Form->unlockField('status');
$this->Form->unlockField('course_id');

$data['session_id'] = isset($data['session_id']) ? $data['session_id'] : $active_session_id;
$shift_id = isset($shift_id) ? $shift_id : '';
$level_id = isset($level_id) ? $level_id : '';
$section_id = isset($section_id) ? $section_id : '';
$sid = isset($sid) ? $sid : '';
$name = isset($name) ? $name : '';
$roll = isset($roll) ? $roll : '';
$religion = isset($religion) ? $religion : '';
$status = isset($status) ? $status : '';
$course_id = isset($course_id) ? $course_id : '';

$statuses = [
    [
        'status_id' => 1,
        'status_name' => 'Active',

    ],
    [
        'status_id' => -1,
        'status_name' => 'In-Active',
    ],
];
$religions = [
    'Islam' => 'Islam',
    'Hindu' => 'Hindu',
    'Christian' => 'Christian',
    'Buddhist' => 'Buddhist'
]
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
                <?= __d('students', 'Search Students') ?>
            </h3>
        </div>
        <?php echo $this->Form->create(); ?>
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
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'SID') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="sid" type="text" class="form-control" placeholder="SID"
                                            value="<?php if (isset($data['sid'])) {
                                                echo $data['sid'];
                                            } ?>">
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Status') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="status" id="status">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($statuses as $status) { ?>
                                                <option value="<?php echo $status['status_id']; ?>" <?php if ($data['status'] == $status['status_id']) {
                                                       echo 'Selected';
                                                   } ?>><?php echo $status['status_name']; ?> </option>
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
                                        <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="name" type="text" class="form-control" placeholder="Name"
                                            value="<?php if (isset($data['name'])) {
                                                echo $data['name'];
                                            } ?>">
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Roll') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="roll" type="text" class="form-control"
                                            value="<?php if (isset($data['roll'])) {
                                                echo $data['roll'];
                                            } ?>">
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Religion') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="religion" id="religion">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($religions as $key => $religion) { ?>
                                                <option value="<?php echo $key; ?>" <?php if (!empty($data['religion']) && $data['religion'] == $key) {
                                                       echo 'selected';
                                                   } ?>><?php echo $religion; ?></option>
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
                                        <p class="label-font13"><?= __d('students', '4Th Subject') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="course_id" id="course_id">
                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($courses as $course) { ?>
                                                <option value="<?php echo $course['course_id']; ?>" <?php if ($data['course_id'] == $course['course_id']) {
                                                       echo 'Selected';
                                                   } ?>><?php echo $course['course_name']; ?> </option>
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
    <?php if (empty($students) || isset($flashMessage) && !empty($flashMessage) && ($flashMessage['message'])) { ?>
        <div style="margin-top: 6px;" class="alert alert-<?= h($flashMessage['type']) ?> <?= h($flashMessage['key']) ?>"
            role="alert">
            <?= $flashMessage['escape'] ? h($flashMessage['message']) : $flashMessage['message']; ?>
        </div>
    <?php } else { ?>
        <div class="row">
            <div>
                <div class="horizontal_scroll table-responsive-sm">
                    <div style="color: #3d7fd1; margin-right: 10px;">Total:<?php echo (count($students)); ?></div>
                    <div class="rows">
                        <div class="flexButton mb-3">
                            <?php //for student data export purpose 27/01/2024
                                $this->Form->unlockField('session_id');
                                $this->Form->unlockField('level_id');
                                $this->Form->unlockField('shift_id');
                                $this->Form->unlockField('section_id');
                                $this->Form->unlockField('status');
                                ?>
                            <?php echo $this->Form->create('Export Data', ['type' => 'file', 'url' => ['action' => 'export']]); ?>
                            <input type="hidden" name="session_id"
                                value="<?php echo isset($where['scms_student_cycle.session_id']) ? $where['scms_student_cycle.session_id'] : ''; ?>">
                            <input type="hidden" name="level_id"
                                value="<?php echo isset($where['scms_student_cycle.level_id']) ? $where['scms_student_cycle.level_id'] : ''; ?>">
                            <input type="hidden" name="shift_id"
                                value="<?php echo isset($where['scms_student_cycle.shift_id']) ? $where['scms_student_cycle.shift_id'] : ''; ?>">
                            <input type="hidden" name="section_id"
                                value="<?php echo isset($where['scms_student_cycle.section_id']) ? $where['scms_student_cycle.section_id'] : ''; ?>">
                            <input type="hidden" name="status"
                                value="<?php echo isset($where['s.status']) ? $where['s.status'] : ''; ?>">
                            <button type="submit" class="btn btn-success"><?= __d('setup', 'Export Data') ?></button>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th><?= __d('students', 'Action') ?></th>
                                <th><?= __d('students', 'SID') ?></th>
                                <th><?= __d('students', 'Photo') ?></th>
                                <th><?= __d('students', 'Name') ?></th>
                                <th><?= __d('students', 'Class') ?></th>
                                <th><?= __d('students', 'Section') ?></th>
                                <th><?= __d('students', 'Roll') ?></th>
                                <th><?= __d('students', 'Quota') ?></th>
                                <th><?= __d('students', 'Active Guardian') ?></th>
                                <th><?= __d('students', 'Resident Status') ?></th>
                                <th><?= __d('students', 'Gender') ?></th>
                                <th><?= __d('students', 'Blood Group') ?></th>
                                <th><?= __d('students', 'Religion Subject') ?></th>
                                <th><?= __d('students', 'Present Address') ?></th>
                                <th><?= __d('students', 'Contact Number') ?></th>
                                <th><?= __d('students', 'Group') ?></th>
                                <th><?= __d('students', '3rd Subject') ?></th>
                                <th><?= __d('students', '4th Subject') ?></th>
                                <th><?= __d('students', 'DOB') ?></th>
                                <th><?= __d('students', 'Status') ?></th>
                                <th><?= __d('students', 'Action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($students as $student) {
                                ?>
                                <tr>
                                    <td style="display: grid; grid-auto-flow: column; gap: 10px;">
                                        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $student['student_id']], ['class' => 'btn action-btn btn-warning', 'escape' => false, 'target' => '_blank']) ?>
                                        <?= $this->Html->link('<i class="fa fa-print"></i>', ['action' => 'print', $student['student_id']], ['class' => 'btn action-btn btn-info', 'escape' => false, 'target' => '_blank']) ?>
                                    </td>
                                    <td><?php echo $student['sid'] ?></td>
                                    <td class="student-thumbnail">
                                        <?php echo $this->Html->image('/webroot/uploads/students/thumbnail/' . $student['thumbnail']); ?>
                                    </td>
                                    <td class="wide_cell"><?php echo $student['name'] ?></td>
                                    <td><?php echo $student['level_name'] ?></td>
                                    <td><?php echo $student['section_name'] ?></td>
                                    <td><?php echo $student['roll'] ?></td>
                                    <td><?php echo $student['quota'] ?></td>
                                    <td><?php echo $student['active_guardian'] ?></td>
                                    <td><?php
                                    if ($student['resedential'] == 1) {
                                        echo 'Resident';
                                    } else {
                                        echo 'Non-Resident';
                                    } ?>
                                    <td><?php echo $student['gender'] ?></td>
                                    <td><?php echo $student['blood_group'] ?></td>
                                    <td><?php echo $student['religion_subject'] ?></td>
                                    <td><?php echo $student['present_address'] ?></td>
                                    <!--<td><?php //echo $student['mobile'] ?></td>-->
                                    <td><?php echo $student['guardians'][strtolower($student['active_guardian'])]['mobile'] ?>
                                    </td>
                                    <td><?php echo $student['group_name'] ?></td>
                                    <td><?php echo $student['thrid_subject_name'] ?></td>
                                    <td><?php echo $student['forth_subject_name'] ?></td>
                                    <td><?php echo $student['date_of_birth'] ?></td>
                                    <td><?php if ($student['status']) {
                                        echo 'Active';
                                    } else {
                                        echo 'Inactive';
                                    } ?></td>
                                    <td style="display: grid; grid-auto-flow: column; gap: 10px;">
                                        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $student['student_id']], ['class' => 'btn action-btn btn-warning', 'escape' => false, 'target' => '_blank']) ?>
                                        <?= $this->Html->link('<i class="fa fa-print"></i>', ['action' => 'print', $student['student_id']], ['class' => 'btn action-btn btn-info', 'escape' => false, 'target' => '_blank']) ?>
                                    </td>
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
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
    });
    $("#session_id").change(function () {
        getSectionAjax();
    });

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        var session_id = $("#session_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "shift_id": shift_id,
                "session_id": session_id,
                "type": 'students'
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '';
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