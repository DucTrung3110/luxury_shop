
// Shopping Cart JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Prevent multiple event listeners
    if (window.cartInitialized) return;
    window.cartInitialized = true;

    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        // Remove any existing listeners
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        newButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.getAttribute('data-product-id');
            const quantityInput = document.getElementById('quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            // Disable button during request
            this.disabled = true;
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';

            addToCart(productId, quantity).then(response => {
                if (response.success) {
                    updateCartCount(response.cartCount);
                    showNotification(response.message, 'success');

                    // Add animation to cart icon
                    const cartIcon = document.querySelector('.nav-link[href*="cart"] i');
                    if (cartIcon) {
                        cartIcon.classList.add('bounce');
                        setTimeout(() => cartIcon.classList.remove('bounce'), 600);
                    }
                } else {
                    showNotification(response.message, 'error');
                }
            }).finally(() => {
                // Re-enable button
                this.disabled = false;
                this.innerHTML = originalText;
            });
        });
    });

    // Cart quantity controls
    const quantityControls = document.querySelectorAll('.quantity-controls');
    quantityControls.forEach(control => {
        const decreaseBtn = control.querySelector('.quantity-decrease');
        const increaseBtn = control.querySelector('.quantity-increase');
        const quantityInput = control.querySelector('.quantity-input');
        const cartItem = control.closest('.cart-item');
        
        if (!cartItem) return;
        
        const productId = cartItem.getAttribute('data-product-id');

        if (decreaseBtn && quantityInput) {
            decreaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    updateCartQuantity(productId, currentValue - 1);
                }
            });
        }

        if (increaseBtn && quantityInput) {
            increaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < 10) {
                    quantityInput.value = currentValue + 1;
                    updateCartQuantity(productId, currentValue + 1);
                }
            });
        }

        if (quantityInput) {
            quantityInput.addEventListener('change', function() {
                const newQuantity = parseInt(this.value);
                if (newQuantity >= 1 && newQuantity <= 10) {
                    updateCartQuantity(productId, newQuantity);
                } else {
                    this.value = this.value < 1 ? 1 : 10;
                }
            });
        }
    });

    // Remove item from cart
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const productId = cartItem.getAttribute('data-product-id');

            if (confirm('Are you sure you want to remove this item from your cart?')) {
                removeFromCart(productId).then(response => {
                    if (response.success) {
                        cartItem.remove();
                        updateCartCount(response.cartCount);
                        updateCartTotal(response.total);
                        showNotification(response.message, 'success');

                        // Check if cart is empty
                        const remainingItems = document.querySelectorAll('.cart-item');
                        if (remainingItems.length === 0) {
                            location.reload();
                        }
                    } else {
                        showNotification(response.message, 'error');
                    }
                });
            }
        });
    });

    // Product detail page quantity controls
    const detailQuantityControls = document.querySelector('.quantity-selector');
    if (detailQuantityControls) {
        const quantityInput = detailQuantityControls.querySelector('input[type="number"]');

        if (quantityInput) {
            quantityInput.addEventListener('change', function() {
                const quantity = parseInt(this.value);
                if (quantity < 1) {
                    this.value = 1;
                } else if (quantity > 10) {
                    this.value = 10;
                }
            });
        }
    }
});

// Cart API functions
async function addToCart(productId, quantity = 1) {
    try {
        const response = await fetch('?controller=cart&action=add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        });

        return await response.json();
    } catch (error) {
        console.error('Error adding to cart:', error);
        return { success: false, message: 'An error occurred while adding to cart' };
    }
}

async function updateCartQuantity(productId, quantity) {
    try {
        const response = await fetch('?controller=cart&action=update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        });

        const result = await response.json();
        if (result.success) {
            updateCartTotal(result.total);
            updateCartCount(result.cartCount);
            updateItemSubtotal(productId, quantity);
        }
        return result;
    } catch (error) {
        console.error('Error updating cart:', error);
        return { success: false, message: 'An error occurred while updating cart' };
    }
}

async function removeFromCart(productId) {
    try {
        const response = await fetch('?controller=cart&action=remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        });

        return await response.json();
    } catch (error) {
        console.error('Error removing from cart:', error);
        return { success: false, message: 'An error occurred while removing from cart' };
    }
}

// UI update functions
function updateCartCount(count) {
    const cartCountElement = document.getElementById('cartCount');
    if (cartCountElement) {
        cartCountElement.textContent = count;
    }
}

function updateCartTotal(total) {
    const cartTotalElement = document.getElementById('cartTotal');
    const cartTotalFinalElement = document.getElementById('cartTotalFinal');

    if (cartTotalElement) {
        cartTotalElement.textContent = formatPrice(total);
    }
    if (cartTotalFinalElement) {
        cartTotalFinalElement.textContent = formatPrice(total);
    }
}

function updateItemSubtotal(productId, quantity) {
    const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
    if (cartItem) {
        const priceElement = cartItem.querySelector('.text-muted');
        const subtotalElement = cartItem.querySelector('.item-subtotal');

        if (priceElement && subtotalElement) {
            const priceText = priceElement.textContent.replace('$', '').replace(',', '');
            const price = parseFloat(priceText);
            const subtotal = price * quantity;
            subtotalElement.textContent = formatPrice(subtotal);
        }
    }
}

// Add CSS for bounce animation
const style = document.createElement('style');
style.textContent = `
    @keyframes bounce {
        0%, 20%, 60%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        80% {
            transform: translateY(-5px);
        }
    }

    .bounce {
        animation: bounce 0.6s ease;
    }

    .cart-item {
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .quantity-controls .btn:hover {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
    }

    .add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
`;
document.head.appendChild(style);
