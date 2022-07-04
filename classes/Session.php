<?php

class Session
{

    public static function put($name, $token)
    {
        return $_SESSION[$name] = $token;
    }

    public static function flash($name, $message = '')
    {
        if (self::exist($name) && ($session = self::get($name)) !== '') {
            self::delete($name);
            return $session;
        } else {
            self::put($name, $message);
        }
    }

    public static function exist($name)
    {
        return (isset($_SESSION[$name]) ? true : false);
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    public static function delete($name)
    {
        if (self::exist($name)) {
            unset($_SESSION[$name]);
        }
    }

}