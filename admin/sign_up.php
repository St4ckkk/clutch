<?php
// Include your configuration file and any necessary classes
require_once('../config.php');
// You might need to include your User class or any other related classes

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and save user data (you need to implement this)
    $result = saveUser($_POST); // You should implement the saveUser function

    if ($result === 1) {
        // User registration successful, redirect to login page or any other page
        header('Location: login.php');
        exit;
    } else {
        $error_message = 'Error during registration. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        User Registration
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <!-- Add more fields as needed for your user registration form -->

                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include necessary scripts or libraries if needed -->

</body>

</html>
