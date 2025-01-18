<?php


// CORS headers for cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Include the database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $phonenum = htmlspecialchars(trim($_POST['phonenum']));
    $email = htmlspecialchars(trim($_POST['email']));
    $village = htmlspecialchars(trim($_POST['village']));
    $village_head = htmlspecialchars(trim($_POST['villageHead']));
    $business_category = htmlspecialchars(trim($_POST['businessCategory']));
    $business_name = htmlspecialchars(trim($_POST['businessName']));
    $social_media_url = htmlspecialchars(trim($_POST['socialMediaLink']));
    $age = htmlspecialchars(trim($_POST['age'])); // Added age field

    $picture_path = "";
    $document_path = "";

    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $picture_extension = pathinfo($_FILES['fileInput']['name'], PATHINFO_EXTENSION);
    
        if (in_array(strtolower($picture_extension), $allowed_extensions)) {
            $picture_path = "uploads/pictures/" . uniqid() . "." . $picture_extension;
            move_uploaded_file($_FILES['fileInput']['tmp_name'], $picture_path);
        } else {
            die(json_encode(["success" => false, "message" => "Invalid picture format. Only JPG, JPEG, and PNG allowed."]));
        }
    }
    
    if (isset($_FILES['uploadPDF']) && $_FILES['uploadPDF']['error'] == 0) {
        $document_extension = pathinfo($_FILES['uploadPDF']['name'], PATHINFO_EXTENSION);
    
        if (strtolower($document_extension) == 'pdf') {
            $document_path = "uploads/documents/" . uniqid() . ".pdf";
            move_uploaded_file($_FILES['uploadPDF']['tmp_name'], $document_path);
        } else {
            die(json_encode(["success" => false, "message" => "Invalid document format. Only PDF allowed."]));
        }
    }
    
    $stmt = $conn->prepare("INSERT INTO registrations (firstname, lastname, phonenum, email, village, village_head, business_category, business_name, picture_path, social_media_url, document_path, age) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $firstname, $lastname, $phonenum, $email, $village, $village_head, $business_category, $business_name, $picture_path, $social_media_url, $document_path, $age);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registration successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
























?>