<?php

use Cake\Core\Configure;

$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
$borderImage = Configure::read('Result.borderImage');
$headerFontFamily = Configure::read('Result.headerFontFamily');
$headerFontCDN = Configure::read('Result.headerFontCDN');
$watermarkLogo = Configure::read('Result.watermarkLogo');
$headSign = Configure::read('Result.headSign');

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>

    <?php if (!empty($headerFontCDN)): ?>
    <link rel="stylesheet" href="<?= h($headerFontCDN) ?>">
<?php endif; ?>



    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fc;
            margin: 20px;
        }

        .resHdr {
            text-align: center;
            margin-bottom: 25px;
        }

        .resHdr .schoolIdentity p {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .resHdr h4 {
            margin-top: 10px;
            font-size: 18px;
            color: #555;
        }

        .ExRegNo,
        .ExRollNo {
            font-weight: bold;
            margin: 0 10px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        thead {
            background: #2c3e50;
            color: white;
        }

        thead th {
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        tbody td {
            padding: 8px;
            font-size: 13px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f2f6fa;
        }

        tbody tr:hover {
            background: #eaf2f8;
        }

        tfoot th {
            padding: 10px;
            text-align: center;
            font-size: 14px;
            background: #dfe6e9;
            font-weight: bold;
        }

        /* Print-friendly */
        @media print {
            body {
                background: white;
                margin: 0;
            }

            table {
                box-shadow: none;
            }

            thead {
                background: #000 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
            }

            tfoot {
                background: #ccc !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="resHdr">
    <?php if (!empty($borderImage)): ?>
        <div style="background: url('<?= $borderImage ?>') repeat-x; height: 8px; margin-bottom: 10px;"></div>
    <?php endif; ?>

    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 15%; text-align: center;">
                <?php if (!empty($instituteLogo)): ?>
                    <img src="<?= $instituteLogo ?>" alt="Logo" style="max-height: 80px;">
                <?php endif; ?>
            </td>
            <td style="width: 70%; text-align: center;">
                <p style="font-size: 28px; font-weight: bold; margin: 0; font-family: <?= $headerFontFamily ?>; color: #2c3e50;">
                    <?= $instituteName ?>
                </p>
                <p style="font-size: 16px; margin: 3px 0; color: #555;">
                    <?= $vouchers[0]['purpose']; ?>
                </p>
                <hr style="width: 50%; margin: 5px auto; border: 1px solid #444;">
                <div style="font-size: 14px;">
                    <span class="ExRegNo"><?= $head1; ?></span>
                    <span class="ExRollNo"><?= $head2; ?></span>
                </div>
            </td>
            <!--<td style="width: 15%; text-align: center;">-->
            <!--    <?php if (!empty($instituteLogo)): ?>-->
            <!--        <img src="<?= $instituteLogo ?>" alt="Logo" style="max-height: 80px; opacity: 0.8;">-->
            <!--    <?php endif; ?>-->
            <!--</td>-->
        </tr>
    </table>
</div>


    <table border="1">
        <thead>
            <tr>
                <th>SL</th>
                <th>Roll</th>
                <th>Name Of Student</th>
                <th>SID</th>
                <?php foreach ($months as $month): ?>
                    <th><?= $month['month_name'] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
            $monthTotals = array_fill(0, count($months), 0);
            foreach ($transformed_vouchers as $student): ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $student['roll'] ?></td>
                    <td style="text-align: left;"><?= $student['name'] ?></td>
                    <td><?= $student['sid'] ?></td>
                    <?php foreach ($months as $month): ?>
                        <td>
                            <?php
                            $monthName = $month['month_name'];
                            $amount = isset($student['amounts'][$monthName]) ? $student['amounts'][$monthName] : '';
                            echo $amount;
                            if ($amount !== '') {
                                $monthTotals[array_search($monthName, array_column($months, 'month_name'))] += $amount;
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <?php foreach ($monthTotals as $total): ?>
                    <th><?= $total > 0 ? number_format($total) : '' ?></th>
                <?php endforeach; ?>
            </tr>
        </tfoot>
    </table>
</body>

