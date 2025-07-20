<?php
class Comment {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getByProduct($productId) {
        $sql = "SELECT c.*, u.name as user_name FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.product_id = ? 
                ORDER BY c.created_at DESC";
        $stmt = $this->db->query($sql, [$productId]);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $sql = "INSERT INTO comments (user_id, product_id, content, rating) VALUES (?, ?, ?, ?)";
        $params = [
            $data['user_id'],
            $data['product_id'],
            $data['content'],
            $data['rating']
        ];
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    public function delete($id) {
        $stmt = $this->db->query("DELETE FROM comments WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }
}
?>
