<?php $this->Form->unlockField('parent'); ?>
<?php $this->Form->unlockField('purpose_name'); ?>
<?php $this->Form->unlockField('report_title'); ?>
<?php $this->Form->unlockField('acc_no'); ?>
<?php $this->Form->unlockField('report_type'); ?>


<div>
    <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('accounts', 'All Purposes') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('accounts', 'Purpose name') ?></label>
                <input name="purpose_name" type="text" class="form-control" id="inputBR"
                    placeholder="Enter purpose name..." value="<?= $currentPurpose->purpose_name; ?>" required>
            </div>
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Parent') ?></label>
                <select id="inputState" class="form-select option-class dropdown260" name="parent">
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($options as $value => $text) { ?>
                    <option value="<?= $value ?>" <?= ($value == $currentPurpose->parent) ? 'selected' : '' ?>>
                        <?= h($text) ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('accounts', 'Report Title') ?></label>
                <input name="report_title" type="text" class="form-control" id="inputBR"
                    value="<?= $currentPurpose->report_title; ?>" >
            </div>
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('accounts', 'Acc No') ?></label>
                <input name="acc_no" type="text" class="form-control" id="inputBR"
                    value="<?= $currentPurpose->acc_no; ?>" >
            </div>
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Report Type') ?></label>
                <select id="inputState" class="form-select option-class dropdown260" name="report_type">
                    <option value="" <?php if (empty($currentPurpose->report_type)) { echo 'selected'; } ?>>
                        <?= __d('students', '-- Choose --') ?>
                    </option>
                    <option value="sonali" <?php if ($currentPurpose->report_type == 'sonali') {
												echo 'selected';
											} ?>><?= __d('students', 'Sonali Bank') ?>
                    </option>
                    <option value="rupali" <?php if ($currentPurpose->report_type == 'rupali') {
												echo 'selected';
											} ?>><?= __d('students', 'Rupali Bank') ?>
                    </option>
                    <option value="govt" <?php if ($currentPurpose->report_type == 'govt') {
												echo 'selected';
											} ?>><?= __d('students', 'Govt') ?>
                    </option>

                </select>
            </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('accounts', 'Update') ?></button>
        <?= $this->Html->Link('Back', ['action' => 'purposes'], ['class' => 'btn btn-sucess']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>