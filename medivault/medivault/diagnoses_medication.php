<?php
// Include the database configuration
include 'db_connection.php';

// Initialize variables
$diagnoses = [];
$medications = [];

// Query to fetch all diagnoses
$sqlDiagnoses = "SELECT DiagnosisID, DiagnosisDescription FROM Diagnoses";
$resultDiagnoses = mysqli_query($conn, $sqlDiagnoses);

// Check if any diagnoses are found
if ($resultDiagnoses && mysqli_num_rows($resultDiagnoses) > 0) {
    // Fetch all diagnoses
    $diagnoses = mysqli_fetch_all($resultDiagnoses, MYSQLI_ASSOC);
}

// Free the result set
mysqli_free_result($resultDiagnoses);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['diagnosis'])) {
    // Get the selected diagnosis ID
    $diagnosisID = $_POST['diagnosis'];

    // Query to fetch medication information associated with the selected diagnosis
    $sqlMedications = "SELECT m.Name AS MedicationName, m.Frequency 
            FROM Medications m
            INNER JOIN Diagnoses d ON m.DiagnosisID = d.DiagnosisID
            WHERE d.DiagnosisID = $diagnosisID";
    $resultMedications = mysqli_query($conn, $sqlMedications);

    // Check if the query was successful
    if ($resultMedications && mysqli_num_rows($resultMedications) > 0) {
        // Fetch all medications
        $medications = mysqli_fetch_all($resultMedications, MYSQLI_ASSOC);
    }

    // Free the result set
    mysqli_free_result($resultMedications);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosis and Medication Lookup</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('path/to/your/image.jpg'); /* Specify the path to your image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background */
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Diagnosis and Medication Lookup</h1>

        <form method="post">
            <label for="diagnosisSelect">Select a Diagnosis:</label>
            <select id="diagnosisSelect" name="diagnosis">
                <option value="">Select Diagnosis</option>
                <?php foreach ($diagnoses as $diagnosis): ?>
                    <option value="<?= $diagnosis['DiagnosisID'] ?>"><?= $diagnosis['DiagnosisDescription'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Search</button>
        </form>

        <?php if (!empty($medications)): ?>
            <h2>Medication Information</h2>
            <table>
                <tr>
                    <th>Medication Name</th>
                    <th>Frequency</th>
                </tr>
                <?php foreach ($medications as $medication): ?>
                    <tr>
                        <td><?= $medication['MedicationName'] ?></td>
                        <td><?= $medication['Frequency'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (isset($_POST['diagnosis'])): ?>
            <p>No medications found for the selected diagnosis.</p>
        <?php endif; ?>
    </div>
</body>
</html>
