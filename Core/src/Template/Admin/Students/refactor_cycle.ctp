<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('sid');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('term_cycle_id');

?>
<!doctype html>

<body>

    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Search Students') ?>
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
                                                <option value="<?= $session['session_id']; ?>">
                                                    <?= $session['session_name']; ?></option>
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
                                        <select class="form-control" name="shift_id" id="shift_id">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($shifts as $shift) { ?>
                                                <option value="<?php echo $shift['shift_id']; ?>"><?php echo $shift['shift_name']; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Class') ?></p>
                                    </div>

                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="level_id" id="level_id" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                                                <option value="<?= $level['level_id']; ?>" >
                                                    <?= $level['level_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="section_id" id="section_id">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($sections as $section) { ?>
                                                <option value="<?php echo $section['section_id']; ?>"><?php echo $section['section_name']; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Term') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="term_cycle_id" id="term_cycle_id" required="true">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>

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
                                        <input name="sid" type="text" class="form-control" placeholder="SID">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </section>
        </div>
        <div class="mt-3">
        <button type="submit" class="btn btn-info" onclick="return confirm('Are you sure you want to Refactor the cycles?');">
    <?= __d('setup', 'Search') ?>
</button>

        </div>
        <?php echo $this->Form->end(); ?>

    </div>
</body>

</html>
<script>
    $("#level_id").change(function() {
        getSectionAjax();
        getTermCycleAjax();
    });
    $("#shift_id").change(function() {
        getSectionAjax();
        getTermCycleAjax();
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
    function getTermCycleAjax() {
        var level_id = $("#level_id").val();
        var session_id = $("#session_id").val();
        if(level_id && session_id){
            $.ajax({
            url: 'getTermCycleAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "session_id": session_id
            },
            success: function(data) {
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