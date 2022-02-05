<?php
    $list = "
    <ul>
        <li><a href='.'>Home</a></li>
    </ul>
    ";

    require 'util.php';
    $username = POST('username');
    $email = POST('email');
    $password = POST('password');
    if ($username && $email && $password) {
        require "constants.php";
        $connection = pg_connect(constant("CONNECTION_STRING")) or die('Could not connect: ' . pg_last_error());
        $query = 'SELECT * FROM users WHERE username = $1';
        $params = array($username);
        $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
        if (pg_num_rows($result) > 0) {
            echo "That username already exists, please pick another";
        } else {
            $query = 'INSERT INTO users (username, email, password_hash) VALUES ($1, $2, $3);';
            $password_hash = password_hash($password, PASSWORD_BCRYPT) or die('Password hashing failed');
            $params = array($username, $email, $password_hash);
            $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
            header("Location: todolist.php");
        }
        pg_close($connection);
    }

    $username = sanitize_POST('username');
    $email = sanitize_POST('email');
    $password = sanitize_POST('password');
    $form = "
    <form method='post'>
    <div><label for='username'>Username:</label></div>
    <input type='text' name='username' id='username' value='$username' required/>
    <div><label for='email'>Email:</label></div>
    <input type='text' name='email' id='email' value='$email' required/>
    <div><label for='password'>Password:</label></div>
    <input type='password' name='password' id='password' value='$password' required/>
    <input type='submit' />
    </form>";

    require 'templates/base.php';
?>
