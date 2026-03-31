<div class="row m-5 profile ">
    <div class="col-md-4">

        <div class="profile-badge text-center">
            <div class="profile-badge-avatar"><?php echo $this->Html->image('/webroot/uploads/employee_image/'.$user['image_name'], ['alt' => 'Picture']);?></div>
        </div>
        <div class="h5 text-center mt-5">
           <?php echo $user['name'];?>
        </div>
    </div>
    <div class="col-md-8 ">
        <div class="row">
            <div class="col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h5 id="thumbnail-label"><?= __d('employees', 'Total Salary') ?></h5>
                        <div class="thumbnail-description smaller"><?php echo $data['basic_salary']+$data['total_allowance']+$data['total_bonus']-$data['total_penalty'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h5 id="thumbnail-label"><?= __d('employees', 'Remaining Casual Leave') ?></h5>
                        <div class="thumbnail-description smaller"><?php echo $leave['casual_leave'];?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h5 id="thumbnail-label"><?= __d('employees', 'Remaining Sick Leave') ?></h5>
                        <div class="thumbnail-description smaller"><?php echo $leave['sick_leave']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h5 id="thumbnail-label"><?= __d('employees', 'Basic salary') ?></h5>
                        <div class="thumbnail-description smaller"><?php echo $data['basic_salary'];?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h5 id="thumbnail-label"><?= __d('employees', 'Total allowances') ?></h5>
                        <div class="thumbnail-description smaller"><?php echo $data['total_allowance'];?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h5 id="thumbnail-label"><?= __d('employees', 'Total bonus') ?></h5>
                        <div class="thumbnail-description smaller"><?php echo $data['total_bonus'];?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h5 id="thumbnail-label"><?= __d('employees', 'Total penalty') ?></h5>
                        <div class="thumbnail-description smaller"><?php echo $data['total_penalty'];?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="profile-button">
                    <button type="button" class="btn btn-warning btn-lg btn-block"><?= __d('employees', 'Enter') ?>  </button>
                </div>
            </div>
        </div>
    </div>
</div>