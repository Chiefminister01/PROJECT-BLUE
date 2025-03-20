<?php
include 'db.php'; // Include database connection

// Function to send JSON response
function sendResponse($status, $message, $data = [])
{
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, "Invalid request method.");
}

// Get course code from request
$course_code = isset($_GET['course_code']) ? trim($_GET['course_code']) : '';

if (empty($course_code)) {
    sendResponse(false, "Course code is required.");
}

// Check if the `created_at` column exists in the table
$column_check_query = "SHOW COLUMNS FROM course_messages LIKE 'created_at'";
$column_check_result = $conn->query($column_check_query);
$created_at_exists = $column_check_result->num_rows > 0;

// Adjust SQL query based on `created_at` column existence
if ($created_at_exists) {
    $sql = "SELECT teacher_regno, message, created_at FROM course_messages WHERE course_code = ? ORDER BY created_at DESC";
} else {
    $sql = "SELECT teacher_regno, message FROM course_messages WHERE course_code = ? ORDER BY teacher_regno DESC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $course_code);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

if (empty($messages)) {
    sendResponse(false, "No messages found for this course.");
}

sendResponse(true, "Messages retrieved successfully.", $messages);

// Close connections
$stmt->close();
$conn->close();
