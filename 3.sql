CREATE INDEX idx_order_date ON orders (order_date); -- создаём индекс по дате заказа для ускорения выборки из 1 запроса

CREATE INDEX idx_customer_id ON orders (customer_id); -- создаём индекс по id клиента для ускорения группировки во 2 и 3 запросе

CREATE INDEX  idx_item_id ON orders (item_id); -- создаём индекс по id товара для ускорения джоина из 3 запроса

CREATE INDEX idx_status ON orders (status) -- создаём индекс по статусу для ускорения выборки из 4 запроса
