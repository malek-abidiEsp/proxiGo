
<?php
ob_start();
?>

<div class="container wide" style="max-width: 1000px; margin: 55px auto; padding: 40px;">

    <div style="margin-bottom: 35px;">
        <p style="color: #40e0d0; font-weight: 600; margin-bottom: 10px;">PROXIGO ACCOUNT</p>
        <h1 style="font-size: 26px; margin-bottom: 10px;">My Profile</h1>
        <p style="color: #817e84; margin: 0;">
            Manage your personal information and password.
        </p>
    </div>

    <div style="padding: 25px; margin-bottom: 25px; background: #151326; border: 1px solid #292342; border-radius: 14px;">
        <h2 style="font-size: 20px; margin-top: 0;">
            Welcome, <?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?>!
        </h2>
        <span class="badge <?= $user->getRoleId() === 1 ? 'badge-admin' : 'badge-user' ?>">
            Role: <?= $user->getRoleId() === 1 ? 'Admin' : 'User' ?>
        </span>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert <?= $flash['type'] === 'success' ? 'alert-success' : 'alert-error' ?>">
            <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="padding: 28px; margin-bottom: 25px; background: #0b0c17; border: 1px solid #202128; border-radius: 14px;">
        <h2 style="font-size: 20px; margin-top: 0; margin-bottom: 22px;">Personal Information</h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <p style="color: #817e84; margin-bottom: 7px;">Account ID</p>
                <p style="color: #40e0d0; font-weight: 600;"><?= $user->getId() ?></p>
            </div>

            <div>
                <p style="color: #817e84; margin-bottom: 7px;">Username</p>
                <p style="color: #e5e5e5; font-weight: 600;"><?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?></p>
            </div>

            <div>
                <p style="color: #817e84; margin-bottom: 7px;">Email address</p>
                <p style="color: #e5e5e5; font-weight: 600;"><?= htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8') ?></p>
            </div>

            <div>
                <p style="color: #817e84; margin-bottom: 7px;">Member since</p>
                <p style="color: #e5e5e5; font-weight: 600;"><?= htmlspecialchars($user->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>
    </div>

    <div style="padding: 28px; margin-bottom: 25px; background: #0b0c17; border: 1px solid #202128; border-radius: 14px;">
        <h2 style="font-size: 20px; margin-top: 0;">Edit Personal Information</h2>
        <p style="color: #817e84;">Update your username and email address.</p>

        <form method="POST" action="index.php?action=profile">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   value="<?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?>"
                   required>

            <label for="email">Email address</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8') ?>"
                   required>

            <button type="submit" style="width: 100%;">Save Changes</button>
        </form>
    </div>

    <div style="padding: 28px; background: #0b0c17; border: 1px solid #202128; border-radius: 14px;">
        <h2 style="font-size: 20px; margin-top: 0;">Change Password</h2>
        <p style="color: #817e84;">Choose a new password to keep your account secure.</p>

        <form method="POST" action="index.php?action=change_password">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <label for="current_password">Current password</label>
            <input type="password" id="current_password" name="current_password"
                   autocomplete="current-password" required>

            <label for="new_password">New password</label>
            <input type="password" id="new_password" name="new_password"
                   minlength="8" autocomplete="new-password" required>

            <label for="confirm_password">Confirm new password</label>
            <input type="password" id="confirm_password" name="confirm_password"
                   minlength="8" autocomplete="new-password" required>

            <button type="submit" style="width: 100%;">Update Password</button>
        </form>
    </div>

</div>

<?php
$content = ob_get_clean();
$title = 'My Profile - ProxiGo';
require __DIR__ . '/layout.php';
