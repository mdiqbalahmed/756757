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
            <h3 class="text-center"><?= __d('setup', 'All Activity') ?></h3>

            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Activity', ['action' => 'addActivity'], ['class' => 'btn btn-info']) ?></span>

        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('setup', 'ID') ?></th>
                        <th><?= __d('setup', 'Name') ?></th>
                        <th><?= __d('setup', 'Comment') ?></th>
                        <th><?= __d('setup', 'Multiple') ?></th>
                        <th><?= __d('setup', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
				<?php
				foreach ($datas as $data) {
				?>
                    <tr>
                        <td><?php echo $data->activity_id  ?></td>
                        <td><?php echo $data->name ?></td>
                        <td><?php echo $data->comment ?></td>
                        <td><?php if($data->multiple){ echo 'Yes';} else {echo 'NO';} ?></td>
                        <td>
		            <?php echo $this->Html->link('Edit', ['action' => 'editActivity', $data->activity_id], ['class' => 'btn action-btn btn-warning']) ?>
			    <?php $this->Form->postLink('Delete', ['action' => 'editActivity', $data->activity_id], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
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