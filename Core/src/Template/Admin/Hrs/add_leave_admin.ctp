<?php

$this->Form->unlockField('employee_id');
$this->Form->unlockField('config_action_setup_id');
$this->Form->unlockField('date_from');
$this->Form->unlockField('date_to');
$this->Form->unlockField('half_leave');
$this->Form->unlockField('body');
$this->Form->unlockField('file');
$this->Form->unlockField('half_leave_type');
$this->Form->unlockField('approval');
$this->Form->unlockField('comment');




?>

<div class="container border-bottom ">
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <div class="row">
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Employee :') ?></label>
                </div>
                <div class="col-md-10">
                    <select  class="form-select option-class dropdown260" id="employee_id" name="employee_id" required>
                        <option value=""><?= __d('hrs', 'Choose Employee') ?></option>
                        <?php foreach ($employees as $employee) { ?>
                        <option value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Leave Type :') ?></label>
                </div>
                <div class="col-md-10">
                    <select id="config_action_setup_id" class="form-select option-class dropdown260" name="config_action_setup_id" required>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Start Date :') ?></label>
                </div>
                <div class="col-md-8">
                    <input name="date_from" type="date" class="form-control" id="StartDateValue" placeholder="Leave Type" required>
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3" id="endDateDiv">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'End Date :') ?></label>
                </div>
                <div class="col-md-8">
                    <input name="date_to" type="date" class="form-control" id="endDateValue" value="">
                </div>
            </div>
        </div>

        <div class="col-md-6  mt-3" id="showCheckbox">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Half Leave :') ?></label>
                </div>
                <div class="col-md-8 form-check form-switch">
                    <input name="half_leave" class="form-check-input ml-1" type="checkbox" id="halfLeaveCheck" value="1">
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3 mystyle_hidden" id="showDropdown">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Half Leave Type :') ?></label>
                </div>
                <div class="col-md-8 form-check form-switch">
                    <select id="halfLeaveType" class="form-select option-class dropdown260 " name="half_leave_type">
                        <option value=""><?= __d('hrs', 'Choose Half Leave Type') ?></option>
                        <option value="1"><?= __d('hrs', 'First Half') ?></option>
                        <option value="2"><?= __d('hrs', 'Second Half') ?></option>

                    </select>
                </div>
            </div>
        </div>  

        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Body :') ?></label>
                </div>
                <div class="col-md-10">
                    <textarea name="body" class="form-control " placeholder="Write a few more about the leave reason" id="" rows="4" cols="120"></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class=" Xlabel-height form-label"><?= __d('hrs', 'Attachments :') ?></label>
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
        <div class="col-md-6  mt-3">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Approval :') ?></label>
                </div>
                <div class="col-md-8">
                    <select id="inputState" class="form-select option-class dropdown260" name="approval" required>
                        <option value="">Choose Action</option>
                        <?php foreach ($approvals as $approval) { ?>
                        <option value="<?php echo $approval ?>"><?php echo $approval ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Comment :') ?></label>
                </div>
                <div class="col-md-10">
                    <textarea name="comment" class="form-control" placeholder="Comment anything if requires.. " rows="4" cols="120"></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right mt-5 mb-4">
            <button type="submit" class="btn btn-info"><?= __d('hrs', 'Submit') ?></button>
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
    
    $("#employee_id").change(function() {
        var employee_id = $("#employee_id").val();
            $.ajax({
            url: 'getLeaveAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "employee_id": employee_id
            },
            success: function(data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["config_action_name"];
                    var id = data[i]["config_action_setup_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#config_action_setup_id').html(text1);
       
            }
        }); 
    });
</script>