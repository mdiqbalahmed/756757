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
        <h3 class="text-center hello"><?= __d('hrs', 'List of All Shift') ?></h3>
        <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Shift', ['action' => 'addShift'], ['class' => 'btn btn-info']) ?></span>
    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>

                    <th><?= __d('hrs', 'Shift Name') ?></th>
                    <th><?= __d('hrs', 'Monday') ?></th>
                    <th><?= __d('hrs', 'Tuesday') ?></th>
                    <th><?= __d('hrs', 'Wednesday') ?></th>
                    <th><?= __d('hrs', 'Thursday') ?></th>
                    <th><?= __d('hrs', 'Friday') ?></th>
                    <th><?= __d('hrs', 'Saturday') ?></th>
                    <th><?= __d('hrs', 'Sunday') ?></th>
                    <th><?= __d('hrs', 'Break') ?></th>
                    <th><?= __d('hrs', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($shifts as $data) {
                ?>
                    <tr>
                        <td><?php echo $data['shift_name'] ?></td>
                        <td><?php echo $data['monday_in_time'] ?> <br> <?php echo $data['monday_out_time'] ?></td>
                        <td><?php echo $data['tuesday_in_time'] ?> <br> <?php echo $data['tuesday_out_time'] ?></td>
                        <td><?php echo $data['wednesday_in_time'] ?> <br> <?php echo $data['wednesday_out_time'] ?></td>
                        <td><?php echo $data['thursday_in_time'] ?> <br> <?php echo $data['thursday_out_time'] ?></td>
                        <td><?php echo $data['friday_in_time'] ?> <br> <?php echo $data['friday_out_time'] ?></td>
                        <td><?php echo $data['saturday_in_time'] ?> <br> <?php echo $data['saturday_out_time'] ?></td>
                        <td><?php echo $data['sunday_in_time'] ?> <br> <?php echo $data['sunday_out_time'] ?></td>
                        <td><?php echo $data['break_out_time'] ?> <br> <?php echo $data['break_in_time'] ?></td>
                        <td>
                            <?php echo $this->Html->link('Edit', ['action' => 'editShift', $data['shift_id']], ['class' => 'btn btn-warning']) ?>
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