<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                <h1 class="mb-4">Order Placed Successfully!</h1>
                <p class="lead">Thank you for your purchase. Your order has been placed and is being processed.</p>
                
                <div class="order-details mt-4">
                    <h4>Order Details</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                                    <p><strong>Order Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                                    <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Total:</strong> <?php echo formatPrice($order['total_amount']); ?></p>
                                    <p><strong>Payment Method:</strong> <?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <h5>Items Ordered:</h5>
                            <?php foreach ($orderItems as $item): ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?></span>
                                    <span><?php echo formatPrice($item['price'] * $item['quantity']); ?></span>
                                </div>
                            <?php endforeach; ?>
                            
                            <hr>
                            
                            <h5>Shipping Address:</h5>
                            <p><?php echo htmlspecialchars($order['shipping_name']); ?><br>
                               <?php echo htmlspecialchars($order['shipping_phone']); ?><br>
                               <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="?controller=orders&action=history" class="btn btn-luxury me-2">View Order History</a>
                    <a href="?controller=products" class="btn btn-outline-luxury">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
