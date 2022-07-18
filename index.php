<?php
require_once "init.php";

$user = new User();

if ($user->isLoggedIn()) {
    echo "Hi <a href='update.php'>{$user->data()->name}</a>  <br>";
    echo '<a href="logout.php">Выйти</a>  <br>';
    echo '<a href="update.php">Обновить профиль</a>  <br>';
    echo '<a href="changepassword.php">Изменить пароль</a>  <br>';

    if ($user->hasPermission('admin')){
        echo 'Admin';
    }

} else {
    echo '<a href="login.php">Login</a> or <a href="register.php">Register</a>';
}
//echo '<pre>';
//var_dump($user->data());
//echo '</pre>';
echo Session::flash('accept');
echo Session::flash('error');



