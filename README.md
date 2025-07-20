# Luxury Fashion E-commerce Website

A sophisticated e-commerce platform for luxury fashion items, built with PHP MVC architecture and MySQL database. Inspired by high-end fashion brands like Gucci, Louis Vuitton, and Chanel.

## Features

### Customer Features
- **Product Catalog**: Browse luxury fashion items with advanced filtering and search
- **Product Details**: Detailed product pages with image gallery and customer reviews
- **Shopping Cart**: Add, update, and remove items with persistent cart functionality
- **Checkout System**: Complete order processing with shipping information
- **User Authentication**: Secure registration and login system
- **Order History**: Track current and past orders with detailed information
- **Product Reviews**: Rate and review purchased items
- **Responsive Design**: Optimized for desktop, tablet, and mobile devices

### Admin Features
- **Dashboard**: Overview of sales, orders, and key metrics
- **Product Management**: CRUD operations for products with image upload
- **Category Management**: Organize products into categories
- **User Management**: Manage customer accounts and roles
- **Order Management**: Process and track customer orders
- **Inventory Control**: Monitor stock levels and product availability

## Technology Stack

### Backend
- **PHP 8+**: Server-side programming language
- **MySQL 8+**: Database management system
- **PDO**: Database abstraction layer for secure queries
- **MVC Architecture**: Organized code structure with Model-View-Controller pattern

### Frontend
- **HTML5**: Modern markup structure
- **CSS3**: Advanced styling with luxury design aesthetics
- **JavaScript**: Interactive functionality and AJAX operations
- **Bootstrap 5**: Responsive UI framework
- **Font Awesome**: Icon library for enhanced user interface

## Installation

### Prerequisites
- XAMPP or Laragon (as specified in project requirements)
- PHP 8.0 or higher
- MySQL 8.0 or higher
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone or Download the Project**
   ```bash
   git clone [repository-url]
   cd luxury-fashion-website
   ```

2. **Database Setup**
   - Create a new database named `luxury_fashion`
   - Import the provided `database.sql` file
   - Update database credentials in `config/database.php` if needed

3. **Configure Environment**
   - Ensure the `uploads/products/` directory is writable
   - Update `config/config.php` with your domain settings
   - Set proper file permissions for upload directories

4. **Access the Application**
   - Place the project in your web server's root directory
   - Access via `http://localhost/luxury-fashion-website`
   - Admin access: `admin@luxury-fashion.com` / `admin123`
   - User access: `john@example.com` / `user123`

## Project Structure

