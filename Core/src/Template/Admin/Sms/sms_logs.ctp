<?php

echo $this->Form->unlockField('sms_type');
echo $this->Form->unlockField('start_date');
echo $this->Form->unlockField('end_date');

$sms_type = isset($sms_type) ? $sms_type : '';
?>
<div class="container">
    <div class="header">
        <h3 class=" text-center" style="word-spacing: 7px; text-transform:capitalize;">
            <?= __d('SMS', 'SMS Logs') ?>
        </h3>
    </div>

    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <div class="form ">
        <section class="bg-light mt-1 p-5 m-auto" action="#">
            <div class=" form_area p-4">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-3">
                                <p class="label-font13">
                                    <?= __d('SMS', 'Type') ?>
                                </p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="sms_type">
                                    <option value="">
                                        <?= __d('SMS', '-- Choose --') ?>
                                    </option>
                                    <option value="all">
                                        <?= __d('SMS', 'All Types') ?>
                                    </option>
                                    <?php
                                    $smsTypes = array_column($searchLogs, 'sms_type');
                                    $uniqueSmsTypes = array_unique(array_filter($smsTypes));
                                    sort($uniqueSmsTypes);

                                    foreach ($uniqueSmsTypes as $smsType) {
                                    ?>
                                        <option style="text-transform:capitalize" value="<?= $smsType; ?>">
                                            <?= $smsType; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-3">
                                <p class="label-font13">
                                    <?= __d('SMS', 'Sent Date Range') ?>
                                </p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <div class="input-group">
                                    <input type="date" name="start_date" id="start_date" class="form-control">


                                    <span class="input-group-text">to</span>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Get the current date in the format YYYY-MM-DD
                    var currentDate = new Date().toISOString().split('T')[0];

                    // Set the value of the input field to the current date
                    document.getElementById('start_date').value = currentDate;
                    document.getElementById('end_date').value = currentDate;
                </script>
                <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-success ">
                        <?= __d('setup', 'Search') ?>
                    </button>
                </div>
            </div>
        </section>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<style>
    #sms_table th {
        padding: .5em;
        text-align: center;
    }

    #sms_table th:first-child {
        text-align: left;
    }

    #sms_table td {
        padding: .3725em;
        text-align: center;
        vertical-align: middle;
    }

    #sms_table td:first-child {
        text-align: left;
    }

    @media only screen and (min-width: 769px) {
        #sms_body {
            min-width: 512px;
            cursor: pointer;
        }
    }

    @media only screen and (max-width: 768px) {
        td:has(#sms_body) {
            min-width: 240px;
        }
    }


    .hoverme {
        background: #f7f7f7 !important;
        font-size: 12px;
    }

    .hoverme {
        position: relative;
        cursor: pointer;
    }

    .pop {
        opacity: 0;
        width: 0;
        height: 0;
        border-radius: 10px;
        background: #fff39c;
        z-index: 1;
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .hoverme:hover .pop {
        opacity: 1;
        width: 350px;
        height: auto;
    }

    .pop p {
        color: #353535;
        font-size: small;
        padding: 10px;
        margin: 0;
    }

    .sms_table * {
        font-size: small;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        #sms_table {
            position: absolute;
            top: 0;
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        #sms_table thead {
            display: table-header-group;
            background-color: #000;
            color: #fff;
        }

        #sms_table tbody {
            display: table-row-group;
        }

        #sms_table tr {
            page-break-inside: avoid;
        }

        #sms_table th,
        #sms_table td {
            border: 1px solid #000;
            padding: 8px;
        }

        #sms_table td {
            max-width: 300px;
            /* Adjust the width as needed for your content */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
</style>

<?php if (isset($smsLogs)) { ?>
    <div class="container">
        <table class="table table-responsive-sm table-bordered" id="sms_table">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>SMS Body</th>
                    <th>Segment</th>
                    <th>Recipients</th>
                    <th>Message Count</th>
                </tr>
            </thead>
            <tbody class="sms_table">
                <?php $totalSmsCount = 0 ?>
                <?php foreach ($smsLogs as $smsLog) {
                    $maxSmsLength = 50;
                    if (isset($smsLog['sms'])) {
                        // Use substr to limit the length of the [sms] field
                        $truncatedSms = substr($smsLog['sms'], 0, $maxSmsLength);
                        // Add the full SMS as a data attribute
                        $smsLog['data_full_sms'] = htmlspecialchars($smsLog['sms'], ENT_QUOTES, 'UTF-8');
                        // Update [sms] field with truncated text
                        $smsLog['sms'] = $truncatedSms;
                    }
                    $totalSmsCount += $smsLog['sms_count'];
                ?>
                    <tr>
                        <td style="min-width:12%"><?= $smsLog['date'] ?></td>
                        <td class="text-capitalize"><?= $smsLog['sms_type'] ?></td>
                        <td>
                            <div class="hoverme" id="sms_body" data-full-sms="<?= $smsLog['data_full_sms'] ?>">
                                <?= $smsLog['sms'] . '...' ?>
                                <div class="pop">
                                    <p><?= $smsLog['data_full_sms'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center"><?= $smsLog['segment'] ?></td>
                        <td class="text-center"><?= $smsLog['number_of_sms'] ?></td>
                        <td class="text-center"><?= $smsLog['sms_count'] ?></td>
                    </tr>

                <?php } ?>
                <tr>
                    <td colspan="5" style="font-weight: bold; text-align:center;font-size:1.25em">Total SMS Sent: </td>
                    <td style="font-weight: bold;font-size:1.25em"><?= $totalSmsCount ?></td>
                </tr>
            </tbody>
        </table>

    </div>

<?php } ?>
