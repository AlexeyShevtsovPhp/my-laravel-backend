<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\DataBase;

$db = DataBase::getInstance();

$tableSchema = "CREATE TABLE IF NOT EXISTS comments (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    content TEXT NOT NULL,
                    users_id INT NOT NULL,
                    category_id INT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
                )";

$db->getConnection()->exec($tableSchema);
echo "Таблица 'comments' успешно создана или уже существует.\n";
