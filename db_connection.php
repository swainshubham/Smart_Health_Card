<?php
// Database configuration for XAMPP localhost
$host = 'localhost'; 
$dbname = 'health_management'; // Name of your database
$username = 'root'; // Default username for XAMPP MySQL
$password = ''; // Default password for XAMPP MySQL (empty by default)

try {
    // Attempt to create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If connection fails, display error message
    die("Connection failed: " . $e->getMessage());
}
?>

