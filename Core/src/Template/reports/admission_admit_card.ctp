<?php

$this->layout = 'report';

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

<style>
    .admHdr {
        display: flex;
        justify-content: space-between;
        padding-left: 1em;
        padding-right: 1em;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

.admwraperAdmit {
  width: 755px;
  height: 500px;
  /* background: #fff url(../images/certificate-bg.png) no-repeat; */
  margin: 0 auto;
  font-family: "Times New Roman", Times, serif;
  color: #000;
  position: relative;
  background-color: #fff;
  overflow: hidden;
  border: 1px solid #fff;
}

    .admBgImage {
        position: absolute;
        top: 56%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 75%;
        opacity: 0.4;
        filter: grayscale(100%);
    }

    .admLogo {
        width: 12%;
        float: left;
        display: block;
    }

    .admSchoolIdentity .img-fluid {
        margin: 0;
        float: left;
    }

    .admSchoolIdentity>img {
        width: 100%;
    }

    .admSchoolIdentity {
        width: 70%;
    }

    .admSchoolIdentity>p {
        transform: scale(1, 1.5);
        font-size: 20px;
        padding-top: 0.5em;
    }

    .ExRegNo,
    .ExRollNo {
        font-family: 'libre-baskerville';
        line-height: 25px;
        float: left;
        background-color: rgb(231, 231, 231);
        border-radius: 10px;
        border: 2px dotted rgb(224, 213, 213);
        padding: 0px 10px;
        font-size: 15px;
        font-weight: bold;
        width: 150px;
        text-align: center;
    }

    .ExRollNo {
        margin-right: 143px;
        float: right;
    }

    .topMidEx big {
        display: flex;
        justify-content: space-around;
    }

    .admadmitExTop {
        border-bottom: 2px dotted #000;
        padding-bottom: 0.25em;
    }

    .admInfoTitle {
        width: 160px;
        padding: 0;
        margin: 0;
        font-size: 16px;
        line-height: 29px;
        color: #000;
        display: inline-block;
    }

    .admInfoName {
        width: 100%;
        padding: 0;
        margin: 0;
        margin-left: 1em;
        font-size: 16px;
        line-height: 20px;
        color: #000;
        display: inline-block;
        color: #000;
        border-bottom: 1px dotted #000;
    }

    .admExSign {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .admExSign b {
        border-top: 1px dashed #000000;
        display: block;
        font-weight: normal;
        text-align: center;
        font-family: 'libre-baskerville';
        color: #000;
        font-size: 12px;
    }

    .msgcont {
        font-size: 14px;
        text-align: justify;
    }

    .admSchoolIdentity h4,
    span.admID {
        font-weight: 800;
        color: darkgreen;
    }

    @media print {
        #admitPrint {
            /* transform: scale(1.42);
            transform-origin: top left; */
            page-break-before: always;
            width: 100%;
            height: auto;
            display: block;
            position: relative;
        }
        .ExbtnWrap{
            display:none;
        }

    }
</style>

<body class="scms-result-print" id="admitPrint">
    <div class="ExbtnWrap">
        <a class="btn btn-warning account" href="javascript:window.print();">প্রিন্ট করুন</a>
    </div>
    <?php
    $student = $admitter[0];
    if (!empty($student)) {
    ?>

    <div id="borderImg" class="admwraperAdmit" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 20 round;">
        <div class="admHdr">
            <div class="admLogo text-left">
                    <?php echo $this->Html->image($instituteLogo, ['alt' => 'logo']); ?>
            </div>
            <div class="admSchoolIdentity hdrInstitute">
                <p class="text-center mb-0" style="font-family: <?= $headerFontFamily ?>">
                        <?= $instituteName ?>
                </p>
                <h4 class="text-center mb-0">
                    Admit Card
                </h4>
                <div class="overlays">
                    <div class="textOverlay" style="border-image: url('<?= $this->Url->image($borderImage) ?>') 18 round;">
                    </div>
                </div>
                <!-- end of hdrText -->
            </div><!-- end of admSchoolIdentity -->
            <div class="admLogo text-left">
                    <?php echo $this->Html->image('/webroot/uploads/students/thumbnail/' . $student['photo'], ['alt' => 'Student Image']); ?>
            </div>
        </div><!-- end of admHdr -->
        <div class="admadmitExTop mb-1">
            <div class="topMidEx">
                <span class="ExClass"><?php echo 'Class ' . $student['level'] . ' Examination ' . $student['session']; ?></span>
                <big>
                    <span class="admExRegNo"><span class="admID">REF :</span> <?php echo $student['ref']; ?></span>
                    <span class="admExRollNo"><span class="admID">ROLL :</span> <?php echo $student['roll']; ?></span>
                </big>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                    

                <div class="admitBtmEx">
                    <div class="admiBtmtLftEx">
                        <div class="admitInfoEx">
                            <span class="admInfoTitle">Student's Name</span><i>:</i><span class="admInfoName"><?php echo $student['name']; ?></span>
                        </div>
                        <div class="admitInfoEx">
                            <span class="admInfoTitle">Father's Name</span><i>:</i><span class="admInfoName"><?php echo $student['fname']; ?></span>
                        </div>
                        <div class="admitInfoEx">
                            <span class="admInfoTitle">Mother's Name</span><i>:</i><span class="admInfoName"><?php echo $student['mname']; ?></span>
                        </div>
                        

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="admExSign">
                        <?php
                        echo $this->Html->image($headSign, ['alt' => 'Head Teacher Sign', 'style' => 'width:100px']); ?>
                    <b>Signature (Head Master)</b>
                </div>
            </div>
        </div>
        <div class="msgcont mt-2 px-2">
            <strong>পরীক্ষার বিষয় সমুহঃ</strong>প্লে হতে নার্সারি-২ঃ(মৌখিক পরীক্ষা); ১ম শ্রেণি হতে ৩য় শ্রেণিঃ(বাংলা, ইংরেজি, গনিত); ৪র্থ শ্রেণি হতে ৯ম শ্রেণি পর্যন্তঃ (বাংলা, ইংরেজি, গনিত, বিজ্ঞান)।
        </div>
        <div class="result-bg">
                <?php echo $this->Html->image($watermarkLogo, ['width' => '240', 'class' => 'admBgImage']); ?>
        </div>
    </div>
    <?php }
    ?>
</body>

</html>
