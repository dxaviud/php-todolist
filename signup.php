<?php
    $list = "
    <ul>
        <li><a href='.'>Home</a></li>
    </ul>
    ";

    require 'util.php';
    $username = sanitize_POST('username');
    $email = sanitize_POST('email');
    $password = sanitize_POST('password');
    $form = "
    <form method='post'>
    <div><label for='username'>Username:</label></div>
    <input type='text' name='username' id='username' value='$username' />
    <div><label for='email'>Email:</label></div>
    <input type='text' name='email' id='email' value='$email'/>
    <div><label for='password'>Password:</label></div>
    <input type='password' name='password' id='password' value='$password'/>
    <input type='submit' />
    </form>";

    require 'templates/base.php';
?>
