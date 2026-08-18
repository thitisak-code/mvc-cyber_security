<?php
require __DIR__ . '/includes/db.php';
requireAdmin();

$pdo = getConnection();
$summary = $pdo->query(
    'SELECT COUNT(*) AS total_students,
            SUM(CASE WHEN score > 0 THEN 1 ELSE 0 END) AS attempts,
            SUM(CASE WHEN passed = 1 THEN 1 ELSE 0 END) AS passed_students,
            ROUND(AVG(CASE WHEN score > 0 THEN score END), 2) AS avg_score
     FROM students'
)->fetch();
$surveySummary = $pdo->query(
    'SELECT COUNT(*) AS total_surveys,
            ROUND(AVG(rating), 2) AS avg_rating,
            SUM(CASE WHEN recommend = "แน่นอน" THEN 1 ELSE 0 END) AS strongly_recommend
     FROM website_surveys'
)->fetch();
$stmt = $pdo->query('SELECT * FROM students ORDER BY passed DESC, score DESC, created_at DESC');
$students = $stmt->fetchAll();
$surveyRows = $pdo->query('SELECT * FROM website_surveys ORDER BY created_at DESC LIMIT 10')->fetchAll();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Portal | Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="container nav-wrap">
            <div class="brand"><?php include __DIR__ . '/includes/logo.php'; ?> Admin Dashboard</div>
            <nav>
                <a href="admin.php" class="nav-item active"><span class="nav-icon" aria-hidden="true">👥</span><span class="nav-label">นักศึกษา</span></a>
                <a href="survey.php" class="nav-item"><span class="nav-icon" aria-hidden="true">⭐</span><span class="nav-label">ประเมิน</span></a>
                <a href="logout.php" class="nav-item"><span class="nav-icon" aria-hidden="true">🚪</span><span class="nav-label">ออกจากระบบ</span></a>
            </nav>
        </div>
    </header>

    <main class="container page-content">
        <section class="hero-panel">
            <div>
                <span class="badge">Session Active</span>
                <h1>ยินดีต้อนรับ <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin', ENT_QUOTES, 'UTF-8'); ?></h1>
                <p>ระบบบันทึกข้อมูลนักศึกษาและคะแนนแบบเรียลไทม์</p>
            </div>
            <div class="score-box">
                <small>ผู้ทำแบบทดสอบ</small>
                <strong><?= (int) ($summary['attempts'] ?? 0); ?></strong>
                <span>คน</span>
            </div>
        </section>

        <section class="cards-grid three">
            <article class="info-card">
                <h3>นักศึกษาทั้งหมด</h3>
                <p><?= (int) ($summary['total_students'] ?? 0); ?> คน</p>
            </article>
            <article class="info-card">
                <h3>ผู้ทำแบบทดสอบ</h3>
                <p><?= (int) ($summary['attempts'] ?? 0); ?> คน</p>
            </article>
            <article class="info-card">
                <h3>คะแนนเฉลี่ยผู้ทำแบบทดสอบ</h3>
                <p><?= htmlspecialchars((string) ($summary['avg_score'] ?? 0), ENT_QUOTES, 'UTF-8'); ?>%</p>
                <div class="meter">
                    <div class="meter-fill" style="width: <?= max(0, min(100, (float) ($summary['avg_score'] ?? 0))); ?>%"></div>
                </div>
            </article>
        </section>

        <section class="cards-grid three">
            <article class="info-card">
                <h3>จำนวนแบบประเมิน</h3>
                <p><?= (int) ($surveySummary['total_surveys'] ?? 0); ?> ครั้ง</p>
            </article>
            <article class="info-card">
                <h3>คะแนนความพึงพอใจเฉลี่ย</h3>
                <p><?= htmlspecialchars((string) ($surveySummary['avg_rating'] ?? 0), ENT_QUOTES, 'UTF-8'); ?> / 5</p>
            </article>
            <article class="info-card">
                <h3>แนะนำให้ใช้</h3>
                <p><?= (int) ($surveySummary['strongly_recommend'] ?? 0); ?> ครั้ง</p>
            </article>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h1>รายชื่อนักศึกษา</h1>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ</th>
                            <th>ห้อง</th>
                            <th>Username</th>
                            <th>คะแนน</th>
                            <th>สถานะ</th>
                            <th>วันที่สมัคร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= htmlspecialchars($student['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($student['room'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($student['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?= (int) $student['score']; ?>%
                                    <div class="meter" style="width: 90px;">
                                        <div class="meter-fill<?= (int) $student['passed'] === 1 ? '' : ' is-danger'; ?>" style="width: <?= max(0, min(100, (int) $student['score'])); ?>%"></div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ((int) $student['passed'] === 1): ?>
                                        <span class="tag success">Passed</span>
                                    <?php else: ?>
                                        <span class="tag warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($student['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h1>ผลประเมินความพึงพอใจ</h1>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>คะแนน</th>
                            <th>แนะนำ</th>
                            <th>ส่วนที่ประเมิน</th>
                            <th>ข้อเสนอแนะ</th>
                            <th>วันที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($surveyRows as $index => $survey): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= htmlspecialchars($survey['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= (int) $survey['rating']; ?> / 5</td>
                                <td><?= htmlspecialchars($survey['recommend'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($survey['page'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($survey['comment'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($survey['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
