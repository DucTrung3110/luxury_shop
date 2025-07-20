<?php include 'views/layout/header.php'; ?>

<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Luxury Fashion Collection</h1>
        <p class="hero-subtitle">Discover timeless elegance and sophisticated style</p>
        <a href="?controller=products" class="btn btn-luxury">Shop Now</a>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h2 class="section-title">Featured Categories</h2>
        </div>
    </div>
    
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-4">
                <div class="category-card">
                    <div class="category-overlay">
                        <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p><?php echo htmlspecialchars($category['description']); ?></p>
                        <a href="?controller=products&category=<?php echo $category['id']; ?>" class="btn btn-outline-light">
                            View Products
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h2 class="section-title">Featured Products</h2>
        </div>
    </div>
    
    <div class="row">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $product['image'] ? 'uploads/products/' . $product['image'] : 'https://via.placeholder.com/300x400/000000/FFFFFF?text=Luxury+Product'; ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="product-overlay">
                            <button class="btn btn-outline-light add-to-cart" 
                                    data-product-id="<?php echo $product['id']; ?>">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                            <a href="?controller=products&action=show&id=<?php echo $product['id']; ?>" 
                               class="btn btn-outline-light">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                        <p class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></p>
                        <p class="product-price"><?php echo formatPrice($product['price']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
