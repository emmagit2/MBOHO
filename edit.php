<?php
// Include the database connection
include('db_connect.php');

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch the current data for the given id
    $sql = "SELECT * FROM registrations WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the data for the user
        $row = mysqli_fetch_assoc($result);
        
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phonenum = mysqli_real_escape_string($conn, $_POST['phonenum']);
            $business_name = mysqli_real_escape_string($conn, $_POST['business_name']);
            $business_category = mysqli_real_escape_string($conn, $_POST['business_category']);
            
            // SQL query to update the record
            $update_sql = "UPDATE registrations SET 
                            firstname = '$firstname', 
                            lastname = '$lastname', 
                            email = '$email', 
                            phonenum = '$phonenum', 
                            business_name = '$business_name', 
                            business_category = '$business_category'
                            WHERE id = $id";
            
            // Execute the update query
            if (mysqli_query($conn, $update_sql)) {
                // Redirect to the dashboard page after successful update
                header("Location: admin.php");
                exit();
            } else {
                // Display an error message if the update fails
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Record not found.";
    }
} else {
    // Redirect to dashboard if no id is provided
    header("Location: admin.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Edit User</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($row['firstname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($row['lastname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phonenum">Phone Number:</label>
            <input type="text" class="form-control" id="phonenum" name="phonenum" value="<?php echo htmlspecialchars($row['phonenum']); ?>" required>
        </div>
        <div class="form-group">
            <label for="business_name">Business Name:</label>
            <input type="text" class="form-control" id="business_name" name="business_name" value="<?php echo htmlspecialchars($row['business_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="business_category">Business Category:</label>
            <input type="text" class="form-control" id="business_category" name="business_category" value="<?php echo htmlspecialchars($row['business_category']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
