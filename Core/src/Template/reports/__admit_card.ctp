<?php

use Cake\Core\Configure;


$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
$borderImage = Configure::read('Result.borderImage');
$headerFontFamily = Configure::read('Result.headerFontFamily');
$headerFontCDN = Configure::read('Result.headerFontCDN');
$watermarkLogo = Configure::read('Result.watermarkLogo');
$headSign = Configure::read('Result.headSign');


?>
<?= $headerFontCDN ?>

<body class="scms-result-print">
    <div class="ExbtnWrap">
        <a class="btn btn-warning account" href="javascript:window.print();">প্রিন্ট করুন</a>
    </div>
    <?php

    if (!empty($students)) {
        $count = 1;
        foreach ($students as $student) {
    ?>
            <div id="borderImg" class="wraperAdmit <?php if ($count % 2 == 0) {
                                                        echo 'page-break';
                                                    } else {
                                                        echo "page_top_line";
                                                    } ?>" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 20 round;">
                <div class="resHdr">
                    <div class="resLogo text-left">
                        <?php echo $this->Html->image($instituteLogo, ['alt' => 'logo']); ?>
                    </div>
                    <div class="schoolIdentity hdrInstitute">
                        <p class="text-center mb-0" style="font-family: <?= $headerFontFamily ?>">
                            <?= $instituteName ?>
                        </p>
                        <h4 class="text-center mb-0">
                            Admit Card
                        </h4>
                        <div class="overlays">
                            <div class="textOverlay" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 18 round;">
                                <p class="title_exam"> <?php echo $exam_title[0]; ?></p>
                                <p class="title_exam_2"> <?php echo $exam_title[1]; ?></p>
                            </div>
                        </div>
                        <!-- end of hdrText -->
                    </div><!-- end of schoolIdentity -->
                </div><!-- end of resHdr -->

                <div class="admitExTop">
                    <div class="topMidEx">

                        <span class="ExClass"><?php echo $terms . ' - ' . $student['session_name']; ?></span>
                        <big>
                            <span class="ExRegNo">ID : <?php echo $student['sid']; ?></span>
                            <span class="ExRollNo">Roll : <?php echo $student['roll']; ?></span>
                        </big>
                    </div>
                </div>

                <div class="admitBtmEx">
                    <div class="admiBtmtLftEx">
                        <div class="admitInfoEx">
                            <span class="infoTitleEx">Student's Name</span><i>:</i><span class="infoNameEx"><?php echo $student['name']; ?></span>
                        </div>
                        <div class="admitInfoEx newInfoEx">
                            <span class="infoTitleExNew">Class</span><i>:</i><span class="infoNameExNew"><?php echo $student['level_name']; ?></span>
                            <span class="infoTitleExNew">Section </span><i>:</i><span class="infoNameExNew"><?php echo $student['section_name']; ?></span>
                            <span class="infoTitleExNew">Shift</span><i>:</i><span class="infoNameExNew"><?php echo $student['shift_name']; ?></span>
                        </div>
                        <div class="admitInfoEx newInfoEx">
                            <span class="infoTitleExNew">Working Days</span><i>:</i><span class="infoNameExNew"><?php echo $total; ?></span>
                            <span class="infoTitleExNew">Presence</span><i>:</i><span class="infoNameExNew">
                                <?php
                                echo $student['count'] . ' Days';
                                ?>
                            </span>
                            <span class="infoTitleExNew">Percentage</span><i>:</i><span class="infoNameExNew">
                                <?php
                                $new_percentage = number_format($student['percentage'], 2, '.', '');        //($sumWorkingday / 100) * $sumAttendence;
                                echo $new_percentage . ' %';
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="msgcontEx">
                        বিদ্যালয়ে প্রত্যেক ছাত্রের ১০০% উপস্থিতি নিশ্চিত করতে হবে। <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা আরম্ভ হওয়ার পূর্বেই বিদ্যালয়ের যাবতীয় পাওনা পরিশোধ না করলে তাকে প্রবেশ পত্র প্রদান করা হবে না। <span style="font-size:20px; font-weight:bold"> • </span>প্রবেশ পত্র ছাড়া পরীক্ষায় অংশগ্রহণ করতে দেওয়া হবে না। <span style="font-size:20px; font-weight:bold"> • </span> প্রত্যেক ছাত্রকে অবশ্যই স্কুল ইউনিফর্ম পরিধান করে বিদ্যালয়ে আসতে হবে। <span style="font-size:20px; font-weight:bold"> • </span> পেন্সিল, কলম, রাবার ও জ্যামিতি বক্স ছাড়া অন্য কোন কাগজ-পত্র, যেমন- বই, নোট খাতা ইত্যাদি নিয়ে পরীক্ষা কক্ষে প্রবেশ সম্পূর্ণরূপে নিষিদ্ধ। <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা শুরুর নির্ধারিত সময়ের ১৫ মিনিট পূর্বেই পরীক্ষার্থীকে নির্দিষ্ট আসন গ্রহণ করতে হবে। <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা কক্ষে নিরবতা পালন বাঞ্চনীয়। কোন প্রকার অসদুপায় অবলম্বন করলে তাকে পরীক্ষা কক্ষ থেকে বহিষ্কার করা হবে। <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষার দিনসমূহে প্রয়োজন ব্যতীত সম্মানিত অভিভাবকবৃন্দকে বিদ্যালয়ে আসতে নিরুৎসাহিত করা হচ্ছে।
                    </div>

                </div>
                <div class="eXsign-teacher">

                    <b style="margin-top:60px">Signature (Class Teacher)</b>
                </div>
                <div class="eXsign-head">
                    <?php
                    echo $this->Html->image($headSign, ['alt' => 'Head Teacher Sign', 'style' => 'left:32px;bottom:7px']); ?>
                    <b>Signature (Head Master)</b>
                </div>
                <div class="result-bg">
                    <?php echo $this->Html->image($watermarkLogo, ['width' => '240', 'class' => 'mainBgImage']); ?>
                </div>
            </div>
            <div class="<?php if ($count % 2 != 0) {
                            echo 'cutting-line';
                        } ?>"></div>
    <?php
            $count++;
        }
    }
    ?>
</body>

</html>
