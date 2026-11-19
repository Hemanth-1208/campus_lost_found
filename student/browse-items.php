<?php
require '../config/database.php'; require '../includes/auth.php'; require_role('student');
$search=trim($_GET['q']??'');$type=$_GET['type']??'all';
$sql="SELECT i.*,u.name AS reporter FROM items i JOIN users u ON u.id=i.user_id WHERE i.status IN ('lost','found')";$args=[];
if($type==='lost'||$type==='found'){$sql.=" AND i.type=?";$args[]=$type;}
if($search!==''){$sql.=" AND (i.title LIKE ? OR i.description LIKE ? OR i.location LIKE ? OR i.category LIKE ?)";$like='%'.$search.'%';array_push($args,$like,$like,$like,$like);}
$sql.=" ORDER BY i.created_at DESC";$s=$pdo->prepare($sql);$s->execute($args);$items=$s->fetchAll();
$pageTitle='Browse items';$assetPrefix='../';$homePrefix='../';require '../includes/header.php';
?>
<div class="dashboard-head"><div><span class="eyebrow">CAMPUS DIRECTORY</span><h1>Browse items</h1><p class="muted">Search reports shared by your campus community.</p></div><a class="btn" href="report-item.php">＋ Report item</a></div>
<form class="search-bar" method="get"><input name="q" value="<?= e($search) ?>" placeholder="Search item, category or location..."><select name="type"><option value="all">All reports</option><option value="lost" <?= $type==='lost'?'selected':'' ?>>Lost items</option><option value="found" <?= $type==='found'?'selected':'' ?>>Found items</option></select><button class="btn">Search</button></form>
<p class="muted"><?= count($items) ?> result(s)</p>
<div class="item-grid"><?php foreach($items as $item): ?><article class="item-card"><?php if($item['image']): ?><img class="item-photo" src="../uploads/<?= e($item['image']) ?>" alt="Item photo"><?php else: ?><div class="item-placeholder"><?= $item['type']==='lost'?'🔎':'📦' ?></div><?php endif; ?><div class="item-info"><span class="tag <?= e($item['type']) ?>"><?= e(ucfirst($item['type'])) ?></span><h3><?= e($item['title']) ?></h3><p><?= e($item['category']) ?> · <?= e($item['location']) ?></p><a class="text-link" href="item-details.php?id=<?= (int)$item['id'] ?>">View details →</a></div></article><?php endforeach; ?></div>
<?php if(!$items): ?><div class="empty-state">No matching items found. Try another search.</div><?php endif; ?>
<?php require '../includes/footer.php'; ?>
