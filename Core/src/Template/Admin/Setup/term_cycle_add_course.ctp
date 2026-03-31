<?php

$this->Form->unlockField('courses_cycle_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('session_id');
$this->Form->unlockField('department_id');
$this->Form->unlockField('term_cycle_id');
$this->Form->unlockField('activity_cycle_id');


?>

<div>
	<?php echo $this->Form->create(); ?>
    <section>

        <h5 class=""><?= __d('setup', 'Add Course To Class: '.$result['level_name'].', Session: '.$result['session_name'].', Term: '.$result['term_name']) ?></h5>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6  mt-1">
                <label for="inputState" class="form-label"><?= __d('setup', 'Department') ?></label>
                <select class="form-select dropdown260" name="department_id" required>
                    <option value="<?php echo $result['department_id']; ?>"><?php echo $result['department_name']; ?></option>
                </select>
            </div>
            <div class="col-md-6  mt-1">
                <label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
                <select id="level_id" class="form-select dropdown260" name="level_id" required>
                    <option value="<?php echo $result['level_id']; ?>"><?php echo $result['level_name']; ?></option>
                </select>
            </div>


            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
                <select id="inputState" class="form-select dropdown260" name="session_id" required>
                    <option value="<?php echo $result['session_id']; ?>"><?php echo $result['session_name']; ?></option>
                </select>
            </div>
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
                <select id="inputState" class="form-select dropdown260" name="term_cycle_id" required>
                    <option value="<?php echo $result['term_cycle_id']; ?>"><?php echo $result['term_name']; ?></option>
                </select>
            </div>
            <div class="col-md-12  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Courses Name') ?></label>
                <select id="" size="5" class="form-select option-class dropdown260 " name="courses_cycle_id[]" multiple="multiple">
                    <option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($courses as $course) { ?>
                    <option value="<?php echo $course['courses_cycle_id']; ?>"><?php echo $course['course_name'] . "(" . $course['course_code'] . ")"." : ".$course['course_type']; ?></option>
					<?php } ?>
                </select>
            </div>

            <div class="col-md-12  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Activity Name') ?></label>
                <select id="" size="5" class="form-select option-class dropdown260 " name="activity_cycle_id[]" multiple="multiple">
                    <option value=""><?= __d('setup', 'Choose...') ?></option>
					<?php foreach ($index_activity as $activity) { ?>
                    <option value="<?php echo $activity['activity_cycle_id']; ?>"><?php echo $activity['activity_name']; ?></option>
					<?php } ?>
                </select>
            </div>
        </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
		<?php echo $this->Form->end(); ?>
    </div>
</div>

<script type='text/javascript'>
    $(document).ready(function () {
        $("option:selected").map(function () {
            return this.value
        }).get().join(", ");
    });
</script>