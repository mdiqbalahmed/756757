<?php 
$this->Form->unlockField('node_page_id');
$this->Form->unlockField('config_title');
$this->Form->unlockField('box_per_row');
$this->Form->unlockField('box_height');
$this->Form->unlockField('box_position'); 
?>


<div>
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <section>
        <h4><?= __d('boxes', 'Add Configuration for Boxes') ?></h4>
        <div class="row mx-3 mt-2 p-3 pb-4 form-box">
            <div class="col-8 mt-2">
                <label class="form-label"><?= __d('boxes', 'Configuration title') ?></label>
                <input name="config_title" type="text" class="form-control" placeholder="Box title" required>
            </div>
            <div class="col-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Location') ?></label>
                <select class="form-select option-class dropdown260" name="node_page_id" required>
                    <option>-- Choose --</option>
                    <option value="0">Home</option>
                    <?php foreach ($nodes as $node) { ?>
                        <option value="<?php echo $node['id']; ?>"><?php echo $node['title']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Box Position') ?></label>
                <select class="form-select option-class dropdown260" name="box_position" required>
                    <option>-- Choose --</option>
                    <option value="1">Top</option>
                    <option value="0">Bottom</option>
                </select>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Box Per Row') ?></label>
                <select class="form-select option-class dropdown260" name="box_per_row" required>
                    <option>-- Choose --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div class="col-4 mt-2">
                <label class="form-label"><?= __d('boxes', 'Box Height') ?></label>
                <input name="box_height" type="text" class="form-control" placeholder="Enter Box Height" required>
            </div>
        </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('boxes', 'Submit') ?></button>

        <?php echo $this->Html->Link('Back', ['action' => 'pageConfig'], ['class' => 'btn btn-sucess']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>