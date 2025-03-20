<?php
include 'db.php';

header("Content-Type: application/json");

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method.");
}

// Required fields
$required_fields = ["regno", "full_name", "contact_number", "email", "dob", "address", "bio", "password"];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        sendResponse(false, "Missing required field: $field.");
    }
}

// Get input data
$regno = trim($_POST['regno']);
$full_name = trim($_POST['full_name']);
$contact_number = trim($_POST['contact_number']);
$email = trim($_POST['email']);
$dob = trim($_POST['dob']);
$address = trim($_POST['address']);
$bio = trim($_POST['bio']);
$password = trim($_POST['password']); // Not hashing password as per request

// Check if regno already exists
$checkQuery = "SELECT regno FROM teacher_profiles WHERE regno = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("s", $regno);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    sendResponse(false, "Duplicate regno. Teacher already exists.");
}

// Handle profile picture upload
$uploadDir = "uploads/teacher_profiles/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$profile_picture_path = "";
if (!empty($_FILES['profile_picture']['name'])) {
    $file_name = basename($_FILES['profile_picture']['name']);
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $profile_picture_path = $uploadDir . $regno . "_" . $file_name;

    if (!move_uploaded_file($file_tmp, $profile_picture_path)) {
        sendResponse(false, "File upload failed.");
    }
}

// Insert into database
$insertQuery = "INSERT INTO teacher_profiles (regno, full_name, contact_number, email, dob, address, profile_picture, bio, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param("sssssssss", $regno, $full_name, $contact_number, $email, $dob, $address, $profile_picture_path, $bio, $password);

if ($insertStmt->execute()) {
    sendResponse(true, "Teacher added successfully.", [
        "regno" => $regno,
        "full_name" => $full_name,
        "profile_picture" => $profile_picture_path
    ]);
} else {
    sendResponse(false, "Database insertion failed.");
}

mysqli_close($conn);
?>
