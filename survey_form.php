<?php
session_start();
include 'db.php'; // Database connection

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input data from POST
    $regno = isset($_POST['regno']) ? trim($_POST['regno']) : '';
    $course_code = isset($_POST['course_code']) ? trim($_POST['course_code']) : '';
    $course_name = isset($_POST['course_name']) ? trim($_POST['course_name']) : '';
    $slot = isset($_POST['slot']) ? trim($_POST['slot']) : '';

    // Validate input
    if (empty($regno) || empty($course_code) || empty($course_name) || empty($slot)) {
        sendResponse(false, "All fields are required.");
    }

    // Check if the student has already submitted a survey for the same course_code and course_name
    $checkQuery = "SELECT id FROM course_survey WHERE regno = ? AND course_code = ? AND course_name = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("sss", $regno, $course_code, $course_name);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        sendResponse(false, "You have already submitted a survey for this course.");
    }

    // Check if the student has already submitted two surveys for the same slot
    $slotCheckQuery = "SELECT COUNT(*) FROM course_survey WHERE regno = ? AND slot = ?";
    $slotCheckStmt = $conn->prepare($slotCheckQuery);
    $slotCheckStmt->bind_param("ss", $regno, $slot);
    $slotCheckStmt->execute();
    $slotCheckStmt->bind_result($slotCount);
    $slotCheckStmt->fetch();
    $slotCheckStmt->close();

    if ($slotCount >= 2) {
        sendResponse(false, "You can only submit a maximum of two surveys for the same slot.");
    }

    // Insert survey data into the database
    $sql = "INSERT INTO course_survey (regno, course_code, course_name, slot) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $regno, $course_code, $course_name, $slot);

    if ($stmt->execute()) {
        sendResponse(true, "Survey submitted successfully.");
    } else {
        sendResponse(false, "Error submitting survey.");
    }
} else {
    sendResponse(false, "Invalid request method.");
}
?>
