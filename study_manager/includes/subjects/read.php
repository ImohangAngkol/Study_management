<?php
require_once '../config.php';
redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header('Location: ../../dashboard.php');
    exit();
}

$subject_id = $_GET['id'];

// Verify the subject belongs to the current user
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $_SESSION['user_id']]);
$subject = $stmt->fetch();

if (!$subject) {
    header('Location: ../../dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Subject - Study Manager</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Study Manager</h1>
        <nav>
            <a href="../../dashboard.php" class="btn">Back to Dashboard</a>
            <a href="../../logout.php" class="btn btn-logout">Logout</a>
        </nav>
    </header>
    
    <main class="container">
        <h2>Subject Details</h2>
        
        <div class="subject-details">
            <div class="detail-row">
                <span class="detail-label">Subject Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($subject['name']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Description:</span>
                <span class="detail-value"><?php echo htmlspecialchars($subject['description']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Hours Studied:</span>
                <span class="detail-value"><?php echo htmlspecialchars($subject['hours_studied']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Target Hours:</span>
                <span class="detail-value"><?php echo htmlspecialchars($subject['target_hours']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Progress:</span>
                <div class="progress-container">
                    <?php 
                    $progress = $subject['target_hours'] > 0 
                        ? min(100, ($subject['hours_studied'] / $subject['target_hours']) * 100) 
                        : 0;
                    ?>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $progress; ?>%"></div>
                        <span><?php echo round($progress); ?>%</span>
                    </div>
                </div>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Created At:</span>
                <span class="detail-value"><?php echo date('M j, Y g:i A', strtotime($subject['created_at'])); ?></span>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="update.php?id=<?php echo $subject['id']; ?>" class="btn btn-edit">Edit</a>
            <a href="delete.php?id=<?php echo $subject['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</a>
        </div>
    </main>
    
    <footer>
        <p>Study Manager &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>