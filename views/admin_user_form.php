
<?php
ob_start();
$isEdit = ($mode ?? 'create') === 'edit';
?>
<div class="card form-card">
    <h2><?= $isEdit ? 'Edit user' : 'Add a new user' ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= htmlspecialchars($formAction, ENT_QUOTES, 'UTF-8') ?>" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <label for="username">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            required
            minlength="3"
            maxlength="50"
            pattern="[a-zA-Z0-9_-]{3,50}"
            value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >

        <label for="email">Email address</label>
        <input
            type="email"
            id="email"
            name="email"
            required
            maxlength="150"
            value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >

        <label for="password">
            Password <?= $isEdit ? '(leave empty to keep the current one)' : '(min. 8 characters)' ?>
        </label>
        <input
            type="password"
            id="password"
            name="password"
            minlength="8"
            autocomplete="new-password"
            <?= $isEdit ? '' : 'required' ?>
        >

        <label for="role_id">Role</label>
        <select id="role_id" name="role_id" required>
            <option value="2" <?= (string)($old['role_id'] ?? '2') === '2' ? 'selected' : '' ?>>user</option>
            <option value="1" <?= (string)($old['role_id'] ?? '2') === '1' ? 'selected' : '' ?>>admin</option>
        </select>

        <div class="form-actions">
            <button type="submit" class="btn"><?= $isEdit ? 'Save changes' : 'Create user' ?></button>
            <a href="index.php?action=admin_users" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
<?php
$content = ob_get_clean();
$title = $isEdit ? 'Edit user' : 'Add user';
$activePage = 'users';
require __DIR__ . '/layout_admin.php';
