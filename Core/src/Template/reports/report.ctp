
<body>


    <?php if (isset($employees)) { ?>
    <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px; overflow-x:auto;">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">Name</th>
                       <?php foreach ($days as $key => $day) { ?>
                    <th style="text-align: center;">  <?php echo date("d", strtotime($day['date'])); ?></th>
                    <?php } ?>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($employees as $employee) { ?>
                <tr>
                    <td style="font-size: 13px; text-align: center;"><b><?php echo $employee['name']; ?></b></td>
                      <?php foreach ($employee['attendance'] as $key => $attandance) { ?>
                    <td style="font-size: 13px; text-align: center;">  <?php echo $attandance['text']; ?></td>
                    <?php } ?>
                    <td style="font-size: 13px; text-align: center;"><b>
                        <?php echo 'Late In: ('.$employee['attendance_status']['late_in'].')<br>'.'Early Out: ('.$employee['attendance_status']['early_out'].')<br>'.'Proper In: ('.$employee['attendance_status']['proper_in'].')<br>'.'Proper Out: ('.$employee['attendance_status']['proper_out'].')<br>'; ?>
                        </b></td>
                </tr>
                    <?php } ?>
            </tbody>
        </table>

    </div>
    <?php } ?>
</body>
