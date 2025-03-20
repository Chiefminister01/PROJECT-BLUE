<?php
include 'db.php';

header("Content-Type: application/json");

// Function to send JSON response
function sendResponse($status, $message, $data = [])
{
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Fetch courses that exist in both courses and course_survey tables
$query = "SELECT DISTINCT c.course_code, c.course_name, c.slot, c.max_students, c.teacher_regno, t.name AS teacher_name 
          FROM courses c
          JOIN course_survey cs ON c.course_code = cs.course_code
          JOIN teachers t ON c.teacher_regno = t.regno";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = [
            "course_code" => $row['course_code'],
            "course_name" => $row['course_name'],
            "slot" => $row['slot'],
            "max_students" => $row['max_students'],
            "teacher_name" => $row['teacher_name']
        ];
    }
    sendResponse(true, "Courses retrieved successfully.", $courses);
} else {
    sendResponse(false, "No matching courses found.");
}

$conn->close();
