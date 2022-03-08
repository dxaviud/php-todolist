<?php
session_start();
if (!isset($_SESSION['username'])) { // not logged in, redirect to index
    header("Location: index.php");
    return;
}

require "../src/constants.php";
$connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $query = 'SELECT id FROM users WHERE username = $1';
    $params = array($_SESSION['username']);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    $user_id = pg_fetch_result($result, 0, 'id');
    $_SESSION['user_id'] = $user_id;
}
$todo_id = $_GET['todo_id'];
$query = 'SELECT title, description FROM todos WHERE id = $1 AND user_id = $2';
$params = array($todo_id, $user_id);
$result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
$row = pg_fetch_row($result);
$oldTodotitle = htmlentities($row[0]);
$oldTododescription = htmlentities($row[1]);

$todotitle = isset($_POST['todotitle']) ? $_POST['todotitle'] : '';
$tododescription = isset($_POST['tododescription']) ? $_POST['tododescription'] : '';

if ($todotitle && $tododescription) {
    // attempt to update this todo

    $query = 'SELECT * FROM todos WHERE title = $1 AND user_id = $2';
    $params = array($todotitle, $user_id);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());

    if (pg_num_rows($result) > 0 && $todotitle !== $oldTodotitle) {

        pg_close($connection);
        $_SESSION['error'] = "That title already exists, please pick another";
        header('Refresh: 0');
        return;
    }

    $query = 'UPDATE todos set title = $1, description = $2 WHERE id = $3 AND user_id = $4';
    $params = array($todotitle, $tododescription, $todo_id, $user_id);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    pg_close($connection);

    $_SESSION['success'] = "Todo updated successfully!";
    header("Location: todo.php?todo_id=$todo_id");
    return;

} else {
    $todotitle = $oldTodotitle;
    $tododescription = $oldTododescription;
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

$form = $error . "
    <form method='post' id='newtodo'>
    <div><label for='todotitle'>Title:</label></div>
    <input type='text' name='todotitle' id='todotitle' value='$todotitle' required/>
    <div><label for='tododescription'>Description:</label></div>
    <textarea name='tododescription' id='tododescription' form='newtodo' required>$tododescription</textarea>
    <input type='submit' value='Update' />
    </form>";

$script = '';

require '../templates/base.php';
