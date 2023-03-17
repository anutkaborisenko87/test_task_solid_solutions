<?php

namespace TestTaskSolidSolutions\Core\DataBase;

use PDO;

class DataBase extends Connection
{
    protected $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->pdo = $this->getPdo();
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function results($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function errors()
    {
        return $this->pdo->errorInfo();
    }
}