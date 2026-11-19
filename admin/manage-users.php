<?php
require '../config/database.php';require '../includes/auth.php';require_role('admin');
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$id=(int)($_POST['id']??0);$active=(int)($_POST['active']??0);if($id!=$_SESSION['user']['id']){$s=$pdo->prepare("UPDATE users SET is_active=? WHERE id=? AND role='student'");$s->execute([$active,$id]);}}
$users=$pdo->query("SELECT id,name,email,student_id,is_active,created_at FROM users WHERE role='student' ORDER BY created_at DESC")->fetchAll();
$pageTitle='Manage users';$assetPrefix='../';$homePrefix='../';require '../includes/header.php';?>
<div class="dashboard-head"><div><span class="eyebrow">ADMIN TOOLS</span><h1>Student accounts</h1><p class="muted">View registered students and manage account access.</p></div></div>
<div class="table-wrap"><table><thead><tr><th>Name</th><th>Email</th><th>Student ID</th><th>Access</th></tr></thead><tbody><?php foreach($users as $u):?><tr><td><?=e($u['name'])?></td><td><?=e($u['email'])?></td><td><?=e($u['student_id']??'—')?></td><td><form method="post" class="inline-form"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="id" value="<?=(int)$u['id']?>"><input type="hidden" name="active" value="<?=$u['is_active']?0:1?>"><span class="tag"><?=$u['is_active']?'Active':'Disabled'?></span><button class="btn btn-small"><?=$u['is_active']?'Disable':'Enable'?></button></form></td></tr><?php endforeach;?></tbody></table></div>
<?php require '../includes/footer.php';?>
