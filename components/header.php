<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>K5Dev++</title>
    <link rel="stylesheet" href="test/css/style.css">
    <link rel="stylesheet" href="test/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- <link rel="stylesheet" href="test/bootstrap-multiselects-main/css/bootstrap-multiselect.min.css"> -->
</head>
<body class="d-flex flex-column min-vh-100">
<header class="d-flex flex-wrap justify-content-between align-items-center py-2 px-5 bg-dark text-white">
    <ul class="nav">
        <li>
            <a class="navbar-brand text-white" href=<?php isset($_SESSION['login_user']) ? "/products" : "/products" ?>>
                <img src="img/tmkpp_white.png" class="img-fluid" width="100vw">
                K5Dev++
            </a>
        </li>
        <?php if (isset($_SESSION['login_user'])) :?>
        <li class="d-flex align-items-center">
            <a href="/vendors" class="nav-link text-white">Производители</a>
            <a href="/products" class="nav-link text-white">Продукция</a>
            <a href="/additional_requirements" class="nav-link text-white">Задать дополнительные требования</a>
        </li>
        <?php endif; ?>
    </ul>

    <div class="text-end mx-2">
        <?php if (isset($_SESSION['login_user'])) :?>
            <li class="d-flex align-items-center">
                <a href="#" class="nav-link text-white"><?php echo $_SESSION['login_user']?></a>
                <a type="button" href="/logics/logout-logic.php" class="btn btn-outline-light">Выйти</a>
            </li>
        <?php else : ?>
            <a type="button" href="/login" class="btn btn-outline-light me-2">Войти</a>
            <a type="button" href="/sign-up" class="btn btn-outline-light">Зарегистрироваться</a>
        <?php endif; ?>
    </div>
</header>
