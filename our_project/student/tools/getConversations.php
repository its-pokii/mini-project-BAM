<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../../auth/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// get all conversations — last message per person
$stmt = mysqli_prepare($connector,
    "SELECT 
        users.id            AS user_id,
        users.first_name,
        users.last_name,
        users.profile_photo,
        messages.message_text AS last_message,
        messages.sent_at    AS last_time,
        messages.is_read,
        messages.sender_id,
        (SELECT COUNT(*) FROM messages 
         WHERE sender_id = users.id 
         AND receiver_id = ? 
         AND is_read = 0) AS unread_count
     FROM users 
     INNER JOIN messages  
        ON (messages.sender_id = users.id   AND messages.receiver_id = ?)
        OR (messages.sender_id = ?      AND messages.receiver_id = users.id)
     WHERE users.id != ?
     AND messages.sent_at = (
         SELECT MAX(messages.sent_at) FROM messages 
         WHERE (messages.sender_id = users.id   AND messages.receiver_id = ?)
            OR (messages.sender_id = ?      AND messages.receiver_id = users.id)
     )
     ORDER BY messages.sent_at DESC"
);

mysqli_stmt_bind_param($stmt, "iiiiii", 
    $user_id, $user_id, $user_id, 
    $user_id, $user_id, $user_id
);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$convos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $convos[] = $row;
}

echo json_encode(['success' => true, 'data' => $convos]);
?>