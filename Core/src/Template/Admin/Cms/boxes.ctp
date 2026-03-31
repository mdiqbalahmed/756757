<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');
?>
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
        <h3 class="text-center"><?= __d('boxes', 'All Boxes') ?></h3>
        <span class="text-right float-right mb-3"><?= $this->Html->link('Add Boxes', ['action' => 'addBoxes'], ['class' => 'btn btn-info']) ?></span>
    </div>

    <?php if ($siteTemplate == 1) { ?>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('boxes', 'SL') ?></th>
                        <th><?= __d('boxes', 'Box Title') ?></th>
                        <th><?= __d('boxes', 'Template') ?></th>
                        <th><?= __d('boxes', 'Page') ?></th>
                        <th class="text-center"><?= __d('boxes', 'Box Order') ?></th>
                        <th><?= __d('boxes', 'URL') ?></th>
                        <th><?= __d('boxes', 'Status') ?></th>
                        <th><?= __d('boxes', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $serialNumber = 1;
                    foreach ($boxes as $box) { ?>
                        <tr data-id="<?= $box['id'] ?>">
                            <td><?= $serialNumber++ ?></td>
                            <td><?= $box['box_title'] ?></td>
                            <td class="text-center"><?php if ($box['block_id'] != null) {
                                                        echo '1';
                                                    } else {
                                                        echo '0';
                                                    } ?></td>
                            <td><?php if ($box['node_page_id'] != 0) {
                                    echo $box['node_title'];
                                } else {
                                    Print_r('Home');
                                } ?></td>
                            <td class="text-center">
                                <button class="order_button move-up"><i class="fa fa-chevron-up"></i></button>
                                <button class="order_button move-down mr-2"><i class="fa fa-chevron-down"></i></button>
                            </td>
                            <td><?= $box['url'] ?></td>
                            <td><?php if ($box['status'] == 1) {
                                    Print_r('Active');
                                } else {
                                    Print_r('Inactive');
                                }; ?></td>
                            <td>
                                <?= $this->Html->link('Edit', ['action' => 'editBoxes', $box['id']], ['class' => 'btn action-btn btn-warning']) ?>
                                <?= $this->Form->postLink('Delete', ['action' => 'deleteBoxes', $box['id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php } else { ?>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('boxes', 'SL') ?></th>
                        <th><?= __d('boxes', 'Box Title') ?></th>
                        <th><?= __d('boxes', 'Page') ?></th>
                        <th class="text-center"><?= __d('boxes', 'Box Order') ?></th>
                        <th><?= __d('boxes', 'URL') ?></th>
                        <th><?= __d('boxes', 'Status') ?></th>
                        <th><?= __d('boxes', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $serialNumber = 1;
                    foreach ($boxes as $box) {
                    ?>
                        <tr data-id="<?= $box['id'] ?>">
                            <td><?= $serialNumber++ ?></td>
                            <td><?= $box['box_title'] ?></td>
                            <td><?php if ($box['node_page_id'] != 0) {
                                    echo $box['node_title'];
                                } else {
                                    Print_r('Home');
                                } ?></td>
                            <td class="text-center">
                                <button class="order_button move-up"><i class="fa fa-chevron-up"></i></button>
                                <button class="order_button move-down mr-2"><i class="fa fa-chevron-down"></i></button>
                            </td>
                            <td><?= $box['url'] ?></td>
                            <td><?php if ($box['status'] == 1) {
                                    Print_r('Active');
                                } else {
                                    Print_r('Inactive');
                                }; ?></td>
                            <td>
                                <?= $this->Html->link('Edit', ['action' => 'editBoxes', $box['id']], ['class' => 'btn action-btn btn-warning']) ?>
                                <?= $this->Form->postLink('Delete', ['action' => 'deleteBoxes', $box['id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    <?php } ?>

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
<script>
    $(document).ready(function() {
        function updateBoxOrder(id1, order1, id2, order2) {
            $.ajax({
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "id1": id1,
                    "order1": order1,
                    "id2": id2,
                    "order2": order2
                },
                url: 'boxes/getBoxOrderAjax/', // Adjust the URL to match your setup
                success: function(response) {
                    if (response === 'success') {
                        location.reload(); // Reload the page to show updated data
                    }
                }
            });
        }

        $('.move-up').click(function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var order = row.data('order');
            var prevRow = row.prev('tr');
            if (prevRow.length > 0) {
                var prevId = prevRow.data('id');
                var prevOrder = prevRow.data('order');
                row.insertBefore(prevRow);
                updateBoxOrder(id, order, prevId, prevOrder);
            }
        });

        $('.move-down').click(function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var order = row.data('order');
            var nextRow = row.next('tr');
            if (nextRow.length > 0) {
                var nextId = nextRow.data('id');
                var nextOrder = nextRow.data('order');
                row.insertAfter(nextRow);
                updateBoxOrder(id, order, nextId, nextOrder);
            }
        });
    });
</script>

</html>