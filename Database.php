<?php

class Database
{

    private static $instance = null;
    private $pdo = null, $query, $error = false, $results, $count;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=comppractice', 'root', '');
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($sql, $params = [])
    {
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);

        if (count($params)) {
            $i = 1;
            foreach ($params as $param) {
                $this->query->bindValue($i, $param);
                $i++;
            }
        }

        if (!$this->query->execute()) {
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);

            $this->count = $this->query->rowCount();
        }

        return $this;
    }

    public function get($table, $where = [])
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where = [])
    {
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $data)
    {
        $stringValues = '';
        foreach ($data as $datum) {
            $stringValues .= '?,';
        }

        $stringValues = rtrim($stringValues, ',');

        $sql = "INSERT INTO {$table} (`" . implode('`,`', array_keys($data)) . "`) VALUES ({$stringValues})";

        if (!$this->query($sql, $data)->error()) {
            return $this;
        }

        return false;
    }

    public function action($action, $table, $where = [])
    {
        if (count($where) === 3) {
            $operators = ['>', '<', '=', '<=', '>='];

            $filed = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$filed} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function error()
    {
        return $this->error;
    }

    public function count()
    {
        return $this->count;
    }

    public function results()
    {
        return $this->results;
    }

}