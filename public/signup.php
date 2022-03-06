<?php
session_start();
if (isset($_SESSION['username'])) { // logged in, redirect to todolist
    header('Location: todolist.php');
    return;
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username && $email && $password) {
    // attempt signup

    require "../src/constants.php";
    $connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
    $query = 'SELECT * FROM users WHERE username = $1';
    $params = array($username);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());

    if (pg_num_rows($result) > 0) {

        pg_close($connection);
        $_SESSION['error'] = "That username already exists, please pick another";
        header('Location: signup.php');
        return;

    } else {
        // signup

        $query = 'INSERT INTO users (username, email, password_hash) VALUES ($1, $2, $3);';
        $password_hash = password_hash($password, PASSWORD_BCRYPT) or die('Password hashing failed');
        $params = array($username, $email, $password_hash);
        $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
        pg_close($connection);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Signup successful, you are now logged in as $username!";
        header("Location: todolist.php");
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
    <div><label for='email'>Email:</label></div>
    <input type='text' name='email' id='email' required/>
    <div><label for='password'>Password:</label></div>
    <input type='password' name='password' id='password' required/>
    <input type='submit' />
    </form>";

$script = '';

require '../templates/base.php';
