<?php
include 'db.php'; // Include database connection

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, "Invalid request method.");
}

// Get input data
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if (empty($message)) {
    sendResponse(false, "Message field is required.");
}

// Insert into database
$sql = "INSERT INTO admin_messages (message) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $message);

if ($stmt->execute()) {
    sendResponse(true, "Admin message sent successfully.");
} else {
    sendResponse(false, "Error sending admin message.");
}

// Close connections
$stmt->close();
$conn->close();
?>
