<?php
header("Content-Type: application/json");
include 'db.php'; // Include database connection

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'Method Not Allowed']);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);
$student_regno = $input['regno'] ?? '';
$student_password = $input['password'] ?? '';

// Validate input
if (empty($student_regno) || empty($student_password)) {
    http_response_code(200);
    echo json_encode(['status' => false, 'message' => 'Please enter both registration number and password.']);
    exit();
}

try {
    // Prepare SQL query to check student existence
    $sql_check = "SELECT * FROM student_profiles WHERE regno = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $student_regno);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 0) {
        http_response_code(200);
        echo json_encode(['status' => false, 'message' => 'Student not found.']);
    } else {
        $student = $result_check->fetch_assoc();

        // Verify password
        if ($student_password == $student['password']) {
            http_response_code(200);
            echo json_encode(['status' => true, 'message' => 'Login successful', 'student' => [
                'regno' => $student['regno'],
                'name' => $student['full_name']
            ]]);
        } else {
            http_response_code(401);
            echo json_encode(['status' => false, 'message' => 'Invalid password.']);
        }
    }

    // Close connections
    $stmt_check->close();
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Internal Server Error', 'error' => $e->getMessage()]);
}
