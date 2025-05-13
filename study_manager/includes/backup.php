<?php
require_once 'config.php';
redirectIfNotLoggedIn();

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="study_manager_backup_' . date('Y-m-d') . '.json"');

// Get all user data
$userData = [
    'user' => [],
    'subjects' => []
];

// Get user info
$stmt = $pdo->prepare("SELECT username, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData['user'] = $stmt->fetch();

// Get subjects
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData['subjects'] = $stmt->fetchAll();

echo json_encode($userData, JSON_PRETTY_PRINT);
exit();
?>