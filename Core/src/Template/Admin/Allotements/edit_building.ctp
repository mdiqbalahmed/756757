<?php $this->Form->unlockField('name'); ?>
<?php $this->Form->unlockField('description'); ?>



<div>
	<?= $this->Form->create(); ?>
	<section>

		<h4><?= __d('buildings', 'Bank Information') ?> </h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('buildings', 'Building Name') ?> </label>
				<input name="name" type="text" class="form-control" placeholder="Building name..." value="<?= $get_building[0]['name']; ?>" required>
			</div>
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('buildings', 'Description') ?> </label>
				<input name="description" type="text" class="form-control" placeholder="Description..." value="<?= $get_building[0]['description']; ?>">
			</div>
		</div>
	</section>

	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('buildings', 'Update') ?></button>
		<?= $this->Form->end(); ?>
	</div>
</div>