<?php
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

    // Query to retrieve user information (excluding password)
    $sql = "SELECT id, firstname, lastname, username, usertype, last_login, type, date_added, date_updated FROM users";
    $result = $conn->query($sql);

    // Delete user if user_id is provided in the POST request
    if(isset($_POST['user_id'])) {
        // Escape user ID to prevent SQL injection
        $user_id = $conn->real_escape_string($_POST['user_id']);

        // Prepare DELETE query
        $delete_sql = "DELETE FROM users WHERE id = '$user_id'";

        // Execute the DELETE query
        if ($conn->query($delete_sql) === TRUE) {
            echo "User deleted successfully";
            // Reload the page after successful deletion
            echo "<script>window.location.reload();</script>";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User History Log</title>
    <!-- Offline Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for card */
        .custom-card {
            background-color: black;
            color: white;
        }
        .justify-text {
            text-align: justify;
        }
    </style>
</head>
<body>

    <div class="container-fluid"> <!-- Use container-fluid to span the entire width -->
        <div class="row justify-content-center align-items-center" style="height: 100vh;"> <!-- Vertically center the card -->
            <div class="col-md-8"> <!-- Adjust the column width as needed -->
                <div class="card custom-card">
                    <div class="card-header">
                        <h2 class="card-title">Users Information</h2>
                    </div>
                    <div class="card-body justify-text"> <!-- Apply justify-text class to justify text -->
                        <table class="table table-bordered table-white">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>User Type</th>
                                    <th>Last Login</th>
                                    <th>Type</th>
                                    <th>Date Added</th>
                                    <th>Date Updated</th>
                                    <th>Action</th> <!-- New column for delete button -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Output data of each row
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["firstname"] . "</td><td>"
                                        . $row["lastname"] . "</td><td>" . $row["username"] . "</td><td>" . $row["usertype"] . "</td><td>"
                                        . $row["last_login"] . "</td><td>" . $row["type"] . "</td><td>"
                                        . $row["date_added"] . "</td><td>" . $row["date_updated"] . "</td>"
                                        . "<td><button class='btn btn-danger btn-sm' onclick='deleteUser(" . $row["id"] . ")'>Delete</button></td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>0 results</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offline Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- JavaScript for delete functionality -->
    <script>
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                // Send AJAX request to delete_user.php
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Display the response message
                        alert(this.responseText);
                    }
                };
                xhttp.open("POST", "", true); // This will post to the current URL (same script)
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("user_id=" + userId);
            }
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
