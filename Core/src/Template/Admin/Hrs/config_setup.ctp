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
        <h3 class="text-center hello"><?= __d('hrs', 'List of All Config Setup') ?></h3>
        <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Config Setup', ['action' => 'addConfigSetup'], ['class' => 'btn btn-info']) ?></span>
    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('hrs', 'User Name') ?></th>
                    <th><?= __d('hrs', 'Config Action Name') ?></th>
                    <th><?= __d('hrs', 'Year') ?></th>
                    <th><?= __d('hrs', 'Month') ?></th>
                    <th><?= __d('hrs', 'Value') ?></th>
                    <th><?= __d('hrs', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hr_config_action_setups as $hr_config_action_setup) { ?>
                    <tr>
                        <td><?php echo $hr_config_action_setup['u_name'] ?></td>
                        <td><?php echo $hr_config_action_setup['c_config_action_name'] ?></td>
                        <td><?php echo $hr_config_action_setup['year'] ?></td>
                        <td><?php echo $hr_config_action_setup['months'] ?></td>
                        <td><?php echo $hr_config_action_setup['value'] ?></td>
                        <td>
                            <?php echo $this->Html->link('Edit', ['action' => 'editConfigSetup', $hr_config_action_setup['config_action_setup_id']], ['class' => 'btn btn-warning']) ?>
                        </td>
                    </tr>
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