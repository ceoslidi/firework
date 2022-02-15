<?php

namespace Firework;

use Config\Config;

class Database
{
    private $connection = null;
    private $database = [];

    /**
     * @return $this
     */
    public function connect()
    {
        $config = new Config();

        $this->database = $config->getDatabase();

        $this->connection = mysqli_connect(
            $this->database['host'],
            $this->database['user'],
            $this->database['password'],
            $this->database['database']
        );

        return $this;
    }

    /**
     * @param array $fields
     * @param array $where
     * @return array|false
     */
    public function select(array $fields, array $where)
    {
        $queryString = 'SELECT ';
        $keys = [];

        for ($i = 0; $i < count($where); $i++)
        {
            $keys[$i] = key($where);
            next($where);
        }

        for ($i = 0; $i < count($fields); $i++)
        {
            if ($i != count($fields) - 1)
                $queryString .= $fields[$i] . ', ';
            else
                $queryString .= $fields[$i] . ' FROM users WHERE ';
        }

        for ($i = 0; $i < count($where); $i++)
        {
            if ($i != count($where) - 1)
                $queryString .= $keys[$i] . ' = "' . $where[$keys[$i]] . '" AND ';
            else
                $queryString .= $keys[$i] . ' = "' . $where[$keys[$i]] . '"';
        }

        $result =  mysqli_query($this->connection, $queryString);

        if ($result) {
            $array = mysqli_fetch_array($result);

            for ($i = 0; $i < count($fields); $i++)
            {
                unset($array[$i]);
            }

            return $array;
        } else {
            return false;
        }
    }

    /**
     * @param array $query
     * @return bool
     */
    public function insert(array $query)
    {
        $queryString = 'INSERT INTO users (';
        $keys = [];

        for ($i = 0; $i < count($query); $i++)
        {
            $keys[$i] = key($query);
            next($query);
        }

        for ($i = 0; $i < count($query); $i++)
        {
            if ($i != count($query) - 1)
                $queryString .= $keys[$i] . ', ';
            else
                $queryString .= $keys[$i] . ') VALUES (';
        }

        for ($i = 0; $i < count($query); $i++)
        {
            if ($i != count($query) - 1)
                $queryString .= '"' . $query[$keys[$i]] . '", ';
            else
                $queryString .= '"' . $query[$keys[$i]] . '")';
        }

        $result = mysqli_query($this->connection, $queryString);

        if ($result)
            return true;
        else
            return false;
    }
}
