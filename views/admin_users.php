
<?php
ob_start();
?>

<?php if (!empty($flash)): ?>
    <div class="alert <?= $flash['type'] === 'success' ? 'alert-success' : 'alert-error' ?>">
        <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div class="users-page-header">
    <div>
        <span class="users-page-tag">PROXIGO ADMIN</span>
        <h2>Manage Users</h2>
        <p>View, edit and manage all platform accounts.</p>
    </div>

    <a href="index.php?action=admin_user_create" class="btn add-user-btn">
        + Add User
    </a>
</div>

<div class="users-summary">
    <div>
        <span class="summary-label">Total Accounts</span>
        <strong><?= count($allUsers) ?></strong>
    </div>
    <div>
        <span class="summary-label">Your Account</span>
        <strong><?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?></strong>
    </div>
</div>

<div class="card users-management-card">
    <div class="card-head">
        <div>
            <h2>All Users</h2>
            <p><?= count($allUsers) ?> registered accounts</p>
        </div>
    </div>

    <div class="users-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($allUsers as $u): ?>
                <tr>
                    <td>#<?= $u->getId() ?></td>
                    <td class="user-name">
                        <?= htmlspecialchars($u->getUsername(), ENT_QUOTES, 'UTF-8') ?>
                        <?php if ($u->getId() === $user->getId()): ?>
                            <span class="you-label">You</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($u->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?php $roleName = $u->getRoleId() === 1 ? 'admin' : 'user'; ?>
                        <span class="badge <?= $roleName === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                            <?= htmlspecialchars($roleName, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($u->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="actions">
                        <a class="btn btn-sm btn-outline" href="index.php?action=admin_user_edit&id=<?= $u->getId() ?>">
                            Edit
                        </a>

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
</div>

<style>
.users-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}

.users-page-tag {
    color: #40e0d0;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
}

.users-page-header h2 {
    color: #dad4de;
    font-size: 27px;
    margin: 9px 0 6px;
}

.users-page-header p,
.card-head p {
    color: #9692a5;
    font-size: 14px;
    margin: 0;
}

.add-user-btn {
    background: #40e0d0 !important;
    color: #03010e !important;
    border: none !important;
    font-weight: 700;
    white-space: nowrap;
}

.add-user-btn:hover {
    background: #31cbbb !important;
}

.users-summary {
    display: flex;
    gap: 18px;
    margin-bottom: 25px;
}

.users-summary > div {
    flex: 1;
    background: #0b0c17;
    border: 1px solid rgba(147, 122, 255, 0.18);
    border-radius: 12px;
    padding: 18px 22px;
}

.summary-label {
    display: block;
    color: #9692a5;
    font-size: 13px;
    margin-bottom: 9px;
}

.users-summary strong {
    color: #40e0d0;
    font-size: 20px;
}

.users-management-card {
    padding: 24px;
}

.card-head {
    margin-bottom: 22px;
}

.card-head h2 {
    color: #dad4de;
    font-size: 20px;
    margin: 0 0 7px;
}

.users-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.users-table-wrapper table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

.users-table-wrapper th {
    color: #9692a5;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    text-align: left;
    padding: 15px 12px;
    border-bottom: 1px solid rgba(147, 122, 255, 0.2);
}

.users-table-wrapper td {
    color: #c5c0d0;
    font-size: 13px;
    padding: 16px 12px;
    border-bottom: 1px solid rgba(147, 122, 255, 0.1);
}

.users-table-wrapper tbody tr:hover {
    background: rgba(147, 122, 255, 0.06);
}

.user-name {
    color: #40e0d0 !important;
    font-weight: 600;
}

.you-label {
    display: inline-block;
    color: #40e0d0;
    background: rgba(64, 224, 208, 0.1);
    border-radius: 10px;
    padding: 3px 8px;
    font-size: 10px;
    margin-left: 5px;
}

.users-table-wrapper .actions {
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.users-table-wrapper .actions form {
    margin: 0;
}

.users-table-wrapper .btn-sm {
    padding: 7px 12px;
    font-size: 12px;
}

@media (max-width: 650px) {
    .users-page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .users-summary {
        flex-direction: column;
    }

    .users-management-card {
        padding: 16px;
    }
}
</style>

<script src="assets/confirm.js"></script>

<?php
$content = ob_get_clean();
$title = 'Manage Users - ProxiGo';
$activePage = 'users';
require __DIR__ . '/layout_admin.php';
