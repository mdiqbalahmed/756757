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
            <h3 class="text-center"><?= __d('employees', 'List of Inactive Employees') ?></h3>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>

                    <th><?= __d('employees', '#') ?></th>
                    <th><?= __d('employees', 'Name') ?></th>
                    <th><?= __d('employees', 'Photo') ?></th>
                    <th><?= __d('employees', 'Email') ?></th>
                    <th><?= __d('employees', 'Mobile') ?></th>
                    <th><?= __d('employees', 'Designation') ?></th>
                    <th><?= __d('employees', 'RFID') ?></th>
                    <th><?= __d('employees', 'Featured') ?></th>
                    <th><?= __d('employees', 'Order') ?></th>
                    <th><?= __d('employees', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $serialNumber = 1;
                foreach ($employees as $key => $employee) { ?>
                    <tr data-id="<?= $employee['employee_id'] ?>">
                        <td><?= $serialNumber++  ?></td>
                        <td><?= $employee['name']  ?></td>
                        <td><?php echo $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $employee['image_name']); ?></td>
                        <td><?= $employee['email'] ?></td>
                        <td><?= $employee['mobile'] ?></td>
                        <td><?= $employee['designation_name'] ?></td>
                        <td><?= $employee['rf_id'] ?></td>
                        <td><?php if ($employee['featured'] != null) {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            } ?></td>
                        <td>
                            <button class="order_button move-up"><i class="fa fa-chevron-up"></i></button>
                            <button class="order_button move-down mr-2"><i class="fa fa-chevron-down"></i></button>
                        </td>
                        <td>
                            <?= $this->Html->link('Edit', ['action' => 'edit', $employee['employee_id']], ['class' => 'btn action-btn btn-warning']) ?>
                            <?= $this->Form->postLink('Delete', ['action' => 'deleteEmployee',  $employee['employee_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
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
        <script>
            $(document).ready(function() {
                function updateEmpOrder(id1, order1, id2, order2) {
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
                        url: 'employees/getEmployeeOrderAjax/', // Adjust the URL to match your setup
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
                        updateEmpOrder(id, order, prevId, prevOrder);
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
                        updateEmpOrder(id, order, nextId, nextOrder);
                    }
                });
            });
        </script>

    </body>

    </html>