<style>
    #nav-container {
        background: #fff;
        width: auto;
        height: 40px;
        background: #1a1a1a;
    }

    .container_16 {
        margin-left: auto;
        margin-right: auto;
        width: calc(350px * <?= $copies ?> + 200px);
        display: flex;
        justify-content: center;

    }

    .container_12 .grid_12,
    .container_16 .grid_16 {
        width: 98%;
    }

    #main #content {
        margin-bottom: 20px;
        background: #696b75;
        padding: 5px 20px 5px 20px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-box-shadow: rgba(200, 200, 200, 1) 0 4px 18px;
        -webkit-box-shadow: rgba(200, 200, 200, 1) 0 4px 18px;
    }

    .receipt {
        width: 341px;
        height: 630px;
        border: 2px solid #000;
        padding: 5px;
        margin-right: 10px;
        background: #ffffff url(../images/receipt-bg.png) no-repeat center center;
        position: relative;
    }

    .receipt span {
        float: left;
        margin-left: 5px;
        line-height: 16px;
        font-style: italic;
        font-size: .9em;
    }

    .receipInner {
        margin: 10px 0;
    }

    .receipt table {
        background-color: transparent !important;
    }

    .receipt .striped {
        background-color: transparent !important;
    }

    table tr th {
        padding: 3px;
        background: #e5e5e5;
        color: #333;
        border-bottom: 0px;
        text-align: left;
        font-weight: bold;
    }

    .receipt table tr td {
        padding: 0 10px !important;
        vertical-align: middle;
        line-height: 13px;
        font-family: arial;
        font-size: 13px;
    }

    table tr td {
        padding: 10px;
        border-bottom: 1px solid #dfdfdf;
        vertical-align: middle;
    }

    .recipt_type {
        display: flex;
        justify-content: center;
    }

    .recipt_type>span {
        background: #8f8f8f;
        color: #fff;
        padding: 3px 10px;
        margin: 0 !important
    }

    .mainWtrMark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 75%;
        opacity: 0.4;
    }

    .RctBtnWrap {
        position: fixed;
        right: 1.5em;
        z-index: 999;
    }

    .btm_wrapper {
        display: flex;
        justify-content: space-around;
    }

    @media print {
        .RctBtnWrap {
            display: none;
        }
    }
</style>

<?php
use Cake\Core\Configure;

$headerFontFamily = Configure::read('Recipt.fontFamily');
$headerFontCDN = Configure::read('Recipt.fontCDN');
$instituteLogo = Configure::read('Recipt.siteLogo');
$instituteName = Configure::read('Recipt.siteTitle');
$addressLine = Configure::read('Recipt.addressLine');
$watermarkLogo = Configure::read('Recipt.waterMark');
$copies = Configure::read('Recipt.copies');

$date = date('d-m-Y', strtotime($transactions['transaction_date']));
// echo '<pre>';
// print_r($transactions);die;
?>


<?= $headerFontCDN ?>
<div class="RctBtnWrap mb-5" id="test">
    <a class="btn btn-lg btn-warning" href="javascript:window.print();">প্রিন্ট করুন</a>
</div>
<div id="main" class="container_16">
    <div class="grid_16">
        <div id="">
            <div class="btm_wrapper">
                <?php for ($i = 0; $i < $copies; $i++) { ?>
                    <div class="receipt" style="float:left">
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo $this->Html->image($instituteLogo, ['alt' => 'logo']); ?>
                            </div>
                            <div class="col-md-9">
                                <p class="text-center mb-0" style="font-size: 9pt;font-family: <?= $headerFontFamily ?>">
                                    <?= $instituteName ?>
                                </p>
                                <p class="text-center mb-0" style="font-size: 8pt;font-weight:500">
                                    <?= $addressLine ?>
                                </p>
                                <div class="recipt_type">
                                    <span style="font-size:8pt;font-style:normal">
                                        <strong>Money Recipt</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
  <?php if ($transactions['deleted']) { ?>
<div style="margin-top:-17px; margin-left:85px; padding-bottom:10px;">
   <span style="font-size:12pt;font-style:normal">
       <b style=" background-color: red; color:white; padding:5px;">Deleted</b>
    </span>
</div>
  <?php  } else if(!$transactions['payment_status']) { ?>
<div style="margin-top:-17px; margin-left:85px; padding-bottom:10px;">
   <span style="font-size:12pt;font-style:normal">
       <b style=" background-color: #0d6efd; color:white; padding:5px;">Unpaid</b>
    </span>
</div>
 <?php  }  ?>
                        <div class="receipInner mt-3">

                            <span style="margin-right:5px;color:#8f8f8f; float:left;width: 117px;">Date :<?= date('Y-m-d', strtotime($transactions['transaction_date'])); ?></span>
                            <span style="float:right; margin-right:5px;background-color:#8f8f8f;padding: 0px 5px;color: rgb(255, 255, 255);width: 188px;">TRN :<?= $transactions['trn_no'] ?></span>

                            <div class="row">
                                <div class="col-md-12">
                                    <span style="clear: left">Name : </span> <span style="width:80%; border-bottom:1px dotted #888;"><?= $transactions['name'] ?></span><br>
                                </div>
                          <?php if ($type == 'school_fees' || $type == 'Student') { ?>
                                <div class="col-md-8">
                                    <span style="clear:left">Student Id : </span><span style="border-bottom:1px dotted #888;"> <?= $transactions['student_sid'] ?></span>
                                </div>
                                <div class="col-md-4">
                                    <span>Class :</span><span style="border-bottom:1px dotted #888;"><?= $transactions['level_name'] ?></span>
                                </div>
                          <?php  }?>
                              
                                <div class="col-md-8">
                                    <span>Month : </span><span style="border-bottom:1px dotted #888;"><?= $months ?></span>
                                </div>
                                <div class="col-md-4">
                                    <span>Year : </span><span style="border-bottom:1px dotted #888;"><?= $transactions['session_name'] ?></span>
                                </div>
                            </div>


                        </div>
                        <table width="100%" style="border: 1px solid #dfdfdf">
                            <tbody>
                                <tr class="striped">
                                    <th width="80%" align="center" style="text-align:left;">Purpose</th>
                                    <th width="20%" align="center" style="text-align:right">Amount</th>
                                </tr>
                                <?php foreach ($purpose as $single_purpose) { ?>
                                    <tr>
                                        <td> <?= $single_purpose['purpose_name'] ?> </td>
                                        <td align="right"> <?= number_format((float) $single_purpose['amount'], 2, '.', '') ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table style="margin-top:-5px!important">
                            <tbody>
                                <tr class="striped">
                                    <td width="85%" style="text-align:center; font-weight:bold;  border: 1px solid #dfdfdf;"><?= $amount ?></td>
                                    <td width="15%" style="text-align:right; font-weight:bold;  border: 1px solid #dfdfdf;"><?= $total ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row" style="position: absolute;bottom: 5px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="text-center" style="border-top:2px solid #000; font-size:10pt; font-weight:600;">Checked By</div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-center" style="border-top:2px solid #000; font-size:10pt; font-weight:600;">Accountant</div>
                            </div>
                            <div class="col-md-1"></div>

                            <div class="col-md-12 text-center">
                                <div style="text-align: center; font-size:9pt; font-style:italic; text-transform: capitalize;">-=: Voucher By <?= $user_name ?> :=-</div>
                            </div>
                        </div>
                        <div class="result-bg">
                            <?php echo $this->Html->image($watermarkLogo, ['width' => '420', 'class' => 'mainWtrMark']); ?>
                        </div>
                    </div>
                <?php } ?>

            </div><!-- end of btm_wrapper-->
        </div>
    </div>
