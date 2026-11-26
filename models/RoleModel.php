
<?php

class RoleModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM roles ORDER BY id ASC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($name)
    {
        $name = trim($name);

        if ($name === '') {
            return false;
        }

        $check = $this->db->prepare(
            "SELECT COUNT(*) FROM roles WHERE LOWER(name) = LOWER(?)"
        );
        $check->execute([$name]);

        if ((int) $check->fetchColumn() > 0) {
            return false;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO roles (name) VALUES (?)"
        );

        return $stmt->execute([$name]);
    }

    public function update($id, $name)
    {
        $id = (int) $id;
        $name = trim($name);

        if ($id <= 0 || $name === '') {
            return false;
        }

        $check = $this->db->prepare(
            "SELECT COUNT(*) FROM roles WHERE LOWER(name) = LOWER(?) AND id != ?"
        );
        $check->execute([$name, $id]);

        if ((int) $check->fetchColumn() > 0) {
            return false;
        }

        $stmt = $this->db->prepare(
            "UPDATE roles SET name = ? WHERE id = ?"
        );

        return $stmt->execute([$name, $id]);
    }

    public function delete($id)
    {
        $id = (int) $id;

        if ($id <= 0 || in_array($id, [1, 2], true)) {
            return false;
        }

        $check = $this->db->prepare(
            "SELECT COUNT(*) FROM users WHERE role_id = ?"
        );
        $check->execute([$id]);

        if ((int) $check->fetchColumn() > 0) {
            return false;
        }

        $stmt = $this->db->prepare(
            "DELETE FROM roles WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }
}
