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
            <h3 class="text-center"><?= __d('students', 'Promotion Template') ?></h3>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Promotion Template', ['action' => 'addPromotionTemplate'], ['class' => 'btn btn-info']) ?></span>

        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('students', '#') ?></th>
                    <th><?= __d('students', 'Name') ?></th>
                    <th><?= __d('students', 'Session From') ?></th>
                    <th><?= __d('students', 'Session To') ?></th>
                    <th><?= __d('students', 'Based on') ?></th>
                    <th><?= __d('students', 'Result Type') ?></th>
                    <th><?= __d('students', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($prmotion_templates as $key => $templates) {
                ?>
                <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo  $templates['name'] ?></td>
                    <td><?php echo  $templates['session_from_name'] ?></td>
                    <td><?php echo  $templates['session_to_name'] ?></td>
                    <td><?php echo $templates['term_name'] ?></td>
                    <td><?php echo ucfirst($templates['type']) ?></td>
                    <td>
                            <?php echo $this->Html->link('View Template', ['action' => 'viewPromotionTemplate', $templates['promotion_template_id']], ['class' => 'btn action-btn btn-warning']) ?>
                             <?php echo $this->Html->link('Delete', ['action' => 'deletePromotionTemplate', $templates['promotion_template_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                    </td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
    </body>

</html>
