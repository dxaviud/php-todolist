<?php
session_start();
// must be authenticated
if (!isset($_SESSION['username'])) {
    header('Location: .');
    return;
}

if (!isset($_GET['todo_id'])) {
    header("Location: todolist.php");
    return;
}
$todo_id = $_GET['todo_id'];
$user_id = $_SESSION['user_id'];

require_once "../src/constants.php";
$connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
$query = 'DELETE FROM todos WHERE id = $1 AND user_id = $2';
$params = array($todo_id, $user_id);
$result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
$_SESSION['success'] = "Deleted todo successfully!";
header('Location: todolist.php');
