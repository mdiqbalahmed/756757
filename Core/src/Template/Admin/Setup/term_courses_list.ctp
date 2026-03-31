<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>

        <div>
            <?php
$this->Form->unlockField('course_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('session_id');
$this->Form->unlockField('department_id');
$this->Form->unlockField('term_id');

?>
	<?php echo $this->Form->create(); ?>
            <section>
                <h4><?= __d('setup', 'Search Term Course Cycle') ?></h4>
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

                    <div class="col-md-4  mt-4">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Term Name') ?></label>
                        <select  class="form-select option-class dropdown260 " name="term_id" id="term_id">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
                                <?php foreach ($terms as $term) { ?>
                            <option value="<?php echo $term['term_id']; ?>" <?php if ($term['term_id'] == $request_data['term_id']) {echo 'Selected';} ?>><?php echo $term['term_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>


                    <div class="col-md-4  mt-4">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Courses Name') ?></label>
                        <select  class="form-select option-class dropdown260 " name="course_id" id="course_id">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
                                <?php foreach ($courses as $course) { ?>
                            <option value="<?php echo $course['course_id']; ?>" <?php if ($course['course_id'] == $request_data['course_id']) {echo 'Selected';} ?>><?php echo $course['course_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>


                </div>
            </section>
            <div class="text-right mt-2">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="rows">
            <h3 class=""><?= __d('setup', 'Term Course Cycle List') ?></h3>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('setup', 'Deparment') ?></th>
                        <th><?= __d('setup', 'Level') ?></th>
                        <th><?= __d('setup', 'Course Details') ?></th> 
                        <th><?= __d('setup', 'Term') ?></th>
                        <?php foreach ($term_course_cycle_part_types as $term_course_cycle_part_type) { ?>
                        <th><?php echo $term_course_cycle_part_type['term_course_cycle_part_type_name'] ?></th>
                        <?php } ?>
                        <th><?= __d('setup', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                   <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result['department_name'] ?></td>
                        <td><?php echo $result['level_name'] ?></td>
                        <td><?php echo $result['course_name'].' - '.$result['course_code']; ?></td>
                        <td><?php echo $result['session_name'].' - '.$result['term_name']; ?></td>
                         <?php foreach ($result['mark_distrubation'] as $mark_distrubation) { ?>
                        <td><?php echo $mark_distrubation['pass_mark'].'/'.$mark_distrubation['mark'] ?></td>
                         <?php } ?>

                        <td>  <?php echo $this->Html->link('Edit', ['action' => 'editTermCourse', $result['term_course_cycle_id']], ['class' => 'btn action-btn btn-warning']) ?></td>

                    </tr>
                  <?php } ?>

                </tbody>
            </table>
        </div>

    </body>

</html>


<script>


    $("#department_id").change(function () {
        var department_id = $("#department_id").val();
        $.ajax({
            url: 'getLevelsAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "department_id": department_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text = '<option value="">Choose...</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["level_name"];
                    var id = data[i]["level_id"];
                    text += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#level_id').html(text);
            }
        });
    });


    $("#level_id").change(function () {
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getCoursesAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">Choose...</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["course_name"];
                    var id = data[i]["course_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#course_id').html(text1);
            }
        });
    });
</script>