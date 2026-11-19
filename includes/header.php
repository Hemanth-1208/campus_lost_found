<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = $pageTitle ?? 'CampusFind';
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?> | CampusFind</title>
  <link rel="stylesheet" href="<?= $assetPrefix ?? '' ?>assets/css/style.css">
  <script defer src="<?= $assetPrefix ?? '' ?>assets/js/script.js"></script>
</head>
<body>
<header class="topbar">
  <a class="brand" href="<?= $homePrefix ?? '' ?>index.php"><span class="brand-mark">C</span> Campus<span>Find</span></a>
  <nav>
    <a href="<?= $homePrefix ?? '' ?>index.php">Home</a>
    <?php if ($user): ?>
      <?php if ($user['role'] === 'admin'): ?>
        <a href="<?= $homePrefix ?? '' ?>admin/dashboard.php">Admin</a>
      <?php else: ?>
        <a href="<?= $homePrefix ?? '' ?>student/dashboard.php">Dashboard</a>
        <a href="<?= $homePrefix ?? '' ?>student/browse-items.php">Browse items</a>
      <?php endif; ?>
      <span class="nav-user"><?= htmlspecialchars($user['name']) ?></span>
      <a class="btn btn-small btn-outline" href="<?= $homePrefix ?? '' ?>logout.php">Logout</a>
    <?php else: ?>
      <a href="<?= $homePrefix ?? '' ?>login.php">Login</a>
      <a class="btn btn-small" href="<?= $homePrefix ?? '' ?>register.php">Get started</a>
    <?php endif; ?>
  </nav>
</header>
<main class="page-shell">
