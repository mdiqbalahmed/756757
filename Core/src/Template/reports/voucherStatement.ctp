<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    </head>
    <style>
        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
    <body>
        <h3 style="text-align: center;background-color: rgba(0, 0, 0, 0.2);padding: 10px;overflow-x:auto;font-colour: red;">Voucher Statement Report</h3>
        <div style="background-color: rgba(0, 0, 0, 0.2); padding: 10px; margin-top: 10px; overflow-x:auto;">
            <p style="position: relative;">
                 <?php echo $head; ?>
                <span style="position: absolute; right: 0;">Report Time:  <?php echo $date=date('d-m-Y h:i A'); ?></span>
            </p>


            <table class="table table-bordered table-striped">

                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;">VN. No</th>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Name</th>
                        <th style="text-align: center;">SID</th>
                        <th style="text-align: center;">Session</th>
                        <th style="text-align: center;">Level</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: right;">Amount</th>
                        <th style="text-align: right;">Payment Amount</th>
                        <th style="text-align: right;">Due</th>
                        <th style="text-align: right;">Discount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($vouchers as $voucher) { ?>
                    <tr>
                        <td style="font-size: 13px; text-align: center;"><?php echo $voucher['voucher_no']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo date("d-m-Y h:i:A",strtotime($voucher['create_date'])); ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $voucher['name']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $voucher['sid']; ?></td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $voucher['session_name']; ?></td>

                        <td style="font-size: 13px; text-align: center;"><?php echo $voucher['level_name']; ?></td>
                        <td style="font-size: 13px; text-align: center; color: <?php echo $voucher['color']; ?>;"><?php echo $voucher['status']; ?></td>
                        <td style="font-size: 13px; text-align: right;"><?php echo number_format((float)$voucher['amount'], 2, '.', ''); ?></td>
                        <td style="font-size: 13px; text-align: right;"><?php echo number_format((float)$voucher['payment_amount'], 2, '.', ''); ?></td>
                        <td style="font-size: 13px; text-align: right;"><?php echo number_format((float)$voucher['due_amount'], 2, '.', '');?></td>
                        <td style="font-size: 13px; text-align: right;"><?php echo number_format((float)$voucher['discount_amount'], 2, '.', ''); ?></td>
                    </tr>
                        <?php } ?>
                    <tr>
                        <td style="font-size: 13px; text-align: center;"></td>
                        <td style="font-size: 13px; text-align: center;"colspan="6"><b><?php echo'Total'; ?></b></td>
                        <td style="font-size: 13px; text-align: right;"><b><?php echo number_format((float)$total['amount'], 2, '.', ''); ?></b></td>
                        <td style="font-size: 13px; text-align: right;"><b><?php echo number_format((float)$total['payment_amount'], 2, '.', ''); ?></b></td>
                        <td style="font-size: 13px; text-align: right;"><b><?php echo number_format((float)$total['due_amount'], 2, '.', '');?></b></td>
                        <td style="font-size: 13px; text-align: right;"><b><?php echo number_format((float)$total['discount_amount'], 2, '.', ''); ?></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
