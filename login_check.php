<?php
// Include the database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $healthID = $_POST["health_id"];
    $password = $_POST["password"];
   // echo $healthID;
    //echo $password;
    try {
        // Prepare the SQL statement to fetch patient data based on health ID
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE health_id = :healthID");

        // Bind parameter
        $stmt->bindParam(':healthID', $healthID);

        // Execute the statement
        $stmt->execute();

        // Fetch the patient data
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $patient['password'];
        // Check if patient exists and password is correct
        if ($patient && $password==$patient['password']) {
            // Start a session and store patient's information in it
            session_start();
            $_SESSION['patient_id'] = $patient['id'];
            $_SESSION['health_id'] = $patient['health_id'];
            $_SESSION['name'] = $patient['name'];
            $_SESSION['email'] = $patient['email'];
            // Redirect to patient dashboard after successful login
            //echo "success";
            header("Location: patient_dashboard.php");
            //exit;
        } 
        else {
            // Redirect back to the login page with error message
            //header("Location: patient-login.php?error=1");
            //exit;
            echo "fail";
        }
    } catch(PDOException $e) {
        // Display error message if something goes wrong
       // echo "Error: " . $e->getMessage();
    }
} else {
    // If the form is not submitted, redirect back to the login page
    //header("Location: patient-login.php");
   // exit;
}
?>
