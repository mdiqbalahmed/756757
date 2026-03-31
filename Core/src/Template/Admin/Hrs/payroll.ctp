<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>

        <div>
            <h3 class="text-center hello"><?= __d('hrs', 'List of All Payroll') ?></h3>
            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Payroll Genarate', ['action' => 'addPayroll'], ['class' => 'btn btn-info']) ?></span>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('hrs', 'Year') ?></th>
                        <th><?= __d('hrs', 'Month') ?></th>
                        <th><?= __d('hrs', 'Type') ?></th>
                        <th><?= __d('hrs', 'Generate Date') ?></th>
                        <th><?= __d('hrs', 'Payment') ?></th>
                        <th><?= __d('hrs', 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>

                    		<?php
				foreach ($payrolls as $payroll) {
				?>
                    <tr>
                        <td><?php echo $payroll['year'] ?></td>
                        <td ><?php echo $payroll['month'] ?> </td>
                        <td ><?php echo $payroll['type'] ?></td>
                        <td ><?php echo $payroll['create_date'] ?> </td>
                        <td ><?php echo $payroll['payment'] ?></td>
                        <td>
                           <?php echo $this->Html->link('payment & View', ['action' => 'payment', $payroll['payroll_id']], ['class' => 'btn btn-warning']) ?>
                        </td>

                    </tr>
				<?php } ?>

                </tbody>
            </table>
        </div>
    </body>

</html>