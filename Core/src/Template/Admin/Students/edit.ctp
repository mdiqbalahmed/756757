<?php
$this->Form->unlockField('sid');
$this->Form->unlockField('student_id');
$this->Form->unlockField('student_cycle_id');
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
$this->Form->unlockField('quota');

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
$this->Form->unlockField('g_id');

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
    <title>Student Edit Form</title>
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


                    <?php if (isset($values['Student\'s Information'])) {
                    ?>
                        <section class="bg-light  p-4 m-auto" action="#">
                            <legend class=" mb-4"><?= __d('students', $values['Student\'s Information'][1]['heading']) ?>
                            </legend>
                            <div class="form_area p-3">

                                <?php echo $this->Form->create('', ['type' => 'file']); ?>
                                <input type="hidden" name="student_id" value="<?php echo $student->student_id; ?>">
                                <input type="hidden" name="student_cycle_id" value="<?php echo $student_cycle->student_cycle_id; ?>">

                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="row mb-3">
                                            <div class="col-lg-2">
                                                <p class="label-font"><?= __d('students', 'Student ID') ?></p>
                                            </div>
                                            <div class="col-lg-10">
                                                <input name="sid" type="text" class="form-control" value="<?php echo $student->sid; ?>" placeholder="Student ID" readonly required>
                                            </div>
                                        </div> 

                                        <?php if (isset($values['Student\'s Information'][1])) { //pr($values['Student\'s Information']);die;
                                        ?>
                                            <div class="row mb-3">
                                                <div class="col-lg-2">
                                                    <p class="label-font"><?= __d('students', 'Full Name') ?></p>
                                                </div>
                                                <div class="col-lg-10">
                                                    <input name="name" type="text" class="form-control" placeholder="Full Name" value="<?php echo $student->name; ?>" <?php echo (($values['Student\'s Information'][1]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row mb-3">
                                            <?php if (isset($values['Student\'s Information'][2])) { ?>
                                                <div class="col-lg-2">
                                                    <p class="label-font"><?= __d('students', 'Full Name<br>(in Bangla)') ?> </p>
                                                </div>
                                                <div class="col-lg-10">
                                                    <input name="name_bn" type="text" class="form-control" placeholder="Full Name (in Bangla)" value="<?php echo $student->name_bn; ?>" <?php echo (($values['Student\'s Information'][2]['required']) == 1) ? 'required' : ''; ?>>
                                                </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row mb-3">
                                        <?php if (isset($values['Student\'s Information'][4])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font"><?= __d('students', 'Mobile No.') ?></p>
                                            </div>
                                            <div class="col-lg-4 d-flex">
                                                <input name="mobile" type="tel" class="form-control" placeholder="Mobile no" value="<?php echo $student->mobile; ?>" <?php echo (($values['Student\'s Information'][4]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($values['Student\'s Information'][3])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font"><?= __d('students', 'Email') ?></p>
                                            </div>
                                            <div class="col-lg-4">
                                                <input name="email" type="text" class="form-control" placeholder="Email address" value="<?php echo $student->email; ?>" <?php echo (($values['Student\'s Information'][3]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row mb-3">
                                        <?php if (isset($values['Student\'s Information'][5])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font"><?= __d('students', 'Telephone') ?></p>
                                            </div>
                                            <div class="col-lg-4">
                                                <input name="telephone" type="tel" class="form-control" placeholder="Telephone number" value="<?php echo $student->telephone; ?>" <?php echo (($values['Student\'s Information'][5]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($values['Student\'s Information'][10])) { ?>
                                            <div class="col-lg-2">
                                                <p class="label-font"><?= __d('students', 'Date of Birth') ?></p>
                                            </div>
                                            <div class="col-lg-4 d-flex">
                                                <input name="date_of_birth" type="date" class="form-control" value="<?php echo $student->date_of_birth; ?>" <?php echo (($values['Student\'s Information'][10]['required']) == 1) ? 'required' : ''; ?>>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    </div>
                                    <div class="col-lg-3">
                                        <div class="center">
                                            <div class="avatar-wrapper" id="avatar">
                                                <img class="profile-pic" src="<?php echo '/webroot/uploads/students/regularSize/' . $student->regular_size; ?>">
                                                <div class="upload-button">
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true"><?= __d('students', 'Uplaoad') ?></i>
                                                </div>
                                                <?php echo $this->form->file('image_name', ['class' => 'file-upload']); ?>
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
                                                        <input name="national_id" type="tel" class="form-control" placeholder="NID number" value="<?php echo $student->national_id; ?>" <?php echo (($values['Student\'s Information'][12]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="birth_registration" type="tel" class="form-control" placeholder="Birth Registration number" value="<?php echo $student->birth_registration; ?>" <?php echo (($values['Student\'s Information'][11]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <textarea name="permanent_address" class="form-control" rows="2"> <?php echo $student->permanent_address; ?> <?php echo (($values['Student\'s Information'][8]['required']) == 1) ? 'required' : ''; ?></textarea>
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
                                                        <textarea name="present_address" class="form-control" rows="2"> <?php echo $student->present_address; ?> <?php echo (($values['Student\'s Information'][9]['required']) == 1) ? 'required' : ''; ?></textarea>
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
                                                        <select class="form-control" name="gender" value="<?php echo $student->gender; ?>" <?php echo (($values['Student\'s Information'][6]['required']) == 1) ? 'required' : ''; ?>>
                                                            <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                            <option value="Male" <?php if ($student->gender == 'Male') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Male') ?></option>
                                                            <option value="Female" <?php if ($student->gender == 'Female') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Female') ?></option>
                                                            <option value="Others" <?php if ($student->gender == 'Others') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Others') ?></option>
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
                                                        <select class="form-control" name="religion" value="<?php echo $student->religion; ?>" <?php echo (($values['Student\'s Information'][7]['required']) == 1) ? 'required' : ''; ?>>
                                                            <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                            <option value="Islam" <?php if ($student->religion == 'Islam') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Islam') ?></option>
                                                            <option value="Hindu" <?php if ($student->religion == 'Hindu') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Hindu') ?></option>
                                                            <option value="Christian" <?php if ($student->religion == 'Christian') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Christian') ?></option>
                                                            
                                                            <option value="Buddhist" <?php if ($student->religion == 'Buddhist') {
                                                                                            echo 'selected';
                                                                                        } ?>><?= __d('students', 'Buddhist') ?></option>
                                                            <option value="Others" <?php if ($student->religion == 'Others') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Others') ?></option>
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
                                                        <select class="form-control" name="blood_group" value="<?php echo $student->blood_group; ?>" <?php echo (($values['Student\'s Information'][14]['required']) == 1) ? 'required' : ''; ?>>
                                                            <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                            <option value="A+" <?php if ($student->blood_group == 'A+') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'A+') ?></option>
                                                            <option value="A-" <?php if ($student->blood_group == 'A-') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'A-') ?></option>
                                                            <option value="B+" <?php if ($student->blood_group == 'B+') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'B+') ?></option>
                                                            <option value="B-" <?php if ($student->blood_group == 'B-') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'B-') ?></option>
                                                            <option value="O+" <?php if ($student->blood_group == 'O+') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'O+') ?></option>
                                                            <option value="O-" <?php if ($student->blood_group == 'O-') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'O-') ?></option>
                                                            <option value="AB+" <?php if ($student->blood_group == 'AB+') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'AB+') ?></option>
                                                            <option value="AB-" <?php if ($student->blood_group == 'AB-') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'AB-') ?></option>
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
                                                        <select class="form-control" name="marital_status" value="<?php echo $student->marital_status; ?>" <?php echo (($values['Student\'s Information'][24]['required']) == 1) ? 'required' : ''; ?>>
                                                            <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                            <option value="Married" <?php if ($student->marital_status == 'Married') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Married') ?></option>
                                                            <option value="Unmarried" <?php if ($student->marital_status == 'Unmarried') {
                                                                                            echo 'selected';
                                                                                        } ?>><?= __d('students', 'Unmarried') ?></option>
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
                                                        <input name="date_of_admission" type="date" class="form-control" placeholder="Date of Admission" value="<?php echo $student->date_of_admission; ?>" <?php echo (($values['Student\'s Information'][15]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="nationality" type="text" class="form-control" placeholder="Nationality" value="<?php echo $student->nationality; ?>" <?php echo (($values['Student\'s Information'][13]['required']) == 1) ? 'required' : ''; ?>>
                                                    </div>
                                                </div>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <?php if (isset($values['Student\'s Information'][21])) { ?>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <p class="label-font"><?= __d('students', 'Quota') ?></p>
                                                    </div>
                                                    <div class="col-lg-9 row2Field">
                                                        <input name="quota" type="text" class="form-control" placeholder="quota" value="<?php echo $student->quota; ?>" readonly>
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
                                                        <select class="form-control" name="scholership" value="<?php echo $student->scholership; ?>" <?php echo (($values['Student\'s Information'][22]['required']) == 1) ? 'required' : ''; ?>>
                                                            <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                            <option value="Yes" <?php if ($student->scholership == 'Yes') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'Yes') ?></option>
                                                            <option value="No" <?php if ($student->scholership == 'No') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'No') ?></option>
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
                                            <?php if (isset($values['Student\'s Information'][66])) { ?>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <p class="label-font"><?= __d('students', 'Name Of College') ?></p>
                                                    </div>
                                                    <div class="col-lg-9 row2Field">
                                                        <input name="institute_name" type="text" class="form-control" value="<?php echo $student->institute_name; ?>" <?php echo (($values['Student\'s Information'][66]['required']) == 1) ? 'required' : ''; ?>>
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

                    <?php }

                    ?>


                    <?php if (isset($values['Academic Information'])) {
                        //                    pr($values);die;
                    ?>
                        <section class="bg-light mt-3 p-4 m-auto" action="#">
                            <fieldset>
                                <legend class=" mb-4"><?= __d('students', "Academic Information") ?></legend>
                                <div class="form_area p-3">


                                    <div class="row mb-3">

                                        <div class="col-lg-4">
                                            <?php if (isset($values['Academic Information'][56])) { ?>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <p class="label-font13"><?= __d('students', "Session") ?></p>
                                                    </div>
                                                    <div class="col-lg-9 row2Field">
                                                        <select class="form-control" name="session_id" id="session_id" <?php echo (($values['Academic Information'][56]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <?php foreach ($shifts as $shift) { ?>
                                                                <option value="<?php echo $shift['shift_id']; ?>" <?php if ($student_cycle->shift_id == $shift['shift_id']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo $shift['shift_name']; ?></option>
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
                                                    <select class="form-control" name="level_id" id="level_id"
                                                        <?php echo (($values['Academic Information'][52]['required']) == 1) ? 'required' : ''; ?>
                                                        disabled>
                                                        <?php foreach ($levels as $level) { ?>
                                                        <option value="<?php echo $level['level_id']; ?>"
                                                            <?php if ($student_cycle->level_id == $level['level_id']) {
                                                                                                                            echo 'selected';
                                                                                                                        } ?>><?php echo $level['level_name']; ?></option>
                                                        <?php } ?>
                                                        <input type="hidden" name="level_id" value="<?php echo $student_cycle->level_id; ?>">
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
                                                            <?php foreach ($sections as $section) { ?>
                                                                <option value="<?php echo $section['section_id']; ?>" <?php if ($student_cycle->section_id == $section['section_id']) {
                                                                                                                            echo 'selected';
                                                                                                                        } ?>><?php echo $section['section_name']; ?></option>
                                                            <?php } ?>
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
                                                                <option value="<?php echo $group['group_id']; ?>" <?php if ($student_cycle->group_id == $group['group_id']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo $group['group_name']; ?></option>
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
                                                        <input name="roll" type="text" class="form-control" value="<?php echo $student_cycle->roll; ?>" placeholder="Roll" <?php echo (($values['Academic Information'][57]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <select class="form-control" name="religion_subject" id="religion_subject">
                                                            <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                            <?php foreach ($religion as $subject) { ?>
                                                                <option value="<?php echo $subject['course_id']; ?>" <?php if ($student->religion_subject == $subject['course_id']) {
                                                                                                                            echo 'selected';
                                                                                                                        } ?>><?php echo $subject['course_name']; ?></option>
                                                            <?php } ?>
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
                                                    <select class="form-control" name="thrid_subject[]" id="thrid_subject" multiple="multiple" size="2">
                                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                        <?php foreach ($third_subjects as $subject) { ?>
                                                            <option value="<?php echo $subject['course_id']; ?>" <?php echo $subject['selected']; ?>><?php echo $subject['course_name']; ?></option>
                                                        <?php } ?>
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
                                                    <select class="form-control" name="forth_subject[]" id="forth_subject" multiple="multiple" size="2">
                                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                        <?php foreach ($forth_subjects as $subject) { ?>
                                                            <option value="<?php echo $subject['course_id']; ?>" <?php echo $subject['selected']; ?>><?php echo $subject['course_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
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
                                                            <select class="form-control" name="status" value="<?php echo $student->status; ?>" <?php echo (($values['Student\'s Information'][63]['required']) == 1) ? 'required' : ''; ?>>
                                                                <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                                <option value="1" <?php if ($student->status == 1) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Active') ?></option>
                                                                <option value="0" <?php if ($student->status == 0) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'In-Active') ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                        </div>
                                        <div class="col-lg-4">

                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </section>
                    <?php }
                    ?>

                    <?php if (isset($values['Educational Information 1'])) { ?>
                        <section class="bg-light mt-3 p-4 m-auto" action="#">
                            <fieldset>
                                <legend class=" mb-4"><?= __d('students', $values['Educational Information 1'][41]['heading']) ?>
                                </legend>
                                <div class="education">
                                    <input type="hidden" name="qualification_id[]" value="<?php echo $educations[0]->qualification_id; ?>">
                                    <div class="education_block form_area p-3 mb-2" id="education_block">
                                        <div class="row mb-3">
                                            <div class="col-lg-6">
                                                <?php if (isset($values['Educational Information 1'][41])) { ?>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <p class="label-font13"><?= __d('students', 'Exam Name') ?></p>
                                                        </div>
                                                        <div class="col-lg-10 row3Field">
                                                            <input name="exam_name[]" type="text" class="form-control" placeholder="Full Name" value="<?php echo $educations[0]->exam_name; ?>" <?php echo (($values['Educational Information 1'][41]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="exam_board[]" type="text" class="form-control" placeholder="Exam Board" value="<?php echo $educations[0]->exam_board; ?>" <?php echo (($values['Educational Information 1'][42]['required']) == 1) ? 'required' : ''; ?>>
                                                    </div>
                                                <?php } ?>
                                                <?php if (isset($values['Educational Information 1'][43])) { ?>
                                                    <div class="col-lg-2">
                                                        <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                                    </div>
                                                    <div class="col-lg-4 row2Field">
                                                        <input name="exam_session[]" type="text" class="form-control" placeholder=" Exam Session" value="<?php echo $educations[0]->exam_session; ?>" <?php echo (($values['Educational Information 1'][43]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="exam_roll[]" type="text" class="form-control" placeholder="Exam Roll No." value="<?php echo $educations[0]->exam_roll; ?>" <?php echo (($values['Educational Information 1'][44]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="exam_registration[]" type="text" class="form-control" placeholder="Registration No." value="<?php echo $educations[0]->exam_registration; ?>" <?php echo (($values['Educational Information 1'][45]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="institute[]" type="text" class="form-control" placeholder="Institute Name" value="<?php echo $educations[0]->institute; ?>" <?php echo (($values['Educational Information 1'][46]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="grade[]" type="text" class="form-control" placeholder="Grade" value="<?php echo $educations[0]->grade; ?>" <?php echo (($values['Educational Information 1'][47]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="group_name[]" type="text" class="form-control" placeholder="Group" value="<?php echo $educations[0]->group_name; ?>" <?php echo (($values['Educational Information 1'][48]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="gpa[]" type="text" class="form-control" placeholder="GPA" value="<?php echo $educations[0]->gpa; ?>" <?php echo (($values['Educational Information 1'][49]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="passing_year[]" type="text" class="form-control" placeholder="Exam Session" value="<?php echo $educations[0]->passing_year; ?>" <?php echo (($values['Educational Information 1'][50]['required']) == 1) ? 'required' : ''; ?>>
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
                                    <input type="hidden" name="qualification_id[]" value="<?php echo $educations[1]->qualification_id; ?>">
                                    <div class="education_block form_area p-3 mb-2" id="education_block">
                                        <div class="row mb-3">
                                            <div class="col-lg-6">
                                                <?php if (isset($values['Educational Information 2'][41])) { ?>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <p class="label-font13"><?= __d('students', 'Exam Name') ?></p>
                                                        </div>
                                                        <div class="col-lg-10 row3Field">
                                                            <input name="exam_name[]" type="text" class="form-control" placeholder="Full Name" value="<?php echo $educations[1]->exam_name; ?>" <?php echo (($values['Educational Information 2'][41]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="exam_board[]" type="text" class="form-control" placeholder="Exam Board" value="<?php echo $educations[1]->exam_board; ?>" <?php echo (($values['Educational Information 2'][42]['required']) == 1) ? 'required' : ''; ?>>
                                                    </div>
                                                <?php } ?>
                                                <?php if (isset($values['Educational Information 2'][43])) { ?>
                                                    <div class="col-lg-2">
                                                        <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                                    </div>
                                                    <div class="col-lg-4 row2Field">
                                                        <input name="exam_session[]" type="text" class="form-control" placeholder=" Exam Session" value="<?php echo $educations[1]->exam_session; ?>" <?php echo (($values['Educational Information 2'][43]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="exam_roll[]" type="text" class="form-control" placeholder="Exam Roll No." value="<?php echo $educations[1]->exam_roll; ?>" <?php echo (($values['Educational Information 2'][44]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="exam_registration[]" type="text" class="form-control" placeholder="Registration No." value="<?php echo $educations[1]->exam_registration; ?>" <?php echo (($values['Educational Information 2'][45]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="institute[]" type="text" class="form-control" placeholder="Institute Name" value="<?php echo $educations[1]->institute; ?>" <?php echo (($values['Educational Information 2'][46]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="grade[]" type="text" class="form-control" placeholder="Grade" value="<?php echo $educations[1]->grade; ?>" <?php echo (($values['Educational Information 2'][47]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="group_name[]" type="text" class="form-control" placeholder="Group" value="<?php echo $educations[1]->group_name; ?>" <?php echo (($values['Educational Information 2'][48]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="gpa[]" type="text" class="form-control" placeholder="GPA" value="<?php echo $educations[1]->gpa; ?>" <?php echo (($values['Educational Information 2'][49]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <input name="passing_year[]" type="text" class="form-control" placeholder="Exam Session" value="<?php echo $educations[1]->passing_year; ?>" <?php echo (($values['Educational Information 2'][50]['required']) == 1) ? 'required' : ''; ?>>
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



                    <?php if (isset($values['Father\'s Information'])) { //pr($guardians);die;
                    ?>
                        <section class="bg-light mt-3 p-4 m-auto" action="#">
                            <fieldset>
                                <legend class=" mb-4"><?= __d('students', $values['Father\'s Information'][29]['heading']) ?></legend>
                                <div class="form_area p-3">
                                    <input name="g_relation[]" type="hidden" class="form-control" value="father">
                                    <input name="g_gender[]" type="hidden" class="form-control" value="Male">
                                    <input name="g_id[]" type="hidden" class="form-control" value="<?php echo $guardians['father']->id; ?>">
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <?php if (isset($values['Father\'s Information'][29])) { ?>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                                    </div>
                                                    <div class="col-lg-10 row3Field">
                                                        <input name="g_name[]" type="text" class="form-control" placeholder="Full Name" value="<?php echo $guardians['father']->name; ?>" <?php echo (($values['Father\'s Information'][29]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_name_bn[]" type="text" class="form-control" placeholder="Full Name (in Bangla)" value="<?php echo $guardians['father']->name_bn; ?>" <?php echo (($values['Father\'s Information'][30]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_mobile[]" type="text" class="form-control" placeholder="Mobile No." value="<?php echo $guardians['father']->mobile; ?>" <?php echo (($values['Father\'s Information'][35]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_nid[]" type="text" class="form-control" placeholder="NID No." value="<?php echo $guardians['father']->nid; ?>" <?php echo (($values['Father\'s Information'][36]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_birth_reg[]" type="text" class="form-control" placeholder="Birth Registration No." value="<?php echo $guardians['father']->birth_reg; ?>" <?php echo (($values['Father\'s Information'][37]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_occupation[]" type="text" class="form-control" placeholder="Occupation" value="<?php echo $guardians['father']->occupation; ?>" <?php echo (($values['Father\'s Information'][33]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_income[]" type="text" class="form-control" placeholder="Monthly Income" value="<?php echo $guardians['father']->yearly_income; ?>" <?php echo (($values['Father\'s Information'][38]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_nationality[]" type="text" class="form-control" placeholder="Nationality" value="<?php echo $guardians['father']->nationality; ?>" <?php echo (($values['Father\'s Information'][32]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                        <option value="Islam" <?php if ($guardians['father']->religion == 'Islam') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'Islam') ?></option>
                                                        <option value="Hindu" <?php if ($guardians['father']->religion == 'Hindu') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'Hindu') ?></option>
                                                        <option value="Christian" <?php if ($guardians['father']->religion == 'Christian') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Christian') ?></option>
                                                        <option value="Buddhist" <?php if ($guardians['father']->religion == 'Buddhist') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Buddhist') ?></option>
                                                        <option value="Others" <?php if ($guardians['father']->religion == 'Other') {
                                                                                    echo 'selected';
                                                                                } ?>><?= __d('students', 'Others') ?></option>
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
                                    <input name="g_id[]" type="hidden" class="form-control" value="<?php echo $guardians['mother']->id; ?>">
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <?php if (isset($values['Mother\'s Information'][29])) { ?>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                                    </div>
                                                    <div class="col-lg-10 row3Field">
                                                        <input name="g_name[]" type="text" class="form-control" placeholder="Full Name" value="<?php echo $guardians['mother']->name; ?>" <?php echo (($values['Mother\'s Information'][29]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_name_bn[]" type="text" class="form-control" placeholder="Full Name (in Bangla)" value="<?php echo $guardians['mother']->name_bn; ?>" <?php echo (($values['Mother\'s Information'][30]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_mobile[]" type="text" class="form-control" placeholder="Mobile No." value="<?php echo $guardians['mother']->mobile; ?>" <?php echo (($values['Mother\'s Information'][35]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_nid[]" type="text" class="form-control" placeholder="NID No." value="<?php echo $guardians['mother']->nid; ?>" <?php echo (($values['Mother\'s Information'][36]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_birth_reg[]" type="text" class="form-control" placeholder="Birth Registration No." value="<?php echo $guardians['mother']->birth_reg; ?>" <?php echo (($values['Mother\'s Information'][37]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_occupation[]" type="text" class="form-control" placeholder="Occupation" value="<?php echo $guardians['mother']->occupation; ?>" <?php echo (($values['Mother\'s Information'][33]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_income[]" type="text" class="form-control" placeholder="Monthly Income" value="<?php echo $guardians['mother']->yearly_income; ?>" <?php echo (($values['Mother\'s Information'][38]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_nationality[]" type="text" class="form-control" placeholder="Nationality" value="<?php echo $guardians['mother']->nationality; ?>" <?php echo (($values['Mother\'s Information'][32]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                            <option value="Islam" <?php if ($guardians['mother']->religion == 'Islam') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Islam') ?></option>
                                                            <option value="Hindu" <?php if ($guardians['mother']->religion == 'Hindu') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Hindu') ?></option>
                                                            <option value="Christian" <?php if ($guardians['mother']->religion == 'Christian') {
                                                                                            echo 'selected';
                                                                                        } ?>><?= __d('students', 'Christian') ?></option>
                                                            <option value="Buddhist" <?php if ($guardians['mother']->religion == 'Buddhist') {
                                                                                            echo 'selected';
                                                                                        } ?>><?= __d('students', 'Buddhist') ?></option>
                                                            <option value="Others" <?php if ($guardians['mother']->religion == 'Other') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Others') ?></option>
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



                    <?php if (isset($values['Active Guardian'])) { //pr($values);die;
                    ?>
                        <section class="bg-light mt-3 p-4 m-auto" action="#">
                            <fieldset>
                                <legend class=" mb-4"><?= __d('students', $values['Active Guardian'][29]['heading']) ?></legend>
                                <div class="form_area p-3">
                                    <input name="g_relation[]" type="hidden" class="form-control" value="other">
                                    <input name="g_gender[]" type="hidden" class="form-control" value="Male">
                                    <input name="g_id[]" type="hidden" class="form-control" value="<?php echo $guardians['other']->id; ?>">
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <?php if (isset($values['Active Guardian'][29])) { ?>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <p class="label-font13"><?= __d('students', 'Name') ?></p>
                                                    </div>
                                                    <div class="col-lg-10 row3Field">
                                                        <input name="g_name[]" type="text" class="form-control" placeholder="Full Name" value="<?php echo $guardians['other']->name; ?>" <?php echo (($values['Active Guardian'][29]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_name_bn[]" type="text" class="form-control" placeholder="Full Name (in Bangla)" value="<?php echo $guardians['other']->name_bn; ?>" <?php echo (($values['Active Guardian'][30]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_mobile[]" type="text" class="form-control" placeholder="Mobile No." value="<?php echo $guardians['other']->mobile; ?>" <?php echo (($values['Active Guardian'][35]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_nid[]" type="text" class="form-control" placeholder="NID No." value="<?php echo $guardians['other']->nid; ?>" <?php echo (($values['Active Guardian'][36]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_birth_reg[]" type="text" class="form-control" placeholder="Birth Registration No." value="<?php echo $guardians['other']->birth_reg; ?>" <?php echo (($values['Active Guardian'][37]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_occupation[]" type="text" class="form-control" placeholder="Occupation" value="<?php echo $guardians['other']->occupation; ?>" <?php echo (($values['Active Guardian'][33]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_income[]" type="text" class="form-control" placeholder="Monthly Income" value="<?php echo $guardians['other']->yearly_income; ?>" <?php echo (($values['Active Guardian'][38]['required']) == 1) ? 'required' : ''; ?>>
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
                                                        <input name="g_nationality[]" type="text" class="form-control" placeholder="Nationality" value="<?php echo $guardians['other']->nationality; ?>" <?php echo (($values['Active Guardian'][32]['required']) == 1) ? 'required' : ''; ?>>
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
                                                            <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                            <option value="Islam" <?php if ($guardians['other']->religion == 'Islam') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Islam') ?></option>
                                                            <option value="Hindu" <?php if ($guardians['other']->religion == 'Hindu') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Hindu') ?></option>
                                                            <option value="Christian" <?php if ($guardians['other']->religion == 'Christian') {
                                                                                            echo 'selected';
                                                                                        } ?>><?= __d('students', 'Christian') ?></option>
                                                            <option value="Buddhist" <?php if ($guardians['other']->religion == 'Buddhist') {
                                                                                            echo 'selected';
                                                                                        } ?>><?= __d('students', 'Buddhist') ?></option>
                                                            <option value="Others" <?php if ($guardians['other']->religion == 'Other') {
                                                                                        echo 'selected';
                                                                                    } ?>><?= __d('students', 'Others') ?></option>
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



                    <div class="row active_guardian mt-5">
                        <div class="col-lg-6 dropdown">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font"><?= __d('students', 'Active Guardian') ?></p>
                                </div>
                                <div class=" col-lg-6 row2Field">
                                    <select class="bg-warning form-control" name="active_guardian" required>
                                        <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                        <option value="Father" <?php if ($student->active_guardian == 'Father') {
                                                                    echo 'selected';
                                                                } ?>><?= __d('students', 'Father') ?></option>
                                        <option value="Mother" <?php if ($student->active_guardian == 'Mother') {
                                                                    echo 'selected';
                                                                } ?>><?= __d('students', 'Mother') ?></option>
                                        <option value="Other" <?php if ($student->active_guardian == 'Other') {
                                                                    echo 'selected';
                                                                } ?>><?= __d('students', 'Other') ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
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
        $('.add_education').append(form);
    });
    $('.form').on('click', '#delete', function(eq) {
        $(this).closest('#single_row').remove();
    });
    $('.add_education').on('click', '#delete', function(eq) {
        alert("Are you sure, You want remove this?");
        $(this).closest('#education_block').remove();
    });
    $('.add_education1').on('click', '#delete', function(eq) {
        alert("Are you sure, You want remove this?");
        $(this).closest('#education_block').remove();
    });

    $("#level_id").change(function() {
        getSectionAjax();
        getReligionSubjectAjax();

        var element1 = document.getElementById("group_id");
        var level_id = $("#level_id").val();
        if (level_id == 9 || level_id == 10) {
            getGroupAjax();
            element1.setAttribute('required', true);
        } else {
            element1.removeAttribute('required');
            var text1 = '<option value="">-- Choose --</option>';
            $('#group_id').html(text1);
        }
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
        getThirdForthAjax();
        var group_id = $("#group_id").val();
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
