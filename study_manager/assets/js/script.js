document.addEventListener('DOMContentLoaded', function() {
    // Backup button functionality
    const backupBtn = document.getElementById('backupBtn');
    if (backupBtn) {
        backupBtn.addEventListener('click', function() {
            window.location.href = 'includes/backup.php';
        });
    }
});