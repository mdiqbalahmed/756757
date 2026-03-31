<?php
$this->Form->unlockField('course_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('session_id');
$this->Form->unlockField('department_id');
?>

<div>
	<?php echo $this->Form->create(); ?>
	<section>
		<h4><?= __d('setup', 'Add Course Cycle') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-md-6  mt-4">
				<label for="inputState" class="form-label"><?= __d('setup', 'Department') ?></label>
				<select class="form-select dropdown260" name="department_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($departments as $department) { ?>
						<option value="<?php echo $department['department_id']; ?>"><?php echo $department['department_name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6  mt-4">
				<label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
				<select id="level_id" class="form-select dropdown260" name="level_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($levels as $level) { ?>
						<option value="<?php echo $level['level_id']; ?>"><?php echo $level['level_name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-12  mt-2">
				<label for="inputState" class="form-label"><?= __d('setup', 'Courses Name') ?></label>
				<select id="" size="5" class="form-select option-class dropdown260 " name="course_id[]" multiple="multiple" max="2">
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($courses as $course) { ?>
						<option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name'] . "(" . $course['course_code'] . ")"." : ".$course['course_type']; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-6  mt-4">
				<label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
				<select id="inputState" class="form-select dropdown260" name="session_id" required>
					<option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($sessions as $session) { ?>
						<option value="<?php echo $session['session_id']; ?>"><?php echo $session['session_name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
		<?php echo $this->Html->Link('Back', ['action' => 'termCycle'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>

<script type='text/javascript'>
	$(document).ready(function() {
		$("option:selected").map(function() {
			return this.value
		}).get().join(", ");
	});
</script>