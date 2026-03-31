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

<body class="scms-result-print" style="">
    <?php foreach ($students as $student) { ?>
    <div class="wraperResult watermarked" id="borderImg" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 20 round;" data-watermark="<?= $instituteName ?>">
        <div class="resHdr">
            <div class="resLogo text-left">
                    <?php echo $this->Html->image($instituteLogo, ['alt' => 'logo']); ?>
            </div>
            <div class="schoolIdentity">
                <p class="text-center mb-0" style="font-family: <?= $headerFontFamily ?>">
                        <?= $instituteName ?>
                </p>
                <div class="overlays">
                    <div class="textOverlay" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 18 round;">
                        <p class="title_exam"> <?php echo $exam_title[0]; ?></p>
                        <p class="title_exam_2"> <?php echo $exam_title[1]; ?></p>
                    </div>
                </div>
                <!-- end of hdrText -->
            </div><!-- end of schoolIdentity -->
        </div><!-- end of resHdr -->


        <div class="resContainer">
            <div class="resTophdr">
                <div class="restopleft">

                    <div><b> <?php echo $student['name']; ?> </b></div>
                    <div><span>FATHER</span><i>: </i><em> <?php echo $student['guardians']['father']['name']; ?></em></div>
                    <div><span>MOTHER</span><i>: </i><em> <?php echo $student['guardians']['mother']['name']; ?></em></div>
                    <div><span>SID</span><i>: </i><em> <?php echo $student['sid']; ?></em></div>
                    <div><span>DOB</span><i>: </i><em> <?php echo $student['date_of_birth']; ?></em></div>
                </div>

                <div class="restopmiddle">
                    <div><span>SHIFT</span><i>: </i><em><?php echo $student['shift_name']; ?></em></div>
                    <div><span>BOARD</span><i>: </i><em>DINAJPUR</em></div>
                    <div><span>CLASS</span><i>: </i><em><?php echo $student['level_name']; ?></em></div>
                    <div><span>GROUP</span><i>: </i><em><?php echo $student['group_name']; ?></em></div>
                    <div><span>SECTION</span><i>: </i><em><?php echo $student['section_name']; ?></em></div>
                </div>

                <div class="restopright">
                    <div><span>ROLL NO</span><i>: </i><em><?php echo $student['roll']; ?></em></div>
                    <div><span>GPA</span><i>: </i><em><?php echo number_format((float)$student['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?></em></div>
                    <div><span>GRADE</span><i>: </i><em><?php echo $student['result']['grade_with_forth_subject']; ?></em></div>
                    <div><span>MERIT</span><i>: </i><em><?php if (isset($student['result']['position_in_' . $position])) {
                                                                echo $student['result']['position_in_' . $position];
                                                            } ?></em></div>
                </div><!-- end of restopleft -->
            </div>


            <div class="resmidcontainer">
                <h2 class="markTitle">Subject-Wise Grade &amp; Mark Sheet</h2>
                <table class="pagetble_middle">
                    <tbody>
                        <tr>
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
                        <!-- marge course start !-->
                            <?php if (isset($student['merge_filter_course'])) { ?>
                                <?php foreach ($student['merge_filter_course'] as $merge_course) { ?>
                        <tr>
                            <td class="res1" rowspan="1"><?php echo $merge_course['1st_course']['course_details']['course_code']; ?></td>
                            <td class="res2 cTitle" rowspan="1"><?php echo $merge_course['1st_course']['course_details']['course_name']; ?></td>


                                        <?php foreach ($merge_course['1st_course']['table_data'] as $table_data) { ?>
                            <td <?php echo $table_data['style'];
                                                if (isset($table_data['result'])) {
                                                    echo 'style="color: red;"';
                                                } ?>><b><?php echo $table_data['value']; ?></b></td>
                                        <?php } ?>
                        </tr>



                        <tr>
                            <td class="res1" rowspan="1"><?php echo $merge_course['2st_course']['course_details']['course_code']; ?></td>
                            <td class="res2 cTitle" rowspan="1"><?php echo $merge_course['2st_course']['course_details']['course_name']; ?></td>
                                        <?php foreach ($merge_course['2st_course']['table_data'] as $table_data) { ?>
                            <td <?php echo $table_data['style'];
                                                if (isset($table_data['result'])) {
                                                    echo 'style="color: red;"';
                                                } ?>><b><?php echo $table_data['value']; ?></b></td>
                                        <?php } ?>
                        </tr>
                                    <?php } ?>
                                <?php } ?>
                        <!-- marge course end !-->

                        <!-- single course start !-->
                                <?php foreach ($student['single_filter_course'] as $single_course) { ?>
                        <tr>
                            <td class="res1" rowspan="1"><?php echo $single_course['course_details']['course_code']; ?></td>
                            <td class="res2 cTitle" rowspan="1"><?php echo $course_name = isset($student['third_fourth_subjects']['forth'][$single_course['course_details']['course_id']]) ? $single_course['course_details']['course_name'].' (4TH)' : $single_course['course_details']['course_name']?>
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
                            <td class="markTotal" colspan="<?php echo $last_row_colspan; ?>">Total Marks &amp; GPA = </td>
                            <td><b><?php echo $student['result']['marks_with_forth_subject']; ?></b></td>
                                        <?php if (isset($student['result']['highest_total_in_' . $position])) { ?>
                            <td><b><?php echo $student['result']['highest_total_in_' . $position]; ?></b></td>
                                        <?php } else { ?>
                            <td><b></b></td>
                                        <?php }  ?>

                            <td <?php if ($student['result']['result'] == 'fail') {
                                                echo 'style="color: red;"';
                                            } ?>><b><?php echo $student['result']['grade_with_forth_subject']; ?></b></td>
                            <td <?php if ($student['result']['result'] == 'fail') {
                                                echo 'style="color: red;"';
                                            } ?>><b><?php echo number_format((float)$student['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?> </b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="btmcontainer">
                <div class="overalreport overalreportAll">
                    <h2 class="markTitle">Overall Report</h2>
                    <table class="pagetble" style="height:113px">
                        <tbody>
                            <tr>
                                <th class="column1" style="width:100px; padding:3px 0 2px">Code</th>
                                <th class="column2" style="width:100px">W</th>
                                <th class="column2" style="width:100px">M</th>
                                <th class="column2" style="width:100px">P</th>
                                <th class="column2" style="width:100px">C</th>
                                <th class="column2" style="width:130px">TwCA</th>
                                <th class="column2" style="width:130px">80%</th>
                                <th class="column2" style="width:130px">GTwCA</th>
                                <th class="column3">Gp</th>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px">&nbsp;</td>
                                <td class="column2" style="width:130px">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="column1" style="width:100px;height:23px;text-align:center">Overall</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2">&nbsp;</td>
                                <td class="column2" style="width:130px;height:23px"></td>
                                <td class="column3" style="height:23px"> </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- end of overalreport -->

                <div class="overalreport attendenceReport" style="width: 202px;">
                    <h2 class="markTitle">Attendance Report</h2>
                    <table class="pagetble" style="height:193px!important">
                        <tbody>
                            <tr>
                                <th colspan="2">Month : Presence/Working Days</th>
                            </tr>
                            <tr>
                                <td>Jan : <?php echo $student['attandance_data'][1]['count'];; ?>/<?php echo $total_attandance[1]['count']; ?></td>
                                <td>Feb : <?php echo $student['attandance_data'][2]['count'];; ?>/<?php echo $total_attandance[2]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Mar : <?php echo $student['attandance_data'][3]['count'];; ?>/<?php echo $total_attandance[3]['count']; ?></td>
                                <td>Apr : <?php echo $student['attandance_data'][4]['count'];; ?>/<?php echo $total_attandance[4]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>May : <?php echo $student['attandance_data'][5]['count'];; ?>/<?php echo $total_attandance[5]['count']; ?></td>
                                <td>Jun : <?php echo $student['attandance_data'][6]['count'];; ?>/<?php echo $total_attandance[6]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Jul : <?php echo $student['attandance_data'][7]['count'];; ?>/<?php echo $total_attandance[7]['count']; ?></td>
                                <td>Aug : <?php echo $student['attandance_data'][8]['count'];; ?>/<?php echo $total_attandance[8]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Sep : <?php echo $student['attandance_data'][9]['count'];; ?>/<?php echo $total_attandance[9]['count']; ?></td>
                                <td>Oct : <?php echo $student['attandance_data'][10]['count'];; ?>/<?php echo $total_attandance[10]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Nov : <?php echo $student['attandance_data'][11]['count'];; ?>/<?php echo $total_attandance[11]['count']; ?></td>
                                <td>Dec : <?php echo $student['attandance_data'][12]['count'];; ?>/<?php echo $total_attandance[12]['count']; ?></td>
                            </tr>
                        </tbody>
                    </table>


                    <h2 class="markTitle" style="margin-top: 1.1em;"><?php echo $scms_activity_remarks[0]['activity_name']; ?> </h2>
                    <table class="pagetble" style="height:106px;">
                        <tbody>
                                <?php foreach ($scms_activity_remarks[0]['remark'] as $remark) { ?>
                            <tr>
                                <td><?php echo $remark['remark_name']; ?></td>
                                        <?php if (isset($student['activity_data']) && isset($student['activity_data'][$scms_activity_remarks[0]['activity_id']]) && isset($student['activity_data'][$scms_activity_remarks[0]['activity_id']][$remark['activity_remark_id']])) { ?>
                                <td>&nbsp;√&nbsp;</td>
                                        <?php } else { ?>
                                <td></td>
                                        <?php } ?>
                            </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                   <?php if(isset( $notes[0])) {?>
                    <div style='font-size:11px;'><?php echo $notes[0]['new']; ?> : <?php echo $notes[0]['old']; ?></div>
                      <?php }?>
                </div><!-- end of overalreport -->

                <div class="overalreport gpagrading" style="width: 192px;">
                    <h2 class="markTitle">GPA Grading</h2>
                    <table class="pagetble" style="height:193px!important">
                        <tbody>
                            <tr>
                                <th class="column1">Range of Marks(%)</th>
                                <th class="column2">Grade</th>
                                <th class="column3">Point</th>
                            </tr>
                            <tr>
                                <td class="column1">80 or Above </td>
                                <td class="column2"> A+</td>
                                <td class="column3">5.00</td>
                            </tr>
                            <tr>
                                <td class="column1">70 to 79</td>
                                <td class="column2">A</td>
                                <td class="column3">4.00</td>
                            </tr>
                            <tr>
                                <td class="column1">60 to 69</td>
                                <td class="column2">A-</td>
                                <td class="column3">3.50</td>
                            </tr>
                            <tr>
                                <td class="column1">50 to 59</td>
                                <td class="column2">B</td>
                                <td class="column3">3.00</td>
                            </tr>

                            <tr>
                                <td class="column1">40 to 49</td>
                                <td class="column2">C</td>
                                <td class="column3">2.00</td>
                            </tr>

                            <tr>
                                <td class="column1">33 to 39</td>
                                <td class="column2">D</td>
                                <td class="column3">1.00</td>
                            </tr>
                            <tr class="lastitem">
                                <td class="column1">Below 33</td>
                                <td class="column2">F</td>
                                <td class="column3">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                    <h2 class="markTitle" style="margin-top: 1.1em;"><?php echo $scms_activity_remarks[1]['activity_name']; ?></h2>
                    <table class="pagetble" style="height:106px">
                        <tbody>
                                <?php foreach ($scms_activity_remarks[1]['remark'] as $remark) { ?>
                            <tr>
                                <td><?php echo $remark['remark_name']; ?></td>
                                        <?php if (isset($student['activity_data']) && isset($student['activity_data'][$scms_activity_remarks[1]['activity_id']]) && isset($student['activity_data'][$scms_activity_remarks[1]['activity_id']][$remark['activity_remark_id']])) { ?>
                                <td>&nbsp;√&nbsp;</td>
                                        <?php } else { ?>
                                <td></td>
                                        <?php } ?>
                            </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                   <?php if(isset( $notes[1])) {?>
                    <div style='font-size:11px;'><?php echo $notes[1]['new']; ?> : <?php echo $notes[1]['old']; ?></div>
                      <?php }?>
                </div>


            </div>


        </div>

        <div class="signatureWraper">
            <div class="signatureCont">
                <div class="sign-grdn"><b>Signature (Guardian)</b></div>
                <div class="sign-clsT"><b>Signature (Class Teacher)</b></div>
                <div class="sign-head">
                        <?php echo $this->Html->image($headSign, ['alt' => 'logo', 'style' => 'left:32px;bottom:7px']); ?>
                    <b>Signature (Head Master)</b>
                </div>
            </div>
        </div>
        <div class="result-bg">
                <?php echo $this->Html->image($watermarkLogo, ['width' => '420', 'class' => 'mainBgImage']); ?>
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
        <input name="session_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['session_id']; ?>">
        <input name="level_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['level_id']; ?>">
        <input name="section_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['section_id']; ?>">
        <input name="group_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['group_id']; ?>">
        <input name="sid" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['sid']; ?>">
        <input name="shift_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['shift_id']; ?>">
        <input name="result_template_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['result_template_id']; ?>">
        <input name="term_cycle_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['term_cycle_id']; ?>">
        <input name="gradings_id" type="hidden" class="form-control" id="" placeholder="" value="<?php echo $request_data['gradings_id']; ?>">
        <input name="save" type="hidden" class="form-control" id="" placeholder="" value="yes">


        <section class="bg-light mt-3 p-4 m-auto" action="#">
            <div class="mt-3">
                <button type="submit" class="btn btn-info" style="position:fixed;  top:20px;  right:50px;"><?= __d('result', 'Save Result') ?></button>
                    <?php echo $this->Form->end(); ?>
            </div>
        </section>
    </div>
    <?php } ?>

</body>
<script>
    document.querySelectorAll('.watermarked').forEach(function (el) {
        el.dataset.watermark = (el.dataset.watermark + ' ').repeat(3000);
    });


</script>
