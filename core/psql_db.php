<?php

class Database
{
    private $connection = null;

    private function __construct(){
        $json = json_decode(file_get_contents("config.json"), true);
        $this->connection = new PDO('pgsql:host='.$json['hostname'].'; dbname='.$json['dbname'], $json['username'], $json['password'],
                                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);
    }

    private function __clone(){}

    public function __wakeup()
    {
        throw new \http\Exception\BadMethodCallException();
    }


    private static $instance = null;

    public static function instance(): Database{
        if(self::$instance === null){
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public static function connection(): PDO{
        return self::instance()->connection;
    }

    public static function prepare($query):PDOStatement{
        return self::connection()->prepare($query);
    }

    public static function lastInsertId(): int{
        return intval(self::connection()->lastInsertId());
    }
}