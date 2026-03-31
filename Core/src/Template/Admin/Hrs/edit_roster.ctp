<?php

$this->Form->unlockField('roster_name');
$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('employee_id');

?>


<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h4><?= __d('hrs', 'Add Roster') ?></h4>
        <div class="row mt-2 p-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Roster Name: ') ?></label>
                    </div>
                    <div class="col-md-10">
                        <input name="roster_name" type="text"class="form-control" id="inputSId"  value="<?php echo $rosters[0]['roster_name']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'Start Date') ?></label>
                            </div>
                            <div class="col-md-8">
                                <input name="start_date" type="date" class="form-control" value="<?php echo $rosters[0]['start_date']; ?>" id="inputSId">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="inputSId" class="form-label"><?= __d('hrs', 'End Date') ?></label>
                            </div>
                            <div class="col-md-8">
                                <input name="end_date" type="date" class="form-control" value="<?php echo $rosters[0]['end_date']; ?>" id="inputSId">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-4">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Shift') ?></label>
                    </div>
                    <div class="col-md-10">
                        <select id="inputState" class="form-select option-class dropdown260" name="shift_id" required>
				<?php foreach ($shifts as $shift) { ?>
                            <option value="<?php echo $shift['shift_id']; ?>" <?php if ($shift['shift_id'] == $rosters[0]['shift_id']) { echo 'Selected';} ?>  ><?php echo $shift['shift_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>
                </div>
            </div>



            <div class="col-md-12 mt-4">
                <h4><?= __d('hrs', 'Employees') ?></h4>
            </div>
            <?php foreach($designations as $designation){?>
            <div class="col-md-12 mt-4 mx-2">
                <h5>  <?php echo $designation['name']; ?></h5>
            </div>
               <?php foreach($designation['employee'] as $employee){?>
            <div class="col-md-2 mt-1">
                <label for="inputSId" class="form-label">  <?php echo $employee['name']; ?></label>
            </div>
            <div class="col-md-1 mt-1">
                <input type="checkbox" class="" id="" name="employee_id[]" value="<?php echo $employee['employee_id'];?>" <?php if($employee['roster_id'] ==$rosters[0]['roster_id']) {echo 'checked';}?>>
            </div>
           <?php } ?>
           <?php } ?>
        </div>


</div>


<div class="text-right float-right mt-5">
    <button type="submit" class="btn btn-info"><?= __d('hrs', 'Submit') ?></button>
                <?php echo $this->Form->end(); ?>
</div>
</section>
</div>

<script type="text/javascript">
    $(document).ready(function() {
      
    });


</script>