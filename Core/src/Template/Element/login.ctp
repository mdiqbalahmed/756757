<style>
 .narrow_field>input {
        height: 75%;
    }

    .loader-container {
        display: none;
    }

    .loader {
        width: 0;
        height: 5px;
        background: repeating-linear-gradient(45deg, #000, #b90000);
        position: fixed;
        top: 0;
        left: 0;
        animation: loading 0.75s linear infinite;
    }

    @keyframes loading {
        0% {
            width: 0;
        }

        100% {
            width: 100%;
        }
    }

    /* Responsive adjustments */
    .user_comment .row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .user_comment .col-5,
    .user_comment .col-2 {
        padding: 5px;
    }

    @media (max-width: 767px) {

        .user_comment .col-5,
        .user_comment .col-2 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .user_comment .row {
            flex-direction: column;
        }

        .user_comment input,
        .user_comment button {
            width: 100%;
            height: auto;
            font-size: 16px;
        }

        .user_comment button {
            margin-top: 10px;
        }
    }
</style>
<?= $this->Form->create('User', ['id' => 'form2', 'class' => 'visible-class']); ?>
<div class="fleft user_comment">
    <div class="row" style="height: 75%;">
        <div class="col-5 mt-2">
            <input name="username" type="text" class="form-control narrow_field" placeholder="ব্যবহারকারী:" required>
        </div>
        <div class="col-5 mt-2">
            <input name="password" type="password" class="form-control narrow_field" placeholder="গোপন নং:" required>
        </div>
        <div class="col-2 mt-2">
            <button type="submit" class="subbtn2 btn btn-light text-center">
                <?= __d('boxes', 'পাঠান') ?>
            </button>
        </div>
    </div>
</div>

<?php echo $this->Form->end(); ?>
<span class="loader-container">
    <span class="loader"></span>
</span>

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
        $('#form2').submit(function(e) {
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

<!-- LOGIN ACTION PERFORM AS THE ELEMENT PAGE -->
