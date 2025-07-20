<?php
// Application configuration
define('APP_NAME', 'Luxury Fashion');
define('APP_URL', 'http://localhost:5000');
define('UPLOAD_PATH', 'uploads/products/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'luxury_fashion');
define('DB_USER', 'root');
define('DB_PASS', '');

// Session configuration (must be set before session_start)
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Helper functions
function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function formatPrice($price) {
    return '$' . number_format($price ?? 0, 2);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function uploadImage($file, $targetDir = UPLOAD_PATH) {
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($fileExtension, $allowedExtensions)) {
        throw new Exception('Invalid file type');
    }
    
    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('File too large');
    }
    
    $fileName = uniqid() . '.' . $fileExtension;
    $targetPath = $targetDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }
    
    throw new Exception('Failed to upload file');
}
?>
