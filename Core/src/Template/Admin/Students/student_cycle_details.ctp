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
            <h5 class="">
                <?= __d('setup', 'Course List Of Student: ' . $head['name'] . ', Class: ' . $head['level_name'] . ', Term: ' . $head['session_name'] . ' - ' . $head['term_name']) ?>
            </h5>
        </div>
        <div class="col-2">
            <?php echo $this->Html->link('Add Course', ['action' => 'studentCycleAddCourse', $head['student_term_cycle_id']], ['class' => ' text-right float-right btn action-btn btn-info']) ?>

        </div>
    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('setup', 'Course Name') ?></th>
                    <th><?= __d('setup', 'Course Details') ?></th>
                    <th><?= __d('setup', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) {
                    ?>
                    <tr>
                        <td><?php echo $course['course_name'] ?></td>
                        <td><?php echo $course['course_code'] ?></td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                'Delete',
                                ['action' => 'deleteStudentTermCourseCycle', $course['student_term_course_cycle_id']],
                                [
                                    'class' => 'text-right float-right btn btn-danger',
                                    'confirm' => 'Are you sure you want to delete this item?'
                                ]
                            );
                            ?>

                        </td>

                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

</body>

</html>
