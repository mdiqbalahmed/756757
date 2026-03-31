<?php
use Cake\Core\Configure;
$siteTemplate = Configure::read('Site.template');

$this->layout = 'admission-form';
?>

<style>
    .topSubmittable {
        font-size: 22px;
        font-weight: 600;
        border-bottom: 2px solid #862424;
        padding-bottom: 0.25em;
    }

    .submitBox {
        padding: 3em;
        text-align: justify;
        background-color: rgb(251, 251, 251);
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-bottom: 4px solid rgb(17, 128, 192);
        margin-top: 10px !important;
    }

    .admInstuct {
        margin-top: 2em;
        font-weight: 600;
        font-size: 14px;
    }

    .submitForm {
        border-radius: 0 !important;
        padding: 1.5em 1em !important;
    }
</style>
<?php if($siteTemplate== 2){ ?>
<div class="container my-3">
<?php } else { ?>
<div >
<?php } ?>
<h3 class="topSubmittable">এডমিট কার্ড খুজে পেতে, নিচে ফরম পূরণ করে "Submit" বাটন টী চাপুন :</h3>
<?php echo $this->Form->create('Admission', array('action' => 'admitSearch')); ?>
<div class="submitBox">
    <?php if (!empty($validationErrors)) echo '<div class="error-message" style="color:#fff;padding:15px; background:#F99;margin:0 0 10px">' . (empty($validationErrors['pErr']) ? 'Please fill up the form correctly!' : $validationErrors['pErr']) . '</div>'; ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label" for="name">GSA ID</label>
                <?php echo $this->Form->text('gsa_id', array('class' => 'form-control submitForm', 'placeholder' => 'GSA ID')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="label" for="email">Birth Reg</label>
                <?php echo $this->Form->text('birth_reg', array('class' => 'form-control submitForm', 'placeholder' => 'Birth Reg')); ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-lg btn-success', 'div' => false)); ?>
            </div>
        </div>
    </div>
    <!--        <div class="admInstuct">
                বিস্তারিত তথ্যের জন্য এবং কোন জটিলতার সম্মুখীন হলে এই নম্বর গুলোতে তাৎক্ষনাত যোগাযোগ করুন। কলেজঃ ০১৭১৯৭৫০৪৬৫ (মোঃ ইয়াকুব আলী সহকারী শিক্ষক)<br>টেকনিক্যালঃ ০১৯৪১২০১২০৭, ০১৭০৮৫১৮৭২১, ০১৯৪১২০১২০৯
            </div>-->
</div><!--End of formWrap-->
</div>
<?php echo $this->Form->end(); ?>
