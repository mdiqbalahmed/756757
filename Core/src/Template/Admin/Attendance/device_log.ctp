<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Device Log</title>
    </head>

    <body>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('setup', 'ID') ?></th>
                        <th><?= __d('setup', 'Date') ?></th>
                        <th><?= __d('setup', 'Present') ?></th>
                        <th><?= __d('setup', 'Absent') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log) { ?>
                    <tr>
                        <td><?php echo $log['id'] ?></td>
                        <td><?php echo $log['date'] ?></td>
                        <td><?php echo $log['present'] ?></td>
                        <td><?php echo $log['absent'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </body>

</html>