<?php
    $list = "
    <ul>
        <li><a href='.'>Home</a></li>
    </ul>
    ";

    $username = isset($_POST['username']) ? htmlentities($_POST['username'], ENT_QUOTES) : '';
    $password = isset($_POST['password']) ? htmlentities($_POST['password'], ENT_QUOTES) : '';
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
