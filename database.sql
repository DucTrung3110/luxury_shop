-- Luxury Fashion E-commerce Database
-- Created for PHP MVC Fashion Website Project

CREATE DATABASE IF NOT EXISTS luxury_fashion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE luxury_fashion;

-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Comments table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    content TEXT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Shopping cart table
CREATE TABLE carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50) NOT NULL,
    shipping_name VARCHAR(100) NOT NULL,
    shipping_phone VARCHAR(20) NOT NULL,
    shipping_address TEXT NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order details table
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Handbags', 'Luxury designer handbags and purses'),
('Shoes', 'Premium footwear collection'),
('Clothing', 'High-end fashion apparel'),
('Accessories', 'Luxury fashion accessories'),
('Jewelry', 'Fine jewelry and watches');

-- Insert sample products
INSERT INTO products (name, description, price, category_id, featured) VALUES
('Classic Leather Handbag', 'Timeless elegance meets modern functionality in this exquisite leather handbag. Crafted from premium Italian leather with gold-tone hardware.', 1299.99, 1, TRUE),
('Diamond Quilted Bag', 'Iconic diamond-quilted pattern in soft lambskin leather. Features chain strap and signature lock closure.', 2499.99, 1, TRUE),
('Luxury Stiletto Heels', 'Sophisticated pointed-toe stilettos with patent leather finish. Perfect for evening occasions.', 899.99, 2, TRUE),
('Designer Sneakers', 'Contemporary luxury sneakers with premium leather upper and signature details.', 749.99, 2, FALSE),
('Silk Evening Dress', 'Flowing silk dress with intricate beadwork and elegant draping. Perfect for formal events.', 1899.99, 3, TRUE),
('Cashmere Coat', 'Luxurious double-breasted cashmere coat with timeless tailoring and premium buttons.', 2299.99, 3, FALSE),
('Diamond Necklace', 'Stunning diamond necklace with 18k white gold setting. Each diamond is carefully selected for brilliance.', 4999.99, 5, TRUE),
('Luxury Watch', 'Swiss-made timepiece with automatic movement and sapphire crystal. Water-resistant design.', 3299.99, 5, TRUE),
('Silk Scarf', 'Hand-rolled silk scarf with exclusive print design. Made from 100% pure silk.', 299.99, 4, FALSE),
('Leather Gloves', 'Soft nappa leather gloves with cashmere lining. Perfect for cold weather elegance.', 199.99, 4, FALSE);

-- Create admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@luxury-fashion.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Super Admin', 'superadmin@luxury-fashion.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Create sample user (password: user123)
INSERT INTO users (name, email, password, phone, address) VALUES
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1234567890', '123 Fashion Street, New York, NY 10001');

-- Insert sample comments
INSERT INTO comments (user_id, product_id, content, rating) VALUES
(2, 1, 'Absolutely love this handbag! The quality is exceptional and it goes with everything in my wardrobe.', 5),
(2, 2, 'The quilted pattern is so elegant and the leather is incredibly soft. Worth every penny!', 5),
(2, 3, 'These heels are gorgeous and surprisingly comfortable for stilettos. Perfect for special occasions.', 4),
(2, 7, 'Stunning necklace! The diamonds are brilliant and the craftsmanship is impeccable.', 5);

-- Create indexes for better performance
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_featured ON products(featured);
CREATE INDEX idx_comments_product ON comments(product_id);
CREATE INDEX idx_comments_user ON comments(user_id);
CREATE INDEX idx_carts_user ON carts(user_id);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_order_details_order ON order_details(order_id);
