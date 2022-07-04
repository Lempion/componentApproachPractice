<?php

class User
{
    private $db, $data, $session_name;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');
    }

    public function create($fields)
    {
        return $this->db->insert('users', $fields);
    }

    public function login($email = null, $password = null)
    {
        if ($email) {
            if ($this->find($email)) {
                if (password_verify($password, $this->data()->password)) {
                    Session::put($this->session_name, $this->data()->id);
                    return true;
                }
            }
        }

        return false;
    }

    public function find($email)
    {
        $this->data = $this->db->get('users', ['email', '=', $email])->first();
        if ($this->data) {
            return true;
        }
        return false;
    }

    public function data()
    {
        return $this->data;
    }

}