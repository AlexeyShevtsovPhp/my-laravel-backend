<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\DataBase;

$db = DataBase::getInstance();

$db->getConnection()->exec("ALTER TABLE categories AUTO_INCREMENT = 1");

$categories = [
    ['name' => 'Спорт'],
    ['name' => 'Готовка'],
    ['name' => 'Охота'],
    ['name' => 'Рыбалка'],
    ['name' => 'Акультизм'],
    ['name' => 'Авто'],
    ['name' => 'Аэробика'],
    ['name' => 'Грубиянство'],
    ['name' => 'Исскуство'],
    ['name' => 'Бизнес'],
];

foreach ($categories as $category) {
    $sql = "INSERT INTO categories (name) VALUES (:name)";
    $stmt = $db->getConnection()->prepare($sql);

    $stmt->bindParam(':name', $categories['name']);
    $stmt->execute();
}
