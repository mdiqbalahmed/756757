<?php
$this->Form->unlockField('name');
?>

<div>
    <?php echo $this->Form->create(); ?>
    <section class="std_info">
        <h4><?= __d('employees', 'Employee Designation Add') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">

            <div class="col-md-12  mt-3">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('employees', 'Designation Name') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input name="name" type="text" class="form-control" id="inputSId" placeholder="Designation Name" required>
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button type="submit" class="btn btn-info"><?= __d('employees', 'Submit') ?></button>
            <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </section>
</div>
