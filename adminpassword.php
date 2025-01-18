<?php
// Replace with your desired admin password
$adminPassword = "ibomimanatimeertysong234**";

// Hash the password
$passwordHash = password_hash($adminPassword, PASSWORD_BCRYPT);

// Display the hashed password (Save this in the database manually)
echo "Hashed Password: " . $passwordHash;
?>