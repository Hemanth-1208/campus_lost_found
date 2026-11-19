<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    if (in_array($status, ['approved', 'rejected', 'pending'], true)) {
        $stmt = $pdo->prepare('UPDATE claims SET status=? WHERE id=?');
        $stmt->execute([$status, $id]);
        if ($status === 'approved') {
            $stmt = $pdo->prepare("UPDATE items SET status='returned' WHERE id=(SELECT item_id FROM claims WHERE id=?)");
            $stmt->execute([$id]);
        }
    }
}

$claims = $pdo->query(
    'SELECT c.*, i.title, u.name AS claimant, u.email
     FROM claims c
     JOIN items i ON i.id=c.item_id
     JOIN users u ON u.id=c.user_id
     ORDER BY c.created_at DESC'
)->fetchAll();

$pageTitle = 'Manage claims';
$assetPrefix = '../';
$homePrefix = '../';
require '../includes/header.php';
?>
<div class="dashboard-head">
    <div>
        <span class="eyebrow">ADMIN TOOLS</span>
        <h1>Ownership claims</h1>
        <p class="muted">Review the claimant details and owner-only description before making a decision.</p>
    </div>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Claimant account</th>
                <th>Name</th>
                <th>Class / Section</th>
                <th>Handover location</th>
                <th>Owner description</th>
                <th>Decision</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($claims as $claim): ?>
            <tr>
                <td><?= e($claim['title']) ?></td>
                <td><?= e($claim['claimant']) ?><br><small><?= e($claim['email']) ?></small></td>
                <td><?= e($claim['claimant_name'] ?? '') ?></td>
                <td><?= e($claim['class_section'] ?? '') ?></td>
                <td><?= e($claim['handover_location'] ?? '') ?></td>
                <td><?= e($claim['message']) ?></td>
                <td>
                    <form method="post" class="inline-form">
                        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                        <input type="hidden" name="id" value="<?= (int)$claim['id'] ?>">
                        <select name="status">
                            <?php foreach (['pending', 'approved', 'rejected'] as $status): ?>
                                <option value="<?= $status ?>" <?= $claim['status'] === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-small">Save</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (!$claims): ?>
        <div class="empty-state">No claims have been submitted.</div>
    <?php endif; ?>
</div>
<?php require '../includes/footer.php'; ?>
