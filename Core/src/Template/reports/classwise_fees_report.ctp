<?php

use Cake\Core\Configure;

$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
$borderImage = Configure::read('Result.borderImage');
// $headerFontFamily = Configure::read('Result.headerFontFamily');
$headerFontCDN = Configure::read('Result.headerFontCDN');
$watermarkLogo = Configure::read('Result.watermarkLogo');
$headSign = Configure::read('Result.headSign');



?>

<style>
.level-column {
        min-width: 50px; /* you can adjust */
        white-space: nowrap; /* prevent wrapping */
    }
    @media print {
        thead.thead-dark th {
            background-color: #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        tfoot.table-dark td {
            background-color: #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<body style="background-color: white">
     <a href="javascript:window.print();"
        class="btn btn-primary position-fixed d-print-none"
        style="top: 20px; right: 20px; z-index: 1000;">
        প্রিন্ট করুন
    </a>

    <div style="text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px;">
        <?= $this->Html->image($instituteLogo, ['alt' => 'logo', 'style' => 'height:60px;']) ?>
        <h2 style="margin: 0; font-weight: 900; font-size: 45px;"><?= h($instituteName) ?></h2>
    </div>

    <h3 class="text-center"><?= __d('accounts', 'Class Wise Fees Credit Report') ?></h3>

<?php
// Extract all unique purposes
$purposes = [];
foreach ($finalData as $level => $purposeData) {
    foreach ($purposeData as $purpose => $amount) {
        if (!in_array($purpose, $purposes)) {
            $purposes[] = $purpose;
        }
    }
}
sort($purposes); // Sorting purposes for consistent order

// Initialize column totals
$columnTotals = array_fill_keys($purposes, 0);
$grandTotal = 0;
?>

  <div class="table-responsive rounded" style="">
        <table class="table table-striped table-hover table-bordered" style="border: 1px solid #dee2e6;" id="studentTable">
            <thead class="thead-dark" style="background-color: black ; color: white;">
            <tr>
                <th width="15%">Class</th>
                <?php foreach ($purposes as $purpose): ?>
                <th class="text-center"><?php echo htmlspecialchars($purpose); ?></th>
                <?php endforeach; ?>
                <th class="text-center" width="12%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($finalData as $level => $purposeData): ?>
            <tr>
                <td class="level-column"><strong><?php echo htmlspecialchars($level); ?></strong></td>
                <?php
                    $rowTotal = 0;
                    foreach ($purposes as $purpose) {
                        $amount = $purposeData[$purpose] ?? 0;
                        $rowTotal += $amount;
                        $columnTotals[$purpose] += $amount;
                        echo '<td class="text-end">' . ($amount > 0 ? number_format($amount, 2) : '<span class="text-muted">--</span>') . '</td>';
                    }
                    $grandTotal += $rowTotal;
                    ?>
                <td class="text-end"><strong><?php echo number_format($rowTotal, 2); ?></strong></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot class="table-dark text-white">
            <tr>
                <td><strong>Total</strong></td>
                <?php foreach ($purposes as $purpose): ?>
                <td class="text-end"><strong><?php echo number_format($columnTotals[$purpose], 2); ?></strong></td>
                <?php endforeach; ?>
                <td class="text-end"><strong><?php echo number_format($grandTotal, 2); ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div> <!-- end of leftblock -->
</body>