<?php
require_once "init.php";

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validator = $validate->check($_POST, [
            'name' => [
                'required' => true,
                'min' => 4,
                'max' => 15,
            ],
            'email' => [
                'required' => true,
                'email' => true,
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
                'email' => Input::get('email'),
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

?>
<div>
    <p><?php echo Session::flash('success'); ?></p>
    <p><?php echo Session::flash('error'); ?></p>
</div>
<form action="register.php" method="post">
    <label for="username">Имя</label>
    <input type="text" name="name" id="username" value="<?php echo Input::get('name'); ?>">
    <label for="email">Почта</label>
    <input type="email" name="email" id="email" value="<?php echo Input::get('email'); ?>">
    <label for="password">Пароль</label>
    <input type="text" name="password" id="password">
    <label for="password_again">Повторение пароля</label>
    <input type="text" name="password_again" id="password_again">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <button type="submit">Отправить</button>
</form>
