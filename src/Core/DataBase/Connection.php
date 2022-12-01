<?php

namespace App\Core\DataBase;

use App\Core\Config;
use PDO;

final class Connection
{

    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (!self::$connection) {
            self::$connection = self::constructConnection();
        }

        return self::$connection;
    }

    private static function constructConnection(): PDO
    {
        $config = Config::getInstance();

        return new PDO(
            self::constructDSN(),
            $config->DB_USERNAME,
            $config->DB_PASSWORD
        );
    }

    private static function constructDSN(): string
    {
        $config = Config::getInstance();

        return 'mysql:dbname=' . $config->DB_NAME . ';host=' . $config->DB_HOST;
    }
}