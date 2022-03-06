<?php
session_start();
if (isset($_SESSION['username'])) { // logged in, redirect to todolist
    header('Location: todolist.php');
    return;
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username && $password) {
    // attempt login

    require "../src/constants.php";
    $connection = pg_connect(constant("CONNECTION_STRING")) or die('Could not connect: ' . pg_last_error());
    $query = 'SELECT password_hash FROM users WHERE username = $1';
    $params = array($username);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    pg_close($connection);

    if (pg_num_rows($result) > 0 && password_verify($password, pg_fetch_result($result, 0, 'password_hash'))) {
        // login

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Login successful, you are now logged in as $username!";
        header("Location: todolist.php");
        return;

    } else {

        $_SESSION['error'] = "Login failed, username or password incorrect";
        header('Location: login.php');
        return;
    }
}

$list = "
    <ul>
        <li><a href='.'>Home</a></li>
    </ul>
    ";

require '../src/flash.php';
$error = flash_error();
if ($error) {
    $error = '<p style="color: red">' . $error . '</p>';
}

$form = $error . "
    <form method='post'>
    <div><label for='username'>Username:</label></div>
    <input type='text' name='username' id='username' required/>
    <div><label for='password'>Password:</label></div>
    <input type='password' name='password' id='password' required/>
    <input type='submit' />
    </form>";

$script = '';

require '../templates/base.php';
