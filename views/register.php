
<?php
ob_start();
$old = $old ?? [];
?>
<div class="container" style="max-width: 460px; margin: 55px auto; padding: 42px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: #40e0d0; font-size: 32px; font-weight: 700; margin-bottom: 12px;">ProxiGo</h2>
        <h1 style="margin-bottom: 10px; font-size: 28px;">Create Your Account</h1>
        <p style="color: #817e84; margin: 0;">Join ProxiGo and get started today</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form id="registerForm" method="POST" action="index.php?action=register" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <label for="username">Username</label>
        <input type="text" id="username" name="username"
               value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
               placeholder="Choose a username" autocomplete="username">

        <label for="email">Email address</label>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
               placeholder="Enter your email" autocomplete="email">

        <label for="password">Password (min. 8 characters)</label>
        <input type="password" id="password" name="password"
               autocomplete="new-password" placeholder="Create a password">

        <label for="password_confirm">Confirm password</label>
        <input type="password" id="password_confirm" name="password_confirm"
               autocomplete="new-password" placeholder="Confirm your password">

        <button type="submit" style="width: 100%; margin-top: 18px;">Create my account</button>
    </form>

    <script src="assets/register-validation.js"></script>

    <div class="switch-link">
        Already have an account? <a href="index.php?action=login">Log in</a>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Sign up - ProxiGo';
require __DIR__ . '/layout.php';
