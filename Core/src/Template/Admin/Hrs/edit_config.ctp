<?php

$this->Form->unlockField('config_action_name');
$this->Form->unlockField('config_key');
$this->Form->unlockField('config_action_id');

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<div>
    <?php echo $this->Form->create(); ?>
    
    <section class="std_info">
        <h4><?= __d('hrs', 'HR Config') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Config Name :') ?></label>
                    </div>
                     <input name="config_action_id" type="hidden" value="<?php echo $hr_config_actions[0]['config_action_id']; ?>">
                    <div class="col-md-8">
                        <select id="inputState" class="form-select option-class dropdown260" name="config_key">
					<?php foreach ($hr_configs as $hr_config) { ?>
                            <option value="<?php echo $hr_config['config_key']; ?>"  <?php if ($hr_config['config_key'] == $hr_config_actions[0]['config_key']) { echo 'Selected';} ?>  ><?php echo $hr_config['config_name']; ?></option>
					<?php } ?>
                        </select>

                    </div>
                </div>
            </div>

            <div class="col-md-12  mt-3">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('hrs', 'Action Name :') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input name="config_action_name" type="text" value="<?php echo $hr_config_actions[0]['config_action_name']; ?>" class="form-control" id="inputSId" placeholder="Action Name" required>
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button type="submit" class="btn btn-info"><?= __d('hrs', 'Update') ?></button>
            <?php echo $this->Form->end(); ?>
            </div>
    </section>
</div>
