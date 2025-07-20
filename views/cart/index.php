<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">Shopping Cart</h1>
        </div>
    </div>
    
    <?php if (empty($cartItems)): ?>
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h3>Your cart is empty</h3>
                    <p>Start shopping to add items to your cart.</p>
                    <a href="?controller=products" class="btn btn-luxury">Continue Shopping</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="cart-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item" data-product-id="<?php echo $item['id']; ?>">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?php echo $item['image'] ? 'uploads/products/' . $item['image'] : 'https://via.placeholder.com/100x100/000000/FFFFFF?text=Product'; ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid">
                                </div>
                                <div class="col-md-4">
                                    <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                    <p class="text-muted"><?php echo formatPrice($item['price']); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <div class="quantity-controls">
                                        <button class="btn btn-sm btn-outline-secondary quantity-decrease">-</button>
                                        <input type="number" class="form-control quantity-input" 
                                               value="<?php echo $item['quantity']; ?>" min="1" max="10">
                                        <button class="btn btn-sm btn-outline-secondary quantity-increase">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p class="item-subtotal"><?php echo formatPrice($item['subtotal']); ?></p>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-sm btn-outline-danger remove-item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="cart-summary">
                    <h4>Order Summary</h4>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span id="cartTotal"><?php echo formatPrice($total); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong id="cartTotalFinal"><?php echo formatPrice($total); ?></strong>
                    </div>
                    
                    <div class="mt-3">
                        <?php if (isLoggedIn()): ?>
                            <a href="?controller=orders&action=checkout" class="btn btn-luxury w-100">Checkout</a>
                        <?php else: ?>
                            <a href="?controller=users&action=login" class="btn btn-luxury w-100">Login to Checkout</a>
                        <?php endif; ?>
                        <a href="?controller=products" class="btn btn-outline-luxury w-100 mt-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/layout/footer.php'; ?>
