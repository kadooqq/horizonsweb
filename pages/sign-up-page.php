<?php
require_once('./logics/auth-logic.php');
require_once('./table_modules/users-table.php');

$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $repeatPassword = $_POST['repeatPassword'] ?? '';

    if ($password !== $repeatPassword) {
        $errors['repeatPassword'] = "Пароли не совпадают!";
    } else {
        $errors = AuthLogic::validate_sing_up_data($login, $password);
    }

    if (empty($errors)) {
        UserTable::sign_up(filter_var($login, FILTER_VALIDATE_EMAIL), $password);
        $_SESSION['login_user'] = $login;
        header("Location: /products");
        die();
    }
}
?>

<?php require "./components/header.php"?>
<main class="form-sign-in">
    <form method="post" class="rounded shadow p-4" enctype="multipart/form-data">
        <h1 class="h3 mb-4 fw-normal">Регистрация</h1>
        <div class="mb-3">
            <input type="text" class="form-control form-control-lg" name="login" placeholder="Логин">
            <div class="text-danger"><?= $errors['login'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control form-control-lg" name="password" placeholder="Пароль">
            <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
        </div>
        <div class="mb-4">
            <input type="password" class="form-control form-control-lg" name="repeatPassword" placeholder="Повторите пароль">
            <div class="text-danger"><?= $errors['repeatPassword'] ?? '' ?></div>
        </div>
        <button class="w-100 btn btn-primary" type="submit">Зарегистрироваться</button>
    </form>
</main>