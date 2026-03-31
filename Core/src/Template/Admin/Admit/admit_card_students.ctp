<?php

use Cake\Core\Configure;


echo $this->Form->unlockField('session_id');
echo $this->Form->unlockField('shift_id');
echo $this->Form->unlockField('level_id');
echo $this->Form->unlockField('section_id');
echo $this->Form->unlockField('courses_cycle_id');
echo $this->Form->unlockField('term_cycle_id');


$session_id = isset($session_id) ? $session_id : '';
$shift_id = isset($shift_id) ? $shift_id : '';
$level_id = isset($level_id) ? $level_id : '';
$section_id = isset($section_id) ? $section_id : '';
$term_cycle_id = isset($term_cycle_id) ? $term_cycle_id : '';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('attendance', 'Generate Room For Admit Card') ?>
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
                                            <option value="<?php echo $session['session_id']; ?>" <?php if ($session_id == $session['session_id']) {
                                                                                                            echo 'Selected';
                                                                                                        } ?>>
                                                <?php echo $session['session_name']; ?> </option>
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
                                            <option value="<?= $shift['shift_id']; ?>"
                                                <?php if ($shift_id == $shift['shift_id']) echo 'selected'; ?>>
                                                <?= $shift['shift_name']; ?>
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
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                                            <option value="<?= $level['level_id']; ?>"
                                                <?php if ($level_id == $level['level_id']) echo 'selected'; ?>>
                                                <?= $level['level_name']; ?>
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
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($sections as $section) { ?>
                                            <option value="<?php echo $section['section_id']; ?>" <?php if ($section_id == $section['section_id']) {
                                                                                                            echo 'Selected';
                                                                                                        } ?>>
                                                <?php echo $section['section_name']; ?> </option>
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
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                    </div>
                                    <div class="col-lg-9 row2Field mt-5">
                                        <button type="submit"
                                            class="btn btn-info"><?= __d('setup', 'Search Student') ?></button>
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
    <?php if (!empty($students1)) { ?>
    <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">
        <?php echo $this->Form->create(); ?>
        <!-- Room Counts Section -->
        <div>
            <p style="text-align: center; font-size: 18px;color: darkcyan;">Term:
                <?php echo $scms_term_cycles[0]['term_name']; ?> </p>
        </div>
        <div id="room-counts" style="margin-top: 20px;">
            <h5>Room Counts:</h5>
            <ul id="room-count-list">
                <!-- Room counts will be dynamically inserted here -->
            </ul>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Sid</th>
                    <th>Roll</th>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sectionWiseStudents = [];
                    foreach ($students1 as $student) {
                        $section = $student['section'] ?? 'Unknown';
                        if (!isset($sectionWiseStudents[$section])) {
                            $sectionWiseStudents[$section] = [];
                        }
                        $sectionWiseStudents[$section][] = $student;
                    }

                    foreach ($sectionWiseStudents as $section => $studentsInSection) { ?>
                <tr>
                    <td colspan="5">
                        <h5 style="color: lightseagreen;">Section: <?php echo htmlspecialchars($section); ?></h5>
                    </td>
                </tr>
                <?php foreach ($studentsInSection as $key => $student) {
                            $this->Form->unlockField('sid' . $key);
                            $this->Form->unlockField('roll' . $key);
                            $this->Form->unlockField('name' . $key);
                            $this->Form->unlockField('section' . $key);
                            $this->Form->unlockField('section_id' . $key);
                            $this->Form->unlockField('room' . $key);
                            $this->Form->unlockField('term_cycle_id');
                            $this->Form->unlockField('level_id');
                        ?>
                <tr>
                    <td><input type="text" name="sid<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($student['sid'] ?? ''); ?>"></td>
                    <td><input type="text" name="roll<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($student['roll'] ?? ''); ?>"></td>
                    <td><input type="text" name="name<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($student['name'] ?? ''); ?>"></td>
                    <td><input type="text" name="section<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($student['section'] ?? ''); ?>"><input type="hidden"
                            name="section_id<?php echo $key; ?>"
                            value="<?php echo htmlspecialchars($student['section_id'] ?? ''); ?>"></td>
                    <td><input type="text" name="room<?php echo $key; ?>" class="form-control room-input"
                            value="<?php echo htmlspecialchars($student['room'] ?? ''); ?>"
                            oninput="countRoomNumbers()"></td>
                </tr>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <input type="hidden" name="level_id" value="<?php echo htmlspecialchars($request_data['level_id'] ?? ''); ?>">
        <input type="hidden" name="term_cycle_id"
            value="<?php echo htmlspecialchars($request_data['term_cycle_id'] ?? ''); ?>">
        <div class="text-right mt-4 mb-4">
            <button type="submit" class="btn btn-info">SAVE</button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <?php } elseif (!empty($students2)) { ?>
    <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">
        <?php echo $this->Form->create(); ?>
        <!-- Room Counts Section -->
        <div>
            <p style="text-align: center; font-size: 18px;color: darkcyan;">Term:
                <?php echo $scms_term_cycles[0]['term_name']; ?> </p>
        </div>
        <div id="room-counts" style="margin-top: 20px;">
            <h5>Room Counts:</h5>
            <ul id="room-count-list">
                <!-- Room counts will be dynamically inserted here -->
            </ul>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Sid</th>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sectionWiseStudents = [];
                    foreach ($students2 as $student) {
                        $section = $student['section'] ?? 'Unknown';
                        if (!isset($sectionWiseStudents[$section])) {
                            $sectionWiseStudents[$section] = [];
                        }
                        $sectionWiseStudents[$section][] = $student;
                    }

                    foreach ($sectionWiseStudents as $section => $studentsInSection) { ?>
                <tr>
                    <td colspan="5">
                        <h5 style="color: lightseagreen;">Section: <?php echo htmlspecialchars($section); ?></h5>
                    </td>
                </tr>
                <?php foreach ($studentsInSection as $key => $student) {
                            $this->Form->unlockField('sid' . $key);
                            $this->Form->unlockField('name' . $key);
                            $this->Form->unlockField('section' . $key);
                            $this->Form->unlockField('section_id' . $key);
                            $this->Form->unlockField('room' . $key);
                            $this->Form->unlockField('term_cycle_id');
                            $this->Form->unlockField('level_id');
                        ?>
                <tr>
                    <td><input type="text" name="sid<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($student['sid'] ?? ''); ?>"></td>
                    <td><input type="text" name="name<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($student['name'] ?? ''); ?>"></td>
                    <td><input type="text" name="section<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($student['section'] ?? ''); ?>"><input type="hidden"
                            name="section_id<?php echo $key; ?>"
                            value="<?php echo htmlspecialchars($student['section_id'] ?? ''); ?>"></td>
                    <td><input type="text" name="room<?php echo $key; ?>" class="form-control room-input"
                            value="<?php echo htmlspecialchars($student['room'] ?? ''); ?>"
                            oninput="countRoomNumbers()"></td>
                </tr>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <input type="hidden" name="level_id" value="<?php echo htmlspecialchars($request_data['level_id'] ?? ''); ?>">
        <input type="hidden" name="term_cycle_id"
            value="<?php echo htmlspecialchars($request_data['term_cycle_id'] ?? ''); ?>">
        <div class="text-right mt-4 mb-4">
            <button type="submit" class="btn btn-info">SAVE</button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <?php } else { ?>

    <?php } ?>









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
    getTermAjax();
    getallSubjectAjax();
});
$("#shift_id").change(function() {
    getSectionAjax();
});
$("#session_id").change(function() {
    getSectionAjax();
    getTermAjax();
    getallSubjectAjax();
});
$("#term_cycle_id").change(function() {
    getallSubjectAjax();
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
        success: function(data) {
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
        success: function(data) {
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
    console.log('data');
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
        success: function(data) {
            data = JSON.parse(data);
            console.log(data);
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



function countRoomNumbers() {
    const rooms = document.querySelectorAll('.room-input');
    const roomCounts = {};

    // Count the room numbers
    rooms.forEach(room => {
        const roomNumber = room.value.trim();
        if (roomNumber) { // Only count non-empty inputs
            if (roomCounts[roomNumber]) {
                roomCounts[roomNumber]++;
            } else {
                roomCounts[roomNumber] = 1;
            }
        }
    });

    // Display the room counts
    const roomCountList = document.getElementById('room-count-list');
    roomCountList.innerHTML = ''; // Clear the previous counts

    for (const [room, count] of Object.entries(roomCounts)) {
        const listItem = document.createElement('li');
        listItem.textContent = `Room No (${room}) : ${count} times.`;
        roomCountList.appendChild(listItem);
    }
}

// Initial count display
document.addEventListener('DOMContentLoaded', countRoomNumbers);
</script>