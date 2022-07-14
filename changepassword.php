<?php
require 'init.php';

$user = new User();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validate = $validate->check($_POST, [
            'current_password' => ['required' => true],
            'new_password' => [
                'required' => true,
                'min' => 6],
            'new_password_again' => [
                'required' => true,
                'min' => 6,
                'matches' => 'new_password'
            ],
        ]);

        if ($validate->passed()) {

            if (password_verify(Input::get('current_password'), $user->data()->password)) {
                $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
                Session::flash('accept', 'Пароль успешно обнавлен');
                Redirect::to('/');
            } else {
                echo 'Пароль не верный';
            }
        } else {
            echo '<pre>';
            print_r($validate->getError());
            echo '</pre>';
        }
    }
}

?>
<form action="changepassword.php" method="post">
    <div>
        <label for="current_password">Current password</label>
        <input type="password" name="current_password" id="current_password">
    </div>
    <br>
    <div>
        <label for="new_password">New password</label>
        <input type="password" name="new_password" id="new_password">
    </div>
    <br>
    <div>
        <label for="new_password_again">New password again</label>
        <input type="password" name="new_password_again" id="new_password_again">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <button type="submit">Save</button>


</form>
