<?php
require_once "init.php";

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validator = $validate->check($_POST, [
            'email' => [
                'required' => true,
                'email' => true
            ],
            'password' => [
                'required' => true,
            ]
        ]);

        if ($validate->passed()) {
            $user = new User();
            $answer = $user->login(Input::get('email'),Input::get('password'));
            if($answer){
                Session::flash('success', 'Пользователь успешно авторизован');
                Redirect::to('/');
            }else{
                Session::flash('error', 'Ошибка авторизации пользователя');
            }

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
<form action="login.php" method="post">
    <label for="email">Почта</label>
    <input type="email" name="email" id="email" value="<?php echo Input::get('email'); ?>">
    <label for="password">Пароль</label>
    <input type="text" name="password" id="password">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <button type="submit">Отправить</button>
</form>