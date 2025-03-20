<?php
include 'db.php'; // Include database connection

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, "Invalid request method.");
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input fields
if (!isset($data['regno']) || empty($data['regno']) || 
    !isset($data['course_id']) || empty($data['course_id']) ||
    !isset($data['slot']) || empty($data['slot'])) {
    sendResponse(false, "All fields (regno, course_id, slot) are required.");
}

$regno = trim($data['regno']);
$course_id = intval($data['course_id']);
$slot = trim($data['slot']);

// Check if the student has already enrolled in this course
$checkQuery = "SELECT id FROM enrolled_courses WHERE regno = ? AND course_id = ? AND slot = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("sis", $regno, $course_id, $slot);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    sendResponse(false, "You are already enrolled in this course.");
}

// Insert the enrollment record
$insertQuery = "INSERT INTO enrolled_courses (regno, course_id, slot) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param("sis", $regno, $course_id, $slot);

if ($insertStmt->execute()) {
    sendResponse(true, "Enrollment successful.");
} else {
    sendResponse(false, "Error enrolling in the course.");
}

// Close database connection
$conn->close();
?>
