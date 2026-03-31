<?php

$this->Form->unlockField('gradings_system_name');
?>


<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h4><?= __d('gradings', 'Add New Grading System') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">


            <div class="col-md-12  mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputSId" class="form-label"><?= __d('gradings', 'Grading System Name:') ?></label>
                    </div>
                    <div class="col-md-6">
                        <input name="gradings_system_name" type="text" class="form-control" id="inputSId" placeholder="Grading System Name" required>
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button type="submit" class="btn btn-info"><?= __d('gradings', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
            </div>
    </section>
</div>
