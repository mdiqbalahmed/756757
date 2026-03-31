<?php

$this->Form->unlockField('file');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('sid');
$this->Form->unlockField('status');
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

    <body>
        <div class="container  mt-5 mb-5">
            <div class="form-border">
                <section class="bg-light  p-4 m-auto" action="#">
                    <div class="form_area p-3">
                        <div class="header">
                            <h1 class="h1 text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                            <?= __d('students', 'Student Registration Form') ?>
                            </h1>
                        </div>
                    <?php echo $this->Form->create('', ['type' => 'file']); ?>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="center">
                                    <div id="avatar">
                                        <img class="profile-pic" src="" />
                                        <div class="upload-button">
                                            <i class="fa fa-arrow-circle-up" aria-hidden="true"><?= __d('students', 'Uplaoad') ?></i>
                                        </div>
                                        <input name="file" class="file-upload" type="file" accept="image/*" />
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
                                <?php echo $this->Form->end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </body>

</html>