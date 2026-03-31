<?php

use Cake\Core\Configure;

$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
$watermarkLogo = Configure::read('Result.watermarkLogo');
$borderImage = Configure::read('Result.borderImage');
$headerFontFamily = Configure::read('Result.headerFontFamily');
$headerFontCDN = Configure::read('Result.headerFontCDN');
$headSign = Configure::read('Result.headSign');

?>

<?= $headerFontCDN ?>

<style>
    @page {
        size: landscape;
    }

    body {
        background-color: #fff;
    }

    .hlc_body {
        position: relative;
        font-family: 'Times New Roman', Times, serif;
        font-size: 14px;
        margin: 1em;
        padding: 5px;
        /*border: 5px double #37ac68;*/
          /* MUST have border width + style */
    border: 20px solid transparent;

    /* Now border-image can draw */
    border-image-source: url('<?= $this->Url->image($borderImage) ?>');
    border-image-slice: 20;      /* adjust slice value */
    border-image-repeat: round;  /* or stretch */
    /* optional: border-image-width: 20; */

        page-break-after: always;
    }

    .hlc_body::before {
        content: '';
        position: absolute;
        top: 15%;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('<?= $this->Url->image($watermarkLogo) ?>');
        filter: grayscale(100%);
        background-repeat: no-repeat;
        background-position: center;
        background-size: 20% 40%;
        opacity: 0.3;
        z-index: -1;
    }


    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border: 1px solid black !important;
    }

    .table-sm {
        font-size: 0.55rem;
        line-height: 1;
    }


    .table-bordered th,
    .table-bordered td {
        padding: 0.1rem 0.2rem;
    }

    .signature-line {
        border-top: 1px solid rgba(143, 140, 140, 0.3);
        width: 50%;
        margin: 70px auto 0 auto;

        padding-top: 5px;
    }

    .marksheet-table td {
        text-align: center;
        vertical-align: middle;
    }

    .marksheet-table {
        background-color: transparent !important;
    }

    .marksheet-table th,
    .marksheet-table td {
        background-color: transparent !important;
    }

    .label-1 {
        display: inline-block;
        width: 150px;
        font-weight: normal;
    }

    .label {
        display: inline-block;
        width: 110px;
        font-weight: normal;
    }

    .value {
        margin-left: 10px;
        font-weight: bold;
    }

    .marksheet-table td {
        text-align: center;
        vertical-align: middle;
    }


    .marksheet-table {
        background-color: transparent !important;
    }

    .marksheet-table th,
    .marksheet-table td {
        background-color: transparent !important;
    }

    .grade-table td:nth-child(4) {
        text-align: left;
        padding-left: 5px;
    }

    @media print {
        a[href='javascript:window.print();'] {
            display: none !important;
        }
    }
</style>
<a href="javascript:window.print();" style="
    position: fixed;
    top: 60px;
    right: 60px;
    background-color: #0070c0;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    z-index: 9999;
">
    প্রিন্ট করুন
</a>

<body class="white-bg" style="">
    <?php foreach ($students as $student) {
        // echo '<pre>';
        // print_r($students);
        // die;

    ?>
        <div class="hlc_body">

            <table class="table table-borderless" style="width: 100%; ">
                <tr>
                    <!-- Left: Student Photo -->
                    <td style="width: 15%; vertical-align: top; text-align: center;">

                        <?= $this->Html->image(
                            !empty($student['thumbnail']) ? '/uploads/students/thumbnail/' . $student['thumbnail'] : '/webroot/uploads/default.png',
                            ['alt' => 'Student Photo', 'class' => 'img-fluid ', 'style' => 'width: 100px; height: 100px;']
                        ); ?>
                    </td>

                    <td style="width: 70%; vertical-align: top; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 15px; align-items: center; margin-left: -105px;">
                            <img src="<?= $this->Url->image($instituteLogo, ['alt' => 'logo']) ?>" alt="College Logo"
                                class="logo me-2" style="width: 100px; height: 80px;">
                            <h1 class=" fw-bold" style="font-weight: 700; font-size: 25px; margin: 0; color: #37ac68; margin-bottom: 50px;"><?= $instituteName ?></h1>
                        </div>


                        <div style="line-height: .8; margin-top: -50px;">
                            <p class="text-success fw-bold" style="margin: 1px 0; font-size: 18px;">
                                ********************************
                            </p>
                            <p
                                style=" color: #0070c0; font-size: 18px; font-weight: 900; background-color: #e2f0d9; border: 2px solid #333; border-radius: 4px; display: inline-block; padding: 4px 8px;">
                                ACADEMIC TRANSCRIPT
                            </p>
                            <p class="fw-bold" style="margin: -10px 0; font-size: 18px; font-weight: 600;">
                                <?php echo $exam_title[0]; ?>
                            </p>
                            <p style="margin: 15px 0; font-weight: 550; font-size: 15px;">
                                CLASS: <?php echo $student['level_name']; ?>
                            </p>
                        </div>
                    </td>
                    <!-- Right: Grade Table -->
                    <td style="width: 15%; vertical-align: top;height: 150px; width: 150px;">
                        <div style="border: 2px solid #28a745; padding: 5px;">
                            <table class="table table-bordered table-sm text-center" style="font-size: 10px; margin: 0; ">
                                <thead style="background-color: #e2f0d9;">
                                    <tr>
                                        <th style="">&nbsp;Range&nbsp; </th>
                                        <th style="">Grade</th>
                                        <th style="">GPA</th>

                                    </tr>
                                </thead>
                                <tbody class="grade-table">
                                    <?php foreach ($grades as $grade_key => $grade) { ?>
                                        <tr class="<?php if (count($grades) == $grade_key + 1) {
                                                        echo 'lastitem';
                                                    } ?>">
                                            <td class="column1"><?php echo $grade['percentage_down'] . '-' . $grade['percentage_top']; ?></td>
                                            <td class="column2"><?php echo $grade['grade_name']; ?></td>
                                            <td class="column3"><?php echo $grade['point']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <table
                style="width:100%; padding: 5px; margin: auto; border: 1px solid rgba(128, 128, 128, 0.3); border-collapse: collapse; margin-top: -20px; margin-bottom: 10px;">
                <thead>
                    <tr>
                        <td
                            style="width: 40%; padding: 10px; text-align: left; border: 1px solid rgba(128, 128, 128, 0.3);">
                            <div><span class="label-1">Name of Student</span>:<strong
                                    class="value" style="text-transform: uppercase;"><?php echo $student['name']; ?></strong></div>
                            <div><span class="label-1">Father's Name</span>:<strong
                                    class="value" style="text-transform: uppercase;"><?php echo $student['guardians']['father']['name']; ?></strong></div>
                            <div><span class="label-1">Mother's Name</span>:<strong
                                    class="value" style="text-transform: uppercase;"><?php echo $student['guardians']['mother']['name']; ?></strong></div>
                            <div><span class="label-1">Date of Birth</span>:<strong
                                    class="value"><?= date('d-m-Y', strtotime($student['date_of_birth'])) ?></strong></div>
                        </td>

                        <td
                            style="width: 30%; padding: 10px; text-align: left; border: 1px solid rgba(128, 128, 128, 0.3);">
                            <div><span class="label">Section</span>:<strong
                                    class="value"><?php echo $student['section_name']; ?></strong></div>
                            <div><span class="label">SID</span>:<strong
                                    class="value"><?php echo $student['sid']; ?></strong></div>
                            <div><span class="label">Section Roll</span>:<strong
                                    class="value"><?php echo $student['roll']; ?></strong></div>
                            <div><span class="label">Attendance</span>:<strong
                                    class="value"><?php echo $student['attandance_data'][13]['count'] . '/' . $student['working_days']; ?></strong>
                            </div>
                        </td>
                        <td
                            style="width: 30%; padding: 10px; text-align: left; border: 1px solid rgba(128, 128, 128, 0.3);">
                            <div><span class="label-1">GPA & Grade</span>:<strong
                                    class="value"><?php echo number_format((float)$student['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?> (<?php echo $student['result']['grade_with_forth_subject']; ?>)</strong></div>
                            <div><span class="label-1">Obtained Marks</span>:<strong
                                    class="value"><?php echo $student['marks_with_forth_subject']; ?></strong></div>
                            <div><span class="label-1">Section Merit</span>:<strong
                                    class="value"><?php echo $student['position_in_section']; ?></strong></div>
                            <div><span class="label-1">Class Merit</span>:<strong
                                    class="value"><?php echo $student['position_in_level']; ?></strong>
                            </div>
                        </td>
                    </tr>
                </thead>
            </table>

            <div class="resmidcontainer">
                <h2 class="markTitle">Subject-Wise Grade &amp; Mark Sheet</h2>
                <table class="pagetble_middle">
                    <tbody>
                        <tr>
                            <th class="res1" rowspan="2">SL</th>
                            <th class="res1" rowspan="2">CODE</th>
                            <th class="res2 cTitle" rowspan="2">SUBJECT</th>
                            <th class="res8 examtitle" colspan="14"> <?php echo $exam_title['title']; ?></th>
                        </tr>

                        <tr>
                            <!-- head start !-->
                            <?php foreach ($heads as $head) { ?>
                                <td <?php echo $head['style']; ?>><?php echo $head['name']; ?></td>
                            <?php } ?>
                            <!-- head end !-->
                        </tr>
                        <?php $sl = 1; ?>

                        <!-- marge course start !-->
                        <?php if (isset($student['merge_filter_course'])) { ?>
                            <?php foreach ($student['merge_filter_course'] as $courses) { //echo '<pre>';print_r($student['merge_filter_course']);die; 
                            ?>
                                <?php foreach (['1st_course', '2st_course'] as $key) { ?>
                                    <?php
                                    if (!isset($courses[$key])) {
                                        continue;
                                    }

                                    $course = $courses[$key];
                                    $course_details = $course['course_details'];
                                    $course_id = $course_details['course_id']; // or 'course_id' if available
                                    $is_forth = isset($student['third_fourth_subjects']['forth'][$course_details['course_id']]);
                                    $course_name = $is_forth
                                        ? $course_details['course_name'] . ' (4TH)'
                                        : $course_details['course_name'];
                                    ?>
                                    <tr>
                                        <td class="res0"><?= $sl++; ?></td>
                                        <td class="res1" rowspan="1"><?php echo $course_details['course_code']; ?></td>
                                        <td class="res2 cTitle" rowspan="1"><?php echo $course_name; ?></td>


                                        <?php foreach ($course['table_data'] as $table_data) { ?>
                                            <td <?php echo $table_data['style'];
                                                if (isset($table_data['result'])) {
                                                    echo 'style="color: red;"';
                                                } ?>>
                                                <b><?php echo $table_data['value']; ?></b>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>

                        <?php } ?>
                        <!-- marge course end !-->
                        <!-- single course start !-->
                        <?php foreach ($student['single_filter_course'] as $single_course) { ?>
                            <tr>
                                <td class="res0"><?= $sl++; ?></td>
                                <td class="res1" rowspan="1"><?php echo $single_course['course_details']['course_code']; ?></td>
                                <td class="res2 cTitle" rowspan="1"><?php echo $course_name = isset($student['third_fourth_subjects']['forth'][$single_course['course_details']['course_id']]) ? $single_course['course_details']['course_name'] . ' (4TH)' : $single_course['course_details']['course_name'] ?>
                                </td>
                                <?php foreach ($single_course['table_data'] as $table_data) { ?>
                                    <td <?php echo $table_data['style'];
                                        if (isset($table_data['result'])) {
                                            echo 'style="color: red;"';
                                        } ?>><b><?php echo $table_data['value']; ?></b></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        <!-- single course end !-->
                        <tr class="lastitem">
                            <td>&nbsp;</td>
                            <td class="markTotal" colspan="<?php echo $last_row_colspan + 1; ?>">Total Marks &amp; GPA = </td>
                            <td><b><?php echo $student['result']['marks_with_forth_subject']; ?></b></td>
                            <?php if (isset($student['result']['highest_total_in_' . $position])) { ?>
                                <td><b><?php echo $student['result']['highest_total_in_' . $position]; ?></b></td>
                            <?php } else { ?>
                                <td><b></b></td>
                            <?php }  ?>

                            <td <?php if ($student['result']['result'] == 'fail') {
                                    echo 'style="color: red;"';
                                } ?>><b><?php echo number_format((float)$student['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?> </b></td>
                            <td <?php if ($student['result']['result'] == 'fail') {
                                    echo 'style="color: red;"';
                                } ?>><b><?php echo $student['result']['grade_with_forth_subject']; ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- signature -->
            <!-- <div style=" top: 635px; position: absolute; width:99%;"> -->
            <table style=" width:100%; margin-top: 10px; border: 1px solid rgba(143, 140, 140, 0.3);" border="1">
                <tr>
                    <td style="width: 28%;">
                        <div class="text-center mb-3">
                            <strong class="d-inline-block border-bottom">
                                <?= h(strtoupper($scms_activity_remarks[0]['activity_name'])) ?>
                            </strong>
                        </div>
                        <?php foreach ($scms_activity_remarks[0]['remark'] as $index => $remark): ?>
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox" id="activity<?= $index ?>"
                                    style="accent-color: #37ac68;" <?php
                                                                    $activityId = $scms_activity_remarks[0]['activity_id'];
                                                                    $remarkId   = $remark['activity_remark_id'];

                                                                    if (
                                                                        isset($student['comments'][$activityId]) &&
                                                                        isset($student['comments'][$activityId][$remarkId]) &&
                                                                        $student['comments'][$activityId][$remarkId] == 1
                                                                    ) {
                                                                        echo 'checked ';
                                                                    } else {
                                                                        echo 'disabled';
                                                                    }
                                                                    ?>>
                                <label class="form-check-label" for="activity<?= $index ?>" style="color: black;">
                                    <?= h($remark['remark_name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td style="width: 18%;">
                        <div class="text-center mb-3">
                            <strong class="d-inline-block border-bottom">
                                <?= h(strtoupper($scms_activity_remarks[1]['activity_name'])) ?>
                            </strong>
                        </div>
                        <?php foreach ($scms_activity_remarks[1]['remark'] as $index => $remark): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="achievement<?= $index ?>"
                                    style="accent-color: #37ac68;" <?php
                                                                    $activityId = $scms_activity_remarks[1]['activity_id'];
                                                                    $remarkId   = $remark['activity_remark_id'];

                                                                    if (
                                                                        isset($student['comments'][$activityId]) &&
                                                                        isset($student['comments'][$activityId][$remarkId]) &&
                                                                        $student['comments'][$activityId][$remarkId] == 1
                                                                    ) {
                                                                        echo 'checked ';
                                                                    } else {
                                                                        echo 'disabled';
                                                                    }
                                                                    ?>>
                                <label class="form-check-label" for="achievement<?= $index ?>" style="color: black;">
                                    <?= h($remark['remark_name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td style="width: 18%; vertical-align: bottom;  text-align: center;">
                        Guardian’s Signature
                    </td>
                    <td style="width: 18%; vertical-align: bottom; text-align: center;">
                        Class Teacher’s Signature
                    </td>

                    <td style="width: 18%; vertical-align: bottom;  text-align: center;">
                        Principal/AVP Signature
                    </td>
                </tr>
            </table>
        </div>
        </div>
        </div>
    <?php } ?>

    <?php
    $this->Form->unlockField('session_id');
    $this->Form->unlockField('level_id');
    $this->Form->unlockField('section_id');
    $this->Form->unlockField('group_id');
    $this->Form->unlockField('sid');
    $this->Form->unlockField('shift_id');
    $this->Form->unlockField('result_template_id');
    $this->Form->unlockField('term_cycle_id');
    $this->Form->unlockField('gradings_id');
    $this->Form->unlockField('save');
    ?>

    <?php if (isset($save)) { ?>
        <div>
            <?php echo $this->Form->create(); ?>
            <input name="session_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['session_id']; ?>">
            <input name="level_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['level_id']; ?>">
            <input name="section_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['section_id']; ?>">
            <input name="group_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['group_id']; ?>">
            <input name="sid" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['sid']; ?>">
            <input name="shift_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['shift_id']; ?>">
            <input name="result_template_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['result_template_id']; ?>">
            <input name="term_cycle_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['term_cycle_id']; ?>">
            <input name="gradings_id" type="hidden" class="form-control" id="" placeholder=""
                value="<?php echo $request_data['gradings_id']; ?>">
            <input name="save" type="hidden" class="form-control" id="" placeholder="" value="yes">
            <section class="bg-light mt-3 p-4 m-auto" action="#">
                <div class="mt-3">
                    <button type="submit" class="btn btn-info"
                        style="position:fixed;  top:20px;  right:50px;"><?= __d('result', 'Save Result') ?></button>
                    <?php echo $this->Form->end(); ?>
                </div>
            </section>
        </div>
    <?php } ?>

</body>