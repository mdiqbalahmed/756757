<?php

$this->Form->unlockField('date');
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h4><?= __d('hrs', 'Search Employee') ?></h4>
        <div class="row mx-3 mt-2 p-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2 mt-1">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Date') ?></label>
                    </div>

                    <div class="col-md-4 ">
                        <input name="date" type="date" class="form-control" id="inputSId" value="<?php echo $date ?>" required>
                    </div>
                    <div class="col-md-2 ">
                        <div class="text-right">
                            <button type="submit" class="btn btn-info"><?= __d('hrs', 'Search') ?></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
      <?php echo $this->Form->end(); ?>
</div>


<div>
    <?php echo $this->Form->create(); ?>
    <?php
$this->Form->unlockField('date');
$this->Form->unlockField('employee_id');
$this->Form->unlockField('id');
$this->Form->unlockField('in_time');
$this->Form->unlockField('out_time');
$this->Form->unlockField('overtime_hours');
$this->Form->unlockField('employee_attendance_id');
$this->Form->unlockField('overtime_amount');

?>
    <section class="std_info mt-4">
        <h4><?= __d('hrs', 'Employee') ?></h4>
        <div class="row mx-3 mt-4 p-3 form-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-1">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'ID') ?></label>
                    </div>
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Name') ?></label>
                    </div>
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'In Time') ?></label>
                    </div>
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Out Time') ?></label>
                    </div>
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Overtime') ?></label>
                    </div>
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Overtime Amount') ?></label>
                    </div>
                </div>
                <?php foreach ($users as $user) { ?>

                <div class="row" style="margin-top: 5px;">
                    <input name="date" type="hidden" class="form-control" id="inputSId" value="<?php echo $date ?>">
                    <input name="employee_id[]" type="hidden" class="form-control" id="inputSId" value="<?php echo $user['employee_id']; ?>">
                    <input name="employee_attendance_id[]" type="hidden" class="form-control" id="inputSId" value="<?php echo $user['employee_attendance_id']; ?>">
                    <input name="id[]" type="hidden" class="form-control" id="inputSId" value="<?php echo $user['id']; ?>">
                    <div class="col-md-1">
                        <label for="inputSId" class="form-label"> <?php echo $user['id']; ?></label>
                    </div>
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"> <?php echo $user['name']; ?></label>
                    </div>
                    <div class="col-md-2">
                        <input name="in_time[]" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $user['in_time']; ?>">
                    </div>
                    <div class="col-md-2">
                        <input name="out_time[]" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $user['out_time']; ?>">
                    </div>
                    <div class="col-md-2">
                        <input name="overtime_hours[]" type="text" class="form-control" id="inputSId" value="<?php echo $user['overtime_hours']; ?>">
                    </div>
                    <div class="col-md-2">
                        <input name="overtime_amount[]" type="text" class="form-control" id="inputSId" value="<?php echo $user['overtime_amount']; ?>">
                    </div>
                </div>

                <?php } ?>
            </div>
        </div>



        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('hrs', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#timepicker').timepicker({});
    });
    $('.timepicker').timepicker({
        timeFormat: 'H:mm',
        startTime: '10:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });
</script>