<?php
require_once "Database.php";
require_once "Config.php";
require_once "Input.php";
require_once "Validate.php";

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'comppractice'
    ]
];

if (Input::exists()) {
    $validate = new Validate();

    $validator = $validate->check($_POST, [
        'name' => [
            'required' => true,
            'min' => 10,
            'max' => 15,
            'uniq' => 'users'
        ],
        'password' => [
            'required' => true,
            'min' => 4,
        ],
        'password_again' => [
            'required' => true,
            'matches' => 'password'
        ],
    ]);

    echo '<pre>';
    print_r($validate->getError());
    echo '</pre>';

    if ($validate->passed()) {
        echo 'Всё успешно';
    } else {
        echo 'Не ну это бан';
    }
}


//$users = Database::getInstance()->query("SELECT * FROM users");
//$users = Database::getInstance()->query("SELECT * FROM users WHERE name IN (?)",['John Snow']);
//$users = Database::getInstance()->get('users', ['name', '=', 'Iliza Ver']);
//Database::getInstance()->delete('users', ['password', '=', '123321']);
//$users = Database::getInstance()->insert('users', ['name' => 'Vera Gole','password'=>'32522'])->query("SELECT * FROM users");
//$id = 5;
//$users = Database::getInstance()->update('users', $id, ['name' => 'Glaca Molly','password'=>'6566636'])->query("SELECT * FROM users");
//echo "mysql:host=" . Config::get('mysql.host') . ";dbname=" . Config::get('mysql.database'); die();
//if ($users->error()) {
//    echo 'Ошибка выполненяи операции';
//} else {
//    echo '<pre>';
//    var_dump($users->results());
//    echo '</pre>';
//}
?>
<form action="index.php" method="post">
    <label for="username">Имя</label>
    <input type="text" name="name" id="username" value="<?php echo Input::get('name'); ?>">
    <label for="password">Пароль</label>
    <input type="text" name="password" id="password">
    <label for="password_again">Повторение пароля</label>
    <input type="text" name="password_again" id="password_again">
    <button type="submit">Отправить</button>
</form>
