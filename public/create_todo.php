<?php
require_once '../src/flash.php';
require_once "../src/constants.php";

session_start();
// must be authenticated
if (!isset($_SESSION['username'])) {
    header('Location: .');
    return;
}

$todotitle = isset($_POST['todotitle']) ? $_POST['todotitle'] : '';
$tododescription = isset($_POST['tododescription']) ? $_POST['tododescription'] : '';

if ($todotitle && $tododescription) {
    // attempt to add this todo
    unset($_SESSION['todotitle']);
    unset($_SESSION['tododescription']);

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

$error = flash_error();

$todotitle = isset($_SESSION['todotitle']) ? htmlentities($_SESSION['todotitle']) : '';
$tododescription = isset($_SESSION['tododescription']) ? htmlentities($_SESSION['tododescription']) : '';

$body_template = 'create_todo.php';
require_once '../templates/base_better.php';
