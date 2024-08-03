<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_connection.php';

// Check if ID parameter is provided
if (!isset($_GET['RecordID'])) {
    header("Location: editrecord.php");
    exit();
}

// Fetch health record details
$user_id = $_SESSION['user_id'];
$record_id = $_GET['RecordID'];
$sql_select = "SELECT * FROM HealthRecords WHERE RecordID = $record_id AND UserID = $user_id";
$result_select = mysqli_query($conn, $sql_select);

// Check if record exists and user has permission to edit it
if (mysqli_num_rows($result_select) == 0) {
    echo "No record found or you don't have permission to edit this record.";
    exit();
}

// Extract record data
$row = mysqli_fetch_assoc($result_select);

// Update health record if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $blood_pressure = $_POST['blood_pressure'];
    $cholesterol_level = $_POST['cholesterol_level'];
    $heart_rate = $_POST['heart_rate'];

    // Update health record in the database
    $sql_update = "UPDATE HealthRecords SET Date = '$date', Weight = $weight, Height = $height, BloodPressure = '$blood_pressure',
                   CholesterolLevel = $cholesterol_level, HeartRate = $heart_rate WHERE RecordID = $record_id AND UserID = $user_id";
    mysqli_query($conn, $sql_update);
    
    // Redirect to view records page after update
    header("Location: view_health_records.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>
