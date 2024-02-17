<?php
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $health_id = $_POST['health_id'];
    $doctor_id = $_SESSION['doctor_id'];

    // Check if medicine is provided in the form submission
    if (!empty($_POST['medicine'])) {
        $medicine = $_POST['medicine'];

        // Check if medicine is already uploaded for this health report
        $stmt = $pdo->prepare("SELECT medicine FROM health_reports WHERE patient_health_id = :health_id AND doctor_id = :doctor_id");
        $stmt->bindParam(':health_id', $health_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();
        $existing_medicine = $stmt->fetchColumn();

        //if ($existing_medicine === false || empty($existing_medicine)) {
            // Update medicine in health_reports table
            $stmt = $pdo->prepare("UPDATE health_reports SET medicine = :medicine, doctor_id = :doctor_id WHERE id = :id");
            $stmt->bindParam(':medicine', $medicine);
            $stmt->bindParam(':doctor_id', $doctor_id);
            $stmt->bindParam(':id', $_POST['report_id']); // Use the ID column to update the specific record
            $stmt->execute();

            // Redirect to upload success page
            header("Location: upload_medicine_success.php");
            exit();
       // } else {
         //   $error = "Medicine already uploaded for this health report.";
       // }
    } else {
        $error = "Please provide medicine information.";
    }
}

// Fetch all entries from health_reports table for the given health ID
if (isset($_POST['health_id'])) {
    $health_id = $_POST['health_id'];
    $stmt = $pdo->prepare("SELECT hr.id, hr.report_text, p.health_id, p.name AS patient_name, hr.medicine 
                            FROM health_reports hr
                            INNER JOIN patients p ON hr.patient_health_id = p.health_id
                            WHERE hr.patient_health_id = :health_id");
    $stmt->bindParam(':health_id', $health_id);
    $stmt->execute();
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Medicine</title>
    <!-- Add your CSS styles here -->
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* CSS for Upload Medicine page */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f3f3f3;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    margin-right: 10px;
}

input[type="text"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 10px;
    flex: 1;
}

button[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #007bff;
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.error {
    color: red;
    margin-bottom: 10px;
    text-align: center;
}

</style>
<body>
    <div class="container">
        <h1>Upload Medicine</h1>
        <?php if (isset($error)) : ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="health_id">Health ID:</label>
            <input type="text" id="health_id" name="health_id" required>
            <button type="submit">Fetch Reports</button>
        </form>
        <?php if (isset($reports)) : ?>
            <h2>Health Reports for <?php echo $health_id; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Health ID</th>
                        <th>Patient Name</th>
                        <th>Report Text</th>
                        <th>Medicine</th>
                        <th>Upload Medicine</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <td><?php echo $report['id']; ?></td>
                            <td><?php echo $report['health_id']; ?></td>
                            <td><?php echo $report['patient_name']; ?></td>
                            <td><?php echo $report['report_text']; ?></td>
                            <td><?php echo $report['medicine'] ? $report['medicine'] : "Not Uploaded"; ?></td>
                            <td>
                                <?php if (!$report['medicine']) : ?>
                                    <form action="" method="POST">
                                        <input type="hidden" name="health_id" value="<?php echo $health_id; ?>">
                                        <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">
                                        <label for="medicine">Medicine:</label>
                                        <input type="text" id="medicine" name="medicine" required>
                                        <button type="submit">Upload Medicine</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
