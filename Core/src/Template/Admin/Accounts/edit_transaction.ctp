<?php $this->Form->unlockField('purpose_id'); ?>
<?php $this->Form->unlockField('reason'); ?>
<?php $this->Form->unlockField('amount'); ?>
<?php $this->Form->unlockField('transaction_date'); ?>
<?php $this->Form->unlockField('transaction_type'); ?>
<?php $this->Form->unlockField('bank_id'); ?>
<?php $this->Form->unlockField('note'); ?>
<?php $this->Form->unlockField('user_id'); ?>

<div>
	<?= $this->Form->create(); ?>
	<section>
		<h4>
			<?= __d('accounts', 'All Transactions') ?>
		</h4>


		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-md-4 col-12 mt-2">
				<label class="form-label form-label-res">
					<?= __d('accounts', 'Voucher No.') ?>
				</label>
				<input type="text" class="form-control" value="<?= $get_transaction[0]['voucher_no']; ?>" readonly>
			</div>
			<div class='col-md-4 col-12 mt-2'>
				<label class="form-label">
					<?= __d('accounts', 'Transaction Date') ?>
				</label>
				<?php
				$transactionDate = $get_transaction[0]['transaction_date']->format('Y-m-d\TH:i');
				?>
				<input type="datetime-local" class="form-control" name="transaction_date"
					value="<?= $transactionDate; ?>" />
			</div>

			<div class="col-md-4 col-12 mt-2">
				<label class="form-label">
					<?= __d('accounts', 'Transaction Type') ?>
				</label>
				<select class="form-select option-class dropdown260" name="transaction_type">

					<option value="" <?php if ($get_transaction[0]['transaction_type'] === null) {
						echo 'Selected';
					} ?>>-- Choose --</option>
					<option value="Debit" <?php if ($get_transaction[0]['transaction_type'] == 'Debit') {
						echo 'Selected';
					} ?>>Debit</option>
					<option value="Credit" <?php if ($get_transaction[0]['transaction_type'] == 'Credit') {
						echo 'Selected';
					} ?>>Credit</option>
				</select>
			</div>
			<div class="col-md-4 col-12 mt-2">
				<label for="inputState" class="form-label">
					<?= __d('accounts', 'Purpose') ?>
				</label>
				<select id="inputState" class="form-select option-class" name="purpose_id" required>
					<?php foreach ($options as $value => $text) { ?>
						<option value="<?= $value ?>" <?= ($value == $currentPurpose->parent) ? 'selected' : '' ?>>
							<?= h($text) ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-4 col-12 mt-2">
				<label for="inputState" class="form-label">
					<?= __d('accounts', 'Bank Name') ?>
				</label>
				<select id="inputState" class="form-select option-class" name="bank_id" required>
					<option value="">
						<?= __d('accounts', 'Choose...') ?>
					</option>
					<?php foreach ($banks as $bank) { ?>
						<option value="<?= $bank['bank_id']; ?>" <?php if ($bank['bank_id'] == $get_transaction[0]['bank_id']) {
							  echo 'Selected';
						  } ?>><?= $bank['bank_name']; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-4 col-12 mt-2">
				<label class="form-label">
					<?= __d('accounts', 'Amount') ?>
				</label>
				<input name="amount" type="tel" class="form-control" placeholder="Enter Amount..."
					value="<?= $get_transaction[0]['amount']; ?>" required>
			</div>

			<div class="col-12 mt-2">
				<label class="form-label">
					<?= __d('accounts', 'Note') ?>
				</label>
				<textarea name="note" class="form-control " placeholder="Write a few more if needed...." id="" rows="4"
					cols="120"><?= $get_transaction[0]['note']; ?></textarea>
			</div>
		</div>
	</section>

	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info">
			<?= __d('accounts', 'Update') ?>
		</button>
		<?= $this->Html->Link('Back', ['action' => 'transactions'], ['class' => 'btn btn-sucess']); ?>
		<?= $this->Form->end(); ?>
	</div>
</div>

<script type="text/javascript">
	config = {
		today,
		enableTime: true,
		dateFormat: "Y-m-d H:i",
	}
	flatpickr("input[type=datetime-local]", config);
</script>