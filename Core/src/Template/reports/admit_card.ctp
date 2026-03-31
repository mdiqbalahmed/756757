<?php

use Cake\Core\Configure;


$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
$borderImage = Configure::read('Admit.borderImage');
$headerFontFamily = Configure::read('Result.headerFontFamily');
$headerFontCDN = Configure::read('Result.headerFontCDN');
$watermarkLogo = Configure::read('Result.watermarkLogo');
$headSign = Configure::read('Result.headSign');


?>
<?= $headerFontCDN ?>

<body class="scms-admit-print">
    <div class="ExbtnWrap">
        <a class="btn btn-warning account" href="javascript:window.print();">প্রিন্ট করুন</a>
    </div>
    <?php

    if (!empty($students)) {
        $count = 1;
        $flag = Configure::read('Routine.show');
        foreach ($students as $student) { //echo '<pre>';print_r($student);die;
    ?>
    <!--<div id="borderImg" class="wraperAdmit" style="border: 1px dotted #000;">-->
        <div id="borderImg" class="wraperAdmit" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 20 round;" data-watermark="<?= $instituteName ?>">
        <div class="admitHdr">

            <div class="schoolIdentity hdrInstitute">
                <p class="text-center mb-0" style="font-family: <?= $headerFontFamily ?>; color: green;">
                    <?= $instituteName ?>
                </p>


                <h4 class="text-center mb-0" style="margin-top: 44px;color: #9419a9;">
                    ADMIT CARD
                </h4>
            </div><!-- end of schoolIdentity -->
        </div><!-- end of resHdr -->

        <div class="admitExTop">
            <div class="topMidEx">

                <span class="ExClass"
                    style="color: blue;"><?php echo $terms . ' - ' . $student['session_name']; ?></span>
                <big>
                    <span class="ExRegNo">ID : <?php echo $student['sid']; ?></span>
                    <span class="ExRollNo">Roll : <?php echo $student['roll']; ?></span>
                </big>
            </div>
        </div>

        <div class="admitLogo text-left logo-box" style="display: flex; align-items: center;">
            <span
                class="imgLogo"><?php echo $this->Html->image($instituteLogo, ['alt' => 'logo', 'style' => 'margin-right: 10px;']); ?></span>
            <span
                class="stuimG"><?php echo $this->Html->image('/webroot/uploads/students/thumbnail/' . $student['thumbnail']); ?></span>
        </div>

        <div class="admitBtmEx">
            <div class="admiBtmtLftEx">
                <div class="admitInfoEx">
                    <span class="infoTitleEx" style="color: black;">Name</span><i>:</i><span class="infoNameEx"
                        style="color: black;"><?php echo $student['name']; ?></span>
                </div>

                <div class="admitInfoEx newInfoEx">
                    <span class="infoTitleExNew" style="color: black;">Class</span><i>:</i><span class="infoNameExNew"
                        style="color: black;"><?php echo $student['level_name']; ?></span>
                    <span class="infoTitleExNew" style="color: black;">Section </span><i>:</i><span
                        class="infoNameExNew" style="color: black;"><?php echo $student['section_name']; ?></span>
                    <span class="infoTitleExNew" style="color: black;">Shift </span><i>:</i><span
                        class="infoNameExNew" style="color: black;"><?php echo $student['shift_name']; ?></span>
                </div>
                
            </div>

            <?php if ($flag == 'ON') { ?>
            <div class="routine">
    <h3 class="text-center" style="color: #17a2b8;text-decoration: underline;">ROUTINE</h3>
    <table class="table">
        <thead>
            <tr>
                <th style="text-align: center;padding: 7px;">Name Of Subjects</th>
                <th style="text-align: center;padding: 7px;">Date of Exam</th>
                <th style="text-align: center;padding: 7px;">Day</th>
                <th style="text-align: center;padding: 7px;">Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($student['admit_cards'] as $card) : ?>
            <tr>
                <td style="text-align: left;padding: 8px;"><?php echo $card['course_name']; ?></td>
                <td style="width: 108px;padding: 8px;"><?php echo date('d-m-Y', strtotime($card['date_of_exam'])); ?></td>
                <td style="padding: 8px;"><?php echo $card['day']; ?></td>
                <td style="width: 202px;padding: 8px;"><?php echo $card['time_from'] . '-' . $card['time_to']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="msgcontEx">
	<strong>বিশেষ দ্রষ্টব্য:</strong> 
        <span style="font-size:20px; font-weight:bold"> • </span>প্রবেশপত্র ব্যতীত কেউ পরীক্ষা কক্ষে প্রবেশ করতে পারবে না। 
        <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষার সময় ইউনিফর্ম পরিধান করে আসা বাধ্যতামূলক।
        <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষার দিন কোনো পরীক্ষার্থী পরীক্ষা সংশ্লিষ্ট দ্রব্যাদি ব্যতীত অন্য কোনো কিছু(ব্যাগ, বই, নোট, খাতা ইত্যাদি) সাথে নিয়ে বিদ্যালয়ে প্রবেশ করতে পারবে না।
        <span style="font-size:20px; font-weight:bold"> • </span> ৮ম থেকে ১০ম শ্রেণির পরীক্ষার্থীরা নন- প্রোগ্রামেবল সায়েন্টিফিক ক্যালকুলেটর ব্যবহার করতে পারবে, ৩য় থেকে ৭ম শ্রেণির পরীক্ষার্থীরা ক্যালকুলেটর ব্যবহার করতে পারবে না
        <span style="font-size:20px; font-weight:bold"> • </span> অনিবার্য কারণ বশত: কোনো পরীক্ষা স্থগিত হলে পরবর্তী পরীক্ষাসমূহ রুটিন অনুযায়ী চলবে এবং স্থগিত পরীক্ষার রুটিন নোটিশের মাধ্যমে পরে জানানো হবে।
        
    </div>

    <!--<div class="msgcontEx">-->
    <!--    বিদ্যালয়ে প্রত্যেক ছাত্রের ১০০% উপস্থিতি নিশ্চিত করতে হবে। <span style="font-size:20px; font-weight:bold"> • </span>-->
    <!--    পরীক্ষা আরম্ভ হওয়ার পূর্বেই বিদ্যালয়ের যাবতীয় পাওনা পরিশোধ না করলে তাকে প্রবেশ পত্র প্রদান করা হবে না। -->
    <!--    <span style="font-size:20px; font-weight:bold"> • </span>প্রবেশ পত্র ছাড়া পরীক্ষায় অংশগ্রহণ করতে দেওয়া হবে না। -->
    <!--    <span style="font-size:20px; font-weight:bold"> • </span> প্রত্যেক ছাত্রকে অবশ্যই স্কুল ইউনিফর্ম পরিধান করে বিদ্যালয়ে আসতে হবে। -->
    <!--    <span style="font-size:20px; font-weight:bold"> • </span> পেন্সিল, কলম, রাবার ও জ্যামিতি বক্স ছাড়া অন্য কোন কাগজ-পত্র, যেমন- বই, নোট খাতা ইত্যাদি নিয়ে পরীক্ষা কক্ষে প্রবেশ সম্পূর্ণরূপে নিষিদ্ধ। -->
    <!--    <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা শুরুর নির্ধারিত সময়ের ১৫ মিনিট পূর্বেই পরীক্ষার্থীকে নির্দিষ্ট আসন গ্রহণ করতে হবে। -->
    <!--    <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা কক্ষে নিরবতা পালন বাঞ্চনীয়। কোন প্রকার অসদুপায় অবলম্বন করলে তাকে পরীক্ষা কক্ষ থেকে বহিষ্কার করা হবে। -->
    <!--    <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষার দিনসমূহে প্রয়োজন ব্যতীত সম্মানিত অভিভাবকবৃন্দকে বিদ্যালয়ে আসতে নিরুৎসাহিত করা হচ্ছে।-->
    <!--</div>-->
</div>

            <!-- <div class="room-no">
                <p style="margin-top: 8px;"><strong>Room No:</strong> <?php echo $card['room']; ?></p>
            </div> -->
            <!-- <div
                style="padding-top: 23px;font-weight:700; font-size: 14px;margin: 0 50px 0 0;position: absolute;bottom: -180px;right: 433px;">
                <span style="color: red;">Direction: The Examinee must bring the<br> admit card in the examination hall
                </span>
            </div> -->
            <?php } else { ?>
            <div class="msgcontEx">
                বিদ্যালয়ে প্রত্যেক ছাত্রের ১০০% উপস্থিতি নিশ্চিত করতে হবে। <span
                    style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা আরম্ভ হওয়ার পূর্বেই বিদ্যালয়ের যাবতীয়
                পাওনা পরিশোধ না করলে তাকে প্রবেশ পত্র প্রদান করা হবে না। <span style="font-size:20px; font-weight:bold">
                    • </span>প্রবেশ পত্র ছাড়া পরীক্ষায় অংশগ্রহণ করতে দেওয়া হবে না। <span
                    style="font-size:20px; font-weight:bold"> • </span> প্রত্যেক ছাত্রকে অবশ্যই স্কুল ইউনিফর্ম পরিধান
                করে বিদ্যালয়ে আসতে হবে। <span style="font-size:20px; font-weight:bold"> • </span> পেন্সিল, কলম, রাবার ও
                জ্যামিতি বক্স ছাড়া অন্য কোন কাগজ-পত্র, যেমন- বই, নোট খাতা ইত্যাদি নিয়ে পরীক্ষা কক্ষে প্রবেশ
                সম্পূর্ণরূপে নিষিদ্ধ। <span style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা শুরুর নির্ধারিত
                সময়ের ১৫ মিনিট পূর্বেই পরীক্ষার্থীকে নির্দিষ্ট আসন গ্রহণ করতে হবে। <span
                    style="font-size:20px; font-weight:bold"> • </span> পরীক্ষা কক্ষে নিরবতা পালন বাঞ্চনীয়। কোন প্রকার
                অসদুপায় অবলম্বন করলে তাকে পরীক্ষা কক্ষ থেকে বহিষ্কার করা হবে। <span
                    style="font-size:20px; font-weight:bold"> • </span> পরীক্ষার দিনসমূহে প্রয়োজন ব্যতীত সম্মানিত
                অভিভাবকবৃন্দকে বিদ্যালয়ে আসতে নিরুৎসাহিত করা হচ্ছে।
            </div>
            <?php } ?>
        </div>
        
        <div class="signatureWraper">
                <div class="signatureCont">
                    <div class="eXsign-teacher"><b style="font-weight: bold;color: #000;">Signature (Class Teacher)</b></div>
                    <div class="sign-head">
                        <?php
                                echo $this->Html->image($headSign, ['alt' => 'Head Teacher Sign', 'style' => 'left:32px;bottom:7px']); ?>
                        <b style="font-weight: bold;color: #000;">Head Master</b>
                    </div>
                </div>
            </div>
        
        
        <div class="result-bg">
            <?php //echo $this->Html->image($watermarkLogo, ['width' => '240', 'class' => 'mainBgImage']); 
                    ?>
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
<style>
.routine table {
    width: 100%;
}

.routine th,
.routine td {
    /*font-style: italic;*/
    color: #000;
    font-weight: bold;
    border: 1px solid #000;
    padding: 0px;
    text-align: center;
}

.logo-box {
    margin-top: -193px;
    padding: 8px;
    display: inline-block;
}

.stuimG {
    border: 1px solid #000;
    margin-top: -5px;
    width: 106px;
    height: 108px;
    margin-left: 523px;
    /*margin-top: -5px;*/
    /*width: 106px;*/
    /*height: 131px;*/
    /*margin-left: 523px;*/
}

.imgLogo {
    margin-left: 10px;
    margin-bottom: 25px;
    width: 90px;
    height: 73px;
}

.room-no {
    margin-top: 33px;
    font-size: 23px;
    color: green;
    width: 22%;
    text-align: left;
    border: 1px solid #000;
    margin-left: 1px;
}




@media print {
    @page {
        size: A5 portrait;
        margin: 10mm 10mm 10mm 5mm; /* Top, Right, Bottom, Left — reduced left margin */
    }

    body {
        background: none !important;
        -webkit-print-color-adjust: exact;
    }

    .ExbtnWrap {
        display: none !important;
    }

    .wraperAdmit {
        page-break-after: always;
        border: 2px solid #000;
        padding: 15px;
        margin: 15px;
        box-sizing: border-box;

        /* Shift a little to the left */
        transform: translateX(-5mm);
    }

    .cutting-line {
        display: none !important;
    }

    .result-bg {
        background: none !important;
    }
}



</style>

</html>