<?php
require __DIR__ . '/includes/db.php';
requireStudent();

$pdo = getConnection();
$user = currentUser();
$stmt = $pdo->prepare('SELECT full_name, score FROM students WHERE id = ? LIMIT 1');
$stmt->execute([(int) $user['id']]);
$student = $stmt->fetch();

if (!$student || (int) $student['score'] < 70) {
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Portal | Certificate</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="certificate-page">
    <div class="certificate-wrap">
        <div class="certificate-card">
            <div class="certificate-header">
                <?php include __DIR__ . '/includes/logo.php'; ?>
                <span class="badge">Cyber Awareness Program</span>
                <h1>Certificate of Completion</h1>
            </div>

            <p class="certificate-text">This certifies that</p>
            <h2><?= htmlspecialchars($student['full_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p class="certificate-text">has successfully completed the Cyber Awareness training and scored</p>
            <h3><?= (int) $student['score']; ?>%</h3>
            <div class="meter" style="max-width: 260px; margin-left: auto; margin-right: auto;">
                <div class="meter-fill" style="width: <?= max(0, min(100, (int) $student['score'])); ?>%"></div>
            </div>
            <p class="certificate-footer">Issued by Cyber Portal Academy · <?= htmlspecialchars(date('d M Y'), ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>
</body>
</html>
