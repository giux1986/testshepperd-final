# testshepperd
 
1)
SELECT username, email
FROM users;

2)
SELECT name, description, price
FROM products;

3)

SELECT total
FROM orders
WHERE id = <order_id>;

4)
SELECT p.name AS product_name, oi.qty AS quantity
FROM order_items AS oi
JOIN products AS p ON oi.product_id = p.id
WHERE oi.order_id = <order_id>;

5)
UPDATE products
SET qty = <new_qty>
WHERE id = <product_id>;

6) My suggestion will be: 

* Add indexes for fields frequently used in the WHERE clause, such as user_id in the orders table and product_id in the order_items table, create indexes to speed up the search process.

-- For users table
CREATE INDEX idx_users_id ON users (id);
CREATE INDEX idx_users_username ON users (username);
CREATE INDEX idx_users_email ON users (email);

-- For products table
CREATE INDEX idx_products_id ON products (id);
CREATE INDEX idx_products_name ON products (name);

-- For orders table
CREATE INDEX idx_orders_id ON orders (id);
CREATE INDEX idx_orders_user_id ON orders (user_id);

-- For order_items table
CREATE INDEX idx_order_items_id ON order_items (id);
CREATE INDEX idx_order_items_order_id ON order_items (order_id);
CREATE INDEX idx_order_items_product_id ON order_items (product_id);

* Denormalize Data: Depending on your specific use case, you might consider denormalizing some data, like adding redundant information to avoid joins and improve query performance.

ALTER TABLE orders
ADD COLUMN user_username VARCHAR(255),
ADD COLUMN user_email VARCHAR(255),
ADD COLUMN user_first_name VARCHAR(255),
ADD COLUMN user_last_name VARCHAR(255);

* Partitioning: If your tables grow significantly large, you can partition them based on certain criteria (e.g., date or ID ranges) to improve query speed.

CREATE TABLE orders_partitioned (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    created_at DATE NOT NULL,
    -- Additional columns here as needed
)
PARTITION BY RANGE (created_at);

-- Create partitions for different date ranges
CREATE TABLE orders_partition_2021_01_01 PARTITION OF orders_partitioned
    FOR VALUES FROM ('2021-01-01') TO ('2021-02-01');

CREATE TABLE orders_partition_2021_02_01 PARTITION OF orders_partitioned
    FOR VALUES FROM ('2021-02-01') TO ('2021-03-01');


* Caching: Use caching mechanisms like Redis to store frequently accessed data temporarily, reducing database load.	

7)
SELECT o.id AS order_id,
       o.total AS order_total,
       o.created_at AS order_created_at,
       CONCAT(u.first_name," ", u.last_name) AS user_full_name,
       p.name AS product_name,
       oi.qty AS quantity,
       p.price AS product_price
FROM orders AS o
JOIN users AS u ON o.user_id = u.id
JOIN order_items AS oi ON o.id = oi.order_id
JOIN products AS p ON oi.product_id = p.id
WHERE o.id = 1;

commands
php artisan migrate
php artisan db:seed
