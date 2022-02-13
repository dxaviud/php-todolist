<?php
    session_start();
    if (isset($_SESSION['username'])) { // logged in, redirect to todolist
        header('Location: todolist.php');
        return;
    }

    require '../src/logger.php';
    log_debug('testing logging');

    $list = '
    <ul>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./signup.php">Sign up</a></li>
    </ul>
    ';

    $form = '';

    $script = '';

    require '../templates/base.php';
?>
