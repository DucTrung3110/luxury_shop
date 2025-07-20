<?php include 'views/layout/header.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <div class="profile-image-container">
                        <img src="<?php echo !empty($user['profile_image']) ? 'uploads/profiles/' . $user['profile_image'] : 'https://via.placeholder.com/150x150/000000/FFFFFF?text=User'; ?>" 
                             alt="Profile Image" class="profile-image">
                        <div class="profile-image-overlay">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <input type="file" id="profileImageUpload" class="profile-image-upload" accept="image/*">
                    <h2><?php echo htmlspecialchars($user['name']); ?></h2>
                    <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-luxury text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user-edit me-2"></i>Update Profile
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" class="profile-form" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-user me-2 text-muted"></i>Full Name
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label fw-semibold">
                                            <i class="fas fa-phone me-2 text-muted"></i>Phone Number
                                        </label>
                                        <input type="tel" class="form-control form-control-lg" id="phone" name="phone" 
                                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" 
                                               placeholder="Enter your phone number">
                                    </div>

                                    <div class="mb-4">
                                        <label for="address" class="form-label fw-semibold">
                                            <i class="fas fa-map-marker-alt me-2 text-muted"></i>Address
                                        </label>
                                        <textarea class="form-control form-control-lg" id="address" name="address" 
                                                  rows="3" placeholder="Enter your address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-luxury btn-lg w-100">
                                        <i class="fas fa-save me-2"></i>Update Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-outline-luxury">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-lock me-2"></i>Change Password
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="?controller=users&action=changePassword" class="profile-form">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label fw-semibold">
                                            <i class="fas fa-key me-2 text-muted"></i>Current Password
                                        </label>
                                        <div class="password-field">
                                            <input type="password" class="form-control form-control-lg" 
                                                   id="current_password" name="current_password" 
                                                   placeholder="Enter current password" required>
                                            <i class="fas fa-eye password-toggle" id="toggleCurrentPassword"></i>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label fw-semibold">
                                            <i class="fas fa-shield-alt me-2 text-muted"></i>New Password
                                        </label>
                                        <div class="password-field">
                                            <input type="password" class="form-control form-control-lg" 
                                                   id="new_password" name="new_password" 
                                                   placeholder="Enter new password" required>
                                            <i class="fas fa-eye password-toggle" id="toggleNewPassword"></i>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="confirm_password" class="form-label fw-semibold">
                                            <i class="fas fa-check-circle me-2 text-muted"></i>Confirm New Password
                                        </label>
                                        <div class="password-field">
                                            <input type="password" class="form-control form-control-lg" 
                                                   id="confirm_password" name="confirm_password" 
                                                   placeholder="Confirm new password" required>
                                            <i class="fas fa-eye password-toggle" id="toggleConfirmNewPassword"></i>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-luxury btn-lg w-100">
                                        <i class="fas fa-sync-alt me-2"></i>Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Account Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Member Since:</strong> <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                                        <p><strong>Account Status:</strong> <span class="badge bg-success">Active</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Role:</strong> <?php echo ucfirst($user['role']); ?></p>
                                        <p><strong>Last Login:</strong> <?php echo date('M j, Y g:i A'); ?></p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <a href="?controller=orders&action=history" class="btn btn-outline-luxury me-2">Order History</a>
                                    <a href="?controller=home" class="btn btn-outline-secondary">Back to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>