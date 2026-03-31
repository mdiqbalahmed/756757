<div class="col-md-4  mt-2">
      <label for="inputState" class="form-label"><?= __d('Certificates', 'Session') ?></label>
      <select id="inputState" class="form-select dropdown260" name="session_id">
            <option value=""><?= __d('Certificates', 'Choose...') ?></option>
            <?php foreach ($sessions as $session) { ?>
                  <option value="<?php echo $session['session_id']; ?>">
                        <?php echo $session['session_name']; ?>
                  </option>
            <?php } ?>
      </select>
</div>

<div class="col-md-4  mt-2">
      <label for="inputState" class="form-label"><?= __d('Certificates', 'Class') ?></label>
      <select class="form-select dropdown260" name="level_id" id="level_id">
            <option value=""><?= __d('Certificates', 'Choose...') ?></option>
            <?php foreach ($levels as $level) { ?>
                  <option value="<?php echo $level['level_id']; ?>">
                        <?php echo $level['level_name']; ?>
                  </option>
            <?php } ?>
      </select>
</div>