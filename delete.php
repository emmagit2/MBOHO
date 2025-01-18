<?php
// Include the database connection
include('db_connect.php');

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // SQL query to delete the record with the given id
    $sql = "DELETE FROM registrations WHERE id = $id";
    
    // Execute the query and check if successful
    if (mysqli_query($conn, $sql)) {
        // Redirect to the dashboard page after deletion
        header("Location: admin.php");
        exit();
    } else {
        // Display an error message if the deletion fails
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // Redirect to dashboard if no id is provided
    header("Location: admin.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
