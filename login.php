<?php
require 'config/database.php'; require 'includes/auth.php';
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $email=strtolower(trim($_POST['email']??'')); $password=$_POST['password']??'';
    $stmt=$pdo->prepare('SELECT id,name,email,password,role FROM users WHERE email=? AND is_active=1');
    $stmt->execute([$email]); $u=$stmt->fetch();
    if ($u && password_verify($password,$u['password'])) {
        session_regenerate_id(true);
        unset($u['password']); $_SESSION['user']=$u;
        header('Location: '.($u['role']==='admin'?'admin/dashboard.php':'student/dashboard.php')); exit;
    } else $error='Incorrect email or password.';
}
$pageTitle='Sign in'; require 'includes/header.php';
?>
<section class="auth-wrap"><div class="auth-aside"><span class="eyebrow">GOOD TO SEE YOU</span><h1>Welcome back<br>to <span>CampusFind.</span></h1><p>Sign in to check your reports, discover found items and follow your claims.</p><div class="auth-mini">✨ Helping campus belongings find their way home.</div></div>
<div class="auth-card"><h2>Sign in</h2><p class="muted">Enter your account details to continue.</p>
<?php if(isset($_GET['registered'])): ?><div class="success">Account created. You can sign in now.</div><?php endif; ?>
<?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="form-stack"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Email address<input type="email" name="email" required placeholder="you@college.edu"></label>
<label>Password<input type="password" name="password" required placeholder="Your password"></label>
<button class="btn btn-full">Sign in →</button></form>
<p class="auth-switch">New to CampusFind? <a href="register.php">Create an account</a></p>
<p class="tiny muted">Administrator accounts are created directly in the database.</p></div></section>
<?php require 'includes/footer.php'; ?>
