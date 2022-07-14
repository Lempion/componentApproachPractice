<?php
require "init.php";

if (!Session::exist(Config::get('session.user_session'))) {
    Redirect::to('/');
}

$user = new User();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validate = $validate->check($_POST, [
            'name' => [
                'required' => true,
                'min' => 4,
                'max' => 15
            ]
        ]);

        if ($validate->passed()) {
            $user->update(['name' => Input::get('name')]);
            Redirect::to('update.php');
        } else {
            echo '<pre>';
            print_r($validate->getError());
            echo '</pre>';
        }
    }
}

?>

<form action="update.php" method="post">
    <label for="name">Change name</label>
    <input type="text" name="name" id="name" value="<?php echo $user->data()->name; ?>">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <button type="submit">Save</button>
</form>
