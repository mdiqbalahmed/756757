<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Student Admission Form</title>
</head>

<?php

use Cake\Core\Configure;

$captchaPublic = Configure::read('Service.recaptcha_public_key');
$captchaSecret = Configure::read('Service.recaptcha_private_key');


$this->Form->unlockField('id');
$this->Form->unlockField('name');
$this->Form->unlockField('name_bn');




$this->Form->unlockField('present_location');
$this->Form->unlockField('permanent_location');
$this->Form->unlockField('mobile');
$this->Form->unlockField('campus');
$this->Form->unlockField('dob');
$this->Form->unlockField('shift');
$this->Form->unlockField('level');
$this->Form->unlockField('group');
$this->Form->unlockField('resident');
$this->Form->unlockField('session');
$this->Form->unlockField('status');
$this->Form->unlockField('version');
$this->Form->unlockField('image_name');
$this->Form->unlockField('fname');
$this->Form->unlockField('fname_bn');
$this->Form->unlockField('foccupation');
$this->Form->unlockField('fmobile');


$this->Form->unlockField('mname');
$this->Form->unlockField('mname_bn');
$this->Form->unlockField('moccupation');
$this->Form->unlockField('mmobile');

$this->Form->unlockField('religion');
$this->Form->unlockField('nationality');
$this->Form->unlockField('pre_school');
$this->Form->unlockField('pre_class');
$this->Form->unlockField('quota');

$this->Form->unlockField('status');
$this->Form->unlockField('g-recaptcha-response');

?>


<body>
    <div class="container  mt-5 mb-5">
        <div class="form-border">
            <section class="bg-light  p-4 m-auto" action="#">
                <div class="form_area p-3">

                    <div class="header">
                        <h1 class="h1 text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                            <?= __d('students', 'Student Admission Form') ?>
                        </h1>
                    </div>

                    <?php echo $this->Form->create('', ['type' => 'file']); ?>
                    <div class="row">
                        <div class="col-lg-9">

                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <p class="label-font13"><?= __d('students', 'Class Of Admission') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="level">
                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        <?php foreach ($levels as $level) { ?>
                                            <option value="<?php echo $level['level_id']; ?>"><?php echo $level['level_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Shift*') ?> </p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="shift">
                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                        <?php foreach ($shifts as $shift) { ?>
                                            <option value="<?php echo $shift['shift_id']; ?>"><?php echo $shift['shift_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p><?= __d('students', 'Version') ?></p>
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <input name="version" type="tel" class="form-control" value="Bangla" readonly="true">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Student\'s Name(In English)') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="name" type="text" class="form-control" placeholder="Student Name(In English)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Student\'s Name(In Bangla)') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="name_bn" type="text" class="form-control" placeholder="Student Name(In Bangla)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Date of Birth') ?></p>
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <input name="dob" type="date" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p><?= __d('students', 'Residential Info') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="resident">
                                        <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                        <option value="Resident"><?= __d('students', 'Resident') ?></option>
                                        <option value="Non-Resident"><?= __d('students', 'Non-Resident') ?></option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p><?= __d('students', 'Campus') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="campus">
                                        <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                        <option value="Campus 1"><?= __d('students', 'Campus 1') ?></option>
                                        <option value="Campus 2"><?= __d('students', 'Campus 2') ?></option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Father\'s Name(In English)') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="fname" type="text" class="form-control" placeholder="Father Name(In English)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Father\'s Name(In Bangla)') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="fname_bn" type="text" class="form-control" placeholder="Father Name(In Bangla)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Father\'s Occupation') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="foccupation" type="text" class="form-control" placeholder="Father Occupation">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Father\'s Mobile No') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="fmobile" type="text" class="form-control" placeholder="Father Mobile No">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Mother\'s Name(In English)') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="mname" type="text" class="form-control" placeholder="Mother Name(In English)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Mother\'s Name(In Bangla)') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="mname_bn" type="text" class="form-control" placeholder="Mother Name(In Bangla)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Mother\'s Occupation') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="moccupation" type="text" class="form-control" placeholder="Mother Occupation">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Mother\'s Mobile No') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="mmobile" type="text" class="form-control" placeholder="Mother Mobile No">
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Religion') ?> </p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <select class="form-control" name="religion">
                                        <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                        <option value="Islam"><?= __d('students', 'Islam') ?></option>
                                        <option value="Hindu"><?= __d('students', 'Hindu') ?></option>
                                        <option value="Christian"><?= __d('students', 'Christian') ?></option>
                                        <option value="Buddhist"><?= __d('students', 'Buddhist') ?></option>
                                        <option value="Others"><?= __d('students', 'Others') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Nationality') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="nationality" type="text" class="form-control" placeholder="Nationality">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Previous School') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="pre_school" type="text" class="form-control" placeholder="Previous School">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('students', 'Previous Class') ?> </p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="pre_class" type="text" class="form-control" placeholder="Previous Class">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <p class="label-font"><?= __d('students', 'Contact Mobile No.') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <input name="mobile" type="tel" class="form-control" placeholder="Mobile No">
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <p class="label-font"><?= __d('students', 'Present Address') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <textarea name="present_location" class="form-control" rows="2" placeholder="Present Address" id="add1" required></textarea>
                                </div>

                            </div>

                            <div>
                                <input type="checkbox" id="copyAddresses">
                                <label style="color: green" for="copyAddresses" class="black11i">Same As Present Address</label>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <p class="label-font"><?= __d('students', 'Permanent Address') ?></p>
                                </div>
                                <div class="col-lg-9 row2Field">
                                    <textarea name="permanent_location" class="form-control" rows="2" placeholder="Permanent Address" id="add11" required></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="col-lg-3">
                            <div class="center">
                                <div class="avatar-wrapper form-avatar" id="avatar">
                                    <img class="profile-pic" src="" />
                                    <div class="upload-button">
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"><?= __d('students', 'Uplaoad') ?></i>
                                    </div>
                                    <input name="image_name" class="file-upload" type="file" accept="image/*" required />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <p class="label-font"><?= __d('students', 'Quota') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="quota">
                                    <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                    <option value="General"><?= __d('students', 'General') ?></option>
                                    <option value="Freedom Fighter"><?= __d('students', 'Freedom Fighter') ?></option>
                                    <option value="Disabled"><?= __d('students', 'Disabled') ?></option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!--<div class="g-recaptcha" data-sitekey="<?= $captchaPublic ?>"></div>-->
                </div>
            </section>

            <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
            <?= $this->Form->end() ?>
        </div>
    </div>
</body>

</html>

<script>
    document.getElementById('copyAddresses').addEventListener('change', function() {
        if (this.checked) {
            // Copy present address to permanent address
            document.getElementById('add11').value = document.getElementById('add1').value;
        } else {
            // Clear permanent address if the checkbox is unchecked
            document.getElementById('add11').value = '';
        }
    });
    $(document).ready(function() {
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(".profile-pic").attr("src", e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        };

        $(".file-upload").on("change", function() {
            readURL(this);
        });

        $(".upload-button").on("click", function() {
            $(".file-upload").click();
        });

    });
    var form = $(".education").html();

    $('.eduAdd').click(function() {
        $('.education').append(form);
    });
    $('.form').on('click', '#delete', function(eq) {
        $(this).closest('#single_row').remove();
    });
    $('.education').on('click', '#delete', function(eq) {
        alert("Are you sure, You want remove this?");
        $(this).closest('#education_block').remove();
    })

    $("#level_id").change(function() {
        getSectionAjax();
        getSubjectAjax();
        getReligionSubjectAjax();

        var element1 = document.getElementById("group_id");
        var level_id = $("#level_id").val();
        if (level_id == 9 || level_id == 10) {
            element1.setAttribute('required', true);
        } else {
            element1.removeAttribute('required');
        }
    });

    $("#shift_id").change(function() {
        getSectionAjax();
    });
    $("#group_id").change(function() {
        var group_id = $("#group_id").val();
        getSubjectAjax();
        var element1 = document.getElementById("thrid_subject");
        var element2 = document.getElementById("forth_subject");
        if (group_id == '') {
            element1.removeAttribute('required');
            element2.removeAttribute('required');
        } else {
            element1.setAttribute('required', true);
            element2.setAttribute('required', true);
        }
    });

    $("#session_id").change(function() {
        getSubjectAjax();
        getReligionSubjectAjax();
    });

    function getSubjectAjax() {
        var group_id = $("#group_id").val();
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'Ajax/getSubjectAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "group_id": group_id,
                "session_id": session_id,
                "level_id": level_id
            },
            success: function(data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["course_name"];
                    var id = data[i]["course_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#thrid_subject').html(text1);
                $('#forth_subject').html(text1);
            }
        });
    }

    function getReligionSubjectAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'Ajax/getReligionSubjectAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "session_id": session_id,
                "level_id": level_id
            },
            success: function(data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["course_name"];
                    var id = data[i]["course_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#religion_subject').html(text1);
            }
        });
    }

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        $.ajax({
            url: 'Ajax/getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "shift_id": shift_id
            },
            success: function(data) {
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

    // Get all the required fields
    const requiredFields = document.querySelectorAll('input[required], select[required]');

    requiredFields.forEach(field => {
        const label = field.closest('.row').querySelector('.label-font , .label-font13');
        if (label) {
            const asterisk = document.createElement('span');
            asterisk.className = 'required';
            asterisk.innerHTML = '*';
            asterisk.style.color = 'red';
            asterisk.style.marginRight = '2px';
            label.prepend(asterisk);
        }

    });
</script>
