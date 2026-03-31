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
    <!--TABULATION SHEET-->
    <div class="tabulation">
        <div class="mt-4">
            <div class="tabulationTop">
                <p class="tabulationInst text-center mb-0" style="font-family: <?= $headerFontFamily ?>;">
                    <?= $instituteName ?>
                </p>
                <div class="text-center">
                    <?php echo $this->Html->image($instituteLogo, ['alt' => 'logo', 'style' => 'width:120px!important']); ?>
                </div>
                <div class="overlays">
                    <div class="text-center">
                        <p class="title_exam"> <?php echo $exam_title[0]; ?></p>
                        <p class="title_exam_2"> <?php echo $exam_title[2]; ?></p>
                    </div>
                </div>
                <!-- end of hdrText -->
            </div>

        </div><!-- end of resHdr -->

        <table class="tabulation_table">
            <thead>
                <tr>
                    <td style="border-bottom:none; border-right:none">

                        <table height="171" class="table_title">
                            <tbody>
                                <tr>
                                    <td width="25" height="75">SL</td>
                                    <td colspan="2" width="160">Subject Code &amp; Name</td>
                                    <td rowspan="4" style="border-right:none">
                                        <table height="171" class="subject_hd_table">
                                            <tbody>
                                                <tr>

                                                    <?php foreach ($course_heads as $course_head) { ?>
                                                        <?php $parts = array_values($course_head['parts']); ?>
                                                        <td>
                                                            <!--Subject Table-->
                                                            <table class="subject_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="3" height="75"> <?php echo $course_head['view_name']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="33" rowspan="3" style="border-bottom:none; border-right:none">
                                                                            <table width="66" height="98" class="inner_mc">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td width="33" height="49"><?php echo $parts[0]['short_form']; ?></td>
                                                                                        <td width="32" height="49"><?php echo $parts[1]['short_form']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="border-bottom:none"><?php echo $parts[2]['short_form']; ?></td>
                                                                                        <td height="49" style="border-bottom:none"><?php echo $parts[3]['short_form']; ?></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td width="33" height="32"> <?php echo $course_head['other_parts']['total']['name']; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td height="32"><?php echo $course_head['other_parts']['gp']['name']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="32" style="border-bottom:none"><?php echo $course_head['other_parts']['letter_grade']['name']; ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!--End Subject Table-->
                                                        </td>
                                                    <?php } ?>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td colspan="2" width="100">Result</td>
                                </tr>

                                <tr>
                                    <td rowspan="4">&nbsp;</td>
                                    <td width="50" height="32">Roll No</td>
                                    <td width="110" rowspan="3">Name of The Student</td>
                                    <td width="40" rowspan="3">
                                        <table width="40" height="98">
                                            <tbody>
                                                <tr>
                                                    <td style="border-right:none" height="32">Total</td>
                                                </tr>
                                                <tr>
                                                    <td style="border-right:none">GPA</td>
                                                </tr>
                                                <tr>
                                                    <td style="border-right:none; border-bottom:none">Grade</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="60" rowspan="3">Status</td>
                                </tr>
                                <tr>
                                    <td height="32">ST ID</td>
                                </tr>
                                <tr>
                                    <td height="32">Session</td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </thead>
            <tbody>
                <?php $j = 1; ?>
                <?php foreach ($students as $student) { ?>
                    <tr class="tab_odd">
                        <td style="border-bottom:none; border-right:none">
                            <table height="90" class="table_number" style="border-top:none">
                                <tbody>
                                    <tr>
                                        <td width="25" rowspan="4"><?php echo $j++; ?></td>
                                        <td width="50" height="32"><?php echo $student['roll']; ?></td>
                                        <td width="110" rowspan="3"><?php echo $student['name']; ?></td>
                                        <td rowspan="3" style="border-right:none">
                                            <table height="90" class="subject_hd_table">
                                                <tbody>
                                                    <tr>


                                                        <?php foreach ($student['view'] as $course) { ?>
                                                            <?php $course_parts = array_values($course['parts']); ?>
                                                            <td>
                                                                <!--Subject Table-->
                                                                <table class="subject_table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width="32" rowspan="3" style="border-bottom:none; border-right:none">
                                                                                <table width="66" height="94" class="inner_mc">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td width="33" height="47"><b><?php echo $course_parts[0]['value']; ?></b></td>
                                                                                            <td width="33" height="47"><b><?php echo $course_parts[1]['value']; ?></b></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="border-bottom:none"><b><?php echo $course_parts[2]['value']; ?></b></td>
                                                                                            <td height="47" style="border-bottom:none"><b><?php echo $course_parts[3]['value']; ?></b></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td width="33" height="30"><b><?php echo $course['other_parts']['total']['value']; ?></b></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td height="30"><b><?php echo $course['other_parts']['gp']['value']; ?></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="30" style="border-bottom:none"><b><?php echo $course['other_parts']['letter_grade']['value']; ?> </b></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--End Subject Table-->
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="40" rowspan="3">
                                            <table width="40" height="90">
                                                <tbody>
                                                    <tr>
                                                        <td style="border-right:none" height="29"><?php echo $student['result']['marks_with_forth_subject']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:none"><?php echo number_format((float)$student['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:none; border-bottom:none">
                                                            <b><?php echo $student['result']['grade_with_forth_subject']; ?></b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="60" rowspan="3">
                                            <?php echo  $student['result']['position_in_' . $position]; ?><br>
                                            <?php
                                                $result = strtolower($student['result']['result']);
                                            ?>
                                            <br>
                                            
                                            <b style="color: <?= (strtolower($student['result']['result']) === 'fail') ? 'red' : 'green'; ?>">
                                                <?php echo $student['result']['result']; ?>
                                            </b>


                                        </td>
                                        
                                        

                                        
                                    </tr>
                                    <tr>
                                        <td height="30"><?php echo $student['sid']; ?></td>
                                    </tr>
                                    <tr>
                                        <td height="30"><?php echo $student['session_name']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
