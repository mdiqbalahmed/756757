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
            <h3 class="text-center hello"><?= __d('hrs', 'List of All Roster') ?></h3>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Roster', ['action' => 'addRoster'], ['class' => 'btn btn-info']) ?></span>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('hrs', 'ID') ?></th>
                        <th><?= __d('hrs', 'Roster Name') ?></th>
                        <th><?= __d('hrs', 'Start Date') ?></th>
                        <th><?= __d('hrs', 'End Date') ?></th>
                        <th><?= __d('hrs', 'Shift Name') ?></th>
                        <th><?= __d('hrs', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rosters as $roster) { ?>
                    <tr>
                        <td><?php echo $roster['roster_id'] ?></td>
                        <td><?php echo $roster['roster_name'] ?></td>
                        <td><?php echo $roster['start_date'] ?></td>
                        <td><?php echo $roster['end_date'] ?></td>
                        <td><?php echo $roster['shift_name'] ?></td>
                        <td>
                            <?php echo $this->Html->link('Edit', ['action' => 'editRoster', $roster['roster_id']], ['class' => 'btn btn-warning']) ?>
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