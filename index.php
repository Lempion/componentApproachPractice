<?php
require_once "Database.php";
require_once "Config.php";

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'comppractice'
    ]
];

$users = Database::getInstance()->query("SELECT * FROM users");
//$users = Database::getInstance()->query("SELECT * FROM users WHERE name IN (?)",['John Snow']);
//$users = Database::getInstance()->get('users', ['name', '=', 'Iliza Ver']);
//Database::getInstance()->delete('users', ['password', '=', '123321']);
//$users = Database::getInstance()->insert('users', ['name' => 'Vera Gole','password'=>'32522'])->query("SELECT * FROM users");
//$id = 5;
//$users = Database::getInstance()->update('users', $id, ['name' => 'Glaca Molly','password'=>'6566636'])->query("SELECT * FROM users");



//echo "mysql:host=" . Config::get('mysql.host') . ";dbname=" . Config::get('mysql.database'); die();

if ($users->error()) {
    echo 'Ошибка выполненяи операции';
} else {
    echo '<pre>';
    var_dump($users->results());
    echo '</pre>';
}

