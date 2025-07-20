<?php
class Category {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->query("SELECT * FROM categories WHERE id = ?", [$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        $this->db->query($sql, [$data['name'], $data['description']]);
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->db->query($sql, [$data['name'], $data['description'], $id]);
        return $stmt->rowCount() > 0;
    }
    
    public function delete($id) {
        $stmt = $this->db->query("DELETE FROM categories WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }
}
?>
