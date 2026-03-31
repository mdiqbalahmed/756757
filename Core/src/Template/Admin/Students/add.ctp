<?php

$this->Form->unlockField('name');
$this->Form->unlockField('name_bn');
$this->Form->unlockField('mobile');
$this->Form->unlockField('telephone');
$this->Form->unlockField('email');
$this->Form->unlockField('gender');
$this->Form->unlockField('religion');
$this->Form->unlockField('image_name');
$this->Form->unlockField('permanent_address');
$this->Form->unlockField('present_address');
$this->Form->unlockField('date_of_birth');
$this->Form->unlockField('birth_registration');
$this->Form->unlockField('national_id');
$this->Form->unlockField('nationality');
$this->Form->unlockField('blood_group');
$this->Form->unlockField('date_of_admission');
$this->Form->unlockField('freedom_fighter');
$this->Form->unlockField('tribal');
$this->Form->unlockField('orphan');
$this->Form->unlockField('part_time_job');
$this->Form->unlockField('job_type');
$this->Form->unlockField('stipend');
$this->Form->unlockField('scholership');
$this->Form->unlockField('disabled');
$this->Form->unlockField('marital_status');
$this->Form->unlockField('institute_name');

//Academic Information table => "scms_qualification"
$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('group_id');
$this->Form->unlockField('roll');
$this->Form->unlockField('religion_subject');
$this->Form->unlockField('thrid_subject');
$this->Form->unlockField('forth_subject');
$this->Form->unlockField('status');
$this->Form->unlockField('resedential');


//Educational Information table => "scms_qualification"
$this->Form->unlockField('qualification_id');
$this->Form->unlockField('exam_name');
$this->Form->unlockField('exam_board');
$this->Form->unlockField('exam_session');
$this->Form->unlockField('exam_roll');
$this->Form->unlockField('exam_registration');
$this->Form->unlockField('institute');
$this->Form->unlockField('grade');
$this->Form->unlockField('group_name');
$this->Form->unlockField('gpa');
$this->Form->unlockField('passing_year');

//Father Information table => "scms_qualification"
$this->Form->unlockField('g_name');
$this->Form->unlockField('g_name_bn');
$this->Form->unlockField('g_mobile');
$this->Form->unlockField('g_nid');
$this->Form->unlockField('g_birth_reg');
$this->Form->unlockField('g_occupation');
$this->Form->unlockField('g_income');
$this->Form->unlockField('g_nationality');
$this->Form->unlockField('g_religion');
$this->Form->unlockField('g_gender');
$this->Form->unlockField('g_relation');

$this->Form->unlockField('active_guardian');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Student Registration Form</title>
</head>

<body>
    <div class="container  mt-5 mb-5">
        <div class="form-border">
            <div class="header">
                <h1 class="h1 text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize; color:chocolate;">
                    <?= __d('students', 'Student Registration Form') ?>
                </h1>
            </div>

            <?php if (isset($values['Student\'s Information'])) { ?>
                <section class="bg-light  p-4 m-auto" action="#">
                    <legend class=" mb-4"><?= __d('students', $values['Student\'s Information'][1]['heading']) ?>
                    </legend>
                    <div class="form_area p-3">

                        <?php echo $this->Form->create('', ['type' => 'file']); ?>
                        <div class="row">
                            <div class="col-lg-9">
                                <?php if (isset($values['Student\'s Information'][1])) { //pr($values['Student\'s Information']);die;
                                ?>
                                    <div class="row mb-3">
                                        <div class="col-lg-2">
                                            <p class="label-font"><?= __d('students', 'Full Name') ?></p>
                                        </div>
                                        <div class="col-lg-10">
                                            <input name="name" type="text" class="form-control" placeholder="Full Name" <?php echo (($values['Student\'s Information'][1]['required']) == 1) ? 'required' : ''; ?>>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row mb-3">
                                    <?php if (isset($values['Student\'s Information'][2])) { ?>
                                        <div class="col-lg-2">
                                            <p class="label-font"><?= __d('students', 'Full Name<br>(in Bangla)') ?> </p>
                                        </div>
                                        <div class="col-lg-10">
                                            <input name="name_bn" type="text" class="form-control" placeholder="Full Name (in Bangla)" <?php echo (($values['Student\'s Information'][2]['required']) == 1) ? 'required' : ''; ?>>
                                        </div>
                                </div>
                            <?php } ?>
                            <div class="row mb-3">
                                <?php if (isset($values['Student\'s Information'][4])) { ?>
                                    <div class="col-lg-2">
                                        <p class="label-font"><?= __d('students', 'Mobile No.') ?></p>
                                    </div>
                                    <div class="col-lg-4 d-flex">
                                        <input name="mobile" type="tel" class="form-control" placeholder="Mobile no" <?php echo (($values['Student\'s Information'][4]['required']) == 1) ? 'required' : ''; ?>>
                                    </div>
                                <?php } ?>
                                <?php if (isset($values['Student\'s Information'][3])) { ?>
                                    <div class="col-lg-2">
                                        <p class="label-font"><?= __d('students', 'Email') ?></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <input name="email" type="text" class="form-control" placeholder="Email address" <?php echo (($values['Student\'s Information'][3]['required']) == 1) ? 'required' : ''; ?>>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row mb-3">
                                <?php if (isset($values['Student\'s Information'][5])) { ?>
                                    <div class="col-lg-2">
                                        <p class="label-font"><?= __d('students', 'Telephone') ?></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <input name="telephone" type="tel" class="form-control" placeholder="Telephone number" <?php echo (($values['Student\'s Information'][5]['required']) == 1) ? 'required' : ''; ?>>
                                    </div>
                                <?php } ?>
                                <?php if (isset($values['Student\'s Information'][10])) { ?>
                                    <div class="col-lg-2">
                                        <p class="label-font"><?= __d('students', 'Date of Birth') ?></p>
                                    </div>
                                    <div class="col-lg-4 d-flex">
                                        <input name="date_of_birth" type="date" class="form-control" <?php echo (($values['Student\'s Information'][10]['required']) == 1) ? 'required' : ''; ?>>
                                    </div>
                                <?php } ?>
                            </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="center">
                                    <div class="avatar-wrapper" id="avatar">
                                        <img class="profile-pic" src="" />
                                        <div class="upload-button">
                                            <i class="fa fa-arrow-circle-up" aria-hidden="true"><?= __d('students', 'Uplaoad') ?></i>
                                        </div>
                                        <input name="image_name" class="file-upload" type="file" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][12])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'NID No.') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="national_id" type="tel" class="form-control" placeholder="NID number" <?php echo (($values['Student\'s Information'][12]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][11])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Birth Registration') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="birth_registration" type="tel" class="form-control" placeholder="Birth Registration number" <?php echo (($values['Student\'s Information'][11]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][8])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Permanent Address') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <textarea name="permanent_address" class="form-control" rows="2" placeholder="Permanent Address" <?php echo (($values['Student\'s Information'][8]['required']) == 1) ? 'required' : ''; ?>></textarea>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][9])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Present Address') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <textarea name="present_address" class="form-control" rows="2" placeholder="Present Address" <?php echo (($values['Student\'s Information'][9]['required']) == 1) ? 'required' : ''; ?>></textarea>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][6])) { ?>
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Gender') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="gender" <?php echo (($values['Student\'s Information'][6]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Male"><?= __d('students', 'Male') ?></option>
                                                    <option value="Female"><?= __d('students', 'Female') ?></option>
                                                    <option value="Others"><?= __d('students', 'Others') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][7])) { ?>
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Religion') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="religion" <?php echo (($values['Student\'s Information'][7]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Islam"><?= __d('students', 'Islam') ?></option>
                                                    <option value="Hindu"><?= __d('students', 'Hindu') ?></option>
                                                    <option value="Christian"><?= __d('students', 'Christian') ?></option>
                                                    <option value="Buddhist"><?= __d('students', 'Buddhist') ?></option>
                                                    <option value="Others"><?= __d('students', 'Others') ?></option>
                                                </select>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][14])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Blood Group') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="blood_group" <?php echo (($values['Student\'s Information'][14]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="A+"><?= __d('students', 'A+') ?></option>
                                                    <option value="A-"><?= __d('students', 'A-') ?></option>
                                                    <option value="B+"><?= __d('students', 'B+') ?></option>
                                                    <option value="B-"><?= __d('students', 'B-') ?></option>
                                                    <option value="O+"><?= __d('students', 'O+') ?></option>
                                                    <option value="O-"><?= __d('students', 'O-') ?></option>
                                                    <option value="AB+"><?= __d('students', 'AB+') ?></option>
                                                    <option value="AB-"><?= __d('students', 'AB-') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][24])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Marital Status') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="marital_status" <?php echo (($values['Student\'s Information'][24]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Married') ?></option>
                                                    <option value="No"><?= __d('students', 'Unmarried') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][15])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Date of Admission') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="date_of_admission" type="date" class="form-control" placeholder="Date of Admission" <?php echo (($values['Student\'s Information'][15]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][13])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Nationality') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="nationality" type="text" class="form-control" placeholder="Nationality" <?php echo (($values['Student\'s Information'][13]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                </div>
                            <?php } ?>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][16])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Freedom Fighter') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="freedom_fighter" <?php echo (($values['Student\'s Information'][16]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Yes') ?></option>
                                                    <option value="No"><?= __d('students', 'No') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][17])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Tribal') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="tribal" <?php echo (($values['Student\'s Information'][17]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Yes') ?></option>
                                                    <option value="No"><?= __d('students', 'No') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][23])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Disabled') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="disabled" <?php echo (($values['Student\'s Information'][23]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Yes') ?></option>
                                                    <option value="No"><?= __d('students', 'No') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][18])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Orphan') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="orphan" <?php echo (($values['Student\'s Information'][18]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Yes') ?></option>
                                                    <option value="No"><?= __d('students', 'No') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][19])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Part-time job') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="part_time_job" <?php echo (($values['Student\'s Information'][19]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Yes') ?></option>
                                                    <option value="No"><?= __d('students', 'No') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][20])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Job Type') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="job_type" type="text" class="form-control" placeholder="Job Type" <?php echo (($values['Student\'s Information'][20]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][21])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Stipend') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="stipend" <?php echo (($values['Student\'s Information'][21]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Yes') ?></option>
                                                    <option value="No"><?= __d('students', 'No') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Student\'s Information'][22])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font"><?= __d('students', 'Scholership') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="scholership" <?php echo (($values['Student\'s Information'][22]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Yes"><?= __d('students', 'Yes') ?></option>
                                                    <option value="No"><?= __d('students', 'No') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                               
                            </div>
                            <div class="row mb-3">

                                <div class="col-lg-4">

                                </div>
                                <div class="col-lg-4">
                                    <?php if (isset($values['Student\'s Information'][63])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Status') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="status" <?php echo (($values['Student\'s Information'][63]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="1"><?= __d('students', 'Active') ?></option>
                                                    <option value="0"><?= __d('students', 'In-Active') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-4">

                                </div>

                            </div>
                        </div>
                    </div>
                </section>

            <?php } ?>

            <?php if (isset($values['Academic Information'])) { ?>
                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', "Academic Information") ?></legend>
                        <div class="form_area p-3">


                            <div class="row mb-3">

                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][56])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', $values['Academic Information'][56]['heading']) ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="session_id" id="session_id" <?php echo (($values['Academic Information'][56]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                    <?php foreach ($sessions as $session) { ?>
                                                        <option value="<?php echo $session['session_id']; ?>"><?php echo $session['session_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][54])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Shift') ?></p>
                                            </div>

                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="shift_id" id="shift_id" <?php echo (($values['Academic Information'][54]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                    <?php foreach ($shifts as $shift) { ?>
                                                        <option value="<?php echo $shift['shift_id']; ?>"><?php echo $shift['shift_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][52])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Class') ?></p>
                                            </div>

                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="level_id" id="level_id" <?php echo (($values['Academic Information'][52]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                    <?php foreach ($levels as $level) { ?>
                                                        <option value="<?php echo $level['level_id']; ?>"><?php echo $level['level_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][55])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Section') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="section_id" id="section_id" <?php echo (($values['Academic Information'][55]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][53])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Group') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="group_id" id="group_id">
                                                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                    <?php foreach ($groups as $group) { ?>
                                                        <option value="<?php echo $group['group_id']; ?>"><?php echo $group['group_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][57])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Roll') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="roll" type="text" class="form-control" placeholder="Roll" <?php echo (($values['Academic Information'][57]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][57])) { //pr($values['Academic Information'][57]);die;
                                    ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Religion Subject') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="religion_subject" id="religion_subject" <?php if ($religion_field) {
                                                                                                                                echo 'required';
                                                                                                                            } ?>>
                                                    <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', '3rd Subject') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="thrid_subject[]" id="thrid_subject" multiple="multiple">
                                                <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', '4th Subject') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="forth_subject[]" id="forth_subject" multiple="multiple">
                                                <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <?php if (isset($values['Academic Information'][61])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Residential') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="resedential" <?php echo (($values['Academic Information'][61]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="1"><?= __d('students', 'Resident') ?></option>
                                                    <option value="0"><?= __d('students', 'Non-Resident') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>
                        </div>
                    </fieldset>
                </section>
            <?php } ?>
            <?php if (isset($values['Educational Information 1'])) { ?>
                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', $values['Educational Information 1'][41]['heading']) ?>
                        </legend>
                        <div class="education">
                            <div class="education_block form_area p-3 mb-2" id="education_block">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <?php if (isset($values['Educational Information 1'][41])) { ?>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('students', 'Exam Name') ?></p>
                                                </div>
                                                <div class="col-lg-10 row3Field">
                                                    <input name="exam_name[]" type="text" class="form-control" placeholder="Full Name" <?php echo (($values['Educational Information 1'][41]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                    </div>
                                <?php } ?>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <?php if (isset($values['Educational Information 1'][42])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Board') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_board[]" type="text" class="form-control" placeholder="Exam Board" <?php echo (($values['Educational Information 1'][42]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($values['Educational Information 1'][43])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_session[]" type="text" class="form-control" placeholder=" Exam Session" <?php echo (($values['Educational Information 1'][43]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 1'][44])) { ?>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <p class="label-font13"><?= __d('students', 'Roll No.') ?></p>
                                                </div>
                                                <div class="col-lg-9 row2Field">
                                                    <input name="exam_roll[]" type="text" class="form-control" placeholder="Exam Roll No." <?php echo (($values['Educational Information 1'][44]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 1'][45])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'Registration No.') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="exam_registration[]" type="text" class="form-control" placeholder="Registration No." <?php echo (($values['Educational Information 1'][45]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?php if (isset($values['Educational Information 1'][46])) { ?>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('students', 'Institute') ?></p>
                                                </div>
                                                <div class="col-lg-10 row2Field">
                                                    <input name="institute[]" type="text" class="form-control" placeholder="Institute Name" <?php echo (($values['Educational Information 1'][46]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 1'][47])) { ?>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <p class="label-font13"><?= __d('students', 'Grade') ?></p>
                                                </div>
                                                <div class="col-lg-9 row2Field">
                                                    <input name="grade[]" type="text" class="form-control" placeholder="Grade" <?php echo (($values['Educational Information 1'][47]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 1'][48])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'Group') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="group_name[]" type="text" class="form-control" placeholder="Group" <?php echo (($values['Educational Information 1'][48]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 1'][49])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'GPA') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="gpa[]" type="text" class="form-control" placeholder="GPA" <?php echo (($values['Educational Information 1'][49]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 1'][50])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'Passing Year') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="passing_year[]" type="text" class="form-control" placeholder="Exam Session" <?php echo (($values['Educational Information 1'][50]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-md-1 mb-3">
                                    <button id="delete" class=" btn btn-danger" type="button"><?= __d('students', 'Remove') ?></button>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </section>
            <?php } ?>

            <?php if (isset($values['Educational Information 2'])) { ?>
                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', $values['Educational Information 2'][41]['heading']) ?>
                        </legend>
                        <div class="education">
                            <div class="education_block form_area p-3 mb-2" id="education_block">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <?php if (isset($values['Educational Information 2'][41])) { ?>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('students', 'Exam Name') ?></p>
                                                </div>
                                                <div class="col-lg-10 row3Field">
                                                    <input name="exam_name[]" type="text" class="form-control" placeholder="Full Name" <?php echo (($values['Educational Information 2'][41]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                    </div>
                                <?php } ?>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <?php if (isset($values['Educational Information 2'][42])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Board') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_board[]" type="text" class="form-control" placeholder="Exam Board" <?php echo (($values['Educational Information 2'][42]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($values['Educational Information 2'][43])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_session[]" type="text" class="form-control" placeholder=" Exam Session" <?php echo (($values['Educational Information 2'][43]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 2'][44])) { ?>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <p class="label-font13"><?= __d('students', 'Roll No.') ?></p>
                                                </div>
                                                <div class="col-lg-9 row2Field">
                                                    <input name="exam_roll[]" type="text" class="form-control" placeholder="Exam Roll No." <?php echo (($values['Educational Information 2'][44]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 2'][45])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'Registration No.') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="exam_registration[]" type="text" class="form-control" placeholder="Registration No." <?php echo (($values['Educational Information 2'][45]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?php if (isset($values['Educational Information 2'][46])) { ?>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('students', 'Institute') ?></p>
                                                </div>
                                                <div class="col-lg-10 row2Field">
                                                    <input name="institute[]" type="text" class="form-control" placeholder="Institute Name" <?php echo (($values['Educational Information 2'][46]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 2'][47])) { ?>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <p class="label-font13"><?= __d('students', 'Grade') ?></p>
                                                </div>
                                                <div class="col-lg-9 row2Field">
                                                    <input name="grade[]" type="text" class="form-control" placeholder="Grade" <?php echo (($values['Educational Information 2'][47]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 2'][48])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'Group') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="group_name[]" type="text" class="form-control" placeholder="Group" <?php echo (($values['Educational Information 2'][48]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 2'][49])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'GPA') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="gpa[]" type="text" class="form-control" placeholder="GPA" <?php echo (($values['Educational Information 2'][49]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <?php if (isset($values['Educational Information 2'][50])) { ?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('students', 'Passing Year') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="passing_year[]" type="text" class="form-control" placeholder="Exam Session" <?php echo (($values['Educational Information 2'][50]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-md-1 mb-3">
                                    <button id="delete" class=" btn btn-danger" type="button"><?= __d('students', 'Remove') ?></button>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </section>
            <?php } ?>

            <!-- Added Name Till EDUCATION FIELD -->

            <?php if (isset($values['Father\'s Information'])) { ?>
                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', $values['Father\'s Information'][29]['heading']) ?></legend>
                        <div class="form_area p-3">
                            <input name="g_relation[]" type="hidden" class="form-control" value="father">
                            <input name="g_gender[]" type="hidden" class="form-control" value="Male">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Father\'s Information'][29])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                            </div>
                                            <div class="col-lg-10 row3Field">
                                                <input name="g_name[]" type="text" class="form-control" placeholder="Full Name" <?php echo (($values['Father\'s Information'][29]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Father\'s Information'][30])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Name<br>(Bangla)') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="g_name_bn[]" type="text" class="form-control" placeholder="Full Name (in Bangla)" <?php echo (($values['Father\'s Information'][30]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <?php if (isset($values['Father\'s Information'][35])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Mobile') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_mobile[]" type="text" class="form-control" placeholder="Mobile No." <?php echo (($values['Father\'s Information'][35]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Father\'s Information'][36])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'NID No.') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_nid[]" type="text" class="form-control" placeholder="NID No." <?php echo (($values['Father\'s Information'][36]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Father\'s Information'][37])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Birth Registration') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="g_birth_reg[]" type="text" class="form-control" placeholder="Birth Registration No." <?php echo (($values['Father\'s Information'][37]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <?php if (isset($values['Father\'s Information'][33])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Occupation') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_occupation[]" type="text" class="form-control" placeholder="Occupation" <?php echo (($values['Father\'s Information'][33]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Father\'s Information'][38])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Monthly Income') ?> </p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_income[]" type="text" class="form-control" placeholder="Monthly Income" <?php echo (($values['Father\'s Information'][38]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Father\'s Information'][32])) { ?>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('students', 'Nationality') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="g_nationality[]" type="text" class="form-control" placeholder="Nationality" <?php echo (($values['Father\'s Information'][32]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Religion') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="g_religion[]" <?php echo (($values['Father\'s Information'][36]['required']) == 1) ? 'required' : ''; ?>>
                                                <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                <option value="Islam"><?= __d('students', 'Islam') ?></option>
                                                <option value="Hindu"><?= __d('students', 'Hindu') ?></option>
                                                <option value="Christian"><?= __d('students', 'Christian') ?></option>
                                                <option value="Buddhist"><?= __d('students', 'Buddhist') ?></option>
                                                <option value="Others"><?= __d('students', 'Others') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </section>
            <?php } ?>



            <?php if (isset($values['Mother\'s Information'])) { ?>
                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', $values['Mother\'s Information'][29]['heading']) ?></legend>
                        <div class="form_area p-3">
                            <input name="g_relation[]" type="hidden" class="form-control" value="mother">
                            <input name="g_gender[]" type="hidden" class="form-control" value="Female">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Mother\'s Information'][29])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                            </div>
                                            <div class="col-lg-10 row3Field">
                                                <input name="g_name[]" type="text" class="form-control" placeholder="Full Name" <?php echo (($values['Mother\'s Information'][29]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Mother\'s Information'][30])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Name<br>(Bangla)') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="g_name_bn[]" type="text" class="form-control" placeholder="Full Name (in Bangla)" <?php echo (($values['Mother\'s Information'][30]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <?php if (isset($values['Mother\'s Information'][35])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Mobile') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_mobile[]" type="text" class="form-control" placeholder="Mobile No." <?php echo (($values['Mother\'s Information'][35]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Mother\'s Information'][36])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'NID No.') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_nid[]" type="text" class="form-control" placeholder="NID No." <?php echo (($values['Mother\'s Information'][36]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Mother\'s Information'][37])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Birth Registration') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="g_birth_reg[]" type="text" class="form-control" placeholder="Birth Registration No." <?php echo (($values['Mother\'s Information'][37]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <?php if (isset($values['Mother\'s Information'][33])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Occupation') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_occupation[]" type="text" class="form-control" placeholder="Occupation" <?php echo (($values['Mother\'s Information'][33]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Mother\'s Information'][38])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Monthly Income') ?> </p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_income[]" type="text" class="form-control" placeholder="Monthly Income" <?php echo (($values['Mother\'s Information'][38]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Mother\'s Information'][32])) { ?>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('students', 'Nationality') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="g_nationality[]" type="text" class="form-control" placeholder="Nationality" <?php echo (($values['Mother\'s Information'][32]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Mother\'s Information'][39])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Religion') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="g_religion[]" <?php echo (($values['Mother\'s Information'][39]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Islam"><?= __d('students', 'Islam') ?></option>
                                                    <option value="Hindu"><?= __d('students', 'Hindu') ?></option>
                                                    <option value="Christian"><?= __d('students', 'Christian') ?></option>
                                                    <option value="Buddhist"><?= __d('students', 'Buddhist') ?></option>
                                                    <option value="Others"><?= __d('students', 'Others') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </section>
            <?php } ?>



            <?php if (isset($values['Active Guardian'])) { ?>
                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', $values['Active Guardian'][29]['heading']) ?></legend>
                        <div class="form_area p-3">
                            <input name="g_relation[]" type="hidden" class="form-control" value="other">
                            <input name="g_gender[]" type="hidden" class="form-control" value="Male">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <?php if (isset($values['Active Guardian'][29])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                            </div>
                                            <div class="col-lg-10 row3Field">
                                                <input name="g_name[]" type="text" class="form-control" placeholder="Full Name" <?php echo (($values['Active Guardian'][29]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Active Guardian'][30])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Name<br>(Bangla)') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="g_name_bn[]" type="text" class="form-control" placeholder="Full Name (in Bangla)" <?php echo (($values['Active Guardian'][30]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <?php if (isset($values['Active Guardian'][35])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Mobile') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_mobile[]" type="text" class="form-control" placeholder="Mobile No." <?php echo (($values['Active Guardian'][35]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Active Guardian'][36])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'NID No.') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_nid[]" type="text" class="form-control" placeholder="NID No." <?php echo (($values['Active Guardian'][36]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <?php if (isset($values['Active Guardian'][37])) { ?>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Birth Registration') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="g_birth_reg[]" type="text" class="form-control" placeholder="Birth Registration No." <?php echo (($values['Active Guardian'][37]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <?php if (isset($values['Active Guardian'][33])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Occupation') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_occupation[]" type="text" class="form-control" placeholder="Occupation" <?php echo (($values['Active Guardian'][33]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Active Guardian'][38])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Monthly Income') ?> </p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="g_income[]" type="text" class="form-control" placeholder="Monthly Income" <?php echo (($values['Active Guardian'][38]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Active Guardian'][32])) { ?>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('students', 'Nationality') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="g_nationality[]" type="text" class="form-control" placeholder="Nationality" <?php echo (($values['Active Guardian'][32]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php if (isset($values['Active Guardian'][39])) { ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Religion') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <select class="form-control" name="g_religion[]" <?php echo (($values['Active Guardian'][39]['required']) == 1) ? 'required' : ''; ?>>
                                                    <option value="" class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                    <option value="Islam"><?= __d('students', 'Islam') ?></option>
                                                    <option value="Hindu"><?= __d('students', 'Hindu') ?></option>
                                                    <option value="Christian"><?= __d('students', 'Christian') ?></option>
                                                    <option value="Buddhist"><?= __d('students', 'Buddhist') ?></option>
                                                    <option value="Others"><?= __d('students', 'Others') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                                </div>
                            </div>

                            <div class="row active_guardian mt-5">
                                <div class="col-lg-6 dropdown">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font"><?= __d('students', 'Active Guardian') ?></p>
                                        </div>
                                        <div class=" col-lg-6 row2Field">
                                            <select class="bg-warning form-control" name="active_guardian" required>
                                                <option value="Father"><?= __d('students', 'Father') ?></option>
                                                <option value="Mother"><?= __d('students', 'Mother') ?></option>
                                                <option value="Other"><?= __d('students', 'Other') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
                                    <?php echo $this->Form->end(); ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </section>
        </div>
    </div>
</body>

</html>
<script>
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
    });
    $("#session_id").change(function() {
        getThirdForthAjax();
        getReligionSubjectAjax();
    });

    $("#level_id").change(function() {
        getSectionAjax();
        getThirdForthAjax();
        getReligionSubjectAjax();
        var element1 = document.getElementById("group_id");
        var level_id = $("#level_id").val();
        //change for icon dinajpur
        getGroupAjax();
        //        element1.setAttribute('required', true);

        /* orginal change for icondinajpur
         if (level_id == 9 || level_id == 10) {
         getGroupAjax();
         element1.setAttribute('required', true);
         } else {
         element1.removeAttribute('required');
         var text1 = '<option value="">-- Choose --</option>';
         $('#group_id').html(text1);
         }
         *
         */

        if (level_id > 5) {
            getThirdForthAjax();
        } else {
            var text1 = '<option value="">-- Choose --</option>';
            $('#thrid_subject').html(text1);
            $('#forth_subject').html(text1);
        }
    });

    $("#shift_id").change(function() {
        getSectionAjax();
    });
    $("#group_id").change(function() {
        var group_id = $("#group_id").val();
        getThirdForthAjax();
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



    function getReligionSubjectAjax() {
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getReligionSubjectAjax',
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

    function getGroupAjax() {
        $.ajax({
            url: 'getGroupAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function(data) {

                data = JSON.parse(data);

                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["group_name"];
                    var id = data[i]["group_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#group_id').html(text1);

            }
        });
    }

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        $.ajax({
            url: 'getSectionAjax',
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

    function getThirdForthAjax() {
        var group_id = $("#group_id").val();
        var session_id = $("#session_id").val();
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getThirdForthAjax',
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
    $("#sid").change(function() {
        var sid = $("#sid").val();
        $.ajax({
            url: 'getCodeAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "sid": sid
            },
            success: function(data) {
                if (data != 0) {
                    alert("Duplicate SID");
                    location.reload();
                }
            }
        });
    });
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
