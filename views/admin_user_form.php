
<?php
ob_start();
$isEdit = ($mode ?? 'create') === 'edit';
?>

<div class="admin-form-header">
    <span class="form-tag">PROXIGO ADMIN</span>
    <h2><?= $isEdit ? 'Edit User' : 'Create New User' ?></h2>
    <p><?= $isEdit ? 'Update account information and permissions.' : 'Add a new member to your ProxiGo platform.' ?></p>
</div>

<div class="card form-card admin-user-form-card">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= htmlspecialchars($formAction, ENT_QUOTES, 'UTF-8') ?>" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-section-title">Account Information</div>

        <div class="admin-field">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                required
                minlength="3"
                maxlength="50"
                pattern="[a-zA-Z0-9_-]{3,50}"
                placeholder="Enter username"
                value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >
            <small>3–50 characters. Letters, numbers, _ and - only.</small>
        </div>

        <div class="admin-field">
            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                maxlength="150"
                placeholder="example@email.com"
                value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >
        </div>

        <div class="admin-field">
            <label for="password">
                Password
            </label>
            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                autocomplete="new-password"
                placeholder="<?= $isEdit ? 'Leave empty to keep current password' : 'Enter password' ?>"
                <?= $isEdit ? '' : 'required' ?>
            >
            <small><?= $isEdit ? 'Leave empty if you do not want to change the password.' : 'Minimum 8 characters.' ?></small>
        </div>

        <div class="form-section-title role-section-title">Account Permissions</div>

        <div class="admin-field">
            <label for="role_id">User Role</label>
            <select id="role_id" name="role_id" required>
                <option value="2" <?= (string)($old['role_id'] ?? '2') === '2' ? 'selected' : '' ?>>Regular User</option>
                <option value="1" <?= (string)($old['role_id'] ?? '2') === '1' ? 'selected' : '' ?>>Administrator</option>
            </select>
            <small>Choose the access level for this account.</small>
        </div>

        <div class="form-actions admin-form-actions">
            <button type="submit" class="btn">
                <?= $isEdit ? 'Save Changes' : 'Create User' ?>
            </button>
            <a href="index.php?action=admin_users" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<style>
.admin-form-header {
    margin-bottom: 25px;
}

.form-tag {
    color: #40e0d0;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
}

.admin-form-header h2 {
    color: #dad4de;
    font-size: 26px;
    margin: 9px 0 6px;
}

.admin-form-header p {
    color: #9692a5;
    font-size: 14px;
    margin: 0;
}

.admin-user-form-card {
    max-width: 750px;
    padding: 30px;
    background: #0b0c17;
    border: 1px solid rgba(147, 122, 255, 0.16);
    border-radius: 14px;
}

.form-section-title {
    color: #40e0d0;
    font-size: 14px;
    font-weight: 700;
    padding-bottom: 13px;
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(147, 122, 255, 0.2);
}

.role-section-title {
    margin-top: 30px;
}

.admin-field {
    margin-bottom: 22px;
}

.admin-field label {
    display: block;
    color: #dad4de;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 9px;
}

.admin-field input,
.admin-field select {
    width: 100%;
    box-sizing: border-box;
    min-height: 46px;
    padding: 12px 14px;
    color: #dad4de;
    background: #03010e;
    border: 1px solid rgba(147, 122, 255, 0.25);
    border-radius: 8px;
    outline: none;
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.admin-field input:focus,
.admin-field select:focus {
    border-color: #40e0d0;
    box-shadow: 0 0 0 3px rgba(64, 224, 208, 0.08);
}

.admin-field input::placeholder {
    color: #777487;
}

.admin-field select option {
    color: #dad4de;
    background: #0b0c17;
}

.admin-field small {
    display: block;
    color: #858195;
    font-size: 11px;
    margin-top: 7px;
}

.admin-form-actions {
    display: flex;
    gap: 12px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.admin-form-actions .btn {
    min-width: 130px;
    text-align: center;
}

.admin-form-actions button.btn {
    background: #40e0d0;
    color: #03010e;
    border: none;
    font-weight: 700;
    cursor: pointer;
}

.admin-form-actions button.btn:hover {
    background: #31cbbb;
}

@media (max-width: 600px) {
    .admin-user-form-card {
        padding: 20px;
    }

    .admin-form-actions {
        flex-direction: column;
    }

    .admin-form-actions .btn {
        width: 100%;
    }
}
</style>

<?php
$content = ob_get_clean();
$title = $isEdit ? 'Edit User - ProxiGo' : 'Add User - ProxiGo';
$activePage = 'users';
require __DIR__ . '/layout_admin.php';
