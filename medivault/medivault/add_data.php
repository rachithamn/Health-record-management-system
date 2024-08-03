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

// Fetch user ID from session
$user_id = $_SESSION['user_id'];

// Check if all required fields are provided
if (!isset($_POST['symptom_name'], $_POST['symptom_description'], $_POST['diagnosis_description'], $_POST['medication_name'], $_POST['dosage'], $_POST['frequency'], $_POST['start_date'], $_POST['end_date'])) {
    echo "Missing required input fields.";
    exit();
}

// Get values from form
$symptom_name = $_POST['symptom_name'];
$symptom_description = $_POST['symptom_description'];
$diagnosis_description = $_POST['diagnosis_description'];
$medication_name = $_POST['medication_name'];
$dosage = $_POST['dosage'];
$frequency = $_POST['frequency'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Escape input values to prevent SQL injection
$symptom_name = mysqli_real_escape_string($conn, $symptom_name);
$symptom_description = mysqli_real_escape_string($conn, $symptom_description);
$diagnosis_description = mysqli_real_escape_string($conn, $diagnosis_description);
$medication_name = mysqli_real_escape_string($conn, $medication_name);
$dosage = mysqli_real_escape_string($conn, $dosage);
$frequency = mysqli_real_escape_string($conn, $frequency);
$start_date = mysqli_real_escape_string($conn, $start_date);
$end_date = mysqli_real_escape_string($conn, $end_date);

// Check if the symptom already exists in the Symptoms table
$sql_check_symptom = "SELECT SymptomID FROM Symptoms WHERE Name = '$symptom_name'";
$result_check_symptom = mysqli_query($conn, $sql_check_symptom);

if (mysqli_num_rows($result_check_symptom) > 0) {
    // Symptom already exists, update its description
    $row = mysqli_fetch_assoc($result_check_symptom);
    $symptom_id = $row['SymptomID'];
    $sql_update_symptom = "UPDATE Symptoms SET Description = '$symptom_description' WHERE SymptomID = '$symptom_id'";
    mysqli_query($conn, $sql_update_symptom);
} else {
    // Symptom does not exist, insert a new record
    $sql_insert_symptom = "INSERT INTO Symptoms (Name, Description) VALUES ('$symptom_name', '$symptom_description')";
    mysqli_query($conn, $sql_insert_symptom);
    // Get the auto-generated SymptomID
    $symptom_id = mysqli_insert_id($conn);
}

// Insert diagnosis data into database
$sql_insert_diagnosis = "INSERT INTO Diagnoses (UserID, SymptomID, DiagnosisDescription) VALUES ('$user_id', '$symptom_id', '$diagnosis_description')";
mysqli_query($conn, $sql_insert_diagnosis);

// Get the auto-generated DiagnosisID
$diagnosis_id = mysqli_insert_id($conn);

// Insert medication data into database
$sql_insert_medication = "INSERT INTO Medications (DiagnosisID, Name, Dosage, Frequency, StartDate, EndDate) VALUES ('$diagnosis_id', '$medication_name', '$dosage', '$frequency', '$start_date', '$end_date')";
mysqli_query($conn, $sql_insert_medication);

// Check for errors
if (mysqli_errno($conn) !== 0) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data inserted successfully.";
}

// Close database connection
mysqli_close($conn);
?>