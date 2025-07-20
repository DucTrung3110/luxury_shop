<?php
class CartController extends BaseController {
    
    public function index() {
        $cartModel = new Cart();
        $cartItems = [];
        $total = 0;
        
        if (isLoggedIn()) {
            $cartItems = $cartModel->getByUser($_SESSION['user_id']);
            $total = $cartModel->getTotal($_SESSION['user_id']);
        } else {
            // Handle session-based cart for guests
            if (isset($_SESSION['cart'])) {
                $productModel = new Product();
                foreach ($_SESSION['cart'] as $productId => $quantity) {
                    $product = $productModel->getById($productId);
                    if ($product) {
                        $cartItems[] = [
                            'id' => $productId,
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'image' => $product['image'],
                            'quantity' => $quantity,
                            'subtotal' => $product['price'] * $quantity
                        ];
                        $total += $product['price'] * $quantity;
                    }
                }
            }
        }
        
        $this->render('cart/index', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)$_POST['product_id'];
            $quantity = (int)($_POST['quantity'] ?? 1);
            
            if ($productId <= 0 || $quantity <= 0) {
                $this->json(['success' => false, 'message' => 'Invalid product or quantity']);
                return;
            }
            
            $productModel = new Product();
            $product = $productModel->getById($productId);
            
            if (!$product) {
                $this->json(['success' => false, 'message' => 'Product not found']);
                return;
            }
            
            if (isLoggedIn()) {
                $cartModel = new Cart();
                $cartModel->addItem($_SESSION['user_id'], $productId, $quantity);
                $cartCount = $cartModel->getItemCount($_SESSION['user_id']);
            } else {
                // Handle session-based cart for guests
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = $quantity;
                }
                
                $cartCount = array_sum($_SESSION['cart']);
            }
            
            $this->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cartCount' => $cartCount
            ]);
        }
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            
            if ($quantity <= 0) {
                return $this->remove();
            }
            
            if (isLoggedIn()) {
                $cartModel = new Cart();
                $cartModel->updateQuantity($_SESSION['user_id'], $productId, $quantity);
                $total = $cartModel->getTotal($_SESSION['user_id']);
                $cartCount = $cartModel->getItemCount($_SESSION['user_id']);
            } else {
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId] = $quantity;
                    
                    // Calculate total for session cart
                    $total = 0;
                    $productModel = new Product();
                    foreach ($_SESSION['cart'] as $pid => $qty) {
                        $product = $productModel->getById($pid);
                        if ($product) {
                            $total += $product['price'] * $qty;
                        }
                    }
                    $cartCount = array_sum($_SESSION['cart']);
                }
            }
            
            $this->json([
                'success' => true,
                'message' => 'Cart updated',
                'total' => $total ?? 0,
                'cartCount' => $cartCount ?? 0
            ]);
        }
    }
    
    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)$_POST['product_id'];
            
            if (isLoggedIn()) {
                $cartModel = new Cart();
                $cartModel->removeItem($_SESSION['user_id'], $productId);
                $cartCount = $cartModel->getItemCount($_SESSION['user_id']);
                $total = $cartModel->getTotal($_SESSION['user_id']);
            } else {
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                    $cartCount = array_sum($_SESSION['cart']);
                    
                    // Calculate total for session cart
                    $total = 0;
                    $productModel = new Product();
                    foreach ($_SESSION['cart'] as $pid => $qty) {
                        $product = $productModel->getById($pid);
                        if ($product) {
                            $total += $product['price'] * $qty;
                        }
                    }
                }
            }
            
            $this->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'cartCount' => $cartCount ?? 0,
                'total' => $total ?? 0
            ]);
        }
    }
    
    public function clear() {
        if (isLoggedIn()) {
            $cartModel = new Cart();
            $cartModel->clearCart($_SESSION['user_id']);
        } else {
            $_SESSION['cart'] = [];
        }
        
        redirect('?controller=cart');
    }
}
?>
