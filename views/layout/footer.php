    </main>
    
    <footer class="luxury-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>LUXURY FASHION</h5>
                    <p>Discover the finest collection of luxury fashion items from world-renowned designers.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="?controller=home">Home</a></li>
                        <li><a href="?controller=products">Products</a></li>
                        <li><a href="?controller=cart">Cart</a></li>
                        <?php if (isLoggedIn()): ?>
                            <li><a href="?controller=orders&action=history">Orders</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Connect With Us</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2024 Luxury Fashion. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Scroll to top button -->
    <button class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
