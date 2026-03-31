<?php
$imgPath = WWW_ROOT . 'uploads' . DS . 'logo1.png';
$src = file_exists($imgPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($imgPath)) : '';
?>

<?php
$this->layout = 'report';
?>
<style>
    @page {
        size: A4 portrait;
        margin: 0;

    }
  .content {

        margin-top: 0px;
    }

    .p {
        width: 210mm;
        /* A4 width */
        height: 297mm;
        margin: 0 auto;
        padding: 0;
        background: white;
        zoom: 100%;
        border: 12px solid skyblue;
        font-size: 12px;
        /* top: -12mm;
        left: -12mm;
        right: -12mm;
        bottom: -12mm; */
    }

    .logo-wrapper {
        position: absolute;
        top: 300px;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 500px;
        background-image: url("<?php echo $src; ?>");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        opacity: 0.1;
        pointer-events: none;
        z-index: 0;

    }

    /* Optional: hide elements that should not appear in print */
    .no-print {
        display: none;
    }

    @media print {
        .logo-wrapper {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            background-image: url("<?php echo $src; ?>") !important;
        }
        
        .print-center {
            position: absolute !important;
            top: 0% !important;
            left: 0% !important;
            transform: translate(0%, 0%) !important;
        }
    }

    .form-container {
        width: 100%;
        font-weight: 500;
        padding: 22px;
        font-weight: 600;
        margin-top: -22px;
    }

    .row {
        margin-bottom: 9px;
    }

    .label {

        min-width: 150px;
    }

    .dots {
        border-bottom: 1px solid #000;
        margin-left: 5px;
        padding-left: 4px;
        /* text-align: center; */
        font-weight: 600;

    }

    .dots:empty::after {
        content: '\00a0';
    }

    .inline {

        margin-right: 15px;
    }

    .signature-section {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .signature-box {
        text-align: center;
        width: 300px;
    }

    .signature-line {
        border-top: 1px solid #000;
        margin-top: 60px;
        padding-top: 5px;

    }

    .form-title {
        display: inline-block;
        border: 2px solid #28a745;
        /* green border */
        border-radius: 20px;
        /* rounded corners */
        padding: 5px 20px;
        /* font-size: 20px; */
        font-weight: bold;
        color: #000;
        font-family: "SolaimanLipi", sans-serif;
        /* Bangla font */
    }

    /* .declaration {
        margin: 20px 0;
        text-align: justify;
    } */
</style>

<button class="download-btn" onclick="generatePDF()" style="margin: 20px; padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
    Download PDF
</button>

<button class="print-btn" onclick="window.print()"
    style="margin: 20px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
    Print
</button>

<div id="admission-form" class="p print-center" style="">
    <div class="logo-wrapper"></div>
    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <?= $this->Html->image('/webroot/uploads/logo1.png', array(
            "alt" => "Header Image",
            "style" => "width:86px; height: 88px;"
        )); ?>
        <div style="flex: 1; text-align: center;">
            <P style="margin: 0; font-weight: 900; font-size: 22PX; margin-top: -40px;">
                দিনাজপুর সরকারি বালিকা উচ্চ বিদ্যালয়, দিনাজপুর
            </P>

           <div class="form-title">ভর্তি ফরম- 2026</div>
        </div>


        <?= $this->Html->image('/webroot/uploads/students/thumbnail/' . $student['thumbnail'], array(
            "alt" => "Header Image",
            "style" => "width:120px; height: 110px; border: 1px solid #000; margin-right: 5px;
    margin-top: 5px;"
        )); ?>
    </div>

    <div class="form-container">
         <div class="row">
            ক্রমিক নম্বর :
            <span class="dots" style="width:165px;"><?= $student['serial'] ?></span>
        </div>
        <div class="row">
            জিএসএ ইউজার আইডি:
            <span class="dots" style="width:165px;"><?= $student['gsa_id'] ?></span>
            শ্রেণি:
            <span class="dots" style="width:120px;"><?= $student['level'] ?></span>
            শাখা:
            <span class="dots" style="width:120px; "><?= $student['section'] ?></span>
        </div>

        <div class="row">
            ১। ছাত্রীর পূর্ণ নাম (বাংলায়):
            <span class="dots" style="width:597px;"><?= $student['name_bangla'] ?></span>
        </div>

        <div class="row">
            ছাত্রীর পূর্ণ নাম (ইংরেজিতে):
            <span class="dots" style="width:592px;"><?= $student['name_english'] ?></span>
        </div>

        <div class="row">
            জন্ম তারিখ:
            <span class="dots" style="width:130px;"><?= $student['date_of_birth'] ?></span>
            জন্ম নিবন্ধন নম্বর:
            <span class="dots" style="width:286px;"><?= $student['birth_reg'] ?></span>
            রক্তের গ্রুপ:
            <span class="dots" style="width:90px;"><?= $student['blood_group'] ?></span>
        </div>

        <div class="row">
            পূর্বের বিদ্যালয়ের নাম ও শ্রেণি:
            <span class="dots" style="width:580px;"><?= $student['pre_school'] ?></span>
        </div>

        <div class="row">
            ধর্ম:
            <span class="dots" style="width:120px;"><?= $student['religion'] ?></span>
            জাতীয়তা: বাংলাদেশী
            যে মোবাইলের এসএমএস পেতে আইডি:
            <span class="dots" style="width:257px;"><?= $student['mobile'] ?></span>
        </div>
        <div class="row">
            ২। পিতার পূর্ণ নাম (বাংলায়):
            <span class="dots" style="width:595px;"><?= $student['bn_fname'] ?></span>
        </div>

        <div class="row">
            পিতার পূর্ণ নাম (ইংরেজিতে):
            <span class="dots" style="width:590px;"><?= $student['fname'] ?></span>
        </div>

        <div class="row">
            পিতার পেশা:
            <span class="dots" style="width:220px;"><?= $student['foccupation'] ?></span>
            পিতার মোবাইল নাম্বার:
            <span class="dots" style="width:324px;"><?= $student['fmobile'] ?></span>
        </div>

        <div class="row">
            পিতার বার্ষিক আয়:
            <span class="dots" style="width:150px;"><?= $student['fincome'] ?></span>
            পিতার জাতীয় পরিচয়পত্র নম্বর:
            <span class="dots" style="width:312px;"><?= $student['f_nid'] ?></span>
        </div>
        <div class="row">
            ৩। মাতার পূর্ণ নাম (বাংলায়):
            <span class="dots" style="width:595px;"><?= $student['bn_mname'] ?></span>
        </div>

        <div class="row">
            মাতার পূর্ণ নাম (ইংরেজিতে):
            <span class="dots" style="width:592px;"><?= $student['mname'] ?></span>
        </div>

        <div class="row">
            মাতার পেশা:
            <span class="dots" style="width:220px;"><?= $student['moccupation'] ?></span>
            মাতার মোবাইল নাম্বার:
            <span class="dots" style="width:324px;"><?= $student['mmobile'] ?></span>
        </div>

        <div class="row">
            মাতার বার্ষিক আয়:
            <span class="dots" style="width:150px;"><?= $student['mincome'] ?></span>
            মাতার জাতীয় পরিচয়পত্র নম্বর:
            <span class="dots" style="width:312px;"><?= $student['m_nid'] ?></span>
        </div>

        <div class="row">
            ৪। বর্তমান ঠিকানা: বাড়ি নম্বর
            <span class="dots" style="width:140px;"><?= $currAdd[0] ?? '' ?></span>
            গ্রাম/মহল্লা:
            <span class="dots" style="width:202px;"><?= $currAdd[1] ?? '' ?></span>
            মৌজা:
            <span class="dots" style="width:137px;"><?= $currAdd[2] ?? '' ?></span>
        </div>

        <div class="row" style="margin-left: 90px;">
            ডাকঘর:
            <span class="dots" style="width:140px;"><?= $currAdd[3] ?? '' ?></span>
            উপজেলা:
            <span class="dots" style="width:180px;"><?= $currAdd[4] ?? '' ?></span>
            জেলা:
            <span class="dots" style="width:175px;"><?= $currAdd[5] ?? '' ?></span>
        </div>

        <div class="row">
            ৫। স্থায়ী ঠিকানা: বাড়ি নম্বর
            <span class="dots" style="width:140px;"><?= $permAdd[0] ?? '' ?></span>
            গ্রাম/মহল্লা:
            <span class="dots" style="width:202px;"><?= $permAdd[1] ?? '' ?></span>
            মৌজা:
            <span class="dots" style="width:146px;"><?= $permAdd[2] ?? '' ?></span>
        </div>

        <div class="row" style="margin-left: 90px;">
            ডাকঘর:
            <span class="dots" style="width:140px;"><?= $permAdd[3] ?? '' ?></span>
            উপজেলা:
            <span class="dots" style="width:180px;"><?= $permAdd[4] ?? '' ?></span>
            জেলা:
            <span class="dots" style="width:175px;"><?= $permAdd[5] ?? '' ?></span>
        </div>
        <div class="row">
            ৬। পূর্বে/পরবর্তী কর্তৃপক্ষের অভিভাবকের নাম:
            <span class="dots" style="width:265px;"><?= $student['aname'] ?></span>
            তাদের সাথে সম্পর্ক:
            <span class="dots" style="width:112px;"><?= $student['relation'] ?></span>
        </div>

        <div class="row" style="margin-left: 90px;">
            বাড়ি নম্বর:
            <span class="dots" style="width:140px;"><?= $Add[0] ?? '' ?></span>
            গ্রাম/মহল্লা:
            <span class="dots" style="width:192px;"><?= $Add[1] ?? '' ?></span>
            মৌজা:
            <span class="dots" style="width:140px;"><?= $Add[2] ?? '' ?></span>
        </div>

        <div class="row" style="margin-left: 90px;">
            ডাকঘর:
            <span class="dots" style="width:140px;"><?= $Add[3] ?? '' ?></span>
            উপজেলা:
            <span class="dots" style="width:180px;"><?= $Add[4] ?? '' ?></span>
            জেলা:
            <span class="dots" style="width:175px;"><?= $Add[5] ?? '' ?></span>
        </div>

        <div class="row">
            এই মর্মে ঘোষণা করছি যে, উল্লেখিত সকল তথ্যাদি সম্পূর্ণ সঠিক। যে কোন তথ্য ভুল প্রমাণিত হলে কর্তৃপক্ষের যে কোন সিদ্ধান্ত
            মেনে নিতে বাধ্য থাকবো। আমি আরও অঙ্গিকার করছি যে, বিদ্যালয়ের সকল নিয়ম-কানুন মেনে চলবো।
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">ছাত্রীর নাম ও স্বাক্ষর</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">পিতা/মাতা/অভিভাবকের নাম ও স্বাক্ষর</div>
            </div>
        </div>
        <div style="border-top: 2px dotted #000; margin-top: 20px; padding: 15px;">
            <div style="text-align: center; font-weight: bold; margin-bottom: 20px;">(অফিস কর্তৃক পূরণীয়)</div>
            
          <div class="row">
                        শিক্ষার্থী আইডি নম্বর:
                        <span class="" style="width:325px;"></span>
                        কোটা: <span class="dots" style="width:238px;"><?= $student['quota'] ?></span>
                    </div>

            <div class="row" style="margin-top: 15px;">
                <span class="dots" style="width:100px;"></span> শ্রেণির <span class="dots" style="width:100px;"></span> শাখায় ভর্তি করা হলো।
                <span style="margin-left: 110px;"></span>
             
            </div>

            <div class="signature-section" style="margin-top: 10px;">
                <div class="signature-box">
                    <div class="signature-line">শ্রেণি শিক্ষকের নাম ও স্বাক্ষর</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line">প্রধান শিক্ষকের নাম ও স্বাক্ষর</div>
                </div>
            </div>
        </div>
    </div>


</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<!-- <script>
    function generatePDF() {
        // Get the element by ID (not class)
        const element = document.getElementById('admission-form');

        const opt = {
            margin: 0,
            filename: 'admission-form-2025.pdf',
            image: {
                type: 'jpeg',
                quality: 0.9
            },
            html2canvas: {
                scale: 2,
                useCORS: true,
                allowTaint: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(element).save();
    }
</script> -->
<script>
    function generatePDF() {
        const element = document.getElementById('admission-form');

        const opt = {
            margin: 0,
            filename: 'admission-form.pdf',
            image: {
                type: 'jpeg',
                quality: 0.9 // full quality image
            },
            html2canvas: {
                scale: 1.5, // increase scale (2 = default, 3–5 gives sharper text/images)
                useCORS: true,
                allowTaint: true,
                logging: false
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait',
                precision: 18 // improve vector/text precision in PDF
            }
        };

        html2pdf().set(opt).from(element).save();
    }
</script>