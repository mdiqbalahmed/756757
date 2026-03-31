<?php $this->Form->unlockField('faculty_name'); ?>
<?php $this->Form->unlockField('faculty_id'); ?>


<div>
	<?php echo $this->Form->create();
	// $name = $faculties[0]['faculty_name'];
	?>
	<section>
		<h4><?= __d('setup', 'Faculty Information') ?></h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('setup', 'Add A Faculty') ?></label>
				<input name="faculty_name" type="text" class="form-control" id="" placeholder="" value=" <?php echo $faculties[0]['faculty_name']; ?>">
				<input name="faculty_id" type="hidden" class="form-control" id="" placeholder="" value=<?php echo $faculties[0]['faculty_id']; ?>>
			</div>
	</section>
	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'addFaculty'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>