<?php

$this->Form->unlockField('name'); 
   $this->Form->unlockField('staff_id'); 
      $this->Form->unlockField('phone_number'); 
?>

<div>
<?php echo $this->Form->create(); ?>
    <section>
        <h4><?= __d('staffs', 'Teacher Form') ?></h4>

        <div class="col-md-4  mt-2">
            <label for="inputState" class="form-label"><?= __d('staffs', 'Staff Name') ?></label>
            <input name="name" type="text" class="form-control" id="inputSName"value="<?php echo $staffs['name']; ?>" >
        </div>
        <div class="col-md-4  mt-2">
            <label for="inputState" class="form-label"><?= __d('staffs', 'Mobile Number') ?></label>
            <input name="phone_number" type="text" class="form-control" id="inputSName"value="<?php echo $staffs['phone_number']; ?>" >
        </div>
        <input name="staff_id" type="hidden" class="form-control" id="inputSName"value="<?php echo $staffs['staff_id'];?>">
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('staffs', 'Submit') ?></button>
	<?php echo $this->Form->end(); ?>
    </div> 

</div>