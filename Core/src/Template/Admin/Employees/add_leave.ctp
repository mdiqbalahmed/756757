<?php
$this->Form->unlockField('config_action_setup_id');
$this->Form->unlockField('date_from');
$this->Form->unlockField('date_to');
$this->Form->unlockField('half_leave');
$this->Form->unlockField('body');
$this->Form->unlockField('file');
$this->Form->unlockField('half_leave_type');



?>

<div class="container border-bottom ">
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <div class="row">
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('employees', 'Leave Type :') ?></label>
                </div>
                <div class="col-md-10">
                    <select id="inputState" class="form-select option-class dropdown260" name="config_action_setup_id" required>
                        <option value=""><?= __d('employees', 'Choose Leave Type') ?></option>
                        <?php foreach ($leave_type as $leave) { ?>
                            <option value="<?php echo $leave['config_action_setup_id']; ?>"><?php echo $leave['config_action_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('employees', 'Start Date :') ?></label>
                </div>
                <div class="col-md-8">
                    <input name="date_from" type="date" class="form-control" id="StartDateValue" placeholder="Leave Type" required>
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3" id="endDateDiv">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('employees', 'End Date :') ?></label>
                </div>
                <div class="col-md-8">
                    <input name="date_to" type="date" class="form-control" id="endDateValue" value="">
                </div>
            </div>
        </div>

        <div class="col-md-6  mt-3" id="showCheckbox">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('employees', 'Half Leave :') ?></label>
                </div>
                <div class="col-md-8 form-check form-switch">
                    <input name="half_leave" class="form-check-input ml-1" type="checkbox" id="halfLeaveCheck" value="1">
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3 mystyle_hidden" id="showDropdown">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('employees', 'Half Leave Type :') ?></label>
                </div>
                <div class="col-md-8 form-check form-switch">
                    <select id="halfLeaveType" class="form-select option-class dropdown260 " name="half_leave_type">
                        <option value=""><?= __d('employees', 'Choose Half Leave Type') ?></option>
                        <option value="1"><?= __d('employees', 'First Half') ?></option>
                        <option value="2"><?= __d('employees', 'Second Half') ?></option>

                    </select>
                </div>
            </div>
        </div>  

        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('employees', 'Body :') ?></label>
                </div>
                <div class="col-md-10">
                    <textarea name="body" class="form-control " placeholder="Write a few more about the leave reason" id="" rows="4" cols="120"></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class=" Xlabel-height form-label"><?= __d('employees', 'Attachments :') ?></label>
                </div>
                <div class="col-md-10 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <?php echo $this->form->file('file'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right mt-5 mb-4">
            <button type="submit" class="btn btn-info"><?= __d('employees', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
        </div>

    </div>
</div>

<script type='text/javascript'>
    $('#endDateValue').change(function() {
        var cut_off = $('#endDateValue').val();
        var element1 = document.getElementById("showCheckbox");
        var element2 = document.getElementById("showDropdown");

        if (cut_off == "") {
            element1.classList.remove("mystyle_hidden");
            element2.classList.remove("mystyle_hidden");

        } else {
            element1.classList.add("mystyle_hidden");
            element2.classList.add("mystyle_hidden");
        }
    });


    $('#halfLeaveCheck').click(function() {
        var element1 = document.getElementById("showDropdown");
        var checkBox = document.getElementById("halfLeaveCheck");
        var element2 = document.getElementById("endDateDiv");

        if (checkBox.checked == true) {
            document.getElementById('halfLeaveType').setAttribute('required', true);
            element1.classList.remove("mystyle_hidden");
            element2.classList.add("mystyle_hidden")

        } else {
            document.getElementById('halfLeaveType').removeAttribute('required');
            element1.classList.add("mystyle_hidden");
            element2.classList.remove("mystyle_hidden");

        }
    });
</script>