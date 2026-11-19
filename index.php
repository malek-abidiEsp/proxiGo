<?php
declare(strict_types=1);

// 1. Secure session configuration
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
// ini_set('session.cookie_secure', '1'); // uncomment if HTTPS
session_start();

// 2. Session expiration (30 min of inactivity)
$sessionLifetime = 1800;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sessionLifetime)) {
    $_SESSION = [];
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

// 3. HTTP security headers
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'");

// 4. Controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';

$authController = new AuthController();
$userController = new UserController($authController);

// Flash message helpers (one-shot message stored in session)
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function popFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

// 5. Routing
$action = $_GET['action'] ?? 'home';

switch ($action) {

    // ---------------- HOME ----------------
    case 'home':
        if (AuthController::isAuthenticated()) {
            header('Location: index.php?action=' . (($_SESSION['role'] ?? '') === 'admin' ? 'admin' : 'dashboard'));
        } else {
            header('Location: index.php?action=login');
        }
        exit;

    // ---------------- REGISTER ----------------
    case 'register':
        if (AuthController::isAuthenticated()) {
            header('Location: index.php?action=dashboard');
            exit;
        }
        $errors = [];
        $old = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $authController->register($_POST);
            $old = ['username' => $_POST['username'] ?? '', 'email' => $_POST['email'] ?? ''];
            if (empty($errors)) {
                header('Location: index.php?action=login&registered=1');
                exit;
            }
        }
        $csrfToken = $authController->getCsrfToken();
        require __DIR__ . '/views/register.php';
        break;

    // ---------------- LOGIN ----------------
    case 'login':
        if (AuthController::isAuthenticated()) {
            header('Location: index.php?action=dashboard');
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $authController->login($_POST);
            if (empty($errors)) {
                $redirect = ($_SESSION['role'] ?? '') === 'admin' ? 'admin' : 'dashboard';
                header('Location: index.php?action=' . $redirect);
                exit;
            }
        }
        $csrfToken = $authController->getCsrfToken();
        require __DIR__ . '/views/login.php';
        break;

    // ---------------- LOGOUT ----------------
    case 'logout':
        $authController->logout();
        header('Location: index.php?action=login');
        exit;

    // ---------------- USER SPACE (frontoffice) ----------------
    case 'dashboard':
        AuthController::requireAuth();
        $user = $authController->findById((int) $_SESSION['user_id']);
        if (!$user) {
            $authController->logout();
            header('Location: index.php?action=login');
            exit;
        }
        require __DIR__ . '/views/user_space.php';
        break;

    // ---------------- ADMIN DASHBOARD (backoffice) ----------------
    case 'admin':
        AuthController::requireRole('admin');
        $user = $authController->findById((int) $_SESSION['user_id']);
        $allUsers = $authController->getAllUsers();
        $totalUsers = $authController->countAllUsers();
        $totalAdmins = $authController->countByRole('admin');
        $totalRegular = $authController->countByRole('user');
        require __DIR__ . '/views/admin_space.php';
        break;

    // ================= CRUD USERS (admin only) =================

    // ---------- READ (list) ----------
    case 'admin_users':
        AuthController::requireRole('admin');
        $user = $authController->findById((int) $_SESSION['user_id']);
        $allUsers = $userController->findAll();
        $csrfToken = $authController->getCsrfToken();
        $flash = popFlash();
        require __DIR__ . '/views/admin_users.php';
        break;

    // ---------- CREATE ----------
    case 'admin_user_create':
        AuthController::requireRole('admin');
        $user = $authController->findById((int) $_SESSION['user_id']);
        $mode = 'create';
        $errors = [];
        $old = ['username' => '', 'email' => '', 'role' => 'user'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $userController->create($_POST);
            $old = [
                'username' => $_POST['username'] ?? '',
                'email'    => $_POST['email'] ?? '',
                'role'     => $_POST['role'] ?? 'user',
            ];
            if (empty($errors)) {
                setFlash('success', 'User created successfully.');
                header('Location: index.php?action=admin_users');
                exit;
            }
        }
        $csrfToken = $authController->getCsrfToken();
        $formAction = 'index.php?action=admin_user_create';
        require __DIR__ . '/views/admin_user_form.php';
        break;

    // ---------- UPDATE ----------
    case 'admin_user_edit':
        AuthController::requireRole('admin');
        $user = $authController->findById((int) $_SESSION['user_id']);
        $id = (int) ($_GET['id'] ?? 0);
        $editedUser = $userController->findById($id);
        if (!$editedUser) {
            setFlash('error', 'User not found.');
            header('Location: index.php?action=admin_users');
            exit;
        }
        $mode = 'edit';
        $errors = [];
        $old = [
            'username' => $editedUser->getUsername(),
            'email'    => $editedUser->getEmail(),
            'role'     => $editedUser->getRole(),
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $userController->update($id, $_POST);
            $old = [
                'username' => $_POST['username'] ?? '',
                'email'    => $_POST['email'] ?? '',
                'role'     => $_POST['role'] ?? 'user',
            ];
            if (empty($errors)) {
                setFlash('success', 'User updated successfully.');
                header('Location: index.php?action=admin_users');
                exit;
            }
        }
        $csrfToken = $authController->getCsrfToken();
        $formAction = 'index.php?action=admin_user_edit&id=' . $id;
        require __DIR__ . '/views/admin_user_form.php';
        break;

    // ---------- DELETE (POST only) ----------
    case 'admin_user_delete':
        AuthController::requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Method not allowed.');
        }
        $errors = $userController->delete((int) ($_POST['id'] ?? 0), $_POST);
        if (empty($errors)) {
            setFlash('success', 'User deleted successfully.');
        } else {
            setFlash('error', $errors[0]);
        }
        header('Location: index.php?action=admin_users');
        exit;

    default:
        http_response_code(404);
        echo '404 - Page not found';
        break;
}
