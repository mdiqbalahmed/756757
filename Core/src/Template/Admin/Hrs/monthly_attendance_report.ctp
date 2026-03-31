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



</body>
