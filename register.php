<?php
require 'config/database.php';
require 'includes/auth.php';
if (!empty($_SESSION['user'])) { header('Location: '.($_SESSION['user']['role']==='admin'?'admin/dashboard.php':'student/dashboard.php')); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $studentId = trim($_POST['student_id'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Enter your name, a valid email and a password with at least 8 characters.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name,email,student_id,password,role) VALUES (?,?,?,?, 'student')");
            $stmt->execute([$name,$email,$studentId ?: null,password_hash($password,PASSWORD_DEFAULT)]);
            header('Location: login.php?registered=1'); exit;
        } catch (PDOException $e) { $error = 'That email is already registered.'; }
    }
}
$pageTitle='Create account'; require 'includes/header.php';
?>
<section class="auth-wrap"><div class="auth-aside"><span class="eyebrow">WELCOME TO CAMPUSFIND</span><h1>Your campus.<br>Your community.<br><span>Found together.</span></h1><p>Create your student account to report items and reconnect with lost belongings.</p><div class="auth-mini">🔒 Your account is protected with secure password hashing.</div></div>
<div class="auth-card"><h2>Create account</h2><p class="muted">Join your campus lost &amp; found community.</p>
<?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="form-stack">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Full name<input name="name" required placeholder="Your full name" value="<?= e($_POST['name']??'') ?>"></label>
<label>College email<input type="email" name="email" required placeholder="you@college.edu" value="<?= e($_POST['email']??'') ?>"></label>
<label>Student ID <span class="optional">(optional)</span><input name="student_id" placeholder="e.g. 2025CSE0082"></label>
<label>Password<input type="password" name="password" minlength="8" required placeholder="At least 8 characters"></label>
<button class="btn btn-full">Create account →</button>
</form><p class="auth-switch">Already registered? <a href="login.php">Sign in</a></p></div></section>
<?php require 'includes/footer.php'; ?>
