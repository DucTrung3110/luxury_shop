<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card">
                <h2 class="text-center mb-4">Login</h2>
                
                <form method="POST" class="auth-form">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-field">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-luxury w-100">Login</button>
                </form>
                
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="?controller=users&action=register">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
