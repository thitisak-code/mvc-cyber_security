<?php
require __DIR__ . '/includes/db.php';
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Awareness Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="container nav-wrap">
            <div class="brand"><?php include __DIR__ . '/includes/logo.php'; ?> Cyber Awareness</div>
            <nav>
                <a href="index.php" class="nav-item active"><span class="nav-icon" aria-hidden="true">🏠</span><span class="nav-label">หน้าแรก</span></a>
                <a href="#lessons" class="nav-item"><span class="nav-icon" aria-hidden="true">📚</span><span class="nav-label">เนื้อหา</span></a>
                <?php if ($user): ?>
                    <?php if (($user['role'] ?? '') === 'admin'): ?>
                        <a href="admin.php" class="nav-item"><span class="nav-icon" aria-hidden="true">🛡️</span><span class="nav-label">Admin</span></a>
                    <?php else: ?>
                        <a href="dashboard.php" class="nav-item"><span class="nav-icon" aria-hidden="true">📊</span><span class="nav-label">แดชบอร์ด</span></a>
                    <?php endif; ?>
                    <a href="survey.php" class="nav-item"><span class="nav-icon" aria-hidden="true">⭐</span><span class="nav-label">ประเมิน</span></a>
                    <a href="logout.php" class="nav-item"><span class="nav-icon" aria-hidden="true">🚪</span><span class="nav-label">ออกจากระบบ</span></a>
                <?php else: ?>
                    <a href="login.php" class="nav-item"><span class="nav-icon" aria-hidden="true">🔐</span><span class="nav-label">เข้าสู่ระบบ</span></a>
                    <a href="register.php" class="nav-item"><span class="nav-icon" aria-hidden="true">✍️</span><span class="nav-label">สมัครสมาชิก</span></a>
                    <a href="survey.php" class="nav-item"><span class="nav-icon" aria-hidden="true">⭐</span><span class="nav-label">ประเมิน</span></a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div>
                    <span class="badge">Human Firewall</span>
                    <h1>ปกป้องตนเองในยุคดิจิทัล</h1>
                    <p>ความปลอดภัยไซเบอร์เริ่มจากการตระหนักรู้ การมีสติ และการวิเคราะห์ข้อมูลก่อนก้าวเดินบนโลกออนไลน์ การมี Human Firewall ที่แข็งแกร่งคือการปกป้องข้อมูลส่วนตัวและหลีกเลี่ยงอาชญากรรมดิจิทัล</p>
                    <?php if ($user): ?>
                        <div class="cta-row">
                            <?php if (($user['role'] ?? '') === 'admin'): ?>
                                <a href="admin.php" class="btn btn-primary">ไปที่ Admin Dashboard</a>
                            <?php else: ?>
                                <a href="dashboard.php" class="btn btn-primary">ไปที่แดชบอร์ดของฉัน</a>
                            <?php endif; ?>
                            <a href="survey.php" class="btn btn-secondary">ประเมินความพึงพอใจ</a>
                        </div>
                    <?php else: ?>
                        <div class="cta-row">
                            <a href="register.php" class="btn btn-primary">สมัครสมาชิก</a>
                            <a href="login.php" class="btn btn-secondary">เข้าสู่ระบบ</a>
                            <a href="survey.php" class="btn btn-secondary">ประเมินความพึงพอใจ</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="hero-visual">
                    <video controls autoplay muted loop playsinline class="video-box">
                        <source src="assets/video/Cyber_Resilience.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </section>

        <section id="lessons" class="container page-content">
            <div class="section-title">
                <span class="badge">บทเรียนหลัก</span>
                <h2>เนื้อหา Cyber Resilience Briefing</h2>
            </div>

            <div class="cards-grid three">
                <article class="info-card">
                    <h3>1. Human Firewall & Digital Literacy</h3>
                    <p>เรียนรู้ว่าการมีสติ การวิเคราะห์ข้อมูล และการดูแลร่องรอยดิจิทัลเป็นพื้นฐานของ Human Firewall ที่ช่วยปกป้องตนเองจากการถูกหลอกลวงได้จริง</p>
                </article>
                <article class="info-card">
                    <h3>2. พื้นที่สีเขียวและสีดำ</h3>
                    <p>แยกความต่างระหว่างโซนปลอดภัยกับโซนภัยคุกคาม เช่น Phishing, Fake App, Call Center Scam, Deepfake และการหลอกให้ติดตั้งไฟล์ .apk</p>
                </article>
                <article class="info-card">
                    <h3>3. MFA & Authentication</h3>
                    <p>ทำความเข้าใจสิ่งที่รู้ สิ่งที่มี และสิ่งที่เป็น ใน MFA พร้อมเช็กลิสต์การตั้งค่าความปลอดภัยที่ควรใช้ทุกบัญชีสำคัญ</p>
                </article>
                <article class="info-card">
                    <h3>4. การจัดการ Digital Footprint</h3>
                    <p>รู้ว่า PII เช่น วันเกิด เลขบัตร ที่อยู่ หรือภาพเอกสารสำคัญไม่ควรถูกเปิดเผยสู่สาธารณะ เพราะอาจถูกใช้เป็นฐานโจมตีทาง Social Engineering</p>
                </article>
                <article class="info-card">
                    <h3>5. การรับมือฉุกเฉิน</h3>
                    <p>เรียนรู้ 8 ขั้นตอนรับมือฉุกเฉินหลังถูกเจาะระบบหรือหลอกให้ติดตั้งแอปปลอม พร้อมการติดต่อสายด่วน 1441 และ 1200</p>
                </article>
                <article class="info-card">
                    <h3>6. ความปลอดภัยเว็บไซต์และ AI</h3>
                    <p>เข้าใจมาตรฐาน WSS 1.0 และการตรวจจับความผิดปกติจาก Deepfake เพื่อปกป้องข้อมูลก่อนถูกหลอกหรือถูกแปลงข้อมูลอันตราย</p>
                </article>
            </div>
        </section>

        <section class="container page-content highlight-band">
            <div class="section-title">
                <span class="badge">จุดเด่น</span>
                <h2>ทำไมต้องเรียนรู้เรื่อง Cyber Awareness</h2>
            </div>

            <div class="feature-list">
                <div>• ป้องกันการสูญเสียข้อมูลส่วนตัวจากมิจฉาชีพ</div>
                <div>• เพิ่มความตระหนักรู้เรื่องแอปปลอม การหลอกลวงและ Deepfake</div>
                <div>• ปรับใช้ MFA และ Security Checklist ให้เหมาะสม</div>
                <div>• สร้างความมั่นใจในการใช้อินเทอร์เน็ตอย่างปลอดภัย</div>
                <div>• เข้าใจแนวทางการแจ้งเหตุและติดต่อสายด่วน 1441 / 1200</div>
                <div>• เตรียมความพร้อมสู่มาตรฐาน WSS 1.0 และยุค AI</div>
            </div>
        </section>

        <!-- ============ Executive Summary ============ -->
        <section class="container page-content">
            <div class="section-title">
                <span class="badge">Executive Summary</span>
                <h2>บทสรุปผู้บริหาร</h2>
            </div>
            <p class="brief-lede">ในยุคที่สมรภูมิดิจิทัลซับซ้อนขึ้นทุกวัน การปรับเปลี่ยนบทบาทของผู้ใช้งานจาก "จุดอ่อนที่เปราะบาง" ไปสู่ "เกราะป้องกันที่แข็งแกร่ง" หรือ Human Firewall คือยุทธศาสตร์ที่สำคัญที่สุด เนื้อหานี้เน้นย้ำการสร้างความตระหนักรู้ผ่านแนวคิด "พื้นที่สีเขียว" (โซนปลอดภัย) และ "พื้นที่สีดำ" (โซนภัยคุกคาม) ตั้งแต่พื้นฐาน Digital Literacy ไปจนถึงอาชญากรรมขั้นสูงที่ใช้ AI</p>
            <p class="brief-lede">ประเด็นสำคัญคือ "รหัสผ่าน" เป็นจุดอ่อนที่เสี่ยงที่สุด และ Multi-Factor Authentication (MFA) คือกุญแจสำคัญที่ทำลายมูลค่าของข้อมูลที่ถูกขโมย รวมถึงความจำเป็นของการรับมือที่รวดเร็วเมื่อถูกเจาะระบบ เพราะความเร็วในการตอบโต้คือเส้นแบ่งระหว่างความเสียหายเล็กน้อยกับความเสียหายทางการเงินขั้นรุนแรง</p>
        </section>

        <!-- ============ 3 Pillars ============ -->
        <section class="container page-content">
            <div class="section-title">
                <span class="badge">พื้นที่สีเขียว</span>
                <h2>เสาหลัก 3 ประการของ Human Firewall</h2>
            </div>
            <div class="pillars-grid">
                <article class="pillar-card">
                    <h3>ปกป้องข้อมูลส่วนตัว</h3>
                    <p>ป้องกันการสวมรอยจากมิจฉาชีพ ด้วยการควบคุมว่าใครเข้าถึงข้อมูลส่วนตัวของเราได้บ้าง</p>
                </article>
                <article class="pillar-card">
                    <h3>มีสติรู้เท่าทัน Social Engineering</h3>
                    <p>หลีกเลี่ยงการถูกชักจูงด้วยจิตวิทยา ไม่ตัดสินใจด้วยความเร่งรีบหรือความกลัว</p>
                </article>
                <article class="pillar-card">
                    <h3>บริหาร Digital Footprint</h3>
                    <p>ตระหนักว่าข้อมูลบนโลกออนไลน์คือบันทึกถาวรที่ส่งผลต่อความน่าเชื่อถือและอนาคตการทำงาน</p>
                </article>
            </div>
        </section>

        <!-- ============ Threat levels ============ -->
        <section class="container page-content highlight-band">
            <div class="section-title">
                <span class="badge">พื้นที่สีดำ</span>
                <h2>วิเคราะห์ภัยคุกคามและจิตวิทยามิจฉาชีพ</h2>
                <p>ภัยคุกคามยกระดับความรุนแรงและชั้นเชิงขึ้นเป็นลำดับ 3 ระดับ</p>
            </div>

            <div class="level-stack">
                <article class="level-block lvl-1">
                    <div class="level-head">
                        <span class="level-num">ระดับ 1 · พื้นฐาน</span>
                        <h3>กลลวงที่พบได้ทั่วไป</h3>
                    </div>
                    <ul>
                        <li><strong>Phishing:</strong> สร้างความอยากรู้หรือความเร่งรีบ เพื่อหลอกเอาข้อมูลล็อกอิน</li>
                        <li><strong>แก๊ง Call Center:</strong> ใช้ความกลัวในอำนาจรัฐกดดันให้เหยื่อโอนเงิน</li>
                        <li><strong>เครื่องมือผิดกฎหมาย:</strong> ใช้ "ซิมผี" และ "บัญชีม้า" ในกระบวนการฟอกเงิน ผู้รับจ้างเปิดบัญชีมีโทษทางกฎหมายรุนแรง</li>
                    </ul>
                </article>

                <article class="level-block lvl-2">
                    <div class="level-head">
                        <span class="level-num">ระดับ 2 · Social Engineering</span>
                        <h3>วิศวกรรมทางสังคมและแอปดูดเงิน</h3>
                    </div>
                    <p style="margin:0;">มิจฉาชีพลดทอนการควบคุมตัวเองของเหยื่ออย่างเป็นระบบผ่าน 3 ขั้นตอน</p>
                    <div class="attack-chain">
                        <span class="chain-step">1. แอบอ้าง — เป็นเจ้าหน้าที่รัฐ</span>
                        <span class="chain-arrow">→</span>
                        <span class="chain-step">2. ปั่นหัว — สร้างความตื่นตระหนก</span>
                        <span class="chain-arrow">→</span>
                        <span class="chain-step">3. ควบคุม — หลอกติดตั้งไฟล์ .apk ผ่าน Line</span>
                    </div>
                    <div class="note-strip">ข้อสังเกต: หน่วยงานรัฐ เช่น กรมที่ดิน มีกฎเหล็ก — ไม่โทรหา ไม่คอลไลน์ และไม่มีการเก็บภาษีผ่านโทรศัพท์เด็ดขาด</div>
                </article>

                <article class="level-block lvl-3">
                    <div class="level-head">
                        <span class="level-num">ระดับ 3 · AI ขั้นสูง</span>
                        <h3>Deepfake และอาชญากรรมที่ขับเคลื่อนด้วย AI</h3>
                    </div>
                    <p style="margin:0 0 6px;">มิจฉาชีพใช้ AI ปลอมแปลงทั้งเสียงและใบหน้า สังเกตจุดผิดปกติได้ดังนี้</p>
                    <div class="table-wrap">
                        <table class="signs-table">
                            <thead>
                                <tr><th>จุดที่ต้องสังเกต</th><th>ลักษณะความผิดปกติจาก AI</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>ดวงตา</td><td>การกระพริบตาที่ดูแข็งทื่อ ไม่เป็นธรรมชาติ</td></tr>
                                <tr><td>ริมฝีปาก</td><td>จังหวะการพูดไม่สัมพันธ์ (Sync) กับเสียง</td></tr>
                                <tr><td>ผิวหนัง</td><td>รอยต่อบริเวณขอบใบหน้ากับลำคอที่ไม่เนียนตา</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="note-strip">มาตรการเชิงโครงสร้าง: ประเทศไทยเตรียมบังคับใช้มาตรฐาน Website Security Standard (WSS 1.0) ภายในวันที่ 17 กันยายน 2569 เพื่อยกระดับการยืนยันตัวตนและป้องกันการเจาะหน้าเว็บไซต์ของหน่วยงานรัฐ</div>
                </article>
            </div>
        </section>

        <!-- ============ MFA strategy ============ -->
        <section class="container page-content">
            <div class="section-title">
                <span class="badge">ยุทธศาสตร์เชิงรุก</span>
                <h2>MFA: ทำลายมูลค่าของรหัสผ่านที่ถูกขโมย</h2>
                <p>การใช้รหัสผ่านเพียงชั้นเดียวเปรียบเสมือนล็อคบ้านด้วยกุญแจเก่า Multi-Factor Authentication เพิ่มอีก 2 ชั้นความปลอดภัย</p>
            </div>

            <div class="mfa-grid">
                <article class="mfa-card">
                    <div class="mfa-icon">Something you know</div>
                    <h3>สิ่งที่รู้</h3>
                    <p>รหัสผ่าน หรือ PIN</p>
                </article>
                <article class="mfa-card">
                    <div class="mfa-icon">Something you have</div>
                    <h3>สิ่งที่มี</h3>
                    <p>รหัส OTP หรือแอป Authenticator</p>
                </article>
                <article class="mfa-card">
                    <div class="mfa-icon">Something you are</div>
                    <h3>สิ่งที่เป็น</h3>
                    <p>การสแกนใบหน้า หรือลายนิ้วมือ</p>
                </article>
            </div>

            <ul class="checklist">
                <li>เปิดใช้งาน 2FA ในทุกบัญชีสำคัญ</li>
                <li>ตั้งรหัสผ่านที่ซับซ้อนและไม่ซ้ำกันในแต่ละบริการ</li>
                <li>อัปเดตระบบปฏิบัติการและแอปพลิเคชันให้เป็นแพตช์ล่าสุดเสมอ</li>
                <li>หลีกเลี่ยง WiFi สาธารณะ และพิจารณาใช้งาน VPN</li>
                <li>ตรวจสอบการตั้งค่าความเป็นส่วนตัวอย่างสม่ำเสมอ</li>
            </ul>
        </section>

        <!-- ============ Emergency response ============ -->
        <section class="container page-content highlight-band">
            <div class="section-title">
                <span class="badge">รับมือฉุกเฉิน</span>
                <h2>โปรโตคอลรับมือด่วน 8 ขั้นตอน</h2>
                <p>หากระบบป้องกันถูกเจาะ ความเร็วในการดำเนินการคือปัจจัยชี้ขาด</p>
            </div>

            <ol class="steps-list">
                <li>เปลี่ยนรหัสผ่านทันที</li>
                <li>ใช้ระบบกู้คืนรหัสผ่าน</li>
                <li>สั่งบังคับล็อกเอาต์ (Logout) อุปกรณ์ที่ไม่รู้จัก</li>
                <li>เปิดใช้งาน 2FA ทันทีหากยังไม่ได้ทำ</li>
                <li>แจ้งเตือนคนรอบข้างเพื่อป้องกันการแอบอ้าง</li>
                <li>บันทึกหลักฐานโดยการแคปหน้าจอ</li>
                <li>แจ้งความออนไลน์ที่ thaipoliceonline.go.th</li>
                <li>ติดต่อสายด่วนเพื่อระงับความเสียหาย</li>
            </ol>

            <div class="hotline-grid">
                <div class="hotline-card">
                    <strong>1441</strong>
                    <span>ตำรวจไซเบอร์ — แจ้งเหตุและระงับบัญชีธนาคาร</span>
                </div>
                <div class="hotline-card">
                    <strong>1200</strong>
                    <span>กสทช. — ร้องเรียนเบอร์โทรศัพท์และข้อความหลอกลวง</span>
                </div>
            </div>
        </section>

        <!-- ============ Closing ============ -->
        <section class="container page-content">
            <div class="callout">
                <p>ความตระหนักรู้ (Cyber Awareness) ร่วมกับระบบป้องกันเชิงรุก คืออาวุธและเกราะป้องกันที่ดีที่สุดในการก้าวเดินในโลกดิจิทัลอย่างปลอดภัย หมั่นประเมินพฤติกรรมดิจิทัลของตนเองเสมอว่ากำลังสร้าง <strong class="zone-safe">"กำแพงสีเขียว"</strong> หรือกำลังเปิดประตูทิ้งไว้ให้ภัยคุกคามจาก <strong class="zone-danger">"พื้นที่สีดำ"</strong> เข้ามาในชีวิตโดยไม่รู้ตัว</p>
            </div>
        </section>
    </main>
</body>
</html>
