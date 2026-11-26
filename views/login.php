
<?php
ob_start();
?>
<div class="container">
    <h1>Log in</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['registered'])): ?>
        <div class="alert alert-success">Account created successfully, you can now log in.</div>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="index.php?action=login" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <label for="email">Email address</label>
        <input type="email" id="email" name="email" autocomplete="email">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password">

        <button type="submit">Log in</button>
    </form>

    <script src="assets/login-validation.js"></script>

    <div class="switch-link">
        Don't have an account yet? <a href="index.php?action=register">Sign up</a>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Log in - ProxiGo';
require __DIR__ . '/layout.php';
