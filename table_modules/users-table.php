<?php
require_once('./core/psql_db.php');

class UserTable {
    public static string $table_name = "users";

    public static function sign_up(string $login, string $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = Database::prepare("INSERT INTO ".static::$table_name." (login, password) VALUES (:login, :password)");

        $query->bindValue(":login", $login);
        $query->bindValue(":password", $password);

        if(!$query->execute()){
            throw new PDOException("error creating a user");
        }
    }

    public static function get_user_by_login(string $login) : array {
        $query = Database::prepare("SELECT * FROM users WHERE login= :login;");
        $query->bindValue(":login", $login);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}