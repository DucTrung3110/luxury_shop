<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
        return $stmt->fetch();
    }
    
    public function login($email, $password) {
        $stmt = $this->db->query("SELECT * FROM users WHERE email = ?", [$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function emailExists($email) {
        $stmt = $this->db->query("SELECT id FROM users WHERE email = ?", [$email]);
        return $stmt->fetch() !== false;
    }
    
    public function create($data) {
        $sql = "INSERT INTO users (name, email, password, role, profile_image) VALUES (?, ?, ?, ?, ?)";
        $params = [
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role'] ?? 'user',
            $data['profile_image'] ?? null
        ];
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
            $params[] = $value;
        }
        
        $params[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount() > 0;
    }
    
    public function delete($id) {
        $stmt = $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch();
        return $result['count'];
    }
}
?>
