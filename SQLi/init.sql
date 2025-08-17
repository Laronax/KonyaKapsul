-- Create database
CREATE DATABASE IF NOT EXISTS sqli_demo;
USE sqli_demo;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample users (vulnerable to SQL injection)
INSERT INTO users (username, password, email) VALUES
('admin', 'admin123', 'admin@example.com'),
('user1', 'password123', 'user1@example.com'),
('test', 'test123', 'test@example.com'),
('demo', 'demo123', 'demo@example.com');

-- Insert sample products
INSERT INTO products (name, description, price, category) VALUES
('Laptop', 'High performance laptop', 999.99, 'Electronics'),
('Smartphone', 'Latest smartphone model', 599.99, 'Electronics'),
('Book', 'Programming book', 29.99, 'Books'),
('Headphones', 'Wireless headphones', 89.99, 'Electronics'),
('Tablet', '10 inch tablet', 299.99, 'Electronics');
