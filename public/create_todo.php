<?php
session_start();
if (!isset($_SESSION['username'])) { // not logged in, redirect to index
    header("Location: index.php");
    return;
}

$todotitle = isset($_POST['todotitle']) ? $_POST['todotitle'] : '';
$tododescription = isset($_POST['tododescription']) ? $_POST['tododescription'] : '';

if ($todotitle && $tododescription) {
    // attempt to add this todo
    unset($_SESSION['todotitle']);
    unset($_SESSION['tododescription']);

    require "../src/constants.php";
    // get user_id
    $connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
    $query = 'SELECT id FROM users WHERE username = $1';
    $params = array($_SESSION['username']);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    $user_id = pg_fetch_result($result, 0, 'id');

    $query = 'SELECT * FROM todos WHERE title = $1 AND user_id = $2';
    $params = array($todotitle, $user_id);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());

    if (pg_num_rows($result) > 0) {

        pg_close($connection);
        $_SESSION['error'] = "That title already exists, please pick another";
        $_SESSION['todotitle'] = $todotitle;
        $_SESSION['tododescription'] = $tododescription;
        header('Location: create_todo.php');
        return;

    }

    $query = 'INSERT INTO todos (title, description, user_id) VALUES ($1, $2, $3)';
    $params = array($todotitle, $tododescription, $user_id);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    pg_close($connection);

    $_SESSION['success'] = "Todo added successfully!";
    unset($_SESSION['todotitle']);
    unset($_SESSION['tododescription']);
    header("Location: todolist.php");
    return;
}

$list = "
    <ul>
        <li><a href='todolist.php'>Todolist</a></li>
    </ul>
    ";

require '../src/flash.php';

$error = flash_error();
if ($error) {
    $error = "<p style='color: red'>" . $error . "</p>";
}
$todotitle = isset($_SESSION['todotitle']) ? htmlentities($_SESSION['todotitle']) : '';
$tododescription = isset($_SESSION['tododescription']) ? htmlentities($_SESSION['tododescription']) : '';

$form = $error . "
    <form method='post' id='newtodo'>
    <div><label for='todotitle'>Title:</label></div>
    <input type='text' name='todotitle' id='todotitle' value='$todotitle' required/>
    <div><label for='tododescription'>Description:</label></div>
    <textarea name='tododescription' id='tododescription' form='newtodo' required>$tododescription</textarea>
    <input type='submit' value='Create' />
    </form>";

$script = '';

require '../templates/base.php';
