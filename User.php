<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($fields)
    {
        return $this->db->insert('users', $fields);
    }

}