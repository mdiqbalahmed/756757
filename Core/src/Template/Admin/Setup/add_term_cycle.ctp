<?php

$this->Form->unlockField('term_id'); 
$this->Form->unlockField('level_id'); 
$this->Form->unlockField('session_id');
?>

<div>
	<?php echo $this->Form->create(); ?>
    <section>
        <h4><?= __d('setup', 'Add Term Cycle') ?></h4>
        <div class="col-md-8  mt-2">
            <label for="inputState" class="form-label"><?= __d('setup', 'Term Name') ?></label>
            <select id="inputState" class="form-select dropdown260" name="term_id" required>
                <option value=""><?= __d('setup', 'Choose...') ?></option>
		<?php foreach ($terms as $term) { ?>
                <option value="<?php echo $term['term_id']; ?>"><?php echo $term['term_name']; ?></option>
		<?php } ?>
            </select>
        </div>
        <div class="col-md-8  mt-2">
            <label for="inputState" class="form-label"><?= __d('setup', 'Level Name') ?></label>
            <select id=""  size="5" class="form-select option-class dropdown260 " name="level_id[]" multiple="multiple" >
                <option value=""><?= __d('setup', 'Choose...') ?></option>
		<?php foreach ($levels as $levels) { ?>
                <option value="<?php echo $levels['level_id']; ?>"><?php echo $levels['department_name']."(".$levels['level_name'].")"; ?></option>
		<?php } ?>
            </select>
        </div>
        <div class="col-md-8  mt-2">
            <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
            <select id="inputState" class="form-select dropdown260" name="session_id" required>
                <option value=""><?= __d('setup', 'Choose...') ?></option>
		<?php foreach ($sessions as $session) { ?>
                <option value="<?php echo $session['session_id']; ?>"><?php echo $session['session_name']; ?></option>
		<?php } ?>
            </select>
        </div>
    </section>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
		<?php echo $this->Html->Link('Back', ['action' => 'termCycle'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
    </div>
</div>

<script type='text/javascript'>
$(document).ready(function()
{	 
  $("option:selected").map(function(){ return this.value }).get().join(", ");
});
</script>