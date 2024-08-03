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

// Fetch user data from database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE UserID = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include CSS styles here -->
    <link rel="stylesheet" href="style.css">
<body>

<!-- Display dashboard -->
<div class="container">
    <h2>Welcome, <?php echo $user['Username']; ?>!</h2><br><br>
   
<p style="margin-right: 20px; color: #7da0ca;"><strong>Stay informed about your health journey by accessing your detailed health records</strong></p>
<p style="margin-right: 20px; color: #7da0ca;"><strong>Your health information is securely protected and treated with the utmost confidentiality.</strong></p>
    <!-- Add more dashboard elements here -->
<a href="view_health_records.php"> You Can View Your Health Records By Clicking Here</a><br><br>
<a href="add_data.html"> You Can add Your Diagnoses By Clicking Here</a>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Your Symptoms Here </title>
  
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('Tijiko 3D.gif'); /* Add your background image path */
    background-size: cover;
    background-position: center;
}

.container {
    max-width: 10000px;
    margin: 0 auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.3); /* Semi-transparent white background */
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3); /* Soft shadow effect */
    animation: fadeIn 0.5s ease-in-out;
}

/* Header styles */
header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
    border-radius: 10px 10px 0 0; /* Rounded corners for the header */
}

/* Main content styles */
main {
    padding: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    color: #333;
}

input[type="text"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    padding: 12px 24px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition */
}

button:hover {
    background-color: #0056b3;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

    </style>
</head>
<body>
    <h2>Search Your Symptoms Here</h2>
    <form method="post">
        <label for="symptom">Enter Symptom Name:</label>
        <input type="text" id="symptom" name="symptom" required>
       <!-- <select id="symptom" name="symptom">
            <option value="option1">Headache</option>
            <option value="option2">Fever</option>
            <option value="option3">Cough</option>
            <option value="option4">Nausea</option>
            <option value="option5">Fatigue </option>
            <option value="option6">Shortness of breath </option>
            <option value="option7"> Muscle pain</option>
            <option value="option8">Sore throat </option>
            <option value="option9">Runny nose </option>
            <option value="option10">Sneezing </option>
            <option value="option12">Watery eyes </option>
            <option value="option13">Chills </option>
            <option value="option14">Loss of appetite </option>
            <option value="option15"> Joint pain</option>
            <option value="option16">Vomiting </option>-->
        </select>
        <button type="submit">Search</button>
    </form>

    <?php
    // Include the database configuration
    include 'db_connection.php';

    // Initialize variables
    $diagnosis = "";
    $medications = array(); // Initialize as an empty array

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['symptom'])) {
        // Get the symptom name from the form
        $symptom = $_POST['symptom'];

        // Query to fetch diagnosis and medication information associated with the specified symptom
        $sql = "SELECT d.DiagnosisDescription, m.Name AS MedicationName, m.Dosage, m.Frequency 
                FROM Symptoms s
                INNER JOIN Diagnoses d ON s.SymptomID = d.SymptomID
                INNER JOIN Medications m ON d.DiagnosisID = m.DiagnosisID
                WHERE s.Name LIKE '%$symptom%'";
        $result = mysqli_query($conn, $sql);

        // Check if any data is found
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch diagnosis and medication information
            $row = mysqli_fetch_assoc($result);
            $diagnosis = $row['DiagnosisDescription'];
            $medications[] = array(
                'MedicationName' => $row['MedicationName'],
                'Dosage' => $row['Dosage'],
                'Frequency' => $row['Frequency']
            );
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <?php if (!empty($diagnosis)): ?>
        <h3>Diagnosis:</h3>
        <p><?= $diagnosis ?></p>

        <?php if (!empty($medications)): ?>
            <h3>Medications:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Medication Name</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medications as $medication): ?>
                        <tr>
                            <td><?= $medication['MedicationName'] ?></td>
                            <td><?= $medication['Dosage'] ?></td>
                            <td><?= $medication['Frequency'] ?></td>
                        </tr>
                        
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p style="color: blue; font-size: 16px;">Please consider the above information for reference or educational purposes</p>
        <?php endif; ?>

    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No information found for the provided symptom.</p>
    <?php endif; ?>
</body>
</html>
