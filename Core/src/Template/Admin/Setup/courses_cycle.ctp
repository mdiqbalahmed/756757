<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Courses</title>
</head>

<body>

	<div class="rows">
		<span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Courses Cycle', ['action' => 'addCoursesCycle'], ['class' => 'btn btn-info']) ?></span>
	</div>
                <?php
$this->Form->unlockField('level_id');
$this->Form->unlockField('session_id');
$this->Form->unlockField('department_id');

?>
	<?php echo $this->Form->create(); ?>
            <section>
                <h4><?= __d('setup', 'Search Course Cycle') ?></h4>
                <div class="row mx-3 mt-2 p-3">
                    <div class="col-md-4 ">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
                        <select id="inputState" class="form-select dropdown260" name="session_id">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
				<?php foreach ($sessions as $session) { ?>
                            <option value="<?php echo $session['session_id']; ?>" <?php if ($session['session_id'] == $request_data['session_id']) {echo 'Selected';} ?>><?php echo $session['session_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4   mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Department') ?></label>
                        <select class="form-select dropdown260" name="department_id" id="department_id">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
				<?php foreach ($departments as $department) { ?>
                            <option value="<?php echo $department['department_id']; ?>" <?php if ($department['department_id'] == $request_data['department_id']) {echo 'Selected';} ?>><?php echo $department['department_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4  mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
                        <select  class="form-select dropdown260" name="level_id" id="level_id">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
                                <?php foreach ($levels as $level) { ?>
                            <option value="<?php echo $level['level_id']; ?>" <?php if ($level['level_id'] == $request_data['level_id']) {echo 'Selected';} ?>><?php echo $level['level_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>
                </div>
            </section>
            <div class="text-right mt-2">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
            <?php echo $this->Form->end(); ?>
    
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('setup', 'Sl') ?></th>
					<th><?= __d('setup', 'Department Name') ?></th>
					<th><?= __d('setup', 'Level Name') ?></th>
					<th><?= __d('setup', 'Course Name') ?></th>
					<th><?= __d('setup', 'Course Code') ?></th>
					<th><?= __d('setup', 'Course Type') ?></th>
					<th><?= __d('setup', 'Course Group') ?></th>
					<th><?= __d('setup', 'Session') ?></th>
					<th><?= __d('setup', 'Delete') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$serial = 1;
				foreach ($results as $result) { ?>
					<tr>
						<td><?php echo $serial; ?></td>
						<td><?php echo $result['department_name']; ?></td>
						<td><?php echo $result['level_name']; ?></td>
						<td><?php echo $result['course_name']; ?></td>
						<td><?php echo $result['course_code']; ?></td>
						<td><?php echo $result['course_type']; ?></td>
						<td><?php echo $result['group_name']; ?></td>
						<td><?php echo $result['session_name']; ?></td>
						<td>
							<button type="button" class="btn btn-danger" id="button" value='<?php echo $result['courses_cycle_id']; ?>' onclick="deleteCourseCycle(this)">Delete</button>
						</td>
					</tr>
					<?php $serial++;
					?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<nav aria-label="Page navigation example">
		<ul class="pagination mt-5 custom-paginate justify-content-center">
			<li class="page-item"> <?= $this->Paginator->first("First") ?></li>
			<li class="page-item"><?= $this->Paginator->prev("<<") ?></li>
			<li class="page-item"><?= $this->Paginator->numbers() ?></li>
			<li class="page-item"><?= $this->Paginator->next(">>") ?></li>
			<li class="page-item"><?= $this->Paginator->last("Last") ?></li>
		</ul>
	</nav>
</body>

</html>

<script>
	function deleteCourseCycle(value) {
		if (confirmDelete()) {
			var courses_cycle_id = value.value;
			$.ajax({
				url: 'deleteCourseCycle',
				cache: false,
				type: 'GET',
				dataType: 'HTML',
				data: {
					"courses_cycle_id": courses_cycle_id
				},
				success: function(data) {
					location.reload();
				}
			});
		}
	}

	function confirmDelete() {
		return confirm("Are you sure you want to delete this file?");
	}
</script>