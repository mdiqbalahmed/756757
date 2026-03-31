<?php

$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
$this->Form->unlockField('bank');
$this->Form->unlockField('role_id');
$this->Form->unlockField('user_id');
$this->Form->unlockField('sid');
$this->Form->unlockField('trn_no');
$this->Form->unlockField('level_id');
$this->Form->unlockField('month_id');
$this->Form->unlockField('report_type');
$this->Form->unlockField('type');

?>


<div class="container">
    <?php echo $this->Form->create(); ?>
    <h3 style="text-align: center;background-color: rgba(0, 0, 0, 0.2);padding: 10px;overflow-x:auto;font-colour: red;">   <?= __d('students', 'Payment Details') ?></h3>
    <section class="bg-light mt-1 p-2 m-auto" action="#">
        <fieldset>
            <div class="row mb-3">

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Roles') ?></p>
                        </div>

                        <div class="col-lg-9 row2Field">
                            <select class="form-control" name="role_id" id="role_id">
                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        <?php foreach ($roles as $role) { ?>
                                <option value="<?= $role['id']; ?>"><?= $role['title']; ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'User') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <select class="form-control" name="user_id" id="user_id">
                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Bank') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <select id="" size="5" class="form-select option-class dropdown260 " name="bank[]" multiple="multiple">
                                <option value=""><?= __d('setup', 'Choose...') ?></option>
                                        <?php foreach ($banks as $bank) { ?>
                                <option value="<?php echo $bank['bank_id']; ?>"><?php echo $bank['bank_name']; ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Level') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <select id="" class="form-select option-class dropdown260 " name="level_id">
                            <?php if (!$required) { ?>
                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                <?php } ?>
                                        <?php foreach ($levels as $level) { ?>
                                <option value="<?php echo $level['level_id']; ?>"><?php echo $level['level_name']; ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'SID') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <input name="sid" type="text" class="form-control" placeholder="SID">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Transaction No') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <input name="trn_no" type="text" class="form-control" placeholder="Transaction No">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Month') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <select id="month_id" multiple class="form-select option-class dropdown260 " name="month_id[]">
                                <option value=""><?= __d('accounts', '-- Choose --') ?></option>
                                            <?php foreach ($months as $month) { ?>
                                <option value="<?php echo $month['id']; ?>"><?php echo $month['month_name']; ?></option>
                                            <?php } ?>>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Report Type') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <select id="type"  class="form-select option-class dropdown260 " name="report_type">
                                <option value="Student">Student Wise</option>
                                <option value="Month">Month Wise</option>
                                <option value="Purpose">Purpose Wise</option>
                                <option value="Class">Class Wise</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Start Date') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <input name="start_date" type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'End Date') ?></p>
                        </div>

                        <div class="col-lg-9 row2Field">
                            <input name="end_date" type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Transaction Type') ?></p>
                        </div>

                        <div class="col-lg-9 row2Field">
                            <select id=""  class="form-select option-class dropdown260 " name="type">
                                <option value="both">Credit & Debit</option>
                                <option value="Credit">Credit</option>
                                <option value="Debit">Debit</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </section>
    <div class="mt-3">
        <button type="submit" class="btn btn-info"><?= __d('result', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
    </div>

</div>
<script type='text/javascript'>
    $(document).ready(function () {
        $("option:selected").map(function () {
            return this.value
        }).get().join(", ");
    });

    $("#role_id").change(function () {
        var role_id = $("#role_id").val();
        $.ajax({
            url: 'getUserAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "role_id": role_id,
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["name"];
                    var id = data[i]["id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#user_id').html(text1);

            }
        });
    });
</script>
