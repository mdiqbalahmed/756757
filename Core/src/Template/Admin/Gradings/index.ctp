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
        <h3 class="text-center"><?= __d('gradings', 'List of Grading System') ?></h3>
         <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Gradings', ['action' => 'add'], ['class' => 'btn btn-info']) ?></span>

    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th><?= __d('gradings', 'ID') ?></th>
                <th><?= __d('gradings', 'Grading System Name') ?></th>
                <th><?= __d('gradings', 'Action') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gradings as $grading) { ?>
                <tr>
                    <td><?php echo $grading->gradings_id  ?></td>
                    <td><?php echo $grading->gradings_system_name ?></td>
                    <td>
                        <?php echo $this->Html->link('Edit', ['action' => 'edit', $grading->gradings_id ], ['class' => 'btn action-btn btn-warning']) ?>
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