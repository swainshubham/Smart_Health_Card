<?php
// Initialize the session
session_start();

// Check if the doctor is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: doctor-login.php");
    exit;
}

// Include the database connection file
include 'db_connection.php';

// Get doctor's information from the database
$doctor_id = $_SESSION["doctor_id"];
$sql = "SELECT name, email FROM doctors WHERE doctor_id = :doctor_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":doctor_id", $doctor_id, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$name = $row["name"];
$email = $row["email"];


if(isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to index.php after logout
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <style>
        /* CSS for responsive and 3D layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .dashboard-container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            margin-bottom: 10px;
            color: #666;
        }

        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons button:hover {
            background-color: #0056b3;
        }

        .logout {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .logout button {
            padding: 10px 20px;
            border: none;
            background-color: #dc3545;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $name; ?></h2>
        <p>Doctor ID: <?php echo $doctor_id; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <div class="buttons">
            <button onclick="location.href='upload_medicine.php'">Upload Medicine</button>
            <button onclick="location.href='view_report.php'">View Report</button>
        </div>
        <div class="logout">
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
        </div>
    </div>
</body>
</html>
