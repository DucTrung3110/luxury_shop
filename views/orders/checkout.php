<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">Checkout</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Shipping Information</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="shipping_name" name="shipping_name" 
                                           value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" 
                                           value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Address</label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                      rows="3" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Order Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-luxury btn-lg">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Order Summary</h4>
                </div>
                <div class="card-body">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?></span>
                            <span><?php echo formatPrice($item['subtotal']); ?></span>
                        </div>
                    <?php endforeach; ?>
                    
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span><?php echo formatPrice($total); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong><?php echo formatPrice($total); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
