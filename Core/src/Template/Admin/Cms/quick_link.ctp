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
        <h3 class="text-center"><?= __d('buttons', 'All Quick Links') ?></h3>
        <span class="text-right float-right mb-3"><?= $this->Html->link('Add Quick Link', ['action' => 'addQuickLink'], ['class' => 'btn btn-info']) ?></span>

    </div>
    <div class="table-responsive-sm table-responsive">
        <table class="table table-bordered table-striped" id="btn-table">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('buttons', 'SL') ?></th>
                    <th class="text-center"><?= __d('buttons', 'Button Preview') ?></th>
                    <th><?= __d('buttons', 'Button Title') ?></th>
                    <th><?= __d('buttons', 'Button Link') ?></th>
                    <th class="text-center"><?= __d('buttons', 'Order') ?></th>
                    <th><?= __d('buttons', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serialNumber = 1;
                foreach ($buttons as $button) {
                ?>
                    <tr data-id="<?= $button['id'] ?>">
                        <td><?= $serialNumber++ ?></td>
                        <td class="text-center">
                            <button class="btn" style="font-weight:700; font-size: 12px; background-color:<?= $button['button_color'] ?>; color:<?= $button['button_text_color'] ?>;"><?= $button['button_title'] ?></button>
                        </td>
                        <td><?= $button['button_title'] ?></td>
                        <td><?= $button['button_link'] ?></td>
                        <td class="text-center">
                            <button class="order_button move-up"><i class="fa fa-chevron-up"></i></button>
                            <button class="order_button move-down mr-2"><i class="fa fa-chevron-down"></i></button>
                        </td>
                        <td>
                            <?= $this->Html->link('Edit', ['action' => 'editQuickLink', $button['id']], ['class' => 'btn action-btn btn-warning']) ?>
                            <?= $this->Form->postLink('Delete', ['action' => 'deleteQuickLink', $button['id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
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
<script>
    $(document).ready(function() {
        function updateOrder(id1, order1, id2, order2) {
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
                url: 'quick_links/getBtnOrderAjax/', // Adjust the URL to match your setup
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
                updateOrder(id, order, prevId, prevOrder);
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
                updateOrder(id, order, nextId, nextOrder);
            }
        });
    });
</script>

</html>