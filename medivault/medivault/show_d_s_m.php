<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Health Data</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-image: url('Download premium image of Pink gradient plain background by marinemynt about plain background, gradient background, abstract, backgrounds, and abstract backgrounds 2344572.jpeg'); /* Replace 'background_image.jpg' with the path to your background image */
            background-size: cover;
    background-position: center;
    }
    h1 {
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: rgba(255, 255, 255, 0.3); 
    }
    table, th, td {
        border: 1px solid #ccc;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>
    <h1>Your Health Data</h1>
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

    // Query to fetch data
    $sql = "SELECT Symptoms.Name AS SymptomName, Symptoms.Description AS SymptomDescription, Diagnoses.DiagnosisDescription, Medications.Name AS MedicationName, Medications.Frequency, Medications.StartDate, Medications.EndDate
            FROM Diagnoses
            INNER JOIN Symptoms ON Diagnoses.SymptomID = Symptoms.SymptomID
            INNER JOIN Medications ON Diagnoses.DiagnosisID = Medications.DiagnosisID
            WHERE Diagnoses.UserID = '$user_id'";

    $result = mysqli_query($conn, $sql);

    // Check if there is data
    if (mysqli_num_rows($result) > 0) {
        // Display data in a table
        echo "<table>";
        echo "<tr><th>Symptom Name</th><th>Symptom Description</th><th>Diagnosis Description</th><th>Medication Name</th><th>Frequency</th><th>Start Date</th><th>End Date</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['SymptomName'] . "</td>";
            echo "<td>" . $row['SymptomDescription'] . "</td>";
            echo "<td>" . $row['DiagnosisDescription'] . "</td>";
            echo "<td>" . $row['MedicationName'] . "</td>";
            echo "<td>" . $row['Frequency'] . "</td>";
            echo "<td>" . $row['StartDate'] . "</td>";
            echo "<td>" . $row['EndDate'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found.";
    }

    // Close database connection
    mysqli_close($conn);
    ?>
</body>
</html>
