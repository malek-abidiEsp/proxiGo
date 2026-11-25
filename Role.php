
<?php

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/RoleController.php';

// Connexion à la base de données
$db = Database::getConnexion();

// Création du controller
$roleController = new RoleController($db);

// Action demandée
$action = $_GET['action'] ?? 'index';

// Afficher les rôles
if ($action == 'index') {

    $roles = $roleController->index();
    require __DIR__ . '/views/roles/index.php';

}

// Afficher formulaire d'ajout
elseif ($action == 'add') {

    require __DIR__ . '/views/roles/create.php';

}

// Enregistrer un nouveau rôle
elseif ($action == 'save') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = trim($_POST['name'] ?? '');

        if ($name != '') {
            $roleController->add($name);
        }
    }

    header('Location: Role.php');
    exit;
}

// Afficher formulaire de modification
elseif ($action == 'edit') {

    $id = (int) ($_GET['id'] ?? 0);
    $roles = $roleController->index();
    $role = null;

    foreach ($roles as $r) {
        if ($r['id'] == $id) {
            $role = $r;
            break;
        }
    }

    if ($role != null) {
        require __DIR__ . '/views/roles/edit.php';
    } else {
        header('Location: Role.php');
        exit;
    }
}

// Enregistrer les modifications
elseif ($action == 'update') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if ($id > 0 && $name != '') {
            $roleController->update($id, $name);
        }
    }

    header('Location: Role.php');
    exit;
}

// Supprimer un rôle
elseif ($action == 'delete') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $roleController->delete($id);
        }
    }

    header('Location: Role.php');
    exit;
}

// Action inconnue
else {
    echo "Action introuvable";
}

?>
