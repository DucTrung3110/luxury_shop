
<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="product-image-large">
                <img src="<?php echo $product['image'] ? 'uploads/products/' . $product['image'] : 'https://via.placeholder.com/600x800/000000/FFFFFF?text=Luxury+Product'; ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                     class="product-detail-image img-fluid">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="product-detail-info">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="?controller=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?controller=products">Products</a></li>
                        <li class="breadcrumb-item active"><?php echo htmlspecialchars($product['name']); ?></li>
                    </ol>
                </nav>
                
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="product-category mb-3">
                    <i class="fas fa-tag"></i> 
                    <?php echo htmlspecialchars($product['category_name'] ?? 'Fashion'); ?>
                </p>
                <p class="product-detail-price"><?php echo formatPrice($product['price']); ?></p>
                
                <div class="product-detail-description">
                    <h5>Description</h5>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
                
                <div class="product-detail-actions mb-4">
                    <div class="quantity-selector mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                            <input type="number" class="form-control mx-2" id="quantity" value="1" min="1" max="10" style="width: 80px;">
                            <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 flex-wrap">
                        <button class="btn btn-luxury btn-lg add-to-cart" 
                                data-product-id="<?php echo $product['id']; ?>">
                            <i class="fas fa-shopping-bag me-2"></i>Add to Cart
                        </button>
                        
                        <button class="btn btn-outline-luxury btn-lg" onclick="toggleWishlist(<?php echo $product['id']; ?>)">
                            <i class="fas fa-heart me-2"></i>Add to Wishlist
                        </button>
                    </div>
                </div>
                
                <div class="product-info mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-info-circle me-2"></i>Product Details</h6>
                            <ul class="list-unstyled">
                                <li><strong>Brand:</strong> Luxury Fashion</li>
                                <li><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name'] ?? 'Fashion'); ?></li>
                                <li><strong>Stock:</strong> <span class="text-success">In Stock</span></li>
                                <li><strong>SKU:</strong> LF-<?php echo str_pad($product['id'], 6, '0', STR_PAD_LEFT); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-truck me-2"></i>Shipping & Returns</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success"></i> Free shipping on orders over $500</li>
                                <li><i class="fas fa-check text-success"></i> 30-day return policy</li>
                                <li><i class="fas fa-check text-success"></i> Authentic guarantee</li>
                                <li><i class="fas fa-check text-success"></i> Secure payment</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="section-title mb-4">Related Products</h3>
        </div>
    </div>
    <div class="row">
        <?php foreach ($relatedProducts as $relatedProduct): ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $relatedProduct['image'] ? 'uploads/products/' . $relatedProduct['image'] : 'https://via.placeholder.com/300x400/000000/FFFFFF?text=Luxury+Product'; ?>" 
                             alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>">
                        <div class="product-overlay">
                            <button class="btn btn-outline-light add-to-cart" 
                                    data-product-id="<?php echo $relatedProduct['id']; ?>">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                            <a href="?controller=products&action=show&id=<?php echo $relatedProduct['id']; ?>" 
                               class="btn btn-outline-light">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h5><?php echo htmlspecialchars($relatedProduct['name']); ?></h5>
                        <p class="product-category"><?php echo htmlspecialchars($relatedProduct['category_name']); ?></p>
                        <p class="product-price"><?php echo formatPrice($relatedProduct['price']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    if (currentValue < 10) {
        quantityInput.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
}

function toggleWishlist(productId) {
    // Implement wishlist functionality
    alert('Wishlist feature will be implemented soon!');
}

// Override add to cart function for product detail page
document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.querySelector('.add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const quantity = document.getElementById('quantity').value;
            
            addToCart(productId, quantity);
        });
    }
});
</script>

<?php include 'views/layout/footer.php'; ?>
