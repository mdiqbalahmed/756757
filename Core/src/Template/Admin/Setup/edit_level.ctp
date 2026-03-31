<?php $this->Form->unlockField('level_name'); ?>
<?php $this->Form->unlockField('level_id'); ?>
<?php $this->Form->unlockField('department_id'); ?>


<div>
	<?php echo $this->Form->create(); ?>
	<section>
		<h4><?= __d('setup', 'Level Information') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-6 mt-2">
				<label for="inputBR" class="form-label"><?= __d('setup', 'Add A Level') ?></label>
				<input name="level_name" type="text" class="form-control" id="" placeholder="" value="<?php echo $levels[0]['level_name']; ?>">
				<input name="level_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $levels[0]['level_id']; ?>">
			</div>
			<div class="col-6  mt-2">
				<label for="inputState" class="form-label"><?= __d('setup', 'Departments') ?></label>
				<select id="inputState" class="form-select dropdown260" name="department_id">
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($departments as $department) { ?>
						<option value="<?php echo $department['department_id']; ?>"
						 <?php if ($department['department_id'] == $levels[0]['department_id']) {echo 'Selected';} ?>>
							<?php echo $department['department_name']; ?></option>
					<?php } ?>
				</select>
			</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'level'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>