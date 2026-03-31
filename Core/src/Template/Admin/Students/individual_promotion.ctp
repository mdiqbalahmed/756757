<?php
$this->Form->unlockField('sid');
$this->Form->unlockField('remove');
$this->Form->unlockField('level_from');
$this->Form->unlockField('section_id');
$this->Form->unlockField('level_to');
$this->Form->unlockField('session_from');
$this->Form->unlockField('session_to');
$this->Form->unlockField('section_from');
$this->Form->unlockField('section_to');
$this->Form->unlockField('roll');
$this->Form->unlockField('name');
$this->Form->unlockField('status');



$this->Form->unlockField('level_id');

$this->Form->unlockField('session_id');

?>

<!doctype html>
<html lang="en">

<body>
    <div class="container">
        <div class="header">
            <h3 class="text-center" style="letter-spacing:3px; word-spacing:7px; text-transform:capitalize;">
                <?= __d('students', 'Individual Students Promotion') ?>
            </h3>
        </div>

        <?= $this->Form->create('', ['type' => 'file']) ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto">
                <div class="p-2">
                    <div class="row mb-3">

                        <!-- SID & Remove Previous Cycle -->
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'SID') ?></p>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="sid" id="sid" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <p class="label-font13"><?= __d('students', 'Remove Previous Cycle') ?></p>
                                </div>
                                <div class="col-lg-6">
                                    <input class="form-check-input" type="checkbox"
                                        name="remove" id="remove_prev"
                                        value="1" onclick="return false;">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                </div>
                                <div class="col-lg-9">
                                    <input name="name" id="name" type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'Status') ?></p>
                                </div>
                                <div class="col-lg-4">
                                    <div id="status" class="form-control" style="background:#f8f9fa;"></div>
                                </div>
                            </div>
                        </div>


                        <!-- Promotion From -->
                        <div class="col-md-6 mt-3">
                            <h5>Promotion From</h5>


                            <div class="col-lg-12 mt-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input type="text" id="session_name" class="form-control" readonly>
                                        <input type="hidden" name="session_from" id="session_from">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Level') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input type="text" id="level_name" class="form-control" readonly>
                                        <input type="hidden" name="level_from" id="level_from">

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input type="text" id="section_name" class="form-control" readonly>
                                        <input type="hidden" name="section_from" id="section_from">
                                    </div>
                                </div>
                            </div>



                        </div>

                        <!-- Promotion To -->
                        <div class="col-md-6 mt-3">
                            <h5>Promotion To</h5>
                            <div class="col-lg-12 mt-3">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Session To') ?></p>
                                    </div>
                                    <div class="col-lg-7">
                                        <select class="form-control" name="session_to" id="session_to" required>
                                            <option value="">-- Choose --</option>
                                            <?php foreach ($sessions as $session) { ?>
                                                <option value="<?= $session['session_id'] ?>"><?= $session['session_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Level To') ?></p>
                                    </div>
                                    <div class="col-lg-7">
                                        <select class="form-control" name="level_to" id="level_to" required>
                                            <option value="">-- Choose --</option>
                                            <?php foreach ($levels as $level) { ?>
                                                <option value="<?= $level['level_id'] ?>"><?= $level['level_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section To') ?></p>
                                    </div>
                                    <div class="col-lg-7">
                                        <select class="form-control" name="section_to" id="section_id_to" required>
                                            <option value="">-- Choose --</option>
                                            <?php foreach ($sections as $section) { ?>
                                                <option value="<?= $section['section_id'] ?>"><?= $section['section_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'New Roll') ?></p>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" name="roll" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>

        <div class="mt-3 text-right">
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
        </div>

        <?= $this->Form->end() ?>
    </div>

    <script>
        $('#remove_prev').on('click', function() {
            return false;
        });

        $(document).ready(function() {

            // Auto-load student info on SID change
            $("#sid").change(function() {
                var sid = $(this).val();
                if (!sid) return;

                $.ajax({
                    url: 'getPromotionAjax',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        sid: sid
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            var student = data[0];

                            // Name
                            $('#name').val(student.name || '');

                            // STATUS (Active / Inactive with color)
                            var statusText = (student.status == 1) ? 'Active' : 'Inactive';
                            var statusColor = (student.status == 1) ? 'green' : 'red';

                            $('#status').html(
                                '<span style="color:' + statusColor + '; font-weight:600;">' +
                                statusText +
                                '</span>'
                            );

                            // Level
                            $('#level_name').val(student.level_name || '');
                            $('#level_from').val(student.level_id || '');

                            // Section
                            $('#section_name').val(student.section_name || '');
                            $('#section_from').val(student.section_id || '');

                            // Session
                            $('#session_name').val(student.session_name || '');
                            $('#session_from').val(student.session_id || '');
                        }
                    }

                });
            });

            // Populate Section To based on Level To
            $("#level_to").change(function() {
                var level_id = $(this).val();
                if (!level_id) return;

                $.ajax({
                    url: 'getSectionAjaxbylevelto',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        level_id: level_id
                    },
                    success: function(data) {
                        var options = '<option value="">-- Choose --</option>';
                        data.forEach(function(sec) {
                            options += '<option value="' + sec.section_id + '">' + sec.section_name + '</option>';
                        });
                        $('#section_id_to').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error:", status, error);
                    }
                });
            });

        });




        $(document).ready(function() {
            function updateRemoveCheckbox() {
                var sessionFrom = $('#session_from').val();
                var sessionTo = $('#session_to').val();

                if (sessionFrom && sessionTo && sessionFrom === sessionTo) {
                    $('#remove_prev').prop('checked', true);
                } else {
                    $('#remove_prev').prop('checked', false);
                }
            }

            // Call when either session_from or session_to changes
            $('#session_from, #session_to').on('change keyup', function() {
                updateRemoveCheckbox();
            });

            // Also call on page load in case values are already set
            updateRemoveCheckbox();
        });
    </script>
</body>

</html>