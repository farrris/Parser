<?php

require_once "helpers.php";

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        if ($this->connect()) {
            $this->initTables();
            $this->createMockData();
            print_r("Успешное подключение к базе данных\n");
        } else {
            print_r("Не удалось подключиться к базе данных\n");
            die();
        }
    }

    public function connect(): bool
    {
        try {
            $env = loadEnv();
            $this->pdo = new PDO("pgsql:host=" . $env["DB_HOST"] . ";dbname=" . $env["DB_NAME"], $env["DB_USER"],
                $env["DB_PASSWORD"]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function initTables(): void
    {
        $this->createClientsTable();
        $this->createMerchandisesTable();
        $this->createOrdersTable();
    }

    public function createOrder(int $itemId, int $customerId, string $comment): void
    {
        $query = $this->pdo->prepare("insert into orders (item_id, customer_id, comment) values (?, ?, ?)");
        $query->execute([$itemId, $customerId, $comment]);
    }

    private function createMockData(): void
    {
        $this->pdo->query("insert into clients (name) values ('Василий'), ('Пётр'), ('Алексей')");
        $this->pdo->query("insert into merchandises (name, price) values ('Маска для лица', 1000), ('Лак', 800), ('Беспроводные наушники', 2000)");
    }

    private function createClientsTable(): void
    {
        $this->pdo->query("create table if not exists clients
                                (id serial primary key, 
                                name varchar(30))");
    }

    private function createMerchandisesTable(): void
    {
        $this->pdo->query("create table if not exists merchandises 
                                (id serial primary key, 
                                name varchar(30),
                                price integer)");
    }

    private function createOrdersTable(): void
    {
        $this->pdo->query("create type order_status as enum ('new', 'complete');");

        $this->pdo->query("create table if not exists orders
                                 (id serial primary key,
                                  item_id integer references merchandises(id),
                                  customer_id integer references clients(id),
                                  comment text,
                                  status order_status default 'new',
                                  order_date timestamp default now()
                                  )");
    }
}