<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom Search</title>
    <style>
        /* Add some basic styles */
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 200px;
            margin-bottom: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
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
    <h2>Symptom Search</h2>
    <form method="post">
        <label for="symptom">Enter Symptom Name:</label>
        <input type="text" id="symptom" name="symptom" required>
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
        <?php endif; ?>

    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No information found for the provided symptom.</p>
    <?php endif; ?>
</body>
</html>
