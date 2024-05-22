<?php

$file_path = $_SERVER['REQUEST_URI'];

if(isset($_SESSION['login_user'])) {
    $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $file_path);

    header('Content-type: image');

    echo $file;
}
else {
    header('Location: /login');
}