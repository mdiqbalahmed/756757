<!DOCTYPE html>
<html lang="en">
<!doctype html>
<html lang="en">
<?php

use Cake\Core\Configure;


$instituteName = Configure::read('Result.instituteName');
$instituteLogo = Configure::read('Result.instituteLogo');
$borderImage = Configure::read('Result.borderImage');
$headerFontFamily = Configure::read('Result.headerFontFamily');
$headerFontCDN = Configure::read('Result.headerFontCDN');
$watermarkLogo = Configure::read('Result.watermarkLogo');
?>

<head>
    <meta charset="UTF-8">
    <title>Your Title Here</title>
    <style>

    </style>
</head>

<body class="scms-admitcard-print">

    <div class="slipWrapEx">
        <ul class="slipul">
            <?php if (!empty($students)) {
                $count = 1;
                foreach ($students as $student) {
                    // echo "<pre>";
                    //    print_r($term);die;
                    //                $defaultPath = '/images/images/default-' . (empty($student['Student']['gender']) || $student['Student']['gender'] == 'Female' ? 'girl' : 'boy') . '.png';
                    //                $thumbPath = trim($student['Student']['thumbnail']);
                    //
                                   $thumbPath = empty($thumbPath) ? $defaultPath : '/img/student/thumbnail/' . $thumbPath;
            ?>
                    <li <?php echo (($count++ % 8) == 0); ?>>
                        <div class="schoolIdentityslip">
                            <p class="text-center mb-0" style="font-family: <?= $headerFontFamily ?>">
                                <?= $instituteName ?>
                            </p>


                            <div class="hdrText">
                            </div><!-- end of hdrText -->
                        </div>
                        <div class="slipimg">
                            <?php
                            echo $this->Html->image('/webroot/img/demo.jpg', ['alt' => 'logo', 'style' => "width:65px;height:65px;border: 5px solid #d2cdcd;"]); ?>
                        </div>
                        <div class="sliptitle"><?php echo $term[0]['term_name'] . '-' . $student['session_name']; ?></div>

                        <p>Student : <i><?php echo $student['name']; ?></i></p>
                        <p>ID : <?php echo $student['sid']; ?><span>Roll : <?php echo $student['roll']; ?></span></p>
                        <p>Class : <?php echo ((!empty($student['class'])) ? $student['class'] : 'N/A'); ?><span>Section : <?php echo ((!empty($student['section'])) ? $student['section'] : 'N/A'); ?></span></p>
                    </li>
            <?php    }
            } ?>
        </ul>
    </div>

</body>

</html>
