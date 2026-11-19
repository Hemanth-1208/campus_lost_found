<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('student');

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT i.*, u.name AS reporter FROM items i JOIN users u ON u.id=i.user_id WHERE i.id=?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    http_response_code(404);
    exit('Item not found.');
}

$error = '';
$name = trim($_POST['claimant_name'] ?? $_SESSION['user']['name'] ?? '');
$classSection = trim($_POST['class_section'] ?? '');
$handoverLocation = trim($_POST['handover_location'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    if ((int)$item['user_id'] === (int)$_SESSION['user']['id']) {
        $error = 'You cannot claim your own report.';
    } elseif ($name === '' || $classSection === '' || $handoverLocation === '' || $message === '') {
        $error = 'Please complete all fields before submitting.';
    } elseif (mb_strlen($name) > 100 || mb_strlen($classSection) > 60 || mb_strlen($handoverLocation) > 150 || mb_strlen($message) > 2000) {
        $error = 'One or more fields are too long. Please shorten your response.';
    } else {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO claims (item_id, user_id, claimant_name, class_section, handover_location, message) VALUES (?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([$id, $_SESSION['user']['id'], $name, $classSection, $handoverLocation, $message]);
            header('Location: my-claims.php?submitted=1');
            exit;
        } catch (PDOException $e) {
            // A duplicate claim is the expected failure when a student has already claimed this item.
            $error = 'You have already submitted a claim for this item.';
        }
    }
}

$pageTitle = 'Item details';
$assetPrefix = '../';
$homePrefix = '../';
require '../includes/header.php';
?>
<div class="detail-layout">
    <section class="panel">
        <span class="tag <?= e($item['type']) ?>"><?= e(ucfirst($item['type'])) ?></span>
        <h1><?= e($item['title']) ?></h1>
        <?php if ($item['image']): ?>
            <img class="detail-image" src="../uploads/<?= e($item['image']) ?>" alt="Item photo">
        <?php else: ?>
            <div class="detail-placeholder">📦</div>
        <?php endif; ?>
        <h3>Description</h3>
        <p><?= nl2br(e($item['description'])) ?></p>
        <div class="detail-meta">
            <span>📍 <?= e($item['location']) ?></span>
            <span>📅 <?= e($item['item_date']) ?></span>
            <span>Category: <?= e($item['category']) ?></span>
        </div>
    </section>

    <aside class="panel claim-panel">
        <h2>Claim this item</h2>
        <p class="muted">Fill in your details so the person who reported the item and the admin can verify the claim and arrange the handover.</p>

        <?php if ($error): ?>
            <div class="alert"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" class="form-stack">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

            <label>
                Your name
                <input type="text" name="claimant_name" maxlength="100" required
                       value="<?= e($name) ?>" placeholder="Enter your full name">
            </label>

            <label>
                Class / Section
                <input type="text" name="class_section" maxlength="60" required
                       value="<?= e($classSection) ?>" placeholder="e.g. 3CSE01">
            </label>

            <label>
                Where can the item be handed over?
                <input type="text" name="handover_location" maxlength="150" required
                       value="<?= e($handoverLocation) ?>" placeholder="e.g. Main block reception">
            </label>

            <label>
                Describe the item (owner verification)
                <textarea name="message" rows="5" maxlength="2000" required
                          placeholder="Describe unique marks, contents, colour, or other details only the owner would know..."><?= e($message) ?></textarea>
            </label>

            <button class="btn btn-full" type="submit">Submit claim</button>
        </form>
        <p class="tiny muted">Reported by <?= e($item['reporter']) ?></p>
    </aside>
</div>
<?php require '../includes/footer.php'; ?>
