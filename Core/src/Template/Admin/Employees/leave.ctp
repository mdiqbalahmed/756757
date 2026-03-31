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
        <h3 class="text-center mb-5"><?= __d('employees', 'List of Leave Application') ?></h3>
        <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Leave Application', ['action' => 'addLeave'], ['class' => 'btn btn-info']) ?></span>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th><?= __d('employees', '#') ?></th>
                <th><?= __d('employees', 'Employee Name') ?></th>
                <th><?= __d('employees', 'Leave Type') ?></th>
                <th><?= __d('employees', 'Date From') ?></th>
                <th><?= __d('employees', 'Date to') ?></th>
                <th><?= __d('employees', 'Half Leave') ?></th>
                <th><?= __d('employees', 'Applied Date') ?></th>
                <th><?= __d('employees', 'Status') ?></th>
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
                        <?php echo $this->Html->link('Edit', ['action' => 'editLeave', $user['leave_id']], ['class' => 'btn action-btn btn-warning']) ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
    $paginator = $this->paginator->setTemplates([
        'number' > '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
        'current' => '<li class="page-item active"><a href="{{url}}" class="page-link">{{text}}</a></li>',
        'first' => '<li class="page-item"><a href="{{url}}" class="page-link">&laquo;</a></li>',
        'last' => '<li class="page-item"><a href="{{url}}" class="page-link">&raquo;</a></li>',
        'prevActive' => '<li class="page-item"><a href="{{url}}" class="page-link">&lt;</a></li>',
        'nextActive' => '<li class="page-item"><a href="{{url}}" class="page-link">&gt;</a></li>'
    ])
    ?>
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