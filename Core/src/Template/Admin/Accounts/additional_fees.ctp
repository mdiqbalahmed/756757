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
            <h3 class="text-center"><?= __d('accounts', 'All Additional Fees Information') ?></h3>

            <span class="text-right float-right mb-3"><?= $this->Html->link('Add Additional Fees', ['action' => 'addAdditionalFees'], ['class' => 'btn btn-info']) ?></span>

        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('accounts', 'ID') ?></th>
                        <th><?= __d('accounts', 'Fees Title') ?></th>
                        <th><?= __d('accounts', 'Purpose') ?></th>
                        <th><?= __d('accounts', 'Value') ?> </th>
                        <th><?= __d('accounts', 'Action') ?> </th>

                    </tr>
                </thead>
                <tbody>
				<?php
				foreach ($additionals as $additional) {
				?>
                    <tr>
                        <td><?=  $additional['id']  ?></td>
                        <td><?=  $additional['fees_title'] ?></td>
                        <td><?=  $additional['p_purpose_name'] ?></td>
                        <td class="text-right">   <?php echo $value = $additional['value'] ?  number_format( $additional['value'], 2, '.', '') : ''; ?></td>

                        <td>
							<?= $this->Html->link('Edit', ['action' => 'editAdditionalFees',  $additional['id']], ['class' => 'btn action-btn btn-warning']) ?>
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