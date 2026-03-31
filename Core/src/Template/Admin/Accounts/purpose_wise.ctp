<?php

$this->Form->unlockField('session');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('purpose_id');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div class="header">

        </div>
        <?php echo $this->Form->create(); ?>
        <div class="form">
            <section>
                <h3
                    style="text-align: center;background-color: rgba(0, 0, 0, 0.2);padding: 10px;overflow-x:auto;font-colour: red;">
                    Purpose Wise Report</h3>
                <div class="row p-2">
                    <div class="col-md-6 ">
                        <label for="inputState" class="form-label"><?= __d('setup', '*Session') ?></label>
                        <select id="session" class="form-select option-class dropdown260 " name="session" required>
                            <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            <?php foreach ($sessions as $session) { ?>
                                <option value="<?php echo $session['session_id']; ?>" <?php if ($active_session_id == $session['session_id']) {
                                       echo 'Selected';
                                   } ?>><?php echo $session['session_name']; ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
                        <select id="level_id" class="form-select option-class dropdown260 " name="level_id">

                            <?php foreach ($levels as $level) { ?>
                                <option value="<?php echo $level['level_id']; ?>"><?php echo $level['level_name']; ?>
                                </option>
                            <?php } ?>>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Section') ?></label>
                        <select id="section_id" class="form-select option-class dropdown260 " name="section_id">
                            <?php if (!$required) { ?>
                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                            <?php } ?>
                            <?php foreach ($sections as $section) { ?>
                                <option value="<?php echo $section['section_id']; ?>">
                                    <?php echo $section['section_name']; ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Purpose') ?></label>
                        <select multiple class="form-select option-class dropdown260 " name="purpose_id">
                            <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            <?php foreach ($purposes as $purpose) { ?>
                                <option value="<?php echo $purpose['purpose_id']; ?>">
                                    <?php echo $purpose['purpose_name']; ?>
                                </option>
                            <?php } ?>>
                        </select>
                    </div>

                </div>
            </section>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

</body>

</html>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#session_id").change(function () {
        getSectionAjax();
    });
    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var session_id = $("#session_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "session_id": session_id,
                "type": 'accounts'
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
</script>