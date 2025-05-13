<?php
require_once '../config.php';
redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header('Location: ../../dashboard.php');
    exit();
}

$subject_id = $_GET['id'];

// Verify the subject belongs to the current user before deleting
$stmt = $pdo->prepare("DELETE FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $_SESSION['user_id']]);

header('Location: ../../dashboard.php');
exit();
?>