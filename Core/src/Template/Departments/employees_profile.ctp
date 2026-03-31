<style>
    .emp_img {
        display: flex;
        justify-content: center;
    }

    .emp_title {
        align-items: center;
    }
</style>

<div class="untree_co-section">
    <div class="container">
        <div class="staff mb-5">
            <div class="row emp_title">
                <div class="col-md-8">
                    <div class=" ml-5 staff-body">
                        <h2 class="staff-name line-bottom "><?= $profiles['name'] ?></h2>
                        <span class="d-block position mb-4"><?= $profiles['designation_name'] ?><br>Department of <?= $profiles['department_name'] ?></span>
                    </div>
                </div>
                <div class="col-md-4 emp_img">
                    <?= $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $profiles['image_name']); ?>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-1 col-lg-1"></div>
            <div class="col-lg-5 col-sm-12 col-md-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="feature">
                    <span class="icon-user-md color-1"></span>
                    <h3 class="line-bottom" style="color: black;">Personal Information</h3>
                    <p>
                        <b><?php if ($profiles['name']) : ?> Name: <?php endif; ?> </b>
                        <?php if ($profiles['name']) : ?> <?= $profiles['name']; ?><?php endif; ?>
                    </p>
                    <p>
                        <strong><?php if ($profiles['degree']) : ?> <?= $profiles['degree']; ?><?php endif; ?></strong>
                    </p>
                    <p>
                        <b><?php if ($profiles['gender']) : ?> Sex: <?php endif; ?> </b>
                        <?php if ($profiles['gender']) : ?> <?= $profiles['gender']; ?><?php endif; ?>
                    </p>
                    <p>
                        <b><?php if ($profiles['blood_group']) : ?> Blood group: <?php endif; ?> </b>
                        <?php if ($profiles['blood_group']) : ?> <?= $profiles['blood_group']; ?><?php endif; ?>
                    </p>

                    <p><b>BMDC registration no.: </b>A-54,934</p>
                </div>
            </div>
            <div class="col-md-1 col-lg-1"></div>
            <?php if ($profiles['email']) : ?>
                <div class="col-lg-5 col-sm-12 col-md-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature">
                        <span class="icon-home color-2"></span>
                        <h3 class="line-bottom" style="color: black;">Mailing Address</h3>
                        <p><b>Email address: </b><a href="mailto: <?= $profiles['email']; ?>"><?= $profiles['email']; ?></a></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="feature">
                <span class="icon-trophy color-3"></span>
                <h3 class="line-bottom" style="color: black;">Academic Qualifications</h3>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Level of education</th>
                            <th scope="col">Specialisation</th>
                            <th scope="col">Institute</th>
                            <th scope="col">Degree</th>
                            <th scope="col">Passing year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Masters or equivalent</td>
                            <td>Anatomy</td>
                            <td>Bangabandhu Sheikh Mujib Medical University, Dhaka</td>
                            <td>MS Anatomy</td>
                            <td>2018</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="feature">
                <span class="icon-suitcase color-4"></span>
                <h3 class="line-bottom" style="color: black;">Employment History</h3>
                <p><b>Current post: </b>Associate Professor (CC) of Department of Anatomy, BSMMC since 2021-06-06</p>
                <p><b>Previous employments: </b></p>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Serial</th>
                            <th scope="col">Institution/Organisation</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Starting date</th>
                            <th scope="col">Ending date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Sir Salimullah Medical College, Dhaka</td>
                            <td>Assistant Professor</td>
                            <td>2019-11-29</td>
                            <td>2021-06-05</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="feature">
                <span class="icon-file-text color-5"></span>
                <h3 class="line-bottom" style="color: black;">Publications</h3>
                <ol style="margin-left: -20px;">
                </ol>
            </div>
        </div>
    </div>
</div>
</div>
</div>
