<?php

$this->Form->unlockField('course_name'); ?>
<?php $this->Form->unlockField('course_code'); ?>
<?php $this->Form->unlockField('department_id'); ?>
<?php $this->Form->unlockField('course_type_id'); ?>
<?php $this->Form->unlockField('course_group_id'); ?>


<div>
	<?php echo $this->Form->create(); ?>
	<section>
		<h4><?= __d('setup', 'Add a Course') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-6 mt-2">
				<label for="inputBR" class="form-label"><?= __d('setup', 'Course Name') ?></label>
				<input name="course_name" type="text" class="form-control" id="inputBR" placeholder="Course Name" required>
			</div>
			<div class="col-6 mt-2">
				<label for="inputBR" class="form-label"><?= __d('setup', 'Course Code') ?></label>
				<input name="course_code" type="text" class="form-control" id="inputBR" placeholder="Course Name" required>
			</div>
			<div class="col-md-6  mt-4">
				<label for="inputState" class="form-label"><?= __d('setup', 'Department') ?></label>
				<select id="department_id" class="form-select dropdown260" name="department_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($departments as $department) { ?>
						<option value="<?php echo $department['department_id']; ?>"><?php echo $department['department_name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-3  mt-4">
				<label for="inputState" class="form-label"><?= __d('setup', 'Course Type') ?></label>
				<select id="inputState" class="form-select dropdown260" name="course_type_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($course_types as $course_type) { ?>
						<option value="<?php echo $course_type['course_type_id']; ?>"><?php echo $course_type['course_type_name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-3  mt-4">
				<label for="inputState" class="form-label"><?= __d('setup', 'Course Group') ?></label>
				<select id="inputState" class="form-select dropdown260" name="course_group_id">
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($scms_groups as $scms_group) { ?>
						<option value="<?php echo $scms_group->group_id; ?>"><?php echo $scms_group->group_name; ?></option>
					<?php } ?>
				</select>
			</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
		<?php echo $this->Html->Link('Back', ['action' => 'Course'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>