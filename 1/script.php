<?php

require_once "Database.php";
require_once "Parser.php";

$filename = "dataset.txt";

$db = new Database();
$results = Parser::getResults($filename);

foreach ($results as $result) {
    $db->createOrder($result[0], $result[1], $result[2]);
}

print_r("Успешное выполнение скрипта");
