<?php $this->Form->unlockField('session_name'); ?>
<?php $this->Form->unlockField('start_date'); ?>
<?php $this->Form->unlockField('end_date'); ?>

<div>

	<?php echo $this->Form->create(); ?>
	<section>
		<h4><?= __d('setup', 'Add a Session') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-6 mt-2">
				<label class="form-label"><?= __d('setup', 'Session Name') ?></label>
				<input name="session_name" type="text" class="form-control" placeholder="Session Name" required>
			</div>
			<div class="col-3 mt-2">
				<label class="form-label"><?= __d('setup', 'Start Date') ?></label>
				<input name="start_date" type="date" class="form-control" placeholder="Start Date" value="<?= date('Y-01-01'); ?>">
			</div>
			<div class="col-3 mt-2">
				<label class="form-label"><?= __d('setup', 'End Date') ?></label>
				<input name="end_date" type="date" class="form-control" placeholder="End Date" value="<?= date('Y-12-01'); ?>">
			</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'Session'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>