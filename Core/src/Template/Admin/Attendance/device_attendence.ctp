<?php
$this->Form->unlockField('date');
$this->Form->unlockField('term_id');
$this->Form->unlockField('sms');
?>
<div>
    <div class="header">
        <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Device Attendence') ?>
        </h3>
    </div>
     <?php echo $this->Form->create('Attendences', array('action' => 'deviceAttendence')); ?>
    <section class="bg-light mt-3 p-4 m-auto" action="#">
        <fieldset>
            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Date') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <input name="date" type="date" class="form-control" required="true">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-3">
                            <p class="label-font13"><?= __d('students', 'Term') ?></p>
                        </div>
                        <div class="col-lg-9 row2Field">
                            <select class="form-control" name="term_id" id="term_id" required>
                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                 <?php foreach ($terms as $term) { ?>
                                <option value="<?php echo $term['term_id']; ?>"><?php echo $term['term_name']; ?></option>
                                              <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </section>
    <div class="text-right mt-4 mb-4">
        <span style="margin-right:20px;"><input type="checkbox" class="sms" id="sms" name="sms" value="1">  Send SMS</span>
        <button type="submit" class="btn btn-info">Give Attendance</button>
    </div>
            <?php echo $this->Form->end(); ?>
</div>  


