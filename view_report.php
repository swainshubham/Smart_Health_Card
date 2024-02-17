<?php
session_start();

// Include database connection
require_once 'db_connection.php';

// Initialize variables
$doctor_id = $_SESSION['doctor_id'];
$health_reports = [];

// Handle search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_term = $_POST['search_term'];

    // Fetch health reports associated with the logged-in doctor and matching health ID
    $stmt = $pdo->prepare("SELECT hr.*, p.name AS patient_name, mw.name AS medical_worker_name 
                           FROM health_reports hr 
                           INNER JOIN patients p ON hr.patient_health_id = p.health_id 
                           INNER JOIN medical_workers mw ON hr.medical_worker_id = mw.medical_worker_id 
                           WHERE hr.doctor_id = :doctor_id AND hr.patient_health_id = :search_term");
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':search_term', $search_term);
    $stmt->execute();
    $health_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch all health reports associated with the logged-in doctor
    $stmt = $pdo->prepare("SELECT hr.*, p.name AS patient_name, mw.name AS medical_worker_name 
                           FROM health_reports hr 
                           INNER JOIN patients p ON hr.patient_health_id = p.health_id 
                           INNER JOIN medical_workers mw ON hr.medical_worker_id = mw.medical_worker_id 
                           WHERE hr.doctor_id = :doctor_id");
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $health_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Health Reports</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .report {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
        }

        .report p {
            margin: 0;
            padding: 5px 0;
        }
    </style>
</head>
<body>
    <h1>View Health Reports</h1>
    <form>
    <input type="text" id="search" onkeyup="search()" placeholder="Search by Health ID...">
    </form>

    <div id="searchResults"></div>
    <?php foreach ($health_reports as $report): ?>
        <div class="report">
            <p><strong>Patient Name:</strong> <?php echo $report['patient_name']; ?></p>
            <p><strong>Health ID:</strong> <?php echo $report['patient_health_id']; ?></p>
            <p><strong>Medical Worker Name:</strong> <?php echo $report['medical_worker_name']; ?></p>
            <p><strong>Test Report:</strong> <?php echo $report['report_text']; ?></p>
            <?php if ($report['medicine']): ?>
                <p><strong>Medicine:</strong> <?php echo $report['medicine']; ?></p>
            <?php else: ?>
                <p><strong>Medicine:</strong> Not Uploaded</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
       <script>
        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("results");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Change index to the column you want to filter (e.g., 0 for Health ID)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</html>
