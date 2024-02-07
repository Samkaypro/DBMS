<?php
// Retrieve form data
$name = isset($_POST['name']) ? $_POST['name'] : '';
$matric = isset($_POST['matric']) ? $_POST['matric'] : '';
$level = isset($_POST['level']) ? $_POST['level'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$cgpa = isset($_POST['cgpa']) ? $_POST['cgpa'] : '';

// Check if required fields are not null
if ($name && $matric && $level && $gender && $phone && $email && $cgpa) {
    // Your database connection code here
  require "./config.php";
    try {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO students (name, matric, level, gender, phone, email, cgpa) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $matric, $level, $gender, $phone, $email, $cgpa]);

        echo "Record inserted successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
} else {
    echo "Error: One or more required fields are empty.";
}
?>
