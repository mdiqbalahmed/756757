<?php

$this->Form->unlockField('csv');
?>


<div>
<?php echo $this->Form->create('', ['type' => 'file']); ?>
    <section class="std_info">
        <h4><?= __d('hrs', 'Upload CSV file') ?></h4>
        <div class="row mx-3 mt-2 p-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <input name="csv" type="file" class="" id="" required>
                    </div>
                    <div class="col-md-2 ">
                        <div class="text-right">
                            <button type="submit" class="btn btn-info"><?= __d('hrs', 'Upload') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
      <?php echo $this->Form->end(); ?>

    <section class="std_info mt-4">
        <h4><?= __d('hrs', 'Process Attendance') ?></h4>
        <span class="text-right mb-3"><?php echo $this->Html->link('Process Attendance', ['action' => 'csvAttendanceProcess'], ['class' => 'btn btn-info']) ?></span>
    </section>
</div>


