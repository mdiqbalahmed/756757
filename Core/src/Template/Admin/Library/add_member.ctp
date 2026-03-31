<?php
$this->Form->unlockField('member_type');
$this->Form->unlockField('student_id');
$this->Form->unlockField('employee_id');
?>

<div>

	<?php echo $this->Form->create('', ['type' => 'file']); ?>
	<section>
		<h4><?= __d('Library', 'Add a Member') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-6 mt-3">
				<label class="form-label"><?= __d('Library', 'Member Type') ?></label>

				<select class="form-select dropdown260" name="member_type">
					<option value=""><?= __d('Library', '-- Choose --') ?></option>
					<?php foreach ($member_types as $member_type) { ?>
						<option value="<?php echo $member_type['member_type_id']; ?>"><?php echo $member_type['member_type_title']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-6 mt-3">
				<label class="form-label"><?= __d('Library', 'Student ID') ?></label>
				<select class="form-select dropdown260" name="student_id">
					<option value=""><?= __d('Library', '-- Choose --') ?></option>
					<?php foreach ($students as $student) { ?>
						<option value="<?php echo $student['student_id']; ?>"><?php echo $student['sid']. ' - '. $student['name']; ?></option>
						<?php } ?>
				</select>

			</div>
			<div class="col-6 mt-3"></div>
			<div class="col-6 mt-3">
				<label class="form-label"><?= __d('Library', 'Employee ID') ?></label>
				<select class="form-select dropdown260" name="employee_id">
					<option value=""><?= __d('Library', '-- Choose --') ?></option>
					<?php foreach ($employees as $employee) { ?>
						<option value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['employee_unique_id'] . ' - ' . $employee['name'];?></option>
						<?php } ?>
				</select>
			</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('Library', 'Submit') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'books'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
