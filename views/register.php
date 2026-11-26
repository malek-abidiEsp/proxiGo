
<?php
ob_start();
$old = $old ?? [];
?>
<div class="container">
    <h1>Create an account</h1>

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
               value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <label for="email">Email address</label>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <label for="password">Password (min. 8 characters)</label>
        <input type="password" id="password" name="password" autocomplete="new-password">

        <label for="password_confirm">Confirm password</label>
        <input type="password" id="password_confirm" name="password_confirm"
               autocomplete="new-password">

        <button type="submit">Create my account</button>
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
