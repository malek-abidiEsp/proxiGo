
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnexion();
    }

    public static function isAuthenticated(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function requireAuth(): void
    {
        if (!self::isAuthenticated()) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public static function hasRole(string $role): bool
    {
        return self::isAuthenticated()
            && ($_SESSION['role'] ?? null) === $role;
    }

    public static function requireRole(string $role): void
    {
        self::requireAuth();

        if (($_SESSION['role'] ?? null) !== $role) {
            http_response_code(403);
            die('Access denied: you do not have the required permissions.');
        }
    }

    public function getCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public function verifyCsrfToken(?string $token): bool
    {
        if (!$token || empty($_SESSION['csrf_token'])) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    private function existsByEmailOrUsername(
        string $email,
        string $username
    ): bool {
        $stmt = $this->db->prepare(
            'SELECT id FROM users
             WHERE email = :email OR username = :username
             LIMIT 1'
        );

        $stmt->execute([
            'email' => $email,
            'username' => $username
        ]);

        return (bool) $stmt->fetch();
    }

    private function insertUser(UserModel $user): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users
            (username, email, password, role_id)
            VALUES (:username, :email, :password, :role_id)'
        );

        return $stmt->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role_id' => $user->getRoleId()
        ]);
    }

    private function findByEmail(string $email): ?UserModel
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM users WHERE email = :email LIMIT 1'
        );

        $stmt->execute(['email' => $email]);

        $row = $stmt->fetch();

        return $row ? UserModel::fromArray($row) : null;
    }

    public function findById(int $id): ?UserModel
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM users WHERE id = :id LIMIT 1'
        );

        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        return $row ? UserModel::fromArray($row) : null;
    }

    public function register(array $post): array
    {
        $errors = [];

        if (!$this->verifyCsrfToken($post['csrf_token'] ?? null)) {
            return ["Invalid security token. Please try again."];
        }

        $username = trim($post['username'] ?? '');
        $email = trim($post['email'] ?? '');
        $password = $post['password'] ?? '';
        $passwordConfirm = $post['password_confirm'] ?? '';

        if ($username === '' || $email === '' || $password === '') {
            $errors[] = "All fields are required.";
        }

        if (!preg_match('/^[a-zA-Z0-9_-]{3,50}$/', $username)) {
            $errors[] = "Username must be 3 to 50 characters (letters, digits, _ or -).";
        }

        if (
            strlen($email) > 150 ||
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            $errors[] = "Invalid email address.";
        }

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        if ($password !== $passwordConfirm) {
            $errors[] = "Passwords do not match.";
        }

        if (!empty($errors)) {
            return $errors;
        }

        if ($this->existsByEmailOrUsername($email, $username)) {
            return ["This email or username is already taken."];
        }

        $user = new UserModel();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setRoleId(2);

        if (!$this->insertUser($user)) {
            $errors[] = "An error occurred while creating your account.";
        }

        return $errors;
    }

    public function login(array $post): array
    {
        $errors = [];

        if (!$this->verifyCsrfToken($post['csrf_token'] ?? null)) {
            return ["Invalid security token. Please try again."];
        }

        $email = trim($post['email'] ?? '');
        $password = $post['password'] ?? '';

        if ($email === '' || $password === '') {
            return ["Please enter your email and password."];
        }

        $user = $this->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return ["Incorrect email or password."];
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role'] = $user->getRoleId() === 1 ? 'admin' : 'user';
        $_SESSION['last_activity'] = time();

        return $errors;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query(
            'SELECT * FROM users ORDER BY id ASC'
        );

        return array_map(
            fn(array $row) => UserModel::fromArray($row),
            $stmt->fetchAll()
        );
    }

    public function countByRole(string $role): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*)
             FROM users u
             INNER JOIN roles r ON u.role_id = r.id
             WHERE r.name = :role'
        );

        $stmt->execute(['role' => $role]);

        return (int) $stmt->fetchColumn();
    }

    public function countAllUsers(): int
    {
        return (int) $this->db
            ->query('SELECT COUNT(*) FROM users')
            ->fetchColumn();
    }
}
