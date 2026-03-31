<?php $this->Form->unlockField('level_name'); ?>
<?php $this->Form->unlockField('department_id'); ?>


<div>

	<?php echo $this->Form->create(); ?>
	<section>
		<h4><?= __d('setup', 'Add a Class') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-6 mt-2">
				<label for="inputBR" class="form-label" <?= __d('setup', '') ?>><?= __d('setup', 'Class Name') ?></label>
				<input name="level_name" type="text" class="form-control" id="inputBR" placeholder="Level Name" required>
			</div>
			<div class="col-md-6  mt-2">
				<label for="inputState" class="form-label"><?= __d('setup', 'Department') ?></label>
				<select id="inputState" class="form-select dropdown260" name="department_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($departments as $department) { ?>
						<option value="<?php echo $department['department_id']; ?>"><?php echo $department['department_name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
		<?php echo $this->Html->Link('Back', ['action' => 'Level'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>