<?php $this->Form->unlockField('bank_code'); ?>
<?php $this->Form->unlockField('bank_name'); ?>
<?php $this->Form->unlockField('bank_branch'); ?>
<?php $this->Form->unlockField('bank_balance'); ?>
<?php $this->Form->unlockField('bank_acc_no'); ?>
<?php $this->Form->unlockField('bank_address'); ?>



<div>
	<?= $this->Form->create(); ?>
	<section>
		<h4><?= __d('accounts', 'Bank Information') ?> </h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('accounts', 'Bank Name') ?> </label>
				<input name="bank_name" type="text" class="form-control" placeholder="Enter bank name..." required>
			</div>
			<div class="col-md-6 col-12 mt-2">

				<label for="inputBR" class="form-label"><?= __d('accounts', 'Bank Account Number') ?> </label>
				<input name="bank_acc_no" type="text" class="form-control" placeholder="Enter bank account number..." required>
			</div>
			<div class="col-md-4 col-12 mt-2">

				<label for="inputBR" class="form-label"><?= __d('accounts', 'Bank Code') ?></label>
				<input name="bank_code" type="text" class="form-control" placeholder=" Enter bank code..." required>
			</div>
			<div class="col-md-4 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('accounts', 'Branch Name') ?> </label>
				<input name="bank_branch" type="text" class="form-control" placeholder="Enter branch name...">
			</div>
			<div class="col-md-4 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('accounts', 'Account Balance') ?> </label>
				<input name="bank_balance" type="number" step="any" min="0" class="form-control" placeholder="Enter Initial Balance">
			</div>
			<div class="col-md-12 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('accounts', 'Bank Address') ?> </label>
				<textarea name="bank_address" class="form-control" placeholder="Enter bank address..."></textarea>
			</div>
	</section>

	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('accounts', 'Submit') ?> </button>
		<?= $this->Html->Link('Back', ['action' => 'Banks'], ['class' => 'btn btn-sucess']); ?>
		<?= $this->Form->end(); ?>
	</div>
</div>