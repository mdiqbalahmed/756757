<?php

$this->Form->unlockField('start_date');
$this->Form->unlockField('end_date');

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
            <div class="header">

            </div>
        <?php echo $this->Form->create(); ?>
            <div class="form">
                <section>
                    <h3 style="text-align: center;background-color: rgba(0, 0, 0, 0.2);padding: 10px;overflow-x:auto;font-colour: red;">Balance Sheet Report</h3>
                    <div class="row p-2">
                        <div class="col-md-6 mt-2">
                            <label for="inputState" class="form-label"><?= __d('setup', 'Start Date') ?></label>
                            <input name="start_date" type="date" class="form-control" value="" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="inputState" class="form-label"><?= __d('setup', 'End Date') ?></label>
                            <input name="end_date" type="date" class="form-control"value="" required>
                        </div>
                    </div>
                </section>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
        <?php echo $this->Form->end(); ?>
        </div>

    </body>

</html>
   

