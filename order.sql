-- Create database
CREATE DATABASE oven_craft;

-- Use the database
USE oven_craft;

-- Create orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    instructions TEXT,
    payment_method VARCHAR(50) NOT NULL,
    cart_items TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
