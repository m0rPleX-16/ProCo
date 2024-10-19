<?php
include_once('../DbConnection.php');

class Crud extends DbConnection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function read($sql)
    {
        $result = $this->connection->query($sql);

        if ($result === false) {
            return false;
        } else {
            return $result;
        }
    }

    public function execute($sql, $params = [])
    {
        $statement = $this->connection->prepare($sql);

        if ($statement === false) {
            return false;
        }

        // Bind parameters if provided
        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings
            $statement->bind_param($types, ...$params);
        }

        $result = $statement->execute();

        $statement->close();

        return $result !== false;
    }


    public function escape_string($value)
    {
        return $this->connection->real_escape_string($value);
    }

    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }
}