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
$teacher_regno = isset($_POST['teacher_regno']) ? trim($_POST['teacher_regno']) : '';
$course_code = isset($_POST['course_code']) ? trim($_POST['course_code']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if (empty($teacher_regno) || empty($course_code) || empty($message)) {
    sendResponse(false, "All fields are required.");
}

// Insert into database
$sql = "INSERT INTO course_messages (teacher_regno, course_code, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $teacher_regno, $course_code, $message);

if ($stmt->execute()) {
    sendResponse(true, "Message uploaded successfully.");
} else {
    sendResponse(false, "Error uploading message.");
}

// Close connections
$stmt->close();
$conn->close();
?>
