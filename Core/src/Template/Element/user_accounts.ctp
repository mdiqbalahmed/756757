<?php
use Cake\ORM\TableRegistry;
?>

<style>
    .result_table td {
        text-align: center;
    }

    .result_table td a {
        font-size: smaller;
    }
</style>

<div class="table-responsive-sm">
    <table class="table table-striped">
        <thead class="thead-custom">
            <tr>
                <th>Session</th>
                <th>Voucher No</th>
                <th>Month</th>
                <th>Date of Payment</th>
                <th>Payment Method</th>
                <th>Paid Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        </tr>
        </thead>
        <tbody class="result_table">

            <?php foreach ($transactions as $transaction) { ?>
                <tr>
                    <td><?= $transaction['session_name'] ?></td>
                    <td><?php echo $transaction['voucher_no'] ?></td>
                    <td style="text-transform:uppercase">
                        <?php
                        $month_ids_str = str_replace(['[', ']', '"'], '', $transaction['month_ids']);
                        $month_ids_array = array_map('intval', explode(',', $month_ids_str));

                        $accMonthTable = TableRegistry::getTableLocator()->get('acc_months');
                        $monthNames = $accMonthTable
                            ->find()
                            ->select(['month_name'])
                            ->where(['id IN' => $month_ids_array])
                            ->order(['id' => 'ASC'])
                            ->enableAutoFields(true)
                            ->enableHydration(false)
                            ->toArray();

                        $shortMonthNames = array_map(function ($month) {
                            return substr($month['month_name'], 0, 3);
                        }, $monthNames);

                        $commaSeparatedNames = implode(', ', $shortMonthNames);
                        $transaction['month_name'] = $commaSeparatedNames;

                        echo $commaSeparatedNames;
                        ?>
                    </td>
                    <td><?php echo $transaction['payment_date'] ?></td>
                    <td><?php echo $transaction['bank_name'] ?></td>
                    <td><?php echo $transaction['amount'] ?></td>
                    <td style="font-weight:600">
                        <?php if ($transaction['payment_status'] == 1) {
                            echo "Paid";
                        } else {
                            echo "Unpaid";
                        } ?>
                    </td>
                    <td style="display:flex">
                        <?php if ($transaction['payment_status'] != 1) { echo $this->Html->link('Pay Now', ['action' => 'payNow', $transaction['transaction_id']], ['class' => 'btn action-btn btn-success mr-3', 'target' => '_blank']); }?>
                        <?php echo $this->Html->link('Print Recipt', ['action' => 'printRecipt', $transaction['transaction_id']], ['class' => 'btn action-btn btn-warning', 'target' => '_blank']) ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
