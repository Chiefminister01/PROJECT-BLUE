<?php
include 'db.php'; // Include database connection

function sendResponse($status, $message, $data = [])
{
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(false, "Invalid request method.");
}

// Updated query: Removed `created_at`
$sql = "SELECT id, message FROM admin_messages ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            "id" => $row['id'],
            "message" => $row['message']
        ];
    }
    sendResponse(true, "Messages retrieved successfully.", $messages);
} else {
    sendResponse(false, "No messages found.");
}

$conn->close();
