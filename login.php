<?php
require __DIR__ . '/includes/db.php';

$pdo = getConnection();
$error = '';

if (currentUser()) {
    redirect((currentUser()['role'] ?? '') === 'admin' ? 'admin.php' : 'dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin123') {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => 0,
            'name' => 'Administrator',
            'role' => 'admin',
            'username' => 'admin',
        ];
        redirect('admin.php');
    }

    $stmt = $pdo->prepare('SELECT * FROM students WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => $user['full_name'],
            'role' => 'student',
            'username' => $user['username'],
        ];
        redirect('dashboard.php');
    }

    $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Portal | Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-shell">
        <div class="auth-card">
            <div class="brand-block">
                <?php include __DIR__ . '/includes/logo.php'; ?>
                <span class="badge">Cyber Awareness Portal</span>
                <h1>เข้าสู่ระบบ</h1>
                <p>เรียนรู้เรื่องความปลอดภัยไซเบอร์และทดสอบความรู้ของคุณ</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form method="post" class="auth-form">
                <label>
                    Username
                    <input type="text" name="username" placeholder="username" required>
                </label>

                <label>
                    Password
                    <input type="password" name="password" placeholder="password" required>
                </label>

                <button type="submit" class="btn btn-primary full-width">เข้าสู่ระบบ</button>
            </form>

            <div class="auth-links">
                <p>ยังไม่มีสมาชิก? <a href="register.php">สมัครสมาชิก</a></p>
                <!-- <p>Admin demo: <strong>admin</strong> / <strong>admin123</strong></p> -->
            </div>
        </div>
    </div>
</body>
</html>
