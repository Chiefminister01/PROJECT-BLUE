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

// Check if name and password are provided
if (!isset($_POST['username']) || !isset($_POST['password']) || empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
    sendResponse(false, "Invalid input data.");
}

$name = trim($_POST['username']);
$password = trim($_POST['password']);

// Query to check if admin exists
$query = "SELECT * FROM admin_profiles WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    sendResponse(false, "Corrupt user.");
}

$admin = $result->fetch_assoc();

// Check if password matches (Assuming plain text storage, ideally use password_hash() & password_verify())
if ($admin['password'] !== $password) {
    sendResponse(false, "Corrupt user.");
}

// If login is successful
sendResponse(true, "Login successful.");

mysqli_close($conn);
