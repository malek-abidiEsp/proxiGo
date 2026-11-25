
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des rôles</title>

    <style>
        body {
            font-family: Arial;
            margin: 30px;
            background: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #333;
            color: white;
        }

        a, button {
            padding: 7px 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .add {
            background: green;
            color: white;
        }

        .edit {
            background: orange;
            color: white;
        }

        .delete {
            background: red;
            color: white;
        }
    </style>
</head>

<body>

    <h2>Gestion des rôles</h2>

    <a href="../../Role.php?action=add" class="add">
        Ajouter un rôle
    </a>

    <br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom du rôle</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($roles as $role): ?>

        <tr>
            <td>
                <?= $role['id'] ?>
            </td>

            <td>
                <?= htmlspecialchars($role['name']) ?>
            </td>

            <td>
                <a class="edit"
                   href="../../Role.php?action=edit&id=<?= $role['id'] ?>">
                    Modifier
                </a>

                <form method="POST"
                      action="../../Role.php?action=delete"
                      style="display:inline"
                      onsubmit="return confirm('Supprimer ce rôle ?')">

                    <input type="hidden" name="id"
                           value="<?= $role['id'] ?>">

                    <button class="delete" type="submit">
                        Supprimer
                    </button>

                </form>
            </td>
        </tr>

        <?php endforeach; ?>

    </table>

</body>
</html>
