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
<style>

.admit-separation-line {
    margin: 20px 0;
    
}

.admit-card-wrap {
    width: 806px;
    height: 579px;
    border: 1px solid #ccc;
    /*margin: 0 auto;*/
    position: relative;
    padding: 15px;
    box-sizing: border-box;
}


.page-break {
    page-break-after: always;
    margin-bottom: 40px;
}


@media print {
    .page-break {
        page-break-after: always;
    }
    .admit-card-wrap:last-child.page-break {
        page-break-after: auto;
        margin-bottom: 0;
    }
    a[href='javascript:window.print();'] {
        display: none !important;
    }
}
</style>

<head>
    <link href="https://fonts.cdnfonts.com/css/old-english-five" rel="stylesheet">
</head>

<a href="javascript:window.print();" style="
    position: fixed;
    top: 20px;
    right: 20px;
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
<?php
if (!empty($students)) {
    $count = 1;
    
    foreach ($students as $student) {
        ?>

        <!-- ADMIT CARD SECTION -->
        <div class="admit-card-wrap <?php echo ($count % 2 == 0) ? 'page-break' : ''; ?>">

            <!-- Header -->
            <div style="text-align:center; position: relative; height: 80px;">

    <?php 
    echo $this->Html->image($instituteLogo, [
        'alt' => 'Logo', 
        'style' => 'position:absolute; left:15px; top:0; height:80px;'
    ]); 
    ?>

    <?php
        
        echo $this->Html->image(
    '/webroot/uploads/students/thumbnail/' . $student['thumbnail'],
    [
        'alt' => 'Student Image',
        'style' => 'position:absolute; right:15px; top:0; height:80px; object-fit: cover; border: 1px solid #ccc;'
    ]
);
    
    ?>

    <!-- Centered Title -->
    <h1 style="font-family: 'Old English Five', sans-serif; font-size:28px; margin:0;">
        <?= $instituteName ?>
    </h1>
    <h2 style="margin:0; color:#1e541e;">Admit Card</h2>

</div>


            <!-- ID / Roll -->
            <div class="admitExTop">
                <div class="topMidEx">
                    <span class="ExClass"><?php echo $terms . ' - ' . $session; ?></span>
                    <big>
                        <span class="ExRegNo">ID : <?php echo $student['sid']; ?></span>
                        <span class="ExRollNo">Roll : <?php echo $student['roll']; ?></span>
                    </big>
                </div>
            </div>

            <!-- Watermark -->
            <?php echo $this->Html->image($watermarkLogo, [
                'alt' => 'Watermark',
                'style' => 'position: absolute;
                top: 149px;
                left: 50%;
                transform: translateX(-50%);
                opacity: 0.75;
                width: 286px;
                z-index: 0;'
            ]); ?>

            <!-- Student Info -->
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
                    <!--<div class="admitInfoEx newInfoEx">-->
                    <!--    <span class="infoTitleExNew">Working Days</span><i>:</i><span class="infoNameExNew"><?php echo $total; ?></span>-->
                    <!--    <span class="infoTitleExNew">Presence</span><i>:</i><span class="infoNameExNew">-->
                            <?php
                            // echo $student['count'] . ' Days';
                            ?>
                    <!--    </span>-->
                    <!--    <span class="infoTitleExNew">Percentage</span><i>:</i><span class="infoNameExNew">-->
                            <?php
                            // $new_percentage = number_format($student['percentage'], 2, '.', '');
                            // echo $new_percentage . ' %';
                            ?>
                    <!--    </span>-->
                    <!--</div>-->
                    <div class="msgcontEx" style="font-size: 14px; line-height: 1.5; color: #333;">
                        <strong>বিশেষ দ্রষ্টব্য:</strong> 
                        (১) প্রবেশপত্র ব্যতীত কেউ পরীক্ষা কক্ষে প্রবেশ করতে পারবে না। 
                        (২) পরীক্ষার সময় ইউনিফর্ম পরিধান করে আসা বাধ্যতামূলক। 
                        (৩) পরীক্ষার দিন কোনো পরীক্ষার্থী পরীক্ষা সংশ্লিষ্ট দ্রব্যাদি ব্যতীত অন্য কোনো কিছু (ব্যাগ, বই, নোট, খাতা ইত্যাদি) সাথে নিয়ে বিদ্যালয়ে প্রবেশ করতে পারবে না। 
                        (৪) পরীক্ষার্থীরা নন-প্রোগ্রামেবল সায়েন্টিফিক ক্যালকুলেটর ব্যবহার করতে পারবে। 
                        (৫) অনিবার্য কারণ বশত: কোনো পরীক্ষা স্থগিত হলে পরবর্তী পরীক্ষাসমূহ রুটিন অনুযায়ী চলবে এবং স্থগিত পরীক্ষার সময়সূচী নোটিশের মাধ্যমে পরে জানানো হবে।
                    </div>

                </div>
                <div class="eXsign-teacher">
                    <b style="margin-top:119px">Class Teacher</b>
                </div>
                <div class="eXsign-head" style="text-align:center">
                    <?php
                    echo $this->Html->image($headSign, ["alt" => "", 'style' => "margin-top:60px"]);
                    ?>
                    <b>Head Master</b>
                </div>
            </div>
        </div>

        <?php 
        // Add separation line after every admit card except the last one
        if ($count < count($students)) {
            echo '<div class="admit-separation-line"></div>';
        }

        $count++;
    }
    ?>

    

<?php
}
?>
