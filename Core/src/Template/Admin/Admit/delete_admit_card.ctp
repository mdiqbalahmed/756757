<?php

use Cake\Core\Configure;

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('courses_cycle_id');
$this->Form->unlockField('term_cycle_id');

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
                <?= __d('attendance', 'Delete Admit Card') ?>
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
                                            <option value="<?php echo $session['session_id']; ?>" <?php if ($data['session_id'] == $session['session_id']) {
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
                                            <option value="<?php echo $shift['shift_id']; ?>" <?php if ($data['shift_id'] == $shift['shift_id']) {
                                                                                                        echo 'Selected';
                                                                                                    } ?>>
                                                <?php echo $shift['shift_name']; ?> </option>
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
                                            <option value="<?php echo $level['level_id']; ?>" <?php if ($data['level_id'] == $level['level_id']) {
                                                                                                        echo 'Selected';
                                                                                                    } ?>>
                                                <?php echo $level['level_name']; ?>
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
                                        <select class="form-control" name="section_id" id="section_id">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($sections as $section) { ?>
                                            <option value="<?php echo $section['section_id']; ?>" <?php if ($data['section_id'] == $section['section_id']) {
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
    <?php if (isset($scms_admit_cards)) { ?>
    <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">
        <?php
            // Unlock dynamically generated fields
            foreach ($scms_admit_cards as $key => $course) {
                $this->Form->unlockField('subject' . $key);
                $this->Form->unlockField('time_from' . $key);
                $this->Form->unlockField('time_to' . $key);
            }
            ?>

        <?php echo $this->Form->create(); ?>
        <?php
            $this->Form->unlockField('subject');
            $this->Form->unlockField('time_from');
            $this->Form->unlockField('time_to');
            $this->Form->unlockField('level_id');
            $this->Form->unlockField('term_cycle_id');
            ?>
        <div>
            <p style="text-align: center; font-size: 18px;">Term: <?php echo $scms_term_cycles[0]['term_name']; ?> </p>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Subject</th>
                    <th>Time From</th>
                    <th>Time To</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scms_admit_cards as $key => $course) { ?>
                <tr>
                    <td>
                        <input type="text" name="subject<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($course['course_name']); ?>">
                    </td>
                    <td>
                        <input type="datetime-local" name="time_from<?php echo $key; ?>"
                            value="<?= date('Y-m-d\TH:i', strtotime($course['datetime_from'])); ?>"
                            class="form-control">
                    </td>
                    <td>
                        <input type="datetime-local" name="time_to<?php echo $key; ?>"
                            value="<?= date('Y-m-d\TH:i', strtotime($course['datetime_to'])); ?>" class="form-control">
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <input type="hidden" class="hidden" id="hidden" name="level_id"
            value="<?php echo htmlspecialchars($request_data['level_id']); ?>">
        <input type="hidden" class="hidden" id="hidden" name="term_cycle_id"
            value="<?php echo $request_data['term_cycle_id']; ?>">
        <div class="text-right mt-4 mb-4">
            <button type="submit" class="btn btn-info">SAVE</button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <?php } elseif (isset($scms_student_cycles)) { ?>
    <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">
        <?php
            // Unlock dynamically generated fields
            foreach ($scms_student_cycles as $key => $course) {
                $this->Form->unlockField('subject' . $key);
                $this->Form->unlockField('time_from' . $key);
                $this->Form->unlockField('time_to' . $key);
            }
            ?>

        <?php echo $this->Form->create(); ?>
        <?php
            $this->Form->unlockField('subject');
            $this->Form->unlockField('time_from');
            $this->Form->unlockField('time_to');
            $this->Form->unlockField('level_id');
            $this->Form->unlockField('term_cycle_id');

            ?>
        <div>
            <p style="text-align: center; font-size: 18px;">Term: <?php echo $scms_term_cycles[0]['term_name']; ?> </p>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Subject</th>
                    <th>Time From</th>
                    <th>Time To</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scms_student_cycles as $key => $course) { ?>
                <tr>
                    <td>
                        <input type="text" name="subject<?php echo $key; ?>" class="form-control"
                            value="<?php echo htmlspecialchars($course['course_name']); ?>">
                    </td>
                    <td>
                        <input type="datetime-local" name="time_from<?php echo $key; ?>"
                            value="<?= date("Y-m-d H:i:s", time() + 6 * 3600) ?>" class="form-control">
                    </td>
                    <td>
                        <input type="datetime-local" name="time_to<?php echo $key; ?>"
                            value="<?= date("Y-m-d H:i:s", time() + 6 * 3600) ?>" class="form-control">
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <!-- <tfoot>
                    <tr>
                        <td colspan="1" style="text-align: left;">Room</td>
                        <td>
                            <input type="text" name="room_no" class="form-control">
                        </td>
                    </tr>
                </tfoot> -->
        </table>

        <input type="hidden" class="hidden" id="hidden" name="level_id"
            value="<?php echo htmlspecialchars($request_data['level_id']); ?>">
        <input type="hidden" class="hidden" id="hidden" name="term_cycle_id"
            value="<?php echo $request_data['term_cycle_id']; ?>">
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
    getTermAjax();
    getallSubjectAjax();
});
$("#term_cycle_id").change(function() {
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

// function countRoomNumbers() {
//     const rooms = document.querySelectorAll('.room-input');
//     const roomCounts = {};

//     // Clear previous counts
//     const displayDiv = document.getElementById('room-count-display');
//     displayDiv.innerHTML = '';

//     rooms.forEach(room => {
//         const roomNumber = room.value.trim();
//         if (roomNumber) { // Only count non-empty fields
//             if (roomCounts[roomNumber]) {
//                 roomCounts[roomNumber]++;
//             } else {
//                 roomCounts[roomNumber] = 1;
//             }
//         }
//     });

//     // Display the counts
//     for (const [room, count] of Object.entries(roomCounts)) {
//         const countText = `Room ${room} has been used ${count} times.`;
//         const p = document.createElement('p');
//         p.textContent = countText;
//         displayDiv.appendChild(p);
//     }
// }

// // Attach event listeners to update count on input change
// document.querySelectorAll('.room-input').forEach(input => {
//     input.addEventListener('input', countRoomNumbers);
// });

// // Initial count on page load
// countRoomNumbers();

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
        listItem.textContent = `Room ${room} has been used ${count} times.`;
        roomCountList.appendChild(listItem);
    }
}

// Initial count display
document.addEventListener('DOMContentLoaded', countRoomNumbers);
</script>