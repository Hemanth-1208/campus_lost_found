<?php
require '../config/database.php';require '../includes/auth.php';require_role('admin');
$users=(int)$pdo->query('SELECT COUNT(*) FROM users WHERE role="student"')->fetchColumn();
$items=(int)$pdo->query('SELECT COUNT(*) FROM items')->fetchColumn();
$claims=(int)$pdo->query('SELECT COUNT(*) FROM claims WHERE status="pending"')->fetchColumn();
$reports=$pdo->query('SELECT i.*,u.name AS reporter FROM items i JOIN users u ON u.id=i.user_id ORDER BY i.created_at DESC LIMIT 8')->fetchAll();
$pageTitle='Admin dashboard';$assetPrefix='../';$homePrefix='../';require '../includes/header.php';?>
<div class="dashboard-head"><div><span class="eyebrow">ADMINISTRATION</span><h1>Campus overview</h1><p class="muted">Manage reports and help belongings get returned.</p></div></div>
<div class="stats-grid"><div class="stat-card"><span class="stat-label">Students</span><strong><?=$users?></strong><small>Registered accounts</small></div><div class="stat-card"><span class="stat-label">Total reports</span><strong><?=$items?></strong><small>Lost and found listings</small></div><div class="stat-card"><span class="stat-label">Pending claims</span><strong><?=$claims?></strong><small>Awaiting review</small></div></div>
<div class="admin-links"><a class="admin-link" href="manage-items.php">📦 Manage item reports <span>→</span></a><a class="admin-link" href="manage-claims.php">🛡️ Review claims <span>→</span></a><a class="admin-link" href="manage-users.php">👥 Manage students <span>→</span></a></div>
<div class="content-heading"><h2>Latest reports</h2><a class="text-link" href="manage-items.php">Manage all →</a></div>
<div class="table-wrap"><table><thead><tr><th>Item</th><th>Reporter</th><th>Type</th><th>Status</th></tr></thead><tbody><?php foreach($reports as $r):?><tr><td><?=e($r['title'])?></td><td><?=e($r['reporter'])?></td><td><?=e(ucfirst($r['type']))?></td><td><?=e(ucfirst($r['status']))?></td></tr><?php endforeach;?></tbody></table></div>
<?php require '../includes/footer.php';?>
