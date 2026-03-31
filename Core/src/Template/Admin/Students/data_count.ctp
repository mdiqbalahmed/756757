
    <?php $this->Form->unlockField('type_id'); ?>
    <?php $this->Form->unlockField('heading'); ?>



<div>
            <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('students',  "Block's Information") ?> </h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6 col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('accounts', 'Name') ?> </label>
                <select class="form-control" name="type_id" id="session_id" required>
                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                <?php foreach ($types as $type) { ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['type_name']; ?></option>
                                                <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-2">

                <label for="inputBR" class="form-label"><?= __d('accounts', 'Heading') ?> </label>
                <input name="heading" type="text" class="form-control" required>
            </div>
        </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('accounts', 'Submit') ?> </button>
                    <?= $this->Form->end(); ?>
    </div>
</div>