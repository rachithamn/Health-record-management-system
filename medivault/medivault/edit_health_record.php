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
if (!isset($_GET['record_id'])) {
    header("Location: view_health_records.php");
    exit();
}

// Fetch health record details
$user_id = $_SESSION['user_id'];
$record_id = $_GET['record_id'];
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Health Record</title>
    <!-- Include CSS styles here -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Form to edit health record -->
<div class="container">
    <h2>Edit Health Record</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?record_id=" . $record_id); ?>">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $row['Date']; ?>" required><br><br>
        <label for="weight">Weight:</label>
        <input type="number" id="weight" name="weight" step="0.1" value="<?php echo $row['Weight']; ?>" required><br><br>
        <label for="height">Height:</label>
        <input type="number" id="height" name="height" value="<?php echo $row['Height']; ?>" required><br><br>
        <label for="blood_pressure">Blood Pressure:</label>
        <input type="text" id="blood_pressure" name="blood_pressure" value="<?php echo $row['BloodPressure']; ?>" required><br><br>
        <label for="cholesterol_level">Cholesterol Level:</label>
        <input type="number" id="cholesterol_level" name="cholesterol_level" value="<?php echo $row['CholesterolLevel']; ?>" required><br><br>
        <label for="heart_rate">Heart Rate:</label>
        <input type="number" id="heart_rate" name="heart_rate" value="<?php echo $row['HeartRate']; ?>" required><br><br>
        <button type="submit">Update Record</button>
    </form>
</div>

</body>
</html>
