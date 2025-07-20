<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="page-title">Our Products</h1>
        </div>
    </div>

    <div class="row">
        <!-- Filters -->
        <div class="col-md-3 mb-4">
            <div class="filter-section">
                <h5>Filter & Sort</h5>

                <form method="GET" id="filterForm">
                    <input type="hidden" name="controller" value="products">

                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?php echo htmlspecialchars($currentSearch); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" 
                                        <?php echo $currentCategory == $category['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="newest" <?php echo $currentSort == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                            <option value="price_low" <?php echo $currentSort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $currentSort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                            <option value="name" <?php echo $currentSort == 'name' ? 'selected' : ''; ?>>Name A-Z</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-luxury w-100">Apply Filters</button>
                </form>
            </div>
        </div>

        <!-- Products -->
        <div class="col-md-9">
            <div class="row">
                <?php if (empty($products)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3>No products found</h3>
                            <p>Try adjusting your search or filter criteria.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
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
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <nav aria-label="Products pagination">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?controller=products&page=<?php echo $i; ?>&category=<?php echo $selectedCategory; ?>&search=<?php echo urlencode($currentSearch); ?>&sort=<?php echo $currentSort; ?>">
                                    <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>