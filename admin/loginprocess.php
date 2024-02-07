<?php
session_start();

require '../config.php';

// Retrieve form data
$usernameInput = isset($_POST['username']) ? $_POST['username'] : '';
$passwordInput = isset($_POST['password']) ? $_POST['password'] : '';

try {
    // Create a MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to fetch admin credentials
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $usernameInput);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Validate admin credentials
    if ($admin && $passwordInput === $admin['password']) {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid login credentials. Please try again.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn->close();
?>
