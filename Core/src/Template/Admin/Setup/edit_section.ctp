<?php $this->Form->unlockField('section_name'); ?>
<?php $this->Form->unlockField('shift_id'); ?>
<?php $this->Form->unlockField('level_id'); ?>

<div>
	<?php echo $this->Form->create(); ?>
	<section>
		<h4><?= __d('setup', 'Edit Section') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-6 mt-2">
				<label for="inputBR" class="form-label"><?= __d('setup', 'Section Name') ?></label>
				<input name="section_name" type="text" class="form-control" id="inputBR" placeholder="Section Name" value="<?php echo $sections[0]['section_name']; ?>" required>
			</div>
			<div class="col-md-6  mt-2">
				<label for="inputState" class="form-label"><?= __d('setup', 'Shift') ?></label>
				<select id="inputState" class="form-select option-class dropdown260" name="shift_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($shifts as $shift) { ?>
						<option value="<?php echo $shift['shift_id']; ?>"
						<?php if ($shift['shift_id'] == $sections[0]['shift_id']) {echo 'Selected';} ?>>
						<?php echo $shift['shift_name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6  mt-2">
				<label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
				<select id="inputState" class="form-select option-class dropdown260" name="level_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($levels as $level) { ?>
						<option value="<?php echo $level['level_id']; ?>"
						<?php if ($level['level_id'] == $sections[0]['level_id']) {echo 'Selected';} ?>>
						<?php echo $level['level_name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'Section'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>