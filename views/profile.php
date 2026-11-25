
<?php
/**
 * views/profile.php
 * Expects: $user, $csrfToken, $errors
 */

ob_start();
?>

<div class="container wide">

    <h1>Mon Profil</h1>

    <p>Welcome, <?= htmlspecialchars(
        $user->getUsername(),
        ENT_QUOTES,
        'UTF-8'
    ) ?> 👋</p>

    <p>
        <span class="badge <?= $user->getRoleId() === 1 ? 'badge-admin' : 'badge-user' ?>">
            Role: <?= $user->getRoleId() === 1 ? 'Admin' : 'User' ?>
        </span>
    </p>
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

    <h2>Informations personnelles</h2>

    <table>
        <tr>
            <th>ID</th>
            <td><?= $user->getId() ?></td>
        </tr>

        <tr>
            <th>Username</th>
            <td><?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>

        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>

        <tr>
            <th>Date de création</th>
            <td><?= htmlspecialchars($user->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
    </table>

    <h2 style="margin-top:30px;">Modifier mes informations</h2>

    <form method="POST" action="index.php?action=profile">
        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <label>Username</label>
        <input type="text" name="username"
               value="<?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?>"
               required>

        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8') ?>"
               required>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <h2 style="margin-top:30px;">Changer mon mot de passe</h2>

    <form method="POST" action="index.php?action=change_password">
        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <label>Mot de passe actuel</label>
        <input type="password" name="current_password" required>

        <label>Nouveau mot de passe</label>
        <input type="password" name="new_password" minlength="8" required>

        <label>Confirmer le nouveau mot de passe</label>
        <input type="password" name="confirm_password" minlength="8" required>

        <button type="submit">Changer le mot de passe</button>
    </form>

</div>

<?php
$content = ob_get_clean();
$title = 'Mon Profil - ProxiGo';

require __DIR__ . '/layout.php';
