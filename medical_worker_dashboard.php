<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: medical_worker_login.php");
    exit;
}

// Include the database connection file
include 'db_connection.php';

// Define variables to store user information
$name = $_SESSION["name"];
$email = $_SESSION["email"];
$medical_worker_id = $_SESSION["medical_worker_id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Worker Dashboard</title>
    <style>
        /* CSS for responsive and 3D layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 100px auto;
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
            text-align: center;
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
    <div class="container">
        <h2>Medical Worker Dashboard</h2>
        <p>Name: <?php echo $name; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <p>Medical Worker ID: <?php echo $medical_worker_id; ?></p>
        <div class="buttons">
            <button onclick="location.href='upload_test_result.php'">Upload Test Result</button>
            <button onclick="location.href='view_test_result.php'">View Test Result</button>
        </div>
        <div class="logout">
            <button onclick="location.href='logout.php'">Logout</button>
        </div>
    </div>
</body>
</html>
