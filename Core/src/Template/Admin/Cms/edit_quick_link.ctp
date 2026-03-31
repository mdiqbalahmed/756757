<?php
$this->Form->unlockField('button_title');
$this->Form->unlockField('button_link');
$this->Form->unlockField('button_color');
$this->Form->unlockField('button_text_color');
$this->Form->unlockField('button_order');
?>


<div>
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <section>
        <h4><?= __d('buttons', 'New Quick Link') ?></h4>
        <div class="row mx-3 mt-2 p-3 pb-4 form-box">
            <div class="col-4 mt-2">
                <label class="form-label"><?= __d('buttons', 'Button title') ?></label>
                <input name="button_title" type="text" class="form-control" placeholder="Enter Button title" value="<?= $button['button_title'] ?>" required>
            </div>
            <div class="col-4 mt-2">
                <label class="form-label"><?= __d('buttons', 'Button Order') ?></label>
                <input name="button_order" type="text" class="form-control" placeholder="Maximum Last Input: XX" value="<?= $button['button_order'] ?>" required>
            </div>
            <div class="col-2 mt-2">
                <label class="form-label"><?= __d('buttons', 'Background Color') ?></label>
                <input name="button_color" type="color" id="backgroundColorInput" class="form-control" style="padding: 0 !important" value="<?= $button['button_color'] ?>" required>
            </div>
            <div class="col-2 mt-2">
                <label class="form-label"><?= __d('buttons', 'Text Color') ?></label>
                <input name="button_text_color" type="color" id="textColorInput" class="form-control" style="padding: 0 !important" value="<?= $button['button_text_color'] ?>" required>
            </div>
            <div class="col-12 mt-2">
                <label class="form-label"><?= __d('buttons', 'Quick Link') ?></label>
                <input name="button_link" type="text" class="form-control" placeholder="Enter Quick Links" value="<?= $button['button_link'] ?>" required>
            </div>
        </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('buttons', 'Submit') ?></button>
        <?php echo $this->Html->Link('Back', ['action' => 'quickLink'], ['class' => 'btn btn-sucess']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>