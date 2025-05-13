<?php
require_once 'includes/config.php';
redirectIfNotLoggedIn();

// Get all subjects for the current user
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$subjects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Manager - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Study Manager</h1>
        <nav>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" class="btn btn-logout">Logout</a>
        </nav>
    </header>
    
    <main class="container">
        <div class="actions">
            <a href="includes/subjects/create.php" class="btn">Add New Subject</a>
            <button id="backupBtn" class="btn">Backup Data</button>
        </div>
        
        <div class="subjects-list">
            <?php if (empty($subjects)): ?>
                <p>No subjects found. Add your first subject to get started!</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Hours Studied</th>
                            <th>Target Hours</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($subject['name']); ?></td>
                                <td><?php echo htmlspecialchars($subject['description']); ?></td>
                                <td><?php echo htmlspecialchars($subject['hours_studied']); ?></td>
                                <td><?php echo htmlspecialchars($subject['target_hours']); ?></td>
                                <td>
                                    <?php 
                                    $progress = $subject['target_hours'] > 0 
                                        ? min(100, ($subject['hours_studied'] / $subject['target_hours']) * 100) 
                                        : 0;
                                    ?>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: <?php echo $progress; ?>%"></div>
                                        <span><?php echo round($progress); ?>%</span>
                                    </div>
                                </td>
                                <td class="actions">
                                    <a href="includes/subjects/update.php?id=<?php echo $subject['id']; ?>" class="btn btn-edit">Edit</a>
                                    <a href="includes/subjects/delete.php?id=<?php echo $subject['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
    <td class="actions">
    <a href="includes/subjects/read.php?id=<?php echo $subject['id']; ?>" class="btn btn-view">View</a>
    <a href="includes/subjects/update.php?id=<?php echo $subject['id']; ?>" class="btn btn-edit">Edit</a>
    <a href="includes/subjects/delete.php?id=<?php echo $subject['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
</td>
    <footer>
        <p>Study Manager &copy; <?php echo date('Y'); ?></p>
        <p>Created with PHP, MySQL, and XAMPP</p>
    </footer>
    
    <script src="assets/js/script.js"></script>
</body>
</html>