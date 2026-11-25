
<h2>Modifier un rôle</h2>

<form method="POST" action="roles.php?action=update">

    <input type="hidden" name="id"
           value="<?= $role['id'] ?>">

    <input type="text" name="name"
           value="<?= htmlspecialchars($role['name']) ?>"
           required>

    <button type="submit">Modifier</button>
</form>
