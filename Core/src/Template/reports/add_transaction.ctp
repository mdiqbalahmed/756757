<?php $this->Form->unlockField('purpose_id'); ?>
<?php $this->Form->unlockField('reason'); ?>
<?php $this->Form->unlockField('amount'); ?>
<?php $this->Form->unlockField('transaction_date'); ?>
<?php $this->Form->unlockField('transaction_type'); ?>
<?php $this->Form->unlockField('bank_id'); ?>
<?php $this->Form->unlockField('note'); ?>
<?php $this->Form->unlockField('user_id'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div>
	<?= $this->Form->create(); ?>
	<section>
		<h4><?= __d('accounts', 'All Transactions') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class='col-md-4 col-12 mt-2'>
				<label class="form-label"><?= __d('accounts', 'Transaction Date') ?></label>
				<input type="datetime-local" name="transaction_date" class="form-control" value="<?= date("Y-m-d H:i:s", time() + 6 * 3600); ?>" required />
			</div>
			<div class="col-md-4 col-12 mt-2">
				<label class="form-label"><?= __d('accounts', 'Transaction Type') ?></label>
				<select class="form-select option-class dropdown260" name="transaction_type">
					<option>-- Choose --</option>
					<option value="Debit">Debit</option>
					<option value="Credit">Credit</option>
				</select>
			</div>
			<div class="col-md-4 col-12 mt-2">
				<label for="inputState" class="form-label"><?= __d('accounts', 'Purpose') ?></label>
				<select id="inputState" class="form-select option-class" name="purpose_id" required>
					<option value=""><?= __d('accounts', 'Choose...') ?></option>
					<?php foreach ($options as $value => $text) { ?>
						<option value="<?= $value ?>"><?= h($text) ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4 col-12 mt-2">
				<label for="inputState" class="form-label"><?= __d('accounts', 'Bank Name') ?></label>
				<select id="inputState" class="form-select option-class" name="bank_id" required>
					<option value=""><?= __d('accounts', 'Choose...') ?></option>
					<?php foreach ($banks as $bank) { ?>
						<option value="<?= $bank['bank_id']; ?>"><?= $bank['bank_name']; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-4 col-12 mt-2">
				<label class="form-label"><?= __d('accounts', 'Amount') ?></label>
				<input name="amount" type="number" class="form-control" placeholder="Enter Amount..." required>
			</div>

			<div class="col-12 mt-2">
				<label class="form-label"><?= __d('accounts', 'Note') ?></label>
				<textarea name="note" class="form-control " placeholder="Write a few more if needed...." id="" rows="4" cols="120"></textarea>
			</div>
		</div>
	</section>

	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info text-light"><?= __d('accounts', 'Submit') ?></button>
		<?= $this->Html->Link('Back', ['action' => 'purposes'], ['class' => 'btn ']); ?>
		<?= $this->Form->end(); ?>
	</div>
</div>

<script type="text/javascript">
	config = {
		enableTime: true,
		dateFormat: "Y-m-d H:i",
		today
	}

	flatpickr("input[type=datetime-local]", config);
</script>