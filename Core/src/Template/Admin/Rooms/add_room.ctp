<?php $this->Form->unlockField('building_id'); ?>
<?php $this->Form->unlockField('room_number'); ?>
<?php $this->Form->unlockField('seat'); ?>
<?php $this->Form->unlockField('type_id'); ?>
<?php $this->Form->unlockField('hostel_id'); ?>
<div>
    <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('rooms', 'Add Room') ?> </h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6 col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('rooms', 'Select Building') ?> </label>
                <select name="building_id" required>
                    <option value=""><?= __d('rooms', '-- Choose --') ?></option>
                    <?php foreach ($get_buildings as $building) { ?>
                        <option value="<?php echo $building['id']; ?>"><?php echo $building['name']; ?></option>
                    <?php } ?>
                    <input name="hostel_id" type="hidden" class="form-control" value="<?php echo $building['hostel_id']; ?>">
                </select>
            </div>
            <div class="col-md-6 col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('rooms', 'Room Types') ?> </label>
                <select name="type_id" required>
                    <option value=""><?= __d('rooms', '-- Choose --') ?></option>
                    <?php foreach ($get_room_types as $get_room_type) { ?>
                        <option value="<?php echo $get_room_type['id']; ?>"><?php echo $get_room_type['type']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('rooms', 'Room No') ?> </label>
                <input name="room_number" type="text" class="form-control" placeholder="Room No" required>
            </div>
            <div class="col-md-6 col-12 mt-2">

                <label for="inputBR" class="form-label"><?= __d('rooms', 'Seat No') ?> </label>
                <input name="seat" type="text" class="form-control" placeholder="Seat No">
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