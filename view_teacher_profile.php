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

// Fetch all teacher profiles
$sql = "SELECT id, regno, full_name, contact_number, email, dob, address, profile_picture, bio FROM teacher_profiles ORDER BY full_name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $teachers = [];
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
    sendResponse(true, "Teacher profiles retrieved successfully.", $teachers);
} else {
    sendResponse(false, "No teacher records found.");
}

// Close database connection
$conn->close();
?>
