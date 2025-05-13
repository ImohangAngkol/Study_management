<?php
require_once '../config.php';
redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header('Location: ../../dashboard.php');
    exit();
}

$subject_id = $_GET['id'];
$error = '';

// Verify the subject belongs to the current user
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND user_id = ?");
$stmt->execute([$subject_id, $_SESSION['user_id']]);
$subject = $stmt->fetch();

if (!$subject) {
    header('Location: ../../dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $hours_studied = floatval($_POST['hours_studied']);
    $target_hours = floatval($_POST['target_hours']);
    
    if (empty($name)) {
        $error = 'Subject name is required';
    } else {
        $stmt = $pdo->prepare("UPDATE subjects SET name = ?, description = ?, hours_studied = ?, target_hours = ? WHERE id = ?");
        $stmt->execute([$name, $description, $hours_studied, $target_hours, $subject_id]);
        
        header('Location: ../../dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
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
        <h2>Edit Subject</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="name">Subject Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($subject['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="hours_studied">Hours Studied</label>
                <input type="number" id="hours_studied" name="hours_studied" step="0.1" min="0" value="<?php echo htmlspecialchars($subject['hours_studied']); ?>">
            </div>
            
            <div class="form-group">
                <label for="target_hours">Target Hours</label>
                <input type="number" id="target_hours" name="target_hours" step="0.1" min="0" value="<?php echo htmlspecialchars($subject['target_hours']); ?>">
            </div>
            
            <button type="submit" class="btn">Update Subject</button>
        </form>
    </main>
    
    <footer>
        <p>Study Manager &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>