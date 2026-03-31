<?php

$this->Form->unlockField('term_course_cycle_part_type_name');
$this->Form->unlockField('partable');
$this->Form->unlockField('short_form');
?>

<div>

    <?php echo $this->Form->create(); ?>
    <section>
        <h4><?= __d('setup', 'Add a Part Distribution Type') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('setup', 'Part Distribution Type Name') ?></label>
                <input name="term_course_cycle_part_type_name" type="text" class="form-control" id="inputBR" required>
            </div>
            <div class="col-6 mt-2">
                <label for="inputBR" class="form-label"><?= __d('setup', 'Part Distribution Short Form') ?></label>
                <input name="short_form" type="text" class="form-control" id="inputBR" required>
            </div>
            <div class="col-md-12  mt-2">
                <label for="inputState" class="form-label"><?= __d('setup', 'Part-able') ?></label>
                <select id="inputState" class="form-select option-class dropdown260" name="partable" required>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>

                </select>
            </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>

        <?php echo $this->Html->Link('Back', ['action' => 'marksDistribution'], ['class' => 'btn btn-sucess']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>