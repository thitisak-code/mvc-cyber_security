<?php
require __DIR__ . '/includes/db.php';
requireStudent();

$pdo = getConnection();
$user = currentUser();
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ? LIMIT 1');
$stmt->execute([(int) $user['id']]);
$student = $stmt->fetch();

$score = (int) ($student['score'] ?? 0);
$passed = (int) ($student['passed'] ?? 0);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Portal | Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="container nav-wrap">
            <div class="brand"><?php include __DIR__ . '/includes/logo.php'; ?> Cyber Awareness</div>
            <nav>
                <a href="index.php">หน้าแรก</a>
                <a href="dashboard.php" class="active">แดชบอร์ด</a>
                <a href="quiz.php">แบบทดสอบ</a>
                <?php if ($passed): ?>
                    <a href="certificate.php">ใบประกาศนียบัตร</a>
                <?php endif; ?>
                <a href="logout.php">ออกจากระบบ</a>
            </nav>
        </div>
    </header>

    <main class="container page-content">
        <section class="hero-panel">
            <div>
                <span class="badge">ยินดีต้อนรับ</span>
                <h1>สวัสดี <?= htmlspecialchars($student['full_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p>เรียนรู้พื้นฐานความปลอดภัยไซเบอร์และเสริมสร้าง Human Firewall ให้แข็งแกร่ง</p>
            </div>
            <div class="score-box">
                <small>คะแนนปัจจุบัน</small>
                <strong><?= $score; ?>%</strong>
                <span><?= $passed ? 'ผ่านเกณฑ์' : 'ยังไม่ผ่าน' ?></span>
                <div class="meter">
                    <div class="meter-fill<?= $passed ? '' : ' is-danger'; ?>" style="width: <?= max(0, min(100, $score)); ?>%"></div>
                </div>
            </div>
        </section>

        <section class="cards-grid three">
            <article class="info-card">
                <h3>บทเรียน</h3>
                <p>เรียนรู้เรื่อง Digital Literacy, Social Engineering, MFA และการป้องกันภัยไซเบอร์</p>
                <a href="index.php#lessons" class="btn btn-secondary">ดูเนื้อหา</a>
            </article>
            <article class="info-card">
                <h3>แบบทดสอบ</h3>
                <p>ประเมินความรู้จากเนื้อหา และเก็บคะแนนไว้ในระบบผู้ดูแล</p>
                <a href="quiz.php" class="btn btn-secondary">เริ่มทำแบบทดสอบ</a>
            </article>
            <article class="info-card">
                <h3>ใบประกาศนียบัตร</h3>
                <p>นักศึกษาที่ผ่านคะแนนจะได้รับใบรับรองออนไลน์</p>
                <?php if ($passed): ?>
                    <a href="certificate.php" class="btn btn-primary">ดูใบประกาศ</a>
                <?php else: ?>
                    <span class="muted">ยังไม่ผ่านเกณฑ์</span>
                <?php endif; ?>
            </article>
        </section>

        <section class="lesson-box">
            <h2>เนื้อหาหลักที่เรียนรู้</h2>
            <div class="list-block">
                <ul>
                    <li>Human Firewall และ Digital Literacy</li>
                    <li>โซนสีเขียวและพื้นที่สีดำ</li>
                    <li>Phishing, Call Center Scam, Fake App</li>
                    <li>AI Deepfake และการตรวจจับความผิดปกติ</li>
                    <li>Multi-Factor Authentication และ MFA Checklist</li>
                    <li>8 ขั้นตอนรับมือเมื่อถูกโจมตี</li>
                </ul>
            </div>
        </section>
    </main>
</body>
</html>
