<?php
include 'db.php';

header("Content-Type: application/json");

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check if all required fields are present
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method.");
}

$required_fields = ["regno", "full_name", "dob", "course", "year", "nationality", "contact_number", "email", "address", "bio", "gender", "password"];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        sendResponse(false, "Missing required field: $field.");
    }
}

// Get input data
$regno = trim($_POST['regno']);
$full_name = trim($_POST['full_name']);
$dob = trim($_POST['dob']);
$course = trim($_POST['course']);
$year = intval($_POST['year']);
$nationality = trim($_POST['nationality']);
$contact_number = trim($_POST['contact_number']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);
$bio = trim($_POST['bio']);
$gender = trim($_POST['gender']);
$password = trim($_POST['password']); // Not hashing password as per request

// Check if regno already exists
$checkQuery = "SELECT regno FROM student_profiles WHERE regno = '$regno'";
$checkResult = mysqli_query($conn, $checkQuery);
if (mysqli_num_rows($checkResult) > 0) {
    sendResponse(false, "Duplicate regno. Student already exists.");
}

// Handle profile picture upload
$uploadDir = "uploads/student_profiles/";
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
$insertQuery = "INSERT INTO student_profiles (regno, full_name, dob, course, year, nationality, contact_number, email, address, bio, gender, password, profile_picture) 
                VALUES ('$regno', '$full_name', '$dob', '$course', '$year', '$nationality', '$contact_number', '$email', '$address', '$bio', '$gender', '$password', '$profile_picture_path')";

if (mysqli_query($conn, $insertQuery)) {
    sendResponse(true, "Student added successfully", [
        "regno" => $regno,
        "full_name" => $full_name,
        "profile_picture" => $profile_picture_path
    ]);
} else {
    sendResponse(false, "Database insertion failed.");
}

mysqli_close($conn);
?>
