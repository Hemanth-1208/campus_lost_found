<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function require_login(): void {
    if (empty($_SESSION['user'])) {
        header('Location: ../login.php');
        exit;
    }
}
function require_role(string $role): void {
    require_login();
    if (($_SESSION['user']['role'] ?? '') !== $role) {
        http_response_code(403);
        exit('Access denied.');
    }
}
function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419);
        exit('Invalid request token. Please go back and try again.');
    }
}
