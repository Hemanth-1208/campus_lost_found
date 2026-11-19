<?php
require '../config/database.php';require '../includes/auth.php';require_role('student');
$s=$pdo->prepare('SELECT c.*,i.title,i.type FROM claims c JOIN items i ON i.id=c.item_id WHERE c.user_id=? ORDER BY c.created_at DESC');$s->execute([$_SESSION['user']['id']]);$claims=$s->fetchAll();
$pageTitle='My claims';$assetPrefix='../';$homePrefix='../';require '../includes/header.php';?>
<div class="dashboard-head"><div><span class="eyebrow">YOUR ACTIVITY</span><h1>My claims</h1><p class="muted">Track the status of your ownership requests.</p></div></div>
<div class="table-wrap"><table><thead><tr><th>Item</th><th>Report type</th><th>Name</th><th>Class / Section</th><th>Handover location</th><th>Owner description</th><th>Claim status</th></tr></thead><tbody><?php foreach($claims as $c):?><tr><td><?=e($c['title'])?></td><td><?=e(ucfirst($c['type']))?></td><td><?=e($c['claimant_name'] ?? '')?></td><td><?=e($c['class_section'] ?? '')?></td><td><?=e($c['handover_location'] ?? '')?></td><td><?=e($c['message'])?></td><td><span class="tag"><?=e(ucfirst($c['status']))?></span></td></tr><?php endforeach;?></tbody></table><?php if(!$claims):?><div class="empty-state">You haven't submitted any claims yet.</div><?php endif;?></div>
<?php require '../includes/footer.php';?>
