<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
require_once '../../auth/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message_text' => 'Not logged in']);
    exit;
}

$user_id     = (int)$_SESSION['user_id'];
$other_id    = (int)($_GET['user_id'] ?? 0);

if ($other_id === 0) {
    echo json_encode(['success' => false, 'message_text' => 'Invalid user']);
    exit;
}

// mark messages as read
$stmt = mysqli_prepare($connector,
    "UPDATE messages SET is_read = 1 
     WHERE sender_id = ? AND receiver_id = ?"
);
mysqli_stmt_bind_param($stmt, "ii", $other_id, $user_id);
mysqli_stmt_execute($stmt);

// get all messages between two users
$stmt = mysqli_prepare($connector,
    "SELECT 
        id,
        sender_id,
        receiver_id,
        message_text AS message,
        is_read,
        sent_at
     FROM messages
     WHERE (sender_id = ? AND receiver_id = ?)
        OR (sender_id = ? AND receiver_id = ?)
     ORDER BY sent_at ASC"
);
mysqli_stmt_bind_param($stmt, "iiii", 
    $user_id, $other_id, 
    $other_id, $user_id
);
mysqli_stmt_execute($stmt);
$result   = mysqli_stmt_get_result($stmt);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['success' => true, 'data' => $messages]);
?>
