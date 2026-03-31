<?php

$this->Form->unlockField('session');
$this->Form->unlockField('level_id');
$this->Form->unlockField('department_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('report_type');
$this->Form->unlockField('month_id');
$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
$this->Form->unlockField('sid');

$session_id = isset($request_data['session_id']) ? $request_data['session_id'] : $active_session_id;
$level_id = isset($request_data['level_id']) ? $request_data['level_id'] : '';
$department_id = isset($request_data['department_id']) ? $request_data['department_id'] : '';
$section_id = isset($request_data['section_id']) ? $request_data['section_id'] : '';
$type = isset($request_data['report_type']) ? $request_data['report_type'] : '';
$start_date = isset($request_data['start_date']) ? $request_data['start_date'] : '';
$end_date = isset($request_data['end_date']) ? $request_data['end_date'] : '';
$month_id = isset($request_data['month_id']) ? $request_data['month_id'] : array();

$sid = isset($request_data['sid']) ? $request_data['sid'] : '';

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
                    Search Due & Send SMS</h3>
                <div class="row p-2">
                    <div class="col-md-6 ">
                        <label for="inputState" class="form-label"><?= __d('setup', '*Session') ?></label>
                        <select id="session" class="form-select option-class dropdown260 " name="session" required>
                            <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            <?php foreach ($sessions as $session) { ?>
                                <option value="<?php echo $session['session_id']; ?>" <?php if ($session_id == $session['session_id']) {
                                       echo 'Selected';
                                   } ?>><?php echo $session['session_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 ">
                        <label for="inputState" class="form-label"><?= __d('setup', 'SID') ?></label>
                        <input type="text" id="sid" value="<?php echo $sid; ?>" class="form-select" name="sid">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Department') ?></label>
                        <select id="department_id" class="form-select option-class dropdown260 " name="department_id">

                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department['department_id']; ?>" <?php if ($department_id == $department['department_id']) {
                                       echo 'Selected';
                                   } ?>>
                                    <?php echo $department['department_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
                        <select id="level_id" class="form-select option-class dropdown260 " name="level_id">
<option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            <?php foreach ($levels as $level) { ?>
                                <option value="<?php echo $level['level_id']; ?>" <?php if ($level_id == $level['level_id']) {
                                       echo 'Selected';
                                   } ?>><?php echo $level['level_name']; ?>
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
                                                <option value="<?php echo $section['section_id']; ?>" <?php if ($section_id == $section['section_id']) {
                                                       echo 'Selected';
                                                   } ?>><?php echo $section['section_name']; ?> </option>
                                            <?php } ?>

                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Month') ?></label>
                        <select id="month_id" multiple class="form-select option-class dropdown260 " name="month_id[]">
                            <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                            <?php foreach ($months as $month) { ?>
                                <option value="<?php echo $month['id']; ?>" <?php if (in_array($month['id'], $month_id)) {
                                       echo 'Selected';
                                   } ?>><?php echo $month['month_name']; ?></option>
                            <?php } ?>>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Type') ?></label>
                        <select id="type" class="form-select option-class dropdown260 " name="report_type">
                            <option value="Student" <?php if ('Student' == $type) {
                                       echo 'Selected';
                                   } ?> >Student Wise</option>
                            <option value="Month" <?php if ('Month' == $type) {
                                       echo 'Selected';
                                   } ?>>Month Wise</option>
                            <option value="Purpose" <?php if ('Purpose' == $type) {
                                       echo 'Selected';
                                   } ?>>Purpose Wise</option>
                            <option value="Class" <?php if ('Class' == $type) {
                                       echo 'Selected';
                                   } ?>>Class Wise</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState"
                            class="form-label"><?= __d('setup', 'Start Date(Voucher Create)') ?></label>
                        <input name="start_date" type="datetime-local" class="form-control" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState"
                            class="form-label"><?= __d('setup', 'End Date(Voucher Create)') ?></label>
                        <input name="end_date" type="datetime-local" class="form-control" value="<?php echo $end_date; ?>">
                    </div>
                </div>
            </section>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

    <?php if (isset($show_data)) { ?>
        <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">


            <?php echo $this->Form->create(); ?>
            <?php

            $this->Form->unlockField('sms');

            ?>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <?php foreach ($table_row as $key => $row) {
                            $align = 'center';
                            if ($key == count($table_row) - 1) {
                                $align = 'right';
                            }
                            ?>
                            <th style="text-align: <?php echo $align; ?> "> <?php echo $row; ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($show_data as $rowIndex => $data_array) {
                        ?>
                        <tr>
                            <?php foreach ($data_array as $key => $data) {
                                $align = 'center';
                                if ($key == count($data_array) - 1) {
                                    $align = 'right';
                                    $data = number_format((float) $data, 2, '.', '');
                                }
                                ?>
                                <td style="text-align: <?php echo $align; ?> ">
                                    <?php
                                    // Check if it's the last element of the array
                                    if ($key == count($data_array) - 1) {
                                        // Create a read-only input field for the last value
                                        echo $this->Form->input("inputValue[{$rowIndex}]", [
                                            'type' => 'text',
                                            'value' => $data,
                                            'style' => 'text-align: ' . $align . ';',
                                            'class' => 'form-control',
                                            'label' => false,
                                            'readonly' => true,
                                        ]);
                                    } else {
                                        echo htmlspecialchars($data);
                                    }
                                    ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>


            <div class="text-right mt-4 mb-4">
                <span style="margin-right:20px;"><input type="checkbox" class="sms" id="sms" name="sms" value="1"> Send
                    SMS</span>
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    <?php } ?>


</body>

</html>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#department_id").change(function () {
        getDeptAjax();
    });

    function getDeptAjax() {
        var department_id = $("#department_id").val();
        $.ajax({
            url: 'getDeptAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "department_id": department_id
            },
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["level_name"];
                    var id = data[i]["level_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#level_id').html(text1);

            }
        });
    }

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