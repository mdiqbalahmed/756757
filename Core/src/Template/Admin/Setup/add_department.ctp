<?php $this->Form->unlockField('department_name'); ?>
<?php $this->Form->unlockField('faculty_id'); ?>

<div>

	<?php echo $this->Form->create(); ?>
	<section>
		<h4><?= __d('setup', 'Add a Department') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-6 mt-2">
				<label for="inputBR" class="form-label"><?= __d('setup', 'Department Name') ?></label>
				<input name="department_name" type="text" class="form-control" id="inputBR" placeholder="Department Name" required>
			</div>
			<div class="col-md-6  mt-2">
				<label for="inputState" class="form-label"><?= __d('setup', 'Faculties') ?></label>
				<select id="inputState" class="form-select option-class dropdown260" name="faculty_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($faculties as $faculty) { ?>
						<option value="<?php echo $faculty['faculty_id']; ?>"><?php echo $faculty['faculty_name']; ?></option>
					<?php } ?>
				</select>
			</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
		<?php echo $this->Html->Link('Back', ['action' => 'Department'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>