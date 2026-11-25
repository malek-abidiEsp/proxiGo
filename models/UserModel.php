
<?php
class UserModel
{
    private int $id = 0;
    private string $username = '';
    private string $email = '';
    private string $password = '';
    private int $roleId = 2;
    private string $createdAt = '';

    public function __construct() {}

    // Getters
    public function getId(): int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRoleId(): int { return $this->roleId; }
    public function getCreatedAt(): string { return $this->createdAt; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setRoleId(int $roleId): void { $this->roleId = $roleId; }
    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }

public static function fromArray(array $row): self
{
    $user = new self();

    $user->setId((int) $row['id']);
    $user->setUsername($row['username']);
    $user->setEmail($row['email']);
    $user->setPassword($row['password']);
    $user->setRoleId((int) $row['role_id']);
    $user->setCreatedAt($row['created_at']);

    return $user;
}

}
