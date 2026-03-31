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
        <h3 class="text-center"><?= __d('setup', 'All Departments') ?></h3>

        <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Departments', ['action' => 'addDepartment'], ['class' => 'btn btn-info']) ?></span>

    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('setup', 'ID') ?></th>
                    <th><?= __d('setup', 'Department Name') ?></th>
                    <th><?= __d('setup', 'Faculty') ?></th>
                    <th><?= __d('setup', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $result) {
                ?>
                    <tr>
                        <td><?php echo $result['department_id'] ?></td>
                        <!-- For Array Declaration We use ['declared_entity_name'] braket method -->
                        <td><?php echo $result['department_name'] ?></td>
                        <td><?php echo $result['faculty_name'] ?></td>
                        <td>
                            <?php echo $this->Html->link('Edit', ['action' => 'editDepartment', $result['id']], ['class' => 'btn action-btn btn-warning']) ?>
                            <?php $this->Form->postLink('Delete', ['action' => 'editDepartment', $result['id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
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