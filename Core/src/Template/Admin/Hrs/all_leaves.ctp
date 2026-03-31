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
            <h3 class="text-center mb-5"><?= __d('hrs', 'List of Leave Application') ?></h3>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add New Leave', ['action' => 'addLeaveAdmin'], ['class' => 'btn btn-info']) ?></span>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('hrs', '#') ?></th>
                    <th><?= __d('hrs', 'Employee Name') ?></th>
                    <th><?= __d('hrs', 'Leave Type') ?></th>
                    <th><?= __d('hrs', 'Date From') ?></th>
                    <th><?= __d('hrs', 'Date to') ?></th>
                    <th><?= __d('hrs', 'Half Leave') ?></th>
                    <th><?= __d('hrs', 'Applied Date') ?></th>
                    <th><?= __d('hrs', 'Status') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
			<?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['leave_id']; ?> </td>
                    <td><?php echo $user['u_username']; ?></td>
                    <td><?php echo $user['hc_config_action_setup_id'] ?></td>
                    <td><?php echo $user['date_from'] ?></td>
                    <td><?php echo $user['date_to'] ?></td>
                    <td><?php echo $user['half_leave'] ?></td>
                    <td><?php echo $user['submit_date'] ?></td>
                    <td><?php echo $user['approval'] ?></td>
                    <td>
						<?php echo $this->Html->link('Action', ['action' => 'leaveAction', $user['leave_id']], ['class' => 'btn action-btn btn-info']) ?>
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