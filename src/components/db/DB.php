<?php

namespace components\db;

use PDO;
use PDOException;

class DB
{
    private static PDO $db;

    public static function getDB(): PDO
    {
        if (isset(self::$db)) {
            return self::$db;
        }

        self::init();

        return self::$db;
    }

    private function __construct(){}

    private static function init(): void
    {
        try {
            self::$db = new PDO(
                sprintf('mysql:dbname=%s;host=%s', $_ENV['DB_DATABASE'], $_ENV['DB_HOST']),
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"],
            );
        } catch (PDOException $e) {
            // TODO Здесь надо реагировать адекватно
            die('Не удалось подключиться к базе данных: ' . $e->getMessage());
        }
    }
}
