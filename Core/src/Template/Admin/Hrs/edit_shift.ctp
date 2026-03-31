<?php

$this->Form->unlockField('shift_name');
$this->Form->unlockField('monday_in_time');
$this->Form->unlockField('monday_out_time');
$this->Form->unlockField('tuesday_in_time');
$this->Form->unlockField('tuesday_out_time');
$this->Form->unlockField('wednesday_in_time');
$this->Form->unlockField('wednesday_out_time');
$this->Form->unlockField('thursday_in_time');
$this->Form->unlockField('thursday_out_time');
$this->Form->unlockField('friday_in_time');
$this->Form->unlockField('friday_out_time');
$this->Form->unlockField('saturday_in_time');
$this->Form->unlockField('saturday_out_time');
$this->Form->unlockField('sunday_in_time');
$this->Form->unlockField('sunday_out_time');
$this->Form->unlockField('break_out_time');
$this->Form->unlockField('break_in_time');
$this->Form->unlockField('shift_id');
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h4><?= __d('hrs', 'Add Shif') ?>t</h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Shift Name:') ?> </label>
                    </div>
                    <div class="col-md-8">
                        <input name="shift_name" type="text" class="form-control" id="inputSId" value="<?php echo $shifts[0]['shift_name'] ?>" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Monday:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="monday_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['monday_in_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="monday_out_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['monday_out_time'] ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Tuesday:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="tuesday_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['tuesday_in_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="tuesday_out_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['tuesday_out_time'] ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Wednesday:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="wednesday_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['wednesday_in_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="wednesday_out_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['wednesday_out_time'] ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Thursday:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="thursday_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['thursday_in_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="thursday_out_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['thursday_out_time'] ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Friday:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="friday_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['friday_in_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="friday_out_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['friday_out_time'] ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Saturday:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="saturday_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['saturday_in_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="saturday_out_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['saturday_out_time'] ?>">
                    </div>
                </div>
            </div><!-- comment -->
            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Sunday:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="sunday_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['sunday_in_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="sunday_out_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['sunday_out_time'] ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row mt-3" >
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Break:') ?></label>
                    </div>
                    <div class="col-md-4">
                        <input name="break_out_time" type="text" class="form-control timepicker" id="timepicker" value="<?php echo $shifts[0]['break_out_time'] ?>">
                    </div>
                    <div class="col-md-4">
                        <input name="break_in_time" type="text" class="form-control timepicker" id="inputSId" value="<?php echo $shifts[0]['break_in_time'] ?>">
                    </div>
                </div>
            </div>
            <input name="shift_id" type="hidden" class="form-control"  value="<?php echo $shifts[0]['shift_id'];?>">
            <div class="text-right mt-5">
                <button type="submit" class="btn btn-info"><?= __d('hrs', 'Update') ?></button>
            <?php echo $this->Form->end(); ?>
            </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function(){
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