<?php
require_once "Database.php";

//$users = Database::getInstance()->query("SELECT * FROM users");
//$users = Database::getInstance()->query("SELECT * FROM users WHERE name IN (?)",['John Snow']);
//$users = Database::getInstance()->get('users', ['name', '=', 'Iliza Ver']);
//Database::getInstance()->delete('users', ['password', '=', '123321']);

$users = Database::getInstance()->insert('users', ['name' => 'Vera Gole','password'=>'32522'])->query("SELECT * FROM users");

if ($users->error()) {
    echo 'Ошибка выполненяи операции';
} else {
    echo '<pre>';
    var_dump($users->results());
    echo '</pre>';
}

