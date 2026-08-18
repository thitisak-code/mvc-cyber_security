<?php
require __DIR__ . '/includes/db.php';
requireLogin();

$pdo = getConnection();
$user = currentUser();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int) ($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    $recommend = trim($_POST['recommend'] ?? '');
    $page = trim($_POST['page'] ?? '');

    if ($rating < 1 || $rating > 5) {
        $error = 'กรุณาให้คะแนนความพึงพอใจ 1-5 ดาว';
    } else {
        $stmt = $pdo->prepare('INSERT INTO website_surveys (user_id, username, rating, comment, recommend, page, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            (int) ($user['id'] ?? 0),
            $user['username'] ?? 'guest',
            $rating,
            $comment,
            $recommend,
            $page,
        ]);

        $success = 'ขอบคุณสำหรับการประเมินความพึงพอใจของคุณ';
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Portal | Satisfaction Survey</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="container nav-wrap">
            <div class="brand"><?php include __DIR__ . '/includes/logo.php'; ?> Cyber Awareness</div>
            <nav>
                <a href="index.php" class="nav-item"><span class="nav-icon" aria-hidden="true">🏠</span><span class="nav-label">หน้าแรก</span></a>
                <a href="dashboard.php" class="nav-item"><span class="nav-icon" aria-hidden="true">📊</span><span class="nav-label">แดชบอร์ด</span></a>
                <a href="quiz.php" class="nav-item"><span class="nav-icon" aria-hidden="true">🧠</span><span class="nav-label">แบบทดสอบ</span></a>
                <a href="survey.php" class="nav-item active"><span class="nav-icon" aria-hidden="true">⭐</span><span class="nav-label">ประเมิน</span></a>
                <a href="logout.php" class="nav-item"><span class="nav-icon" aria-hidden="true">🚪</span><span class="nav-label">ออกจากระบบ</span></a>
            </nav>
        </div>
    </header>

    <main class="container page-content">
        <section class="panel survey-shell">
            <div class="panel-header survey-header">
                <div class="survey-meta">
                    <span class="survey-pill">Website Experience</span>
                    <span class="survey-pill">5-point feedback</span>
                </div>
                <h1>แบบประเมินความพึงพอใจของเว็บไซต์</h1>
                <p>ช่วยให้เราเข้าใจว่าคุณรู้สึกอย่างไรต่อประสบการณ์การเรียนรู้และการใช้งานเว็บไซต์</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form method="post" class="survey-form">
                <label>
                    ความพึงพอใจโดยรวม (1-5 ดาว)
                    <div class="rating-row">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <label class="star-option">
                                <input type="radio" name="rating" value="<?= $i; ?>" required>
                                <span><?= $i; ?> ★</span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </label>

                <label>
                    คำแนะนำหรือข้อเสนอแนะ
                    <textarea name="comment" rows="5" placeholder="กรอกข้อเสนอแนะ เช่น การใช้งานง่าย, เนื้อหาเหมาะสม, ต้องการปรับปรุงอะไร"></textarea>
                </label>

                <label>
                    คุณจะแนะนำเว็บไซต์นี้ให้ผู้อื่นใช้งานหรือไม่?
                    <select name="recommend">
                        <option value="">-- เลือก --</option>
                        <option value="แน่นอน">แน่นอน</option>
                        <option value="มีโอกาส">มีโอกาส</option>
                        <option value="ไม่แน่ใจ">ไม่แน่ใจ</option>
                        <option value="ไม่แนะนำ">ไม่แนะนำ</option>
                    </select>
                </label>

                <label>
                    ส่วนที่ประเมิน
                    <select name="page">
                        <option value="">-- เลือก --</option>
                        <option value="หน้าแรก">หน้าแรก</option>
                        <option value="หน้า Login / Register">หน้า Login / Register</option>
                        <option value="Dashboard">Dashboard</option>
                        <option value="แบบทดสอบ">แบบทดสอบ</option>
                        <option value="ใบประกาศนียบัตร">ใบประกาศนียบัตร</option>
                        <option value="ทั้งหมด">ทั้งหมด</option>
                    </select>
                </label>

                <button type="submit" class="btn btn-primary">ส่งแบบประเมิน</button>
            </form>
        </section>
    </main>
</body>
</html>
