<?php

$this->Form->unlockField('purpose_id');
$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');
$this->Form->unlockField('session_id');

$session_id = isset($session_id) ? $session_id : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <?php echo $this->Form->create(); ?>
        <div class="form">
            <section>
                <h4><?= __d('setup', 'Search Credit') ?></h4>
                <div class="row p-2">
                    <div class="col-md-6 ">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
                        <select class="form-control" name="session_id" id="feesSelect" required>
                            <option value="">
                                <?= __d('accounts', '-- Choose --') ?>
                            </option>
                            <?php foreach ($sessions as $session) { ?>
                            <option value="<?= $session['session_id']; ?>"
                                <?php if ($session_id == $session['session_id']) echo 'selected'; ?>>
                                <?= $session['session_name']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Fees Type') ?></label>
                        <select class="form-control" name="purpose_id" id="feesSelect" required>
                            <?php foreach ($purposes as $purpose) { ?>
                            <option value="<?= $purpose['purpose_id']; ?>">
                                <?= $purpose['purpose_name']; ?>
                            </option>
                            <?php } ?>
                            <option value="other">Other Fees</option> <!-- Add this line for "Other" -->
                        </select>
                    </div>



                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Start Date') ?></label>
                        <input name="start_date" type="date" class="form-control">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'End Date') ?></label>
                        <input name="end_date" type="date" class="form-control">
                    </div>
                </div>
            </section>
        </div>
        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-info px-5"><?= __d('setup', 'Search') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>




</body>