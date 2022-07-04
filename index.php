<?php
require_once "init.php";

echo Session::get(Config::get('session.user_session'));
