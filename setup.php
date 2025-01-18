<?php
include('db_connect.php'); // Include your database connection

// Set your desired admin username and password
$adminUsername = "admin"; // Replace with your admin username
$adminPassword = "ibomimanatimeertysong234**"; // Replace with your desired admin password

// Hash the password
$hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);

// Insert the admin credentials into the database
try {
    $stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $adminUsername, $hashedPassword);

    if ($stmt->execute()) {
        echo "Admin credentials successfully added to the database.";
    } else {
        echo "Error inserting admin credentials: " . $stmt->error;
    }
    $stmt->close();
} catch (Exception $e) {
    echo "Exception occurred: " . $e->getMessage();
}

$conn->close();
?>
