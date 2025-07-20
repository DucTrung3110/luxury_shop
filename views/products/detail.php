<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="product-image-large">
                <img src="<?php echo $product['image'] ? 'uploads/products/' . $product['image'] : 'https://via.placeholder.com/600x800/000000/FFFFFF?text=Luxury+Product'; ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="product-details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></p>
                <p class="product-price-large"><?php echo formatPrice($product['price']); ?></p>
                
                <div class="product-description">
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
                
                <div class="product-actions">
                    <div class="quantity-selector mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" class="form-control" id="quantity" value="1" min="1" max="10">
                    </div>
                    
                    <button class="btn btn-luxury btn-lg add-to-cart" 
                            data-product-id="<?php echo $product['id']; ?>">
                        <i class="fas fa-shopping-bag"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Customer Reviews</h3>
            
            <?php if (isLoggedIn()): ?>
                <div class="review-form mb-4">
                    <h5>Leave a Review</h5>
                    <form method="POST" action="?controller=products&action=addComment&id=<?php echo $product['id']; ?>">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="">Select Rating</option>
                                <option value="5">5 Stars - Excellent</option>
                                <option value="4">4 Stars - Very Good</option>
                                <option value="3">3 Stars - Good</option>
                                <option value="2">2 Stars - Fair</option>
                                <option value="1">1 Star - Poor</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Review</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-luxury">Submit Review</button>
                    </form>
                </div>
            <?php else: ?>
                <p><a href="?controller=users&action=login">Login</a> to leave a review.</p>
            <?php endif; ?>
            
            <div class="reviews">
                <?php if (empty($comments)): ?>
                    <p>No reviews yet. Be the first to review this product!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <h6><?php echo htmlspecialchars($comment['user_name']); ?></h6>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i <= $comment['rating'] ? '' : '-o'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <small class="text-muted"><?php echo date('F j, Y', strtotime($comment['created_at'])); ?></small>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="row mt-5">
            <div class="col-12">
                <h3>Related Products</h3>
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
                                        <a href="?controller=products&action=detail&id=<?php echo $relatedProduct['id']; ?>" 
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
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/layout/footer.php'; ?>
