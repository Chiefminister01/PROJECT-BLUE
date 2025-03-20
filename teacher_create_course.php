<?php
include 'db.php';

header("Content-Type: application/json");

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Read raw JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Check required fields
if (!isset($data['course_code']) || !isset($data['course_name']) || !isset($data['slot']) || !isset($data['max_students']) || !isset($data['teacher_regno'])) {
    sendResponse(false, "Invalid input data.");
}

$course_code = trim($data['course_code']);
$course_name = trim($data['course_name']);
$slot = trim($data['slot']);
$max_students = intval($data['max_students']);
$teacher_regno = intval($data['teacher_regno']);

// Check if course_code already exists
$checkQuery = "SELECT id FROM courses WHERE course_code = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("s", $course_code);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    sendResponse(false, "Course code already exists.");
}

// Insert the new course
$query = "INSERT INTO courses (course_code, course_name, slot, max_students, teacher_regno) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssis", $course_code, $course_name, $slot, $max_students, $teacher_regno);

if ($stmt->execute()) {
    sendResponse(true, "Course added successfully.");
} else {
    sendResponse(false, "Failed to add course.");
}
?>
