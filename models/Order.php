<?php
class Order {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($data) {
        $sql = "INSERT INTO orders (user_id, total_amount, shipping_name, shipping_phone, shipping_address, payment_method, notes, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['user_id'],
            $data['total_amount'],
            $data['shipping_name'],
            $data['shipping_phone'],
            $data['shipping_address'],
            $data['payment_method'],
            $data['notes'],
            $data['status']
        ];
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    public function addItem($orderId, $productId, $quantity, $price) {
        $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $this->db->query($sql, [$orderId, $productId, $quantity, $price]);
    }
    
    public function getById($id) {
        $stmt = $this->db->query("SELECT * FROM orders WHERE id = ?", [$id]);
        return $stmt->fetch();
    }
    
    public function getByUser($userId) {
        $stmt = $this->db->query("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC", [$userId]);
        return $stmt->fetchAll();
    }
    
    public function getOrderItems($orderId) {
        $sql = "SELECT od.*, p.name, p.image FROM order_details od 
                LEFT JOIN products p ON od.product_id = p.id 
                WHERE od.order_id = ?";
        $stmt = $this->db->query($sql, [$orderId]);
        return $stmt->fetchAll();
    }
    
    public function getAllWithUsers() {
        $sql = "SELECT o.*, u.name as user_name, u.email as user_email FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->db->query("UPDATE orders SET status = ? WHERE id = ?", [$status, $id]);
        return $stmt->rowCount() > 0;
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
        $result = $stmt->fetch();
        return $result['count'];
    }
    
    public function getTotalRevenue() {
        $stmt = $this->db->query("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    public function getRecent($limit = 10) {
        $sql = "SELECT o.*, u.name as user_name FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC 
                LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
}
?>
