<?php
class Cart {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getByUser($userId) {
        $sql = "SELECT c.*, p.name, p.price, p.image, (c.quantity * p.price) as subtotal 
                FROM carts c 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?";
        $stmt = $this->db->query($sql, [$userId]);
        return $stmt->fetchAll();
    }
    
    public function addItem($userId, $productId, $quantity) {
        // Check if item already exists
        $stmt = $this->db->query("SELECT * FROM carts WHERE user_id = ? AND product_id = ?", [$userId, $productId]);
        $existing = $stmt->fetch();
        
        if ($existing) {
            // Update quantity
            $newQuantity = $existing['quantity'] + $quantity;
            $this->db->query("UPDATE carts SET quantity = ? WHERE user_id = ? AND product_id = ?", 
                [$newQuantity, $userId, $productId]);
        } else {
            // Insert new item
            $this->db->query("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)", 
                [$userId, $productId, $quantity]);
        }
    }
    
    public function updateQuantity($userId, $productId, $quantity) {
        $stmt = $this->db->query("UPDATE carts SET quantity = ? WHERE user_id = ? AND product_id = ?", 
            [$quantity, $userId, $productId]);
        return $stmt->rowCount() > 0;
    }
    
    public function removeItem($userId, $productId) {
        $stmt = $this->db->query("DELETE FROM carts WHERE user_id = ? AND product_id = ?", 
            [$userId, $productId]);
        return $stmt->rowCount() > 0;
    }
    
    public function clearCart($userId) {
        $stmt = $this->db->query("DELETE FROM carts WHERE user_id = ?", [$userId]);
        return $stmt->rowCount() > 0;
    }
    
    public function getItemCount($userId) {
        $stmt = $this->db->query("SELECT SUM(quantity) as count FROM carts WHERE user_id = ?", [$userId]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
    
    public function getTotal($userId) {
        $sql = "SELECT SUM(c.quantity * p.price) as total FROM carts c 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?";
        $stmt = $this->db->query($sql, [$userId]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
?>
