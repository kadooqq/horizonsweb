<?php
require_once('./table_modules/users-table.php');

class AuthLogic {
    static function validate_login_data(string $login, string $password) : array {
        $errors = array();
        $users = UserTable::get_user_by_login($login);

        if (empty($users)) {
            $errors['login'] = "Пользователь с таким именем не найден!";
        } elseif (!password_verify($password, $users[0]['password'])) {
            $errors['password'] = "Пароли не совпадают!";
        }

        return $errors;
    }

    static function validate_sing_up_data(string $login, string $password) : array {
        $errors = array();

        if (trim($login) === '') {
            $errors['login'] = "Укажите логин!";
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL) === false) {
            $errors['login'] = "Логин не является допустимым";
        } elseif (!empty(UserTable::get_user_by_login($login))) {
            $errors['login'] = "Пользователь с таким логином уже существует!";
        }

        if ($password !== '') {
            if (strlen($password) <= '8') {
                $errors['password'] = "Пароль должен быть более 8 символов!";
            }
            elseif(!preg_match("#[0-9]+#", $password)) {
                $errors['password'] = "Пароль должен содержать минимум одно число!";
            }
            elseif(!preg_match("#[A-Z]+#", $password)) {
                $errors['password'] = "Пароль должен содержать минимум один заглавный символ!";
            }
        } else {
            $errors['password'] = "Укажите пароль!";
        }

        return $errors;
    }


}