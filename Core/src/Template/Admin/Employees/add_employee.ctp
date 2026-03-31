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
$this->Form->unlockField('training_title');
$this->Form->unlockField('duration');
$this->Form->unlockField('attend_year');
$this->Form->unlockField('achievement');
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
                                    <input name="name" type="text" class="form-control" placeholder="Full Name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'Full Name <br>(in Bangla)') ?></p>
                                </div>
                                <div class="col-lg-10">
                                    <input name="name_bn" type="text" class="form-control" placeholder="Full Name (in Bangla)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p><?= __d('employees', 'Mobile No.') ?></p>
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <input name="mobile" type="tel" class="form-control" placeholder="Mobile no">

                                </div>
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'Email') ?></p>
                                </div>
                                <div class="col-lg-4">
                                    <input name="email" type="text" class="form-control" placeholder="Email address">
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'Date of Birth') ?></p>
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <input name="date_of_birth" type="date" class="form-control">

                                </div>
                                <div class="col-lg-2">
                                    <p class="label-font"><?= __d('employees', 'National ID') ?></p>
                                </div>
                                <div class="col-lg-4">
                                    <input name="national_id" type="tel" class="form-control" placeholder="National ID">
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="center">
                                <div class="avatar-wrapper" id="avatar">
                                    <img class="profile-pic" src="" />
                                    <div class="upload-button">
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"><?= __d('employees', 'Uplaoad') ?></i>
                                    </div>
                                    <input name="image_name" class="file-upload" type="file" accept="image/*" />
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
                                        <input name="father_name" type="text" class="form-control" placeholder="Father's Name">
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', "Father's Name(Bangla)") ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">

                                        <input name="father_name_bn" type="text" class="form-control" placeholder="Father's Name(in Bangla)">
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
                                        <textarea name="permanent_address" class="form-control" rows="2" placeholder="Permanent Address"></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Present Address') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <textarea name="present_address" class="form-control" rows="2" placeholder="Present Address"></textarea>
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
                                            <option value="Male"><?= __d('employees', 'Male') ?></option>
                                            <option value="Female"><?= __d('employees', 'Female') ?></option>
                                            <option value="Others"><?= __d('employees', 'Others') ?></option>
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
                                            <option value="Muslim"><?= __d('employees', 'Muslim') ?></option>
                                            <option value="Hindu"><?= __d('employees', 'Hindu') ?></option>
                                            <option value="Christian"><?= __d('employees', 'Christian') ?></option>
                                            <option value="Buddhist"><?= __d('employees', 'Buddhist') ?></option>
                                            <option value="Others"><?= __d('employees', 'Others') ?></option>
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
                                            <option value="A+"><?= __d('employees', 'A(+ve) Positive') ?></option>
                                            <option value="A-"><?= __d('employees', 'A(-ve) Negative') ?></option>
                                            <option value="B+"><?= __d('employees', 'B(+ve) Positive') ?></option>
                                            <option value="B-"><?= __d('employees', 'B(-ve) Negative') ?></option>
                                            <option value="O+"><?= __d('employees', 'O(+ve) Positive') ?></option>
                                            <option value="O-"><?= __d('employees', 'O(-ve) Negative') ?></option>
                                            <option value="AB+"><?= __d('employees', 'AB(+ve) Positive') ?></option>
                                            <option value="AB-"><?= __d('employees', 'AB(-ve) Negative') ?></option>
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
                                            <option value="Married"><?= __d('employees', 'Married') ?></option>
                                            <option value="Unmarried"><?= __d('employees', 'Unmarried') ?></option>
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
                                        <input name="nationality" type="text" class="form-control" placeholder="Nationality">
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font"><?= __d('employees', 'Hobby') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input name="hobby" type="text" class="form-control" placeholder="Hobby">
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
                                        <input name="rf_id" type="text" class="form-control" placeholder="">
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
                                            <option value="1"><?= __d('employees', 'Yes') ?></option>
                                            <option value="0"><?= __d('employees', 'No') ?></option>
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
                                        <select id="inputStateID" class="form-select" name="employees_designation_id" required>
                                            <option class="option-select" value=""><?= __d('employees', '-- Choose --') ?></option>
                                            <?php foreach ($designations as $designation) { ?>
                                                <option class="option-select" value="<?php echo $designation['id']; ?>"><?php echo $designation['name']; ?></option>
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
                                        <input name="join_date" type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'MPO Date<br>(If Any)') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <input name="mpo_date" type="date" class="form-control">
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
                                        <select id="inputStateID" class="form-select" name="role_id" required>
                                            <option class="option-select"><?= __d('employees', '-- Choose --') ?></option>
                                            <?php foreach ($roles as $role) { ?>
                                                <option class="option-select" value="<?php echo $role['id']; ?>"><?php echo $role['title']; ?></option>
                                            <?php } ?>
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
                                        <input name="join_as" type="text" class="form-control" placeholder="Joined As">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="label-font13"><?= __d('employees', 'Institute') ?></p>
                                    </div>
                                    <div class="col-lg-10 row2Field">
                                        <input name="job_institute" type="text" class="form-control" placeholder="Institute name">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'Training') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <input name="training" type="text" class="form-control" placeholder="Training">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="label-font13"><?= __d('employees', 'Order') ?></p>
                                    </div>
                                    <div class="col-lg-10 row2Field">

                                        <input name="employee_order" type="text" class="form-control" placeholder=" Suggested Order: <?= $empOrder ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'End Date<') ?></p>
                                    </div>
                                    <div class="col-lg-8 row2Field">
                                        <input name="end_date" type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </section>


            <section class="bg-light mt-3 p-4 m-auto" action="#">
                <fieldset>
                    <legend class=" mb-4"><?= __d('employees', 'Educational Information') ?> <input type="button" class="eduAdd btn btn-info" value="Add Education"></legend>
                    <div class="education">
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

                            <div class="col-md-1 mb-3">
                                <button id="delete" class=" btn btn-danger" type="button"><?= __d('employees', 'Remove') ?></button>
                            </div>
                        </div>

                    </div>
                </fieldset>
            </section>

            <section class="bg-light mt-3 p-4 m-auto" action="#">
                <fieldset>
                    <legend class=" mb-4"><?= __d('employees', 'Training Information') ?> <input type="button" class="trAdd btn btn-info" value="Add Training"></legend>
                    <div class="training">
                        <div class="training_block form_area p-3 mb-2" id="training_block">
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <p class="label-font13"><?= __d('employees', 'Training Title') ?></p>
                                        </div>
                                        <div class="col-lg-10 row3Field">
                                            <input name="training_title[]" type="text" class="form-control" placeholder="Name of Training">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <p class="label-font13"><?= __d('employees', 'Taining Duration') ?></p>
                                        </div>
                                        <div class="col-lg-7 row2Field">
                                            <input name="duration[]" type="text" class="form-control" placeholder="Taining Duration">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <p class="label-font13"><?= __d('employees', 'Achivement') ?></p>
                                        </div>
                                        <div class="col-lg-8 row3Field">
                                            <input name="achievement[]" type="text" class="form-control" placeholder="Achievement">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <p class="label-font13"><?= __d('employees', 'Year Attended') ?></p>
                                        </div>
                                        <div class="col-lg-7 row2Field">
                                            <input name="attend_year[]" type="text" class="form-control" placeholder="Participating Year">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1 mb-3">
                                <button id="delete" class=" btn btn-danger" type="button"><?= __d('employees', 'Remove') ?></button>
                            </div>
                        </div>

                    </div>
                </fieldset>
            </section>

            <section class="bg-light mt-3 p-4 m-auto" action="#">
                <fieldset>
                    <legend class=" mb-4"><?= __d('employees', 'Login Information') ?></legend>
                    <div class="form_area p-3">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="label-font13"><?= __d('employees', 'Username') ?></p>
                                    </div>
                                    <div class="col-lg-8 row3Field">
                                        <input name="username" type="text" class="form-control" placeholder="Username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('employees', 'Password') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input id="password" type="password" name="password" class="form-control" onChange="onChange()" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="label-font13"><?= __d('employees', 'Confirm Password') ?></p>
                                    </div>
                                    <div class="col-lg-9 row2Field">
                                        <input id="confirm_password" name="confirm" type="password" class="form-control" onChange="onChange()" placeholder=" Confirm Password">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4 dropdown mt-5">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p class="label-font"><?= __d('employees', 'Status') ?></p>
                                </div>
                                <div class=" col-lg-9 row2Field">
                                    <select name="status" class="bg-warning form-control" required>
                                        <option class="text-center" value=""><?= __d('employees', '-- Choose --') ?></option>
                                        <option value="1"><?= __d('employees', 'Active') ?></option>
                                        <option value="0"><?= __d('employees', 'Deactivated') ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button class="btn btn-lg btn-info text-white btn-right" type="submit"><?= __d('employees', 'Submit Application') ?></button>
                        <?php echo $this->Html->Link('Back', ['action' => 'index'], ['class' => 'btn btn-lg btn-sucess btn-right']); ?>
                    </div>

        </div>
        </fieldset>
        </section>
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
    var eduForm = $(".education").html();
    $('.eduAdd').click(function() {
        $('.education').append(eduForm);
    });
    $('.form').on('click', '#delete', function(eq) {
        $(this).closest('#single_row').remove();
    });
    $('.education').on('click', '#delete', function(eq) {
        alert("Are you sure, You want remove this?");
        $(this).closest('#education_block').remove();
    })

    // Training Field Add
    var trnForm = $(".training").html();
    $('.trAdd').click(function() {
        $('.training').append(trnForm);
    });
    $('.form').on('click', '#delete', function(eq) {
        $(this).closest('#single_row').remove();
    });
    $('.training').on('click', '#delete', function(eq) {
        alert("Are you sure, You want remove this?");
        $(this).closest('#training_block').remove();
    })

    //Password Checker
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
