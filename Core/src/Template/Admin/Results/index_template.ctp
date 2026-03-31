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
            <h4 class="text-center"><?= __d('Result', 'List of Single Template') ?></h4>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Single Template', ['action' => 'addTemplate'], ['class' => 'btn btn-info']) ?></span>

        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('Result', 'ID') ?></th>
                    <th><?= __d('Result', 'Template Name') ?></th>
                    <th><?= __d('Result', 'Merit From') ?></th>
                    <th><?= __d('Result', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($single_result_templates as $result_template) { ?>
                <tr>
                    <td><?php echo $result_template->result_template_id ?></td>
                    <td><?php echo $result_template->name ?></td>
                    <td><?php echo ucfirst($result_template->merit) ?></td>
                    <td>
                        <?php echo $this->Html->link('View', ['action' => 'viewTemplate', $result_template->result_template_id], ['class' => 'btn action-btn btn-success']) ?>
                        <?php echo $this->Html->link('Delete', ['action' => 'deleteTemplate', $result_template->result_template_id], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
     <div class="rows">
            <h4 class="text-center"><?= __d('Result', 'List of Marge Template') ?></h4>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Marge Template', ['action' => 'addMergeTemplate'], ['class' => 'btn btn-info']) ?></span>

        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('Result', 'ID') ?></th>
                    <th><?= __d('Result', 'Template Name') ?></th>
                    <th><?= __d('Result', 'Merit From') ?></th>
                    <th><?= __d('Result', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($result_templates_marge as $result_template) { ?>
                <tr>
                    <td><?php echo $result_template->result_template_id ?></td>
                    <td><?php echo $result_template->name ?></td>
                    <td><?php echo ucfirst($result_template->merit) ?></td>
                    <td>
                        <?php echo $this->Html->link('View', ['action' => 'viewTemplate', $result_template->result_template_id], ['class' => 'btn action-btn btn-success']) ?>
                        <?php echo $this->Html->link('Delete', ['action' => 'deleteTemplate', $result_template->result_template_id], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </body>

</html>