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

<body class="scms-result-print">
    <div class="wraperResultSummary">
        <div class="resSummaryContainer">
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
                            <p class="title_exam_2"> <?php echo $exam_title[2]; ?></p>
                        </div>
                    </div>
                    <!-- end of hdrText -->
                </div><!-- end of schoolIdentity -->
            </div><!-- end of resHdr -->


            <div class="resultSummary">
                <table class="summary_table" style="text-align: center;">
                    <thead>
                        <tr>
                            <th> SID </th>
                            <th> NAME </th>
                            <th> CLASS </th>
                            <th> SECTION </th>
                            <th> ROLL </th>
                            <th> TOTAL MARKS </th>
                            <th> GPA </th>
                            <th> GRADE </th>
                            <th> MERIT POSITION </th>
                            <th> FAILED COURSES </th>
                        </tr>


                    </thead>

                    <tbody>
                        <?php foreach ($students as $student) { //echo '<pre>';print_r($student);die;?>
                            <tr>
                                <td> <?php echo $student['sid']; ?> </td>
                                <td> <?php echo $student['name']; ?> </td>
                                <td> <?php echo $student['level_name']; ?> </td>
                                <td> <?php echo $student['section_name']; ?> </td>
                                <td> <?php echo $student['roll']; ?> </td>
                                <td> <?php echo $student['result']['marks_with_forth_subject']; ?> </td>
                                <td> <?php echo number_format((float)$student['result']['gpa_with_forth_subject'], $decemal_point, '.', ''); ?> </td>
                                <td> <em> <?php echo $student['result']['grade_with_forth_subject']; ?></em> </td>
                                <td> <?php echo  $student['result']['position_in_' . $position]; ?></td>
                                <td> <?php echo $student['failed_course']; ?> </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <br>
                <h5 style="text-align: center;">Result Report</h5>
                <br>
                <table cellpadding="0" cellspacing="0" style="text-align: center;width: 100%;">
                    <tbody>
                        <tr>
                            <td colspan="2"> Total Students</td>
                            <td colspan="1"> <?php echo $count['total']; ?> </td>
                            <td colspan="2"> Total Pass</td>
                            <td colspan="1"> <?php echo $count['pass']; ?> </td>
                            <td colspan="2"> Total Fails</td>
                            <td colspan="1"> <?php echo $count['fail']; ?> </td>
                        </tr>
                    </tbody>
                </table>

                <br>
                <h5 style="text-align: center;">Grading Report</h5>
                <br>
                <table cellpadding="0" cellspacing="0" style="text-align: center;width: 100%;">

                    <tbody>
                        <tr>
                            <th> Grade </th>
                            <?php foreach ($filter_grade as $grade) { ?>
                                <td> <?php echo $grade['grade_name']; ?> </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td> Total </td>
                            <?php foreach ($filter_grade as $grade) { ?>
                                <td> <?php echo $grade['count']; ?> </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
                <div class="signatureWraper" style="position: inherit;">
                    <div class="signatureCont">

                        <div class="sign-head">
                            <?php echo $this->Html->image('/webroot'.$headSign , ['alt' => 'logo', "style" => 'left:32px;bottom:7px']); ?><b>Signature (Head Master)</b>
                        </div>
                    </div>
                </div><!-- end of signatureWraper -->
            </div> <!-- end resultSummary -->
        </div><!-- end of resSummaryContainer -->
    </div><!-- end of wraperResultSummary -->
</body>
