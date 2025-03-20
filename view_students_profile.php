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

// Fetch all student profiles
$sql = "SELECT id, regno, full_name, dob, course, year, nationality, contact_number, email, address, bio, gender, profile_picture FROM student_profiles ORDER BY full_name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    sendResponse(true, "Student profiles retrieved successfully.", $students);
} else {
    sendResponse(false, "No student records found.");
}

// Close database connection
$conn->close();
?>
