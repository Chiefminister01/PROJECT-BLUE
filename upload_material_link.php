<?php
include 'db.php'; // Include the database connection

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, "Invalid request method.");
}

// Get input data
$teacher_regno = isset($_POST['teacher_regno']) ? trim($_POST['teacher_regno']) : '';
$course_code = isset($_POST['course_code']) ? trim($_POST['course_code']) : '';
$material_link = isset($_POST['material_link']) ? trim($_POST['material_link']) : '';

// Validate input
if (empty($teacher_regno) || empty($course_code) || empty($material_link)) {
    sendResponse(false, "All fields are required.");
}

// Insert into database
$sql = "INSERT INTO course_materials (teacher_regno, course_code, material_link) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $teacher_regno, $course_code, $material_link);

if ($stmt->execute()) {
    sendResponse(true, "Course material uploaded successfully.");
} else {
    sendResponse(false, "Error uploading course material.");
}

// Close the database connection
$stmt->close();
$conn->close();
?>
