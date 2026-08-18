<?php
/**
 * Core bootstrap: session handling, database connection, and auth helpers.
 * Every page in the portal starts with `require __DIR__ . '/includes/db.php';`
 * so session state is always available and consistent across the whole site.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        // Keep the session alive while the person works through the lessons/quiz.
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}

const DB_HOST = 'localhost';
const DB_NAME = 'cyber_portal';
const DB_USER = 'root';
const DB_PASS = '';
const DB_CHARSET = 'utf8mb4';

/**
 * Returns a shared PDO connection for the request.
 */
function getConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    return $pdo;
}

/**
 * Returns the logged-in user's session data, or null when logged out.
 */
function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

/**
 * Sends a Location redirect and stops execution.
 */
function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

/**
 * Sends the person to login.php if no session exists yet.
 */
function requireLogin(): array
{
    $user = currentUser();

    if (!$user) {
        redirect('login.php');
    }

    return $user;
}

/**
 * Guards admin-only pages. Students are bounced to their dashboard.
 */
function requireAdmin(): array
{
    $user = requireLogin();

    if (($user['role'] ?? '') !== 'admin') {
        redirect('dashboard.php');
    }

    return $user;
}

/**
 * Guards student-only pages. The admin account is bounced to admin.php.
 */
function requireStudent(): array
{
    $user = requireLogin();

    if (($user['role'] ?? '') !== 'student') {
        redirect('admin.php');
    }

    return $user;
}
