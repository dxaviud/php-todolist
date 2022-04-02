<?php
require_once '../src/flash.php';
require_once "../src/constants.php";

session_start();
// must not be authenticated
if (isset($_SESSION['username'])) {
    header('Location: todolist.php');
    return;
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username && $password) {
    // attempt login

    $connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
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

$error = flash_error();

$body_template = 'login.php';
require_once '../templates/base_better.php';
