<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\DataBase;

$db = DataBase::getInstance();

$tableSchema = "CREATE TABLE IF NOT EXISTS categories (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name TEXT NOT NULL
                )";

$db->getConnection()->exec($tableSchema);
echo "Таблица 'categories' успешно создана или уже существует.\n";
