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
            <h3 class="text-center"><?= __d('students', 'All Blocks') ?></h3>

            <span class="text-right float-right mb-3"><?= $this->Html->link('Add Block', ['action' => 'dataCount'], ['class' => 'btn btn-info']) ?></span>

        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('students', 'ID') ?></th>
                        <th><?= __d('students', 'Heading') ?></th>
                        <th><?= __d('students', 'Type') ?></th>
                        <th><?= __d('students', 'Action') ?></th>

                    </tr>
                </thead>
                <tbody>
                        <?php
                        foreach ($datas as $data) {
                        ?>
                    <tr>
                        <td><?php echo $data['id'] ?></td>
                        <td><?php echo $data['heading'] ?></td>
                        <td><?php echo $data['name'] ?></td>
                        <td>
                         <?= $this->Html->link('Edit', ['action' => 'editCount', $data['id']], ['class' => 'btn action-btn btn-warning']) ?>
                        </td>

                    </tr>
                        <?php } ?>

                </tbody>
            </table>
        </div>

    </body>

</html>