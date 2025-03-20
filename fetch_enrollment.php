<?php
include 'db.php'; // Include database connection

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, "Invalid request method.");
}

// Validate student registration number (regno) input
if (!isset($_GET['regno']) || empty(trim($_GET['regno']))) {
    sendResponse(false, "Student registration number (regno) is required.");
}

$regno = trim($_GET['regno']); // Get regno from query params

// Query to fetch courses from 'courses' table where student has submitted a survey
$sql = "SELECT c.course_code, c.course_name, c.slot, c.max_students, c.teacher_regno 
        FROM courses c 
        JOIN course_survey s ON c.course_code = s.course_code AND c.course_name = s.course_name AND c.slot = s.slot
        WHERE s.regno = ?
        ORDER BY c.id ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $regno);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
} else {
    sendResponse(false, "No enrolled courses found for this student.");
}

// Close database connection
$conn->close();

// Send response with enrolled courses
sendResponse(true, "Enrolled courses retrieved successfully.", $courses);
?>
