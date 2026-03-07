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

$data        = json_decode(file_get_contents('../04-connection.php'), true);
$receiver_id = (int)($data['receiver_id'] ?? 0);
$message     = trim($data['message_text']      ?? '');
$sender_id   = (int)$_SESSION['user_id'];

if ($receiver_id === 0 || empty($message)) {
    echo json_encode(['success' => false, 'message_text' => 'Invalid request']);
    exit;
}

$stmt = mysqli_prepare($connector,
    "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "iis", $sender_id, $receiver_id, $message);
mysqli_stmt_execute($stmt);

echo json_encode([
    'success' => true,
    'message_id' => mysqli_insert_id($connector)
]);
?>