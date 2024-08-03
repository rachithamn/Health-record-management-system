
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Health Records</title>
    <!-- Include CSS styles here -->
    <style>
        .container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-in-out;
}

.container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.container table {
    width: 100%;
    border-collapse: collapse;
}

.container table th,
.container table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

.container table th {
    background-color: #007bff;
    color: #fff;
}

.container table td {
    background-color: #fff;
    color: #333;
}

.container table tbody tr:nth-child(even) td {
    background-color: #f2f2f2;
}

.container table tbody tr:hover td {
    background-color: #e0e0e0;
}

.container form label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.container form input[type="date"],
.container form input[type="number"],
.container form input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.container form button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.container form button:hover {
    background-color: #0056b3;
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

<!-- Display existing health records -->
<div class="container">
    <h2>medication details</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th> DiagnosisDescription</th>
                <th>tablet Name </th>
                <th> Dosage </th>
                <th>Frequency</th>
                <th>StartDate</th>
             <th>EndDate </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_select)): ?>
                <tr>
                    <td><?php echo $row['Date']; ?></td>
                    <td><?php echo $row['DiagnosisDescription']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Frequency']; ?></td>
                    <td><?php echo $row['StartDate']; ?></td>
                    <td><?php echo $row['EndDate']; ?></td>
                  <!---  <td><button><a href="editrecord.php?RecordID=<?php echo $row['RecordID']; ?>">Edit</a></button>-->
    <!--<button type="Delete">Delete</button></button>-->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<h2>Enter Diagnoses and Medications</h2>
    <form action="submit_diagnoses.php" method="post">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required><br><br>
        
        <label for="symptom_id">Symptom ID:</label>
        <input type="text" id="symptom_id" name="symptom_id" required><br><br>
        
        <label for="diagnosis_description">Diagnosis Description:</label><br>
        <textarea id="diagnosis_description" name="diagnosis_description" rows="4" cols="50"></textarea><br><br>
        
        <label for="medication_name">Medication Name:</label>
        <input type="text" id="medication_name" name="medication_name" required><br><br>
        
        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage"><br><br>
        
        <label for="frequency">Frequency:</label>
        <input type="text" id="frequency" name="frequency"><br><br>
        
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br><br>
        
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date"><br><br>
        
        <input type="submit" value="Submit">
    </form>



</body>
</html>
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



// Fetch existing health records from the database
$user_id = $_SESSION['user_id'];
$sql_select = "SELECT * FROM HealthRecords WHERE UserID = $user_id";
$result_select = mysqli_query($conn, $sql_select);

// Add new health record if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $blood_pressure = $_POST['blood_pressure'];
    $cholesterol_level = $_POST['cholesterol_level'];
    $heart_rate = $_POST['heart_rate'];

    // Insert new health record into the database
    $sql_insert = "INSERT INTO HealthRecords (UserID, Date, Weight, Height, BloodPressure, CholesterolLevel, HeartRate) VALUES
                   ($user_id, '$date', $weight, $height, '$blood_pressure', $cholesterol_level, $heart_rate)";
    mysqli_query($conn, $sql_insert);
    
    // Redirect to the same page to prevent duplicate submissions
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Close database connection
mysqli_close($conn);
?>