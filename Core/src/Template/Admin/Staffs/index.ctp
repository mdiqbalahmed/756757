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
        <h3 class="text-center"><?= __d('staffs', 'List of Staffs') ?></h3>

    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th><?= __d('staffs', 'ID') ?></th>
                <th><?= __d('staffs', 'Name') ?></th>
                <th><?= __d('staffs', 'Mobile Number') ?></th>
                <th><?= __d('staffs', 'Action') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffs as $staff) { ?>
                <tr>
                    <td><?php echo $staff->staff_id  ?></td>
                    <td><?php echo $staff->name ?></td>
                    <td><?php echo $staff->phone_number ?></td>
                    <td>

                        <?php echo $this->Html->link('Edit', ['action' => 'edit', $staff->staff_id], ['class' => 'btn action-btn btn-warning']) ?>
                        <?php $this->Form->postLink('Delete', ['action' => 'delete', $staff->staff_id], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>

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