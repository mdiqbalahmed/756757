<?php

use Croogo\Core\Controller\StudentsController;

$contactsController = new StudentsController();
$sessionData  = $contactsController->sessionStudent();
$siteURL = $this->Url->build([
    "plugin" => "Croogo/Core",
    "controller" => "Students",
    "action" => "studentDashboard",
]);
$logoutURL = $this->Url->build([
    "plugin" => "Croogo/Core",
    "controller" => "Students",
    "action" => "userLogout",
]);
if (isset($sessionData)) { ?>
    <div class="fixedHdr">
        <div class="fxdFormCon" id="fxdFormConID">
            <?php echo $this->element('user_comments'); ?>
            <?php echo $this->element('login'); ?>
        </div>
        <div class="fx_hdr_wrap">
            <div class="fright">
                <a href="<?= $siteURL ?>" class="btn1">ড্যাশবোর্ড</a>
                <a href="javascript:void(0);" onclick="toggleForm('form1', this);" class="btn1">মন্তব্য <div class="fa fa-caret-down cr_1 rotate" aria-hidden="true"></div></a>
                <a href="<?= $logoutURL ?>"class="btn2">লগ আউট</a>
            </div>
        </div>
    </div>
<?php } else { ?>



    <div class="fixedHdr">
        <div class="fxdFormCon" id="fxdFormConID">
            <?php echo $this->element('user_comments'); ?>
            <?php echo $this->element('login'); ?>
        </div>
        <div class="fx_hdr_wrap">
            <div class="fright">
                <a href="javascript:void(0);" onclick="toggleForm('form1', this);" class="btn1">মন্তব্য <div class="fa fa-caret-down cr_1 rotate" aria-hidden="true"></div></a>
                <a href="javascript:void(0);" onclick="toggleForm('form2', this);" class="btn2">লগ ইন <div class="fa fa-caret-down cr_2 rotate" aria-hidden="true"></div></a>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    function toggleForm(formId, clickedElement) {
        var formContainer = $("#fxdFormConID");
        var form = $("#" + formId);
        var caretIcon1 = $(".cr_1");
        var caretIcon2 = $(".cr_2");

        // Check if the selected form is already visible
        var isFormVisible = form.is(":visible");

        // Hide all forms within the fxdFormConID
        formContainer.find("form").slideUp(800);

        // Display the selected form if it was not visible, otherwise hide it
        if (!isFormVisible) {
            form.slideDown(800);
        } else {
            form.slideUp(800);
        }

        caretIcon1.toggleClass("rotated", !isFormVisible);
        caretIcon2.toggleClass("rotated", !isFormVisible);

        // Check if cr_1 is clicked, remove rotated class from cr_2
        if ($(clickedElement).hasClass("cr_1")) {
            $(".cr_2").removeClass("rotated");
        }

        $(".btn1").not($(clickedElement).closest(".btn1")).find(".cr_1").removeClass("rotated");
        $(".btn2").not($(clickedElement).closest(".btn2")).find(".cr_2").removeClass("rotated");
    }
</script>
