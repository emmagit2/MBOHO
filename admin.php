<?php 
// Include the database connection
include('db_connect.php');

// Start the session
session_start();

// Check session timeout for inactivity (10 minutes)
$timeout = 600; // 10 minutes in seconds
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset(); 
    session_destroy(); 
    header("Location: login.php"); // Redirect to login page
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Initialize the search query
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

// SQL query with search condition
$sql = "SELECT * FROM registrations WHERE 
        firstname LIKE '%$search_query%' OR 
        lastname LIKE '%$search_query%' OR 
        business_name LIKE '%$search_query%' OR 
        business_category LIKE '%$search_query%' OR
        email LIKE '%$search_query%'";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result === false) {
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
        .navbar {
            margin-bottom: 20px;
        }
        .main-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .table-container {
            flex: 1 1 100%;
            overflow-x: auto;
        }
        .table th {
            background-color: #007bff;
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .table td {
            vertical-align: middle;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .card {
            flex: 1 1 calc(100% - 30px);
            max-width: 48%;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .card-body {
            padding: 10px;
        }
        .card-body h5 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .card-body p {
            font-size: 14px;
            color: #555;
        }
        @media (max-width: 768px) {
            .card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <form class="form-inline ml-auto" method="get">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search by name, email, business" aria-label="Search" value="' . htmlspecialchars($search_query) . '">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <a href="logout.php" class="btn btn-danger ml-3">Logout</a>
</nav>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Table Section -->
        <div class="table-container col-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Village</th>
                        <th>Village Head</th>
                        <th>Business Category</th>
                        <th>Business Name</th>
                        <th>Picture</th>
                        <th>Social Media</th>
                        <th>Document</th>
                        <th>Submitted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

$counter = 1; // Initialize a counter for numbering

// Fetch and display the data
while ($row = mysqli_fetch_assoc($result)) {
    $social_media_url = !empty($row['social_media_url']) && strpos($row['social_media_url'], 'http') === false ? 'https://' . $row['social_media_url'] : $row['social_media_url'];
    $document_path = !empty($row['document_path']) && strpos($row['document_path'], 'http') === false ? 'https://' . $row['document_path'] : $row['document_path'];

    echo '<tr>
            <td>' . $counter++ . '</td>
            <td>' . htmlspecialchars($row['firstname']) . '</td>
            <td>' . htmlspecialchars($row['lastname']) . '</td>
            <td>' . htmlspecialchars($row['phonenum']) . '</td>
            <td>' . htmlspecialchars($row['email']) . '</td>
            <td>' . htmlspecialchars($row['age']) . '</td>
            <td>' . htmlspecialchars($row['village']) . '</td>
            <td>' . htmlspecialchars($row['village_head']) . '</td>
            <td>' . htmlspecialchars($row['business_category']) . '</td>
            <td>' . htmlspecialchars($row['business_name']) . '</td>
            <td>';
            if (!empty($row['picture_path'])) {
                echo '<img src="' . htmlspecialchars($row['picture_path']) . '" alt="Picture" width="100">';
            } else {
                echo 'No Image';
            }
            echo '</td>
            <td>';
            if (!empty($social_media_url)) {
                echo '<a href="' . $social_media_url . '" target="_blank"><i class="fas fa-link icon-link"></i></a>';
            } else {
                echo 'No Social Media';
            }
            echo '</td>
            <td>';
            if (!empty($document_path)) {
                echo '<a href="' . $document_path . '" target="_blank"><i class="fas fa-eye icon-link"></i></a> 
                      <a href="' . $document_path . '" download><i class="fas fa-download icon-link"></i></a>';
            } else {
                echo 'No Document';
            }
            echo '</td>
            <td>' . htmlspecialchars($row['submitted_at']) . '</td>
            <td>
                <a href="edit.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Edit</a>
                <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>';
}

echo '      </tbody>
            </table>
        </div>

        <!-- Cards Section -->
        <div class="cards-container col-12">';

$card_counter = 0; 
mysqli_data_seek($result, 0);

while ($row = mysqli_fetch_assoc($result)) {
    if ($card_counter >= 5) {
        break; 
    }
    echo '<div class="card">
            <img src="' . htmlspecialchars($row['picture_path']) . '" alt="Picture">
            <div class="card-body">
                <h5>' . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . '</h5>
                <p>Age: ' . htmlspecialchars($row['age']) . '</p>
                <p>Phone: ' . htmlspecialchars($row['phonenum']) . '</p>
                <p>Submitted: ' . htmlspecialchars($row['submitted_at']) . '</p>
            </div>
        </div>';
    $card_counter++;
}

echo '      </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>';

// Close the database connection
mysqli_close($conn);
?>
