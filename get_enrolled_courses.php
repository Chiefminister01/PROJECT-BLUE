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

// Fetch enrolled courses with course details
$sql = "SELECT e.course_id, c.course_code, c.course_name, e.slot, e.enrollment_date 
        FROM enrolled_courses e
        JOIN courses c ON e.course_id = c.id
        WHERE e.regno = ?
        ORDER BY e.enrollment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $regno);
$stmt->execute();
$result = $stmt->get_result();

$enrolledCourses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $enrolledCourses[] = $row;
    }
} else {
    sendResponse(false, "No enrolled courses found.");
}

// Close database connection
$conn->close();

// Send response with enrolled courses
sendResponse(true, "Enrolled courses retrieved successfully.", $enrolledCourses);
?>
