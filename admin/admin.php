<?php
// Database connection parameters
    $servername = "localhost"; // Corrected the spelling of localhost
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "expense_budget_db";
// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
    

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, usertype) VALUES (?, ?, ?)";
         
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_usertype);
            
            // Set parameters
            $param_username = $username;
            $param_password = md5($password);
            $param_usertype = $_POST["user_type"]; // Assuming user_type is passed from the form
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Create Account</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font: 16px sans-serif; /* Larger font size */
            background-image: url('brkdvlg.jpg');
            background-size: cover;
        }
        .wrapper {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent white */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 70%; /* Adjust the width of the button */
            height: 40px; /* Adjust the height of the button */
            font-size: 18px; /* Larger font size for the button text */
        }
        .create-account {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px; /* Larger font size for the heading */
        }
        .input-group {
            display: flex;
            justify-content: space-between;
        }
        .input-group label {
            flex: 0 0 45%; /* Adjust the width of the label */
            margin-right: 5%; /* Adjust the space between label and input */
            font-size: 16px; /* Larger font size for the label */
        }
        .input-group input, 
        .input-group select {
            flex: 0 0 50%; /* Adjust the width of the input/select */
            font-size: 16px; /* Larger font size for the input/select */
        }
        .center-btn {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="wrapper">
                    <h2 class="create-account">Create Account</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
                            </div>
                            <span class="text-danger"><?php echo $username_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <div class="input-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <span class="text-danger"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                            </div>
                            <span class="text-danger"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="user_type">User Type</label>
                                <select name="user_type" id="user_type" class="form-control">
                                    <option value="employee">Employee</option>
                                    <option value="admin">Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group center-btn">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
