<?php $this->Form->unlockField('parent'); ?>
<?php $this->Form->unlockField('purpose_name'); ?>

<div>
	<?= $this->Form->create(); ?>
	<section>
		<h4><?= __d('accounts', 'Add a Purposes') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('accounts', 'Purpose title') ?></label>
				<input name="purpose_name" type="text" class="form-control" placeholder="Enter purpose name..." required>
			</div>
			<div class="col-md-6 col-12 mt-2">
				<label for="inputState" class="form-label"><?= __d('accounts', 'Parent') ?></label>
				<select id="inputState" class="form-select option-class dropdown260" name="parent">
					<option value=""><?= __d('accounts', 'Choose...') ?></option>
					<?php foreach ($options as $value => $text) { ?>
						<option value="<?= $value ?>"><?= h($text) ?></option>
					<?php } ?>
				</select>
			</div>
	</section>

	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('accounts', 'Submit') ?></button>
		<?= $this->Html->Link('Back', ['action' => 'purposes'], ['class' => 'btn']); ?>
		<?= $this->Form->end(); ?>
	</div>
</div>