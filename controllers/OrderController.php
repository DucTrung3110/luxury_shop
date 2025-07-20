<?php
class OrderController extends BaseController {
    
    public function checkout() {
        $this->requireLogin();
        
        $cartModel = new Cart();
        $cartItems = $cartModel->getByUser($_SESSION['user_id']);
        $total = $cartModel->getTotal($_SESSION['user_id']);
        
        if (empty($cartItems)) {
            $_SESSION['error'] = 'Your cart is empty';
            redirect('?controller=cart');
        }
        
        $userModel = new User();
        $user = $userModel->getById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $shippingName = sanitize($_POST['shipping_name']);
            $shippingPhone = sanitize($_POST['shipping_phone']);
            $shippingAddress = sanitize($_POST['shipping_address']);
            $paymentMethod = sanitize($_POST['payment_method']);
            $notes = sanitize($_POST['notes'] ?? '');
            
            if (empty($shippingName) || empty($shippingPhone) || empty($shippingAddress)) {
                $_SESSION['error'] = 'All shipping fields are required';
            } else {
                $orderModel = new Order();
                
                try {
                    $orderId = $orderModel->create([
                        'user_id' => $_SESSION['user_id'],
                        'total_amount' => $total,
                        'shipping_name' => $shippingName,
                        'shipping_phone' => $shippingPhone,
                        'shipping_address' => $shippingAddress,
                        'payment_method' => $paymentMethod,
                        'notes' => $notes,
                        'status' => 'pending'
                    ]);
                    
                    // Add order items
                    foreach ($cartItems as $item) {
                        $orderModel->addItem($orderId, $item['id'], $item['quantity'], $item['price']);
                    }
                    
                    // Clear cart
                    $cartModel->clearCart($_SESSION['user_id']);
                    
                    $_SESSION['success'] = 'Order placed successfully!';
                    redirect("?controller=orders&action=success&id={$orderId}");
                    
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Order placement failed: ' . $e->getMessage();
                }
            }
        }
        
        $this->render('orders/checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'user' => $user
        ]);
    }
    
    public function success($orderId) {
        $this->requireLogin();
        
        $orderModel = new Order();
        $order = $orderModel->getById($orderId);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            redirect('?controller=home');
        }
        
        $orderItems = $orderModel->getOrderItems($orderId);
        
        $this->render('orders/success', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
    
    public function history() {
        $this->requireLogin();
        
        $orderModel = new Order();
        $orders = $orderModel->getByUser($_SESSION['user_id']);
        
        $this->render('orders/history', [
            'orders' => $orders
        ]);
    }
    
    public function detail($orderId) {
        $this->requireLogin();
        
        $orderModel = new Order();
        $order = $orderModel->getById($orderId);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            redirect('?controller=orders&action=history');
        }
        
        $orderItems = $orderModel->getOrderItems($orderId);
        
        $this->render('orders/detail', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
}
?>
