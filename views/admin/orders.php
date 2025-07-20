<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">Manage Orders</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['id']; ?></td>
                                        <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($order['user_email']); ?></td>
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
                                        <td><?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary edit-order" 
                                                    data-id="<?php echo $order['id']; ?>"
                                                    data-status="<?php echo $order['status']; ?>">
                                                Update Status
                                            </button>
                                            <button class="btn btn-sm btn-outline-info view-order" 
                                                    data-id="<?php echo $order['id']; ?>"
                                                    data-customer="<?php echo htmlspecialchars($order['user_name']); ?>"
                                                    data-phone="<?php echo htmlspecialchars($order['shipping_phone']); ?>"
                                                    data-address="<?php echo htmlspecialchars($order['shipping_address']); ?>"
                                                    data-notes="<?php echo htmlspecialchars($order['notes']); ?>">
                                                View Details
                                            </button>
                                        </td>
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

<!-- Edit Order Status Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="id" id="editOrderId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Order Status</label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Order Details Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <p><strong>Name:</strong> <span id="viewCustomerName"></span></p>
                        <p><strong>Phone:</strong> <span id="viewCustomerPhone"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Shipping Address</h6>
                        <p id="viewShippingAddress"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6>Order Notes</h6>
                        <p id="viewOrderNotes"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-order');
    const viewButtons = document.querySelectorAll('.view-order');
    const editModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
    const viewModal = new bootstrap.Modal(document.getElementById('viewOrderModal'));
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const status = this.getAttribute('data-status');
            
            document.getElementById('editOrderId').value = id;
            document.getElementById('editStatus').value = status;
            
            editModal.show();
        });
    });
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const customer = this.getAttribute('data-customer');
            const phone = this.getAttribute('data-phone');
            const address = this.getAttribute('data-address');
            const notes = this.getAttribute('data-notes');
            
            document.getElementById('viewCustomerName').textContent = customer;
            document.getElementById('viewCustomerPhone').textContent = phone;
            document.getElementById('viewShippingAddress').textContent = address;
            document.getElementById('viewOrderNotes').textContent = notes || 'No notes';
            
            viewModal.show();
        });
    });
});
</script>

<?php include 'views/layout/footer.php'; ?>
