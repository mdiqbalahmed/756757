
<?php
//pr($students[0]);die;
$this->Form->unlockField('id');
$this->Form->unlockField('name');
$this->Form->unlockField('bn_name');
$this->Form->unlockField('bn_fname');
$this->Form->unlockField('bn_mname');
$this->Form->unlockField('gender');
$this->Form->unlockField('mobile');
$this->Form->unlockField('fname');
$this->Form->unlockField('foccupation_type');
$this->Form->unlockField('f_nid');
$this->Form->unlockField('image_name');
$this->Form->unlockField('foccupation');
$this->Form->unlockField('fincome');
$this->Form->unlockField('fmobile');
$this->Form->unlockField('mname');
$this->Form->unlockField('nid');
$this->Form->unlockField('m_nid');
$this->Form->unlockField('moccupation_type');
$this->Form->unlockField('moccupation');
$this->Form->unlockField('present_address');
$this->Form->unlockField('mincome');
$this->Form->unlockField('mmobile');
$this->Form->unlockField('dob');
$this->Form->unlockField('birth_reg');
$this->Form->unlockField('nationality');
$this->Form->unlockField('blood');
$this->Form->unlockField('religion');

$this->Form->unlockField('permanent_address');
$this->Form->unlockField('current_address');
$this->Form->unlockField('pre_school');

//Educational Information table => "scms_qualification"
$this->Form->unlockField('exam_name');
$this->Form->unlockField('exam_board');
$this->Form->unlockField('passing_year');
$this->Form->unlockField('exam_roll');
$this->Form->unlockField('exam_gpa');
$this->Form->unlockField('exam_reg');
$this->Form->unlockField('sub_4th');
$this->Form->unlockField('sub_3rd');
$this->Form->unlockField('group');
$this->Form->unlockField('session');

//Father Information table => "scms_qualification"
$this->Form->unlockField('quota');
$this->Form->unlockField('shift');
$this->Form->unlockField('roll');
$this->Form->unlockField('level');
$this->Form->unlockField('section');
$this->Form->unlockField('class_roll');
$this->Form->unlockField('thumbnail');
$this->Form->unlockField('status');
$this->Form->unlockField('student_status');
$this->Form->unlockField('scholarship');
$this->Form->unlockField('stipend');

$this->Form->unlockField('stipend_id');
$this->Form->unlockField('stipend_account');

?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <title>Student Admission Form</title>
    </head>

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
                                    <div class="col-lg-2">
                                        <p class="label-font"><?= __d('students', 'Full Name<br>(in English)') ?> </p>
                                    </div>
                                    <div class="col-lg-10">
                                        <!--<input name="name" type="text" class="form-control" placeholder="Full Name (in English)" >-->
                                        <input name="name" type="text" class="form-control" value="<?php echo $stu->name; ?>" placeholder="Full Name" readonly="true">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2">
                                        <p class="label-font"><?= __d('students', 'Full Name<br>(in Bangla)') ?> </p>
                                    </div>
                                    <div class="col-lg-10">
                                        <input name="bn_name" type="text" class="form-control" placeholder="Full Name (in Bangla)" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2">
                                        <p><?= __d('students', 'Mobile No.') ?></p>
                                    </div>
                                    <div class="col-lg-4 d-flex">
                                        <input name="mobile" type="tel" class="form-control" placeholder="Mobile no" >

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
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font"><?= __d('students', 'NID No.') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="nid" type="tel" class="form-control" placeholder="NID number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font"><?= __d('students', 'Birth Registration') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="birth_reg" type="tel" class="form-control" placeholder="Birth Registration number" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font"><?= __d('students', 'Permanent Address') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <textarea name="permanent_address" class="form-control" rows="2" placeholder="Permanent Address" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font"><?= __d('students', 'Present Address') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <textarea name="present_address" class="form-control" rows="2" placeholder="Present Address" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font"><?= __d('students', 'Gender') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="gender" >
                                                <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                <option value="Male"><?= __d('students', 'Male') ?></option>
                                                <option value="Female"><?= __d('students', 'Female') ?></option>
                                                <option value="Others"><?= __d('students', 'Others') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font"><?= __d('students', 'Religion') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="religion">
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
                    </div>
                </section>

                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', "Father's Information") ?></legend>
                        <div class="form_area p-3">
                            <div class="row mb-3">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <p class="label-font13"><?= __d('students', 'Father\'s Name(Bangla)') ?></p>
                                        </div>
                                        <div class="col-lg-10 row3Field">
                                            <input name="bn_fname" type="text" class="form-control" placeholder="Full Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <p class="label-font13"><?= __d('students', 'Father\'s Name(English)') ?></p>
                                        </div>
                                        <div class="col-lg-10 row3Field">
                                            <input name="fname" type="text" class="form-control" placeholder="Full Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Father Mobile') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="fmobile" type="text" class="form-control" placeholder="Mobile No.">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Father NID No.') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="f_nid" type="text" class="form-control" placeholder="NID No." >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="label-font13"><?= __d('students', 'Father Occupation') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="foccupation" type="text" class="form-control" placeholder="Occupation" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="label-font13"><?= __d('students', 'Father Occupation Type') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="foccupation_type">
                                                <option value="Govt"><?= __d('students', 'Govt') ?></option>
                                                <option value="Non Govt"><?= __d('students', 'Non Govt') ?></option>
                                                <option value="Others"><?= __d('students', 'Others') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Father Monthly Income') ?> </p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="fincome" type="text" class="form-control" placeholder="Monthly Income" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </section>

                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', "Mother's Information") ?></legend>
                        <div class="form_area p-3">
                            <div class="row mb-3">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <p class="label-font13"><?= __d('students', 'Mother\'s Name(Bangla)') ?></p>
                                        </div>
                                        <div class="col-lg-10 row3Field">
                                            <input name="bn_mname" type="text" class="form-control" placeholder="Full Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <p class="label-font13"><?= __d('students', 'Mother\'s Name(English)') ?></p>
                                        </div>
                                        <div class="col-lg-10 row3Field">
                                            <input name="mname" type="text" class="form-control" placeholder="Full Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Mother Mobile') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="mmobile" type="text" class="form-control" placeholder="Mobile No.">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Mother NID No.') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="m_nid" type="text" class="form-control" placeholder="NID No." >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="label-font13"><?= __d('students', 'Mother Occupation') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="moccupation" type="text" class="form-control" placeholder="Occupation" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="label-font13"><?= __d('students', 'Father Occupation') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="moccupation_type">
                                                <option value="Govt"><?= __d('students', 'Govt') ?></option>
                                                <option value="Non Govt"><?= __d('students', 'Non Govt') ?></option>
                                                <option value="Others"><?= __d('students', 'Others') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Mother Monthly Income') ?> </p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="mincome" type="text" class="form-control" placeholder="Monthly Income" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </section>




                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <div class="education">
                            <div class="education_block form_area p-3 mb-2" id="education_block">
<!--                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Exam Name') ?></p>
                                            </div>
                                            <div class="col-lg-10 row3Field">
                                                <input name="exam_name[]" type="text" class="form-control" placeholder="Full Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Board') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_board[]" type="text" class="form-control" placeholder="Exam Board" >
                                            </div>
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_session[]" type="text" class="form-control" placeholder=" Exam Session" >
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
<!--                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Roll No.') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="exam_roll[]" type="text" class="form-control" placeholder="Exam Roll No." >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('students', 'Registration No.') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="exam_reg[]" type="text" class="form-control" placeholder="Registration No." >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Institute') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="prev_school[]" type="text" class="form-control" placeholder="Institute Name" >
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="row mb-3">

                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('students', 'Previous School') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="pre_school" type="text" class="form-control" placeholder="Previous School" >
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('students', 'GPA') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="exam_gpa[]" type="text" class="form-control" placeholder="GPA" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('students', 'Passing Year') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="passing_year[]" type="text" class="form-control" placeholder="Exam Session" >
                                            </div>
                                        </div>
                                    </div>-->
                                </div>

                            </div>

                        </div>
                    </fieldset>
                </section>

                <!-- Added Name Till EDUCATION FIELD -->



                <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', "Admission Information") ?></legend>
                        <div class="form_area p-3">


                            <div class="row mb-3">

                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Session') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <input name="session" type="text" class="form-control" value="2023" placeholder="Session" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Shift') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <input name="shift" type="text" class="form-control" value="<?php echo $stu->shift; ?>" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Class') ?></p>
                                        </div>

                                        <div class="col-lg-9 row2Field">
                                            <input name="level" type="text" class="form-control" value="<?php echo $stu->level; ?>" readonly="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

<!--                            <div class="row mb-3">

                                <div class="col-lg-4">
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
                                </div>


                            </div>-->
                            <div class="row mb-3">

                                <div class="col-lg-4">
                                    

                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2">
                                        <p class="label-font"><?= __d('students', 'Quota') ?> </p>
                                    </div>
                                    <div class="col-lg-10">
                                        <!--<input name="name" type="text" class="form-control" placeholder="Full Name (in English)" >-->
                                        <input name="quota" type="text" class="form-control" value="<?php echo $stu->quota; ?>" placeholder="Quota" readonly="true">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p class="label-font13"><?= __d('students', 'Status') ?></p>
                                        </div>
                                        <div class="col-lg-9 row2Field">
                                            <select class="form-control" name="status">
                                                <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                                <option value="1"><?= __d('students', 'Active') ?></option>
                                                <option value="0"><?= __d('students', 'In-Active') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">

                                </div>

                            </div>

                        </div>
                    </fieldset>
                </section>
                <div class="mt-5">
                    <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
                            <?php echo $this->Form->end(); ?>
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
           if(level_id ==9 || level_id ==10 ){
              element1.setAttribute('required', true);
           }else{
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
        if(group_id ==''){
             element1.removeAttribute('required');
             element2.removeAttribute('required');  
        }else{
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
</script>


