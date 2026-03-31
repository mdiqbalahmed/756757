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
        <h3 class="text-center"><?= __d('employees', 'List of Employee Designation') ?></h3>
        <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Designation', ['action' => 'addDesignation'], ['class' => 'btn btn-info']) ?></span>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th><?= __d('employees', '#') ?></th>
                <th><?= __d('employees', 'Designation Name') ?></th>
                <th><?= __d('employees', 'Action') ?></th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees_designation as $key => $designation) { ?>
                <tr>
                    <td><?php echo $key + 1  ?></td>
                    <td><?php echo $designation['name']  ?></td>
                    <td>
                        <?php echo $this->Html->link('Edit', ['action' => 'editDesignation', $designation['id']], ['class' => 'btn action-btn btn-warning']) ?>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
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