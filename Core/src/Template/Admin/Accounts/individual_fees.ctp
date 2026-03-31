<?php

echo $this->Form->unlockField('level_id');
echo $this->Form->unlockField('session_id');
echo $this->Form->unlockField('sid');

$level_id = isset($request_data['level_id']) ? $request_data['level_id'] : '';
$session_id = isset($request_data['session_id']) ? $request_data['session_id'] : '';
$sid = isset($request_data['sid']) ? $request_data['sid'] : '';
?>

<div class="container">
    <div class="header">
        <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
            <?= __d('accounts', 'Individual Additional Fees') ?>
        </h3>
    </div>
    <?= $this->Form->create('', ['type' => 'file']); ?>
    <div class="form ">
        <section class="bg-light m-auto" action="#">
            <fieldset>
                <div class="row p-3">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-3 mt-2">
                                <p class="label-font13">
                                        <?= __d('accounts', 'Session') ?>
                                </p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="session_id" id="sessionSelect" required>
                                    <option value="">
                                            <?= __d('accounts', '-- Choose --') ?>
                                    </option>
                                        <?php foreach ($sessions as $session) { ?>
                                    <option value="<?= $session['session_id']; ?>" <?php if ($session_id == $session['session_id']) echo 'selected'; ?>>
                                                <?= $session['session_name']; ?>
                                    </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-3 mt-2">
                                <p class="label-font13">
                                        <?= __d('accounts', 'Class') ?>
                                </p>
                            </div>

                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="level_id" id="levelSelect" required>
                                    <option value="">
                                            <?= __d('accounts', '-- Choose --') ?>
                                    </option>
                                        <?php foreach ($levels as $level) { ?>
                                    <option value="<?= $level['level_id']; ?>" <?php if ($level_id == $level['level_id']) echo 'selected'; ?>>
                                                <?= $level['level_name']; ?>
                                    </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4 mt-4">
                        <div class="row">
                            <div class="col-lg-2 mt-2">
                                <p class="label-font13"><?= __d('accounts', 'SID') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <input name="sid" type="text" class="form-control" id="inputBR"  value="<?= $sid ?>" required>  
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </section>
    </div>
    <div class="mt-3 pull-right">
        <button type="submit" class="btn btn-success">
            <?= __d('setup', 'Search') ?>
        </button>
    </div>
    <?= $this->Form->end(); ?>
</div>


<?php
if (isset($students)) {
    $this->Form->unlockField('student_cycle_id');
    $this->Form->unlockField('session_id');
    $this->Form->unlockField('level_id');
    $this->Form->unlockField('fees_value');;
?>
<div class="mt-5">
    <div class="header">
        <p><?= $head; ?></p>
    </div>
    <?= $this->Form->create('', ['type' => 'file']); ?>
    <input type="hidden" name="student_cycle_id" value='<?= $students['student_cycle_id'] ?>'>
    <input type="hidden" name="session_id" value="<?= $students['session_id'] ?>">
    <input type="hidden" name="level_id" value="<?= $students['level_id'] ?>">

    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('accounts', 'Months Name') ?></th>
                 <?php foreach ($additionals as $additional) { ?>
                    <th><?= $additional['fees_title'] ?></th>
                <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filter_months as $month) { ?>
                <tr>
                    <td><?= $month['name']; ?></td>
                 <?php foreach ($month['additional'] as $additional) { ?>
                    <td><input type="number" step="any" name="fees_value[<?= $month['id']?>][<?= $additional['id']?>]" placeholder="<?= $additional['value'] ?>" value="<?php if (isset($additional['set_value'])) {echo $additional['set_value'];}?>"></td>
                <?php } ?>

                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
    <div class="mt-3 text-right">
        <button type="submit" class="btn btn-info">
            <?= __d('accounts', 'Submit') ?>
        </button>
    </div>

<?php echo $this->Form->end();
}
?>
</div>
