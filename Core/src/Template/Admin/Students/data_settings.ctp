<?php

$this->Form->unlockField('return');

?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <title>Student</title>
    </head>


    <div class="header">
        <h1 class="h1 text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
            <?= __d('students', 'Student\'s All Fields') ?>
        </h1>
    </div>

        <?php
                foreach ($data_counts as $key => $value) {
                ?>

    <div class="container  mt-5 mb-5">
        <div class="form-border">
            <section class="bg-light  p-4 m-auto" action="#">
                <div class="form_area p-3">
                    <div class="header">
                        <h3 class=" text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                            <?= __d('students', $value['heading']) ?>
                        </h3>
                    </div>
                    <?php echo $this->Form->create('', ['type' => 'file']); ?>

                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Show or Not</th>
                                <th>Required</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    foreach ($value['field'] as $val) {
//                        pr($value['field']);die;
                        $newName = str_replace("_", " ", strtoupper($val['name'])); // Replace underscore with space and convert to uppercase
                        $newName = ucwords(strtolower($newName)); 
                ?>
                            <tr style="padding: 10px;">
                            <tr style="padding: 10px;">
                                <td><?php echo $newName;  ?></td>
                                <td>
                                    <input name="return[<?php echo $key; ?>][<?php echo $val['id'] ; ?>][exist]" type="checkbox" value="1" class="form-check-input-data-set" <?php echo $val['exist'] = isset($val['exist']) ? 'Checked' : null; ?> <?php echo $readonly = isset($val['readonly']) ? 'disabled' : null; ?> >
                                </td>
                                <td>
                                    <input name="return[<?php echo $key; ?>][<?php echo $val['id'] ; ?>][required]" type="checkbox" value="1" class="form-check-input-data-set" <?php echo $val['required'] = isset($val['required']) ? 'Checked' : null; ?> <?php echo $readonly = isset($val['readonly']) ? 'disabled' : null; ?>>
                                </td>
                            </tr>


                    <?php  }?>
                        </tbody>
                    </table>

                </div>
            </section>

        </div>
    </div>

<?php
                } 
                ?>
    <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
                                <?php echo $this->Form->end(); ?>

</html>