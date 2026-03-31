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
            <h3 class="text-center"><?= __d('setup', 'List of Teachers') ?></h3>


        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('setup', 'ID') ?></th>
                    <th><?= __d('setup', 'Name') ?></th>
                </tr>
            </thead>
            <tbody>
			<?php foreach($teachers as $teacher){ ?>
                <tr>
                    <td><?php echo $teacher['employee_id']  ?></td>
                    <td><?php echo $teacher['name'] ?></td>
                </tr>
			<?php } ?>

            </tbody>
        </table>
    </body>
</html>