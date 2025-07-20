<?php // include 'views/layout/header.php'; line analysis: Includes the header layout file.
 include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card">
                <h2 class="text-center mb-4">Register</h2>

                <form method="POST" class="auth-form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

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

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="password-field">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                        </div>
                    </div>

                    <div class="password-requirements" id="passwordRequirements">
                        <small>Mật khẩu phải có:</small>
                        <ul>
                            <li id="length">Ít nhất 8 ký tự</li>
                            <li id="uppercase">Một chữ cái viết hoa</li>
                            <li id="lowercase">Một chữ cái viết thường</li>
                            <li id="number">Một chữ số</li>
                            <li id="special">Một ký tự đặc biệt (!@#$%^&*)</li>
                        </ul>
                    </div>

                    <div class="password-requirements mt-2">
                        <ul>
                            <li id="match">Mật khẩu khớp nhau</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-luxury w-100">Register</button>
                </form>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="?controller=users&action=login">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>