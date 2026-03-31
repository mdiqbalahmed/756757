<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Assign Courses</title>
    </head>
    <div>
    <?php echo $this->Form->create();
$this->Form->unlockField('teachers_user_id');
    ?>
        <section>
            <h4></h4>
            <div class="row mx-4 mt-2 p-3"  >
                <div class="col-md-4  mt-2">

                </div>
                <div class="col-md-2 text-right mt-2">
                    <label for="inputState" class="form-label"><?= __d('setup', 'Search Teacher: ') ?></label>
                </div>

                <div class="col-md-4  mt-2">
                    <select id="inputState" class="form-select dropdown260" name="teachers_user_id" required>
                        <option value=""><?= __d('setup', '-- Choose --') ?></option>
                    <?php foreach ($teachers as $teacher) { ?>
                        <option value="<?php echo $teacher['user_id']; ?>"><?php echo $teacher['name']; ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-md-2  mt-2">
                    <div class="text-right mt-2">
                        <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>

                    </div>
                </div>

            </div>
        </section>

           <?php echo $this->Form->end(); ?>

    </div>
    <body>
        <div class="rows">
            <h3 class="text-center"><?= __d('setup', 'Assign Courses') ?></h3>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Assign Teacher', ['action' => 'assignTeacherAdd'], ['class' => 'btn btn-info']) ?></span>

        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>

                    <th><?= __d('setup', 'Teacher Name') ?></th>
                    <th><?= __d('setup', 'Level') ?></th>
                    <th><?= __d('setup', 'Section') ?></th>
                    <th><?= __d('setup', 'Course Name') ?></th>
                    <th><?= __d('setup', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
				<?php
				foreach ($assign_courses as $assign_course) {
				?>
                <tr>
                    <td><?php echo $assign_course['name']  ?></td>
                    <td><?php echo $assign_course['level_name']  ?></td>
                    <td><?php echo $assign_course['section_name']  ?></td>
                    <td><?php echo $assign_course['course_name'].' - '.$assign_course['course_code'] ?></td>
                    <td>
		       <?php echo $this->Form->postLink('Delete', ['action' => 'deleteAssignTeacher', $assign_course['teaches_assign_courses_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                    </td>
                </tr>
				<?php } ?>

            </tbody>
        </table>
    </body>

</html>