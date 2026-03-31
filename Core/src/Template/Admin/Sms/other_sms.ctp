

<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('type');

use Cake\Core\Configure;

$attendance_type = Configure::read('Attendance.Type');
$types = [
    'due_sms' => 'Due Sms',
    'birthday' => 'Birthday',
];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Attendance Form</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('attendance', 'Student Search') ?>
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
                                                <option value="<?= $session['session_id'] ?>"
                                                    <?= (!empty($data['session_id']) && $data['session_id'] == $session['session_id']) ? 'selected' : '' ?>>
                                                    <?= $session['session_name'] ?>
                                                </option>
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
                                                <option value="<?= $shift['shift_id'] ?>"
                                                    <?= (!empty($data['shift_id']) && $data['shift_id'] == $shift['shift_id']) ? 'selected' : '' ?>>
                                                    <?= $shift['shift_name'] ?>
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
                                        <select class="form-control" name="level_id" id="level_id">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                                                <option value="<?= $level['level_id'] ?>"
                                                    <?= (!empty($data['level_id']) && $data['level_id'] == $level['level_id']) ? 'selected' : '' ?>>
                                                    <?= $level['level_name'] ?>
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
                                                <option value="<?= $section['section_id'] ?>"
                                                    <?= (!empty($data['section_id']) && $data['section_id'] == $section['section_id']) ? 'selected' : '' ?>>
                                                    <?= $section['section_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Type') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="type">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($types as $key => $type) { ?>
                                                <option value="<?= $key ?>"
                                                    <?= (!empty($data['type']) && $data['type'] == $key) ? 'selected' : '' ?>>
                                                    <?= $type ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">


                            <div class="col-lg-4">

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

    <?php if (isset($students)): ?>
    <div class="container mt-5 p-3 bg-light border rounded">
        <?= $this->Form->create(null) ?>
        <?php
            $this->Form->unlockField('student_id');
            $this->Form->unlockField('user_id');
            $this->Form->unlockField('sms');
            $this->Form->unlockField('date');
            $this->Form->unlockField('text');
            $this->Form->unlockField('type');
            ?>
        
        
        <?php if (!empty($request_data['type']) && $request_data['type'] === 'birthday'): ?>
            <div class="alert alert-success text-center fw-bold">
                🎉 Today is the birthday of the following students:
            </div>
        <?php endif; ?>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center"><input type="checkbox" id="check_all"> All</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): //echo '<pre>';print_r($request_data);die;?>
                <tr>
                    <td><?= h($student['name']) ?></td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox_attend" name="student_id[]"
                            value="<?= h($student['student_id']) ?>">
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <div class="form-group">
                            <?= $this->Form->hidden('box_size', ['value' => $box_count, 'id' => 'box_size']) ?>
                            <textarea name="text" maxlength="<?= $char_count ?>" class="form-control"
                                placeholder="Write SMS Here..." id="sms-area" rows="4"><?= $smsFooter ?></textarea>
                            <p id="count" class="text-end text-muted mt-2">
                                Characters: <strong>0/<?= $char_count ?></strong> SMS Parts:
                                <strong>0/<?= $box_count ?></strong>
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <?= $this->Form->hidden('user_id', ['value' => $data['user_id']]) ?>
        <?= $this->Form->hidden('session_id', ['value' => $data['session_id']]) ?>
        <?= $this->Form->hidden('shift_id', ['value' => $data['shift_id']]) ?>
        <?= $this->Form->hidden('level_id', ['value' => $data['level_id']]) ?>
        <?= $this->Form->hidden('section_id', ['value' => $data['section_id']]) ?>
        <?= $this->Form->hidden('date', ['value' => $data['date']]) ?>
        <?= $this->Form->hidden('type', ['value' => $data['type']]) ?>

        <div class="text-end mt-4">
            <label class="me-2">
                <input type="checkbox" class="sms" name="sms" value="1"> Send SMS
            </label>
            <button type="submit" class="btn btn-info">SUBMIT</button>
        </div>

        <?= $this->Form->end() ?>
    </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        // Check All
        $("#check_all").on('change', function() {
            $(".checkbox_attend").prop("checked", this.checked);
        });

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

        // SMS Counter
        const SMSCalculator = {
            encoding: {
                GSM_7BIT_EX: [160, 146, 153],
                UTF16: [70, 64, 67]
            },
            charset: {
                gsm: "@£$¥èéùìòÇ\nØø\rÅåΔ_ΦΓΛΩΠΨΣΘΞÆæßÉ !\"#¤%&'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà",
                gsmEscaped: "\\^{}\\\\\\[~\\]|€"
            },
            regex() {
                return {
                    gsm: new RegExp(`^[${this.charset.gsm}]*$`),
                    gsmEscaped: new RegExp(`[${this.charset.gsmEscaped}]`, 'g'),
                    gsmFull: new RegExp(`^[${this.charset.gsm}${this.charset.gsmEscaped}]*$`)
                };
            },
            detectEncoding(text) {
                if (this.regex().gsm.test(text)) return '7BIT';
                if (this.regex().gsmFull.test(text)) return '7BIT_EX';
                return 'UTF16';
            },
            getEscapedCharCount(text) {
                return (text.match(this.regex().gsmEscaped) || []).length;
            },
            getCount(text) {
                let type = this.detectEncoding(text);
                let length = text.length;
                const boxSize = parseInt(document.getElementById("box_size").value);

                if (type === '7BIT_EX') length += this.getEscapedCharCount(text);

                let limit = type === 'UTF16' ? 50 : 130;
                let perPart = type === 'UTF16' ? 67 : 153;
                let parts = 1;

                if (length > limit) {
                    parts = Math.ceil(length / perPart);
                    limit = parts * perPart;
                }

                document.getElementById("sms-area").maxLength = limit;
                document.getElementById("count").innerHTML =
                    `Characters: <strong>${length}/${limit}</strong> SMS Parts: <strong>${parts}/${boxSize}</strong>`;
            }
        };

        const smsArea = document.getElementById("sms-area");
        smsArea.addEventListener("input", function() {
            SMSCalculator.getCount(this.value);
        });

        SMSCalculator.getCount(smsArea.value); // initial load
    });
    </script>
</body>

</html>