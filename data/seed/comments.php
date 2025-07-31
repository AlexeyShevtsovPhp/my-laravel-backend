<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\DataBase;

$db = DataBase::getInstance();

$db->getConnection()->exec("ALTER TABLE comments AUTO_INCREMENT = 1");

$comments = [
    ['content' => 'Looks so delicious!', 'users_id' => 5, 'category_id' => 2],
    ['content' => 'Just look at that streachy girl', 'users_id' => 4, 'category_id' => 1],
    ['content' => 'Great video', 'users_id' => 4, 'category_id' => 6],
    ['content' => 'We need more sport events like this', 'users_id' => 2, 'category_id' => 1],
    ['content' => 'Oh men, this sport tasks is so annoying', 'users_id' => 4, 'category_id' => 7],
    ['content' => 'But i need to be more patient and just do it', 'users_id' => 4, 'category_id' => 7],
    ['content' => 'We need to cook', 'users_id' => 1, 'category_id' => 5],
    ['content' => 'Greetings, ur dish looks pretty nice', 'users_id' => 6, 'category_id' => 2],
    ['content' => 'Nice sniper rifle, bud', 'users_id' => 7, 'category_id' => 3],
    ['content' => 'What a gorgeous place for fishing', 'users_id' => 8, 'category_id' => 4],
    ['content' => 'We need a more specific victim next time', 'users_id' => 6, 'category_id' => 5],
    ['content' => 'So much death, so quicly', 'users_id' => 1, 'category_id' => 5],
    ['content' => 'Is anyone take my ritual dagger?', 'users_id' => 3, 'category_id' => 5],
    ['content' => 'Great video and great car, dude', 'users_id' => 5, 'category_id' => 6],
    ['content' => 'What a nice little conversation we have out there', 'users_id' => 4, 'category_id' => 8],
    ['content' => 'It is a truly art, man, absolute cinema', 'users_id' => 1, 'category_id' => 9],
    ['content' => 'Hard times makes tough people', 'users_id' => 7, 'category_id' => 9],
    ['content' => 'Good work, artist-girl', 'users_id' => 7, 'category_id' => 9],
    ['content' => 'We are selling and purchasing things', 'users_id' => 4, 'category_id' => 10],
    ['content' => 'Selling garage', 'users_id' => 8, 'category_id' => 10],
    ['content' => 'Money-money-money', 'users_id' => 1, 'category_id' => 10],
];

foreach ($comments as $comment) {
    $sql = "INSERT INTO comments (content, users_id, category_id) VALUES (:content, :users_id, :category_id)";
    $stmt = $db->getConnection()->prepare($sql);

    $stmt->bindParam(':content', $comment['content']);
    $stmt->bindParam(':users_id', $comment['users_id']);
    $stmt->bindParam(':category_id', $comment['category_id']);

    $stmt->execute();
}
