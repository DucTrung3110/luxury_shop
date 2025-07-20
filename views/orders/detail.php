<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">Order Details</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Order #<?php echo $order['id']; ?></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Order Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-<?php 
                                    switch ($order['status']) {
                                        case 'pending': echo 'warning'; break;
                                        case 'processing': echo 'info'; break;
                                        case 'shipped': echo 'primary'; break;
                                        case 'delivered': echo 'success'; break;
                                        case 'cancelled': echo 'danger'; break;
                                        default: echo 'secondary';
                                    }
                                ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total:</strong> <?php echo formatPrice($order['total_amount']); ?></p>
                            <p><strong>Payment Method:</strong> <?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>
                        </div>
                    </div>
                    
                    <h6>Items Ordered:</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderItems as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $item['image'] ? 'uploads/products/' . $item['image'] : 'https://via.placeholder.com/50x50'; ?>" 
                                                     alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                                     class="img-thumbnail me-3" style="width: 50px; height: 50px;">
                                                <?php echo htmlspecialchars($item['name']); ?>
                                            </div>
                                        </td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td><?php echo formatPrice($item['price']); ?></td>
                                        <td><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Shipping Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['shipping_name']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['shipping_phone']); ?></p>
                    <p><strong>Address:</strong><br><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                    
                    <?php if ($order['notes']): ?>
                        <p><strong>Notes:</strong><br><?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-12">
            <a href="?controller=orders&action=history" class="btn btn-outline-luxury">Back to Orders</a>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
