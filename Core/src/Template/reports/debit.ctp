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
        <h3 style="text-align: center;background-color: rgba(0, 0, 0, 0.2);padding: 10px;overflow-x:auto;font-colour: red;">Debit Report</h3>
    <?php if (isset($debits)) { ?>
        <div style="background-color: rgba(0, 0, 0, 0.2); padding: 10px; margin-top: 50px; overflow-x:auto;">

            <table class="table table-bordered table-striped">
                <h6 style="float: right;">Date Between <?php echo $start_date; ?> to <?php echo $end_date1; ?> </h6>
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;">Serial No</th>
                        <th style="text-align: center;">Voucher No</th>
                        <th style="text-align: center;">Bank</th>
                        <th style="text-align: center;">Purpose</th>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $serialNo = 1; // Initialize the serial number
                    $totalAmount = 0; // Initialize the total amount
                    foreach ($debits as $debit) {
                        $totalAmount += $debit['amount']; // Update the total amount
                    ?>
                    <tr>
                        <td style="font-size: 13px; text-align: center;"><b><?php echo $serialNo; ?></b></td>
                        <td style="font-size: 13px; text-align: center;"><b><?php echo $debit['voucher_no']; ?></b></td>
                        <td style="font-size: 13px; text-align: center;"><b><?php echo $debit['bank']; ?></b></td>
                        <td style="font-size: 13px; text-align: center;"><b><?php echo $debit['purpose']; ?></b></td>
                        <td style="font-size: 13px; text-align: center;"><b><?php echo $debit['transaction_date']; ?></b></td>
                        <td style="font-size: 13px; text-align: center;"><b><?php echo $debit['amount']; ?></b></td>
                    </tr>
                        <?php
                        $serialNo++; // Increment the serial number for the next row
                    } ?>
                </tbody>
            </table>

            <p style="text-align: right;font-weight: bold;">Total Amount: <?php echo $totalAmount; ?></p>
        </div>
    <?php } ?>
    </body>
</html>
