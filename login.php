<?php
    $list = "
    <ul>
        <li><a href='./index.php'>Home</a></li>
    </ul>
    ";

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $form = "
    <form method='post'>
    <div><label for='username'>Username:</label></div>
    <input type='text' name='username' id='username' value='$username' />
    <div><label for='password'>Password:</label></div>
    <input type='password' name='password' id='password' value='$password'/>
    <input type='submit' />
    </form>";

    require 'templates/base.php';
?>
