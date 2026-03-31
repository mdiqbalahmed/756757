<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    </head>
    <body>
        <h3 style="text-align: center;background-color: rgba(0, 0, 0, 0.2);padding: 10px;overflow-x:auto;font-colour: red;">Balance Sheet Report</h3>
    <?php if (isset($credits)) { ?>
        <div style="background-color: rgba(0, 0, 0, 0.2); padding: 10px; margin-top: 10px; overflow-x:auto;">
            <table class="table table-bordered table-striped">
            <p style="position: relative;">
                Date Between <?php echo $date1; ?> to <?php echo $date2; ?>
                <span style="position: absolute; right: 0;">Report Time:  <?php echo $date=date('d-m-Y h:i A'); ?></span>
            </p>

                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;">Serial No</th>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Credit Amount</th>
                        <th style="text-align: center;">Debit Amount</th>
                        <th style="text-align: center;">Balance</th>
                    </tr>
                </thead>
                <tbody>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-size: 16px; text-align: center;">Previous Balance:</td>
                <td style="font-size: 16px; text-align: center;"> <?php echo number_format($previous_balance, 2); ?></td>
                    <?php
                    $serialNo = 1; // Initialize the serial number
                    $totalAmount = 0; // Initialize the total amount
//                    pr($credits);die;
                    foreach ($credits as $credit) {
                        $totalAmount += $credit['balance']; // Update the total amount
                    ?>
                <tr>
                    <td style="font-size: 13px; text-align: center;"><b><?php echo $serialNo; ?></b></td>
                    <td style="font-size: 13px; text-align: center;"><b><?php echo $credit['date']; ?></b></td>
                    <td style="font-size: 13px; text-align: center;"><b><?php echo $credit['credit']; ?></b></td>
                    <td style="font-size: 13px; text-align: center;"><b><?php echo $credit['debit']; ?></b></td>
                    <td style="font-size: 13px; text-align: center;"><b><?php echo $credit['balance']; ?></b></td>
                </tr>
                        <?php
                        $serialNo++; // Increment the serial number for the next row
                    } ?>
                </tbody>
                <tr>
                    <td style="font-size: 16px; text-align: center;">Total</td>
                    <td></td>
                    <td style="font-size: 16px; text-align: center;"><?php echo number_format($totalCr, 2); ?></td>
                    <td style="font-size: 16px; text-align: center;"><?php echo number_format($totalDb, 2); ?></td>
                    <td style="font-size: 16px; text-align: center;"><?php echo number_format($totalAmount, 2); ?></td>
                </tr>
            </table>

            <!--<p style="text-align: right;font-weight: bold;">Total Amount: <?php echo $totalAmount; ?></p>-->
        </div>
    <?php } ?>
    </body>
</html>
