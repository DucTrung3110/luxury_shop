<?php
class Product {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll() {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    public function getFeatured($limit = 8) {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.featured = TRUE 
                ORDER BY p.created_at DESC 
                LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
    
    public function getFiltered($category = null, $search = '', $sort = 'newest', $page = 1, $limit = 12) {
        $page = (int)$page;
        $limit = (int)$limit;
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        $params = [];
        
        if ($category) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category;
        }
        
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        
        switch ($sort) {
            case 'price_low':
                $sql .= " ORDER BY p.price ASC";
                break;
            case 'price_high':
                $sql .= " ORDER BY p.price DESC";
                break;
            case 'name':
                $sql .= " ORDER BY p.name ASC";
                break;
            default:
                $sql .= " ORDER BY p.created_at DESC";
        }
        
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getFilteredCount($category = null, $search = '') {
        $sql = "SELECT COUNT(*) as count FROM products WHERE 1=1";
        $params = [];
        
        if ($category) {
            $sql .= " AND category_id = ?";
            $params[] = $category;
        }
        
        if ($search) {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        
        $stmt = $this->db->query($sql, $params);
        $result = $stmt->fetch();
        return $result['count'];
    }
    
    public function getRelated($categoryId, $excludeId, $limit = 4) {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ? AND p.id != ? 
                ORDER BY RANDOM() 
                LIMIT ?";
        $stmt = $this->db->query($sql, [$categoryId, $excludeId, $limit]);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $sql = "INSERT INTO products (name, description, price, category_id, image, featured) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $data['image'] ?? null,
            $data['featured'] ?? 0
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
        $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount() > 0;
    }
    
    public function delete($id) {
        $stmt = $this->db->query("DELETE FROM products WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }
    
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM products");
        $result = $stmt->fetch();
        return $result['count'];
    }
    
    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }
    
    public function search($query) {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE ? OR p.description LIKE ? 
                ORDER BY p.name ASC";
        $stmt = $this->db->query($sql, ["%$query%", "%$query%"]);
        return $stmt->fetchAll();
    }
}
?>
