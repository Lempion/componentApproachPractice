<?php
require "init.php";

$user = new User();
$user->logout();

Redirect::to("/");
