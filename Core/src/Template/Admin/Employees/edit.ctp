<?php

$this->Form->unlockField('name');
$this->Form->unlockField('name_bn');
$this->Form->unlockField('mobile');
$this->Form->unlockField('email');
$this->Form->unlockField('date_of_birth');
$this->Form->unlockField('national_id');
$this->Form->unlockField('image_name');
$this->Form->unlockField('father_name');
$this->Form->unlockField('father_name_bn');
$this->Form->unlockField('permanent_address');
$this->Form->unlockField('present_address');
$this->Form->unlockField('gender');
$this->Form->unlockField('religion');
$this->Form->unlockField('blood_group');
$this->Form->unlockField('marital_status');
$this->Form->unlockField('nationality');
$this->Form->unlockField('hobby');
$this->Form->unlockField('employees_designation_id');
$this->Form->unlockField('join_date');
$this->Form->unlockField('mpo_date');
$this->Form->unlockField('role_id');
$this->Form->unlockField('join_as');
$this->Form->unlockField('job_institute');
$this->Form->unlockField('end_date');
$this->Form->unlockField('employee_order');
$this->Form->unlockField('training');
$this->Form->unlockField('username');
$this->Form->unlockField('password');
$this->Form->unlockField('confirm');
$this->Form->unlockField('status');
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
$this->Form->unlockField('qualification_id');
$this->Form->unlockField('rf_id');
$this->Form->unlockField('featured');

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Employee Registration Form</title>
</head>

<body>
    <div class="container  mt-5 mb-5">
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
        <div class="form-border">

            <section class="bg-light  p-4 m-auto" action="#">
                <div class="form_area p-3">

                    <div class="header">
                        <h1 class="h1 text-center mb-5" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;"><?= __d('employees', 'Employee Registration Form') ?>
                        </h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'Full Name') ?></p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="name" type="text" class="form-control" placeholder="Full Name" value="<?php echo $employees['name']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'Full Name <br>(in Bangla)') ?></p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="name_bn" type="text" class="form-control" placeholder="Full Name (in Bangla)" value="<?php echo $employees['name_bn']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p><?= __d('employees', 'Mobile No.') ?></p>
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <input name="mobile" type="tel" class="form-control" placeholder="Mobile no" value="<?php echo $employees['mobile']; ?>">

                                </div>
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'Email') ?></p>
                                </div>
                                <div class="col-lg-4">
                                    <input name="email" type="text" class="form-control" placeholder="Email address" value="<?php echo $employees['email']; ?>">
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'Date of Birth') ?></p>
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <input name="date_of_birth" type="date" class="form-control" value="<?php echo $employees['date_of_birth']; ?>">

                                </div>
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'National ID') ?></p>
                                </div>
                                <div class="col-lg-4">
                                    <input name="national_id" type="tel" class="form-control" placeholder="National ID" value="<?php echo $employees['national_id']; ?>">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="center">
                                <div class="avatar-wrapper" id="avatar">
                                    <?php echo $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $employees['image_name'], ['class' => 'profile-pic']); ?>
                                    <div class="upload-button">
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"><?= __d('employees', 'Uplaoad') ?></i>
                                    </div>
                                    <?php echo $this->form->file('image_name', ['class' => 'file-upload']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', "Father's Name") ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="father_name" type="text" class="form-control" placeholder="Father's Name" value="<?php echo $employees['father_name']; ?>">
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', "Father's Name(Bangla)") ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">

                                        <input name="father_name_bn" type="text" class="form-control" placeholder="Father's Name(in Bangla)" value="<?php echo $employees['father_name_bn']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Permanent Address<') ?>/p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <textarea name="permanent_address" class="form-control" rows="2" placeholder="Permanent Address"> <?php echo $employees['permanent_address']; ?></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Present Address') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <textarea name="present_address" class="form-control" rows="2" placeholder="Present Address"><?php echo $employees['present_address']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Gender') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select name="gender" class="form-control">
                                            <option class="text-center" value=""><?= __d('employees', '-- Choose --') ?></option>
                                            <option value="Male" <?php if ($employees['gender'] == "Male") {
                                                                        echo 'selected';
                                                                    } ?>><?= __d('employees', 'Male') ?></option>
                                            <option value="Female" <?php if ($employees['gender'] == "Female") {
                                                                        echo 'selected';
                                                                    } ?>><?= __d('employees', 'Female') ?></option>
                                            <option value="Others" <?php if ($employees['gender'] == "Others") {
                                                                        echo 'selected';
                                                                    } ?>><?= __d('employees', 'Others') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Religion') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select name="religion" class="form-control">
                                            <option class="text-center" value=""><?= __d('employees', '-- Choose --') ?></option>
                                            <option value="Muslim" <?php if ($employees['religion'] == "Muslim") {
                                                                        echo 'selected';
                                                                    } ?>><?= __d('employees', 'Muslim') ?></option>
                                            <option value="Hindu" <?php if ($employees['religion'] == "Hindu") {
                                                                        echo 'selected';
                                                                    } ?>><?= __d('employees', 'Hindu') ?></option>
                                            <option value="Christian" <?php if ($employees['religion'] == "Christian") {
                                                                            echo 'selected';
                                                                        } ?>><?= __d('employees', 'Christian') ?></option>
                                            <option value="Buddhist" <?php if ($employees['religion'] == "Buddhist") {
                                                                            echo 'selected';
                                                                        } ?>><?= __d('employees', 'Buddhist') ?></option>
                                            <option value="Others" <?php if ($employees['religion'] == "Others") {
                                                                        echo 'selected';
                                                                    } ?>><?= __d('employees', 'Others') ?></option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Blood Group') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select name="blood_group" class="form-control">
                                            <option class="text-center" value=""><?= __d('employees', '-- Choose --') ?></option>
                                            <option value="A+" <?php if ($employees['blood_group'] == "A+") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'A(+ve) Positive') ?></option>
                                            <option value="A-" <?php if ($employees['blood_group'] == "A-") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'A(-ve) Negative') ?></option>
                                            <option value="B+" <?php if ($employees['blood_group'] == "B+") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'B(+ve) Positive') ?></option>
                                            <option value="B-" <?php if ($employees['blood_group'] == "B-") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'B(-ve) Negative') ?></option>
                                            <option value="O+" <?php if ($employees['blood_group'] == "O+") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'O(+ve) Positive') ?></option>
                                            <option value="O-" <?php if ($employees['blood_group'] == "O-") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'O(-ve) Negative') ?></option>
                                            <option value="AB+" <?php if ($employees['blood_group'] == "AB+") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'AB(+ve) Positive') ?></option>
                                            <option value="AB-" <?php if ($employees['blood_group'] == "AB-") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'AB(-ve) Negative') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Marital Status') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select name="marital_status" class="form-control">
                                            <option class="text-center" value=""><?= __d('employees', '-- Choose --') ?></option>
                                            <option value="Married" <?php if ($employees['marital_status'] == "Married") {
                                                                        echo 'selected';
                                                                    } ?>><?= __d('employees', 'Married') ?></option>
                                            <option value="Unmarried" <?php if ($employees['marital_status'] == "Unmarried") {
                                                                            echo 'selected';
                                                                        } ?>><?= __d('employees', 'Unmarried') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Nationality') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="nationality" type="text" class="form-control" placeholder="Nationality" value="<?php echo $employees['nationality']; ?>">
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Hobby') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="hobby" type="text" class="form-control" placeholder="Hobby" value="<?php echo $employees['hobby']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'RFID') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="rf_id" type="text" class="form-control" value="<?php echo $employees['rf_id']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Featured') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <select name="featured" class="form-control">
                                            <option class="text-center" value=""><?= __d('employees', '-- Choose --') ?></option>
                                            <option value="1" <?php if ($employees['featured'] == "1") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'Yes') ?></option>
                                            <option value="0" <?php if ($employees['featured'] == "0") {
                                                                    echo 'selected';
                                                                } ?>><?= __d('employees', 'No') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- EMPLOYEMENT INFORMATION -->


            <section class="bg-light mt-3 p-4 m-auto" action="#">
                <fieldset>
                    <legend class=" mb-4"><?= __d('employees', 'Employment Information') ?></legend>
                    <div class="form_area p-3">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="label-font13"><?= __d('employees', 'Designation') ?></p>
                                    </div>
                                    <div class="col-lg-10 ">
                                        <select id="inputStateID" class="form-select" name="employees_designation_id">
                                            <?php foreach ($designations as $designation) { ?>
                                                <option class="option-select" value="<?php echo $designation['id']; ?>" <?php if ($designation['id'] == $employees['employees_designation_id']) {
                                                                                                                            echo 'selected';
                                                                                                                        } ?>><?php echo $designation['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'Joining Date') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <input name="join_date" type="date" class="form-control" value="<?php echo $employees['join_date']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'MPO Date<br>(If Any)') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <input name="mpo_date" type="date" class="form-control" value="<?php echo $employees['mpo_date']; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'Employee Role') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <select id="inputStateID" class="form-select" name="role_id">
                                            <option class="option-select" value=""><?= __d('employees', '-- Choose --') ?></option>
                                            <?php foreach ($roles as $role) { ?>
                                                <option value="<?php echo $role['id']; ?>" <?php if ($role['id'] == $users['role_id']) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                    <?php echo $role['title']; ?></option><?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="label-font13"><?= __d('employees', 'Join As:') ?></p>
                                    </div>
                                    <div class="col-lg-10 row2Field">
                                        <input name="join_as" type="text" class="form-control" placeholder="Joined As" value="<?php echo $employees['join_as']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="label-font13"><?= __d('employees', 'Institute') ?></p>
                                    </div>
                                    <div class="col-lg-10 row2Field">
                                        <input name="job_institute" type="text" class="form-control" placeholder="Institute name" value="<?php echo $employees['job_institute']; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="label-font13"><?= __d('employees', 'Training') ?></p>
                                    </div>
                                    <div class="col-lg-10 row2Field">
                                        <input name="training" type="text" class="form-control" placeholder="Training" value="<?php echo $employees['training']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'Order') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <input name="employee_order" type="text" class="form-control" placeholder="Order" value="<?php echo $employees['employee_order']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'End Date') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <input name="end_date" type="date" class="form-control" value="<?php echo $employees['end_date']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </section>


            <section class="bg-light mt-3 p-4 m-auto" action="#">
                <fieldset>
                    <legend class=" mb-4"><?= __d('employees', 'Educational Information') ?><button type="button" class="eduAdd btn btn-info float-right">Add</button></legend>
                    <div class="add_education1">
                        <?php foreach ($educations as $key => $education) { ?>
                            <input type="hidden" name="qualification_id[]" value="<?php echo $education['qualification_id']; ?>">
                            <div class="education_block form_area p-3 mb-2" id="education_block">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('employees', 'Exam Name') ?></p>
                                            </div>
                                            <div class="col-lg-10 row3Field">
                                                <input name="exam_name[]" type="text" class="form-control" value="<?php echo $education['exam_name']; ?>" placeholder="Name of Exam">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('employees', 'Board') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_board[]" type="text" class="form-control" value="<?php echo $education['exam_board']; ?>" placeholder="Exam Board">
                                            </div>
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('employees', 'Session') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="exam_session[]" type="text" class="form-control" value="<?php echo $education['exam_session']; ?>" placeholder=" Exam Session">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('employees', 'Roll No.') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="exam_roll[]" type="text" class="form-control" value="<?php echo $education['exam_roll']; ?>" placeholder="Exam Roll No.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('employees', 'Registration No.') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="exam_registration[]" type="text" class="form-control" value="<?php echo $education['exam_registration']; ?>" placeholder="Registration No.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('employees', 'Institute') ?></p>
                                            </div>
                                            <div class="col-lg-10 row2Field">
                                                <input name="institute[]" type="text" class="form-control" value="<?php echo $education['institute']; ?>" placeholder="Institute Name">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('employees', 'Grade') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="grade[]" type="text" class="form-control" value="<?php echo $education['grade']; ?>" placeholder="Grade">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('employees', 'Group') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="group_name[]" type="text" class="form-control" value="<?php echo $education['group_name']; ?>" placeholder="Group">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('employees', 'GPA') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="gpa[]" type="text" class="form-control" value="<?php echo $education['gpa']; ?>" placeholder="GPA">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="label-font13"><?= __d('employees', 'Passing Year:') ?></p>
                                            </div>
                                            <div class="col-lg-8 row2Field">
                                                <input name="passing_year[]" type="text" class="form-control" value="<?php echo $education['passing_year']; ?>" placeholder="Passing Year">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <button id="delete" class=" btn btn-danger" type="button"><?= __d('employees', 'Remove') ?></button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="add_education">
                        <div class="">
                            <div class="education ">
                                <div class="education_block form_area p-3 mb-2" id="education_block">
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('employees', 'Exam Name') ?></p>
                                                </div>
                                                <div class="col-lg-10 row3Field">
                                                    <input name="exam_name[]" type="text" class="form-control" placeholder="Name of Exam">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('employees', 'Board') ?></p>
                                                </div>
                                                <div class="col-lg-4 row2Field">
                                                    <input name="exam_board[]" type="text" class="form-control" placeholder="Exam Board">
                                                </div>
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('employees', 'Session') ?></p>
                                                </div>
                                                <div class="col-lg-4 row2Field">
                                                    <input name="exam_session[]" type="text" class="form-control" placeholder=" Exam Session">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <p class="label-font13"><?= __d('employees', 'Roll No.') ?></p>
                                                </div>
                                                <div class="col-lg-9 row2Field">
                                                    <input name="exam_roll[]" type="text" class="form-control" placeholder="Exam Roll No.">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('employees', 'Registration No.') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="exam_registration[]" type="text" class="form-control" placeholder="Registration No.">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="label-font13"><?= __d('employees', 'Institute') ?></p>
                                                </div>
                                                <div class="col-lg-10 row2Field">
                                                    <input name="institute[]" type="text" class="form-control" placeholder="Institute Name">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <p class="label-font13"><?= __d('employees', 'Grade') ?></p>
                                                </div>
                                                <div class="col-lg-9 row2Field">
                                                    <input name="grade[]" type="text" class="form-control" placeholder="Grade">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('employees', 'Group') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="group_name[]" type="text" class="form-control" placeholder="Group">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('employees', 'GPA') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="gpa[]" type="text" class="form-control" placeholder="GPA">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <p class="label-font13"><?= __d('employees', 'Passing Year:') ?></p>
                                                </div>
                                                <div class="col-lg-8 row2Field">
                                                    <input name="passing_year[]" type="text" class="form-control" placeholder="Passing Year">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <button id="delete" class=" btn btn-danger" type="button"><?= __d('employees', 'Remove') ?></button>
                                        <span class="remove_edu text-center ml-5 p-2" style=" background: yellow; color: red; font-weight: 500; border: 1px solid black "> <?= __d('employees', 'Click "Remove", If not Applicable!') ?></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </section>

            <div class="col-lg-4 dropdown mt-5">
                <div class="row">
                    <div class="col-lg-3">
                        <p class="label-font"><?= __d('employees', 'Status') ?></p>
                    </div>
                    <div class=" col-lg-9 row2Field">
                        <select name="status" class="bg-warning form-control" required>
                            <option class="text-center" value=""><?= __d('employees', '-- Choose --') ?></option>

                            <option value="1" <?php if ($employees['status'] == "1") {
                                                    echo 'selected';
                                                } ?>><?= __d('employees', 'Active') ?></option>
                            <option value="0" <?php if ($employees['status'] == "0") {
                                                    echo 'selected';
                                                } ?>><?= __d('employees', 'Deactivated') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-lg btn-info text-white btn-right" type="submit"><?= __d('employees', 'Submit Application') ?></button>
                <?php echo $this->Html->Link('Back', ['action' => 'index'], ['class' => 'btn btn-lg btn-sucess']); ?>
            </div>

        </div>
        <?php echo $this->Form->end(); ?>
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

    // Education Field Add

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
    })

    function onChange() {
        const password = document.querySelector('#password');
        const confirm = document.querySelector('#confirm_password');
        if (confirm.value === password.value) {
            confirm.setCustomValidity('');
        } else {
            confirm.setCustomValidity('Password not matching!');
        }
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.querySelector(".file-upload");
        const allowedExtensions = [".jpg", ".jpeg", ".png"]; // Define your allowed extensions here

        fileInput.addEventListener("change", function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                const fileName = selectedFile.name;
                const fileExtension = fileName.slice(((fileName.lastIndexOf(".") - 1) >>> 0) + 2); // Extract the file extension

                if (!allowedExtensions.includes("." + fileExtension.toLowerCase())) {
                    alert("Unsupported file format. Please upload a JPEG, JPG or PNG image.");
                    fileInput.value = ""; // Clear the input field
                }
            }
        });
    });
</script>
