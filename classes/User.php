<?php

class User
{
    private $db, $data, $session_name, $cookie_name, $isLoggedIn;

    public function __construct($user = null)
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');
        $this->cookie_name = Config::get('cookie.cookie_name');

        if (!$user) {
            if (Session::exist($this->session_name)) {
                $user = Session::get($this->session_name);

                if ($this->find($user)) {
                    $this->isLoggedIn = true;
                } else {
                    $this->isLoggedIn = false;
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields)
    {
        return $this->db->insert('users', $fields);
    }

    public function update($fields, $id = null)
    {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        $this->db->update('users', $id, $fields);
    }

    public function login($email = null, $password = null, $remember = false)
    {
        if (!$email && !$password && $this->exists()) {
            Session::put($this->session_name, $this->data()->id);
        } else {

            if ($this->find($email)) {
                if (password_verify($password, $this->data()->password)) {
                    Session::put($this->session_name, $this->data()->id);

                    if ($remember) {
                        $hash = hash('sha256', uniqid());

                        $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->data()->id]);

                        if (!$hashCheck->count()) {
                            $this->db->insert('user_sessions', [
                                'user_id' => $this->data()->id,
                                'hash' => $hash,
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->cookie_name, $hash, Config::get('cookie.cookie_expiry'));

                    }

                    return true;

                }
            }

        }


        return false;
    }

    public function logout()
    {
        $this->db->delete('user_sessions', ['user_id', '=', $this->data()->id]);
        Session::delete($this->session_name);
        Cookie::delete($this->cookie_name);
    }

    public function hasPermission($key)
    {

        $group = $this->db->get('groupsPermissions', ['id', '=', $this->data()->group_id]);

        if ($group->count()) {
            
            $permissions = json_decode($group->first()->permissions, true);

            if ($permissions[$key]) {
                return true;
            }
        }

        return false;
    }

    public function exists()
    {
        return (!empty($this->data()) ? true : false);
    }

    public function find($value)
    {
        if (is_numeric($value)) {
            $this->data = $this->db->get('users', ['id', '=', $value])->first();
        } else {
            $this->data = $this->db->get('users', ['email', '=', $value])->first();
        }

        if ($this->data) {
            return true;
        }
        return false;
    }

    public function data()
    {
        return $this->data;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

}