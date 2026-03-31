<?php
echo $this->Form->unlockField('level_id');
echo $this->Form->unlockField('session_id');
echo $this->Form->unlockField('month_id');
echo $this->Form->unlockField('additional_fees_id');

$level_id = isset($level_id) ? $level_id : '';
$additional_fees_id = isset($additional_fees_id) ? $additional_fees_id : '';
$month_id = isset($month_id) ? $month_id : '';
$session_id = isset($session_id) ? $session_id : '';
?>

<div class="container">
    <div class="header">
        <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
            <?= __d('accounts', 'Edit Generated Additional Fees') ?>
        </h3>
    </div>


    <?= $this->Form->create('', ['type' => 'file']); ?>
    <div class="form ">
        <section class="bg-light mt-1 p-5 m-auto" action="#">
            <fieldset>
                <div class=" form_area p-4">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-3">
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
                                <div class="col-lg-3">
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
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font13">
                                        <?= __d('accounts', 'Fees Title') ?>
                                    </p>
                                </div>

                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="additional_fees_id" id="feesSelect" required>
                                        <option value="">
                                            <?= __d('accounts', '-- Choose --') ?>
                                        </option>
                                        <?php foreach ($additionals as $additional_fee) { ?>
                                            <option value="<?= $additional_fee['id']; ?>" <?php if ($additional_fees_id == $additional_fee['id']) echo 'selected'; ?>>
                                                <?= $additional_fee['fees_title']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-3 mt-3">
                                    <p class="label-font13">
                                        <?= __d('accounts', 'Months') ?>
                                    </p>
                                </div>
                                <div class="col-lg-9 mt-3 row2Field">
                                    <select class="form-control" name="month_id" id="feesSelect" required>
                                        <option value="">
                                            <?= __d('accounts', '-- Choose --') ?>
                                        </option>
                                        <?php foreach ($months as $month) { ?>
                                            <option value="<?= $month['id']; ?>" <?php if ($month_id == $month['id']) echo 'selected'; ?>>
                                                <?= $month['month_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </fieldset>
        </section>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            <?= __d('setup', 'Search') ?>
        </button>
    </div>
    <?= $this->Form->end(); ?>
</div>


<?php
if (isset($students)) {
    $this->Form->unlockField('user_id');
    $this->Form->unlockField('session_id');
    $this->Form->unlockField('level_id');
    $this->Form->unlockField('additional_fees_id');
    $this->Form->unlockField('student_cycle_id');
    $this->Form->unlockField('additional_fees_cycle_id');
    $this->Form->unlockField('fees_value');
    $this->Form->unlockField('month_id');
?>

    <?= $this->Form->create('', ['type' => 'file']); ?>
    <input type="hidden" name="month_id" value='<?= $month_id ?>'>
    <input type="hidden" name="session_id" value="<?= $session_id ?>">
    <input type="hidden" name="level_id" value="<?= $level_id ?>">
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <input type="hidden" name="additional_fees_id" value="<?= $additional_fees_id ?>">

    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('accounts', 'SID') ?></th>
                    <th><?= __d('accounts', 'Student Name') ?></th>
                    <th><?= __d('accounts', 'Fees Value') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) { ?>
                    <tr>
                        <td><?= $student['sid']; ?></td>
                        <td><?= $student['student_name']; ?></td>
                        <td><input type="number" step="any" name="fees_value[<?= $student['student_cycle_id'] ?>]" placeholder="<?= $student['base_price'] ?>" value="<?php if (isset($student['fees_value'])) {echo $student['fees_value'];}?>"></td>
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
