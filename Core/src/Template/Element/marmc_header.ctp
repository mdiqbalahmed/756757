<?php

use Croogo\Core\Controller\StudentsController;
use Cake\Core\Configure;

$siteTitle = Configure::read('Site.title');
$siteLogo = Configure::read('Site.Logo');
$siteTemplate = Configure::read('Site.template');
$siteSortForm = Configure::read('Site.sortForm');
$siteEmail = Configure::read('Site.email');
$sitePhone = Configure::read('Site.phone');


$StudentsController = new StudentsController();
$sessionData  = $StudentsController->sessionStudent();
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
?>

<style>
    .login-header {
        border: none;
    }

    .login-footer {
        border: none;
    }

    .login-content {
        border-radius: 20px;
        padding: 1em 1.25em;
        background: #f7fafc;
    }

    .login-input {
        border: 1px solid #c9c9c9 !important;
    }

    .login-input:focus {
        border-color: #0fb78d !important;
    }

    @media(min-width: 701px) {
        .logo-position{
        display:flex;
        align-items: center;
        }
    }
</style>


<nav class="site-nav mb-5">
    <div class="pb-2 top-bar mb-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-lg-9">
                    <a href="#" class="small mr-3"> <i class="fa fa-question-circle mr-2"></i> <span class="d-none d-lg-inline-block">Have a
                            question?</span></a>
                    <a href="tel:<?= $sitePhone ?>" class="small mr-3"> <i class="fa fa-phone mr-2"></i> <span class="d-none d-lg-inline-block"><?= $sitePhone ?></span></a>
                    <a href="mailto:<?= $siteEmail ?>" class="small mr-3"><i class="fa fa-envelope mr-2"></i> <span class="d-none d-lg-inline-block"><span class="__cf_email__"><?= $siteEmail ?></span></span></a>
                </div>


                <?php
                if (isset($sessionData)) { ?>

                    <div class="col-6 col-lg-3 text-right">
                        <a href="<?= $siteURL ?>" class="small mr-3">
                            <i class="fa fa-dashboard mr-2"></i>
                            Dashboard
                        </a>
                        <a href="<?= $logoutURL ?>" class="small mr-3">
                            <i class="fa fa-unlock mr-2"></i>
                            Log Out
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="col-6 col-lg-3 text-right">
                        <a data-toggle="modal" data-target="#exampleModalCenter" class="small mr-3">
                            <i class="fa fa-lock mr-2"></i>
                            Log In
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div id="sticky-wrapper" class="sticky-wrapper" style="height: 42.3906px;">
        <div class="sticky-nav js-sticky-header">
            <div class="container position-relative">
                <div class="site-navigation text-center">
                    <div class="row">
                        <div class="col-md-2 logo-position">
                            <a href="./" class="medical_logo menu-absolute m-0"><?= $this->Html->image($siteLogo, ['alt' => $siteTitle, 'class' => 'ftr_logo']); ?> <?= $siteSortForm ?></a>
                        </div>
                        <div class="col-md-10">
                            <?= $this->element('marmc_webmenu'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<?= $this->Form->create(null, ['url' => ['plugin' => 'Croogo/Core', 'controller' => 'Students', 'action' => 'userLoginAjax'], 'id' => 'marmcform2', 'class' => 'visible-class']); ?>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content login-content">
            <div class="modal-header login-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Student Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mt-2">
                    <?= $this->Form->control('username', ['class' => 'form-control narrow_field login-input', 'placeholder' => 'Username(SID):', 'required' => true]); ?>
                </div>
                <div class="mt-2">
                    <?= $this->Form->control('password', ['class' => 'form-control narrow_field login-input', 'placeholder' => 'Password', 'required' => true]); ?>
                </div>
            </div>
            <div class="modal-footer login-footer">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>

<?php
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
$baseUrl = ($isHttps ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'];

if ($_SERVER['SERVER_PORT'] != ($isHttps ? 443 : 80)) {
    $baseUrl .= ':' . $_SERVER['SERVER_PORT'];
}
$baseUrl .= dirname($_SERVER['SCRIPT_NAME'], 2) . '/';
?>

<script>
    $(document).ready(function() {
        $('#marmcform2').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var username = $('input[name="username"]').val();
            var password = $('input[name="password"]').val();

            // Extracting the base URL (homepage URL) from the current URL
            var baseURL = <?= json_encode($baseUrl); ?>;
            var formData = {
                username: username,
                password: password
            };

            // Show the loader when the form is being submitted
            $('.loader-container').show();

            $.ajax({
                type: 'GET',
                cache: false,
                url: 'userLoginAjax',
                data: formData,
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.status === 'success') {
                        var dynamicURL = baseURL + "student_dashboard";
                        window.location.href = dynamicURL;
                    } else {
                        alert('Login failed: ' + response.message);
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                },
                complete: function() {
                    // Hide the loader when the form submission is complete
                    $('.loader-container').hide();
                }
            });
        });
    });
</script>
