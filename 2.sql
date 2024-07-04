-- 1
SELECT name FROM clients WHERE id not in (
    SELECT customer_id
    FROM orders
    WHERE order_date > current_date - interval '7 days'
);
-- 2
SELECT name FROM clients WHERE id in (
    SELECT customer_id
    FROM orders
    GROUP BY customer_id
    ORDER BY COUNT(*) DESC
    LIMIT 5
);
-- 3
SELECT name FROM clients WHERE id in (
    SELECT customer_id
    FROM orders
    JOIN merchandises ON orders.item_id = merchandises.id
    GROUP BY customer_id
    ORDER BY sum(price) DESC
    LIMIT 10
);
-- 4
SELECT name FROM merchandises WHERE id not in (
    SELECT item_id
    FROM orders
    WHERE status = 'complete'
);