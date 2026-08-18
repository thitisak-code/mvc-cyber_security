<?php
require __DIR__ . '/includes/db.php';

$pdo = getConnection();
$error = '';
$success = '';

if (currentUser()) {
    redirect((currentUser()['role'] ?? '') === 'admin' ? 'admin.php' : 'dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $room = trim($_POST['room'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($fullName === '' || $room === '' || $username === '' || $password === '') {
        $error = 'กรุณากรอกข้อมูลให้ครบทุกช่อง';
    } elseif (strlen($password) < 6) {
        $error = 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร';
    } elseif ($password !== $confirmPassword) {
        $error = 'ยืนยันรหัสผ่านไม่ตรงกัน';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM students WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = 'Username นี้ถูกใช้งานแล้ว';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO students (full_name, room, username, password, score, passed, created_at) VALUES (?, ?, ?, ?, 0, 0, NOW())');
            $stmt->execute([$fullName, $room, $username, $passwordHash]);

            $success = 'สมัครสมาชิกสำเร็จแล้ว กรุณาเข้าสู่ระบบ';
            $_POST = [];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Portal | Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-shell">
        <div class="auth-card">
            <div class="brand-block">
                <?php include __DIR__ . '/includes/logo.php'; ?>
                <span class="badge">สร้างบัญชีผู้เรียน</span>
                <h1>สมัครสมาชิก</h1>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form method="post" class="auth-form">
                <label>
                    ชื่อ-นามสกุล
                    <input type="text" name="full_name" placeholder="กรอกชื่อ-นามสกุล" required>
                </label>

                <label>
                    ห้อง
                    <input type="text" name="room" placeholder="เช่น 5/1" required>
                </label>

                <label>
                    Username
                    <input type="text" name="username" placeholder="username" required>
                </label>

                <label>
                    Password
                    <input type="password" name="password" placeholder="รหัสผ่าน" required>
                </label>

                <label>
                    ยืนยัน Password
                    <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" required>
                </label>

                <button type="submit" class="btn btn-primary full-width">สมัครสมาชิก</button>
            </form>

            <div class="auth-links">
                <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
            </div>
        </div>
    </div>
</body>
</html>
