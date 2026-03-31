<?php $this->Form->unlockField('department_name'); ?>
<?php $this->Form->unlockField('department_id'); ?>
<?php $this->Form->unlockField('faculty_id'); ?>

<div>
    <?php echo $this->Form->create(); ?>
    <section>
        <h4><?= __d('setup', 'Department Information') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('setup', 'Add A Department') ?></label>
                <input name="department_name" type="text" class="form-control" id="inputBR" placeholder="Department Name" value="<?php echo $departments[0]['department_name']; ?>">
            </div>
            <div class="col-md-6  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Faculties') ?></label>
                <select id="inputState" class="form-select dropdown260" name="faculty_id">
                    <option value=""><?= __d('setup', 'Choose...') ?></option>
                    <?php foreach ($faculties as $faculty) { ?>
                        <option value="<?php echo $faculty['faculty_id']; ?>" <?php if ($faculty['faculty_id'] == $departments[0]['faculty_id']) {
                                                                                    echo 'Selected';
                                                                                } ?>>
                            <?php echo $faculty['faculty_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input name="department_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $departments[0]['department_id']; ?>">

    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>

        <?php echo $this->Html->Link('Back', ['action' => 'Department'], ['class' => 'btn btn-sucess']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
