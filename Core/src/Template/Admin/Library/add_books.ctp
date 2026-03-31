<?php $this->Form->unlockField('book_name'); ?>
<?php $this->Form->unlockField('copy_number'); ?>
<?php $this->Form->unlockField('genre'); ?>
<?php $this->Form->unlockField('author'); ?>
<?php $this->Form->unlockField('edition'); ?>
<?php $this->Form->unlockField('publication_year'); ?>
<?php $this->Form->unlockField('book_price'); ?>
<?php $this->Form->unlockField('book_image'); ?>

<div>

	<?php echo $this->Form->create('', ['type' => 'file']); ?>
	<section>
		<h4><?= __d('Library', 'Add a Book') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-12 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Book Name') ?></label>
				<input name="book_name" type="text" class="form-control" id="inputBR" placeholder="Book Name" required>
			</div>
			<div class="col-6 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Genre') ?></label>
				<input name="genre" type="text" class="form-control" id="inputBR" placeholder="Book Genre" required>
			</div>
			<div class="col-6 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Author') ?></label>
				<input name="author" type="text" class="form-control" id="inputBR" placeholder="Book Author" required>
			</div>
			<div class="col-3 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Edition') ?></label>
				<input name="edition" type="text" class="form-control" id="inputBR" placeholder="Edition" required>
			</div>
			<div class="col-3 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Publication Year') ?></label>
				<input name="publication_year" type="text" class="form-control" id="inputBR" placeholder="Publication Year" required>
			</div>
			<div class="col-3 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Book Price') ?></label>
				<input name="book_price" type="text" class="form-control" id="inputBR" placeholder="Book Price" required>
			</div>
			<div class="col-3 mt-3">
				<label for="inputBR" class="form-label"><?= __d('Library', 'Copies') ?></label>
				<input name="copy_number" type="text" class="form-control" id="inputBR" placeholder="Number of Copies" required>
			</div>
			<div class="col-md-12 mt-2">
				<label for="inputSId" class="Xlabel-height form-label"><?= __d('Library', 'Book Image') ?></label>
				<div class="card">
					<div class="card-body">
						<?php echo $this->form->file('book_image'); ?>
					</div>
				</div>
			</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('Library', 'Submit') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'books'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>