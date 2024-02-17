<?php
// Include the database connection file
include 'db_connection.php';

// Initialize the session
session_start();

// Define variables and initialize with empty values
$doctor_id = $password = "";
$doctor_id_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate doctor ID
    if (empty(trim($_POST["doctor_id"]))) {
        $doctor_id_err = "Please enter doctor ID.";
    } else {
        $doctor_id = trim($_POST["doctor_id"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before processing the data
    if (empty($doctor_id_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT doctor_id, name, email, password FROM doctors WHERE doctor_id = :doctor_id";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":doctor_id", $param_doctor_id, PDO::PARAM_STR);

            // Set parameters
            $param_doctor_id = $doctor_id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if doctor ID exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $stored_doctor_id = $row["doctor_id"];
                        $name = $row["name"];
                        $email = $row["email"];
                        $stored_password = $row["password"];
                        if ($password == $stored_password) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["doctor_id"] = $stored_doctor_id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;

                            // Redirect user to dashboard page
                            header("location: doctor_dashboard.php");
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if doctor ID doesn't exist
                    $doctor_id_err = "No account found with that doctor ID.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>
