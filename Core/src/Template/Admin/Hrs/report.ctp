<?php

$this->Form->unlockField('month');
$this->Form->unlockField('year');
?>

<body>
    <div class="no-print" style="background-color: #f2f2f2; padding: 10px;">
        <h4 class="text-left">Search Attendance Sheet</h4>
        <?php echo $this->Form->create(); ?>
        <div class="row">
            <div class="col-md-6 col-sm-12  mt-2">
                <label for="inputState" class="form-label">Year</label>
                <input name="year" type="number" class="form-control" id="" placeholder="Year" value="<?php echo $data['year'] ?>">
            </div>
            <div class="col-md-6 col-sm-12  mt-2">
                <label for="inputState" class="form-label">Month</label>
                <select id="month" class="form-select dropdown260" name="month"  required="true">
                    <option value="">Choose...</option>
                    <?php foreach ($months as $month) { ?>
                    <option value="<?php echo $month['name']; ?>" <?php if ($data['month'] == $month['name']) { echo 'Selected'; } ?>><?php echo $month['name']; ?> </option>
                    <?php } ?>
                </select>
            </div>


        </div>
        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info">Search</button>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>


    <?php if (isset($employees)) { ?>
    <div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px; overflow-x:auto;">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">Name</th>
                       <?php foreach ($days as $key => $day) { ?>
                    <th style="text-align: center;">  <?php echo date("d", strtotime($day['date'])); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($employees as $employee) { ?>
                <tr>
                    <td style="font-size: 13px; text-align: center;"><b><?php echo $employee['name']; ?></b></td>
                      <?php foreach ($employee['attendance'] as $key => $attandance) { ?>
                    <td style="font-size: 13px; text-align: center;">  <?php echo $attandance['text']; ?></td>
                    <?php } ?>
                </tr>
                    <?php } ?>
            </tbody>
        </table>

    </div>
    <?php } ?>
</body>
