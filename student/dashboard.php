<?php
require '../config/database.php'; require '../includes/auth.php'; require_role('student');
$uid=$_SESSION['user']['id'];
$q=$pdo->prepare("SELECT COUNT(*) FROM items WHERE user_id=?"); $q->execute([$uid]); $mine=$q->fetchColumn();
$q=$pdo->prepare("SELECT COUNT(*) FROM claims WHERE user_id=?"); $q->execute([$uid]); $claims=$q->fetchColumn();
$recent=$pdo->query("SELECT i.*,u.name AS reporter FROM items i JOIN users u ON u.id=i.user_id WHERE i.status IN ('lost','found') ORDER BY i.created_at DESC LIMIT 4")->fetchAll();
$pageTitle='Student dashboard'; $assetPrefix='../'; $homePrefix='../'; require '../includes/header.php';
?>
<div class="dashboard-head"><div><span class="eyebrow">STUDENT SPACE</span><h1>Hello, <?= e($_SESSION['user']['name']) ?> 👋</h1><p class="muted">Here's what's happening around your campus.</p></div><a class="btn" href="report-item.php">＋ Report an item</a></div>
<div class="stats-grid"><div class="stat-card"><span class="stat-label">My reports</span><strong><?= (int)$mine ?></strong><small>Items you've submitted</small></div><div class="stat-card"><span class="stat-label">My claims</span><strong><?= (int)$claims ?></strong><small>Ownership requests</small></div><div class="stat-card"><span class="stat-label">Quick action</span><strong>⌕</strong><small><a href="browse-items.php">Browse campus items →</a></small></div></div>
<div class="content-heading"><div><h2>Recently reported</h2><p class="muted">Latest lost and found updates from students.</p></div><a class="text-link" href="browse-items.php">View all →</a></div>
<div class="item-grid"><?php foreach($recent as $item): ?><article class="item-card"><div class="item-placeholder"><?= $item['image']?'🖼️':($item['type']==='lost'?'🔎':'📦') ?></div><div class="item-info"><span class="tag <?= e($item['type']) ?>"><?= e(ucfirst($item['type'])) ?></span><h3><?= e($item['title']) ?></h3><p><?= e($item['location']) ?> · <?= e($item['category']) ?></p><a href="item-details.php?id=<?= (int)$item['id'] ?>" class="text-link">View details →</a></div></article><?php endforeach; ?></div>
<?php require '../includes/footer.php'; ?>
