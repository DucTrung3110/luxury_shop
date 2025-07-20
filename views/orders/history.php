<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">Order History</h1>
        </div>
    </div>
    
    <?php if (empty($orders)): ?>
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h3>No orders yet</h3>
                    <p>You haven't placed any orders yet. Start shopping to see your orders here.</p>
                    <a href="?controller=products" class="btn btn-luxury">Start Shopping</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                    <td><?php echo formatPrice($order['total_amount']); ?></td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="?controller=orders&action=detail&id=<?php echo $order['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/layout/footer.php'; ?>
