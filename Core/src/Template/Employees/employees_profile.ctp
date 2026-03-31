    <?php

    use Cake\Core\Configure;

    $siteTemplate = Configure::read('Site.template');
    $siteTitle =  $this->fetch('pagetitle');
    ?>

    <?php if ($siteTemplate == 2) { ?>
        <?php foreach ($profiles as $key => $profile) { ?>

            <div class="container my-3">
                <h4 class="content_title">Employee Details</h4>
                <div class="row mt-3 check" style="margin: 0em 2em;">
                    <div class=" col-md-4 col-12 fixed_img">
                        <?= $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $profile['image_name'], ['alt' => $profile['name'], 'class' => 'custom_img']); ?>
                    </div>
                    <div class="col-md-8 col-12">
                        <h5><?= $profile['name'] ?></h5>
                        <hr class="new_hr">
                        <table id="teachers_profile">
                            <tr>
                                <td><?php if ($profile['designation_name']) : ?> পদবীঃ <?php endif; ?> </td>
                                <td><?php if ($profile['designation_name']) : ?> <?= $profile['designation_name']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['father_name_bn']) : ?> পিতার নামঃ <?php endif; ?> </td>
                                <td><?php if ($profile['father_name_bn']) : ?> <?= $profile['father_name_bn']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td>শিক্ষাগত যোগ্যতাঃ </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['training']) : ?> ট্রেনিংঃ <?php endif; ?> </td>
                                <td><?php if ($profile['training']) : ?> <?= $profile['training']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['email']) : ?> ইমেইলঃ <?php endif; ?> </td>
                                <td><?php if ($profile['email']) : ?> <?= $profile['email']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['blood_group']) : ?> রক্তের গ্রুপঃ <?php endif; ?> </td>
                                <td><?php if ($profile['blood_group']) : ?> <?= $profile['blood_group']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['nationality']) : ?> জাতীয়তাঃ <?php endif; ?> </td>
                                <td><?php if ($profile['nationality']) : ?> <?= $profile['nationality']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['national_id']) : ?> জাতীয় পরিচয় নংঃ <?php endif; ?> </td>
                                <td><?php if ($profile['national_id']) : ?> <?= $profile['national_id']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['mobile']) : ?> ফোনঃ <?php endif; ?> </td>
                                <td><?php if ($profile['mobile']) : ?> <?= $profile['mobile']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['present_address']) : ?> ঠিকানাঃ <?php endif; ?> </td>
                                <td><?php if ($profile['present_address']) : ?> <?= $profile['present_address']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['date_of_birth']) : ?> জন্মতারিখঃ <?php endif; ?> </td>
                                <td><?php if ($profile['date_of_birth']) : ?> <?= $profile['date_of_birth']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['join_date']) : ?> যোগদানের তারিখঃ <?php endif; ?> </td>
                                <td><?php if ($profile['join_date']) : ?> <?= $profile['join_date']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['mpo_date']) : ?> এমপিও তারিখ ঃ<?php endif; ?> </td>
                                <td><?php if ($profile['mpo_date']) : ?> <?= $profile['mpo_date']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['join_as']) : ?> প্রথম যোগদানঃ <?php endif; ?> </td>
                                <td><?php if ($profile['join_as']) : ?> <?= $profile['join_as']; ?><br /><?php endif; ?></td>
                            </tr>
                            <tr>
                                <td><?php if ($profile['hobby']) : ?>শখঃ<?php endif; ?> </td>
                                <td><?php if ($profile['hobby']) : ?> <?= $profile['hobby']; ?><br /><?php endif; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        <?php }
    } else { ?>
        <?php foreach ($profiles as $key => $profile) { ?>
            <h4 class="content_title">Employee Details</h4>
            <div class="row mt-3 check">
                <div class=" col-md-4 col-12 fixed_img">
                    <?= $this->Html->image('/webroot/uploads/employee_images/regularSize/' . $profile['image_name'], ['alt' => $profile['name'], 'class' => 'custom_img']); ?>
                </div>
                <div class="col-md-8 col-12">
                    <h5><?= $profile['name'] ?></h5>
                    <hr class="new_hr">
                    <table id="teachers_profile">
                        <tr>
                            <td><?php if ($profile['designation_name']) : ?> পদবীঃ <?php endif; ?> </td>
                            <td><?php if ($profile['designation_name']) : ?> <?= $profile['designation_name']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['father_name_bn']) : ?> পিতার নামঃ <?php endif; ?> </td>
                            <td><?php if ($profile['father_name_bn']) : ?> <?= $profile['father_name_bn']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td>শিক্ষাগত যোগ্যতাঃ </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['training']) : ?> ট্রেনিংঃ <?php endif; ?> </td>
                            <td><?php if ($profile['training']) : ?> <?= $profile['training']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['email']) : ?> ইমেইলঃ <?php endif; ?> </td>
                            <td><?php if ($profile['email']) : ?> <?= $profile['email']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['blood_group']) : ?> রক্তের গ্রুপঃ <?php endif; ?> </td>
                            <td><?php if ($profile['blood_group']) : ?> <?= $profile['blood_group']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['nationality']) : ?> জাতীয়তাঃ <?php endif; ?> </td>
                            <td><?php if ($profile['nationality']) : ?> <?= $profile['nationality']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['national_id']) : ?> জাতীয় পরিচয় নংঃ <?php endif; ?> </td>
                            <td><?php if ($profile['national_id']) : ?> <?= $profile['national_id']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['mobile']) : ?> ফোনঃ <?php endif; ?> </td>
                            <td><?php if ($profile['mobile']) : ?> <?= $profile['mobile']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['present_address']) : ?> ঠিকানাঃ <?php endif; ?> </td>
                            <td><?php if ($profile['present_address']) : ?> <?= $profile['present_address']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['date_of_birth']) : ?> জন্মতারিখঃ <?php endif; ?> </td>
                            <td><?php if ($profile['date_of_birth']) : ?> <?= $profile['date_of_birth']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['join_date']) : ?> যোগদানের তারিখঃ <?php endif; ?> </td>
                            <td><?php if ($profile['join_date']) : ?> <?= $profile['join_date']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['mpo_date']) : ?> এমপিও তারিখ ঃ<?php endif; ?> </td>
                            <td><?php if ($profile['mpo_date']) : ?> <?= $profile['mpo_date']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['join_as']) : ?> প্রথম যোগদানঃ <?php endif; ?> </td>
                            <td><?php if ($profile['join_as']) : ?> <?= $profile['join_as']; ?><br /><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td><?php if ($profile['hobby']) : ?>শখঃ<?php endif; ?> </td>
                            <td><?php if ($profile['hobby']) : ?> <?= $profile['hobby']; ?><br /><?php endif; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
    <?php }
    } ?>