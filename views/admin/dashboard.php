<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">Admin Dashboard</h1>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3><?php echo $stats['totalUsers']; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-box fa-3x text-success mb-3"></i>
                    <h3><?php echo $stats['totalProducts']; ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-shopping-cart fa-3x text-warning mb-3"></i>
                    <h3><?php echo $stats['totalOrders']; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-dollar-sign fa-3x text-info mb-3"></i>
                    <h3><?php echo formatPrice($stats['totalRevenue']); ?></h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="?controller=admin&action=categories" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-tags"></i> Manage Categories
                    </a>
                    <a href="?controller=admin&action=products" class="btn btn-outline-success w-100 mb-2">
                        <i class="fas fa-box"></i> Manage Products
                    </a>
                    <a href="?controller=admin&action=users" class="btn btn-outline-info w-100 mb-2">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    <a href="?controller=admin&action=orders" class="btn btn-outline-warning w-100">
                        <i class="fas fa-shopping-cart"></i> Manage Orders
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['recentOrders'] as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['id']; ?></td>
                                        <td><?php echo htmlspecialchars($order['user_name']); ?></td>
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
                                        <td><?php echo date('M j', strtotime($order['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
