<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'db_connection.php';

    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // Query to insert user into database
    $sql = "INSERT INTO Users (Username, Email, PasswordHash, Age, Gender) VALUES ('$username', '$email', '$password', $age, '$gender')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        // Redirect to login page after successful signup
        header("Location: login.html");
        exit();
    } else {
        // Display error message if signup fails
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
