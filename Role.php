
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/RoleController.php';

AuthController::requireRole('admin');

$db = Database::getConnexion();
$authController = new AuthController();

$user = $authController->findById((int) $_SESSION['user_id']);

if ($user === null) {
    session_destroy();
    header('Location: index.php?action=login');
    exit;
}

$roleController = new RoleController($db);
$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $roles = $roleController->index();
    $flash = $_SESSION['role_flash'] ?? null;
    unset($_SESSION['role_flash']);
    require __DIR__ . '/views/role/index.php';

} elseif ($action === 'add') {
    $csrfToken = $authController->getCsrfToken();
    require __DIR__ . '/views/role/create.php';

} elseif ($action === 'save') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed');
    }

    if (!$authController->verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid security token.');
    }

    $name = trim($_POST['name'] ?? '');
    $success = $roleController->add($name);

    $_SESSION['role_flash'] = [
        'type' => $success ? 'success' : 'error',
        'message' => $success ? 'Role added successfully.' : 'Unable to add role. Check the name or verify that it does not already exist.'
    ];

    header('Location: Role.php');
    exit;

} elseif ($action === 'edit') {
    $id = (int) ($_GET['id'] ?? 0);
    $roles = $roleController->index();
    $role = null;

    foreach ($roles as $r) {
        if ((int) $r['id'] === $id) {
            $role = $r;
            break;
        }
    }

    if ($role !== null) {
        $csrfToken = $authController->getCsrfToken();
        require __DIR__ . '/views/role/edit.php';
    } else {
        header('Location: Role.php');
        exit;
    }

} elseif ($action === 'update') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed');
    }

    if (!$authController->verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid security token.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $success = $roleController->update($id, $name);

    $_SESSION['role_flash'] = [
        'type' => $success ? 'success' : 'error',
        'message' => $success ? 'Role updated successfully.' : 'Unable to update role. Check the name or verify that it does not already exist.'
    ];

    header('Location: Role.php');
    exit;

} elseif ($action === 'delete') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed');
    }

    if (!$authController->verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid security token.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $success = $roleController->delete($id);

    $_SESSION['role_flash'] = [
        'type' => $success ? 'success' : 'error',
        'message' => $success ? 'Role deleted successfully.' : 'Unable to delete this role. It may be protected or assigned to users.'
    ];

    header('Location: Role.php');
    exit;

} else {
    http_response_code(404);
    exit('Action introuvable');
}
