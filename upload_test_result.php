<?php
// Start session
session_start();

// Check if user is not logged in as medical worker, redirect to login page
if (!isset($_SESSION["loggedin"])) {
    header("location: medical_worker_login.php");
    exit;
}

// Include database connection
include_once "db_connection.php";

// Define variables and initialize with empty values
$patient_health_id = $report_text = "";
$patient_health_id_err = $report_text_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate patient health ID
    if (empty(trim($_POST["patient_health_id"]))) {
        $patient_health_id_err = "Please enter patient health ID.";
    } else {
        $patient_health_id = trim($_POST["patient_health_id"]);
    }

    // Validate report text
    if (empty(trim($_POST["report_text"]))) {
        $report_text_err = "Please enter test report.";
    } else {
        $report_text = trim($_POST["report_text"]);
    }

    // Check input errors before inserting into database
    if (empty($patient_health_id_err) && empty($report_text_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO health_reports (patient_health_id, report_text, medical_worker_id) VALUES (:patient_health_id, :report_text, :medical_worker_id)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":patient_health_id", $param_patient_health_id, PDO::PARAM_STR);
            $stmt->bindParam(":report_text", $param_report_text, PDO::PARAM_STR);
            $stmt->bindParam(":medical_worker_id", $param_medical_worker_id, PDO::PARAM_INT);

            // Set parameters
            $param_patient_health_id = $patient_health_id;
            $param_report_text = $report_text;
            $param_medical_worker_id = $_SESSION["medical_worker_id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success page
                header("location: upload_success.php");
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Test Result</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"],
        input[type="reset"] {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #0056b3;
        }
        span.error {
            color: red;
            font-size: 14px;
        }
    </style>
<body>
    <h2>Upload Test Result</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Patient Health ID:</label>
            <input type="text" name="patient_health_id" value="<?php echo $patient_health_id; ?>">
            <span><?php echo $patient_health_id_err; ?></span>
        </div>
        <div>
            <label>Test Report:</label>
            <textarea name="report_text"><?php echo $report_text; ?></textarea>
            <span><?php echo $report_text_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Upload">
            <input type="reset" value="Reset">
        </div>
    </form>
</body>
</html>
