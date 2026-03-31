<?php

use Cake\Core\Configure;

$this->Form->unlockField('session_id');
$this->Form->unlockField('name');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('courses_cycle_id');
$this->Form->unlockField('term_cycle_id');
$this->Form->unlockField('sid');
$this->Form->unlockField('room');
$attendance_type = Configure::read('Attendance.Type');

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Student Attendance Form</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('attendance', 'Admit Card') ?>
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
                                            <option value="<?php echo $session['session_id']; ?>">
                                                <?php echo $session['session_name']; ?></option>
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
                                        <input name="sid" id="sid" type="text" class="form-control" placeholder="SID">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="name" id="name" type="text" class="form-control" readonly>
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
                                        <input name="section_id" id="section_name" type="text" class="form-control"
                                            readonly>
                                        <input type="hidden" name="section_id" id="section_id">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Level') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="level_id" id="level_name" type="text" class="form-control"
                                            readonly>
                                        <input type="hidden" name="level_id" id="level_id">
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
                                            <option value=""><?= __d('students', '-- Choose Term --') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Room') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="room" type="text" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
                        </div>
                    </div>
                </fieldset>
            </section>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>



</html>
<script>
$(document).ready(function() {
    $("#check_all").click(function() {
        var checkBoxes = $(".checkbox_attend");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    });
})


$("#session_id").change(function() {
    getAdmitAjax();
});
$("#sid").change(function() {
    getAdmitAjax();
});

function getAdmitAjax() {
    var session_id = $("#session_id").val();
    var sid = $("#sid").val();
    $.ajax({
        url: 'getAdmitAjax',
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        data: {
            "session_id": session_id,
            "sid": sid
        },
        success: function(data) {
            data = JSON.parse(data);

            // Set the inputs
            $("#name").val(data.name || '');

            // Set Section Name and ID
            $("#section_name").val(data.section_name || '');
            $("#section_id").val(data.section_id || '');

            // Set Level Name and ID
            $("#level_name").val(data.level_name || '');
            $("#level_id").val(data.level_id || '');

            // Set the dropdown (terms)
            var termOptions = '<option value="">-- Choose Term --</option>';
            if (data.terms && Array.isArray(data.terms)) {
                for (let i = 0; i < data.terms.length; i++) {
                    var termName = data.terms[i]["term_name"];
                    var termId = data.terms[i]["term_cycle_id"];
                    termOptions += '<option value="' + termId + '">' + termName + '</option>';
                }
            }
            $('#term_cycle_id').html(termOptions);
        }
    });
}
</script>