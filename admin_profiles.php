<?php
include 'db.php';

header("Content-Type: application/json");

// Function to send JSON response
function sendResponse($status, $message)
{
    echo json_encode(["status" => $status, "message" => $message]);
    exit;
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method.");
}

// Check required fields
if (!isset($_POST['username']) || !isset($_POST['password']) || empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
    sendResponse(false, "Invalid input data.");
}

$name = trim($_POST['username']);
$password = trim($_POST['password']); // Ideally, use password_hash($password, PASSWORD_BCRYPT) for security

// Insert into database
$query = "INSERT INTO admin_profiles (name, password) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $name, $password);

if ($stmt->execute()) {
    sendResponse(true, "Admin added successfully.");
} else {
    sendResponse(false, "Database insertion failed.");
}

mysqli_close($conn);
