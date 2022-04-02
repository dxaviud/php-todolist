<?php
require_once "../src/flash.php";
require_once "../src/constants.php";

session_start();
// must be authenticated
if (!isset($_SESSION['username'])) {
    header('Location: .');
    return;
}

// get user_id
$connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
$query = 'SELECT id FROM users WHERE username = $1';
$params = array($_SESSION['username']);
$result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
$user_id = pg_fetch_result($result, 0, 'id');
$_SESSION['user_id'] = $user_id;

// get todo
if (!isset($_GET['todo_id'])) {
    header("HTTP/1.1 404 Not Found");
    return;
}
$todo_id = $_GET['todo_id'];
$query = 'SELECT title, description FROM todos WHERE user_id = $1 AND id = $2';
$params = array($user_id, $todo_id);
$result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
$todo = pg_fetch_row($result);
if (!$todo) {
    echo "404 Not Found";
    header("HTTP/1.1 404 Not Found");
    return;
}

$todotitle = $todo[0];
$tododescription = $todo[1];

$success = flash_success();

$body_template = 'todo.php';
require_once '../templates/base_better.php';
