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
            <h3 class="text-center"><?= __d('setup', 'Promotion Log') ?></h3>



        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('students', '#') ?></th>
                        <th><?= __d('students', 'Template Name') ?></th>
                        <th><?= __d('students', 'Promotion From') ?></th>
                        <th><?= __d('students', 'Promotion To') ?></th>
                        <th><?= __d('students', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
		 <?php foreach ($promotion_log as $key =>$log) {?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $log['name'] ?></td>
                        <td><?php echo  $log['session_from_name'].' - '. $log['level_from_name'] ?></td>
                        <td><?php echo  $log['session_to_name'].' - '. $log['level_to_name'] ?></td>
                        <td>
                             <?php echo $this->Html->link('Delete Promotion', ['action' => 'deletePromotion', $log['promotion_log_id']],  ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>

                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </body>

</html>
