<?php
class AdminController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
    }
    
    public function index() {
        $this->dashboard();
    }
    
    public function dashboard() {
        $userModel = new User();
        $productModel = new Product();
        $orderModel = new Order();
        
        $stats = [
            'totalUsers' => $userModel->getCount(),
            'totalProducts' => $productModel->getCount(),
            'totalOrders' => $orderModel->getCount(),
            'totalRevenue' => $orderModel->getTotalRevenue(),
            'recentOrders' => $orderModel->getRecent(10)
        ];
        
        $this->render('admin/dashboard', ['stats' => $stats]);
    }
    
    public function categories() {
        $categoryModel = new Category();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            
            if ($action === 'create') {
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                
                if (empty($name)) {
                    $_SESSION['error'] = 'Category name is required';
                } else {
                    $categoryModel->create([
                        'name' => $name,
                        'description' => $description
                    ]);
                    $_SESSION['success'] = 'Category created successfully';
                }
            } elseif ($action === 'update') {
                $id = (int)$_POST['id'];
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                
                if (empty($name)) {
                    $_SESSION['error'] = 'Category name is required';
                } else {
                    $categoryModel->update($id, [
                        'name' => $name,
                        'description' => $description
                    ]);
                    $_SESSION['success'] = 'Category updated successfully';
                }
            } elseif ($action === 'delete') {
                $id = (int)$_POST['id'];
                $categoryModel->delete($id);
                $_SESSION['success'] = 'Category deleted successfully';
            }
        }
        
        $categories = $categoryModel->getAll();
        $this->render('admin/categories', ['categories' => $categories]);
    }
    
    public function products() {
        $productModel = new Product();
        $categoryModel = new Category();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            
            if ($action === 'create') {
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                $price = (float)$_POST['price'];
                $categoryId = (int)$_POST['category_id'];
                $featured = isset($_POST['featured']) ? 1 : 0;
                
                if (empty($name) || $price <= 0) {
                    $_SESSION['error'] = 'Name and valid price are required';
                } else {
                    $data = [
                        'name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'category_id' => $categoryId,
                        'featured' => $featured
                    ];
                    
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                        try {
                            $data['image'] = uploadImage($_FILES['image']);
                        } catch (Exception $e) {
                            $_SESSION['error'] = 'Image upload failed: ' . $e->getMessage();
                        }
                    }
                    
                    if (!isset($_SESSION['error'])) {
                        $productModel->create($data);
                        $_SESSION['success'] = 'Product created successfully';
                    }
                }
            } elseif ($action === 'update') {
                $id = (int)$_POST['id'];
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                $price = (float)$_POST['price'];
                $categoryId = (int)$_POST['category_id'];
                $featured = isset($_POST['featured']) ? 1 : 0;
                
                if (empty($name) || $price <= 0) {
                    $_SESSION['error'] = 'Name and valid price are required';
                } else {
                    $data = [
                        'name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'category_id' => $categoryId,
                        'featured' => $featured
                    ];
                    
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                        try {
                            $data['image'] = uploadImage($_FILES['image']);
                        } catch (Exception $e) {
                            $_SESSION['error'] = 'Image upload failed: ' . $e->getMessage();
                        }
                    }
                    
                    if (!isset($_SESSION['error'])) {
                        $productModel->update($id, $data);
                        $_SESSION['success'] = 'Product updated successfully';
                    }
                }
            } elseif ($action === 'delete') {
                $id = (int)$_POST['id'];
                $productModel->delete($id);
                $_SESSION['success'] = 'Product deleted successfully';
            }
        }
        
        $products = $productModel->getAll();
        $categories = $categoryModel->getAll();
        $this->render('admin/products', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
    
    public function users() {
        $userModel = new User();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            
            if ($action === 'update_role') {
                $id = (int)$_POST['id'];
                $role = sanitize($_POST['role']);
                
                if (in_array($role, ['user', 'admin'])) {
                    $userModel->update($id, ['role' => $role]);
                    $_SESSION['success'] = 'User role updated successfully';
                } else {
                    $_SESSION['error'] = 'Invalid role';
                }
            } elseif ($action === 'delete') {
                $id = (int)$_POST['id'];
                if ($id != $_SESSION['user_id']) {
                    $userModel->delete($id);
                    $_SESSION['success'] = 'User deleted successfully';
                } else {
                    $_SESSION['error'] = 'Cannot delete your own account';
                }
            }
        }
        
        $users = $userModel->getAll();
        $this->render('admin/users', ['users' => $users]);
    }
    
    public function orders() {
        $orderModel = new Order();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            
            if ($action === 'update_status') {
                $id = (int)$_POST['id'];
                $status = sanitize($_POST['status']);
                
                if (in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
                    $orderModel->updateStatus($id, $status);
                    $_SESSION['success'] = 'Order status updated successfully';
                } else {
                    $_SESSION['error'] = 'Invalid status';
                }
            }
        }
        
        $orders = $orderModel->getAllWithUsers();
        $this->render('admin/orders', ['orders' => $orders]);
    }
}
?>
