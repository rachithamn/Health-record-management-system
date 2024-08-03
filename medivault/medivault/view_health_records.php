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


// Delete health record if requested
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['record_id'])) {
    $record_id = $_GET['record_id'];
    $sql_delete = "DELETE FROM HealthRecords WHERE RecordID = $record_id AND UserID = $user_id";
    mysqli_query($conn, $sql_delete);
    // Redirect to the same page after deletion
    header("Location: {$_SERVER['PHP_SELF']}");
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
    <title>View Health Records</title>
    <!-- Include CSS styles here -->
<style>
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            background-image: url('Gradient.jpeg'); /* Add your background image path */
    background-size: cover;
    background-position: center;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            background-color: rgba(255, 255, 255, 0.3); /* Semi-transparent white background */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #7da0ca;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #7da0ca;
            color: #fff;
        }

        td {
            background-color: #f2f2f2;
            color: #333;
        }

        tbody tr:hover {
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
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .container form button {
            width: calc(100% - 22px);
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
    <h2> Your Previous Health Records</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Blood Pressure</th>
                <th>Cholesterol Level</th>
                <th>Heart Rate</th>
                <th>BMI(Body Mass Index)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_select)): ?>
                <tr>
                    <td><?php echo $row['Date']; ?></td>
                    <td><?php echo $row['Weight']; ?></td>
                    <td><?php echo $row['Height']; ?></td>
                    <td><?php echo $row['BloodPressure']; ?></td>
                    <td><?php echo $row['CholesterolLevel']; ?></td>
                    <td><?php echo $row['HeartRate']; ?></td>
                    <td><?php echo $row['BMI']; ?></td>

                    <td>
                        <a href="edit_health_record.php?record_id=<?php echo $row['RecordID']; ?>">Edit</a>
                        <a href="?action=delete&record_id=<?php echo $row['RecordID']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Form to add new health record -->
<div class="container">
    <h2> You Can Add New Health Record Here</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        <label for="weight">Weight:</label>
        <input type="number" id="weight" name="weight" step="0.1" required><br><br>
        <label for="height">Height:</label>
        <input type="number" id="height" name="height" required><br><br>
        <label for="blood_pressure">Blood Pressure:</label>
        <input type="text" id="blood_pressure" name="blood_pressure" required><br><br>
        <label for="cholesterol_level">Cholesterol Level:</label>
        <input type="number" id="cholesterol_level" name="cholesterol_level" required><br><br>
        <label for="heart_rate">Heart Rate:</label>
        <input type="number" id="heart_rate" name="heart_rate" required><br><br>
        <button type="submit">Add Record</button>
    </form>
</div>

</body>
</html>