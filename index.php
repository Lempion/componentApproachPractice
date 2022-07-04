<?php
session_start();
require_once "Database.php";
require_once "Config.php";
require_once "Input.php";
require_once "Validate.php";
require_once "Session.php";
require_once "Token.php";
require_once "User.php";

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'comppractice'
    ],
    'session' => [
        'token_name' => 'token',
    ]
];

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validator = $validate->check($_POST, [
            'name' => [
                'required' => true,
                'min' => 4,
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

        if ($validate->passed()) {
            $user = new User();
            $answer = $user->create([
                'name' => Input::get('name'),
                'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
            ]);
            ($answer
                ? Session::flash('success', 'Пользователь успешно создан')
                : Session::flash('error', 'Ошибка добавления пользователя'));

        } else {
            echo '<pre>';
            print_r($validate->getError());
            echo '</pre>';
        }
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
<div>
    <p><?php echo Session::flash('success'); ?></p>
</div>
<form action="index.php" method="post">
    <label for="username">Имя</label>
    <input type="text" name="name" id="username" value="<?php echo Input::get('name'); ?>">
    <label for="password">Пароль</label>
    <input type="text" name="password" id="password">
    <label for="password_again">Повторение пароля</label>
    <input type="text" name="password_again" id="password_again">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <button type="submit">Отправить</button>
</form>
