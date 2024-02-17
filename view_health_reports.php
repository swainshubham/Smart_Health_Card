<?php
session_start();

// Check if the patient is logged in
if (!isset($_SESSION['health_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_connection.php';

// Fetch health reports for the logged-in patient, considering doctor_id and medicine can be null
$stmt = $pdo->prepare("SELECT hr.patient_health_id, 
                               d.name AS doctor_name, 
                               hr.report_text, 
                               hr.medicine, 
                               mw.name AS medical_worker_name
                       FROM health_reports hr
                       LEFT JOIN doctors d ON hr.doctor_id = d.doctor_id
                       JOIN medical_workers mw ON hr.medical_worker_id = mw.medical_worker_id
                       WHERE hr.patient_health_id = :health_id");
$stmt->bindParam(':health_id', $_SESSION['health_id']);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Health Reports</title>
    <!-- Add your CSS styles here -->
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* CSS for 3D-style and responsive design */
.container {
    width: 80%;
    margin: 20px auto;
}

h1 {
    text-align: center;
    color: #333;
}

.table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.table th, .table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #f5f5f5;
}

@media only screen and (max-width: 600px) {
    .container {
        width: 90%;
    }

    .table {
        font-size: 14px;
    }

    .table th, .table td {
        padding: 10px 12px;
    }
}

</style>
<body>
    <div class="container">
        <h1>View Health Reports</h1>
        <?php if ($reports && count($reports) > 0) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Report Text</th>
                        <th>Medicine</th>
                        <th>Medical Worker Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report['doctor_name'] ?: 'Not Available'); ?></td>
                            <td><?php echo htmlspecialchars($report['report_text']); ?></td>
                            <td><?php echo htmlspecialchars($report['medicine'] ?: 'Not Uploaded'); ?></td>
                            <td><?php echo htmlspecialchars($report['medical_worker_name']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No health reports available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
