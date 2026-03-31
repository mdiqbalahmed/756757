<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>

        <div class="row">
            <div class="col-10">
                <h5 class=""><?= __d('setup', 'Course List Of Class: '.$head['level_name'].', Term: '.$head['session_name']. ' - '.$head['term_name']) ?></h5>
            </div>
            <div class="col-2">
            <?php echo $this->Html->link('Add Course & Activity', ['action' => 'termCycleAddCourse', $head['term_cycle_id']], ['class' => ' text-right float-right btn action-btn btn-info']) ?>

            </div>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('setup', 'Deparment') ?></th>
                        <th><?= __d('setup', 'Level') ?></th>
                        <th><?= __d('setup', 'Course Details') ?></th> 
                        <th><?= __d('setup', 'Term') ?></th>
                        <th><?= __d('setup', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                   <?php foreach ($term_course_cycle_lists as $term_course_cycle_list) { ?>
                    <tr>
                        <td><?php echo $term_course_cycle_list['department_name'] ?></td>
                        <td><?php echo $term_course_cycle_list['level_name'] ?></td>
                        <td><?php echo $term_course_cycle_list['course_name'].' - '.$term_course_cycle_list['course_code']; ?></td>
                        <td><?php echo $term_course_cycle_list['session_name'].' - '.$term_course_cycle_list['term_name']; ?></td>
                        <td> 
                            <button type="button" class="btn btn-danger" id="button" value='<?php echo $term_course_cycle_list['term_course_cycle_id'] ?>' onclick="deleteTermCourseCycle(this)">Delete</button>
                        </td>

                    </tr>
                  <?php } ?>

                </tbody>
            </table>
        </div>


        <div class="row mt-5">
            <div class="col-10">
                <h5 class=""><?= __d('setup', 'Activity List Of Class: '.$head['level_name'].', Term: '.$head['session_name']. ' - '.$head['term_name']) ?></h5>
            </div>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('setup', 'Level') ?></th>
                        <th><?= __d('setup', 'Activity Details') ?></th> 
                        <th><?= __d('setup', 'Multiple') ?></th> 
                        <th><?= __d('setup', 'Term') ?></th>
                        <th><?= __d('setup', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                   <?php foreach ($term_activity_cycle_list as $term_activity_cycle_list_single) { ?>
                    <tr>
                        <td><?php echo $term_activity_cycle_list_single['level_name'] ?></td>
                        <td><?php echo $term_activity_cycle_list_single['activity_name']; ?></td>
                        <td><?php if($term_activity_cycle_list_single['multiple']){ echo 'Yes';} else {echo 'NO';} ?></td>
                        <td><?php echo $term_activity_cycle_list_single['session_name'].' - '.$term_activity_cycle_list_single['term_name']; ?></td>
                        <td> 
                            <button type="button" class="btn btn-danger" id="button" value='<?php echo $term_activity_cycle_list_single['term_activity_cycle_id'] ?>' onclick="deleteTermActivityCycle(this)">Delete</button>
                        </td>

                    </tr>
                  <?php } ?>

                </tbody>
            </table>
        </div>

    </body>

</html>


<script>
    function deleteTermCourseCycle(value) {
        if (confirmDelete()) {
            var term_course_cycle_id = value.value;
            $.ajax({
                url: 'deleteTermCourseCycle',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "term_course_cycle_id": term_course_cycle_id
                },
                success: function (data) {
                    location.reload();
                }
            });
        }
    }
    function deleteTermActivityCycle(value) {
        if (confirmDelete()) {
            var term_activity_cycle_id = value.value;
            $.ajax({
                url: 'deleteTermActivityCycle',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "term_activity_cycle_id": term_activity_cycle_id
                },
                success: function (data) {
                    location.reload();
                }
            });
        }
    }

    function confirmDelete() {
        return confirm("Are you sure you want to delete this file?");
    }
</script>