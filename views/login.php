
<?php
ob_start();
?>
<div class="container" style="max-width: 460px; margin: 75px auto; padding: 42px;">
    <div style="text-align: center; margin-bottom: 32px;">
        <h2 style="color: #40e0d0; font-size: 32px; font-weight: 700; margin-bottom: 12px;">ProxiGo</h2>
<h1 style="margin-bottom: 10px; font-size: 30px;">Welcome Back</h1>
        <p style="color: #817e84; margin: 0;">Log in to your ProxiGo account</p>
    </div>

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
        <input type="email" id="email" name="email" autocomplete="email" placeholder="Enter your email">

        <label for="password">Password</label>
<input type="password" id="password" name="password"
       autocomplete="new-password"
       placeholder="Enter your password">        <button type="submit" style="width: 100%; margin-top: 18px;">Log in</button>
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
