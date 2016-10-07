<?php

namespace formCreator\app\Storage\Mysql\PDO;
use PDO;

class PDOConnection
{
    public static $connection;

    public static function getConnection($db_settings)
    {

        if (!isset(self::$connection)) {
            $dsn = 'mysql:host=' . $db_settings['host'] . ';
                dbname=' . $db_settings['database'] . ';
                charset=utf8mb4';
            $user = $db_settings['user'];
            $password = $db_settings['password'];

            try {
                self::$connection = new PDO($dsn, $user, $password,
                    array(PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    )
                );

            } catch (\PDOException $e) {
                throw new \Exception('connection failed');
            }
        }

        return self::$connection;
    }
}

