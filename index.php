<?php
    session_start();
    if (isset($_SESSION['username'])) { // logged in, redirect to todolist
        header('Location: todolist.php');
        return;
    }

    $list = "
    <ul>
        <li><a href='./login.php'>Login</a></li>
        <li><a href='./signup.php'>Sign up</a></li>
    </ul>
    ";

    $form = "";

    require 'templates/base.php';
?>
