<?php

use Cake\Core\Configure;


$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
$watermarkLogo = Configure::read('Result.watermarkLogo');
$borderImage = Configure::read('Result.borderImage');
$headerFontFamily = Configure::read('Result.headerFontFamily');
$headerFontCDN = Configure::read('Result.headerFontCDN');

?>

<?= $headerFontCDN ?>


<body class="scms-result-print" style="">
    <?php foreach ($students as $student) { //echo '<pre>';print_r($studnet_attandance);die;?>
    <div class="wraperResult watermarked" id="borderImg" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 20 round;" data-watermark="">
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

                    <div><b> <?php echo $student['base_term']['name']; ?> </b></div>
                    <div><span>FATHER:</span><i>: </i><em> <?php echo $student['base_term']['guardians']['father']['name']; ?></em></div>
                    <div><span>MOTHER:</span><i>: </i><em> <?php echo $student['base_term']['guardians']['mother']['name']; ?></em></div>
                    <div><span>SID</span><i>: </i><em> <?php echo $student['base_term']['sid']; ?></em></div>
                    <div><span>DOB</span><i>: </i><em> <?php echo $student['base_term']['date_of_birth']; ?></em></div>

                </div>
                <div class="restopmiddle">
                    <div><span>SHIFT</span><i>: </i><em><?php echo $student['base_term']['shift_name']; ?></em></div>
                    <div><span>BOARD</span><i>: </i><em>DINAJPUR</em></div>
                    <div><span>CLASS</span><i>: </i><em><?php echo $student['base_term']['level_name']; ?></em></div>
                    <div><span>GROUP</span><i>: </i><em><?php echo $student['base_term']['group_name']; ?></em></div>
                    <div><span>SECTION</span><i>: </i><em><?php echo $student['base_term']['section_name']; ?></em></div>
                </div>

                <div class="restopright">
                    <div><span>ROLL NO</span><i>: </i><em><?php echo $student['base_term']['roll']; ?></em></div>
                    <div><span>GPA</span><i>: </i><em><?php echo number_format((float)$student['merge_term']['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?></em></div>
                    <div><span>GRADE</span><i>: </i><em><?php echo $student['merge_term']['result']['grade_with_forth_subject']; ?></em></div>
                    
                    <div><span>MERIT</span><i>: </i><em><?php if (isset($student['merge_term']['result']['position_in_section'])) {
                                                                echo $student['merge_term']['result']['position_in_section'];
                                                            } ?></em>(Section)</div>
                                                                 <div><span>MERIT</span><i>: </i><em><?php if (isset($student['merge_term']['result']['position_in_level'])) {
                                                                echo $student['merge_term']['result']['position_in_level'];
                                                            } ?></em>(CLASS)</div>
                </div><!-- end of restopleft -->
            </div>


            <div class="resmidcontainer">
                <h2 class="markTitle">Subject-Wise Grade &amp; Mark Sheet</h2>
                <table class="pagetble_middle">
                    <tbody>
                        <tr>
                            <th class="res1" rowspan="2">CODE</th>
                            <th class="res2 cTitle" rowspan="2">SUBJECT</th>
                                <?php foreach ($term_names['others'] as $term) { ?>
                            <th class="res3 examtitle" colspan="2"><?php echo $term; ?></th>
                                <?php } ?>
                            <th class="res8 examtitle" colspan="14"><?php echo $term_names['base_term']; ?></th>
                        </tr>

                        <tr>
                            <!-- head start !-->
                                <?php foreach ($heads as $head) { ?>
                            <td <?php echo $head['style']; ?>><?php echo $head['name']; ?></td>
                                <?php } ?>
                            <!-- head end !-->
                        </tr>
                        <!-- marge course start !-->
                            <?php if (isset($student['base_term']['merge_filter_course'])) { ?>
                                <?php foreach ($student['base_term']['merge_filter_course'] as $merge_course) { ?>

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
                            <?php foreach ($student['base_term']['single_filter_course'] as $single_course) { ?>
                        <tr>
                            <td class="res1" rowspan="1"><?php echo $single_course['course_details']['course_code']; ?></td>
                            <td class="res2 cTitle" rowspan="1"><?php echo $single_course['course_details']['course_name'];   ?>
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
                            <td><b><?php echo $student['base_term']['result']['marks_with_forth_subject']; ?></b></td>
                                <?php if (isset($student['base_term']['result']['highest_total_in_' . $position])) { ?>
                            <td><b><?php echo $student['base_term']['result']['highest_total_in_' . $position]; ?></b></td>
                                <?php } else { ?>
                            <td><b></b></td>
                                <?php }  ?>
                            
                            <td <?php if ($student['base_term']['result']['result'] == 'fail') {
                                        echo 'style="color: red;"';
                                    } ?>><b><?php echo number_format((float)$student['base_term']['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?> </b></td>
                            <td <?php if ($student['base_term']['result']['result'] == 'fail') {
                                        echo 'style="color: red;"';
                                    } ?>><b><?php echo $student['base_term']['result']['grade_with_forth_subject']; ?></b></td>
                            
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
                                <!-- head start !-->
                                <th class="column1">Code</th>
                                    <?php foreach ($merge_heads as $merge_head) { ?>
                                <td <?php echo $merge_head['style']; ?>><?php echo $merge_head['name']; ?></td>
                                    <?php } ?>
                                <!-- head end !-->
                            </tr>

                            <!-- marge course start !-->
                                <?php if (isset($student['merge_term']['merge_filter_course'])) { ?>
                                    <?php foreach ($student['merge_term']['merge_filter_course'] as $merge_course) { ?>

                            <tr>
                                <td><?php echo $merge_course['1st_course']['course_details']['course_code']; ?></td>
                                            <?php foreach ($merge_course['1st_course']['table_data'] as $table_data) {
                                                unset($table_data['Grade']); ?>
                                <td <?php echo $table_data['style'];
                                                    if (isset($table_data['result'])) {
                                                        echo 'style="color: red;"';
                                                    } ?>><b><?php echo $table_data['value']; ?></b></td>
                                            <?php } ?>
                            </tr>

                            <tr>
                                <td><?php echo $merge_course['2st_course']['course_details']['course_code']; ?></td>
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


                                <?php foreach ($student['merge_term']['single_filter_course'] as $single_course) {
                                    unset($single_course['table_data']['Grade']); ?>
                            <tr>
                                <td><?php echo $single_course['course_details']['course_code']; ?></td>
                                </td>
                                        <?php foreach ($single_course['table_data'] as $table_data) { ?>
                                <td <?php echo $table_data['style'];
                                                if (isset($table_data['result'])) {
                                                    echo 'style="color: red;"';
                                                } ?>><b><?php echo $table_data['value']; ?></b></td>
                                        <?php } ?>
                            </tr>


                                <?php } ?>

                              <?php
                             $count1= isset($student['merge_term']['merge_filter_course']) ? count($student['merge_term']['merge_filter_course'])*2 : 0 ;
                             $count2= isset($student['merge_term']['single_filter_course']) ? count($student['merge_term']['single_filter_course']) : 0 ;
                             $empty=13-$count1-$count2;
                            if($empty>0){
                                for($i=0;$i<$empty; $i++){  ?>
                            <tr>
                                <!-- head start !-->
                                <th class="column1"></th>
                                    <?php foreach ($merge_heads as $merge_head) { ?>
                                <td <?php echo $merge_head['style']; ?>></td>
                                    <?php } ?>
                                <!-- head end !-->
                            </tr>  
                                <?php  }
                            }
                              ?>
                            <tr>
                                <td class="column1" colspan="<?php echo $last_row_colspan_merge_result; ?>">Overall</td>
                                <td><b><?php echo $student['merge_term']['result']['marks_with_forth_subject']; ?></b></td>
                                <td><b><?php echo number_format((float)$student['merge_term']['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?></b></td>
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
                                <td>Jan : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][1]['count']; ?>/<?php echo $total_attandance[1]['count']; ?></td>
                                <td>Feb : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][2]['count']; ?>/<?php echo $total_attandance[2]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Mar : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][3]['count']; ?>/<?php echo $total_attandance[3]['count']; ?></td>
                                <td>Apr : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][4]['count']; ?>/<?php echo $total_attandance[4]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>May : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][5]['count']; ?>/<?php echo $total_attandance[5]['count']; ?></td>
                                <td>Jun : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][6]['count']; ?>/<?php echo $total_attandance[6]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Jul : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][7]['count']; ?>/<?php echo $total_attandance[7]['count']; ?></td>
                                <td>Aug : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][8]['count'];; ?>/<?php echo $total_attandance[8]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Sep : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][9]['count']; ?>/<?php echo $total_attandance[9]['count']; ?></td>
                                <td>Oct : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][10]['count']; ?>/<?php echo $total_attandance[10]['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Nov : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][11]['count']; ?>/<?php echo $total_attandance[11]['count']; ?></td>
                                <td>Dec : <?php echo $studnet_attandance[$student['base_term']['student_cycle_id']][12]['count']; ?>/<?php echo $total_attandance[12]['count']; ?></td>
                            </tr>
                        </tbody>
                    </table>



                    <h2 class="markTitle" style="margin-top: 1.1em;"><?php echo $scms_activity_remarks[0]['activity_name']; ?> </h2>
                    <table class="pagetble" style="height:106px;">
                        <tbody>
                                <?php foreach ($scms_activity_remarks[0]['remark'] as $remark) { ?>
                            <tr>
                                <td><?php echo $remark['remark_name']; ?></td>
                                        <?php if (isset($student['base_term']['activity_data']) && isset($student['base_term']['activity_data'][$scms_activity_remarks[0]['activity_id']]) && isset($student['base_term']['activity_data'][$scms_activity_remarks[0]['activity_id']][$remark['activity_remark_id']])) { ?>
                                <td>&nbsp;√&nbsp;</td>
                                        <?php } else { ?>
                                <td></td>
                                        <?php } ?>
                            </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                      <?php if(count($notes) >0 ) { ?>
                    <div style='font-size:11px;'><?php echo $notes[0]['new']; ?> : <?php echo $notes[0]['old']; ?></div>
                     <?php } ?>
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
                      <?php if(count($notes)==2) { ?>
                    <div style='font-size:11px;'><?php echo $notes[1]['new']; ?> : <?php echo $notes[1]['old']; ?></div>
                      <?php } ?>
                </div>


            </div>


        </div>

        <div class="signatureWraper">
            <div class="signatureCont">
                <div class="sign-grdn"><b>Signature (Guardian)</b></div>
                <div class="sign-clsT"><b>Signature (Class Teacher)</b></div>
                <div class="sign-head">
                        <?php echo $this->Html->image('/webroot/uploads/result/head-sign.png', ['alt' => 'logo', "style" => 'left:32px;bottom:7px']); ?>
                    <b>Signature (Principal)</b>
                </div>
            </div>
        </div>
        <div class="result-bg">
                <?php echo $this->Html->image($watermarkLogo, ['width' => '420', 'class' => 'mainBgImage']); ?>
        </div>
    </div>
    <?php } ?>

   
</body>
<script>
    document.querySelectorAll('.watermarked').forEach(function (el) {
        el.dataset.watermark = (el.dataset.watermark + ' ').repeat(3000);
    });
</script>
