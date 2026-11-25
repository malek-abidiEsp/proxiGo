
<?php

class RoleModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Afficher les roles
    public function getAll() {
        $sql = "SELECT * FROM roles";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un role
    public function add($name) {
        $sql = "INSERT INTO roles (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name]);
    }

    // Modifier un role
    public function update($id, $name) {
        $sql = "UPDATE roles SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }

    // Supprimer un role
    public function delete($id) {
        $sql = "DELETE FROM roles WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
