<?php

$this->Form->unlockField('term_name'); ?>
<?php $this->Form->unlockField('term_id'); ?>


<div>
	<?php echo $this->Form->create();
	?>
    <section>
        <h4><?= __d('setup', 'Term Information') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class="col-12 mt-2">
                <label for="inputBR" class="form-label"><?= __d('setup', 'Edit Term') ?></label>
                <input name="term_name" type="text" class="form-control" id="" value=" <?php echo $terms[0]['term_name']; ?>">
                <input name="term_id" type="hidden" class="form-control"  value=<?php echo $terms[0]['term_id']; ?>>
            </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>

		<?php echo $this->Html->Link('Back', ['action' => 'addTerm'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
    </div>
</div>