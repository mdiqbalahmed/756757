<?php

$this->Form->unlockField('name');
$this->Form->unlockField('session_from');
$this->Form->unlockField('session_to');
$this->Form->unlockField('term_id');
$this->Form->unlockField('non_islam');
$this->Form->unlockField('chnage_roll');
$this->Form->unlockField('promote_fail');
$this->Form->unlockField('fail_course_count');
$this->Form->unlockField('fourth_subject');
$this->Form->unlockField('type');
?>
<!doctype html>
<html lang="en">


    <body>

        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Add Promotion Template') ?>
                </h3>
            </div>
        <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">

                    <div class=" p-2">
                        <div class="row mb-3">
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Template Name') ?></p>
                                    </div>
                                    <div class="col-lg-9">
                                        <input  type="text" class="form-control"  name="name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Session From') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="session_from" id="session_from" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($sessions as $session) { ?>
                                            <option value="<?= $session['session_id']; ?>"><?= $session['session_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Session To') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="session_to" id="session_to" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($sessions as $session) { ?>
                                            <option value="<?= $session['session_id']; ?>"><?= $session['session_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Term') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="term_id" id="term">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Result Type') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="type">
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <option value="single">Single</option>
                                            <option value="merge">Merge</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Filter Non Islam') ?></p>
                                    </div>

                                    <div class="col-lg-9">
                                        <input style=" margin-left: 5px; width: 20px;  height: 20px;" type="checkbox"  name="non_islam" value="1">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Change Roll') ?></p>
                                    </div>
                                    <div class="col-lg-9">
                                        <input style=" margin-left: 5px; width: 20px;  height: 20px;" type="checkbox"  name="chnage_roll" value="1">
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Promote Fail Students') ?></p>
                                    </div>
                                    <div class="col-lg-9">
                                        <input style=" margin-left: 5px; width: 20px;  height: 20px;" id="promote_fail" type="checkbox"  name="promote_fail" value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Number of Course') ?></p>
                                    </div>
                                    <div class="col-lg-9">
                                        <input  type="number" class="form-control"  name="fail_course_count">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Fourth Subject') ?></p>
                                    </div>
                                    <div class="col-lg-9">
                                        <input style=" margin-left: 5px; width: 20px;  height: 20px;" type="checkbox"  name="fourth_subject" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </section>
            </div>
            <div class="mt-3 text-right">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
            </div>

        </div>
  <?php  echo $this->Form->end(); ?>
    </body>

</html>
<script>
    $("#session_from").change(function () {
        getTermForPromotionAjax();
    });
    function getTermForPromotionAjax() {
        var session_from = $("#session_from").val();
        $.ajax({
            url: 'getTermForPromotionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "session_from": session_from
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["term_name"];
                    var id = data[i]["term_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#term').html(text1);


            }
        });
    }
</script>