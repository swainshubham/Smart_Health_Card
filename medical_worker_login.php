<?php
// Include the database connection file
include 'db_connection.php';

// Initialize the session
session_start();

// Define variables and initialize with empty values
$medical_worker_id = $password = "";
$medical_worker_id_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate medical worker ID
    if (empty(trim($_POST["medical_worker_id"]))) {
        $medical_worker_id_err = "Please enter medical worker ID.";
    } else {
        $medical_worker_id = trim($_POST["medical_worker_id"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before processing the data
    if (empty($medical_worker_id_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT medical_worker_id, name, email, password FROM medical_workers WHERE medical_worker_id = :medical_worker_id";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":medical_worker_id", $param_medical_worker_id, PDO::PARAM_STR);

            // Set parameters
            $param_medical_worker_id = $medical_worker_id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if medical worker ID exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $stored_medical_worker_id = $row["medical_worker_id"];
                        $name = $row["name"];
                        $email = $row["email"];
                        $stored_password = $row["password"];
                        if ($password == $stored_password) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["medical_worker_id"] = $stored_medical_worker_id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;

                            // Redirect user to dashboard page
                            header("location: medical_worker_dashboard.php");
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if medical worker ID doesn't exist
                    $medical_worker_id_err = "No account found with that medical worker ID.";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Worker Login</title>
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
            max-width: 400px;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group .error {
            color: red;
            font-size: 14px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Medical Worker Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($medical_worker_id_err)) ? 'has-error' : ''; ?>">
                <label>Medical Worker ID</label>
                <input type="text" name="medical_worker_id" value="<?php echo $medical_worker_id; ?>">
                <span class="error"><?php echo $medical_worker_id_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="medical_worker_register.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>
