<?php

$this->Form->unlockField('term_course_cycle_part_type_name');
$this->Form->unlockField('term_course_cycle_part_type_id');
$this->Form->unlockField('partable');
$this->Form->unlockField('short_form');
?>

<div>

    <?php echo $this->Form->create(); ?>
    <input name="term_course_cycle_part_type_id" type="hidden" value="<?php echo $marks_types[0]['term_course_cycle_part_type_id']; ?>">
    <section>
        <h4><?= __d('setup', 'Edit Part Distribution Type') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('setup', 'Part Distribution Type Name') ?></label>
                <input name="term_course_cycle_part_type_name" type="text" class="form-control" id="inputBR" value="<?php echo $marks_types[0]['term_course_cycle_part_type_name']; ?>" required>
            </div>
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('setup', 'Part Distribution Short Form') ?></label>
                <input name="short_form" type="text" class="form-control" id="inputBR" value="<?php echo $marks_types[0]['short_form']; ?>" required>
            </div>
            <div class="col-md-12  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Part-able') ?></label>
                <select id="inputState" class="form-select option-class dropdown260" name="partable" required>
                    <option value="No" <?php if ($marks_types[0]['partable'] == "No") {
                                            echo 'Selected';
                                        } ?>>No</option>
                    <option value="Yes" <?php if ($marks_types[0]['partable'] == "Yes") {
                                            echo 'Selected';
                                        } ?>>Yes</option>

                </select>
            </div>
        </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>

        <?php echo $this->Html->Link('Back', ['action' => 'marksDistribution'], ['class' => 'btn btn-sucess']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>