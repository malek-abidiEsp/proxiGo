
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/AuthController.php';


class UserController
{
    private PDO $db;
    private AuthController $auth;
    public const ROLES = [
        'user' => 2,
        'admin' => 1
    ];

    public function __construct(AuthController $auth)
    {
        $this->db = Database::getConnexion();
        $this->auth = $auth;
    }


    public function findAll(): array
    {
        $stmt = $this->db->query(
            'SELECT * FROM users ORDER BY id ASC'
        );

        return array_map(
            fn(array $row) => UserModel::fromArray($row),
            $stmt->fetchAll()
        );
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

    private function isTaken(
        string $email,
        string $username,
        int $excludeId = 0
    ): bool {
        $stmt = $this->db->prepare(
            'SELECT id FROM users
             WHERE (email = :email OR username = :username)
             AND id <> :id
             LIMIT 1'
        );

        $stmt->execute([
            'email' => $email,
            'username' => $username,
            'id' => $excludeId
        ]);

        return (bool) $stmt->fetch();
    }

    private function validate(
        array $post,
        bool $passwordRequired
    ): array {
        $errors = [];

        $username = trim($post['username'] ?? '');
        $email = trim($post['email'] ?? '');
        $password = $post['password'] ?? '';
        $roleId = (int) ($post['role_id'] ?? 0);

        if (!preg_match('/^[a-zA-Z0-9_-]{3,50}$/', $username)) {
            $errors[] = "Username must be 3 to 50 characters (letters, digits, _ or -).";
        }

        if (
            strlen($email) > 150 ||
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            $errors[] = "Invalid email address.";
        }

        if (!in_array($roleId, self::ROLES, true)) {
            $errors[] = "Invalid role.";
        }

        if ($passwordRequired || $password !== '') {
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }
        }

        return $errors;
    }
    public function create(array $post): array
    {
        if (!$this->auth->verifyCsrfToken($post['csrf_token'] ?? null)) {
            return ["Invalid security token. Please try again."];
        }

        $errors = $this->validate($post, true);

        if (!empty($errors)) {
            return $errors;
        }

        $username = trim($post['username']);
        $email = trim($post['email']);
        $roleId = (int) $post['role_id'];

        if ($this->isTaken($email, $username)) {
            return ["This email or username is already taken."];
        }

        $stmt = $this->db->prepare(
            'INSERT INTO users
            (username, email, password, role_id)
            VALUES
            (:username, :email, :password, :role_id)'
        );

        $ok = $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => password_hash(
                $post['password'],
                PASSWORD_DEFAULT
            ),
            'role_id' => $roleId
        ]);

        return $ok
            ? []
            : ["An error occurred while creating the user."];
    }


    public function update(int $id, array $post): array
    {
        if (!$this->auth->verifyCsrfToken($post['csrf_token'] ?? null)) {
            return ["Invalid security token. Please try again."];
        }

        if (!$this->findById($id)) {
            return ["User not found."];
        }

        $errors = $this->validate($post, false);

        if (!empty($errors)) {
            return $errors;
        }

        $username = trim($post['username']);
        $email = trim($post['email']);
        $roleId = (int) $post['role_id'];

        $isSelf = $id === (int) ($_SESSION['user_id'] ?? 0);

        if ($isSelf && $roleId !== 1) {
            return ["You cannot remove your own admin role."];
        }

        if ($this->isTaken($email, $username, $id)) {
            return ["This email or username is already taken."];
        }

        $params = [
            'username' => $username,
            'email' => $email,
            'role_id' => $roleId,
            'id' => $id
        ];

        if (($post['password'] ?? '') !== '') {

            $sql = 'UPDATE users
                    SET username = :username,
                        email = :email,
                        role_id = :role_id,
                        password = :password
                    WHERE id = :id';

            $params['password'] = password_hash(
                $post['password'],
                PASSWORD_DEFAULT
            );

        } else {

            $sql = 'UPDATE users
                    SET username = :username,
                        email = :email,
                        role_id = :role_id
                    WHERE id = :id';
        }

        $ok = $this->db->prepare($sql)->execute($params);

        if ($ok && $isSelf) {
            $_SESSION['username'] = $username;
        }

        return $ok
            ? []
            : ["An error occurred while updating the user."];
    }


    public function delete(int $id, array $post): array
    {
        if (!$this->auth->verifyCsrfToken($post['csrf_token'] ?? null)) {
            return ["Invalid security token. Please try again."];
        }

        if ($id === (int) ($_SESSION['user_id'] ?? 0)) {
            return ["You cannot delete your own account."];
        }

        if (!$this->findById($id)) {
            return ["User not found."];
        }

        $stmt = $this->db->prepare(
            'DELETE FROM users WHERE id = :id'
        );

        $ok = $stmt->execute(['id' => $id]);

        return $ok
            ? []
            : ["An error occurred while deleting the user."];
    }
}
