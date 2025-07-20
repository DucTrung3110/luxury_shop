// Main JavaScript file for Luxury Fashion Website
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Password visibility toggle
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.parentElement.querySelector('input[type="password"], input[type="text"]');
            const icon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Form validation
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            if (!email || !password) return;

            if (!email.value.trim()) {
                e.preventDefault();
                showNotification('Please enter your email', 'error');
                return;
            }

            if (!password.value.trim()) {
                e.preventDefault();
                showNotification('Please enter your password', 'error');
                return;
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');

            if (!name || !email || !password || !confirmPassword) return;

            if (!name.value.trim()) {
                e.preventDefault();
                showNotification('Please enter your name', 'error');
                return;
            }

            if (!email.value.trim()) {
                e.preventDefault();
                showNotification('Please enter your email', 'error');
                return;
            }

            if (password.value.length < 6) {
                e.preventDefault();
                showNotification('Password must be at least 6 characters long', 'error');
                return;
            }

            if (password.value !== confirmPassword.value) {
                e.preventDefault();
                showNotification('Passwords do not match', 'error');
                return;
            }
        });
    }

    // Product hover effects
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-submit filter form
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        const filterInputs = filterForm.querySelectorAll('input, select');
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                filterForm.submit();
            });
        });
    }

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Fade in animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    // Observe all product cards
    document.querySelectorAll('.product-card').forEach(card => {
        observer.observe(card);
    });

    // Image lazy loading
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));

    // Show loading spinner on form submission
    const allForms = document.querySelectorAll('form');
    allForms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                submitBtn.disabled = true;
            }
        });
    });

    // Fix product detail page functionality
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            const value = parseInt(this.value);
            if (value < 1) this.value = 1;
            if (value > 10) this.value = 10;
        });
    }

    // Auto hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Mobile menu enhancement
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            navbarCollapse.classList.toggle('show');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navbarToggler.contains(e.target) && !navbarCollapse.contains(e.target)) {
                navbarCollapse.classList.remove('show');
            }
        });
    }

    // Enhanced product image gallery
    const productImages = document.querySelectorAll('.product-image img');
    productImages.forEach(img => {
        img.addEventListener('click', function() {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${this.src}" class="img-fluid" alt="${this.alt}">
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();

            modal.addEventListener('hidden.bs.modal', function() {
                modal.remove();
            });
        });
    });

    // Search functionality enhancement
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
    }

    // Quantity input validation
    const quantityInputs = document.querySelectorAll('input[type="number"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const min = parseInt(this.min) || 1;
            const max = parseInt(this.max) || 10;
            const value = parseInt(this.value);

            if (value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = max;
            }
        });
    });

    // Enhanced Password visibility toggle functionality
    function initializePasswordToggles() {
        // Find all password toggle buttons
        const passwordToggles = document.querySelectorAll('.password-toggle');
        
        passwordToggles.forEach(toggle => {
            // Remove any existing event listeners
            toggle.replaceWith(toggle.cloneNode(true));
        });

        // Re-select after cloning to get fresh elements
        const freshToggles = document.querySelectorAll('.password-toggle');
        
        freshToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Find the password input in the same parent container
                const passwordField = this.closest('.password-field, .mb-3, .form-group')?.querySelector('input[type="password"], input[type="text"]');
                
                if (passwordField) {
                    const isPassword = passwordField.type === 'password';
                    passwordField.type = isPassword ? 'text' : 'password';

                    // Toggle icon classes safely
                    if (isPassword) {
                        this.classList.remove('fa-eye');
                        this.classList.add('fa-eye-slash');
                    } else {
                        this.classList.remove('fa-eye-slash');
                        this.classList.add('fa-eye');
                    }
                }
            });
        });
    }

    // Initialize password toggles
    initializePasswordToggles();

    // Profile image upload functionality
    const profileImageContainer = document.querySelector('.profile-image-container');
    const profileImageUpload = document.getElementById('profileImageUpload');
    const profileImage = document.querySelector('.profile-image');

    if (profileImageContainer && profileImageUpload && profileImage) {
        // Click on container to trigger file input
        profileImageContainer.addEventListener('click', function() {
            profileImageUpload.click();
        });

        // Handle file selection
        profileImageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
                    return;
                }

                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    return;
                }

                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Create form data and upload
                const formData = new FormData();
                formData.append('profile_image', file);

                fetch('?controller=users&action=uploadProfileImage', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showAlert('Profile image updated successfully!', 'success');
                    } else {
                        showAlert(data.message || 'Failed to upload image', 'error');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    showAlert('Failed to upload image', 'error');
                });
            }
        });
    }

    // Helper function to show alerts
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    }

    // Password strength validation for register form
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');

    if (passwordField) {
        passwordField.addEventListener('input', function() {
            validatePassword(this.value);
        });
    }

    if (confirmPasswordField) {
        confirmPasswordField.addEventListener('input', function() {
            validatePasswordMatch();
        });
    }

    function validatePassword(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(req);
            if (element) {
                element.className = requirements[req] ? 'valid' : 'invalid';
            }
        });

        validatePasswordMatch();
    }

    function validatePasswordMatch() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const matchElement = document.getElementById('match');

        if (password && confirmPassword && matchElement) {
            const isMatch = password.value === confirmPassword.value && confirmPassword.value !== '';
            matchElement.className = isMatch ? 'valid' : 'invalid';
        }
    }

    // Product quantity controls
    const quantityControls = document.querySelectorAll('.quantity-selector');
    quantityControls.forEach(control => {
        const decreaseBtn = control.querySelector('.decrease');
        const increaseBtn = control.querySelector('.increase');
        const input = control.querySelector('input');

        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value) || 1;
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }

        if (increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value) || 1;
                const maxValue = parseInt(input.max) || 10;
                if (currentValue < maxValue) {
                    input.value = currentValue + 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }
    });

    // Shopping cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const quantity = this.closest('.product-detail-actions')?.querySelector('input[name="quantity"]')?.value || 1;

            addToCart(productId, quantity);
        });
    });

    // Animation on scroll
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, { threshold: 0.1 });

    animatedElements.forEach(element => {
        animationObserver.observe(element);
    });
});

// Add to cart function
async function addToCart(productId, quantity = 1) {
    try {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        const response = await fetch('?controller=cart&action=add', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showNotification(data.message, 'success');
            updateCartCount(data.cartCount);
        } else {
            showNotification(data.message, 'error');
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        showNotification('An error occurred while adding to cart', 'error');
    }
}

// Show notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 80px; right: 20px; z-index: 9999; min-width: 300px;';

    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Update cart count function
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
        if (count > 0) {
            element.style.display = 'inline';
        } else {
            element.style.display = 'none';
        }
    });
}

// Format price function
function formatPrice(price) {
    return '$' + parseFloat(price).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}