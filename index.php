<?php
require_once "init.php";

$user = new User();

if ($user->isLoggedIn()) {
    echo "Hi <a href=''>{$user->data()->name}</a>  <br>";
    echo '<a href="logout.php">Выйти</a>';
} else {
    echo '<a href="login.php">Login</a> or <a href="register.php">Register</a>';
}
//echo '<pre>';
//var_dump($user->data());
//echo '</pre>';


