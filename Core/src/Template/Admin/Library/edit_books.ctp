<?php $this->Form->unlockField('book_id'); ?>
<?php $this->Form->unlockField('book_name'); ?>
<?php $this->Form->unlockField('genre'); ?>
<?php $this->Form->unlockField('author'); ?>
<?php $this->Form->unlockField('edition'); ?>
<?php $this->Form->unlockField('copy_number'); ?>
<?php $this->Form->unlockField('publication_year'); ?>
<?php $this->Form->unlockField('book_price'); ?>
<?php $this->Form->unlockField('book_image'); ?>


<div>

	<?php echo $this->Form->create('', ['type' => 'file']); ?>
	<section>
		<h4><?= __d('Library', 'Add a Book') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<input name="book_id" type="hidden" class="form-control" value="<?php echo $books['book_id']; ?>">
			<div class="col-12 mt-3">
				<label class="form-label"><?= __d('Library', 'Book Name') ?></label>
				<input name="book_name" type="text" class="form-control" placeholder="Book Name" value="<?php echo $books['book_name']; ?>" required>
			</div>
			<div class="col-6 mt-3">
				<label class="form-label"><?= __d('Library', 'Genre') ?></label>
				<input name="genre" type="text" class="form-control" placeholder="Book Genre" value="<?php echo $books['genre']; ?>" required>
			</div>
			<div class="col-6 mt-3">
				<label class="form-label"><?= __d('Library', 'Author') ?></label>
				<input name="author" type="text" class="form-control" placeholder="Book Author" value="<?php echo $books['author']; ?>" required>
			</div>
			<div class="col-3 mt-3">
				<label class="form-label"><?= __d('Library', 'Edition') ?></label>
				<input name="edition" type="text" class="form-control" placeholder="Edition" value="<?php echo $books['edition']; ?>" required>
			</div>
			<div class="col-3 mt-3">
				<label class="form-label"><?= __d('Library', 'Publication Year') ?></label>
				<input name="publication_year" type="text" class="form-control" placeholder="Publication Year" value="<?php echo $books['publication_year']; ?>" required>
			</div>
			<div class="col-3 mt-3">
				<label class="form-label"><?= __d('Library', 'Book Price') ?></label>
				<input name="book_price" type="text" class="form-control" placeholder="Book Price" value="<?php echo $books['book_price']; ?>" required>
			</div>
			<div class="col-3 mt-3">
				<label class="form-label"><?= __d('Library', 'Copy') ?></label>
				<input name="copy_number" type="text" class="form-control" placeholder="Number of Copies" value="<?php echo $books['copy_number']; ?>" required>
			</div>
			<?php if ($books['book_image'] != null) { ?>
				<div class="col-md-12 mt-2">
					<label for="inputSId" class="Xlabel-height form-label"><?= __d('Library', 'Book Image') ?> </label>
					<div class="card">
						<div class="card-body">
							<div class="library_book_images"><?php echo $this->Html->image('/webroot/uploads/library/book_images/' . $books['book_image']); ?></div>
						</div>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-md-12 mt-2" hidden>
					<div class="card">
						<div class="card-body">
							<div class="library_book_images"><?php echo $this->Html->image('/webroot/uploads/library/book_images/' . $books['book_image']); ?></div>
						</div>
					</div>
				</div>
			<?php } ?>

	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('Library', 'Submit') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'books'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>