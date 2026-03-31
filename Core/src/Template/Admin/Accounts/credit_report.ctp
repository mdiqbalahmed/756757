<?php

$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
$this->Form->unlockField('purpose');
$this->Form->unlockField('bank');
$this->Form->unlockField('role_id');
$this->Form->unlockField('user_id');
$this->Form->unlockField('sid');
$this->Form->unlockField('voucher_no');

?>


<div>
    <?php echo $this->Form->create(); ?>
    <div class="header">
        <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
            <?= __d('students', 'Search Credits') ?>
        </h3>
    </div>
    <section class="bg-light mt-3 p-4 m-auto" action="#">
        <section class="bg-light mt-1 p-2 m-auto" action="#">
            <fieldset>
                <div class=" form_area p-2">
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'Start Date') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <input name="start_date" type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'End Date') ?></p>
                                </div>

                                <div class="col-lg-9 row2Field">
                                    <input name="end_date" type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-4">
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
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'Purpose') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="purpose[]" id="" multiple="multiple">
                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        <?php foreach ($purposes as $purpose) { ?>
                                            <option value="<?= $purpose['purpose_id']; ?>"><?= $purpose['purpose_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
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
                    </div>
                    <div class="row mb-3">
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

                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'Voucher No') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <input name="voucher_no" type="text" class="form-control" placeholder="Voucher No">
                                </div>
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
    </section>
</div>
<script type='text/javascript'>
    $(document).ready(function() {
        $("option:selected").map(function() {
            return this.value
        }).get().join(", ");
    });

    $("#role_id").change(function() {
        var role_id = $("#role_id").val();
        $.ajax({
            url: 'getUserAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "role_id": role_id,
            },
            success: function(data) {
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
