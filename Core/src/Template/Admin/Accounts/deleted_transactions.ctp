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
            <h3 class="text-center"><?= __d('accounts', 'Deleted Transactions') ?></h3>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('accounts', 'ID') ?></th>
                        <th><?= __d('accounts', 'TRN No') ?></th>
                        <th><?= __d('accounts', 'Transaction Type') ?></th>
                        <th><?= __d('accounts', 'Amount') ?></th>
                        <th><?= __d('accounts', 'Transaction Date') ?></th>
                        <th><?= __d('accounts', 'Bank Name') ?></th>
                        <th><?= __d('accounts', 'Notes') ?></th>


                    </tr>
                </thead>
                <tbody>
				<?php
				foreach ($transactions as $transaction) { ?>
                    <tr>
                        <td><?= $transaction['transaction_id'] ?></td>
                        <td><?= $transaction['trn_no'] ?></td>
                        <td><?= $transaction['transaction_type'] ?></td>
                        <td><?= $transaction['amount'] ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo date("d-m-Y h:i:A",strtotime($transaction['transaction_date'])); ?></td>
                        <td><?= $transaction['bank_name'] ?></td>
                        <td><?= $transaction['note'] ?></td>

                    </tr>
				<?php } ?>

                </tbody>
            </table>
        </div>
    </body>

</html>