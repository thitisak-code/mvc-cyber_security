<?php
require __DIR__ . '/includes/db.php';
requireStudent();

$pdo = getConnection();
$user = currentUser();

$questions = [
    1 => ['question' => 'ความหมายที่แท้จริงของ Digital Literacy ตามเนื้อหา คือข้อใด?', 'options' => ['A. การรู้วิธีดาวน์โหลดแอป', 'B. การมี digital footprint ที่น่าเชื่อถือ', 'C. การเข้าถึงอินเทอร์เน็ตความเร็วสูง', 'D. กระบวนการคิดเชิงวิเคราะห์เพื่อยกระดับตัวเองเป็น Human Firewall'], 'answer' => 'D'],
    2 => ['question' => 'เสาหลัก 3 ประการของ Human Firewall คือข้อใด?', 'options' => ['A. การใช้ VPN, MFA, ตรวจสอบโดเมนอีเมล', 'B. การเปลี่ยนรหัสผ่านทุกเดือน, แจ้งความ, ติดตั้งแอนตี้ไวรัส', 'C. ปกป้องข้อมูลส่วนตัว, มีสติหลีกเลี่ยง social engineering, จัดการ digital footprint', 'D. ไม่รับสายคนแปลกหน้า, ไม่คลิกลิงก์, ไม่โอนเงิน'], 'answer' => 'C'],
    3 => ['question' => 'มิจฉาชีพทำฟิชชิงมักเล่นกับความรู้สึกใดของเหยื่อ?', 'options' => ['A. ความอยากรู้อยากเห็นหรือความเร่งรีบ', 'B. ความโกรธแค้น', 'C. ความเห็นอกเห็นใจ', 'D. ความกลัวเรื่องภาษี'], 'answer' => 'A'],
    4 => ['question' => 'สัญญาณเตือนที่ชัดเจนว่ากำลังคุยกับมิจฉาชีพคือข้อใด?', 'options' => ['A. เจ้าหน้าที่ธนาคารขอให้ยืนยันตัวตนผ่านแอปทางการ', 'B. ได้รับสายจากไปรษณีย์ไทยด้วยหมายเลข 150', 'C. ได้รับอีเมลแจ้งจาก facebooksupport@mail.com', 'D. ได้รับอีเมลจาก support@official.facebook.com'], 'answer' => 'C'],
    5 => ['question' => 'ขั้นตอนสุดท้ายของกลวิธีแอปดูดเงินคืออะไร?', 'options' => ['A. แอบอ้างเป็นเจ้าหน้าที่รัฐเพื่อขอชื่อสกุล', 'B. หลอกให้ติดตั้งไฟล์ .apk ผ่าน Line', 'C. ส่ง SMS ให้ไปรับเอกสาร', 'D. โทรศัพท์ข่มขู่เรื่องภาษี'], 'answer' => 'B'],
    6 => ['question' => 'กรมที่ดินมีกฎเหล็กในการติดต่อประชาชนอย่างไร?', 'options' => ['A. ไม่โทรหา, ไม่คอล Line, และไม่มีการเรียกเก็บภาษีผ่านโทรศัพท์', 'B. ติดต่อผ่านวิดีโอคอลเท่านั้น', 'C. ใช้บัญชีม้าในการรับชำระเงิน', 'D. เรียกเก็บภาษีผ่าน SMS'], 'answer' => 'A'],
    7 => ['question' => 'Deepfake ควรสังเกตจุดผิดปกติแบบใด?', 'options' => ['A. การกระพริบตาแข็งทื่อและรอยต่อผิวหนัง', 'B. การใช้ภาษาชัดเจน', 'C. การแต่งกายเป็นทางการ', 'D. ระยะเวลาคลิปสั้นเกิน 1 นาที'], 'answer' => 'A'],
    8 => ['question' => 'MFA ทำลายค่าใช้จ่ายจากรหัสผ่านที่ถูกขโมยได้อย่างไร?', 'options' => ['A. ลบข้อมูลบัญชีทันที', 'B. เปลี่ยนรหัสผ่านทุก 5 นาที', 'C. จะถามปัจจัยอื่นนอกจากรหัสผ่าน เช่น OTP หรือลายนิ้วมือ', 'D. บังคับตั้งรหัสผ่านใหม่'], 'answer' => 'C'],
    9 => ['question' => 'สิ่งที่เป็น (Something you are) ใน MFA คือข้อใด?', 'options' => ['A. รหัส PIN 6 หลัก', 'B. แอป Authenticator', 'C. รหัส OTP จาก SMS', 'D. ใบหน้าหรือลายนิ้วมือ'], 'answer' => 'D'],
    10 => ['question' => 'หากตกเป็นเหยื่อ ขั้นตอนแรกของ 8 ขั้นตอนรับมือด่วนคือข้อใด?', 'options' => ['A. แจ้งความที่ thaipoliceonline.go.th', 'B. โทรสายด่วน 1441', 'C. แจ้งเตือนคนรอบข้าง', 'D. เปลี่ยนรหัสผ่านทันที'], 'answer' => 'D'],
    11 => ['question' => 'สายด่วนหมายเลขใดใช้สำหรับระงับบัญชีธนาคาร?', 'options' => ['A. 1200', 'B. 150', 'C. 1441', 'D. 1111'], 'answer' => 'C'],
    12 => ['question' => 'มาตรฐานความปลอดภัยเว็บไซต์ที่หน่วยงานรัฐไทยจะบังคับใช้คืออะไร?', 'options' => ['A. Cyber Shield 2026', 'B. MFA Standard 2.0', 'C. Human Firewall Protocol', 'D. WSS 1.0'], 'answer' => 'D'],
    13 => ['question' => 'ตัวอย่างของสิ่งที่มี (Something you have) ใน MFA คือข้อใด?', 'options' => ['A. รหัสผ่านหลัก', 'B. การสแกนม่านตา', 'C. อุปกรณ์ Physical Security Key หรือรหัส OTP จาก Authenticator', 'D. คำถามความปลอดภัย'], 'answer' => 'C'],
    14 => ['question' => 'เมื่อสงสัยว่ามีแอปดูดเงินหรือไฟล์ .apk ให้ทำสิ่งใดเป็นอันดับแรก?', 'options' => ['A. รีสตาร์ตเครื่อง', 'B. ตัดการเชื่อมต่ออินเทอร์เน็ตทันที', 'C. ทักไปสอบถามคนส่งใน Line', 'D. แคปหน้าจอแล้วส่งให้เพื่อน'], 'answer' => 'B'],
    15 => ['question' => 'การจัดการ Digital Footprint ให้ถูกต้องคือข้อใด?', 'options' => ['A. เปิดเผยตำแหน่งกายภาพตลอดเวลา', 'B. โพสต์รูปบัตรประชาชน', 'C. หลีกเลี่ยงการแชร์ PII เช่น วันเกิด เลขบัตร ที่อยู่ หรือภาพเอกสารสำคัญ', 'D. ใช้ชื่อจริงเป็นรหัสผ่านทุกบัญชี'], 'answer' => 'C'],
];

$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';
$score = 0;

if ($submitted) {
    foreach ($questions as $id => $q) {
        $answer = $_POST['q' . $id] ?? '';
        if ($answer === $q['answer']) {
            $score++;
        }
    }

    $percent = round(($score / count($questions)) * 100);
    $passed = $percent >= 70 ? 1 : 0;

    $stmt = $pdo->prepare('UPDATE students SET score = ?, passed = ? WHERE id = ?');
    $stmt->execute([$percent, $passed, (int) $user['id']]);

    $_SESSION['last_quiz_score'] = $percent;
    $_SESSION['last_quiz_passed'] = $passed;
    redirect('quiz.php?result=1');
}

$result = $_GET['result'] ?? null;
$lastScore = $_SESSION['last_quiz_score'] ?? null;
$lastPassed = $_SESSION['last_quiz_passed'] ?? null;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Portal | Quiz</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="container nav-wrap">
            <div class="brand"><?php include __DIR__ . '/includes/logo.php'; ?> Cyber Awareness</div>
            <nav>
                <a href="index.php">หน้าแรก</a>
                <a href="dashboard.php">แดชบอร์ด</a>
                <a href="quiz.php" class="active">แบบทดสอบ</a>
                <a href="logout.php">ออกจากระบบ</a>
            </nav>
        </div>
    </header>

    <main class="container page-content">
        <?php if ($result && $lastScore !== null): ?>
            <div class="alert <?= $lastPassed ? 'alert-success' : 'alert-warning'; ?>">
                ผลคะแนนของคุณ: <strong><?= (int) $lastScore; ?>%</strong>
                <?= $lastPassed ? 'ผ่านเกณฑ์ 70% แล้ว' : 'ยังไม่ผ่านเกณฑ์ 70% กรุณาทบทวนและทำใหม่อีกครั้ง' ?>
            </div>
        <?php endif; ?>

        <section class="panel">
            <div class="panel-header">
                <h1>แบบทดสอบ Cyber Awareness</h1>
                <p>คำชี้แจง: เลือกคำตอบที่ถูกต้องที่สุดเพียง 1 ข้อต่อข้อ</p>
            </div>

            <form method="post" class="quiz-form">
                <?php foreach ($questions as $id => $q): ?>
                    <div class="question-block">
                        <h3><?= $id; ?>. <?= htmlspecialchars($q['question'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <?php foreach ($q['options'] as $option): ?>
                            <label class="option-row">
                                <input type="radio" name="q<?= $id; ?>" value="<?= substr($option, 0, 1); ?>" required>
                                <span><?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8'); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary">ส่งคำตอบ</button>
            </form>
        </section>
    </main>
</body>
</html>
