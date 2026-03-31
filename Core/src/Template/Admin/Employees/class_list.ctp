<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <div class="rows">
            <h3 class="text-center"><?= __d('employees', 'List of Running Class Today') ?></h3>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Start Class', ['action' => 'liveClass'], ['class' => 'btn btn-info']) ?></span>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('employees', 'Date') ?></th>
                    <th><?= __d('employees', 'Session') ?></th>
                    <th><?= __d('employees', 'Level') ?></th>
                    <th><?= __d('employees', 'Shift') ?></th>
                    <th><?= __d('employees', 'Course') ?></th>
                    <th><?= __d('employees', 'Teacher') ?></th>
                    <th><?= __d('employees', 'Start Time') ?></th>
                    <th><?= __d('employees', 'End Course') ?></th>

                </tr>
            </thead>
            <tbody>
            <?php foreach ($live_classes as $key => $live_class) { ?>
                <tr>

                    <td><?php echo $live_class['date']  ?></td>
                    <td><?php echo $live_class['session_name']  ?></td>
                    <td><?php echo $live_class['level_name']  ?></td> 
                    <td><?php echo $live_class['shift_name']  ?></td>
                    <td><?php echo $live_class['course_name']  ?></td>
                    <td><?php echo $live_class['employee_name']  ?></td> 
                    <td><?php echo $live_class['start_time']  ?></td> 
                    <td>
                        <?php echo $this->Html->link('End Class', ['action' => 'endClass', $live_class['timesheet_live_class_id']], ['class' => 'btn action-btn btn-danger']) ?>

                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>

</html>