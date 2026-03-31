<?php

$this->Form->unlockField('config_action_id');
$this->Form->unlockField('user_id');
$this->Form->unlockField('year');
$this->Form->unlockField('months');
$this->Form->unlockField('value');

?>


<div>
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <section class="std_info">
        <h4><?= __d('hrs', 'HR Config Setup') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Config Action Name :') ?></label>
                    </div>
                    <div class="col-md-8">
                        <select id="inputState" class="form-select option-class dropdown260" name="config_action_id">
					<?php foreach ($hr_config_actions as $hr_config_action) { ?>
                            <option value="<?php echo $hr_config_action['config_action_id']; ?>"><?php echo $hr_config_action['config_action_name']; ?></option>
					<?php } ?>
                        </select>
                    </div>
                </div>
            </div>


            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"><?= __d('hrs', "User's Name :") ?></label>
                    </div>
                    <div class="col-md-8">
                        <select id="inputState" class="form-select option-class dropdown260" name="user_id">
                                      <?php foreach ($users as $user) { ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
					<?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Year :') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input name="year" type="text" class="form-control" id="inputSId" value="<?php echo $today = getdate()['year'];?>" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="my-input" class="form-label"><?= __d('hrs', 'Month :') ?></label>
                    </div>
                    <div class="col-md-8">
                        <select id=""  size="5" class="form-select option-class dropdown260 " name="months[]" multiple="multiple" >
                             <?php
                            foreach ($months as $id => $month) {  ?>
                            <option value="<?php echo $month['name']; ?>"><?php echo $month['name']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>


            <div class="col-md-12  mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Value :') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input name="value" type="text" class="form-control" id="inputSId" placeholder="Value" required>
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button type="submit" class="btn btn-info"><?= __d('hrs', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
            </div>
    </section>
</div>

<script type='text/javascript'>
$(document).ready(function()
{	 
  $("option:selected").map(function(){ return this.value }).get().join(", ");
});
</script>
