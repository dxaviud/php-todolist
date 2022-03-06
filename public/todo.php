<?php
session_start();
if (!isset($_SESSION['username'])) { // not logged in, redirect to index
    header("Location: index.php");
    return;
}

require "../src/constants.php";
// get user_id
$connection = pg_connect(constant("CONNECTION_STRING")) or die('Could not connect: ' . pg_last_error());
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

$list = "
    <ul>
        <li><a href='todolist.php'>Todolist</a></li>
        <li><a style='color: red' href='delete_todo.php?todo_id=$todo_id'>Delete todo</a></li>
    </ul>
    ";

$todotitle = $todo[0];
$tododescription = $todo[1];

$form = "
    <form id='newtodo'>
    <div><label for='todotitle'>Title:</label></div>
    <input type='text' name='todotitle' id='todotitle' value='$todotitle' disabled/>
    <div><label for='tododescription'>Description:</label></div>
    <textarea name='tododescription' id='tododescription' form='newtodo' rows=6 cols=25 disabled>$tododescription</textarea>
    <br/>
    </form>";
// <button href='edit_todo.php?todo_id=$todo_id' style='margin-top: 5px'>Edit</button>

$script = '';

require '../templates/base.php';
