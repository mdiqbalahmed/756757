<?php

$this->Form->unlockField('year');
$this->Form->unlockField('months');
$this->Form->unlockField('full');
$this->Form->unlockField('half');
$this->Form->unlockField('attandance');
$this->Form->unlockField('designation');
$this->Form->unlockField('attandance_grace');
$this->Form->unlockField('attandance_day');
$this->Form->unlockField('attandance_cut_from');
$this->Form->unlockField('absent');
$this->Form->unlockField('absent_cut');
$this->Form->unlockField('absent_cut_from');
$this->Form->unlockField('overtime');
$this->Form->unlockField('config');
$this->Form->unlockField('user_id');
?>
<div>
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <section class="std_info">
        <h4><?= __d('hrs', 'Payroll Generate') ?></h4>
        <div class="row mx-3 mt-2 p-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Months :') ?></label>
                    </div>
                    <div class="col-md-8">
                        <select id="" size="5" class="form-select option-class dropdown260" name="months" required>
                            <?php foreach ($months as $id => $month) {  ?>
                                <option value="<?php echo $month['name']; ?>"><?php echo $month['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Year :') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input name="year" type="text" class="form-control" id="inputSId" value="<?php echo $today = getdate()['year']; ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6" id="show_1">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Full Payroll :') ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-check-input ml-1" type="checkbox" name="full" id="full" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="show_2">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Partial Payroll :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-check-input ml-1" type="checkbox" name="half" id="half" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2 mystyle_hidden" id="show_3">
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Management Type :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <select id="" style="width: 100%;" size="5" class="form-select option-class dropdown260" name="designation[]" multiple>
                                    <?php foreach ($designations as $id => $designation) {  ?>
                                        <option value="<?php echo $designation['id']; ?>"><?php echo $designation['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 mystyle_hidden" id="show_4">
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Employees :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <select id="" style="width: 100%;" size="5" class="form-select option-class dropdown260" name="user_id[]" multiple>
                                    <?php foreach ($users as $id => $user) {  ?>
                                        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Late Attendance :') ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-check-input ml-1" type="checkbox" name="attandance" id="attandance">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2 mystyle_hidden" id="show_5">
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Attendance Grace :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <input id="attandance_grace" name="attandance_grace" type="number" class="form-control" id="inputSId" value="" placeholder="In Minute(s)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 mystyle_hidden" id="show_6">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Days Late For One Salary Deduction :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <input id="attandance_day" name="attandance_day" type="number" class="form-control" id="inputSId" value="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 mystyle_hidden" id="show_7">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Deducation From :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <select id="attandance_cut_from" style="width: 100%;" size="5" class="form-select option-class dropdown260" name="attandance_cut_from">
                                    <option value="basic"><?= __d('hrs', 'Basic Salary') ?></option>
                                    <option value="gross"><?= __d('hrs', 'Gross Salary') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Absent :') ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-check-input ml-1" type="checkbox" name="absent" id="absent">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2 mystyle_hidden" id="show_8">
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Percentage Of Salary Deduction For Absent :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <input name="absent_cut" id="absent_cut" type="number" class="form-control" id="inputSId" value="" placeholder="Between 0 to 100">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 mystyle_hidden" id="show_9">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Deducation From :') ?></label>
                            </div>
                            <div class="col-md-8">
                                <select id="absent_cut_from" style="width: 100%;" size="5" class="form-select option-class dropdown260" name="absent_cut_from">
                                    <option value="basic"><?= __d('hrs', 'Basic Salary') ?></option>
                                    <option value="gross"><?= __d('hrs', 'Gross Salary') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Overtime :') ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-check-input ml-1" type="checkbox" name="overtime">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <h5 class="mt-3"> <?= __d('hrs', 'Payroll configuration setup') ?></h5>
            </div>
            <?php foreach ($hr_config_actions as $id => $config_actions) {
                $id = $config_actions['config_action_id']; ?>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputSId" class="form-label"><?php echo $config_actions['config_action_name']; ?> :</label>
                        </div>
                        <div class="col-md-6">
                            <input name="config[]" class="form-check-input ml-1" type="checkbox" id="full" value="<?php echo $id; ?>">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('hrs', 'Submit') ?></button>
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
</script>

<script type='text/javascript'>
    $('#full').click(function() {
        var element1 = document.getElementById("show_2");
        var checkBox = document.getElementById("full");
        if (checkBox.checked == true) {
            document.getElementById('half').removeAttribute('required');
            element1.classList.add("mystyle_hidden");
        } else {
            document.getElementById('half').setAttribute('required', true);
            element1.classList.remove("mystyle_hidden");
        }
    });
    $('#attandance').click(function() {
        var element1 = document.getElementById("show_5");
        var element2 = document.getElementById("show_6");
        var element3 = document.getElementById("show_7");
        var checkBox = document.getElementById("attandance");
        if (checkBox.checked == true) {
            document.getElementById('attandance_grace').setAttribute('required', true);
            document.getElementById('attandance_day').setAttribute('required', true);
            document.getElementById('attandance_cut_from').setAttribute('required', true);
            element1.classList.remove("mystyle_hidden");
            element2.classList.remove("mystyle_hidden");
            element3.classList.remove("mystyle_hidden");
        } else {
            document.getElementById('attandance_grace').removeAttribute('required');
            document.getElementById('attandance_day').removeAttribute('required');
            document.getElementById('attandance_cut_from').removeAttribute('required');
            element1.classList.add("mystyle_hidden");
            element2.classList.add("mystyle_hidden");
            element3.classList.add("mystyle_hidden");
        }
    });
    $('#absent').click(function() {
        var checkBox = document.getElementById("absent");
        var element1 = document.getElementById("show_8");
        var element2 = document.getElementById("show_9");

        if (checkBox.checked == true) {
            document.getElementById('absent_cut').setAttribute('required', true);
            document.getElementById('absent_cut_from').setAttribute('required', true);
            element1.classList.remove("mystyle_hidden");
            element2.classList.remove("mystyle_hidden");
        } else {
            document.getElementById('absent_cut').removeAttribute('required');
            document.getElementById('absent_cut_from').removeAttribute('required');
            element1.classList.add("mystyle_hidden");
            element2.classList.add("mystyle_hidden");
        }
    });
    $('#half').click(function() {
        var element1 = document.getElementById("show_1");
        var element2 = document.getElementById("show_3");
        var element3 = document.getElementById("show_4");
        var checkBox = document.getElementById("half");
        if (checkBox.checked == true) {
            document.getElementById('full').removeAttribute('required');
            element3.classList.remove("mystyle_hidden");
            element2.classList.remove("mystyle_hidden");
            element1.classList.add("mystyle_hidden");
        } else {
            document.getElementById('full').setAttribute('required', true);
            element3.classList.add("mystyle_hidden");
            element2.classList.add("mystyle_hidden");
            element1.classList.remove("mystyle_hidden");
        }
    });
</script>