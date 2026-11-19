<?php
require '../config/database.php'; require '../includes/auth.php'; require_role('student');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $title=trim($_POST['title']??''); $type=$_POST['type']??''; $category=$_POST['category']??''; $description=trim($_POST['description']??''); $location=trim($_POST['location']??''); $date=$_POST['item_date']??'';
 if($title===''||!in_array($type,['lost','found'],true)||$description===''||$location===''||!$date) $error='Please complete all required fields.';
 else {
  $image=null;
  if(!empty($_FILES['image']['name'])){
   $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp']; $mime=mime_content_type($_FILES['image']['tmp_name']);
   if(!isset($allowed[$mime])||$_FILES['image']['size']>3*1024*1024) $error='Upload a JPG, PNG or WEBP image under 3 MB.';
   else { $dir=__DIR__.'/../uploads'; if(!is_dir($dir)) mkdir($dir,0755,true); $image=bin2hex(random_bytes(16)).'.'.$allowed[$mime]; move_uploaded_file($_FILES['image']['tmp_name'],$dir.'/'.$image); }
  }
  if(!$error){$s=$pdo->prepare('INSERT INTO items(user_id,type,title,category,description,location,item_date,image,status) VALUES(?,?,?,?,?,?,?,?,?)');$s->execute([$_SESSION['user']['id'],$type,$title,$category,$description,$location,$date,$image,$type]);header('Location: my-reports.php?submitted=1');exit;}
 }
}
$pageTitle='Report an item';$assetPrefix='../';$homePrefix='../';require '../includes/header.php';
?>
<div class="form-page"><span class="eyebrow">MAKE A REPORT</span><h1>Tell us about the item</h1><p class="muted">Add clear details so the right person can find it.</p>
<?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data" class="panel form-stack"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<div class="form-row"><label>Report type<select name="type" required><option value="lost">I lost an item</option><option value="found">I found an item</option></select></label><label>Category<select name="category" required><option>Electronics</option><option>Identity cards</option><option>Books & stationery</option><option>Clothing</option><option>Accessories</option><option>Other</option></select></label></div>
<label>Item name<input name="title" required maxlength="120" placeholder="e.g. Black wireless headphones"></label>
<label>Description<textarea name="description" required rows="4" placeholder="Describe colour, brand, unique marks or other identifying details..."></textarea></label>
<div class="form-row"><label>Campus location<input name="location" required placeholder="e.g. Library, Block A"></label><label>Date lost / found<input type="date" name="item_date" required max="<?= date('Y-m-d') ?>"></label></div>
<label>Item photo <span class="optional">(optional · JPG, PNG or WEBP · max 3 MB)</span><input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label>
<button class="btn">Submit report →</button></form></div>
<?php require '../includes/footer.php'; ?>
