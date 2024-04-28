<?php
// Function to add an employee to the database
function addEmployee($fullName, $username, $password)
{
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

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL to insert data into the employee table
    $sql = "INSERT INTO employee (full_name, username, password) VALUES ('$fullName', '$username', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    // Close the database connection
    $conn->close();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["fullName"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the data if needed (you may add additional validation here)

    // Add the employee
    $result = addEmployee($fullName, $username, $password);

    // Check the result and provide feedback
    if ($result) {
        $message = "Employee added successfully.";
    } else {
        $message = "Error adding employee.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees</title>
</head>
<body>



<?php
// Display feedback message if available
if (isset($message)) {
    echo "<p>$message</p>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="fullName">Full Name:</label>
    <input type="text" id="fullName" name="fullName" required><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    
</form>

</body>
</html>
