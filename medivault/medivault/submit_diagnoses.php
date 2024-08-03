<?php
// Database connection
$servername = "localhost"; // Change this according to your database server
$username = "username"; // Change this according to your database username
$password = "password"; // Change this according to your database password
$dbname = "your_database_name"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_id = $_POST['user_id'];
$symptom_id = $_POST['symptom_id'];
$diagnosis_description = $_POST['diagnosis_description'];
$medication_name = $_POST['medication_name'];
$dosage = $_POST['dosage'];
$frequency = $_POST['frequency'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Insert diagnosis
$sql = "INSERT INTO Diagnoses (UserID, SymptomID, Date, DiagnosisDescription) VALUES ('$user_id', '$symptom_id', NOW(), '$diagnosis_description')";

if ($conn->query($sql) === TRUE) {
    $diagnosis_id = $conn->insert_id;
    // Insert medication
    $sql_medication = "INSERT INTO Medications (DiagnosisID, Name, Dosage, Frequency, StartDate, EndDate) VALUES ('$diagnosis_id', '$medication_name', '$dosage', '$frequency', '$start_date', '$end_date')";
    if ($conn->query($sql_medication) === TRUE) {
        echo "Diagnosis and Medication added successfully.";
    } else {
        echo "Error: " . $sql_medication . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
