<?php
/**
 * views/admin_users.php
 * Expects: $user, $allUsers (UserModel[]), $csrfToken, $flash (?array)
 */
ob_start();
?>
<?php if (!empty($flash)): ?>
    <div class="alert <?= $flash['type'] === 'success' ? 'alert-success' : 'alert-error' ?>">
        <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-head">
        <h2>All users (<?= count($allUsers) ?>)</h2>
        <a href="index.php?action=admin_user_create" class="btn">+ Add user</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($allUsers as $u): /** @var UserModel $u */ ?>
            <tr>
                <td><?= $u->getId() ?></td>
                <td><?= htmlspecialchars($u->getUsername(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($u->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <span class="badge <?= $u->getRole() === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                        <?= htmlspecialchars($u->getRole(), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($u->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?></td>
                <td class="actions">
                    <a class="btn btn-sm btn-outline" href="index.php?action=admin_user_edit&id=<?= $u->getId() ?>">Edit</a>
                    <?php if ($u->getId() !== $user->getId()): ?>
                        <form method="POST" action="index.php?action=admin_user_delete" class="inline"
                              data-confirm="Delete this user permanently?">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="id" value="<?= $u->getId() ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="assets/confirm.js"></script>
<?php
$content = ob_get_clean();
$title = 'Users';
$activePage = 'users';
require __DIR__ . '/layout_admin.php';
