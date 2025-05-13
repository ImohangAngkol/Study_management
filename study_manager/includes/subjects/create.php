<?php
require_once '../config.php';
redirectIfNotLoggedIn();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $target_hours = floatval($_POST['target_hours']);
    
    if (empty($name)) {
        $error = 'Subject name is required';
    } else {
        $stmt = $pdo->prepare("INSERT INTO subjects (user_id, name, description, target_hours) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $name, $description, $target_hours]);
        
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
    <title>Add New Subject</title>
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
        <h2>Add New Subject</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="name">Subject Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="target_hours">Target Hours</label>
                <input type="number" id="target_hours" name="target_hours" step="0.1" min="0" value="10">
            </div>
            
            <button type="submit" class="btn">Add Subject</button>
        </form>
    </main>
    
    <footer>
        <p>Study Manager &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>