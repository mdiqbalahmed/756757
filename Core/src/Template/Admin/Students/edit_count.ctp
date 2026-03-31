<?php $this->Form->unlockField('name'); ?>
<?php $this->Form->unlockField('heading'); ?>
<?php $this->Form->unlockField('id'); ?>
<?php $this->Form->unlockField('type_id'); ?>


<div>
	<?= $this->Form->create(); ?>
    <input type="hidden" name="id" value="<?php echo $get_datas[0]['id']; ?>">
    <input type="hidden" name="type_id" value="<?php echo $get_datas[0]['type_id']; ?>">
    <section>

        <h4><?= __d('students', 'Edit Data') ?> </h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-md-6 col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('students', 'Name') ?> </label>
                <input name="name" type="text" class="form-control" placeholder="Enter bank name..." value="<?= $get_datas[0]['name']; ?>"readonly="true">
            </div>
            <div class="col-md-6 col-12 mt-2">

                <label for="inputBR" class="form-label"><?= __d('students', 'Heading') ?> </label>
                <input name="heading" type="text" class="form-control" placeholder="Enter bank account number..." value="<?= $get_datas[0]['heading']; ?>">
            </div>

    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('students', 'Update') ?></button>
			<?= $this->Form->end(); ?>
    </div>
</div>