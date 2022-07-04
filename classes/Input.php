<?php

class Input
{
    public static function exists($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST) ? true : false);
            case 'get':
                return (!empty($_GET) ? true : false);
            default:
                return false;
        }
    }

    public static function get($field)
    {
        if (isset($_POST[$field])) {
            return $_POST[$field];
        } elseif (isset($_GET[$field])) {
            return $_GET[$field];
        }
        return '';
    }
}