<?php
ob_start();
require_once 'config/config.php';
require_once 'config/database.php';
session_start();

// Auto-load controllers and models
spl_autoload_register(function ($class) {
    $paths = [
        'controllers/' . $class . '.php',
        'models/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            break;
        }
    }
});

// Get route parameters
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Route handling
try {
    switch ($controller) {
        case 'home':
            $controllerInstance = new HomeController();
            break;
        case 'products':
            $controllerInstance = new ProductController();
            break;
        case 'users':
            $controllerInstance = new UserController();
            break;
        case 'cart':
            $controllerInstance = new CartController();
            break;
        case 'orders':
            $controllerInstance = new OrderController();
            break;
        case 'admin':
            $controllerInstance = new AdminController();
            break;
        default:
            $controllerInstance = new HomeController();
            $action = 'index';
    }
    
    // Call the action method
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action($id);
    } else {
        $controllerInstance->index();
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    header('Location: ?controller=home&action=index');
    exit();
}

ob_end_flush();
?>
