<?php
session_start();

// Check if the admin is not logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Include the database configuration file
require '../config.php';

// Your database connection code here
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Handle search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$searchQuery = trim($searchQuery);

// Handle sort
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sortOrder = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

// Fetch data from the students table based on the search query and sorting
if ($searchQuery) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE :searchQuery OR matric LIKE :searchQuery OR level LIKE :searchQuery OR gender LIKE :searchQuery OR phone LIKE :searchQuery OR email LIKE :searchQuery OR cgpa LIKE :searchQuery ORDER BY $sortColumn $sortOrder");
    $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
} else {
    // If no search query, fetch all data with sorting
    $stmt = $conn->query("SELECT * FROM students ORDER BY $sortColumn $sortOrder");
}

$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            text-align: center;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Green color for header */
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray background for even rows */
        }
        .university-logo {
      max-width: 100px;
    }




    form {
            margin-bottom: 20px;
        }

        label {
            margin-right: 10px;
        }

        input[type="text"] {
            padding: 5px;
        }

        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        th a {
            text-decoration: none;
            color: white;
        }




    </style>
</head>
<body>
<div style="margin: 0 auto; width: 50%; "><img src="https://oaustech.edu.ng/images/oaustech-logo.png" alt="University Logo" class="university-logo"></div>
<h1>Welcome to the Admin Dashboard</h1>

<!-- Search form -->
<form action="dashboard.php" method="get">
    <label for="search">Search For a Student:</label>
    <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
    <button type="submit">Search</button>
</form>

<!-- Sort buttons -->
<table border="1">
    <thead>
        <tr>
            <th><a href="?sort=id&order=<?php echo $sortColumn == 'id' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">ID</a></th>
            <th><a href="?sort=name&order=<?php echo $sortColumn == 'name' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Name</a></th>
            <th><a href="?sort=matric&order=<?php echo $sortColumn == 'matric' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Matric</a></th>
            <th><a href="?sort=level&order=<?php echo $sortColumn == 'level' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Level</a></th>
            <th><a href="?sort=gender&order=<?php echo $sortColumn == 'gender' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Gender</a></th>
            <th><a href="?sort=phone&order=<?php echo $sortColumn == 'phone' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Phone</a></th>
            <th><a href="?sort=email&order=<?php echo $sortColumn == 'email' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">Email</a></th>
            <th><a href="?sort=cgpa&order=<?php echo $sortColumn == 'cgpa' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>">CGPA</a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo $student['id']; ?></td>
                <td><?php echo $student['name']; ?></td>
                <td><?php echo $student['matric']; ?></td>
                <td><?php echo $student['level']; ?></td>
                <td><?php echo $student['gender']; ?></td>
                <td><?php echo $student['phone']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td><?php echo $student['cgpa']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add any additional content or scripts here -->

</body
