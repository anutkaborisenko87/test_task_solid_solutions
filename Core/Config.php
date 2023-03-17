<?php

namespace TestTaskSolidSolutions\Core;

use PDO;

class Config
{
    /**
     * @return array
     */

    public static function databaseConfig(): array
    {
        return [
            'host' => config('db_host', 'localhost'),
            'port' => config('db_port', '3306'),
            'database' => config('db_name', 'test_task_solid_solutions'),
            'username' => config('db_user', 'root'),
            'password' => config('db_pass', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ];
    }

}
