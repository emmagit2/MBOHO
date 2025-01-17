<?php
// Include the database connection
include('db_connect.php');

// SQL query to fetch user details from the registrations table
$sql = "SELECT * FROM registrations";  // Replace with your actual table name

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result === false) {
    // Query failed, output the error
    die("Query failed: " . mysqli_error($conn));
}

// Start HTML output
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .admin-dashboard {
            margin: 20px;
        }
        table th, table td {
            vertical-align: middle;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .btn-edit, .btn-delete {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        img {
            max-width: 100px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="admin-dashboard">
    <h2 class="mb-4">Admin Dashboard - Registrations</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Village</th>
                <th>Business Category</th>
                <th>Business Name</th>
                <th>Uploaded Image</th>
                <th>Uploaded PDF</th>
                <th>Social Media</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        // Fetch and display the data
        while ($row = mysqli_fetch_assoc($result)) {
            // Format image path and pdf file path
            $imagePath = "uploads/" . $row['picture_path'];  // Assuming file is stored in an 'uploads' directory
            $pdfPath = "uploads/" . $row['document_path'];    // Assuming PDF is stored similarly

            // Social Media URLs
            $socialLinks = $row['social_media_url'];

            echo '<tr>
                    <td>' . htmlspecialchars($row['firstname']) . '</td>
                    <td>' . htmlspecialchars($row['lastname']) . '</td>
                    <td>' . htmlspecialchars($row['phonenum']) . '</td>
                    <td>' . htmlspecialchars($row['email']) . '</td>
                    <td>' . htmlspecialchars($row['village']) . '</td>
                    <td>' . htmlspecialchars($row['business_category']) . '</td>
                    <td>' . htmlspecialchars($row['business_name']) . '</td>
                    <td>';
            if ($imagePath && file_exists($imagePath)) {
                echo '<img src="' . $imagePath . '" alt="Uploaded Image">';
            } else {
                echo 'No image uploaded';
            }
            echo '</td>
                  <td>';
            if ($pdfPath && file_exists($pdfPath)) {
                echo '<a href="' . $pdfPath . '" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-file-pdf"></i> View PDF</a>';
            } else {
                echo 'No PDF uploaded';
            }
            echo '</td>
                  <td>';
            if (!empty($socialLinks)) {
                echo '<a href="' . $socialLinks . '" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-link"></i> View Profile</a>';
            } else {
                echo 'No social media link';
            }
            echo '</td>
                  <td>
                      <a href="edit.php?id=' . $row['id'] . '" class="btn-edit"><i class="fa fa-pencil-alt"></i> Edit</a>
                      <a href="delete.php?id=' . $row['id'] . '" class="btn-delete" onclick="return confirm(\'Are you sure you want to delete this record?\');"><i class="fa fa-trash-alt"></i> Delete</a>
                  </td>
              </tr>';
        }

echo '</tbody>
    </table>
</div>

<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>';

mysqli_close($conn);
?>
