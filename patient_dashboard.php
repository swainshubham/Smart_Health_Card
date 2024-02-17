<?php
// Start or resume a session
session_start();

// Check if the patient is logged in
if (!isset($_SESSION['patient_id'])) {
    // If not logged in, redirect to the login page
    header("Location: patient-login.php");
    exit;
}

// Retrieve patient information from the session
$patient_name = $_SESSION['name'];
$health_id = $_SESSION['health_id'];
$email = $_SESSION['email'];

// Check if the logout button is clicked
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
    <title>Patient Dashboard</title>
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

        /* Footer styles */
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $patient_name; ?></h2>
        <p>Health ID: <?php echo $health_id; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <div class="buttons">
            <button onclick="location.href='view_health_reports.php'">View Health Reports</button>
        </div>
        <!-- Logout button -->
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
    <!-- Footer -->
    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> Your Hospital Name. All Rights Reserved.</p>
    </div>
</body>
</html>
