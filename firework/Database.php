<?php

namespace Firework;

use Config\Config;

/*
 * Class controls the database interactions.
 * Includes:
 *  public connect method,
 *  public select method,
 *  public update method,
 *  public insert method,
 *  public delete method.
 */
class Database
{
    private $connection = null;
    private array $database = [];

    /*
     * Sets up the connection with the database.
     */
    /**
     * @return $this
     */
    public function connect(): static
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

    /*
     * Selects data from the database.
     */
    /**
     * @param string $table
     * @param array $fields
     * @param array $where
     * @return array|false
     */
    public function select(string $table, array $fields, array $where): bool|array
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
                $queryString .= $fields[$i] . ' FROM ' . $table . ' WHERE ';
        }

        for ($i = 0; $i < count($where); $i++)
        {
            if ($i != count($where) - 1)
                $queryString .= $keys[$i] . ' = "' . $where[$keys[$i]] . '", ';
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

    /*
     * Updates data in the database.
     */
    /**
     * @param string $table
     * @param array $query
     * @param array $where
     * @return bool
     */
    public function update(string $table, array $query, array $where): bool
    {
        $queryString = 'UPDATE ' . $table . ' SET ';

        $fieldsKeys = [];
        $whereKeys = [];

        for ($i = 0; $i < count($query); $i++)
        {
            $fieldsKeys[$i] = key($query);
            next($query);
        }

        for ($i = 0; $i < count($where); $i++)
        {
            $whereKeys[$i] = key($where);
            next($where);
        }

        for ($i = 0; $i < count($query); $i++)
        {
            if ($i != count($query) - 1)
                $queryString .= $fieldsKeys[$i] . '="' . $query[$fieldsKeys[$i]] . '", ';
            else
                $queryString .= $fieldsKeys[$i] . '="' . $query[$fieldsKeys[$i]] . '" WHERE ';
        }

        for ($i = 0; $i < count($where); $i++)
        {
            if ($i != count($where) - 1)
                $queryString .= $whereKeys[$i] . '="' . $where[$whereKeys[$i]] . '", ';
            else
                $queryString .= $whereKeys[$i] . '="' . $where[$whereKeys[$i]] . '"';
        }

        $result = mysqli_query($this->connection, $queryString);

        if ($result)
            return true;
        else
            return false;
    }

    /*
     * Inserts data into the database.
     */
    /**
     * @param string $table
     * @param array $query
     * @return bool
     */
    public function insert(string $table, array $query): bool
    {
        $queryString = 'INSERT INTO ' . $table . ' (';
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

    /*
     * Deletes data from the database.
     */
    /**
     * @param string $table
     * @param array $where
     * @return bool
     */
    public function delete(string $table, array $where): bool
    {
        $queryString = 'DELETE FROM ' . $table . ' WHERE ';
        $keys = [];

        for ($i = 0; $i < count($where); $i++)
        {
            $keys[$i] = key($where);
            next($where);
        }

        for ($i = 0; $i < count($where); $i++)
        {
            if ($i != count($where) - 1)
                $queryString .= $keys[$i] . '="' . $where[$keys[$i]] . '", ';
            else
                $queryString .= $keys[$i] . '="' . $where[$keys[$i]] . '"';
        }

        $result = mysqli_query($this->connection, $queryString);

        if ($result)
            return true;
        else
            return false;
    }
}
