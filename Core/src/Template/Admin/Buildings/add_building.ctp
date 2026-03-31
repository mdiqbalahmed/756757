<?php $this->Form->unlockField('name'); ?>
<?php $this->Form->unlockField('description'); ?>
<?php $this->Form->unlockField('hostel_id'); ?>

<div>
    <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('buildings', 'Add Building') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6 col-12 mt-2">
                <label for="hostel_id" class="form-label"><?= __d('buildings', 'Hostel') ?></label>
                <select class="form-control" name="hostel_id" required>
                    <option value=""><?= __d('buildings', '-- Choose --') ?></option>
                    <?php foreach ($hostels as $hostel) { ?>
                        <option value="<?php echo $hostel['id']; ?>"><?php echo $hostel['hostel_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-2">
                <label for="building_name" class="form-label"><?= __d('buildings', 'Building Name') ?></label>
                <input id="building_name" name="name" type="text" class="form-control" placeholder="Building name..." required>
            </div>
            <div class="col-md-6 col-12 mt-2">
                <label for="description" class="form-label"><?= __d('buildings', 'Description') ?></label>
                <input id="description" name="description" type="text" class="form-control" placeholder="Description...">
            </div>
        </div>
    </section>


    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('buildings', 'Submit') ?> </button>
        <?= $this->Form->end(); ?>
    </div>
</div>