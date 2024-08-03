<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'db_connection.php';

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user from database based on username/email
    $sql = "SELECT * FROM Users WHERE Username = '$username' OR Email = '$username'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $row['PasswordHash'])) { // Corrected column name from 'PasswordHash' to 'Password'
            // Password is correct, start session and redirect to dashboard
            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['username'] = $row['Username'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect, display error message
            $error_message = "Incorrect username/email or password.";
        }
    } else {
        // User does not exist, display error message
        $error_message = "User does not exist.";
    }

    // Close database connection
    mysqli_close($conn);
}
?>
