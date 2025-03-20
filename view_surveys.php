<?php
include 'db.php'; // Include database connection

// Function to send JSON response
function sendResponse($status, $message, $data = [])
{
    if (!is_array($data)) {
        $data = []; // Ensure 'data' is always an array
    }
    header('Content-Type: application/json');
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, "Invalid request method.", []);
}

// Fetch unique courses with their count
$sql = "SELECT course_code, course_name, COUNT(*) AS count 
        FROM course_survey 
        GROUP BY course_code, course_name 
        ORDER BY count DESC";

$result = $conn->query($sql);

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row; // Append each row as an array
}

// Close database connection
$conn->close();

// Ensure 'data' is an array, even if empty
sendResponse(true, "Survey data retrieved successfully.", $courses);
