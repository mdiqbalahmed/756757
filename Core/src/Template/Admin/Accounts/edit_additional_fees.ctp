<?php

$this->Form->unlockField('fees_title'); ?>
<?php $this->Form->unlockField('purpose_id'); ?>
<?php $this->Form->unlockField('value'); ?>



<div>
	<?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('accounts', 'Create Additional Fees') ?> </h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-4 mt-2">
                <label class="form-label"><?= __d('accounts', 'Fees Title') ?> </label>
                <input name="fees_title" type="text" class="form-control" placeholder="Enter Additional Fees" value="<?= $additionals['fees_title'] ?>" required>
            </div>
            <div class="col-md-4 mt-2">
                <label class="form-label"><?= __d('accounts', 'Value') ?> </label>
                <input name="value" type="number" step="any" min="0" class="form-control" placeholder="Initial Value" value="<?= $additionals['value'] ?>">
            </div>
            <div class="col-md-4 mt-2">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Purpose') ?></label>
                <select id="inputState" class="form-select option-class" name="purpose_id" required>
                <?php foreach ($options as $value => $option) { ?>
                    <option value="<?= $option['purpose_id'] ?>" <?= ($option['purpose_id'] == $additionals['purpose_id']) ? 'selected' : '' ?> ><?= h($option['purpose_name']) ?></option>
		<?php } ?>
                </select>
            </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('accounts', 'Submit') ?> </button>
		<?= $this->Html->Link('Back', ['action' => 'additionalFees'], ['class' => 'btn btn-sucess']); ?>
		<?= $this->Form->end(); ?>
    </div>
</div>