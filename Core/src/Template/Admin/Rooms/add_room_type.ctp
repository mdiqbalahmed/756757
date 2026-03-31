<?php $this->Form->unlockField('type'); ?>

<div>
    <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('rooms', 'Add Room Type') ?> </h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6 col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('rooms', 'Room Type') ?> </label>
                <input name="type" type="text" class="form-control" placeholder="Building name..." required>
            </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('rooms', 'Submit') ?> </button>
        <?= $this->Form->end(); ?>
    </div>
</div>

<script>
    // Get all the required fields
    const requiredFields = document.querySelectorAll('input[required], select[required]');

    requiredFields.forEach(field => {
        const label = field.closest('.row').querySelector('.form-label , .label-font13');
        if (label) {
            const asterisk = document.createElement('span');
            asterisk.className = 'required';
            asterisk.innerHTML = '*';
            asterisk.style.color = 'red';
            asterisk.style.marginRight = '2px';
            label.prepend(asterisk);
        }
    });
</script>