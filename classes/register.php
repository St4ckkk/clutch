<?php
require_once('../config.php');
require_once('Users.php'); // Adjust the path accordingly

$users = new Users();


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $users->saveEmployee();
    $response = json_decode($result, true);

    if ($response['status'] === 'success') {
        $_SESSION['success_message'] = 'Registration successful. You can now log in.';
        header('Location: login.php');
        exit;
    } else {
        $error_message = isset($response['message']) ? $response['message'] : 'Registration failed.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>

<body class="hold-transition login-page bg-navy">
    <script>
        start_loader();
    </script>
    <h2 class="text-center mb-4 pb-3"><?php echo $_settings->info('name') ?></h2>
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <p class="login-box-msg text-dark">Register a new employee</p>

                <?php if (isset($error_message)) : ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <form id="register-frm" action="" method="post">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="img" class="control-label">Avatar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this, $(this))">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <img src="" alt="" id="cimg" class="img-fluid img-thumbnail">
                    </div>

                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                        <a href="login.php" class="btn btn-success btn-block">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            end_loader();
        });

        function displayImg(input, _this) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#cimg').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
