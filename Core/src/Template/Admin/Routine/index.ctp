<?php

$this->Form->unlockField('shift_id');
$this->Form->unlockField('session_id');
$this->Form->unlockField('date');
?>
<!doctype html>
<html lang="en">


    <body>
          <?php if(!isset($timesheets)) { ?>
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('attendance', 'Timesheet') ?>
                </h3>
            </div>
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <fieldset>
                        <div class=" p-3">
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="session_id" id="session_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($sessions as $session) { ?>
                                                <option value="<?php echo $session['session_id']; ?>"><?php echo $session['session_name']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Shift') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="shift_id" id="shift_id" required>
                                                <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($shifts as $shift) { ?>
                                                <option value="<?php echo $shift['shift_id']; ?>"><?php echo $shift['shift_name']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Date') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <input type="date" name="date" class="form-control" value="<?= date("Y-m-d", time()) ?>" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </section>
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search Timesheet') ?></button>
            </div>
        <?php echo $this->Form->end(); ?>
        </div>
          <?php } else { ?>
        <div class="container">
            <?php
$this->Form->unlockField('shift_id');
$this->Form->unlockField('session_id');
$this->Form->unlockField('date');
?>
            <?php echo $this->Form->create('', ['type' => 'file']); ?>
            <input type="hidden" name="date"  value="<?= $data['date'] ?>" />
            <input type="hidden" name="shift_id"  value="<?= $data['shift_id'] ?>" />
             <input type="hidden" name="session_id"  value="<?= $data['session_id'] ?>" />
            <button type="submit" class="btn btn-info" style="position: fixed;top: 80px;right: 10px;"><?= __d('setup', 'Refrase') ?></button> 
             <?php echo $this->Form->end(); ?>
            <div class="header">
                <h4 class=" text-center" style="letter-spacing: 1px; word-spacing: 3px; text-transform:capitalize;">
                <?= __d('attendance', 'Timesheet of Session:'.$sessions['0']['session_name']. ' Shift:'.$shifts['0']['shift_name']. ' Day:' .$day) ?>
                </h4>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: center;">Name</th>
                        <th scope="col" style="text-align: center;">Section</th>
                          <?php foreach ($timesheets as $timesheet) { ?>
                        <th scope="col" style="text-align: center;"><?= $timesheet['name'] ?> <br> <?= $timesheet['in_time'] ?> - <?= $timesheet['out_time'] ?> </th>
                          <?php } ?>
                    </tr>
                </thead>
                <tbody>
                          <?php foreach ($levels as $level) { ?>
                           <?php if(isset($level['section'])) {
                           $sections=array_values($level['section']); ?>
                    <tr>
                        <td rowspan=" <?php echo count($level['section']); ?>"> <?= $level['level_name'] ?></td>
                        <td style="text-align: center;"> <?= $sections[0]['section_name'] ?></td>
                        <?php foreach ($sections[0]['timesheet'] as $timesheet) { ?>
                          <?php if(isset($timesheet['routine'])) { ?>
                    <td>
                             <?php foreach ($timesheet['routine'] as $key => $name) { ?>
                        <div style="text-align: center;"> <?= $name ?></div> 
                             <?php } ?>
                    </td>
                        <?php }else{ ?>
                    <td></td>
                     <?php } ?>
                     <?php } ?>
                        <?php unset($sections[0]); ?>
                    </tr>
                     <?php foreach ($sections as $section) { ?>
                    <tr>
                        <td><div style="text-align: center;"> <?= $section['section_name'] ?></div> </td>
                        <?php foreach ($section['timesheet'] as $timesheet) { ?>
                          <?php if(isset($timesheet['routine'])) { ?>
                    <td>
                             <?php foreach ($timesheet['routine'] as $key => $name) { ?>
                        <div style="text-align: center;"> <?= $name ?></div> 
                             <?php } ?>
                    </td>
                        <?php }else{ ?>
                    <td></td>
                     <?php } ?>
                     <?php } ?>
                    </tr>
                     <?php } ?>

                            <?php } ?>
                          <?php } ?>

                </tbody>
            </table>

        </div>
          <?php } ?>
    </body>

</html>
<script>
  setTimeout(function(){
    window.location.reload(1);
  }, 30000);
</script>