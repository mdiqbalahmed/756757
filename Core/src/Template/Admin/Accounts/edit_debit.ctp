<?php

$this->Form->unlockField('purpose_id'); ?>
<?php $this->Form->unlockField('reason'); ?>
<?php $this->Form->unlockField('amount'); ?>
<?php $this->Form->unlockField('transaction_date'); ?>
<?php $this->Form->unlockField('type'); ?>
<?php $this->Form->unlockField('transaction_type'); ?>

<?php $this->Form->unlockField('sid'); ?>
<?php $this->Form->unlockField('other'); ?>
<?php $this->Form->unlockField('employee_id'); ?>
<?php $this->Form->unlockField('bank_id'); ?>
<?php $this->Form->unlockField('note'); ?>
<?php $this->Form->unlockField('user_id'); ?>
<?php $this->Form->unlockField('session_id'); ?>
<?php $this->Form->unlockField('month_ids'); ?>
<?php $this->Form->unlockField('transaction_id'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div>
    <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('accounts', 'Edit Transaction(Debit)') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class='col-md-6 col-12 mt-2'>
                <label class="form-label"><?= __d('accounts', 'Transaction Date') ?></label>
                <input type="datetime-local" name="transaction_date" class="form-control" value="<?= date("Y-m-d H:i:s", strtotime($transactions['transaction_date']) + 6 * 3600); ?>" required>
            </div>
            <input type="hidden" name="transaction_type" class="form-control" value="Debit">
            <input type="hidden" name="transaction_id" class="form-control" value="<?= $transactions['transaction_id'] ?>">
            <div class="col-md-6 col-12 mt-2">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Purpose') ?></label>
                <select id="inputState" class="form-select option-class" name="purpose_id" required>
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($options as $value => $text) { ?>
                    <option value="<?= $value ?>"   <?php if($value==$transactions['purpose_id']){echo 'selected';} ?>><?= h($text) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Select Type') ?></label>
                <select class="form-control" name="type" id="type">
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <option value="Student"<?php if('Student'==$transactions['type']){echo 'selected';} ?> >School Student</option>
                    <option value="Staff"<?php if('Staff'==$transactions['type']){echo 'selected';} ?> >Staff</option>
                    <option value="Other"<?php if('Other'==$transactions['type']){echo 'selected';} ?> >Other</option>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <div class="<?php if('Student'!=$transactions['type']){echo 'mystyle_hidden';} ?> " id="student">
                    <label for="inputState" class="form-label"><?= __d('accounts', 'Student ID') ?></label>
                    <input type="number" name="sid" value="<?= $transactions['sid'] ?>" id="sid" class="form-control">
                </div>
                <div class="<?php if('Other'!=$transactions['type']){echo 'mystyle_hidden';} ?>" id="others">
                    <label for="inputState" class="form-label"><?= __d('accounts', 'Others') ?></label>
                    <input type="number" name="other" value="<?= $transactions['other'] ?> id="other" class="form-control">
                </div>
                <div class=" <?php if('Staff'!=$transactions['type']){echo 'mystyle_hidden';} ?>" id="staff">
                    <label for="inputState" class="form-label"><?= __d('accounts', 'Employee') ?></label>
                    <select  class="form-select option-class" name="employee_id" id="employee_id">
                        <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($employees  as $employee) { ?>
                        <option value="<?= $employee->employee_id ?>" <?php if($employee->employee_id==$transactions['employee_id']){echo 'selected';} ?>><?= h($employee->name) ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Session') ?></label>
                <select id="session_id" class="form-select option-class" name="session_id" required>
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($sessions as $session) { ?>
                    <option value="<?= $session->session_id; ?>"   <?php if($session->session_id==$transactions['session_id']){echo 'selected';} ?>><?= $session->session_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Months') ?></label>
                <select id="month_id" class="form-select option-class" name="month_ids" required>
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($months as $month) { ?>
                    <option value="<?= $month['id']; ?> " <?php if($month['id']==$transactions['month_ids']){echo 'selected';} ?>><?= $month['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Bank Name') ?></label>
                <select id="inputState" class="form-select option-class" name="bank_id" required>
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($banks as $bank) { ?>
                    <option value="<?= $bank['bank_id']; ?>"<?php if($bank['bank_id']==$transactions['bank_id']){echo 'selected';} ?>><?= $bank['bank_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <label class="form-label"><?= __d('accounts', 'Amount') ?></label>
                <input name="amount" type="number" value="<?= ($transactions['amount'])*-1 ?>" class="form-control"  required>
            </div>
            <div class="col-12 mt-1">
                <label class="form-label"><?= __d('accounts', 'Note') ?></label>
                <textarea name="note" class="form-control " placeholder="Write a few more if needed...." id="" rows="4" cols="120"> <?= $transactions['note'] ?></textarea>
            </div>
        </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info text-light"><?= __d('accounts', 'Submit') ?></button>
        <?= $this->Html->Link('Back', ['action' => 'purposes'], ['class' => 'btn ']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
    $("#session_id").change(function () {
        var session_id = $("#session_id").val();
        $.ajax({
            url: 'getMonthsFrromSessionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "session_id": session_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["name"];
                    var id = data[i]["id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#month_id').html(text1);
            }
        });
    });
    $("#type").change(function () {
        var Student = document.getElementById("student");
        var Staff = document.getElementById("staff");
        var Other = document.getElementById("others");
        var type = $("#type").val();
        if (type == 'Student') {
            $("#sid").attr("required", true);
            $("#other").attr("required", false);
            $("#employee_id").attr("required", false);
            Student.classList.remove("mystyle_hidden");
            Staff.classList.add("mystyle_hidden");
            Other.classList.add("mystyle_hidden");
        } else if (type == 'Staff') {
            $("#sid").attr("required", false);
            $("#other").attr("required", false);
            $("#employee_id").attr("required", true);
            Student.classList.add("mystyle_hidden");
            Staff.classList.remove("mystyle_hidden");
            Other.classList.add("mystyle_hidden");
        } else if (type == 'Other') {
            $("#sid").attr("required", false);
            $("#other").attr("required", true);
            $("#employee_id").attr("required", false);
            Student.classList.add("mystyle_hidden");
            Staff.classList.add("mystyle_hidden");
            Other.classList.remove("mystyle_hidden");
        } else {
            $("#sid").attr("required", false);
            $("#other").attr("required", false);
            $("#employee_id").attr("required", false);
            Student.classList.add("mystyle_hidden");
            Staff.classList.add("mystyle_hidden");
            Other.classList.add("mystyle_hidden");
        }
    });
</script>

<script type="text/javascript">
    config = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        today
    };
    flatpickr("input[type=datetime-local]", config);
</script>
