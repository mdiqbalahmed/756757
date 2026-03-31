<?php

$this->Form->unlockField('session_from');
$this->Form->unlockField('session_to');
?>

<div>
	<?php echo $this->Form->create(); ?>
    <section>
        <h4><?= __d('setup', 'Promotion Course Cycle') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6  mt-4">
                <label for="inputState" class="form-label"><?= __d('setup', 'Promotion From') ?></label>
                <select class="form-select dropdown260" name="session_from" required>
                    <option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($scms_sessions as $scms_session) { ?>
                    <option value="<?php echo $scms_session['session_id']; ?>"><?php echo $scms_session['session_name']; ?></option>
					<?php } ?>
                </select>
            </div>
            <div class="col-md-6  mt-4">
                <label for="inputState" class="form-label"><?= __d('setup', 'Promotion To') ?></label>
                <select id="level_id" class="form-select dropdown260" name="session_to" required>
                    <option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($scms_sessions as $scms_session) { ?>
                    <option value="<?php echo $scms_session['session_id']; ?>"><?php echo $scms_session['session_name']; ?></option>
					<?php } ?>
                </select>
            </div>
        </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>

    </div>
<?php echo $this->Form->end(); ?>
</div>

