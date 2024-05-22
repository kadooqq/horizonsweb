<?php

class Database{
    private static Database|null $instance = null;

    private mysqli|null $connection = null;

    private string $db_host = "localhost";
    private string $db_user = "usr";
    private string $db_pass = "usr";
    private string $db_name = "test";

    private function __construct() {
        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass,$this->db_name);

        if (!empty($this->connection) && $this->connection->connect_error)
            die("Connection failed: " . $this->connection->connect_error);
    }

    public static function getInstance() : Database
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function getConnection() : mysqli
    {
        return static::getInstance()->connection;
    }

    // Запрещаем клонирование
    protected function __clone() {
    }
}
