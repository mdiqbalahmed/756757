<?php
$this->Form->unlockField('book_id');
$this->Form->unlockField('book_name');
$this->Form->unlockField('deadline');
$this->Form->unlockField('issue_date');
$this->Form->unlockField('member_id');
$this->Form->unlockField('status');



?>

<div style="background-color: #f2f2f2; padding: 10px; margin-top: 50px;">
	<?php echo $this->Form->create('', ['type' => 'file']); ?>
	<section>
		<h4><?= __d('Library', 'Issue a Book') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-md-12 mt-3">
				<label for="inputSId" class="Xlabel-height form-label"><?= __d('Library', 'Issued to') ?></label>
				<div class="card">
					<div class="card-body">
						<div class="row">

							<div class="col-md-8">
								<label class="form-label"><?= __d('Library', 'Member ID') ?></label>
								<select id="" class="form-select dropdown260" name="member_id">
									<option value=""><?= __d('Library', 'Choose...') ?></option>
									<?php foreach ($members as $member) { ?><option value="<?php echo $member['member_id']; ?>"><?php echo $member['member_id'] . '( ' . $member['name'] . ' )'; ?>
										</option>
									<?php } ?>
								</select>

							</div>

							<div class="col-md-4">

								<img style="width: 100%;" src="https://w7.pngwing.com/pngs/1024/751/png-transparent-blue-and-black-background-with-text-overlay-blue-material-on-the-back-of-business-cards-template-blue-angle.png" alt="">

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 mt-3">
				<label for="inputSId" class="Xlabel-height form-label"><?= __d('Library', 'Book Name') ?></label>

				<select class="form-select dropdown260" name="book_id">
					<option value=""><?= __d('Library', '-- Choose --') ?></option>
					<?php foreach ($books as $book) { ?>
						<option value="<?php echo $book['book_id']; ?>"><?php echo $book['book_name']; ?></option>
					<?php } ?>
				</select>

			</div>
			<div class="col-6 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Issue Date') ?></label>
				<input name="issue_date" type="date" class="form-control" value="<?= date("Y-m-d") ?>">
			</div>
			<div class="col-6 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Return Date') ?></label>
				<input name="deadline" type="date" class="form-control">
			</div>
			<input name="status" type="hidden" class="form-control" value="1">


	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('Library', 'Issue Book') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'allIssues'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>