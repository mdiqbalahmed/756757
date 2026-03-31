<?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('sid');
$session_id = isset($data['session_id']) ? $data['session_id'] : null;
$level_id = isset($data['level_id']) ? $data['level_id'] : null;
$sid = isset($data['sid']) ? $data['sid'] : null;
?>
<!doctype html>

<body>

    <div class="container">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Search Students') ?>
            </h3>
        </div>
        <?php echo  $this->Form->create('', ['type' => 'file']); ?>
        <div class="form">
            <section class="bg-light mt-1 p-2 m-auto" action="#">
                <fieldset>
                    <div class=" form_area p-2">
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
                                            <option value="<?= $session['session_id']; ?>" <?php if ($session['session_id'] == $session_id) {
                                                                                                    echo 'selected';
                                                                                                } ?>>
                                                <?= $session['session_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Class') ?></p>
                                    </div>

                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="level_id" id="level_id" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                                            <option value="<?= $level['level_id']; ?>" <?php if ($level['level_id'] == $level_id) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                <?= $level['level_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'SID') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="sid" type="text" class="form-control" placeholder="SID"
                                            value="<?= $sid ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </section>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
        <?php if (isset($terms)) { ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('students', 'SID') ?></th>
                    <th><?= __d('students', 'Name') ?></th>
                    <th><?= __d('students', 'Class') ?></th>
                    <th><?= __d('students', 'Session') ?></th>
                    <th><?= __d('students', 'term_name') ?></th>
                    <th><?= __d('students', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($terms as $term) {
                    ?>
                <tr>
                    <td><?php echo $term['sid'] ?></td>
                    <td class="wide_cell"><?php echo $term['name'] ?></td>
                    <td><?php echo $term['level_name'] ?></td>
                    <td><?php echo $term['session_name'] ?></td>
                    <td><?php echo $term['term_name'] ?></td>
                    <td>
                        <?php echo $this->Html->link('Details', ['action' => 'studentCycleDetails', $term['student_term_cycle_id']], ['class' => 'btn action-btn btn-warning']) ?>
                    </td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
        <?php } ?>

    </div>
</body>

</html>