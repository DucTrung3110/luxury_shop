<?php
abstract class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    protected function render($view, $data = []) {
        extract($data);
        include "views/{$view}.php";
    }
    
    protected function requireLogin() {
        if (!isLoggedIn()) {
            redirect('?controller=users&action=login');
        }
    }
    
    protected function requireAdmin() {
        if (!isAdmin()) {
            redirect('?controller=home&action=index');
        }
    }
    
    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
?>
