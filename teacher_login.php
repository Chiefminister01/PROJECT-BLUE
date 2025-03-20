<?php
include 'db.php';

header("Content-Type: application/json");

// Function to send JSON response
function sendResponse($status, $message, $data = []) {
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method.");
}

// Check if regno and password are provided
if (!isset($_POST['regno']) || !isset($_POST['password'])) {
    sendResponse(false, "Invalid input data.");
}

$regno = trim($_POST['regno']);
$password = trim($_POST['password']);

// Query to check if user exists
$query = "SELECT * FROM teacher_profiles WHERE regno = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $regno);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    sendResponse(false, "Needed information required.");
}

$teacher = $result->fetch_assoc();

// Check if password matches (Assuming plain text, ideally, you should hash passwords)
if ($teacher['password'] !== $password) {
    sendResponse(false, "Unauthorized User.");
}

// If login is successful
sendResponse(true, "User exists.", [
    "regno" => $teacher['regno'],
    "full_name" => $teacher['full_name'],
    "email" => $teacher['email'],
    "contact_number" => $teacher['contact_number'],
    "dob" => $teacher['dob'],
    "address" => $teacher['address'],
    "profile_picture" => $teacher['profile_picture'],
    "bio" => $teacher['bio']
]);

mysqli_close($conn);
?>
