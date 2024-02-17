<?php
session_start();

// Check if the user is logged in as a medical worker and retrieve their ID from the session
if (!isset($_SESSION['medical_worker_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.php"); // Adjust this according to your login page
    exit;
}

// Assuming you have established a database connection
include 'db_connection.php';

// Fetch test results from health_reports table joined with patients table
$query = "SELECT hr.patient_health_id, p.name AS patient_name, hr.report_text, hr.medicine
          FROM health_reports hr
          INNER JOIN patients p ON hr.patient_health_id = p.health_id
          WHERE hr.medical_worker_id = :medical_worker_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':medical_worker_id', $_SESSION['medical_worker_id']);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Test Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 800px;
            padding: 40px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Test Results</h2>
        <input type="text" id="search" onkeyup="search()" placeholder="Search by Health ID...">
        <table id="results">
            <tr>
                <th>Health ID</th>
                <th>Patient Name</th>
                <th>Test Result</th>
                <th>Medicine</th>
            </tr>
            <?php
            // Display fetched results
            foreach ($results as $result) {
                echo "<tr>";
                echo "<td>".$result['patient_health_id']."</td>";
                echo "<td>".$result['patient_name']."</td>";
                echo "<td>".$result['report_text']."</td>";
                echo "<td>".$result['medicine']."</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

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
</body>
</html>
