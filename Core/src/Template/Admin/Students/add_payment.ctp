<?php

$this->Form->unlockField('trxId');
$this->Form->unlockField('ref_proxy');
$this->Form->unlockField('amount');
$this->Form->unlockField('sender');
$this->Form->unlockField('receiver');
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
        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Add Payment') ?>
                </h3>
            </div>
        <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <fieldset>
                        <div class=" form_area p-2">
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Ref Proxy') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="ref_proxy" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Trx Id') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="trxId" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Sender') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="sender" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Receiver') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="receiver" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Amount') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="amount" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </fieldset>
                </section>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
            </div>
          <?php  echo $this->Form->end(); ?>
        </div>
         






    </body>

</html>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
    });

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id, "shift_id": shift_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["section_name"];
                    var id = data[i]["section_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#section_id').html(text1);

            }
        });
    }
</script>