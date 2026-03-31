<?php
use Cake\Core\Configure;
$siteTemplate = Configure::read('Site.template');
$paymentImage= Configure::read('Site.PaymentImage');
$paymentNote= Configure::read('Site.paymentNote');
if($siteTemplate== 2){$this->layout = 'default';} else { $this->layout = 'no_sidebar'; }
?>

<style>
    .mob {
        position: absolute;
        top: 41.7%;
        right: 21.5%;
        z-index: 1;
    }

    .ref {
        position: absolute;
        top: 78.7%;
        left: 24.5%;
        z-index: 1;
    }

    .bkash {
        position: relative;
    }

    .btmTop {
        text-align: center;
        font-size: 25px;
        cursor: pointer;
    }

    .account,
    .account:hover,
    .account {
        color: #212529;
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btmTop .account {
        margin-top: 18px
    }

    .btmTop {
        padding: 2em;
        background: #f0f8ff;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .btmTop p {
        font-weight: 600;
    }
</style>
<?php if($siteTemplate== 2){ ?>
<div class="container my-3">
<?php } else { ?>
<div >
<?php } ?>
<div class="regWrap">
    <?php if (!empty($newAdmitter)) { ?>
        <h2>Congratulation!! Your registration has been completed successfully.</h2>
    <?php } ?>
    <div class="regCont">
        <?php if (!empty($newAdmitter)) { ?>
            <div class="studentInfo">
                <div class="infobox">Reference/Ref Number: <span><?php echo $newAdmitter['ref']; ?></span></div>
                <div class="infobox">Student Name: <span><?php echo $newAdmitter['name']; ?></span></div>
                <div class="infobox">Father`s Name: <span><?php echo $newAdmitter['fname']; ?></span></div>
                <div class="infobox">Mother`s Name: <span><?php echo $newAdmitter['mname']; ?></span></div>
            </div><!--End of studentInfo-->
        <?php } ?>

        <div class="bkash">
            <?= $this->Html->image($paymentImage); ?>
        </div>

        <div class="btmTop">
            <?= $paymentNote ?>
            <button class="btn btn-lg btn-warning"><?php echo $this->Html->link('Admit Card', '/admitcard', array('class' => 'account', 'target' => '_blank')); ?></button>
        </div>
    </div><!--End of regCont-->

</div>
</div><!--End of regWrap-->
