<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);

    .login-page {
        width:  440px;
        padding: 8% 0 0;
        margin: auto;
    }

    .student-login-form {
        position: relative;
        z-index: 1;
        background: #FFFFFF;
        max-width: 440px;
        margin: 0 auto 100px;
        padding: 45px;
        text-align: left;
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }

    .student-login-form input {
        font-family: "Roboto", sans-serif;
        outline: 0;
        background: #f2f2f2;
        width: 100%;
        border: 0;
        margin: 0 0 15px;
        padding: 15px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .student-login-form button {
        font-family: "Roboto", sans-serif;
        text-transform: uppercase;
        outline: 0;
        background: #4CAF50;
        width: 100%;
        border: 0;
        padding: 15px;
        color: #FFFFFF;
        font-size: 14px;
        -webkit-transition: all 0.3 ease;
        transition: all 0.3 ease;
        cursor: pointer;
    }

    .student-login-form button:hover,
    .student-login-form button:active,
    .student-login-form button:focus {
        background: #43A047;
    }

    .student-login-form .message {
        margin: 15px 0 0;
        color: #b3b3b3;
        font-size: 12px;
    }

    .student-login-form .message a {
        color: #4CAF50;
        text-decoration: none;
    }

    .student-login-form .register-form {
        display: none;
    }

    .student-login-form label {
        text-align: left !important;
    }
</style>

<?php $this->Form->unlockField('username'); ?>
<?php $this->Form->unlockField('password'); ?>
<?= $this->Form->create(null, ['url' => ['plugin' => 'Croogo/Core', 'controller' => 'Students', 'action' => 'loginForm'], 'id' => 'form2', 'class' => 'visible-class']); ?>
<div class="login-page">
    <div class="student-login-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </div>

</div>
<?php echo $this->Form->end(); ?>

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
                type: 'POST', // Use POST instead of GET for security
                cache: false,
                url: 'loginForm',
                data: formData,
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.status === 'success') {
                        // Redirect to the dashboard URL returned by the server
                        window.location.href = response.redirectURL;
                    } else {
                        // Display error message to the user
                        alert('Login failed: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Display more informative error message to the user
                    alert('Login failed: ' + error);
                }
            });
        });
    });
</script>

<!-- LOGIN ACTION PERFORM AS THE ELEMENT PAGE -->
