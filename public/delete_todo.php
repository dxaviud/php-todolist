<?php
session_start();
if (!isset($_SESSION['username'])) { // not logged in, redirect to index
    header("Location: index.php");
    return;
}

if (!isset($_GET['todo_id'])) {
    $_SESSION['error'] = "Todo not found";
    header("Location: todolist.php");
    return;
}
$todo_id = $_GET['todo_id'];
$user_id = $_SESSION['user_id'];

require "../src/constants.php";
$connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
$query = 'DELETE FROM todos WHERE id = $1 AND user_id = $2';
$params = array($todo_id, $user_id);
pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());

$_SESSION['success'] = "Deleted todo";
header('Location: todolist.php');
