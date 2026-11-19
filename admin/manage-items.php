<?php
require '../config/database.php';require '../includes/auth.php';require_role('admin');
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$id=(int)($_POST['id']??0);$status=$_POST['status']??'';if(in_array($status,['lost','found','returned','closed'],true)){$s=$pdo->prepare('UPDATE items SET status=? WHERE id=?');$s->execute([$status,$id]);}}
$items=$pdo->query('SELECT i.*,u.name AS reporter FROM items i JOIN users u ON u.id=i.user_id ORDER BY i.created_at DESC')->fetchAll();
$pageTitle='Manage items';$assetPrefix='../';$homePrefix='../';require '../includes/header.php';?>
<div class="dashboard-head"><div><span class="eyebrow">ADMIN TOOLS</span><h1>Manage reports</h1><p class="muted">Review listings and update their status.</p></div></div>
<div class="table-wrap"><table><thead><tr><th>Item</th><th>Reporter</th><th>Type</th><th>Location</th><th>Update status</th></tr></thead><tbody><?php foreach($items as $i):?><tr><td><?=e($i['title'])?></td><td><?=e($i['reporter'])?></td><td><?=e(ucfirst($i['type']))?></td><td><?=e($i['location'])?></td><td><form method="post" class="inline-form"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="id" value="<?=(int)$i['id']?>"><select name="status"><?php foreach(['lost','found','returned','closed'] as $st):?><option value="<?=$st?>" <?=$i['status']===$st?'selected':''?>><?=ucfirst($st)?></option><?php endforeach;?></select><button class="btn btn-small">Save</button></form></td></tr><?php endforeach;?></tbody></table></div>
<?php require '../includes/footer.php';?>
