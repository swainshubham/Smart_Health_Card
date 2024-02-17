<?php
include 'db_connection.php';

// Initialize health ID variable
$healthID = "";

// Generate a unique health ID
function generateHealthID() {
    // Generate a random alphanumeric string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $healthID = '';
    $length = 8; // Adjust the length of the health ID as needed

    for ($i = 0; $i < $length; $i++) {
        $healthID .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $healthID;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Generate a health ID
    $healthID = generateHealthID();

    // Insert data into the database
    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("INSERT INTO patients (health_id, name, email, password) VALUES (:healthID, :name, :email, :password)");

        // Bind parameters
        $stmt->bindParam(':healthID', $healthID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // Execute the statement
        $stmt->execute();
    } catch(PDOException $e) {
        // Display error message if registration fails
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .registration-container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        .input-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>Patient Registration</h2>
        <?php if ($healthID !== ""): ?>
            <p>Your Health ID: <?php echo $healthID; ?></p>
            <p>Please remember this for future use.</p>
        <?php else: ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Register</button>
            </form>
        <?php endif; ?>
        <div class="login-link">
            <p>Already have an account? <a href="patient-login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
