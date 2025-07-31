<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\DataBase;

$db = DataBase::getInstance();

$db->getConnection()->exec("ALTER TABLE users AUTO_INCREMENT = 1");
$users = [
    ['username' => 'Артём', 'password' => '1111', 'role' => 'admin'],
    ['username' => 'Винсент', 'password' => '2222', 'role' => 'guest'],
    ['username' => 'Джон', 'password' => '8876', 'role' => 'guest'],
    ['username' => 'Егор', 'password' => '0342', 'role' => 'guest'],
    ['username' => 'Саша', 'password' => '8842', 'role' => 'guest'],
    ['username' => 'Роб', 'password' => '3257', 'role' => 'guest'],
    ['username' => 'Борис', 'password' => '8532', 'role' => 'guest'],
    ['username' => 'БоБо', 'password' => '2403', 'role' => 'guest'],
];

foreach ($users as $user) {
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, password, created_at, role)
            VALUES (:username, :password, NOW(), :role)";
    $stmt = $db->getConnection()->prepare($sql);
    $stmt->bindParam(':username', $user['username']);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindValue(':role', $user['role']);
    $stmt->execute();
}

