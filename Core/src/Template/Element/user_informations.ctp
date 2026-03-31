<?php

use Cake\ORM\TableRegistry;

$this->Form->unlockField('name');
$this->Form->unlockField('mobile');
$this->Form->unlockField('email');
$this->Form->unlockField('gender');
$this->Form->unlockField('religion');
$this->Form->unlockField('permanent_address');
$this->Form->unlockField('date_of_birth');
$this->Form->unlockField('birth_registration');



?>

<section style="background-color: #eee;">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="my-3"><?= $students['name'] ?></h5>
                                <p class="text-muted mb-1"><strong>SID: <?= $students['sid'] ?></strong></p>
                                <p class="text-muted mb-1">Class: <?= $levels['level_name'] ?> --- Section: <?= $sections['section_name'] ?></p>
                                <p class="text-muted mb-4">Session: <?= $sessions['session_name'] ?></p>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Html->image('/webroot/uploads/students/thumbnail/' . $students['thumbnail'], ['class' => 'rounded-circle img-fluid', 'style' => 'width: 150px;']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <?php echo $this->Form->create('', ['type' => 'file']); ?>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="inputName" placeholder="Full Name" value="<?= $students['name'] ?>" readonly="true">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email@example.com" value="<?= $students['email'] ?>" readonly="true">
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row">
                            <label for="inputMobile" class="col-sm-2 col-form-label">Mobile:</label>
                            <div class="col-sm-10">
                                <input type="mobile" name="mobile" class="form-control" id="inputMobile" placeholder="mobile" value="<?= $students['mobile'] ?>" readonly="true">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="inputMobile" class="col-sm-2 col-form-label">Gender:</label>
                            <div class="col-sm-4">
                                <select class="form-control" disabled>
                                    <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                    <option value="Male" <?= $students['gender'] == 'Male' ? 'selected' : '' ?>><?= __d('students', 'Male') ?></option>
                                    <option value="Female" <?= $students['gender'] == 'Female' ? 'selected' : '' ?>><?= __d('students', 'Female') ?></option>
                                    <option value="Others" <?= $students['gender'] == 'Others' ? 'selected' : '' ?>><?= __d('students', 'Others') ?></option>
                                </select>
                                <!-- hidden input to actually submit the value -->
                                <input type="hidden" name="gender" value="<?= h($students['gender']) ?>">
                            </div>

                            <label for="inputMobile" class="col-sm-2 col-form-label">Religion:</label>
                            <div class="col-sm-4">
                                <select class="form-control" disabled>
                                    <option class="text-center"><?= __d('students', '-- Choose --') ?></option>
                                    <option value="Islam" <?= $students['religion'] == 'Islam' ? 'selected' : '' ?>><?= __d('students', 'Islam') ?></option>
                                    <option value="Hindu" <?= $students['religion'] == 'Hindu' ? 'selected' : '' ?>><?= __d('students', 'Hindu') ?></option>
                                    <option value="Christian" <?= $students['religion'] == 'Christian' ? 'selected' : '' ?>><?= __d('students', 'Christian') ?></option>
                                    <option value="Buddhist" <?= $students['religion'] == 'Buddhist' ? 'selected' : '' ?>><?= __d('students', 'Buddhist') ?></option>
                                    <option value="Others" <?= $students['religion'] == 'Others' ? 'selected' : '' ?>><?= __d('students', 'Others') ?></option>
                                </select>
                            
                                <!-- hidden input to actually submit the value -->
                                <input type="hidden" name="religion" value="<?= h($students['religion']) ?>">
                            </div>

                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="inputMobile" class="col-sm-2 col-form-label">Address:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="permanent_address" id="" readonly="true" rows="3"><?= $students['permanent_address'] ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="inputDob" class="col-sm-2 col-form-label">Birth Date:</label>
                            <div class="col-sm-4">
                                <input type="date" name="date_of_birth" class="form-control" id="inputDob" placeholder="" value="<?= date($students['date_of_birth']); ?>" readonly="true">
                            </div>
                            <label for="inputRegistration" class="col-sm-2 col-form-label">Birth Reg.:</label>
                            <div class="col-sm-4">
                                <input type="number" name="birth_registration" class="form-control" id="inputRegistration" placeholder="Birth Registration" value="<?= $students['birth_registration'] ?>" readonly="true">
                            </div>
                        </div>
                        <hr>
                        <!--<div class="form-group row">-->
                        <!--    <div class="col-sm-12">-->
                        <!--        <button type="submit" class="btn btn-info"><?= __d('setup', 'Update') ?></button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                                </p>
                                <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                <div class="progress rounded mb-2" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                                </p>
                                <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                <div class="progress rounded" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                <div class="progress rounded mb-2" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
