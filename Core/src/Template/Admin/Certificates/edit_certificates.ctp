<?php
foreach ($tags as $key => $tag) {
      $unlock = $tag['tag'];
      $this->Form->unlockField($unlock);
      }
$this->Form->unlockField('generate');
$this->Form->unlockField('student_id');
$this->Form->unlockField('config_id');
echo $this->Form->create();

      echo "<pre>";
      print_r($values);
      die;

?>


<input name="student_id" type="hidden" value="<?php echo $request_data['student_id'] ?>">
<input name="config_id" type="hidden" value="<?php echo $request_data['config_id'] ?>">
<input name="generate" type="hidden" value="1">
<div class="row">
      <?php
      foreach ($values as $key => $value) { ?>
            <div class="col-lg-2 mt-2">
                  <p class="label-font"><?php echo $value['tag_description'] ?></p>
            </div>
            <div class="col-lg-4 mt-2">
                  <input name="<?php echo $value['tag'] ?>" type="text" class="form-control" value="<?php if (isset($value['tag_value'])) {echo $value['tag_value'];} ?>" required></div>
      <?php } ?>
</div>
<div class="text-right mt-2">
      <button type="submit" class="btn btn-info"><?= __d('Certificates', 'Generate') ?></button>
      <?php echo $this->Form->end(); ?>
</div>
</div>