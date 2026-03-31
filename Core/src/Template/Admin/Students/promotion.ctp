<?php

$this->Form->unlockField('template');
$this->Form->unlockField('level_from');
$this->Form->unlockField('level_to');
$this->Form->unlockField('section_from');
$this->Form->unlockField('section_to');

?>
<!doctype html>
<html lang="en">


    <body>

        <div class="container">
            <div class="header">
                <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('students', 'Students Promotion') ?>
                </h3>
            </div>
        <?php  echo  $this->Form->create('', ['type' => 'file']); ?>
            <div class="form">
                <section class="bg-light mt-1 p-2 m-auto" action="#">
                    <div class=" p-2">
                        <div class="row mb-3">
                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Promotion Template') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="template" id="template" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($prmotion_templates as $prmotion_template) { ?>
                                            <option value="<?= $prmotion_template['promotion_template_id']; ?>"><?= $prmotion_template['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Level From') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="level_from" id="level_from" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                                            <option value="<?= $level['level_id']; ?>"><?= $level['level_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Level To') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select class="form-control" name="level_to" id="level_to" required>
                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                            <?php foreach ($levels as $level) { ?>
                                            <option value="<?= $level['level_id']; ?>"><?= $level['level_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3 section">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section Set 1') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control section_from" name="section_from[1][]" id="section_from_1" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section From--') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <span style='font-size:25px;'>&#8594;</span>
                                            </div>
                                            <div class="col-lg-5 row2Field">
                                                <select class="form-control section_to" name="section_to[1][]" id="section_to_1" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section To --') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3 section">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section Set 2') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control section_from" name="section_from[2][]" id="section_from_2" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section From--') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <span style='font-size:25px;'>&#8594;</span>
                                            </div>
                                            <div class="col-lg-5 row2Field">
                                                <select class="form-control section_to" name="section_to[2][]" id="section_to_2" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section To --') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3 section">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section Set 3') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control section_from" name="section_from[3][]" id="section_from_3" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section From--') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <span style='font-size:25px;'>&#8594;</span>
                                            </div>
                                            <div class="col-lg-5 row2Field">
                                                <select class="form-control section_to" name="section_to[3][]" id="section_to_3" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section To --') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3 section">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section Set 4') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control section_from" name="section_from[4][]" id="section_from_4" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section From--') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <span style='font-size:25px;'>&#8594;</span>
                                            </div>
                                            <div class="col-lg-5 row2Field">
                                                <select class="form-control section_to" name="section_to[4][]" id="section_to_4" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section To --') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3 section">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section Set 5') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control section_from" name="section_from[5][]" id="section_from_5" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section From--') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <span style='font-size:25px;'>&#8594;</span>
                                            </div>
                                            <div class="col-lg-5 row2Field">
                                                <select class="form-control section_to" name="section_to[5][]" id="section_to_5" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section To --') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3 section">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section Set 6') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control section_from" name="section_from[6][]" id="section_from_6" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section From--') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <span style='font-size:25px;'>&#8594;</span>
                                            </div>
                                            <div class="col-lg-5 row2Field">
                                                <select class="form-control section_to" name="section_to[6][]" id="section_to_6" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section To --') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3 section">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('students', 'Section Set 7') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <select class="form-control section_from" name="section_from[7][]" id="section_from_7" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section From--') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <span style='font-size:25px;'>&#8594;</span>
                                            </div>
                                            <div class="col-lg-5 row2Field">
                                                <select class="form-control section_to" name="section_to[7][]" id="section_to_7" required multiple>
                                                    <option value=""><?= __d('students', '-- Choose Section To --') ?></option>

                                                </select>
                                            </div>
                                            <div class="col-lg-1 row2Field">
                                                <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                                            </div>

                                        </div>
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
    $("#level_from").change(function () {
        getSectionForPromotionAjax();
    });
    $("#level_to").change(function () {
        getSectionForPromotionAjax();
    });
    $('.section').on('click', '#delete', function (eq) {
        $(this).closest('.section').remove();
    });
    function getSectionForPromotionAjax() {
        var level_from = $("#level_from").val();
        var level_to = $("#level_to").val();
        if (level_from) {
            $.ajax({
                url: 'getSectionForPromotionAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "level": level_from
                },
                success: function (data) {
                    data = JSON.parse(data);
                    var text1 = '<option value="">-- Choose --</option>';
                    for (let i = 0; i < data.length; i++) {
                        var name = data[i]["section_name"];
                        var id = data[i]["section_id"];
                        text1 += '<option value="' + id + '" >' + name + '</option>';
                    }
                    $('#section_from_1').html(text1);
                    $('#section_from_2').html(text1);
                    $('#section_from_3').html(text1);
                    $('#section_from_4').html(text1);
                    $('#section_from_5').html(text1);
                    $('#section_from_6').html(text1);
                    $('#section_from_7').html(text1);
                }
            });
        }

        if (level_to) {
            $.ajax({
                url: 'getSectionForPromotionAjax',
                cache: false,
                type: 'GET',
                dataType: 'HTML',
                data: {
                    "level": level_to
                },
                success: function (data) {
                    data = JSON.parse(data);
                    var text1 = '<option value="">-- Choose --</option>';
                    for (let i = 0; i < data.length; i++) {
                        var name = data[i]["section_name"];
                        var id = data[i]["section_id"];
                        text1 += '<option value="' + id + '" >' + name + '</option>';
                    }
                    $('#section_to_1').html(text1);
                    $('#section_to_2').html(text1);
                    $('#section_to_3').html(text1);
                    $('#section_to_4').html(text1);
                    $('#section_to_5').html(text1);
                    $('#section_to_6').html(text1);
                    $('#section_to_7').html(text1);
                }
            });
        }

    }
</script>