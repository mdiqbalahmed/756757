<?php $this->Form->unlockField('hostel_name'); ?>

<div>
    <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('buildings', 'Add Hostel') ?> </h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6 col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('buildings', 'Hostel Name') ?> </label>
                <input name="hostel_name" type="text" class="form-control" placeholder="Hostel name..." required>
            </div>

    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('buildings', 'Submit') ?> </button>
        <?= $this->Form->end(); ?>
    </div>
</div>