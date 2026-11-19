<?php
require '../config/database.php';require '../includes/auth.php';require_role('student');
$s=$pdo->prepare('SELECT * FROM items WHERE user_id=? ORDER BY created_at DESC');$s->execute([$_SESSION['user']['id']]);$items=$s->fetchAll();
$pageTitle='My reports';$assetPrefix='../';$homePrefix='../';require '../includes/header.php';?>
<div class="dashboard-head"><div><span class="eyebrow">YOUR ACTIVITY</span><h1>My reports</h1><p class="muted">All items you've reported.</p></div><a class="btn" href="report-item.php">＋ New report</a></div>
<?php if(isset($_GET['submitted'])):?><div class="success">Your report was submitted successfully.</div><?php endif;?>
<div class="table-wrap"><table><thead><tr><th>Item</th><th>Type</th><th>Location</th><th>Status</th><th>Date</th></tr></thead><tbody><?php foreach($items as $i):?><tr><td><?=e($i['title'])?></td><td><?=e(ucfirst($i['type']))?></td><td><?=e($i['location'])?></td><td><span class="tag"><?=e(ucfirst($i['status']))?></span></td><td><?=e($i['item_date'])?></td></tr><?php endforeach;?></tbody></table><?php if(!$items):?><div class="empty-state">You haven't reported any items yet.</div><?php endif;?></div>
<?php require '../includes/footer.php';?>
