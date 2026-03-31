<?php $this->Form->unlockField('node_page_id'); ?>
<?php $this->Form->unlockField('config_title'); ?>
<?php $this->Form->unlockField('box_per_row'); ?>
<?php $this->Form->unlockField('box_height'); ?>
<?php $this->Form->unlockField('box_position'); 
?>



<div>
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <section>
        <h4><?= __d('boxes', 'Add Configuration for Boxes') ?></h4>
        <div class="row mx-3 mt-2 p-3 pb-4 form-box">
            <div class="col-8 mt-2">
                <label class="form-label"><?= __d('boxes', 'Configuration title') ?></label>
                <input name="config_title" type="text" class="form-control" placeholder="Box title" value="<?=$configs['config_title']?>" required>
            </div>
            <div class="col-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Location') ?></label>
                <select class="form-select option-class dropdown260" name="node_page_id" required>
                    <option>-- Choose --</option>
                    <option value="0" <?php if ($configs['node_page_id'] == 0) {echo 'Selected';} ?>>Home
                    </option>
                    <?php
                    foreach ($nodes as $node) { ?>
                        <option value="<?php echo $node['id']; ?>" <?php if ($node['id'] == $configs['node_page_id']) {echo 'Selected';} ?>>
                            <?php echo $node['title']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Box Position') ?></label>
                <select class="form-select option-class dropdown260" name="box_position" required>
                    <option value="" <?php if ($configs['box_position'] == null) {echo 'Selected';}?>>-- Choose --</option>
                    <option value="1" <?php if ($configs['box_position'] == 1) {echo 'Selected';} ?>>Top</option>
                    <option value="0" <?php if ($configs['box_position'] == 0) {echo 'Selected';} ?>>Bottom
                </select>
                
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Box Per Row') ?></label>
                <select class="form-select option-class dropdown260" name="box_per_row" required>
                    <option value="" <?php  if ($configs['box_per_row'] == null){echo 'Selected';}?>>-- Choose --</option>  
                    <option value="1" <?php if ($configs['box_per_row'] == 1){echo 'Selected';} ?>>1</option>
                    <option value="2" <?php if ($configs['box_per_row'] == 2){echo 'Selected';} ?>>2</option>
                    <option value="3" <?php if ($configs['box_per_row'] == 3){echo 'Selected';}?>>3</option>
                    <option value="4" <?php if ($configs['box_per_row'] == 4){echo 'Selected';} ?>>4</option>
                    <option value="6" <?php if ($configs['box_per_row'] == 6){echo 'Selected';} ?>>6</option>
                    </select>
            </div>
            <div class="col-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Box Height') ?></label>
                <input name="box_height" type="text" class="form-control" placeholder="Enter Box Height" value="<?=$configs['box_height']?>" required>
            </div>
        </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('boxes', 'Submit') ?></button>

        <?php echo $this->Html->Link('Back', ['action' => 'Boxes'], ['class' => 'btn btn-sucess']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>