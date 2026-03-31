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

        <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Configuration', ['action' => 'addPageConfig'], ['class' => 'btn btn-info']) ?></span>

    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('boxes', 'ID') ?></th>
                    <th><?= __d('boxes', 'Configuration Title') ?></th>
                    <th><?= __d('boxes', 'Page') ?></th>
                    <th><?= __d('boxes', 'Box per Row') ?></th>
                    <th><?= __d('boxes', 'box Height') ?></th>
                    <th><?= __d('boxes', 'box Position') ?></th>
                    <th><?= __d('boxes', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($configs as $config) {
                ?>
                    <tr>
                        <td><?php echo $config['id'] ?></td>
                        <td><?php echo $config['config_title'] ?></td>
                        <td><?php if ($config['node_page_id'] != 0) {
                                echo $config['node_title'];
                            } else {
                                Print_r('Home');
                            } ?></td>
                        <td><?php echo $config['box_per_row'] ?></td>
                        <td><?php echo $config['box_height'] ?></td>
                        <td><?php if ($config['box_position'] == 1) {
                                Print_r('Top');
                            } else {
                                Print_r('Bottom');
                            }; ?></td>
                        <td>
                            <?php echo $this->Html->link('Edit', ['action' => 'editPageConfig', $config['id']], ['class' => 'btn action-btn btn-warning']) ?>
                            <?php echo $this->Form->postLink('Delete', ['action' => 'deletePageConfig', $config['id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
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