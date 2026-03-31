<?php
$this->Form->unlockField('session_name'); ?>
<?php $this->Form->unlockField('session_id'); ?>
<?php $this->Form->unlockField('start_date'); ?>
<?php $this->Form->unlockField('end_date'); ?>
<?php $this->Form->unlockField('active'); ?>
<div>
	<?php echo $this->Form->create(); ?>
    <section>
        <h4><?= __d('setup', 'Session Information') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-3 mt-2">
                <label class="form-label"><?= __d('setup', 'Session Name') ?></label>
                <input name="session_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $sessions[0]['session_id']; ?>">
                <input name="session_name" type="text" class="form-control" placeholder="Session Name" value="<?php echo $sessions[0]['session_name']; ?>" required>
            </div>
            <div class="col-3 mt-2">
                <label class="form-label"><?= __d('setup', 'Start Date') ?></label>
                <input name="start_date" type="date" class="form-control" placeholder="Session Name" value="<?php echo $sessions[0]['start_date']; ?>">
            </div>
            <div class="col-3 mt-2">
                <label class="form-label"><?= __d('setup', 'End Date') ?></label>
                <input name="end_date" type="date" class="form-control" placeholder="Session Name" value="<?php echo $sessions[0]['end_date']; ?>">
            </div>
            <div class="col-3 mt-2">
                <label class="form-label"><?= __d('setup', 'Active Session') ?></label>
                <select id="inputState" class="form-select option-class dropdown260" name="active">
                    <option value=""><?= __d('setup', 'Choose...') ?></option>
                    <option value="1"<?php if (1 == $sessions[0]['active']) {echo 'Selected';} ?>>Active </option>
                </select>
            </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'session'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
    </div>
</div>